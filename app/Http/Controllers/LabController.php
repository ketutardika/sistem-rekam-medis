<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Imports\LabImport;
use App\Exports\LabExport;
use App\Lab;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use PDF;

class LabController extends Controller
{
    public function index () 
    {    
        $metadatas = ambil_satudata('metadata',7);
        $labs = ambil_semuadata('lab');
        return view('lab',['labs'=> $labs],['metadatas'=>$metadatas]);   
    }
    
        public function tambah_lab () 
    {    
        $metadatas = ambil_satudata('metadata',8);
        return view('tambah-lab',['metadatas'=>$metadatas]);   
    }

    public function import()
    {
        $lab = new LabImport;
        $buka=route('lab');
        $pesan='Data Lab berhasil Di Import';
        Excel::import(new $lab, request()->file('file'));
        if ($lab->getRowCount()==0)
        {
            return redirect($buka)->with('pesan','Data Excel Ada Kesalahan'); 
        }
        else{
            \LogActivity::addToLog('Pengguna Import Data Lab');
            return redirect($buka)->with('pesan',$pesan); 
        }
        
    }

    public function export()
    {   
        \LogActivity::addToLog('Pengguna Export Data Lab');
        return Excel::download(new LabExport, 'Data-Lab-'. date("Y-m-d H:i:s") .'.xlsx');
    }

    public function cetak_pdf()
    {
        $labs = ambil_semuadata('lab');
        $date= date("Y-m-d H:i:s");
        $pdf = PDF::loadview('cetaklab', compact('labs'));
        \LogActivity::addToLog('Pengguna Cetak PDF Data Lab');
        return $pdf->stream('data-rekap-lab-'.$date.'.pdf', array('Attachment' => 0));
    }

    public function lab_print()
    {
        $labs = ambil_semuadata('lab');
        \LogActivity::addToLog('Pengguna Cetak Print Data Lab');
        return view('cetaklab', compact('labs'));
    }
 
    
       public function simpan_lab(Request $request)
    { 
        $this->validate($request, [
            'nama_lab' => 'required|min:4|max:25',
            'harga' => 'required|numeric|digits_between:1,7',
            'satuan' => 'required|max:10',
        ]);
        DB::table('lab')->insert([
            'nama' => $request->nama_lab,
            'harga' => $request->harga,
            'satuan' => $request->satuan,
            'created_time' => Carbon::now(),
            'updated_time' => Carbon::now(),
        ]);
           $ids= DB::table('lab')->orderby('id','desc')->first();         
            switch($request->simpan) {
                case 'simpan': 
                    $buka=route('lab.edit', $ids->id);
                    $pesan='Data lab berhasil disimpan!';
                break;             
                case 'simpan_baru': 
                    $buka=route('lab.tambah');
                    $pesan='Data lab berhasil disimpan!';
                break;
            }
        \LogActivity::addToLog('Pengguna Menambah Data Lab');
        return redirect($buka)->with('pesan',$pesan);
    }
    
        //Proses Update Pasien
        public function update_lab(Request $request)
    {
            $this->validate($request, [
                'nama_lab' => 'required|min:4|max:25',
                'harga' => 'required|numeric|digits_between:1,7',
                'satuan' => 'required|max:10',
            ]);
            
            DB::table('lab')->where('id',$request->id)->update([
                'nama' => $request->nama_lab,
                'harga' => $request->harga,
                'satuan' => $request->satuan,
                'updated_time' => Carbon::now()
            ]);
     
            switch($request->simpan) {
                 case 'simpan': 
                    $buka=route('lab.edit',$request->id);
                    $pesan='Data pasien berhasil disimpan!';
                break;           
                case 'simpan_baru': 
                    $buka=route('lab.tambah');
                    $pesan='Data pasien berhasil disimpan!';
                break;
            }
        \LogActivity::addToLog('Pengguna Mengubah Data Lab ID: '.$request->id);
        return redirect($buka)->with('pesan',$pesan);
    }
    
    public function edit_lab($id)
    {
        $metadatas = ambil_satudata('metadata',9);
        $datas= ambil_satudata('lab',$id);
        if ($datas->count() <= 0) {
            return abort(404, 'Halaman Tidak Ditemukan.');
        }
        return view('edit-lab',['metadatas'=>$metadatas],['datas'=>$datas]);
    }
    
    public function hapus_lab($id)
    {
        DB::table('lab')->where('id',$id)->update([
            'deleted' => 1,
        ]);
        $pesan="Data lab berhasil dihapus!";
        \LogActivity::addToLog('Pengguna Menghapus Data Lab ID: '.$id);
        return redirect(route("lab"))->with('pesan',$pesan);
    }
}
