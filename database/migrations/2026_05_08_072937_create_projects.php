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
            'projects',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'project_code',
                            'name'
                        ],

                        'properties' => [

                            'project_code' => [
                                'bsonType' => 'string',
                                'description' => 'Unique project code'
                            ],

                            'name' => [
                                'bsonType' => 'string',
                                'description' => 'Project name'
                            ],

                            'description' => [
                                'bsonType' => 'string',
                                'description' => 'Project description'
                            ],

                            'is_active' => [
                                'bsonType' => 'bool',
                                'description' => 'Project active status'
                            ],

                            'created_by' => [
                                'bsonType' => 'objectId',
                                'description' => 'Created user id'
                            ],

                            'updated_by' => [
                                'bsonType' => 'objectId',
                                'description' => 'Updated user id'
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
            ->selectCollection('projects')
            ->createIndex(
                ['project_code' => 1],
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
            ->dropCollection('projects');
    }
};