<?php  

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Models\User;

class UserService
{	
	private User $userModel;


    public function __construct()
    {
        $this->userModel = new User;
    }

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
    

}
