<?php

namespace App\Documents;

use DateTime;
use App\Documents\User;
use App\Documents\Action;
use App\Documents\Module;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "permissions")]
#[ODM\HasLifecycleCallbacks]
#[ODM\UniqueIndex(keys: [
    'module.$id' => 'asc',
    'action.$id' => 'asc'
])]
class Permission
{
    #[ODM\Id]
    private string $id;

    #[ODM\ReferenceOne(
        targetDocument: Module::class,
        storeAs: 'id'
    )]
    private ?Module $module = null;

    #[ODM\ReferenceOne(
        targetDocument: Action::class,
        storeAs: 'id'
    )]
    private ?Action $action = null;

    #[ODM\Field(type: "string")]
    private string $code;

    #[ODM\Field(type: "string")]
    private string $name;

    #[ODM\Field(type: "string", nullable: true)]
    private ?string $description = null;

    #[ODM\Field(type: "bool")]
    private bool $is_active = true;

    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id',
        nullable: true
    )]
    private ?User $created_by = null;

    #[ODM\Field(type: "date")]
    private ?DateTime $created_at = null;

    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id',
        nullable: true
    )]
    private ?User $updated_by = null;

    #[ODM\Field(type: "date")]
    private ?DateTime $updated_at = null;

    #[ODM\PrePersist]
    public function prePersist(): void
    {
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
    }

    #[ODM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updated_at = new DateTime();
    }

    // ─── ID ───────────────────────────────────────────────────────────────────

    public function getId(): string
    {
        return $this->id;
    }

    // ─── Module ───────────────────────────────────────────────────────────────

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    // ─── Action ───────────────────────────────────────────────────────────────

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): self
    {
        $this->action = $action;

        return $this;
    }

    // ─── Code ─────────────────────────────────────────────────────────────────

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = strtoupper($code);

        return $this;
    }

    // ─── Name ─────────────────────────────────────────────────────────────────

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    // ─── Description ──────────────────────────────────────────────────────────

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    // ─── Is Active ────────────────────────────────────────────────────────────

    public function getIsActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    // ─── Created By ───────────────────────────────────────────────────────────

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $user): self
    {
        $this->created_by = $user;

        return $this;
    }

    // ─── Created At ───────────────────────────────────────────────────────────

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    // ─── Updated By ───────────────────────────────────────────────────────────

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(?User $user): self
    {
        $this->updated_by = $user;

        return $this;
    }

    // ─── Updated At ───────────────────────────────────────────────────────────

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}