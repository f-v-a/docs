<?php

namespace App\Http\Livewire\Contractors;

use App\Models\Contractor;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Store extends ModalComponent
{
    use Actions;

    public $description, $name, $email, $inn;

    public function render()
    {
        return view('livewire.contractors.store');
    }

    private function resetInput() {
        $this->name = null;
        $this->email = null;
        $this->inn = null;
        $this->description = null;
    }

    public function store() {
        $this->validate([
            'name' => 'required',
            'inn' => 'required',
            'email' => 'email'
        ]);

        $newContractor = Contractor::create([
            'name' => $this->name,
            'inn' => $this->inn,
            'description' => $this->description,
            'email' => $this->email,
        ]);
        
        if($newContractor) {
            $this->forceClose()->closeModal();
            $this->notification()->success(
                $title = 'Успешно',
                $description = 'Данные успешно сохранены'
            );
            $this->resetInput();
        }
    }
}
