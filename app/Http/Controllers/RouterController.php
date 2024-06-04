<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\RouterosAPI;
use App\Models\Router;
use App\Models\Pemesanan;

class RouterController extends Controller
{
    public function router(){

        session()->forget(['ip', 'user', 'pass']);
        // Ambil ID pengguna yang saat ini login
        $userId = Auth::id();
    
        // Periksa apakah pengguna memiliki level admin
        $userLevel = Auth::user()->level;
    
        if ($userLevel == 'admin') {
            // Jika pengguna memiliki level admin, ambil semua router
            $routers = Router::all();
        } else {
            // Jika tidak, ambil daftar router yang terkait dengan pengguna yang login
            $routers = Router::with('user:id,email')->where('user_id', $userId)->get();    
        }
    
        return view('router', ['datausers' => $routers]);    
    }

    public function addrouter(Request $request){
        // Validasi data yang diterima dari formulir
        $validasi = $request->validate([
            'address' => 'required',
            'username'=> 'required',
            'password' =>'required',
        ]);

        // Ambil ID pengguna yang saat ini login
        $userId = Auth::id();

        // Tambahkan user_id ke dalam array validasi
        $validasi['user_id'] = $userId;
        
        // Tambahkan mitra ke tabel pengguna
        try {
            router::create($validasi);
            return redirect('router')->with('success','Router berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect('router')->with('error','Gagal menambahkan Router: '.$e->getMessage());
        }
    }

    //Update
    public function ubah(Request $request, $id)
    {
        $item = router::find($id);
        $item->address = $request->address;
        $item->username = $request->username;
        // Periksa apakah password disediakan dalam permintaan
        if ($request->filled('password')) {
            // Enkripsi kata sandi sebelum menyimpannya ke dalam basis data
            $item->password = $request->password;
        }
        $item->save();

        return redirect('/router')->with('success', 'Data berhasil diubah');
    }

//delete
    public function deleteRouter($id){
        $item = router::find($id);
        $item->delete();

        return redirect('/router');
    }
}