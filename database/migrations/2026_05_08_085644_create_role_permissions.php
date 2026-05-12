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
       //role and permission one to many
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'role_permissions',
            [
                'validator' => [
                    '$jsonSchema' => [

                        'bsonType' => 'object',

                        'required' => [
                            'role_id',
                            'permission_id'
                        ],

                        'properties' => [

                            'role_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'permission_id' => [
                                'bsonType' => 'objectId'
                            ],

                            'created_at' => [
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
                ['role_id' => 1, 'permission_id' => 1],
                ['unique' => true]
            );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')->getMongoDB()->dropCollection('role_permissions');
    }
};
