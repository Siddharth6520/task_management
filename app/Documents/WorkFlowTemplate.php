<?php

namespace App\Documents;

use DateTime;
use App\Documents\User;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;
use DateTimeInterface;
use MongoDB\BSON\ObjectId;

#[ODM\Document(collection: "workflow_templates")]
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
    )]
    private ?User $created_by = null;

    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id',
    )]
    private ?User $updated_by = null;


    public function setCreatedBy(?string $userId): self
    {
        $this->created_by;

        return $this;
    }

    public function setUpdatedBy(?string $userId): self
    {
        $this->updated_by;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->created_by;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updated_by;
    }



    #[ODM\Field(type: "date", nullable: true)]
    private ?\DateTimeInterface $created_at = null;

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTimeInterface $created_at): self
    {
    $this->created_at = $created_at;
    return $this;
    }



    #[ODM\Field(type: "date", nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTimeInterface $updated_at): self
    {
    $this->updated_at = $updated_at;
    return $this;
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
        'created_by' => $this->getCreatedBy(),
        'updated_by' => $this->getUpdatedBy(),
        'created_at' => $this->getCreatedAt()?->format('Y-m-d H:i:s'),
        'updated_at' => $this->getUpdatedAt()?->format('Y-m-d H:i:s'),
    ];
}
}