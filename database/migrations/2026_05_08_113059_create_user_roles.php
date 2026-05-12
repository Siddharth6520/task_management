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
        // user role assignments with scope
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'user_roles',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'user_id',
                            'role_id',
                            'scope_type'
                        ],

                        'properties' => [

                            'user_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'role_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'scope_type' => [
                                'bsonType' => 'string',
                                'enum' => [
                                    'global',
                                    'team',
                                    'project'
                                ]
                            ],

                            'scope_id' => [
                                'bsonType' => [
                                    'objectId',
                                    'null'
                                ]
                            ],

                            'is_active' => [
                                'bsonType' => 'bool'
                            ],

                            'assigned_by' => [
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
            ->selectCollection('user_roles')
            ->createIndex([
                'user_id' => 1
            ]);

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('user_roles')
            ->createIndex([
                'role_id' => 1
            ]);

     
        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('user_roles')
            ->createIndex(
                [
                    'user_id' => 1,
                    'role_id' => 1,
                    'scope_type' => 1,
                    'scope_id' => 1
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
            ->dropCollection('user_roles');
    }
};