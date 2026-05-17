<?php

namespace App\Documents;

use DateTime;
use App\Documents\User;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "workflow_templates")]
#[ODM\HasLifecycleCallbacks]

#[ODM\Index(keys: [
    'is_active' => 'asc'
])]

#[ODM\UniqueIndex(keys: [
    'code' => 'asc'
])]
class WorkFlowTemplate
{
    #[ODM\Id]
    private ?string $id = null;

    public function getId(): ?string
    {
        return $this->id;
    }


    /*
    |--------------------------------------------------------------------------
    | Basic Information
    |--------------------------------------------------------------------------
    */

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



    #[ODM\Field(type: "string", nullable: true)]
    private ?string $description = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description
            ? trim($description)
            : null;

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

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }



    #[ODM\Field(type: "bool")]
    private bool $is_default = false;

    public function isDefault(): bool
    {
        return $this->is_default;
    }

    public function setIsDefault(bool $is_default): self
    {
        $this->is_default = $is_default;

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

    public function setCreatedBy(?User $user): self
    {
        $this->created_by = $user;

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



    #[ODM\Field(type: "date")]
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



    #[ODM\Field(type: "date")]
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



    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    #[ODM\PrePersist]
    public function prePersist(): void
    {
        $this->created_at ??= new DateTime();
        $this->updated_at ??= new DateTime();
    }

    #[ODM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updated_at = new DateTime();
    }



    public function toArray(): array
    {
        return [

            'id' => $this->getId(),

            'name' => $this->getName(),

            'code' => $this->getCode(),

            'description' => $this->getDescription(),

            'is_active' => $this->isActive(),

            'is_default' => $this->isDefault(),

            'created_by' => $this->getCreatedBy()
                ? [
                    'id' => $this->getCreatedBy()->getId(),
                    'name' => $this->getCreatedBy()->getName()
                ]
                : null,

            'updated_by' => $this->getUpdatedBy()
                ? [
                    'id' => $this->getUpdatedBy()->getId(),
                    'name' => $this->getUpdatedBy()->getName()
                ]
                : null,

            'created_at' => $this
                ->getCreatedAt()
                ?->format('Y-m-d H:i:s'),

            'updated_at' => $this
                ->getUpdatedAt()
                ?->format('Y-m-d H:i:s'),
        ];
    }
}
