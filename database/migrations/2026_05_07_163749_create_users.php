<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'users',
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => ['name', 'email', 'mobile_no', 'password',
                        //  'global_role', 
                         'department_id', 'team_id'],
                        'properties' => [
                            'name' => [
                                'bsonType' => 'string'
                            ],

                            'email' => [
                                'bsonType' => 'string'
                            ],

                            'mobile_no' => [
                                'bsonType' => 'string'
                            ],

                            'username' => [
                                'bsonType' => 'string'
                            ],

                            'password' => [
                                'bsonType' => 'string'
                            ],

                            // 'global_role' => [
                            //     'bsonType' => 'string',
                            //     'enum' => [
                            //         'ADMIN',
                            //         'CLIENT'
                            //     ]
                            // ],

                            'is_active' => [
                                'bsonType' => 'boolean'
                            ],

                            'created_at' => [
                                'bsonType' => 'date'
                            ],

                            'updated_at' => [
                                'bsonType' => 'date'
                            ]
                        ]
                    ],
                ]
            ]
        );

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('users')
            ->createIndex(
                ['email' => 1],
                ['unique' => true]
            );

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('users')
            ->createIndex(
                ['mobile_no' => 1],
                ['unique' => true]
            );

    }

    public function down(): void
    {
        DB::connection('mongodb')->getMongodb()->dropCollection('users');
    }
};
