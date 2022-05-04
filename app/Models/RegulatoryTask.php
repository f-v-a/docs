<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RegulatoryTask extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['description', 'status', 'start_date', 'dates', 'periodicity', 'end_date', 'executor_id', 'equipment_id', 'mode'];

    protected $dates = ['start_date', 'end_date'];

    public function performer()
    {

        return $this->belongsTo(Executor::class, 'executor_id');
    }

    public function equipment()
    {

        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function getModifyDescriptionAttribute()
    {
        return Str::substr($this->description, 0, 235);
    }
}
