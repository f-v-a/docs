<?php

namespace App\Http\Livewire\Types;

use App\Models\EquipmentType;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Store extends ModalComponent
{
    use Actions;

    public $name, $success = false;

    public function render()
    {
        return view('livewire.types.store');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:equipment_types|regex:/^([^0-9]*)$/'
        ]);

        $newType = EquipmentType::create([
            'name' => $this->name
        ]);

        if ($newType) {
            $this->forceClose()->closeModal();
            $this->notification()->success(
                $title = 'Успешно',
                $description = 'Данные успешно сохранены'
            );
        }
    }
}
