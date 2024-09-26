<?php  

namespace App\Services;

use App\Models\Specialty;

class SpecialtyService
{	
	private Specialty $specialtyModel;


    public function __construct()
    {
        $this->specialtyModel = new Specialty;
    }

    public function getSpecialties($params)
    {
        $users = Specialty::query()
        ->when($params['search'],function($query, $search){
            
            $query->where('name','like','%' . $search . '%');
        })
        ->get();

        return $users;
    }
    

}
