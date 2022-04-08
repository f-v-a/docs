<?php

namespace App\Http\Livewire\Performers;

use App\Models\Contractor;
use App\Models\Executor;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Store extends ModalComponent
{
    use Actions;

    public $contractor_id, $user_id;

    public function render()
    {
        $this->contractors = Contractor::get();

        $this->users = User::whereNotIn('id', Executor::pluck('user_id'))
        ->where('role_id', 3)->get();

        return view('livewire.performers.store');
    }

    private function resetInput() {
        $this->contractor_id = null;
        $this->user_id = null;
    }

    public function store() {
        $this->validate([
            'contractor_id' => 'nullable',
            'user_id' => 'required',
        ]);

        $newPerformer = Executor::create([
            'contractor_id' => $this->contractor_id,
            'user_id' => $this->user_id,
        ]);
        
        if($newPerformer) {
            $this->forceClose()->closeModal();
            $this->notification()->success(
                $title = 'Успешно',
                $description = 'Данные успешно сохранены'
            );
            $this->resetInput();
        }
    }
}
