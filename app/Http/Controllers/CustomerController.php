<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends ApiController
{
    public function index(){
        $customers=Customer::all();
        $this->addValue('success',true);

        $this->addValue('data',$customers);

        return $this->printResponse();
    }
    public function store(Request $request){
        $new_customer= new Customer($request->only('name', 'surname', 'birthday'));
       if( $new_customer->save()){
            $this->addValue('success',true);
            $this->addValue('message', 'The customer has been added successfully');
            return $this->printResponse();
       }else{
            return $this->responseError('the customer can not been added');
       }
    }
}
