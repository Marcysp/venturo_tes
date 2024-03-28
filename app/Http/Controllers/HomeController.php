<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request['tahun'];
        $menu = json_decode(file_get_contents('http://tes-web.landa.id/intermediate/menu'), true);
        $transaksi = json_decode(file_get_contents('http://tes-web.landa.id/intermediate/transaksi?tahun=' . $tahun), true);

        $totalPerMenu = [];
        $totalMenuPerBulan = [];

        if ($tahun != null) {
            foreach ($transaksi as $tr) {
                $tanggal = substr($tr['tanggal'], 5, 2);
                $bulan = ltrim($tanggal, '0');
                $namamenu = $tr['menu'];

                $totalPerMenu[$bulan][$namamenu] = ($totalPerMenu[$bulan][$namamenu] ?? 0) + $tr['total'];
                $totalMenuPerBulan[$bulan] = ($totalMenuPerBulan[$bulan] ?? 0) + $tr['total'];
            }
        }

        return view('home', [
            'menu' => $menu,
            'transaksi' => $transaksi,
            'tahun' => $tahun,
            'totalPerMenu' => $totalPerMenu,
            'totalMenuPerBulan' => $totalMenuPerBulan
        ]);
    }
}
