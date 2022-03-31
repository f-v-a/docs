<?php

namespace App\Http\Livewire\Types;

use App\Models\EquipmentType;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Update extends ModalComponent
{
    use Actions;

    public $name, $selectedId;

    public function mount($id)
    { 
        $editType = EquipmentType::findOrFail($id);
        $this->selectedId = $id;
        $this->name = $editType->name;
    }

    public function render()
    {
        return view('livewire.types.update');
    }

    public function update() {
        $this->validate([
            'name' => 'required|:equipment_types|regex:/^([^0-9]*)$/',
        ]);

        if($this->selectedId) {
            $updateType = EquipmentType::find($this->selectedId);

            $updateType->update([
                'name' => $this->name,
            ]);

            $this->forceClose()->closeModal();
            $this->notification()->success(
                $title = 'Успешно',
                $description = 'Данные успешно сохранены'
            );
        }
    }
}
