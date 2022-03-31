<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'cabinet_number', 'manufacture_date', 'buy_date', 'commissioning_date', 'warranty_period',
    'status', 'model_id', 'price', 'serial_number', 'contractor_id'];

    public $timestamps = false;

    // public function type() {

    //     return $this->belongsTo(EquipmentType::class, 'model_id');
    // }

    public function model() {

        return $this->belongsTo(EquipmentModel::class, 'model_id');
    }

    // public function manufacturer() {

    //     return $this->belongsTo(Manufacturer::class, 'model_id');
    // }

    public function contractor() {

        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
