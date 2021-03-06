<?php

namespace App\Http\Livewire\Users;

use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Update extends ModalComponent
{
    use Actions;

    public $name, $surname, $patronymic, $position_id, $role_id, $login, $phone, $email;

    public function mount($id)
    { 
        $editUser = User::findOrFail($id);
        $this->selectedId = $id;
        $this->login = $editUser->login;
        $this->name = $editUser->name;
        $this->surname = $editUser->surname;
        $this->patronymic = $editUser->patronymic;
        $this->position_id = $editUser->position_id;
        $this->role_id = $editUser->role_id;
        $this->phone = $editUser->position_iphoned;
        $this->email = $editUser->email;
    }
    
    private function resetInput() {
        $this->name = null;
        $this->surname = null;
        $this->patronymic = null;
        $this->position_id = null;
        $this->role_id = null;
        $this->phone = null; 
        $this->email = null;
    }
    
    public function render()
    {
        $this->positions = Position::get();
        $this->roles = Role::get();

        return view('livewire.users.update');
    }

    public function update() {
        $this->validate([
            'name' => 'required',
            'surname' => 'required',
            'position_id' => 'required',
            'email' => 'email',
        ]);

        if($this->selectedId) {
            $updateUser = User::find($this->selectedId);

            $updateUser->update([
                'name' => $this->name,
                'surname' => $this->surname,
                'patronymic' => $this->patronymic,
                'position_id' => $this->position_id,
                'role_id' => $this->role_id,
                'login' => $this->login,
                'phone' => $this->phone,
                'email' => $this->email,
            ]);

            $this->forceClose()->closeModal();
            $this->resetInput();
            $this->notification()->success(
                $title = '??????????????',
                $description = '???????????? ?????????????? ??????????????????'
            );
        }
    }
}
