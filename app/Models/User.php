<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use MongoDB\Laravel\Auth\User as Authenticatable;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

// #[Fillable(['name', 'email', 'password'])]
// #[Hidden(['password', 'remember_token'])]

class User extends Authenticatable
{
    // protected $connection = 'mongodb';
    protected $collection = 'users';

    
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $attributes = [
        'is_active' => true
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime'
    ];

    
}
