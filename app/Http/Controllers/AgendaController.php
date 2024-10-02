<?php

namespace App\Http\Controllers;

use App\Services\AgendaService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AgendaController extends Controller
{   
    private AgendaService $agendaService;


    public function __construct()
    {
        $this->agendaService = new AgendaService;
    }

    public function index()
    {
        // $specialties = $this->agendaService->getSpecialties();
        $specialties = null;
        
        return inertia('Dashboard/Agenda',[
            'data' => [
                'specialties' => $specialties,
            ]
        ]);
    }

    public function appointment()
    {
        return inertia('Dashboard/Citas');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
