<?php

namespace Database\Seeders;

use App\Models\Position;
use Doctrine\DBAL\Platforms\Keywords\DB2Keywords;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = ['Врач', 'Администратор', 'Мастер', 'Главный врач'];

        foreach ($positions as $position) {
            Position::create(['name' => $position]);
        }

        DB::table('users')->insert([
            'login' => 'admin',
            'password' => Hash::make('admin'),
            'name' => ' Михаил',
            'surname' => 'Петров',
            'patronymic' => 'Тимофеевич',
            'position_id' => 2,
            'role_id' => 2,
        ]);

        DB::table('users')->insert([
            'login' => 'master',
            'password' => Hash::make('master'),
            'name' => 'Лев',
            'surname' => 'Федоров',
            'patronymic' => 'Матвеевич',
            'position_id' => 3,
            'role_id' => 3,
        ]);

        DB::table('users')->insert([
            'login' => 'chief',
            'password' => Hash::make('chief'),
            'name' => 'Георгий',
            'surname' => 'Круглов',
            'patronymic' => 'Ярославович',
            'position_id' => 4,
            'role_id' => 4,
        ]);

        DB::table('users')->insert([
            'login' => 'user',
            'password' => Hash::make('user'),
            'name' => 'Федор',
            'surname' => 'Беляев',
            'patronymic' => 'Григорьевич',
            'position_id' => 1,
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'login' => 'master2',
            'password' => Hash::make('master2'),
            'name' => 'Лев',
            'surname' => 'Новиков',
            'patronymic' => 'Даниилович',
            'position_id' => 3,
            'role_id' => 3,
        ]);

        DB::table('users')->insert([
            'login' => 'master3',
            'password' => Hash::make('master3'),
            'name' => 'Филатов',
            'surname' => 'Давид',
            'patronymic' => 'Артемович',
            'position_id' => 3,
            'role_id' => 3,
        ]);


        DB::table('employees')->insert([
            'user_id' => 1,
            'cabinet_number' => '',
            'gender' => 'М',
            'birthday' => '1995-01-19',
        ]);

        DB::table('employees')->insert([
            'user_id' => 3,
            'cabinet_number' => '100',
            'gender' => 'М',
            'birthday' => '1990-07-11',
        ]);

        DB::table('employees')->insert([
            'user_id' => 4,
            'cabinet_number' => '101',
            'gender' => 'М',
            'birthday' => '1988-03-22',
        ]);

        DB::table('contractors')->insert([
            'description' => 'Контрагент',
            'name' => 'ООО Контрагент',
            'email' => 'contragent@gmail.com',
            'inn' => '123456789123',
        ]);

        DB::table('contractors')->insert([
            'description' => 'Контрагент2',
            'name' => 'ООО Контрагент2',
            'email' => 'contragent2@gmail.com',
            'inn' => '123456789122',
        ]);

        DB::table('executors')->insert([
            'contractor_id' => 1,
            'user_id' => 2,
            'email' => 'performer@gmail.com',
            'phone' => '89123334455',
        ]);

        DB::table('executors')->insert([
            'contractor_id' => 2,
            'user_id' => 5,
            'email' => 'performer2@gmail.com',
            'phone' => '89123334466',
        ]);

        DB::table('executors')->insert([
            'user_id' => 6,
            'email' => 'performer3@gmail.com',
            'phone' => '89123334123',
        ]);
    }
}
