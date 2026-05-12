<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up():void{
        //actions - create, update, delete, view, approve
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'actions',
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

                            'created_at' => [
                                'bsonType' => 'date'
                            ],

                            'updated_at' => [
                                'bsonType' => 'date'
                            ],
                            'created_by' => [
                                'bsonType' => 'objectId',
                                'description' => 'Created user id'
                            ],

                            'updated_by' => [
                                'bsonType' => 'objectId',
                                'description' => 'Updated user id'
                            ],
                        ]
                    ]
                ]
            ]
        );

    }

    public function down():void{
        DB::connection('mongodb')->getMongoDB()->dropCollection('actions');
    }
};
