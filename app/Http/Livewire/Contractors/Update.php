<?php

namespace App\Http\Livewire\Contractors;

use App\Models\Contractor;
use App\Models\Fullname;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Update extends ModalComponent
{
    use Actions;

    public $description, $name, $email, $inn, $selectedId;

    public function render()
    {

        return view('livewire.contractors.update');
    }
    
    private function resetInput() {
        $this->name = null;
        $this->email = null;
        $this->inn = null;
        $this->description = null;
    }

    public function mount($id)
    { 
        $editContractor = Contractor::findOrFail($id);
        $this->selectedId = $id;
        $this->name = $editContractor->name;
        $this->inn = $editContractor->inn;
        $this->description = $editContractor->description;
        $this->email = $editContractor->email;
    }

    public function update() {
        $this->validate([
            'name' => 'required',
            'inn' => 'required',
            'email' => 'email'
        ]);

        if($this->selectedId) {
            $updateContractor = Contractor::find($this->selectedId);

            $updateContractor->update([
                'name' => $this->name,
                'inn' => $this->inn,
                'description' => $this->description,
                'email' => $this->email,
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
