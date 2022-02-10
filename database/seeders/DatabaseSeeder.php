<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = ['Nailul Badri',
        'Khotibul umam',
        'Aminudin',
        'Anang Kustur',
        'Baihaqi Khoirul',
        'Farid Kurniawan',
        'Ferri Yulianto',
        'Hasbiallah',
        'Ibrohim',
        'Maskur Yamin',
        'Pahlevi',
        'Zuhri Utama',
        'Feri Gusrijal',
        'Haekal rizky',
        'Abd Aziz'];
        
        foreach($users as $user){
            \App\Models\User::create([
                'name' => $user,
                'email' => $user.'@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
