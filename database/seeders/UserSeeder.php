<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Library;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $library = new Library;
        $library->name = 'hereinafter';
        $library->email = 'demo@gmail.com';
        $library->password = Hash::make('Password123#');
        $library->save();
    }
}
