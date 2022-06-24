<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory(1)->create([
            'name' => 'Николай',
            'surname' => 'Фихтер',
            'last_name' => 'Олегович',
            'login' => 'adminOne',
            'email' => 'adminOne@mail.ru',
            'password' => bcrypt('admin'),
        ]);

        User::factory(1)->create([
            'name' => 'Анатолий',
            'surname' => 'Оленников',
            'last_name' => 'Евгеньевич',
            'login' => 'adminTwo',
            'email' => 'adminTwo@mail.ru',
            'password' => bcrypt('admin'),
        ]);

        User::factory(1)->create([
            'name' => 'Егор',
            'surname' => 'Ивашкеев',
            'last_name' => 'Александрович',
            'login' => 'adminThree',
            'email' => 'adminThree@mail.ru',
            'password' => bcrypt('admin'),
        ]);

        User::factory(1,[
            'boss_id' => 1
        ])->create();

        User::factory(1,[
            'boss_id' => 2
        ])->create();

        User::factory(1,[
            'boss_id' => 3
        ])->create();

        Task::factory(2, [
            'responsible_id' => 4,
            'creator_id' => 1
        ])->create();

        Task::factory(2, [
            'responsible_id' => 5,
            'creator_id' => 2
        ])->create();

        Task::factory(2, [
            'responsible_id' => 6,
            'creator_id' => 3
        ])->create();

    }
}
