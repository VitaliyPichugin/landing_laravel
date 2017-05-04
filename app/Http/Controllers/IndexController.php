<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Service;
use App\Portfolio;
use App\People;
use Illuminate\Support\Facades\Mail;
use DB;


class IndexController extends Controller
{
    //
    public function execute(Request $request){


        if($request->isMethod('post')){
            $messages = [
                'required' => 'Поле обезательно к заполнению',
                'email' => 'Поле должно быть email аддресом'

            ];
            self::validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'
            ], $messages);

            $data = $request->all();

            $res = Mail::send('site.mail', ['data' => $data], function($message) use ($data){
                $mail_admin = env('MAIL_ADMIN');

                $message->from($data['email'], $data['name']);
                $message->to($mail_admin)->subject('Question');

            });
            if($res){
                return redirect()->route('home')->with('status', 'Email is send');
            }
        }
        $pages = Page::all();
        $peoples = People::all();
        $services = Service::all();
        $portfolios = Portfolio::get(array('name', 'filter', 'img'));

        //выбор уникальных значений столбца filter(lists - устарел)
        $tags = DB::table('portfolios')->distinct()->pluck('filter');

       // dd($tags);

        $menu = array();
        foreach($pages as $page){
            $item = array('title'=>$page->name, 'alias'=>$page->alias);
            array_push($menu, $item);
        }

        $item = array('title'=>'Services', 'alias'=>'service');
        array_push($menu, $item);

        $item = array('title'=>'Portfolio', 'alias'=>'Portfolio');
        array_push($menu, $item);

        $item = array('title'=>'Team', 'alias'=>'team');
        array_push($menu, $item);

        $item = array('title'=>'Contact', 'alias'=>'contact');
        array_push($menu, $item);

        return view('site.index', array(
            'menu' => $menu,
            'pages' => $pages,
            'services' => $services,
            'portfolios' => $portfolios,
            'peoples' => $peoples,
            'tags' => $tags,
        ));
    }
}
