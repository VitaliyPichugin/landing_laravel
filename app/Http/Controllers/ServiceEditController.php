<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceEditController extends Controller
{
    //
    public function execute(Request $request, Service $service){

        if($request->isMethod('delete')){
            $service->delete();
            return view('admin.service_edit')->with('status', 'Service is deleted');
        }
        if($request->isMethod('post')){

            $input = $request->except('_token');

            $validator = Validator::make($input, [
               'name' => 'required|max:255',
                'text' => 'required',
                'icon' => 'required'
            ]);

            if($validator->fails()){
                return redirect()->route('ServiceEdit', ['service' => $service['id']])->
                                        withErrors($validator);
            }

            $service->fill($input);

            if($service->update()){
                return redirect('admin')->with('status', 'Service is edit');
            }

        }
        $old = $service->toArray(); //для отображения конкретного имени сервиса $old['name']
        //dd($old);
        if(view()->exists('admin.pages_edit')){
            $data = [
                'title' => 'Редактирование сервиса - '.$old['name'],
                'data' => $old
            ];
            return view('admin.service_edit', $data);
        }
    }
}
