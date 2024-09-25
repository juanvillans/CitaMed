<?php

namespace Database\Seeders;

use App\Models\User;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $user1 = User::create([

            "ci" => "30847627",
            "name" => "Juan",
            "last_name" => "Donquis",
            "email" => "juandonquis07@gmail.com",
            "password" => Hash::make('admin'),
            "phone_number" => "04125800610",
        ]);

        $user2 = User::create([

            "ci" => "27253194",
            "name" => "Juan",
            "last_name" => "Villasmil",
            "email" => "juanvillans16@gmail.com",
            "password" => Hash::make('admin'),
            "phone_number" => "04124393123",
        ]);

        $user1->assignRole('admin');
        $user2->assignRole('admin');



    }
}
