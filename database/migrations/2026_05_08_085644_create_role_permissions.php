<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'role_permissions',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'role',
                            'permission'
                        ],

                        'properties' => [

                            'role' => [
                                'bsonType' => 'objectId'
                            ],

                            'permission' => [
                                'bsonType' => 'objectId'
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
            ->selectCollection('role_permissions')
            ->createIndex(
                [
                    'role' => 1,
                    'permission' => 1
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
            ->dropCollection('role_permissions');
    }
};