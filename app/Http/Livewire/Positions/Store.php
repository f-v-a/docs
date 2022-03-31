<?php

namespace App\Http\Livewire\Positions;

use App\Models\Position;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Store extends ModalComponent
{
    use Actions;

    public $name, $selectedId;

    public function render()
    {
        return view('livewire.positions.store');
    }

    private function resetInput() {
        $this->name = null;
    }

    public function store() {
        $this->validate([
            'name' => 'required|unique:positions|alpha'
        ]);

        $newPosition = Position::create([
            'name' => $this->name
        ]);
        
        if($newPosition) {
            $this->forceClose()->closeModal();
            $this->notification()->success(
                $title = 'Успешно',
                $description = 'Данные успешно сохранены'
            );
            $this->resetInput();
        }
    }
}
