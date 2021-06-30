<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $token = Str::random(60);
        User::create([
            'name' => "Admin",
            'email' => "fluensercs@gmail.com",
            'password' => Hash::make('Fisherpr!ceishome1917'),
            'api_token' => hash('sha256', $token),
            'username' => 'admin',
            'loggedIn' => true,
            'stripe_id' => '',
            'accountType' => '',
        ]);
    }
}
