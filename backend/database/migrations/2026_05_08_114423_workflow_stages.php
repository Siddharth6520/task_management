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
                            'workflow_template',
                            'stage_name',
                            'stage_order',
                            'department',
                            'can_skip',
                            'can_rework',
                            'is_mandatory',
                            'is_final_stage',
                            'is_active',
                            'created_at'
                        ],

                        'properties' => [

                            'workflow_template' => [
                                'bsonType' => 'objectId'
                            ],

                            'stage_name' => [
                                'bsonType' => 'string'
                            ],

                            'stage_order' => [
                                'bsonType' => 'int'
                            ],

                            'department' => [
                                'bsonType' => 'objectId'
                            ],

                            'role' => [
                                'bsonType' => ['objectId', 'null']
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

                            'sla_hours' => [
                                'bsonType' => ['double', 'null']
                            ],

                            'is_active' => [
                                'bsonType' => 'bool'
                            ],

                            'created_by' => [
                                'bsonType' => ['objectId', 'null']
                            ],

                            'updated_by' => [
                                'bsonType' => ['objectId', 'null']
                            ],

                            'created_at' => [
                                'bsonType' => 'date'
                            ],

                            'updated_at' => [
                                'bsonType' => ['date', 'null']
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
                'workflow_template' => 1
            ]);

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('workflow_stages')
            ->createIndex([
                'department' => 1
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
                    'workflow_template' => 1,
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
