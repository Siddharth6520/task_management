<?php

namespace App\Documents;

use DateTime;
use App\Documents\User;
use App\Documents\Action;
use App\Documents\Module;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

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

    // Getters and Setters
}