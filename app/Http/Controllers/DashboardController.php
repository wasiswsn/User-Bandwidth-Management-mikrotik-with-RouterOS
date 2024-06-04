<?php

namespace App\Http\Controllers;
use App\Models\RouterosAPI;
use App\Models\Transaksi;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
    	$API = new RouterosAPI();
    	$API->debug('false');

    	if($API->connect($ip, $user, $pass)){
    		$address = $API ->comm('/ip/address/print');
            $hotspotuser = $API->comm('/ip/hotspot/user/print');
            $hotspotprofile = $API->comm('/ip/hotspot/user/profile/print');
            $resource = $API->comm('/system/resource/print');
            $interface = $API->comm('/interface/ethernet/print');
            $routerboard = $API->comm('/system/routerboard/print');
            $identity = $API->comm('/system/identity/print');

    	}else{
           return redirect('router') -> with('alert','Tidak Dapat Terhubung');
    	}

    	$data = [
    		'totalhotspotuser' => count($hotspotuser),
            'totalhotspotprofile' => count($hotspotprofile),
    		'address' => $address [0]['address'],
    		'network' => $address [0]['network'],
    		'interface' => $address [0]['interface'],
            'cpu' => $resource[0]['cpu-load'],
            'uptime' => $resource[0]['uptime'],
            'version' => $resource[0]['version'],
            'interface' => $interface,
            'boardname' => $resource[0]['board-name'],
            'freememory' => $resource[0]['free-memory'],
            'freehdd' => $resource[0]['free-hdd-space'],
            'model' => $routerboard[0]['model'],
            'identity' => $identity[0]['name'],
    	]; 

    // Total transaksi
        
        $transactions = transaksi::where('status',['Paid'])->get();
        $totalPrice = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->User->username == auth()->user()->username) {
                $totalPrice += $transaction->price;
            }
           
        }

        $transaksiMitra = pemesanan::where('status',['Selesai'])->get();
        $total = 0;

        foreach ($transaksiMitra as $transaksi) {
            if (Auth::check() && Auth::user()->level == 'admin') {
                $total += $transaksi->total;
            }
            elseif ($transaksi->User->username == auth()->user()->username) {
                $total += $transaksi->total;
            }
           
        }

    	// dd($user);

    	return view('dashboard', $data)
        ->with('totalPrice', $totalPrice)
        ->with('total', $total);
    }

     public function cpu()
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {

            $resource = $API->comm('/system/resource/print');

            $data = [
                'cpu' => $resource['0']['cpu-load'],
            ];

            return view('realtime.status', $data);
        } else {

            return view('failed');
        }
    }

    public function uptime()
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {

            $uptime = $API->comm('/system/resource/print');

            $data = [
                'uptime' => $uptime['0']['uptime'],
            ];

            return view('realtime.uptime', $data);
        } else {

            return view('failed');
        }
    }




    public function traffic_special($traffic)
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {
            $traffic = $API->comm('/interface/monitor-traffic', array(
                'interface' => $traffic,
                'once' => '',
            ));

            $rx = $traffic[0]['rx-bits-per-second'];
            $tx = $traffic[0]['tx-bits-per-second'];

            $data = [
                'rx' => $rx,
                'tx' => $tx,
            ];

            return response()->json($data);
        } else {

            return view('failed');
        }
    }

    public function traffic($traffic)
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {
            $traffic = $API->comm('/interface/monitor-traffic', array(
                'interface' => $traffic,
                'once' => '',
            ));

            $rx = $traffic[0]['rx-bits-per-second'];
            $tx = $traffic[0]['tx-bits-per-second'];

            $data = [
                'rx' => $rx,
                'tx' => $tx,
            ];


            return view('realtime.traffic', $data);
        } else {

            return view('failed');
        }
    }


    public function load()
    {
        $data = Report::orderBy('created_at', 'desc')->limit('2')->get();

        return view('realtime.load', compact('data'));
    }


}
error_reporting(0);
