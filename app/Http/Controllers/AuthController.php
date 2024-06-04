<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
   public function index() {
   		return view('auth.login');
   }

   public function login(Request $request)
   {
       $validasi = $request->validate([
           'email' => ['required', 'email'],
           'password' => ['required'],
       ]);
   
       $credentials = $request->only('email', 'password');
   
       if (Auth::attempt($credentials)) {
            return redirect('router');
       }
   
       return response()->json([
           'status' => false,
           'message' => "Fail"
       ]);
   
       // Jika autentikasi gagal, arahkan kembali ke halaman login
       return redirect('login');
   }


   public function loginAuth(Request $request)
   {
       $request->validate([
           'ip' => 'required',
           'user' => 'required',
           'password' => 'required', // tambahkan validasi password
       ]);
   
       $ip = $request->post('ip');
       $user = $request->post('user');
       $pass = $request->post('password');
   
       // Simpan data dalam session
       $request->session()->put('ip', $ip);
       $request->session()->put('user', $user);
       $request->session()->put('pass', $pass);
   
       return redirect('dashboard');
   }
   


   public function logout(Request $request) {

      Auth::logout();

   		$request->session()->forget('ip');
   		$request->session()->forget('user');
   		$request->session()->forget('pass');
        $request->session()->invalidate();

   		return redirect('/login');
   }

}
