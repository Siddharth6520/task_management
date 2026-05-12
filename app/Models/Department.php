<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class Department extends Model
{
    // protected $connection = 'mongodb';
    protected $collection = 'departments';

    protected $fillable = [
        'name', 'description','code'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

}
