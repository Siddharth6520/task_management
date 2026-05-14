<?php

namespace App\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

use Tymon\JWTAuth\Contracts\JWTSubject;

#[ODM\Document(collection: "users")]
class User implements JWTSubject
{

    #[ODM\Id]
    private string $id;
    public function getId(): string
    {
        return $this->id;
    }

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }



    #[ODM\Field(type: "string")]
    private string $name;
    public function setName(string $name): self
    {
        $this->name = trim($name);

        return $this;
    }
    public function getName(): string{
        return $this->name;
    }



    #[ODM\Field(type: "string")]
    private string $email;
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = strtolower(trim($email));

        return $this;
    }




    #[ODM\Field(type: "string")]
    private string $mobile_no;
    public function setMobileNo(string $mobile_no): self
    {
        $this->mobile_no = trim($mobile_no);

        return $this;
    }
    public function getMobileNo(): string{
        return $this->email;
    }



    #[ODM\Field(type: "string")]
    private string $username;
    public function setUsername(string $username): self
    {
        $this->username = strtolower(trim($username));

        return $this;
    }
    public function getUsername(): string
    {
        return $this->username;
    }



    #[ODM\Field(type: "string")]
    private string $password;
    public function setPassword(string $password): self
    {
        $this->password = password_hash(
            $password,
            PASSWORD_BCRYPT
        );

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }



    #[ODM\Field(type: "bool")]
    private bool $is_active = true;
    public function isActive():bool{
        return $this->is_active;
    }

    public function setIsActive(bool $status): self
    {
        $this->is_active = $status;

        return $this;
    }



    #[ODM\Field(type: "date")]
    private \DateTime $created_at;
    public function __construct()
    {
        $this->created_at = new \DateTime();
    }
}
