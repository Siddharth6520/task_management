<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'permissions',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'module',
                            'action',
                            'code'
                        ],

                        'properties' => [

                            'module' => [
                                'bsonType' => 'objectId'
                            ],

                            'action' => [
                                'bsonType' => 'objectId'
                            ],

                            'code' => [
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

                            'created_at' => [
                                'bsonType' => ['date', 'null']
                            ],

                            'updated_by' => [
                                'bsonType' => ['objectId', 'null']
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
            ->selectCollection('permissions')
            ->createIndex(
                [
                    'module' => 1,
                    'action' => 1
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
            ->dropCollection('permissions');
    }
};