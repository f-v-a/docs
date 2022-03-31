<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function models() {

        return $this->hasManyThrough(Equipment::class, EquipmentModel::class, 'type_id', 'model_id');
    }
}
