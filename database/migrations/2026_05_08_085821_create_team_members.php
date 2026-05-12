<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //all together with employee - here only ui will work
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'team_members',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'team_id',
                            'user_id',
                            'department_id',
                            'role_id'
                        ],

                        'properties' => [

                            'team_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'user_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'department_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'role_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'reporting_manager_id' => [
                                'bsonType' => 'objectId' //optional
                            ],

                            'is_active' => [
                                'bsonType' => 'bool'
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
            ->selectCollection('users')
            ->createIndex(
                [
                    'team_id' => 1,
                    'user_id' => 1,
                    'department_id' => 1
                ],
                ['unique' => true]
            );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')->getMongoDB()->dropCollection('team_members');
    }
};
