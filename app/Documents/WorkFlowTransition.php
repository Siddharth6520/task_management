<?php

namespace App\Documents;

use DateTime;
use App\Documents\User;
use App\Documents\Tasks;
use App\Documents\Department;
use App\Documents\WorkStage;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "workflow_transitions")]
#[ODM\Index(keys: [
    'task' => 'asc'
])]
#[ODM\Index(keys: [
    'transitioned_at' => 'desc'
])]
class WorkFlowTransition
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
    | Department Movement
    |--------------------------------------------------------------------------
    */

    #[ODM\ReferenceOne(
        targetDocument: Department::class,
        storeAs: 'id'
    )]
    private ?Department $from_department = null;

    public function getFromDepartment(): ?Department
    {
        return $this->from_department;
    }

    public function setFromDepartment(?Department $department): self
    {
        $this->from_department = $department;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: Department::class,
        storeAs: 'id'
    )]
    private ?Department $to_department = null;

    public function getToDepartment(): ?Department
    {
        return $this->to_department;
    }

    public function setToDepartment(?Department $department): self
    {
        $this->to_department = $department;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Assignee Movement
    |--------------------------------------------------------------------------
    */

    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id'
    )]
    private ?User $from_assignee = null;

    public function getFromAssignee(): ?User
    {
        return $this->from_assignee;
    }

    public function setFromAssignee(?User $user): self
    {
        $this->from_assignee = $user;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id'
    )]
    private ?User $to_assignee = null;

    public function getToAssignee(): ?User
    {
        return $this->to_assignee;
    }

    public function setToAssignee(?User $user): self
    {
        $this->to_assignee = $user;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Workflow Stage Movement
    |--------------------------------------------------------------------------
    */

    #[ODM\ReferenceOne(
        targetDocument: WorkStage::class,
        storeAs: 'id'
    )]
    private ?WorkStage $from_workflow_stage = null;

    public function getFromWorkflowStage(): ?WorkStage
    {
        return $this->from_workflow_stage;
    }

    public function setFromWorkflowStage(?WorkStage $stage): self
    {
        $this->from_workflow_stage = $stage;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: WorkStage::class,
        storeAs: 'id'
    )]
    private ?WorkStage $to_workflow_stage = null;

    public function getToWorkflowStage(): ?WorkStage
    {
        return $this->to_workflow_stage;
    }

    public function setToWorkflowStage(?WorkStage $stage): self
    {
        $this->to_workflow_stage = $stage;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Transition Details
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type: "string")]
    private string $transition_type = 'forward';

    public function getTransitionType(): string
    {
        return $this->transition_type;
    }

    public function setTransitionType(string $transition_type): self
    {
        $this->transition_type = strtolower(trim($transition_type));

        return $this;
    }



    #[ODM\Field(type: "string", nullable: true)]
    private ?string $reason = null;

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): self
    {
        $this->reason = $reason
            ? trim($reason)
            : null;

        return $this;
    }



    #[ODM\Field(type: "string", nullable: true)]
    private ?string $comments = null;

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments
            ? trim($comments)
            : null;

        return $this;
    }



    #[ODM\Field(type: "int")]
    private int $time_spent_in_department_seconds = 0;

    public function getTimeSpentInDepartmentSeconds(): int
    {
        return $this->time_spent_in_department_seconds;
    }

    public function setTimeSpentInDepartmentSeconds(int $seconds): self
    {
        $this->time_spent_in_department_seconds = $seconds;

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
    private ?User $transitioned_by = null;

    public function getTransitionedBy(): ?User
    {
        return $this->transitioned_by;
    }

    public function setTransitionedBy(?User $user): self
    {
        $this->transitioned_by = $user;

        return $this;
    }



    #[ODM\Field(type: "date")]
    private ?DateTime $transitioned_at = null;

    public function getTransitionedAt(): ?DateTime
    {
        return $this->transitioned_at;
    }

    public function setTransitionedAt(?DateTime $transitioned_at): self
    {
        $this->transitioned_at = $transitioned_at;

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