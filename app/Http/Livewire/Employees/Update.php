<?php

namespace App\Http\Livewire\Employees;

use App\Models\Employee;
use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use WireUi\Traits\Actions;

class Update extends ModalComponent
{
    use Actions;

    public $cabinet_number, $gender, $birthday, $phone, $email, $user_id, $selectedId;

    public function mount($id)
    { 
        $editEmployee = Employee::findOrFail($id);
        $this->selectedId = $id;
        $this->user_id = $editEmployee->user_id;
        $this->cabinet_number = $editEmployee->cabinet_number;
        $this->gender = $editEmployee->gender;
        $this->birthday = $editEmployee->birthday;
        $this->phone = $editEmployee->phone;
        $this->email = $editEmployee->email;
    }
    
    private function resetInput() {
        $this->user_id = null;
        $this->cabinet_number = null;
        $this->gender = null;
        $this->birthday = null;
        $this->phone = null;
        $this->email = null;
    }

    public function render()
    {
        $this->users = User::where('role_id', 1)->orWhere('role_id', 2)->orWhere('role_id', 4)->get();
        
        return view('livewire.employees.update');
    }

    public function update() {
        $this->validate([
            'gender' => 'required',
            'birthday' => 'required',
            'user_id' => 'required',
            'email' => 'email',
        ]);

        if($this->selectedId) {
            $updateEmployee = Employee::find($this->selectedId);

            $updateEmployee->update([
                'user_id' => $this->user_id,
                'cabinet_number' => $this->cabinet_number,
                'gender' => $this->gender,
                'birthday' => $this->birthday,
                'phone' => $this->phone,
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
