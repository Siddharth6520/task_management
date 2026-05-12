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
        //roles
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'roles',
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
                            'created_by' => [
                                'bsonType' => 'objectId',
                                'description' => 'Created user id'
                            ],

                            'created_at' => [
                                'bsonType' => 'date'
                            ],
                            'updated_by' => [
                                'bsonType' => 'objectId',
                                'description' => 'Updated user id'
                            ],

                            'updated_at' => [
                                'bsonType' => 'date'
                            ]
                        ]
                    ]
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')->getMongoDB()->dropCollection('roles');
    }
};
