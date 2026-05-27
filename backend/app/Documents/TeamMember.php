<?php

namespace App\Documents;

use DateTime;
// use App\Documents\Role;
use App\Documents\Team;
use App\Documents\User;
use App\Documents\Department;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "team_members")]

#[ODM\UniqueIndex(
    keys: [
        'team' => 'asc',
        'user' => 'asc',
        'department' => 'asc'
    ]
)]

#[ODM\HasLifecycleCallbacks]

class TeamMember
{
    #[ODM\Id]
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

    /*
    |--------------------------------------------------------------------------
    | Team Information
    |--------------------------------------------------------------------------
    */

    #[ODM\ReferenceOne(
        targetDocument: Team::class,
        storeAs: 'id'
    )]
    private ?Team $team = null;

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id'
    )]
    private ?User $user = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: Department::class,
        storeAs: 'id'
    )]
    private ?Department $department = null;

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(
        ?Department $department
    ): self {
        $this->department = $department;

        return $this;
    }



    // #[ODM\ReferenceOne(
    //     targetDocument: Role::class,
    //     storeAs: 'id'
    // )]
    // private ?Role $role = null;

    // public function getRole(): ?Role
    // {
    //     return $this->role;
    // }

    // public function setRole(?Role $role): self
    // {
    //     $this->role = $role;

    //     return $this;
    // }



    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id',
        nullable: true
    )]
    private ?User $reporting_manager = null;

    public function getReportingManager(): ?User
    {
        return $this->reporting_manager;
    }

    public function setReportingManager(
        ?User $reporting_manager
    ): self {
        $this->reporting_manager = $reporting_manager;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type: "bool")]
    private bool $is_active = true;

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(
        bool $is_active
    ): self {
        $this->is_active = $is_active;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Audit
    |--------------------------------------------------------------------------
    */

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

    public function setCreatedBy(
        ?User $user
    ): self {
        $this->created_by = $user;

        return $this;
    }



    #[ODM\Field(
        type: "date",
        nullable: true
    )]
    private ?DateTime $created_at = null;

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(
        ?DateTime $created_at
    ): self {
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

    public function setUpdatedBy(
        ?User $user
    ): self {
        $this->updated_by = $user;

        return $this;
    }



    #[ODM\Field(
        type: "date",
        nullable: true
    )]
    private ?DateTime $updated_at = null;

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(
        ?DateTime $updated_at
    ): self {
        $this->updated_at = $updated_at;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Lifecycle callbacks
    |--------------------------------------------------------------------------
    */

    #[ODM\PrePersist]
    public function prePersist(): void
    {
        $this->created_at ??= new DateTime();
    }

    #[ODM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updated_at = new DateTime();
    }
}
