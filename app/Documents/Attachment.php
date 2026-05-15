<?php

namespace App\Documents;

use DateTime;
use App\Documents\User;
use App\Documents\Tasks;
use App\Documents\WorkStage;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document(collection: "attachments")]
#[ODM\Index(keys: [
    'task' => 'asc',
    'workflow_stage' => 'asc'
])]
class Attachment
{
    #[ODM\Id]
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }



    /*
    |--------------------------------------------------------------------------
    | Relations
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



    #[ODM\ReferenceOne(
        targetDocument: WorkStage::class,
        storeAs: 'id'
    )]
    private ?WorkStage $workflow_stage = null;

    public function getWorkflowStage(): ?WorkStage
    {
        return $this->workflow_stage;
    }

    public function setWorkflowStage(?WorkStage $workflow_stage): self
    {
        $this->workflow_stage = $workflow_stage;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type: "string")]
    private string $file_name;

    public function getFileName(): string
    {
        return $this->file_name;
    }

    public function setFileName(string $file_name): self
    {
        $this->file_name = trim($file_name);

        return $this;
    }



    #[ODM\Field(type: "string")]
    private string $file_path;

    public function getFilePath(): string
    {
        return $this->file_path;
    }

    public function setFilePath(string $file_path): self
    {
        $this->file_path = trim($file_path);

        return $this;
    }



    #[ODM\Field(type: "string")]
    private string $mime_type;

    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    public function setMimeType(string $mime_type): self
    {
        $this->mime_type = trim($mime_type);

        return $this;
    }



    #[ODM\Field(type: "int", nullable: true)]
    private ?int $file_size_bytes = null;

    public function getFileSizeBytes(): ?int
    {
        return $this->file_size_bytes;
    }

    public function setFileSizeBytes(?int $file_size_bytes): self
    {
        $this->file_size_bytes = $file_size_bytes;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Attachment Context
    |--------------------------------------------------------------------------
    */

    #[ODM\Field(type: "string", nullable: true)]
    private ?string $context = null;

    public function getContext(): ?string
    {
        return $this->context;
    }

    public function setContext(?string $context): self
    {
        $this->context = $context
            ? strtolower(trim($context))
            : null;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Upload Information
    |--------------------------------------------------------------------------
    */

    #[ODM\ReferenceOne(
        targetDocument: User::class,
        storeAs: 'id'
    )]
    private ?User $uploaded_by = null;

    public function getUploadedBy(): ?User
    {
        return $this->uploaded_by;
    }

    public function setUploadedBy(?User $uploaded_by): self
    {
        $this->uploaded_by = $uploaded_by;

        return $this;
    }



    #[ODM\Field(type: "date")]
    private ?DateTime $uploaded_at = null;

    public function getUploadedAt(): ?DateTime
    {
        return $this->uploaded_at;
    }

    public function setUploadedAt(?DateTime $uploaded_at): self
    {
        $this->uploaded_at = $uploaded_at;

        return $this;
    }
}