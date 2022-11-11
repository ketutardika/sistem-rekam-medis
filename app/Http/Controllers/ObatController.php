<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Imports\ObatImport;
use App\Exports\ObatExport;
use App\Obat;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use PDF;

class ObatController extends Controller
{
    public function index () 
    {    
        $metadatas = ambil_satudata('metadata',4);
        $obats = ambil_semuadata('obat');
        return view('obat',['obats'=> $obats],['metadatas'=>$metadatas]);   
    }
    
        public function tambah_obat () 
    {    
        $metadatas = ambil_satudata('metadata',5);
        return view('tambah-obat',['metadatas'=>$metadatas]); 
    }

    public function import()
    {
        $obat = new ObatImport;
        $buka=route('obat');
        $pesan='Data Obat berhasil Di Import';
        Excel::import(new $obat, request()->file('file'));
        if ($obat->getRowCount()==0)
        {
            return redirect($buka)->with('pesan','Data Excel Ada Kesalahan'); 
        }
        else{
            \LogActivity::addToLog('Pengguna Import Data Obat');
            return redirect($buka)->with('pesan',$pesan); 
        }
        
    }

    public function export()
    {
        \LogActivity::addToLog('Pengguna Export Data Obat');
        return Excel::download(new ObatExport, 'Data-Obat-'. date("Y-m-d H:i:s") .'.xlsx');
    }

    public function cetak_pdf()
    {
        $obats = ambil_semuadata('obat');
        $date= date("Y-m-d H:i:s");
        $pdf = PDF::loadview('cetakobat', compact('obats'));
        \LogActivity::addToLog('Pengguna Cetak PDF Data Obat');
        return $pdf->stream('data-rekap-obat-'.$date.'.pdf', array('Attachment' => 0));
    }

    public function obat_print()
    {
        $obats = ambil_semuadata('obat');
        \LogActivity::addToLog('Pengguna Cetak Print Data Obat');
        return view('cetakobat', compact('obats'));
    }
 
    
       public function simpan_obat(Request $request)
    { 
        $this->validate($request, [
            'n_obat' => 'required|min:4|max:25',
            'sediaan' => 'required',
            'dosis' => 'required|numeric|digits_between:1,7',
            'satuan' => 'required',
            'harga' => 'required|numeric|digits_between:1,7',
            'stok' => 'required|numeric|digits_between:1,5'
        ]);
        DB::table('obat')->insert([
            'nama_obat' => $request->n_obat,
            'sediaan' => $request->sediaan,
            'dosis' => $request->dosis,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'created_time' => Carbon::now(),
            'updated_time' => Carbon::now(),
        ]);
           $ids= DB::table('obat')->orderby('id','desc')->first();         
            switch($request->simpan) {
                case 'simpan': 
                    $buka=route('obat.edit',$ids->id);
                    $pesan='Data obat berhasil disimpan!';
                break;             
                case 'simpan_baru': 
                    $buka=route('obat.tambah');
                    $pesan='Data obat berhasil disimpan!';
                break;
            }
        \LogActivity::addToLog('Pengguna Menambah Data Obat ID: '.$request->n_obat);
        return redirect($buka)->with('pesan',$pesan);
    }
     //Proses Update Pasien
        public function update_obat(Request $request)
    {
            $this->validate($request, [
                'n_obat' => 'required|min:4|max:25',
                'sediaan' => 'required',
                'dosis' => 'required|numeric|digits_between:1,7',
                'satuan' => 'required',
                'harga' => 'required|numeric|digits_between:1,7',
                'stok' => 'required|numeric|digits_between:1,5'
            ]);
            
            DB::table('obat')->where('id',$request->id)->update([
                'nama_obat' => $request->n_obat,
                'sediaan' => $request->sediaan,
                'dosis' => $request->dosis,
                'satuan' => $request->satuan,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'updated_time' => Carbon::now()
            ]);
     
            switch($request->simpan) {
                 case 'simpan': 
                    $buka='/obat/edit/' . $request->id;
                    $pesan='Data pasien berhasil disimpan!';
                break;           
                case 'simpan_baru': 
                    $buka='/obat/tambah';
                    $pesan='Data pasien berhasil disimpan!';
                break;
            }
        \LogActivity::addToLog('Pengguna Mengubah Data Obat ID: '.$request->n_obat);
        return redirect($buka)->with('pesan',$pesan);
    }
    
    public function edit_obat($id)
    {
        $metadatas = ambil_satudata('metadata',6);
        $datas= ambil_satudata('obat',$id);
        if ($datas->count() <= 0) {
            return abort(404, 'Halaman Tidak Ditemukan.');
        }
        return view('edit-obat',['metadatas'=>$metadatas],['datas'=>$datas]);
    }
    
    public function hapus_obat($id)
    {
        DB::table('obat')->where('id',$id)->update([
            'deleted' => 1,
        ]);
        $pesan="Data obat berhasil dihapus!";
        \LogActivity::addToLog('Pengguna Menghapus Data Obat ID : '.$id);
        return redirect(route("obat"))->with('pesan',$pesan);
    }
}
