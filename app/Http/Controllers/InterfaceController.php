<?php

namespace App\Http\Controllers;

use App\Models\RouterosAPI;
use Illuminate\Http\Request;

class InterfaceController extends Controller
{
    public function interface()
	{
		$ip = session()->get('ip');
		$user = session()->get('user');
		$pass = session()->get('pass');
		$API = new RouterosAPI();
		$API->debug = false;

		if ($API->connect($ip, $user, $pass)) {

			$interface = $API->comm('/interface/print');

			$data = [
				'menu' => 'Ethernet',
				'interface' => $interface,
			];

            return view('interface', $data);

		} else {
            return redirect('failed');
		}
	}


    public function traffic($interface)
	{
		$ip = session()->get('ip');
		$user = session()->get('user');
		$pass = session()->get('pass');
		$API = new RouterosAPI();
		$API->debug = false;

		if ($API->connect($ip, $user, $pass)) {

			$getinterfacetraffic = $API->comm("/interface/monitor-traffic", array(
				"interface" => $interface,
				"once" => "",
			));
			$ftx = $getinterfacetraffic[0]['tx-bits-per-second'];
			$frx = $getinterfacetraffic[0]['rx-bits-per-second'];

			$rows['name'] = 'Tx';
			$rows['data'][] = $ftx;
			$rows2['name'] = 'Rx';
			$rows2['data'][] = $frx;
			$result = array();

			array_push($result, $rows);
			array_push($result, $rows2);
			print json_encode($result);

		} else {
			echo "<font color='#ff0000'>Connection Failed!!</font>";
		}

		$API->disconnect();
	}
}
