<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Robson Pedreira',
            'email' => 'masterdba6@gmail.com',
            'password' => 'Rm@150917',
            'admin' => true
        ]);
    }
}
