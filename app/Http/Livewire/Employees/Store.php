<?php

namespace App\Http\Livewire\Employees;

use App\Models\Employee;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Store extends ModalComponent
{
    use Actions;

    public $cabinet_number, $gender, $birthday, $phone, $email, $user_id;

    public function render()
    {
        $this->users = User::where('role_id', 1)
        ->orWhere('role_id', 2)
        ->orWhere('role_id', 4)
        // ->where('id', '!=', Employee::pluck('id'))
        ->get();
        return view('livewire.employees.store');
    }

    private function resetInput() {
        $this->user_id = null;
        $this->cabinet_number = null;
        $this->gender = null;
        $this->birthday = null;
        $this->phone = null;
        $this->email = null;
    }

    public function store() {
        $this->validate([
            'gender' => 'required',
            'birthday' => 'required',
            'user_id' => 'required',
            'email' => 'email',
        ]);

        $newEmployee = Employee::create([
            'user_id' => $this->user_id,
            'cabinet_number' => $this->cabinet_number,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'email' => $this->email,
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
