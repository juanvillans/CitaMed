<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class TypeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        $fields = [

            ['name' => 'Administrador' ],
            ['name' => 'Doctor' ],
            ['name' => 'Paciente' ],

         ];   

         DB::table('type_users')->insert($fields);

    }
}
