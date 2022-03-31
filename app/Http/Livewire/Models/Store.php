<?php

namespace App\Http\Livewire\Models;

use App\Models\EquipmentModel;
use App\Models\EquipmentType;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;
use Monarobase\CountryList\CountryListFacade;

class Store extends ModalComponent
{
    use Actions;

    public $types , $manufacturers, $name, $type_id, $manufacturer;

    public function render()
    {
        $this->types = EquipmentType::get();
        $this->countries = CountryListFacade::getList('ru');

        return view('livewire.models.store');
    }

    private function resetInput() {
        $this->name = null;
        $this->type_id = null;
        $this->manufacturer = null;
    }

    public function store() {
        $this->validate([
            'name' => 'required|unique:equipment_models',
            'type_id' => 'required|numeric',
            'manufacturer' => 'required'
        ]);

        $newModel = EquipmentModel::create([
            'name' => $this->name,
            'type_id' => $this->type_id,
            'manufacturer' => $this->manufacturer,
        ]);

        if($newModel) {
            $this->forceClose()->closeModal();
            $this->notification()->success(
                $title = 'Успешно',
                $description = 'Данные успешно сохранены'
            );
            $this->resetInput();
        }
    }
}
