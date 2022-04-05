<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends ApiController
{
    public function index(Request $request){
        $id_customer= $request->only('customer_id');
        $id_customer= $id_customer['customer_id'];
        if( $id_customer !=0 ){
            echo json_encode($id_customer); 
            $field="customers.id";
            $operator="=";
            $value=$id_customer;
            $data=DB::table('appointments')->select('*', 'appointments.id as appointment_id')
            ->join('customers', 'appointments.customer_id','=', 'customers.id')
            ->where('appointments.state','=', 'RESERVED')
            ->where($field, $operator, $value)
            ->get();
            $this->addValue('success',true);
            $this->addValue('data',$data);
            return $this->printResponse();
        }
        $data=DB::table('appointments')->select('*','appointments.id as appointment_id')
        ->join('customers', 'appointments.customer_id','=', 'customers.id')
        ->where('appointments.state','=', 'RESERVED')
        ->get();
        $this->addValue('success',true);
        $this->addValue('data',$data);
        return $this->printResponse();
    }
    public function completeAppointment(Request $request){
        $id=$request->only('appointment_id');
       
        $appointment=Appointment::find($id)->first();
        
        $appointment->state='COMPLETE';
       
        if($appointment->save()){
            $this->addValue('success',true);

        }else{
            $this->addValue('success',false);

        }
        return $this->printResponse();
    }
    public function getAppointment(Request $request){
        $date= $request->only('start_date');
        $data=DB::table('appointments')->select('*')
        ->join('customers', 'appointments.customer_id','=', 'customers.id')
        
        ->where('start_date','=', $date)->get();
        $this->addValue('success',true);
        $this->addValue('data',$data);
        return $this->printResponse();

    }
    public function store(Request $request){
        
        $new_customer= new Appointment($request->only('description', 'end_date', 'start_date', 'customer_id'));
        $new_customer->state='RESERVED';
        if( $new_customer->save()){
             $this->addValue('success',true);
             $this->addValue('message', 'The customer has been added successfully');
             return $this->printResponse();
        }else{
             return $this->responseError('the customer can not been added');
        }
    }

}
