<?php

namespace App\Documents;

use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "departments")]
#[ODM\Index(keys: ['code' => 'asc'], unique: true)]
class Department
{
    #[ODM\Id]
    private string $id;



    #[ODM\Field(type: "string")]
    private string $name;



    #[ODM\Field(type: "string")]
    private string $code;



    #[ODM\Field(type: "string", nullable: true)]
    private ?string $description = null;



    /*
    |--------------------------------------------------------------------------
    | ID
    |--------------------------------------------------------------------------
    */

    public function getId(): string
    {
        return $this->id;
    }



    /*
    |--------------------------------------------------------------------------
    | Name
    |--------------------------------------------------------------------------
    */

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = trim($name);

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Code
    |--------------------------------------------------------------------------
    */

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = strtoupper(trim($code));

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Description
    |--------------------------------------------------------------------------
    */

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
    | Array Response
    |--------------------------------------------------------------------------
    */

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'code' => $this->getCode(),
            'description' => $this->getDescription(),
        ];
    }
}