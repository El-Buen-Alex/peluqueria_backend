<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Appointment_done;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentDoneController extends ApiController
{
    public function index(){
        $data=DB::table('appointment_dones')
        ->select('appointments.start_date','customers.name', 
        'customers.surname', 'appointments.description', 'appointment_dones.reason', 'appointment_dones.amount')
        ->join('appointments', 'appointments.id', '=', 'appointment_dones.appointment_id')
        ->join('customers', 'customers.id','=', 'appointments.customer_id')
        ->where('appointments.state','=', 'FINISHED')
        ->orderByDesc('appointments.start_date')->get();


        $this->addValue('success',true);
        $this->addValue('data',$data);
        return $this->printResponse();
    }
    public function store(Request $request){

       return DB::transaction(function () use ($request){
            $new_appotintment_done=new Appointment_done($request->only('appointment_id', 'reason', 'amount'));
            if($new_appotintment_done->save()){
                $apoointment_id=$request->only('appointment_id');
                $apoointment_id=intval($apoointment_id['appointment_id']);
               
                $appointment=Appointment::find($apoointment_id);
               
                $appointment->state='FINISHED';
                if($appointment->save()){
                    $this->addValue('success',true);
                }else{
                $this->addValue('success',false);

                }
                return $this->printResponse();
            }else{
                $this->addValue('success',false);
                return $this->printResponse();
            }
       },5);
       
    }
}
