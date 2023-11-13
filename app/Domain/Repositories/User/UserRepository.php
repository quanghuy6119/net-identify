<?php

namespace App\Domain\Repositories\User;

use App\Domain\Adapters\User\UserAdapter;
use App\Domain\Entities\User\User;
use App\Domain\Repositories\Contracts\UserRepositoryInterface;
use App\Domain\Repositories\DataManager;
use App\Domain\Repositories\DataRetriever;
use App\Domain\Repositories\Repository;
use App\Models\User as UserModel;

class UserRepository extends Repository implements UserRepositoryInterface
{
    private DataManager $manager;

    private DataRetriever $retriever;

    public function __construct(UserModel $model)
    {
        $adapter = new UserAdapter();
        $this->manager = new DataManager($model, $adapter);
        $this->retriever = new DataRetriever($model, $adapter);
    }

    /**
     * Get by email
     *
     * @param string $email
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        $query = $this->retriever->makeQuery();
        $result = $query->where('email', $email)->first();
        return $this->entityAdapter->toEntity($result);
    }
}
