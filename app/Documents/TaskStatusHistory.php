<?php

namespace App\Documents;

use DateTime;

use App\Documents\User;
use App\Documents\Task;

use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "task_status_histories")]
#[ODM\HasLifecycleCallbacks]

#[ODM\Index(keys: [
    'task_id' => 'asc'
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
        targetDocument: Task::class,
        storeAs: 'id',
        name: 'task_id'
    )]
    private ?Task $task = null;

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Status Change
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(
        type: "string",
        nullable: true
    )]
    private ?string $from_status = null;

    public function getFromStatus(): ?string
    {
        return $this->from_status;
    }

    public function setFromStatus(
        ?string $from_status
    ): self {
        $this->from_status =
            $from_status
            ? strtolower(trim($from_status))
            : null;

        return $this;
    }



    #[ODM\Field(type: "string")]
    private string $to_status;

    public function getToStatus(): string
    {
        return $this->to_status;
    }

    public function setToStatus(
        string $to_status
    ): self {
        $this->to_status =
            strtolower(trim($to_status));

        return $this;
    }



    #[ODM\Field(type: "int")]
    private int $hold_duration_seconds = 0;

    public function getHoldDurationSeconds(): int
    {
        return $this->hold_duration_seconds;
    }

    public function setHoldDurationSeconds(
        int $seconds
    ): self {
        $this->hold_duration_seconds =
            $seconds;

        return $this;
    }



    #[ODM\Field(
        type: "string",
        nullable: true
    )]
    private ?string $remarks = null;

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function setRemarks(
        ?string $remarks
    ): self {
        $this->remarks =
            $remarks
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
        storeAs: 'id',
        name: 'changed_by',
        nullable: true
    )]
    private ?User $changed_by = null;

    public function getChangedBy(): ?User
    {
        return $this->changed_by;
    }

    public function setChangedBy(
        ?User $user
    ): self {
        $this->changed_by = $user;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id',
        name: 'created_by',
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



    #[ODM\Field(type: "date")]
    private ?DateTime $changed_at = null;

    public function getChangedAt(): ?DateTime
    {
        return $this->changed_at;
    }

    public function setChangedAt(
        ?DateTime $date
    ): self {
        $this->changed_at = $date;

        return $this;
    }



    #[ODM\Field(type: "date")]
    private ?DateTime $created_at = null;

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
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



    #[ODM\PrePersist]
    public function prePersist(): void
    {
        $now = new DateTime();

        $this->changed_at ??= $now;
        $this->created_at ??= $now;
        $this->updated_at ??= $now;
    }


    #[ODM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updated_at =
            new DateTime();
    }
}
