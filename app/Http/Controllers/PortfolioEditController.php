<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PortfolioEditController extends Controller
{
    //
    public function execute(Portfolio $portfolio, Request $request){

        if($request->isMethod('delete')){
            $portfolio->delete();
            return redirect('admin')->with('status', 'Portfolio is delete');
        }

        if($request->isMethod('post')){
            $input = $request->except('_token');

            $messages = [
                'required' => 'Fuck of mrazina this pole required'
            ];
            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'filter' => 'required|max:255'
            ], $messages);

            if($validator->fails()){
                return redirect()->route('PortfolioEdit', ['portfolio' => $input['id']])
                    ->withErrors($validator);
            }

            if($request->hasFile('img')){
                $file = $request->file('img');
                $file->move(public_path().'/assets/images', $file->getClientOriginalName());
                $input['img'] = $file->getClientOriginalName();
            }else{
                $input['img'] = $input['old_img'];
            }
            unset($input['old_img']);

            $portfolio->fill($input);

            if($portfolio->update()){
                return redirect('admin')->with('status', 'Page is edit');
            }
        }

        $old = $portfolio->toArray();
        if(view()->exists('admin.portfolio_edit')){
            $data = [
                'title' => 'Edit Page is - '.$old['name'],
                'data' => $old
            ];
            return view('admin.portfolio_edit', $data);
        }

    }
}
