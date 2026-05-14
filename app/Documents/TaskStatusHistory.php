<?php

namespace App\Documents;

use DateTime;
use App\Documents\User;
use App\Documents\Tasks;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document(collection: "task_status_histories")]
#[ODM\Index(keys: [
    'task' => 'asc'
])]
#[ODM\Index(keys: [
    'changed_at' => 'desc'
])]
class TaskStatusHistory
{
    #[ODM\Id]
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }



    /*
    |--------------------------------------------------------------------------
    | Task Reference
    |--------------------------------------------------------------------------
    */

    #[ODM\ReferenceOne(
        targetDocument: Tasks::class,
        storeAs: 'id'
    )]
    private ?Tasks $task = null;

    public function getTask(): ?Tasks
    {
        return $this->task;
    }

    public function setTask(?Tasks $task): self
    {
        $this->task = $task;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Status Change
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type: "string")]
    private string $from_status;

    public function getFromStatus(): string
    {
        return $this->from_status;
    }

    public function setFromStatus(string $from_status): self
    {
        $this->from_status = strtolower(trim($from_status));

        return $this;
    }



    #[ODM\Field(type: "string")]
    private string $to_status;

    public function getToStatus(): string
    {
        return $this->to_status;
    }

    public function setToStatus(string $to_status): self
    {
        $this->to_status = strtolower(trim($to_status));

        return $this;
    }



    #[ODM\Field(type: "int")]
    private int $hold_duration_seconds = 0;

    public function getHoldDurationSeconds(): int
    {
        return $this->hold_duration_seconds;
    }

    public function setHoldDurationSeconds(int $seconds): self
    {
        $this->hold_duration_seconds = $seconds;

        return $this;
    }



    #[ODM\Field(type: "string", nullable: true)]
    private ?string $remarks = null;

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function setRemarks(?string $remarks): self
    {
        $this->remarks = $remarks
            ? trim($remarks)
            : null;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Audit
    |--------------------------------------------------------------------------
    */

    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id'
    )]
    private ?User $changed_by = null;

    public function getChangedBy(): ?User
    {
        return $this->changed_by;
    }

    public function setChangedBy(?User $user): self
    {
        $this->changed_by = $user;

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



    #[ODM\Field(type: "date")]
    private ?DateTime $changed_at = null;

    public function getChangedAt(): ?DateTime
    {
        return $this->changed_at;
    }

    public function setChangedAt(?DateTime $changed_at): self
    {
        $this->changed_at = $changed_at;

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
}