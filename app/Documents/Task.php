<?php

namespace App\Documents;

use DateTime;

use App\Documents\User;
use App\Documents\Project;
use App\Documents\Department;
use App\Documents\WorkFlowStages;
use App\Documents\Attachment;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection:"tasks")]
#[ODM\HasLifecycleCallbacks]

#[ODM\Index(keys:[
    'current_department_id'=>'asc'
])]

#[ODM\Index(keys:[
    'current_assignee_id'=>'asc'
])]

#[ODM\Index(keys:[
    'execution_status'=>'asc'
])]

#[ODM\UniqueIndex(keys:[
    'task_code'=>'asc'
])]

class Task
{
    #[ODM\Id]
    private string $id;

    public function __construct()
    {
        $this->attachments = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    /*
    |--------------------------------------------------------------------------
    | Basic Information
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type:"string")]
    private string $task_code;

    public function getTaskCode(): string
    {
        return $this->task_code;
    }

    public function setTaskCode(string $task_code): self
    {
        $this->task_code = strtoupper(trim($task_code));

        return $this;
    }


    #[ODM\Field(type:"string")]
    private string $title;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = trim($title);

        return $this;
    }


    #[ODM\Field(
        type:"string",
        nullable:true
    )]
    private ?string $description=null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description=
            $description
            ? trim($description)
            : null;

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    #[ODM\ReferenceMany(
        targetDocument: Attachment::class,
        mappedBy:"task"
    )]
    private Collection $attachments;

    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    #[ODM\ReferenceOne(
        targetDocument: Project::class,
        storeAs:"id",
        name:"project_id",
        nullable:true
    )]
    private ?Project $project=null;

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project=$project;

        return $this;
    }

    #[ODM\ReferenceOne(
        targetDocument: Department::class,
        storeAs:"id",
        name:"current_department_id"
    )]
    private ?Department $current_department=null;

    public function getCurrentDepartment(): ?Department
    {
        return $this->current_department;
    }

    public function setCurrentDepartment(
        ?Department $department
    ):self{
        $this->current_department=$department;

        return $this;
    }


    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs:"id",
        name:"current_assignee_id"
    )]
    private ?User $current_assignee=null;

    public function getCurrentAssignee(): ?User
    {
        return $this->current_assignee;
    }

    public function setCurrentAssignee(?User $user):self
    {
        $this->current_assignee=$user;

        return $this;
    }


    #[ODM\ReferenceOne(
        targetDocument: WorkFlowTemplate::class,
        storeAs:"id",
        name:"workflow_template_id"
    )]
    private ?WorkFlowTemplate $workflow_template=null;

    public function getWorkflowTemplate(): ?WorkFlowTemplate
    {
        return $this->workflow_template;
    }

    public function setWorkflowTemplate(
        ?WorkFlowTemplate $workflow_template
    ):self{
        $this->workflow_template=$workflow_template;

        return $this;
    }


    #[ODM\ReferenceOne(
        targetDocument: WorkFlowStages::class,
        storeAs:"id",
        name:"current_workflow_stage_id"
    )]
    private ?WorkFlowStages $current_workflow_stage=null;

    public function getCurrentWorkflowStage(): ?WorkFlowStages
    {
        return $this->current_workflow_stage;
    }

    public function setCurrentWorkflowStage(
        ?WorkFlowStages $stage
    ):self{
        $this->current_workflow_stage=$stage;

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type:"string")]
    private string $execution_status="opened";

    public function getExecutionStatus(): string
    {
        return $this->execution_status;
    }

    public function setExecutionStatus(string $status): self
    {
        $this->execution_status =
            strtolower(trim($status));

        return $this;
    }


    #[ODM\Field(type:"string")]
    private string $priority="medium";

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority =
            strtolower(trim($priority));

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | Dates
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type:"date",nullable:true)]
    private ?DateTime $started_at=null;

    public function getStartedAt(): ?DateTime
    {
        return $this->started_at;
    }

    public function setStartedAt(?DateTime $date): self
    {
        $this->started_at=$date;

        return $this;
    }


    #[ODM\Field(type:"date",nullable:true)]
    private ?DateTime $due_at=null;

    public function getDueAt(): ?DateTime
    {
        return $this->due_at;
    }

    public function setDueAt(?DateTime $date): self
    {
        $this->due_at=$date;

        return $this;
    }


    #[ODM\Field(type:"date",nullable:true)]
    private ?DateTime $completed_at=null;

    public function getCompletedAt(): ?DateTime
    {
        return $this->completed_at;
    }

    public function setCompletedAt(?DateTime $date): self
    {
        $this->completed_at=$date;

        return $this;
    }


    #[ODM\Field(type:"date",nullable:true)]
    private ?DateTime $original_due_at=null;

    public function getOriginalDueAt(): ?DateTime
    {
        return $this->original_due_at;
    }

    public function setOriginalDueAt(?DateTime $date): self
    {
        $this->original_due_at=$date;

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | Hold
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type:"date",nullable:true)]
    private ?DateTime $current_hold_started_at=null;

    public function getCurrentHoldStartedAt(): ?DateTime
    {
        return $this->current_hold_started_at;
    }

    public function setCurrentHoldStartedAt(
        ?DateTime $date
    ): self{
        $this->current_hold_started_at=$date;

        return $this;
    }


    #[ODM\Field(type:"int")]
    private int $total_hold_duration_seconds=0;

    public function getTotalHoldDurationSeconds(): int
    {
        return $this->total_hold_duration_seconds;
    }

    public function setTotalHoldDurationSeconds(
        int $seconds
    ):self{
        $this->total_hold_duration_seconds=
            $seconds;

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | SLA
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type:"bool")]
    private bool $is_sla_breached=false;

    public function isSlaBreached(): bool
    {
        return $this->is_sla_breached;
    }

    public function setIsSlaBreached(
        bool $status
    ): self{
        $this->is_sla_breached=$status;

        return $this;
    }


    #[ODM\Field(type:"int")]
    private int $sla_breach_count=0;

    public function getSlaBreachCount(): int
    {
        return $this->sla_breach_count;
    }

    public function setSlaBreachCount(
        int $count
    ):self{
        $this->sla_breach_count=$count;

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | Audit
    |--------------------------------------------------------------------------
    */

    #[ODM\ReferenceOne(
        targetDocument:User::class,
        storeAs:"id"
    )]
    private ?User $created_by=null;

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(
        ?User $user
    ):self{
        $this->created_by=$user;

        return $this;
    }


    #[ODM\ReferenceOne(
        targetDocument:User::class,
        storeAs:"id",
        nullable:true
    )]
    private ?User $updated_by=null;

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(
        ?User $user
    ):self{
        $this->updated_by=$user;

        return $this;
    }


    #[ODM\Field(type:"date")]
    private ?DateTime $created_at=null;

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }


    #[ODM\Field(
        type:"date",
        nullable:true
    )]
    private ?DateTime $updated_at=null;

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }


    #[ODM\PrePersist]
    public function prePersist(): void
    {
        $now=new DateTime();

        $this->created_at ??= $now;
        $this->updated_at ??= $now;
    }

    #[ODM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updated_at=new DateTime();
    }
}