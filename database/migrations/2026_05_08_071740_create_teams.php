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
            'teams',
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',

                        'required' => [
                            'name',
                            'code'
                        ],

                        'properties' => [

                            'name' => [
                                'bsonType' => 'string',
                                'description' => 'Team name'
                            ],

                            'code' => [
                                'bsonType' => 'string',
                                'description' => 'Unique team code'
                            ],

                            'description' => [
                                'bsonType' => [
                                    'string',
                                    'null'
                                ],
                                'description' => 'Team description'
                            ],

                            'created_by' => [
                                'bsonType' => ['objectId', 'null'],
                                'description' => 'Created user id'
                            ],

                            'created_at' => [
                                'bsonType' => ['date', 'null']
                            ],

                            'updated_by' => [
                                'bsonType' => ['objectId', 'null'],
                                'description' => 'Updated user id'
                            ],

                            'updated_at' => [
                                'bsonType' => ['date', 'null']
                            ],
                        ]
                    ]
                ]
            ]
        );

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('teams')
            ->createIndex(
                ['code' => 1],
                ['unique' => true]
            );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')
            ->getMongoDB()
            ->dropCollection('teams');
    }
};
