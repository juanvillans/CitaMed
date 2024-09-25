<?php  

namespace App\Services;

use DB;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserService
{	
	private User $userModel;


    public function __construct()
    {
        $this->userModel = new User;
    }
    

}
