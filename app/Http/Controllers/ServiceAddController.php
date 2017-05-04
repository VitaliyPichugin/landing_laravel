<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceAddController extends Controller
{
    //
    public function execute(Request $request){
        if($request->isMethod('post')){

          //  $input = $request->all();
            $input = $request->except('_token');

            $messages = [
                'required' => 'Pole obeztelno k zapolneniy',
                'max' => 'ska big limited symbol'
            ];

            $valiator = Validator::make($input, [
                'name' => 'required|max:255',
                'text' => 'required',
                'icon' => 'required|max:60'
            ], $messages);

            if($valiator->fails()){
                return redirect()->route('ServiceAdd')->withErrors($valiator)->withInput();
            }

            $service = new Service();
            $service->fill($input);

            if($service->save()){
                return redirect('admin')->with('status', 'Service Added');
            }
        }
        if(view()->exists('admin.portfolio_add')){
            $data = [
                'title' => 'Add Services',
            ];
            return view('admin.service_add', $data);
        }
        abort(404);
    }
}
