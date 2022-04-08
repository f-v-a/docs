<?php

namespace App\Http\Livewire\Users;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Store extends ModalComponent
{
    use Actions, PasswordValidationRules;

    public $name, $surname, $patronymic, $position_id, $role_id, $password, $login, $email, $phone;

    public function render()
    {
        $this->positions = Position::get();
        $this->roles = Role::get();

        return view('livewire.users.store');
    }

    private function resetInput() {
        $this->name = null;
        $this->surname = null;
        $this->patronymic = null;
        $this->position_id = null;
        $this->role_id = null;
        $this->login = null;
        $this->password = null;
        $this->phone = null;
        $this->email = null;
    }

    public function store()
    {
        $this->validate([
            'login' => ['required', 'string', 'max:100', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
            'surname' => 'required|alpha|max:150',
            'name' => 'required|alpha|max:150',
            'patronymic' => 'alpha|max:150',
            'position_id' => 'numeric',
            'role_id' => 'numeric',
            'email' => 'email',
        ]);

        $newUser = User::create([
            'name' => $this->name,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
            'position_id' => $this->position_id,
            'role_id' => $this->role_id,
            'login' => $this->login,
            'password' => Hash::make($this->password),
            'phone' => $this->phone,
            'email' => $this->email,
        ]);

        if($newUser) {
            $this->forceClose()->closeModal();
            $this->notification()->success(
                $title = 'Успешно',
                $description = 'Данные успешно сохранены'
            );
            $this->resetInput();
        }
    }
}
