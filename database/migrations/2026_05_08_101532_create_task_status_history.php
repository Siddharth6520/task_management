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
                            'to_status',
                            'changed_at',
                            'created_at'
                        ],

                        'properties' => [

                            'task_id' => [
                                'bsonType' => ['objectId']
                            ],

                            'from_status' => [
                                'bsonType' => ['string', 'null'],
                                'enum' => [
                                    'opened',
                                    'in_progress',
                                    'on_hold',
                                    'completed',
                                    'cancelled',
                                    null
                                ]
                            ],

                            'to_status' => [
                                'bsonType' => 'string',
                                'enum' => [
                                    'opened',
                                    'in_progress',
                                    'on_hold',
                                    'completed',
                                    'cancelled'
                                ]
                            ],

                            'remarks' => [
                                'bsonType' => ['string', 'null']
                            ],

                            'hold_duration_seconds' => [
                                'bsonType' => 'int'
                            ],

                            'updated_at' => [
                                'bsonType' => ['date', 'null']
                            ],

                            'changed_by' => [
                                'bsonType' => ['objectId', 'null']
                            ],

                            'created_by' => [
                                'bsonType' => ['objectId', 'null']
                            ],

                            'created_at' => [
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
