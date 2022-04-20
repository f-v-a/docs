<?php

namespace App\Http\Livewire\Equipments;

use App\Models\Contractor;
use App\Models\Equipment;
use App\Models\EquipmentModel;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Store extends ModalComponent
{
    use Actions;

    public $model_id, $selectedId, $isShow = false,
    $pasteName, $price, $warranty_period, $commissioning_date,
    $buy_date, $manufacture_date, $cabinet_number, $description, $serial_number, $name, $contractor_id;

    protected $listeners = ['selected'];

    public function selected ($value) {
        $this->name = $value;
        $this->selectedId = $this->model_id;
        $this->pasteName = EquipmentModel::find($this->selectedId);
        $this->isShow = true;
    }

    private function resetInput() {
        $this->model_id = null;
        $this->price = null;
        $this->warranty_period = null;
        $this->commissioning_date = null;
        $this->buy_date = null;
        $this->manufacture_date = null;
        $this->cabinet_number = null;
        $this->description = null;
        $this->name = null;
        $this->serial_number = null;
        $this->description = null;
    }

    public function render()
    {
        $this->models = EquipmentModel::get();
        $this->contractors = Contractor::get();

        return view('livewire.equipments.store');
    }

    public function store() {
        $this->validate([
            'model_id'=>'required',
            'price'=>'required',
            'serial_number'=>'required|unique:equipment',
            'manufacture_date'=>'required',
            'buy_date'=>'required',
            'commissioning_date'=>'required|after:manufacture_date',
            'warranty_period'=>'required',
        ]);

        $newEquipment = Equipment::create([
            'name' => $this->name,
            'cabinet_number' => $this->cabinet_number,
            'model_id' => $this->model_id,
            'contractor_id' => $this->contractor_id,
            'price' => $this->price,
            'serial_number' => $this->serial_number,
            'manufacture_date' => $this->manufacture_date,
            'buy_date' => $this->buy_date,
            'commissioning_date' => $this->commissioning_date,
            'warranty_period' => $this->warranty_period,
            'description' => $this->description,
            'status' => 'В работе',
        ]);

        if($newEquipment) {
            $this->forceClose()->closeModal();
            $this->notification()->success(
                $title = 'Успешно',
                $description = 'Данные успешно сохранены'
            );
            $this->resetInput();
        }
    }

}
