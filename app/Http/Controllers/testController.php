<?php

namespace App\Http\Controllers;


use Request;
use Response;
use Config;
use JsonServer\JsonServer;
    

class testController extends Controller
{
    public function handleRequest($uri)
    {
        $data = Request::all();                                             //request data
        $method = Request::method();                                        //request method
        $jsonServer = new JsonServer();                                     //create new JsonServer instance
        $response = $jsonServer->handleRequest($method, $uri, $data);       //handle request
                                                                            //return Symfony\Component\HttpFoundation\Response
                                                                            //object with content, status and headers
        $response->send();                                                  //send response
        
        
        
        
    }
   
}