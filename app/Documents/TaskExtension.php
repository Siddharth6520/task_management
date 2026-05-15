<?php

namespace App\Documents;

use DateTime;
use App\Documents\User;
use App\Documents\Tasks;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "task_extensions")]
#[ODM\HasLifecycleCallbacks]
#[ODM\Index(keys: ['task' => 'asc'])]
#[ODM\Index(keys: ['status' => 'asc'])]
#[ODM\Index(keys: ['requested_at' => 'desc'])]
class TaskExtension
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
    | Request — assignee fills this
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type: "string")]
    private string $reason;                         // required, why they need more time

    public function getReason(): string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = trim($reason);
        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Approval — manager fills this
    | pending → approved | rejected
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type: "string")]
    private string $status = 'pending';             // pending | approved | rejected

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = strtolower(trim($status));
        return $this;
    }



    #[ODM\Field(type: "date", nullable: true)]
    private ?DateTime $new_due_at = null;           // manager sets this on approval

    public function getNewDueAt(): ?DateTime
    {
        return $this->new_due_at;
    }

    public function setNewDueAt(?DateTime $date): self
    {
        $this->new_due_at = $date;
        return $this;
    }



    #[ODM\Field(type: "date")]
    private ?DateTime $previous_due_at = null;      // snapshot of due_at at request time

    public function getPreviousDueAt(): ?DateTime
    {
        return $this->previous_due_at;
    }

    public function setPreviousDueAt(?DateTime $date): self
    {
        $this->previous_due_at = $date;
        return $this;
    }



    #[ODM\Field(type: "string", nullable: true)]
    private ?string $reviewer_remarks = null;       // manager's note on approve/reject

    public function getReviewerRemarks(): ?string
    {
        return $this->reviewer_remarks;
    }

    public function setReviewerRemarks(?string $remarks): self
    {
        $this->reviewer_remarks = $remarks ? trim($remarks) : null;
        return $this;
    }



    #[ODM\Field(type: "date", nullable: true)]
    private ?DateTime $reviewed_at = null;

    public function getReviewedAt(): ?DateTime
    {
        return $this->reviewed_at;
    }

    public function setReviewedAt(?DateTime $date): self
    {
        $this->reviewed_at = $date;
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
    private ?User $requested_by = null;

    public function getRequestedBy(): ?User
    {
        return $this->requested_by;
    }

    public function setRequestedBy(?User $user): self
    {
        $this->requested_by = $user;
        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id',
        nullable: true
    )]
    private ?User $reviewed_by = null;

    public function getReviewedBy(): ?User
    {
        return $this->reviewed_by;
    }

    public function setReviewedBy(?User $user): self
    {
        $this->reviewed_by = $user;
        return $this;
    }



    #[ODM\Field(type: "date")]
    private ?DateTime $requested_at = null;

    public function getRequestedAt(): ?DateTime
    {
        return $this->requested_at;
    }

    public function setRequestedAt(?DateTime $date): self
    {
        $this->requested_at = $date;
        return $this;
    }



    #[ODM\PrePersist]
    public function prePersist(): void
    {
        $this->requested_at ??= new DateTime();
    }
}