<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // attachments

        DB::connection('mongodb')->getMongoDB()->createCollection(
            'attachments',
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => [
                            'task_id',
                            'workflow_stage_id',  
                            'uploaded_by',
                            'uploaded_at',
                            'file_name',
                            'file_path',         
                            'mime_type'
                        ],
                        'properties' => [
                            'task_id'              => ['bsonType' => 'objectId'],
                            'workflow_stage_id'    => ['bsonType' => 'objectId'],
                            'file_name'            => ['bsonType' => 'string'],
                            'file_path'            => ['bsonType' => 'string'],
                            'mime_type'            => ['bsonType' => 'string'],
                            'file_size_bytes'      => ['bsonType' => 'long'],
                            'context'             => [
                                'bsonType' => 'string',
                                'enum' => [
                                    'stage_work',      
                                    'transition',       
                                    'status_change',    
                                    'comment'           
                                ]
                            ],
                            'uploaded_by'          => ['bsonType' => 'objectId'],
                            'uploaded_at'          => ['bsonType' => 'date'],
                        ]
                    ]
                ]
            ]
        );

        DB::connection('mongodb')->getMongoDB()
            ->selectCollection('attachments')
            ->createIndex(['task_id' => 1, 'workflow_stage_id' => 1]);
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')
            ->getMongoDB()
            ->dropCollection('attachments');
    }
};
