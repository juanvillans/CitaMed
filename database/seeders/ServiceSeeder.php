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
            'description' => 'Esto es una jodida descripcion',
            'duration_per_appointment' => 30,
            'schedule_json' => json_encode(['monday' => '9:00-17:00']),
            'start_date_agenda' => '2024-01-01',
            'end_date_agenda' => '2024-12-31',
            'max_reservation_time_before_appointment' => 2,
            'min_reservation_time_before_appointment' => 1,
            'adjust_avability_json' => json_encode(['adjustments' => []]),
            'duration_between_appointment' => 15,
            'max_reservations_per_day' => 10,
            'fields' => json_encode(['Nombre y Apellido']),
        ]);

        Service::create([
            'user_id' => 3, 
            'specialty_id' => 1, 
            'title' => 'Consulta Operacion',
            'description' => 'Esto es una jodida descripcion',
            'duration_per_appointment' => 30,
            'schedule_json' => json_encode(['monday' => '9:00-17:00']),
            'start_date_agenda' => '2024-01-01',
            'end_date_agenda' => '2024-12-31',
            'max_reservation_time_before_appointment' => 2,
            'min_reservation_time_before_appointment' => 1,
            'adjust_avability_json' => json_encode(['adjustments' => []]),
            'duration_between_appointment' => 15,
            'max_reservations_per_day' => 10,
            'fields' => json_encode(['Nombre y Apellido']),
        ]);
    }
}
