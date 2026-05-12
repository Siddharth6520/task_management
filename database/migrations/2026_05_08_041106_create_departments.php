<?php

use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::connection('mongodb')->getMongoDB()->createCollection(
            'departments',[
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => ['name', 'code'],
                        'properties' => [
                            'name'=> [
                                'bsonType' => 'string'
                            ],
                            
                            'description'=> [
                                'bsonType'=> 'string'
                            ],

                            'code' => [
                                'bsonType' => 'string'
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
        DB::dropIfExists('departments');
    }
};
