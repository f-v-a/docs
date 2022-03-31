<?php

namespace App\Http\Livewire\Equipments;

use App\Models\Contractor;
use App\Models\Equipment;
use App\Models\EquipmentModel;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Update extends ModalComponent
{
    use Actions;

    public $isShow = true, $model_id, $selectedId, $price, $warranty_period, $commissioning_date,
    $buy_date, $manufacture_date, $cabinet_number, $description, $serial_number, $name, $contractor_id;

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

    public function mount($id)
    { 
        $editEquipment = Equipment::findOrFail($id);
        $this->selectedId = $id;
        $this->name = $editEquipment->name;
        $this->cabinet_number = $editEquipment->cabinet_number;
        $this->contractor_id = $editEquipment->contractor_id;
        $this->model_id = $editEquipment->model_id;
        $this->price = $editEquipment->price;
        $this->serial_number = $editEquipment->serial_number;
        $this->manufacture_date = $editEquipment->manufacture_date;
        $this->buy_date = $editEquipment->buy_date;
        $this->commissioning_date = $editEquipment->commissioning_date;
        $this->warranty_period = $editEquipment->warranty_period;
        $this->description = $editEquipment->description;
    }

    public function render()
    {
        $this->contractors = Contractor::get();
        $this->models = EquipmentModel::get();
        $this->equipment = Equipment::get();

        return view('livewire.equipments.update');
    }

    public function update() {
        $this->validate([
            'model_id'=>'required',
            'price'=>'required',
            'serial_number'=>'required',
            'manufacture_date'=>'required',
            'buy_date'=>'required',
            'commissioning_date'=>'required',
            'warranty_period'=>'required',
        ]);

        if($this->selectedId) {
            $updateEquipment = Equipment::find($this->selectedId);
            $updateEquipment->update([
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
            ]);
        }
        if($updateEquipment) {
            $this->forceClose()->closeModal();
            $this->notification()->success(
                $title = 'Успешно',
                $description = 'Данные успешно сохранены'
            );
            $this->resetInput();
        }
    }
}
