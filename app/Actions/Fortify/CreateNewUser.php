<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'login' => ['required', 'string', 'max:100', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
            'surname' => 'required|alpha|max:150',
            'name' => 'required|alpha|max:150',
            'patronymic' => 'alpha|max:150',
            'position_id' => 'numeric',
            'is_performer' => 'boolean',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'password' => Hash::make($input['password']),
            'surname' => $input['surname'],
            'name' => $input['name'],
            'patronymic' => $input['patronymic'],
            'position_id' =>$input['position_id'],
            'is_performer' => $input['is_performer'],
        ]);
    }
}
