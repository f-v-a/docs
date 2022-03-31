<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name', 'type_id', 'manufacturer'
    ];

    public function type() {

        return $this->belongsTo(EquipmentType::class, 'type_id');
    }
}
