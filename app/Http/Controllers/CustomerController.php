<?php

namespace App\Http\Controllers;

use App\Models\Order_summary;
use App\Models\Shipping;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customer(){
        return view('frontend.customer.login');
    }
    public function customerregister(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'captcha' => 'required|captcha'
        ]);


        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer',
            'created_at' => Carbon::now(),
        ]);
        return back()->with([
            'success' => 'Registration Successfull! Please Login!',
            'email'=> $request->email,
        ]);
    }
    public function customerdashboard ()
    {
        $orders = Order_summary::where('user_id', auth()->id())->get();
        return view('frontend.customer.dashboard', compact('orders'));
    }
    public function reloadcaptcha ()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}

