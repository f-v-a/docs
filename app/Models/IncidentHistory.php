<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'incident_id', 'condition', 'conclusion'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function incident() {
        return $this->belongsTo(Incident::class, 'incident_id');
    }
}
