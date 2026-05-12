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
        //permissions -  module+actions - 
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'permissions',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'module_id',
                            'action_id',
                            'code'
                        ],

                        'properties' => [

                            'module_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'action_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'code' => [
                                'bsonType' => 'string'
                            ],

                            'name' => [
                                'bsonType' => 'string'
                            ],

                            'description' => [
                                'bsonType' => 'string'
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
            ->selectCollection('permissions')
            ->createIndex(
                [
                    'module_id' => 1,
                    'action_id' => 1
                ],
                ['unique' => true]
            );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')->getMongoDB()->dropCollection('permissions');
    }
};
