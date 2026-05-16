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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')->getMongoDB()->dropCollection('roles');
    }
};
