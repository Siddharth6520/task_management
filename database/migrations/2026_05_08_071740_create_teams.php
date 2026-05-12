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
            'teams',[
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => ['name', 'code', 'team_lead_id'],
                        'properties' => [
                            'name'=> [
                                'bsonType' => 'string'
                            ],
                            
                            'description'=> [
                                'bsonType'=> 'string'
                            ],

                            'team_lead_id' =>[
                                'bsonType' => 'integer' 
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
        DB::dropIfExists('teams');
    }
};
