<?php

namespace App\Http\Livewire\Models;

use App\Models\EquipmentModel;
use App\Models\EquipmentType;
use App\Models\Manufacturer;
use LivewireUI\Modal\ModalComponent;
use Monarobase\CountryList\CountryListFacade;
use WireUi\Traits\Actions;

class Update extends ModalComponent
{
    use Actions;

    public $name, $type_id, $manufacturer;

    public function mount($id)
    { 
        $editModel = EquipmentModel::findOrFail($id);
        $this->selectedId = $id;
        $this->name = $editModel->name;
        $this->type_id = $editModel->type_id;
        $this->manufacturer = $editModel->manufacturer;
    }
    
    private function resetInput() {
        $this->name = null;
        $this->type_id = null;
        $this->manufacturer_id = null;
    }
    
    public function render()
    {
        $this->types = EquipmentType::get();
        $this->countries = CountryListFacade::getList('ru');

        return view('livewire.models.update');
    }

    public function update() {
        $this->validate([
            'name' => 'required',
            'type_id' => 'required|numeric',
            'manufacturer' => 'required'
        ]);

        if($this->selectedId) {
            $updateModel = EquipmentModel::find($this->selectedId);

            $updateModel->update([
                'name' => $this->name,
                'type_id' => $this->type_id,
                'manufacturer' => $this->manufacturer,
            ]);
            
            $this->forceClose()->closeModal();
            $this->resetInput();
            $this->notification()->success(
                $title = 'Успешно',
                $description = 'Данные успешно сохранены'
            );
        }
    }
}
