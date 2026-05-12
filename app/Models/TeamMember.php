<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class TeamMember extends Model
{
    // protected $connection = 'mongodb';
    protected $collection = 'team_members';

    protected $fillable = [
        'team_id', 'user_id', 'department_id', 'role_id'
    ];

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

}
