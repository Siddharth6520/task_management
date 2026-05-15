<?php

namespace App\Documents;

use App\Documents\User;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "modules")]
#[ODM\Index(keys: ['code' => 'asc'], unique: true)]

class Module
{

    #[ODM\Id]
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }



    #[ODM\Field(type: "string")]
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = trim($name);

        return $this;
    }



    #[ODM\Field(type: "string")]
    private string $code;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = strtoupper(trim($code));

        return $this;
    }



    #[ODM\Field(type: "string")]
    private string $description = '';

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = trim($description);

        return $this;
    }



    #[ODM\Field(type: "bool")]
    private bool $is_active = true;

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id'
    )]
    private ?User $created_by = null;

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(User $user): self
    {
        $this->created_by = $user;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id'
    )]
    private ?User $updated_by = null;

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(User $user): self
    {
        $this->updated_by = $user;

        return $this;
    }



    #[ODM\Field(type: "date")]
    private \DateTime $created_at;

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    

    #[ODM\Field(type: "date")]
    private \DateTime $updated_at;

    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(): self
    {
        $this->updated_at = new \DateTime();

        return $this;
    }



    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }
}