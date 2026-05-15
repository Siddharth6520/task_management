<?php

namespace App\Documents;

use DateTime;
use App\Documents\Role;
use App\Documents\User;
use App\Documents\Department;
use App\Documents\WorkTemplate;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "workflow_stages")]
#[ODM\Index(keys: [
    'workflow_template' => 'asc'
])]
#[ODM\Index(keys: [
    'department' => 'asc'
])]
#[ODM\UniqueIndex(keys: [
    'workflow_template' => 'asc',
    'stage_order' => 'asc'
])]
class WorkStage
{
    #[ODM\Id]
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }



    /*
    |--------------------------------------------------------------------------
    | Workflow Template
    |--------------------------------------------------------------------------
    */
//template-web id-1 ui-1->backend-2->frontend-3->qa-4->delivery-5
    #[ODM\ReferenceOne(
        targetDocument: WorkTemplate::class,
        storeAs: 'id'
    )]
    private ?WorkTemplate $workflow_template = null;

    public function getWorkflowTemplate(): ?WorkTemplate
    {
        return $this->workflow_template;
    }

    public function setWorkflowTemplate(?WorkTemplate $workflow_template): self
    {
        $this->workflow_template = $workflow_template;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Stage Information
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type: "string")]
    private string $stage_name;

    public function getStageName(): string
    {
        return $this->stage_name;
    }

    public function setStageName(string $stage_name): self
    {
        $this->stage_name = trim($stage_name);

        return $this;
    }

//template :- name:-web flow, code:- WEB, description:- when doing web developmnet
//stage:- ui-1->backend-2->frontend-3->qa-4->delivery-5

    #[ODM\Field(type: "int")]
    private int $stage_order;

    public function getStageOrder(): int
    {
        return $this->stage_order;
    }

    public function setStageOrder(int $stage_order): self
    {
        $this->stage_order = $stage_order;

        return $this;
    }



    #[ODM\ReferenceOne(
        targetDocument: Department::class,
        storeAs: 'id'
    )]
    private ?Department $department = null;

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Workflow Rules
    |--------------------------------------------------------------------------
    */

    #[ODM\ReferenceOne(
        targetDocument: Role::class,
        storeAs: 'id',
        nullable: true
    )]
    private ?Role $role = null;

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }



    #[ODM\Field(type: "bool")]
    private bool $can_skip = false;

    public function canSkip(): bool
    {
        return $this->can_skip;
    }

    public function setCanSkip(bool $can_skip): self
    {
        $this->can_skip = $can_skip;

        return $this;
    }



    #[ODM\Field(type: "bool")]
    private bool $can_rework = false;

    public function canRework(): bool
    {
        return $this->can_rework;
    }

    public function setCanRework(bool $can_rework): self
    {
        $this->can_rework = $can_rework;

        return $this;
    }



    #[ODM\Field(type: "bool")]
    private bool $is_mandatory = true;

    public function isMandatory(): bool
    {
        return $this->is_mandatory;
    }

    public function setIsMandatory(bool $is_mandatory): self
    {
        $this->is_mandatory = $is_mandatory;

        return $this;
    }



    #[ODM\Field(type: "bool")]
    private bool $is_final_stage = false;

    public function isFinalStage(): bool
    {
        return $this->is_final_stage;
    }

    public function setIsFinalStage(bool $is_final_stage): self
    {
        $this->is_final_stage = $is_final_stage;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | SLA
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type: "float", nullable: true)]
    private ?float $sla_hours = null;

    public function getSlaHours(): ?float
    {
        return $this->sla_hours;
    }

    public function setSlaHours(?float $sla_hours): self
    {
        $this->sla_hours = $sla_hours;

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



    /*
    |--------------------------------------------------------------------------
    | Audit
    |--------------------------------------------------------------------------
    */

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



    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id',
        nullable: true
    )]
    private ?User $updated_by = null;

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(?User $user): self
    {
        $this->updated_by = $user;

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