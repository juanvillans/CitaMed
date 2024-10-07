<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Services\AgendaService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{   
    private AgendaService $agendaService;
    private $params = [];

    public function __construct()
    {
        $this->agendaService = new AgendaService;
    }

    public function index()
    {
        $specialties = $this->agendaService->getSpecialties();
        
        return inertia('Dashboard/Agenda',[
            'data' => [
                'specialties' => $specialties,
            ]
        ]);
    }

    public function service(Service $service)
    {
        $serviceDetails = $this->agendaService->getServiceDetails($service);   
        
        return inertia('Dashboard/Citas',[
            
            'data' => [
                'serviceDetails' => $serviceDetails,
            ]
        ]);

    }

    public function createService(){

        $serviceDetails = $this->agendaService->getDataToCreateService();   

        return inertia('Dashboard/Citas',[
            'data' => [
                'serviceDetails' => $serviceDetails,
            ]
        ]);
    }

    public function updateService(UpdateServiceRequest $request, Service $service){
        
        DB::beginTransaction();

        try 
        {
            $data = $request->all();

            $this->agendaService->updateService($data, $service);

            DB::commit();

            return redirect()->back()->with(['message' => 'Cita actualizada con éxito']);

        }
        catch (\Throwable $e)
        {   
            
            DB::rollback();
            
            return redirect()->back()->withErrors(['data' => $e->getMessage()]);
        }
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
