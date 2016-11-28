<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'           => "Thanasis Nterelis",
            'email'          => 'nteath@gmail.com',
            'password'       => bcrypt('nteath'),
            'remember_token' => str_random(10),
        ]);
    }
}
