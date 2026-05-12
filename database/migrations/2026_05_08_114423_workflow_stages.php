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
        // workflow stages configuration
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'workflow_stages',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'workflow_template_id',
                            'stage_order',
                            'department_id'
                        ],

                        'properties' => [

                            'workflow_template_id' => [
                                'bsonType' => 'objectId'
                            ],

                            /*
                            |--------------------------------------------------------------------------
                            | Stage Information
                            |--------------------------------------------------------------------------
                            */

                            'stage_name' => [
                                'bsonType' => 'string'
                            ],

                            'stage_order' => [
                                'bsonType' => 'int'
                            ],

                            'department_id' => [
                                'bsonType' => 'objectId'
                            ],

                            /*
                            |--------------------------------------------------------------------------
                            | Permissions & Workflow Rules
                            |--------------------------------------------------------------------------
                            */

                            'role_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'can_skip' => [
                                'bsonType' => 'bool'
                            ],

                            'can_rework' => [
                                'bsonType' => 'bool'
                            ],

                            'is_mandatory' => [
                                'bsonType' => 'bool'
                            ],

                            'is_final_stage' => [
                                'bsonType' => 'bool'
                            ],

                            /*
                            |--------------------------------------------------------------------------
                            | SLA
                            |--------------------------------------------------------------------------
                            */

                            'sla_hours' => [
                                'bsonType' => 'double'
                            ],

                            /*
                            |--------------------------------------------------------------------------
                            | Stage Status
                            |--------------------------------------------------------------------------
                            */

                            'is_active' => [
                                'bsonType' => 'bool'
                            ],

                            /*
                            |--------------------------------------------------------------------------
                            | Audit
                            |--------------------------------------------------------------------------
                            */

                            'created_by' => [
                                'bsonType' => 'objectId'
                            ],

                            'updated_by' => [
                                'bsonType' => 'objectId'
                            ],

                            'created_at' => [
                                'bsonType' => 'date'
                            ],

                            'updated_at' => [
                                'bsonType' => 'date'
                            ]
                        ]
                    ]
                ]
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Indexes
        |--------------------------------------------------------------------------
        */

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('workflow_stages')
            ->createIndex([
                'workflow_template_id' => 1
            ]);

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('workflow_stages')
            ->createIndex([
                'department_id' => 1
            ]);

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate stage order inside same workflow
        |--------------------------------------------------------------------------
        */

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('workflow_stages')
            ->createIndex(
                [
                    'workflow_template_id' => 1,
                    'stage_order' => 1
                ],
                [
                    'unique' => true
                ]
            );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')
            ->getMongoDB()
            ->dropCollection('workflow_stages');
    }
};