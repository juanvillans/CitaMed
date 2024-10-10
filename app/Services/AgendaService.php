<?php  

namespace App\Services;

use App\Http\Resources\AgendaCollection;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Service;
use App\Models\Specialty;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;

class AgendaService
{	
    public function getSpecialties()
    {   
        $userID = auth()->id();
        $user = User::find($userID);
        $role = $user->getRoleNames()->first();
        
        $specialties = Specialty::with('doctors')
        ->when($role == 'doctor', function($query) use ($userID){

            $query->whereHas('services',function($query) use ($userID) {
                $query->where('doctor_id',$userID);
            });
        })
        ->where('status',1)
        ->get();

        return new AgendaCollection($specialties);
        
    }


    public function getServiceDetails($service)
    {
        $service->load('user','specialty');

        return new ServiceResource($service);

    }

    public function getDataToCreateService(){
        
        $userService = new UserService;
        $params = $this->generateParamsAccordingToRoleUser();
        
        
        $doctors = $userService->getUsers($params);

        $response = [

            'doctors' => new UserCollection($doctors),
        ];

        return $response;
    }

    public function getCalendar($service, $params){
        
        $startOfWeek = Carbon::now()->startOfWeek();
        if(isset($params['to']) && isset($params['startOfWeek']) ) {

            if($params['to'] == 'next'){
                $startOfWeek = Carbon::parse($params['startOfWeek'])->addWeek()->startOfWeek();
            }

            if($params['to'] == 'prev'){
                $startOfWeek = Carbon::parse($params['startOfWeek'])->subWeek()->startOfWeek();
            }

        }

        $response = [
            'headerInfo' => [
                'month_year' => Carbon::now()->format('F \d\e Y'),
                'today' => Carbon::now()->format('Y-m-d'),
            ],
            'calendar' => [
                'mon' => [
                    'current_date' => $startOfWeek->copy()->format('Y-m-d'),
                    'appointments' => []
                ],
                'tue' => [
                    'current_date' => $startOfWeek->copy()->addDays(1)->format('Y-m-d'),
                    'appointments' => []
                ],
                'wed' => [
                    'current_date' => $startOfWeek->copy()->addDays(2)->format('Y-m-d'),
                    'appointments' => []
                ],
                'thu' => [
                    'current_date' => $startOfWeek->copy()->addDays(3)->format('Y-m-d'),
                    'appointments' => []
                ],
                'fri' => [
                    'current_date' => $startOfWeek->copy()->addDays(4)->format('Y-m-d'),
                    'appointments' => []
                ],
                'sat' => [
                    'current_date' => $startOfWeek->copy()->addDays(5)->format('Y-m-d'),
                    'appointments' => []
                ],
                'sun' => [
                    'current_date' => $startOfWeek->copy()->addDays(6)->format('Y-m-d'),
                    'appointments' => []
                ],

            ]
        ];

        return $response;
    }

    public function storeService($serviceData){
        
        $newService = Service::create([
            'user_id' => $serviceData['doctor_id'],
            'specialty_id' => $serviceData['specialty_id'],
            'title' => $serviceData['title'],
            'availability' => json_encode($serviceData['availability']),
            'adjust_avability' => json_encode($serviceData['adjusted_availability']),
            'programming_slot' => json_encode($serviceData['programming_slot']),
            'booked_appointment_settings' => json_encode($serviceData['booked_appointment_settings']),
            'description' => $serviceData['description'],
            'fields' => json_encode($serviceData['fields']),
        ]);

        return $newService;
    }

    public function updateService($serviceData, $service){

        $service->update([
            'user_id' => $serviceData['doctor_id'],
            'specialty_id' => $serviceData['specialty_id'],
            'title' => $serviceData['title'],
            'availability' => json_encode($serviceData['availability']),
            'adjust_avability' => json_encode($serviceData['adjusted_availability']),
            'programming_slot' => json_encode($serviceData['programming_slot']),
            'booked_appointment_settings' => json_encode($serviceData['booked_appointment_settings']),
            'description' => $serviceData['description'],
            'fields' => json_encode($serviceData['fields']),
        ]);

        return 0;
    }

    public function deleteService($service){
        
        $service->delete();

        return 0;
    }


    private function generateParamsAccordingToRoleUser(){

        $user = auth()->user();
        $role = $user->getRoleNames()->first();
        $params = null;

        if($role == 'admin'){
            $params = [
                'role' => 'doctor',
            ];
        }
        else{

            $params = [
                'role' => 'doctor',
                'userID' => $user->id,
            ];
        }

        return $params;
    }


    public function deleteUser($usuario)
    {   
        $authUserId = auth()->id();
        $usuario->id == $authUserId ? throw new Exception("No puedes eliminar tu propio usuario", 401) : null;

        $usuario->specialties()->detach();
        $usuario->roles()->detach();

        $usuario->delete();

        return 0;
    }

    private function assignSpecialties($user, $data)
    {

        if(!isset($data['specialties_ids']) || count($data['specialties_ids']) == 0 )
            throw new Exception("El doctor debe tener alguna especialidad seleccionada", 401);
        
        $user->specialties()->sync($data['specialties_ids']);

        return 0;
            
    }

    private function generateSearch($data)
    {
        $search = $data['ci'] . " "
                 .$data['name'] . " "
                 .$data['last_name'] . " "
                 .$data['email'] . " "
                 .$data['phone_number'] . " ";
        
        return $search;
    }
    

}
