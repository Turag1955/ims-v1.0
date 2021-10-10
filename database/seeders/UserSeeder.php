<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => 1,
            'name' => 'Turag',
            'email' => 'superadmin@gmail.com',
            'mobile_no' => '01822010286',
            'avatar' => '',
            'gender' => 1,
            'status' => '1',
            'password' => 'superadmin@'
        ]);
    }
}
