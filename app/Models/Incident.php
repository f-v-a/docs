<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = ['influence', 'equipment_id', 'executor_id', 'description', 'creator_id', 'date_completion', 'condition'];

    public $timestamps = false;

    public function equipment() {

        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function employee() {

        return $this->belongsTo(Employee::class, 'creator_id');
    }

    public function executor() {

        return $this->belongsTo(Executor::class, 'executor_id');
    }

    // protected static function booted()
    // {
    //     static::addGlobalScope('employees', function (Builder $builder) {
    //         $builder->where('cabinet_number', Employee::where('user_id', (auth()->id()))->firstOrFail()->cabinet_number);
    //     });
    // }
}
