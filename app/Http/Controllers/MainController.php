<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\User;
use Cache;

class MainController extends Controller
{
    public function index() {
        $metadatas = ambil_satudata('metadata',17);
        $jumlah['pasien']=DB::table('pasien')->where('deleted','0')->count();
        $jumlah['kunjungan']=DB::table('rm')->where('deleted','0')->count();
        $jumlah['lab']=DB::table('lab')->where('deleted','0')->count();
        $jumlah['obat']=DB::table('obat')->where('deleted','0')->count();
        $pasiens = ambil_semuadata('pasien');
        $labs= ambil_semuadata('lab');
        $rms = ambil_semuadata('rm');
        $obats= ambil_semuadata('obat');
        $warning=cek_stok_warning (10); 
        $users= ambil_semuadata('users');
        $counter = 0;
        foreach ($users as $user) {
            if (Cache::has('is_online' . $user->id)) {
                $counter++;   
            }
        }
        $jumlah['login'] = $counter;
        $jumlah['ip'] = \Request::ip();
        $jumlah['agent'] = \Request::server('HTTP_USER_AGENT');

        return view('index',compact('metadatas','jumlah','pasiens','labs','rms','obats','warning','users'));
    }
}
