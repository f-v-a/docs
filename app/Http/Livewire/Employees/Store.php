<?php

namespace App\Http\Livewire\Employees;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Store extends ModalComponent
{
    use Actions;

    public $cabinet_number, $gender, $birthday, $user_id;

    public function render()
    {
        $this->users = User::whereNotIn('id', Employee::pluck('user_id'))
        ->whereNot(function($query) {
            $query->where('role_id', 3);
        })
        ->get();
        return view('livewire.employees.store');
    }

    private function resetInput() {
        $this->user_id = null;
        $this->cabinet_number = null;
        $this->gender = null;
        $this->birthday = null;
    }

    public function store() {
        $this->validate([
            'gender' => 'required',
            'birthday' => 'required',
            'user_id' => 'required',
        ]);

        $newEmployee = Employee::create([
            'user_id' => $this->user_id,
            'cabinet_number' => $this->cabinet_number,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
        ]);
        
        if($newEmployee) {
            $this->forceClose()->closeModal();
            $this->notification()->success(
                $title = 'Успешно',
                $description = 'Данные успешно сохранены'
            );
            $this->resetInput();
        }
    }
}
