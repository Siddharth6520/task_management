<?php

namespace App\Documents;

use App\Documents\Task;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "actions")]

class Action
{

    #[ODM\ReferenceOne(targetDocument: User::class, storeAs:'id')]
    private ?User $created_by = null;

    #[ODM\ReferenceOne(targetDocument: User::class, storeAs:'id')]
    private ?User $updated_by = null;

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
    private string $description;
    public function setDescription(string $description): self
    {

        $this->description = trim($description);

        return $this;
    }



    public function setCreatedBy(
        User $user
    ): self {

        $this->created_by = $user;

        return $this;
    }

    public function setUpdatedBy(
        User $user
    ): self {

        $this->updated_by = $user;

        return $this;
    }
}
