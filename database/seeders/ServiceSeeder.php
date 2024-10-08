<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'user_id' => 3, 
            'specialty_id' => 1, 
            'title' => 'Consulta General',
            'availability_json' => json_encode([
                'mon' => [ 
                    [
                        'start' => '8:00',
                        'end' => '16:00',
                        'appointments' => [
                            [
                                'start_appo' => '8:00', 
                            ]
                            
                            ]
                     ] 
                ] 
            
            ]),
            'adjust_avability_json' => json_encode([]),
            'programming_slot_json' => json_encode([
                
                'available_now_check' => true,

                'interval_date' => [
                    'start_now_check' => false,
                    'custom_start_date' => '2024-09-09T04:00:00.000Z',

                    'end_never_check' => false,
                    'custom_end_date' => '2024-09-09T04:00:00.000Z'
                ],
            ]),
            'booked_appointment_settings_json' => json_encode([

                'time_between_appointment' => null,
                'allow_max_appointment_per_day' => false,
                'max_appointment_per_day' => 4,
            ]), 
            'description' => 'Esto es una jodida descripcion',
            'fields_json' => json_encode([
                [ 'name' => 'Nombre', 'required' => true, 'default' => true ],
                [ 'name' => 'Apellido', 'required' => true, 'default' => true ],
                [ 'name' => 'Correo', 'required' => true, 'default' => false ],
                [ 'name' => 'Cédula', 'required' => true, 'default' => true ],
                [ 'name' => 'Teléfono', 'required' => true, 'default' => true ],
                ]),
        ]);

        Service::create([
            'user_id' => 3, 
            'specialty_id' => 1, 
            'title' => 'Consulta especial',
            'availability_json' => json_encode([
                'mon' => [ 
                    [
                        'start' => '8:00',
                        'end' => '16:00',
                        'appointments' => [
                            [
                                'start_appo' => '8:00', 
                            ]
                            
                            ]
                     ] 
                ] 
            
            ]),
            'adjust_avability_json' => json_encode([]),
            'programming_slot_json' => json_encode([
                
                'available_now_check' => true,

                'interval_date' => [
                    'start_now_check' => false,
                    'custom_start_date' => '2024-09-09T04:00:00.000Z',

                    'end_never_check' => false,
                    'custom_end_date' => '2024-09-09T04:00:00.000Z'
                ],
            ]), 
            'booked_appointment_settings_json' => json_encode([

                'time_between_appointment' => null,
                'allow_max_appointment_per_day' => false,
                'max_appointment_per_day' => 4,
            ]), 
            'description' => 'Esto es una jodida descripcion 2',
            'fields_json' => json_encode([
                [ 'name' => 'Nombre', 'required' => true, 'default' => true ],
                [ 'name' => 'Apellido', 'required' => true, 'default' => true ],
                [ 'name' => 'Correo', 'required' => true, 'default' => false ],
                [ 'name' => 'Cédula', 'required' => true, 'default' => true ],
                [ 'name' => 'Teléfono', 'required' => true, 'default' => true ],
                ]),
        ]);

        
    }
}
