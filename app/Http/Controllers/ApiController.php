<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Mockery\Matcher\Any;
use Symfony\Component\HttpFoundation\Cookie;

class ApiController extends Controller
{
    private $data = [];

    protected function addValue(string $key, $data)
    {
        $this->data[$key] = $data;
    }
    public function sendRespons($message)
    {
        $this->data['message'] = $message;
       
        return response()->json($this->data, 200);
    }
    public function sendResponsWithCookie($message, Cookie $cookie)
    {
        $this->data['message'] = $message;
       
        return response()->json($this->data,  200)->withCookie($cookie);
    }
    public function printResponse(){
        return response()->json($this->data,  200);
    }
    public function responseError($errorMessage, $code = 404)
    {
        $this->data['success']=false;
        $this->data['message'] = $errorMessage;
    
        $this->data['code'] = $code;

        return response()->json($this->data);
    }
}
