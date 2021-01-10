<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        $admin = User::create([
            'firstname' => 'Dejan',
            'lastname' => 'Ristic',
            'email' => 'dejanr77@yahoo.com',
            'password' => Hash::make(123456),
            'role_id' => 1,
        ]);

        \App\Models\User::factory(20)->create();
    }
}
