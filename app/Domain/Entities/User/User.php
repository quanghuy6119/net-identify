<?php
namespace App\Domain\Entities\User;

use App\Domain\Entities\Entity;
use DateTime;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\AccessorOrder;

/**
 * @AccessorOrder("custom", custom = {"id", "name", "email", "password", "createdAt", "updatedAt"})
*/
class User extends Entity
{
    use AvatarProp;
    /**
     * @Serializer\SerializedName("name")
     * @var string
     */
    private string $name;

    /**
     * @Serializer\Exclude()
     * @var string
    */
    private string $password;

    /**
     * @Serializer\SerializedName("email")
     * @var string
    */
    private string $email;

    /**
     * @Serializer\SerializedName("role")
     * @var int
    */
    private int $role;

    /**
     * @Serializer\SerializedName("createdAt")
     * @var DateTime   The created time
    */
    private DateTime $createdAt;

    /**
     * @Serializer\SerializedName("updatedAt")
     * @var DateTime   The updated time
    */
    private DateTime $updatedAt;

    public function __construct(
        ?int $id,
        string $name,
        string $email,
        string $password,
        int $role,
        ?DateTime $createdAt,
        ?DateTime $updatedAt
    ) {        
        $this->setId($id);
        $this->setName($name);
        $this->setRole($role);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setCreatedAt($createdAt);
        $this->setUpdatedAt($updatedAt);
    }

    /**
     * Get the value of name
     *
     * @return  string
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */ 
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */ 
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of password
     *
     * @return  string
    */ 
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
    */ 
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get the value of role
     *
     * @return  int
     */ 
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param  int  $role
     *
     * @return  self
     */ 
    public function setRole(int $role): self
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Get the value of createdAt
     *
     * @return  DateTime|null
    */ 
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param  DateTime|null  $createdAt
     *
     * @return  self
    */ 
    public function setCreatedAt(?Datetime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return  DateTime|null
    */ 
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param  DateTime|null  $updatedAt
     *
     * @return  self
    */ 
    public function setUpdatedAt(?Datetime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
