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
            'name' => 'Claudio Fabião',
            'email' => 'claudiojuniorfabiao@gmail.com',
            'password' => '12345678',
            'admin' => true
        ]);
    }
}
