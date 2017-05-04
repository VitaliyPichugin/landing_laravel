<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    //
    public function execute(){
        if(view()->exists('admin.services')){
            $service = Service::all();

            $data = [
                'title' => 'Services',
                'data' => $service
            ];
            return view('admin.services', $data);
        }
        abort(404);
    }
}
