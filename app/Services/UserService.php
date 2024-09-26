<?php  

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService
{	
    public function getUsers($params)
    {
        $users = User::query()
        ->when($params['search'],function($query, $search){
            
            $query->where('search','like','%' . $search . '%');
        })
        ->with('specialties')
        ->get();

        return new UserCollection($users);
    }

    public function createUser($data)
    {
        $newUser = User::create([
            
            "ci" => $data['ci'],
            "name" => $data['name'],
            "last_name" => $data['last_name'],
            "email" => $data['email'],
            "password" => Hash::make($data['ci']),
            "phone_number" => $data['phone_number'],
            "search" => $this->generateSearch($data),
        ]);

        $newUser->assignRole($data['role']);

        if($newUser->hasRole('doctor'))
            $this->assignSpecialties($newUser,$data);

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

        $user->revokeRoles();
        $user->assignRole($data['role']);

        if($user->hasRole('doctor'))
            $this->assignSpecialties($user,$data);

        return 0;

    }

    private function assignSpecialties($user, $data)
    {

        if(!isset($data['specialties']))
            throw new Exception("El doctor debe tener alguna especialidad seleccionada", 401);
        
        $user->specialties->sync($data['specialties']);

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
