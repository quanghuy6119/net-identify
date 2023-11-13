<?php

namespace App\Services\Auth;

use App\Domain\Entities\Token\TokenResult;
use App\Domain\Entities\User\User;
use App\Domain\Exceptions\InvalidInputException;
use App\Validation\Auth\RegisterValidator;
use App\Domain\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\RegisterServiceInterface;
use App\Services\BaseService;
use App\Domain\Repositories\Contracts\TokenRepositoryInterface;
use App\Domain\UnitOfWork\UnitOfWorkInterface;
use App\Domain\Repositories\Contracts\InviteRepositoryInterface;
use App\Domain\Repositories\Contracts\PermissionGroupRepositoryInterface;
use App\Services\StatusCode;

class RegisterService extends BaseService implements RegisterServiceInterface
{
    /**
     * Register validator
     *
     * @var RegisterValidator
     */
    protected RegisterValidator $registerValidator;

    /**
     * Unit of work
     *
     * @var UnitOfWorkInterface
     */
    protected UnitOfWorkInterface $unitOfWork;

    /**
     * Token repository
     *
     * @var TokenRepositoryInterface
     */
    protected TokenRepositoryInterface $tokenRepository;

    /**
     * Invite repository
     *
     * @var InviteRepositoryInterface
     */
    protected InviteRepositoryInterface $inviteRepository;

    /**
     * User repository
     *
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * Permission group repository
     *
     * @var UserRepositoryInterface
     */
    protected PermissionGroupRepositoryInterface $permissionGroupRepository;


    function __construct(
        UserRepositoryInterface $userRepository,
        TokenRepositoryInterface $tokenRepository,
        InviteRepositoryInterface $inviteRepository,
        PermissionGroupRepositoryInterface $permissionGroupRepository,
        UnitOfWorkInterface $unitOfWork
    ) {
        $this->registerValidator = $this->resolve(RegisterValidator::class);
        $this->userRepository = $userRepository;
        $this->unitOfWork = $unitOfWork;
        $this->tokenRepository = $tokenRepository;
        $this->inviteRepository = $inviteRepository;
        $this->permissionGroupRepository = $permissionGroupRepository;
    }

    /**
     * Register a new account
     *
     * @param array $info
     * @return TokenResult
     * @throws Exception
     * @throws AdapterException
     * @throws DatabaseException
     * @throws NotFoundException
     * @throws RepositoryException
     * @throws InvalidInputException
     */
    public function register(array $info)
    {
        // Validate input
        $this->registerValidator->with($info);
        if ($this->registerValidator->fails()) throw new InvalidInputException($this->registerValidator->errors());
        
        $invitationToken = $info["invitationToken"];
        $invite = $this->inviteRepository->getByToken($invitationToken);

        // Check invitation token existed
        if (!$invite) 
            throw new InvalidInputException(["invitationToken" => [__('response.token_invalid')]], StatusCode::INVALID_TOKEN);
        // Check invitation token expired
        if ($invite->isExpired()) 
            throw new InvalidInputException(["invitationToken" => [__('response.token_expired')]], StatusCode::TOKEN_EXPIRED);
        // Check email same with email in token
        if ($invite->getEmail() != $info['email']) 
            throw new InvalidInputException(["email" => [__('response.invalid_email_token')]], StatusCode::INVALID_EMAIL_TOKEN);

        // Begin trans
        $this->unitOfWork->begin();

        // Hash password
        $password = \Hash::make($info['password']);
        // Get role
        $isAdmin = $invite->getIsAdmin();
        // Get signature
        $signature = $info['signature'] ?? null;
        $signature = $signature ?  $signature : $info['name'];
        // Create new entity
        $user =  new User(
            null,
            $info['name'],
            $info['username'],
            $info['email'],
            $password,
            $signature,
            null,
            null,
            $info['phone'] ?? null,
            $isAdmin
        );
        // Insert to db
        $createdUser = $this->userRepository->create($user);

        // Check permission group is existed
        $group = $this->permissionGroupRepository->get($invite->getPermissionGroupId());
        if ($group) {
            // Add to group if group existed
            $this->permissionGroupRepository->addMembers($group, [$createdUser->getId()]);
        }

        // Remove the invitation token
        $this->inviteRepository->deleteByToken($invite->getToken());

        // Create token for the user
        $scopes = $user->getIsAdmin() ? ['admin'] : ['member'];
        $tokenResult = $this->tokenRepository->createToken($createdUser->getId(), 'Role', $scopes);

        // Commit  
        $this->unitOfWork->commit();
        // Return token result
        return $tokenResult;
    }
}
