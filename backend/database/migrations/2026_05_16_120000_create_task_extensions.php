<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'task_extensions',
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => [
                            'task',
                            'reason',
                            'status',
                            'requested_by',
                            'requested_at'
                        ],
                        'properties' => [
                            'task' => [
                                'bsonType' => ['objectId']
                            ],
                            'reason' => [
                                'bsonType' => 'string',
                                'minLength' => 10,
                                'maxLength' => 1000
                            ],
                            'status' => [
                                'bsonType' => 'string',
                                'enum' => [
                                    'pending',
                                    'approved',
                                    'rejected'
                                ]
                            ],
                            'new_due_at' => [
                                'bsonType' => ['date', 'null']
                            ],
                            'previous_due_at' => [
                                'bsonType' => ['date', 'null']
                            ],
                            'reviewer_remarks' => [
                                'bsonType' => ['string', 'null'],
                                'maxLength' => 1000
                            ],
                            'reviewed_at' => [
                                'bsonType' => ['date', 'null']
                            ],
                            'requested_by' => [
                                'bsonType' => ['objectId', 'null']
                            ],
                            'reviewed_by' => [
                                'bsonType' => ['objectId', 'null']
                            ],
                            'requested_at' => [
                                'bsonType' => 'date'
                            ]
                        ]
                    ]
                ]
            ]
        );

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('task_extensions')
            ->createIndex([
                'task' => 1
            ]);

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('task_extensions')
            ->createIndex([
                'status' => 1
            ]);

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('task_extensions')
            ->createIndex([
                'requested_at' => -1
            ]);
    }

    public function down(): void
    {
        DB::connection('mongodb')
            ->getMongoDB()
            ->dropCollection('task_extensions');
    }
};
