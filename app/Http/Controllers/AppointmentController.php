<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppointmentRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(){

        return inertia('Reservar');
    }

    public function store(CreateAppointmentRequest $appointmentData){

        DB::beginTransaction();

        try {

            $serviceCreated = $this->agendaService->storeService($serviceData->all());
            
            DB::commit();
            
            return redirect('/admin/agenda/cita/'.$serviceCreated->id)->with(['message' => 'Cita creada con éxito']);
        
        } catch (\Throwable $e) {
            
            DB::rollback();
            
            return redirect()->back()->withErrors(['data' => $e->getMessage()]);
        }


    }
}
