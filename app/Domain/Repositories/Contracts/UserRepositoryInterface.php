<?php
namespace App\Domain\Repositories\Contracts;

interface UserRepositoryInterface extends RepositoryContainerInterface {
    /**
     * Get by email
     *
     * @param string $email
     * @return User|null
     */
    public function getByEmail(string $email): ?User;
}
