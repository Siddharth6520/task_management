<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'tasks',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'task_code',
                            'title',
                            'workflow_template_id',
                            'current_workflow_stage_id',
                            'current_department_id',
                            'current_assignee_id',
                            'execution_status',
                            'created_by',
                            'created_at'
                        ],

                        'properties' => [

                            'task_code' => [
                                'bsonType' => 'string' //task_01_2026-11-04
                            ],

                            'title' => [
                                'bsonType' => 'string',
                                'maxLength' => 200
                            ],

                            'description' => [
                                'bsonType' => 'string'
                            ],

                            'project_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'current_department_id' => [  //1
                                'bsonType' => 'objectId'
                            ],

                            'current_assignee_id' => [ //Siddharth
                                'bsonType' => 'objectId'
                            ],

                            'workflow_template_id' => [ //common workflow
                                'bsonType' => 'objectId'
                            ],

                            'current_workflow_stage_id' => [ //1 - Backend
                                'bsonType' => 'objectId'
                            ],



                            'execution_status' => [
                                'bsonType' => 'string',
                                'enum' => [
                                    'opened',
                                    'in_progress',
                                    'on_hold',
                                    'completed',
                                    'cancelled',
                                    'closed'
                                ]
                            ],

                            'priority' => [
                                'bsonType' => 'string',
                                'enum' => [
                                    'low',
                                    'medium',
                                    'high',
                                    'critical'
                                ]
                            ],

                            'started_at' => [   //May 1
                                'bsonType' => 'date'
                            ],

                            'due_at' => [     //Deadline given by admin like May 30
                                'bsonType' => 'date'
                            ],

                            'completed_at' => [  //actual completed date after extension approval - june 10
                                'bsonType' => 'date'
                            ],

                            // 'workflow_completed_at' => [
                            //     'bsonType' => 'date'
                            // ],


                            //holding 
                            'current_hold_started_at' => [
                                'bsonType' => 'date'  //holded at
                            ],

                            'total_hold_duration_seconds' => [
                                'bsonType' => 'long' //when changing from onhold to inprogress again means (now - onhold) time to update
                            ],

                            // 'completion_percentage' => [
                            //     'bsonType' => 'int',
                            //     'minimum' => 0,
                            //     'maximum' => 100
                            // ],//optional if need we will put

                            'original_due_at' => [
                                'bsonType' => 'date'
                            ],

                            'is_sla_breached' => [
                                'bsonType' => 'bool'
                            ],

                            'sla_breach_count' => [
                                'bsonType' => 'int'
                            ],

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

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('tasks')
            ->createIndex([
                'current_department_id' => 1
            ]);

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('tasks')
            ->createIndex([
                'current_assignee_id' => 1
            ]);

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('tasks')
            ->createIndex([
                'execution_status' => 1
            ]);

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('tasks')
            ->createIndex(
                [
                    'task_code' => 1
                ],
                [
                    'unique' => true
                ]
            );
    }


    public function down(): void
    {
        DB::connection('mongodb')
            ->getMongoDB()
            ->dropCollection('tasks');
    }
};



