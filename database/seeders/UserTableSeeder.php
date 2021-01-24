<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name'=>'Osamah',
            'last_name'=>'fadhil',
            'email'=>'Osamah@admin.com',
            'password'=>bcrypt('1159800'),
        ]);

        $user->attachRoles(['super_admin']);
    }
}
