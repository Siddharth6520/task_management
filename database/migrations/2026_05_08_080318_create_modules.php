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

//module - tasks
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'modules',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'name',
                            'code',
                            'is_active'
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
                                'bsonType' => ['objectId', 'null'],
                                'description' => 'Created user id'
                            ],
                            'created_at' => [
                                'bsonType' => 'date'
                            ],
                            'updated_by' => [
                                'bsonType' => ['objectId', 'null'],
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
        DB::connection('mongodb')->getMongoDB()->dropCollection('modules');
    }
};

// modules	Seeder
// actions	Seeder
// permissions	Seeder
// base roles	Seeder
// departments	Seeder