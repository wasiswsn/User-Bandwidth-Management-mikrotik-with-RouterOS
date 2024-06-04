<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tambahkan data pengguna
        User::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'level' => 'admin', // Sesuaikan dengan level yang sesuai
        ]);
    }
}
