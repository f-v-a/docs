<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    public $timestamps = false;
    
    protected $fillable = [
        'login',
        'password',
        'name', 
        'surname', 
        'patronymic', 
        'position_id',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'position_id',
        'role_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    
    public function position() {

        return $this->belongsTo(Position::class, 'position_id');
    }

    public function role() {

        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getIsUserAttribute() {

        return $this->role_id == 1;
    }

    public function getIsAdminAttribute() {

        return $this->role_id == 2;
    }

    public function getIsPerformerAttribute() {

        return $this->role_id == 3;
    }

    public function getIsChiefAttribute() {

        return $this->role_id == 4;
    }
}
