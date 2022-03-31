<?php

namespace App\Http\Livewire\Positions;

use App\Models\Position;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Update extends ModalComponent
{
    use Actions;

    public $name, $selectedId;

    public function mount($id)
    { 
        $editPosition = Position::findOrFail($id);
        $this->selectedId = $id;
        $this->name = $editPosition->name;
    }

    public function render()
    {
        return view('livewire.positions.update');
    }

    private function resetInput() {
        $this->name = null;
    }

    public function update() {
        $this->validate([
            'name' => 'required|unique:positions|alpha'
        ]);

        if($this->selectedId) {
            $updatePosition = Position::find($this->selectedId);

            $updatePosition->update([
                'name' => $this->name
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
