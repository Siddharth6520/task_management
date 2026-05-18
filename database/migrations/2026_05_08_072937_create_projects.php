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
                                'bsonType' => 'string'
                            ],

                            'name' => [
                                'bsonType' => 'string'
                            ],

                            'description' => [
                                'bsonType' => ['string', 'null']
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
                                'bsonType' => ['date', 'null']
                            ],

                            'updated_at' => [
                                'bsonType' => ['date', 'null']
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
                [
                    'project_code' => 1
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
            ->dropCollection('projects');
    }
};