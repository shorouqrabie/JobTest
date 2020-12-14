<?php

use Illuminate\Database\Seeder;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('people')->insert([
            'username' => 'person1user',
            'name' => 'person1',
            'email' => 'person1@gmail.com',
            'password' => Hash::make('password'),
            'age' => 25,
            'biography' => 'person 1 biography',
            'personal_photo' => 'default-avatar.png',
        ]);

        DB::table('people')->insert([
            'username' => 'person2user',
            'name' => 'person2',
            'email' => 'person2@gmail.com',
            'password' => Hash::make('password'),
            'age' => 18,
            'biography' => 'person 2 biography',
            'personal_photo' => 'default-avatar.png',
        ]);

    }
}
