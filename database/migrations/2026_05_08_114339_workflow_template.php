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
        // reusable workflow definitions
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'workflow_templates',
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
                                'bsonType' => 'string'
                            ],

                            'code' => [
                                'bsonType' => 'string'
                            ],

                            'description' => [
                                'bsonType' => 'string'
                            ],

                            'is_active' => [
                                'bsonType' => 'bool'
                            ],

                            'is_default' => [
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
            ->selectCollection('workflow_templates')
            ->createIndex(
                [
                    'code' => 1
                ],
                [
                    'unique' => true
                ]
            );

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('workflow_templates')
            ->createIndex([
                'is_active' => 1
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')
            ->getMongoDB()
            ->dropCollection('workflow_templates');
    }
};