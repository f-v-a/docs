<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Executor extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id' ,'contractor_id', 'email', 'phone'];

    public $timestamps = false;

    public function user() {

        return $this->belongsTo(User::class, 'user_id');
    }

    public function contractor() {

        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
