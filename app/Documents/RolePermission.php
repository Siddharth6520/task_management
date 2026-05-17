<?php

namespace App\Documents;

use DateTime;
use App\Documents\User;
use App\Documents\Role;
use App\Documents\Permission;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "role_permissions")]
#[ODM\UniqueIndex(keys: [
    'role' => 'asc',
    'permission' => 'asc'
])]
#[ODM\HasLifecycleCallbacks]

class RolePermission
{
    #[ODM\Id]
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }



    #[ODM\ReferenceOne(
        targetDocument: Role::class,
        storeAs: 'id'
    )]
    private ?Role $role = null;

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: Permission::class,
        storeAs: 'id'
    )]
    private ?Permission $permission = null;

    public function getPermission(): ?Permission
    {
        return $this->permission;
    }

    public function setPermission(?Permission $permission): self
    {
        $this->permission = $permission;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id',
        nullable: true
    )]
    private ?User $created_by = null;

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $user): self
    {
        $this->created_by = $user;

        return $this;
    }



    #[ODM\Field(type: "date", nullable: true)]
    private ?DateTime $created_at = null;

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id',
        nullable: true
    )]
    private ?User $updated_by = null;

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(?User $user): self
    {
        $this->updated_by = $user;

        return $this;
    }



    #[ODM\Field(type: "date", nullable: true)]
    private ?DateTime $updated_at = null;

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    #[ODM\PrePersist]
    public function prePersist(): void
    {
        $this->created_at = new DateTime();
    }

    #[ODM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updated_at = new DateTime();
    }
}
