<?php  

namespace App\Services;

use App\Http\Resources\AgendaCollection;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Specialty;
use App\Models\User;
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

    public function updateService($data, $service){

        // Update service
        return 0;
    }

    public function updateUser($data, $user)
    {

        $user->update([
            
            "ci" => $data['ci'],
            "name" => $data['name'],
            "last_name" => $data['last_name'],
            "email" => $data['email'],
            "search" => $this->generateSearch($data),
        ]);

        method_exists($user, 'revokeRoles') ? $user->revokeRoles(): null;
        
        $user->assignRole($data['role_name']);

        if($user->hasRole('doctor'))
            $this->assignSpecialties($user,$data);

        return 0;

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
