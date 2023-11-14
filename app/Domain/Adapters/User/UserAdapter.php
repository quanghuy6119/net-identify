<?php
namespace App\Domain\Adapters\User;

use App\Domain\Adapters\EntityAdapterInterface;
use App\Models\User as EloquentUser;
use App\Domain\Entities\User\User;
use App\Utilities\Helpers\DateTimeHelper;

class UserAdapter implements EntityAdapterInterface {
    /**
     * Convert entity to eloquent
     *
     * @param User $entity
     * @return EloquentUser
     */
    public function toNewEloquent($entity)
    {
        $model = new EloquentUser();
        $model->fill($this->getFillable($entity));
        return $model;
    }

    /**
     * Convert entity to eloquent
     *
     * @param User $entity
     * @return EloquentUser
     */
    public function toEloquent($entity)
    {
        $model = EloquentUser::firstOrNew(["id" => $entity->getId()]);
        $model->fill($this->getFillable($entity));
        return $model;
    }

    /**
     * Get fillable attributes convert entity to eloquent
     *
     * @param User $entity
     * @return array
     */
    private function getFillable($entity) 
    {
        return [
            "role" => $entity->getRole(),
            "name" => $entity->getName(),
            "email" => $entity->getEmail(),
            "password" => $entity->getPassword(),
            "created_at" => $entity->getCreatedAt(),
            "updated_at" => $entity->getUpdatedAt()
        ];
    }

    /**
     * Convert eloquent to entity
     *
     * @param EloquentUser $eloquent
     * @return User
     */
    public function toEntity($eloquent)
    {
        if (!$eloquent) return null;

        return new User(
            $eloquent->id,
            $eloquent->name,
            $eloquent->email,
            $eloquent->password,
            $eloquent->role,
            DateTimeHelper::parseFromString($eloquent->created_at),
            DateTimeHelper::parseFromString($eloquent->updated_at)
        );
    }
}