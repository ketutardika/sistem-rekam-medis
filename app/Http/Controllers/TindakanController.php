<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Imports\TindakanImport;
use App\Exports\TindakanExport;
use App\Tindakan;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use PDF;

class TindakanController extends Controller
{
    public function index () 
    {    
        $metadatas = ambil_satudata('metadata',21);
        $tindakans = ambil_semuadata('tindakan');
        return view('tindakan',['tindakans'=> $tindakans],['metadatas'=>$metadatas]);   
    }
    
        public function tambah_tindakan () 
    {    
        $metadatas = ambil_satudata('metadata',21);        
        $AWAL = 'TND';
        $noUrutAkhir = \DB::table('tindakan')->where('deleted','=',0)
          ->select(\DB::raw('max(RIGHT(no_tindakan, 3)) as no_tindakan'))
          ->get();

        foreach ($noUrutAkhir as $noUru) {
             $idsa = $noUru->no_tindakan;
        }
        if (!empty($idsa)){
            $noUrus = $idsa+1;
        }
        else{
            $noUrus = 0001;
        }

        $nomertdk = $AWAL .'-'.sprintf("%03s", $noUrus);
        return view('tambah-tindakan',compact('metadatas','nomertdk'));
    }

    public function import()
    {
        $tindakans = new TindakanImport;
        $buka=route('tindakan');
        $pesan='Data Tindakan berhasil Di Import';
        Excel::import(new $tindakans, request()->file('file'));
        if ($tindakans->getRowCount()==0)
        {
            return redirect($buka)->with('pesan','Data Excel Ada Kesalahan'); 
        }
        else{
            \LogActivity::addToLog('Pengguna Import Data Tindakan');
            return redirect($buka)->with('pesan',$pesan); 
        }
        
    }

    public function export()
    {
        \LogActivity::addToLog('Pengguna Export Data Tindakan');
        return Excel::download(new TindakanExport, 'Data-Tindakan-'. date("Y-m-d H:i:s") .'.xlsx');
    }

    public function cetak_pdf()
    {
        $tindakans = ambil_semuadata('tindakan');
        $date= date("Y-m-d H:i:s");
        $pdf = PDF::loadview('cetaktindakan', compact('tindakans'));
        \LogActivity::addToLog('Pengguna Cetak PDF Data Tindakan');
        return $pdf->stream('data-rekap-tindakan-'.$date.'.pdf', array('Attachment' => 0));
    }

    public function tindakan_print()
    {
        $tindakans = ambil_semuadata('tindakan');
        \LogActivity::addToLog('Pengguna Cetak Print Data Tindakan');
        return view('cetaktindakan', compact('tindakans'));
    }
    
       public function simpan_tindakan(Request $request)
    { 
        $rupiah = $request->harga;
        $hargaclean = preg_replace('/\D/','', $rupiah);
        $this->validate($request, [
            'nama_tindakan' => 'required|min:4|max:25',
        ]);
        DB::table('tindakan')->insert([
            'no_tindakan' => $request->no_tindakan,
            'nama' => $request->nama_tindakan,
            'harga' => $hargaclean,
            'satuan' => $request->satuan,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
           $ids= DB::table('tindakan')->orderby('id','desc')->first();         
            switch($request->simpan) {
                case 'simpan': 
                    $buka=route('tindakan.edit', $ids->id);
                    $pesan='Data tindakan berhasil disimpan!';
                break;             
                case 'simpan_baru': 
                    $buka=route('tindakan.tambah');
                    $pesan='Data tindakan berhasil disimpan!';
                break;
            }
        \LogActivity::addToLog('Pengguna Tambah Data Tindakan ID: '.$request->no_tindakan);
        return redirect($buka)->with('pesan',$pesan);
    }
    
        //Proses Update Pasien
        public function update_tindakan(Request $request)
    {
            $this->validate($request, [
                'nama_tindakan' => 'required|min:4|max:25',
                'harga' => 'required|numeric|digits_between:1,7',
            ]);
            
            DB::table('tindakan')->where('id',$request->id)->update([
                'no_tindakan' => $request->no_tindakan,
                'nama' => $request->nama_tindakan,
                'harga' => $request->harga,
                'satuan' => $request->satuan,
                'updated_at' => Carbon::now()
            ]);
     
            switch($request->simpan) {
                 case 'simpan': 
                    $buka=route('tindakan.edit',$request->id);
                    $pesan='Data pasien berhasil disimpan!';
                break;           
                case 'simpan_baru': 
                    $buka=route('tindakan.tambah');
                    $pesan='Data pasien berhasil disimpan!';
                break;
            }
        \LogActivity::addToLog('Pengguna Mengubah Data Tindakan ID: '.$request->no_tindakan);
        return redirect($buka)->with('pesan',$pesan);
    }
    
    public function edit_tindakan($id)
    {
        $metadatas = ambil_satudata('metadata',21);
        $datas= ambil_satudata('tindakan',$id);
        if ($datas->count() <= 0) {
            return abort(404, 'Halaman Tidak Ditemukan.');
        }
        return view('edit-tindakan',['metadatas'=>$metadatas],['datas'=>$datas]);
    }
    
    public function hapus_tindakan($id)
    {
        DB::table('tindakan')->where('id',$id)->update([
            'deleted' => 1,
        ]);
        $pesan="Data tindakan berhasil dihapus!";
        \LogActivity::addToLog('Pengguna Hapus Data Tindakan ID: '.$id);
        return redirect(route("tindakan"))->with('pesan',$pesan);
    }
}
