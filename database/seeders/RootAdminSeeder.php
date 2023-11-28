<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RootAdmin;
use Illuminate\Support\Facades\Hash;

class RootAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RootAdmin::create([
            'full_name' => 'Root Admin',
            'username' => 'root',
            'password' => Hash::make('123123123')
        ]);
    }
}
