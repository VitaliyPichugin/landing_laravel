<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PortfolioAddController extends Controller
{
    //
    public function execute(Request $request){

        if($request->isMethod('post')){
            $input = $request->all();

            $messages = [
                'required' => 'Поле :attribute обязательно к заполнению'
            ];

            $validator = Validator::make($input, [
                'name' => 'required',
                'filter' => 'required'
            ], $messages);

            if($validator->fails()){
                return redirect()->route('PortfolioAdd')->withErrors($validator)->withInput();
            }

            if($request->hasFile('img')){
                $file = $request->file('img');

                $input['img'] = $file->getClientOriginalName();

                $file->move(public_path().'/assets/images', $input['img']);
            }

            $portfolio = new Portfolio();
            $portfolio->fill($input);
           // $portfolio->save();

            if($portfolio->save()){
                return redirect('admin')->with('status', 'Portfolio Added');
            }
        }

        if(view()->exists('admin.portfolio_add')){
            $data = [
                'title' => 'New Portfolio'
            ];
            return view('admin.portfolio_add', $data);
        }
        abort(404);
    }
}
