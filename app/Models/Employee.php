<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','gender','birthday','phone','email','cabinet_number'];

    public $timestamps = false;

    public function user() {
        
        return $this->belongsTo(User::class, 'user_id');
    }
}
