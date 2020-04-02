<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'supriadiroadman@gmail.com')->first();

        // Buat objek untuk data user dengan kondisi email diatas
        if (!$user) {
            User::create([
                'name' => 'Supriadi Roadman',
                'email' => 'supriadiroadman@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('12345678')
            ]);
        }
    }
}
