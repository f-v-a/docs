<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $positions = ['Врач', 'Администратор', 'Мастер', 'Главный врач'];

        foreach ($positions as $position) {
            Position::create(['name' => $position]);
        }

        DB::table('users')->insert([
            'login' => 'admin',
            'password' => Hash::make('admin'),
            'name' => 'Иван',
            'surname' => 'Иванов',
            'patronymic' => 'Иванович',
            'position_id' => 2,
            'role_id' => 2,
        ]);

        DB::table('employees')->insert([
            'user_id' => 1,
            'cabinet_number' => '',
            'gender' => 'М',
            'birthday' => '1995-03-19',
        ]);
    }
}
