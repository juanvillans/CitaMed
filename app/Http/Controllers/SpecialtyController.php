<?php

namespace App\Http\Controllers;

use App\Services\SpecialtyService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SpecialtyController extends Controller
{   
    private SpecialtyService $specialtyService;
    private $params = [];

    public function __construct()
    {
        $this->specialtyService = new SpecialtyService;
    }

    public function index(Request $request)
    {
        $this->params = [
            'search' => $request->input('search'),
        ];

        $specialties = $this->specialtyService->getSpecialties($this->params);

        return inertia('Dashboard/Especialidades',[

            "data" => [
                'specialties' => $specialties,
            ]
        ]);
    }

   
}
