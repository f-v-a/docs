<?php

namespace App\Http\Livewire\Performers;

use App\Models\Contractor;
use App\Models\Executor;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Update extends ModalComponent
{
    use Actions;

    public $contractor_id, $user_id, $selectedId;

    public function render()
    {
        $this->contractors = Contractor::get();

        $this->users = User::where('role_id', 3)->get();

        return view('livewire.performers.update');
    }

    public function mount($id)
    { 
        $editPerformer = Executor::findOrFail($id);
        $this->selectedId = $id;
        $this->contractor_id = $editPerformer->contractor_id;
        $this->user_id = $editPerformer->user_id;
    }
    
    public function update() {
        $this->validate([
            'contractor_id' => 'required',
            'user_id' => 'required',
        ]);

        if($this->selectedId) {
            $updatePerformer = Executor::find($this->selectedId);

            $updatePerformer->update([
                'contractor_id' => $this->contractor_id,
                'user_id' => $this->user_id,
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
