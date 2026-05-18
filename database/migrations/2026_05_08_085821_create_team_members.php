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
                            'team',
                            'user',
                            'department',
                            // 'role'
                        ],

                        'properties' => [

                            'team' => [
                                'bsonType' => 'objectId'
                            ],

                            'user' => [
                                'bsonType' => 'objectId'
                            ],

                            'department' => [
                                'bsonType' => 'objectId'
                            ],

                            // 'role' => [
                            //     'bsonType' => 'objectId'
                            // ],

                            'reporting_manager' => [
                                'bsonType' => ['objectId', 'null']
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
            ->selectCollection('team_members')
            ->createIndex(
                [
                    'team' => 1,
                    'user' => 1,
                    'department' => 1
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
