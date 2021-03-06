<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulatoryTask extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['description', 'status', 'start_date', 'dates', 'periodicity', 'end_date', 'executor_id', 'equipment_id', 'mode'];

    public function performer()
    {

        return $this->belongsTo(Executor::class, 'executor_id');
    }

    public function equipment()
    {

        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
