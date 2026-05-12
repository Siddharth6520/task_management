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
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'workflow_transitions',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'task_id',
                            'from_department_id',
                            'to_department_id',
                            'from_workflow_stage_id',
                            'to_workflow_stage_id',
                            'from_assignee_id',
                            'to_assignee_id',
                            'transition_type',
                            'transitioned_by',
                            'transitioned_at'
                        ],

                        'properties' => [

                            'task_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'from_department_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'to_department_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'from_assignee_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'to_assignee_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'transition_type' => [
                                'bsonType' => 'string',
                                'enum' => [
                                    'forward',
                                    'rework' //escalate transition type added if needed for urgent
                                ]
                            ],

                            'from_workflow_stage_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'to_workflow_stage_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'reason' => [
                                'bsonType' => 'string'
                            ],

                            'comments' => [
                                'bsonType' => 'string'
                            ],

                            'time_spent_in_department_seconds' => [
                                'bsonType' => 'long',
                                'minimum' => 0
                            ],

                            'transitioned_by' => [
                                'bsonType' => 'objectId'
                            ],

                            'transitioned_at' => [
                                'bsonType' => 'date'
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
            ->selectCollection('workflow_transitions')
            ->createIndex([
                'task_id' => 1
            ]);

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('workflow_transitions')
            ->createIndex([
                'transitioned_at' => -1
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')
            ->getMongoDB()
            ->dropCollection('workflow_transitions');
    }
};
