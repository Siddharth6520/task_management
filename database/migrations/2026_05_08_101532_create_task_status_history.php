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
            'task_status_histories',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'task_id',
                            'from_status',
                            'to_status',
                            'changed_by',
                            'changed_at'
                        ],

                        'properties' => [

                            'task_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'from_status' => [
                                'enum' => [
                                    'opened',
                                    'in_progress',
                                    'on_hold',
                                    'completed',
                                    'cancelled'
                                ]
                            ],

                            'to_status' => [
                                'enum' => [
                                    'todo',
                                    'in_progress',
                                    'on_hold',
                                    'completed',
                                    'cancelled'
                                ]
                            ],

                            'hold_duration_seconds' => [
                                'bsonType' => 'long',
                                'minimum' => 0
                            ],

                            'remarks' => [
                                'bsonType' => 'string'
                            ],

                            'changed_by' => [
                                'bsonType' => 'objectId'
                            ],

                            'changed_at' => [
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



        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('task_status_histories')
            ->createIndex([
                'task_id' => 1
            ]);

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('task_status_histories')
            ->createIndex([
                'changed_at' => -1
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')
            ->getMongoDB()
            ->dropCollection('task_status_histories');
    }
};