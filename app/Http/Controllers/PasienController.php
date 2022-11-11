<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PasienImport;
use App\Pasien;
use App\Exports\PasienExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use PDF;

class PasienController extends Controller
{
    //Halaman Utama Pasien
    public function index()
    {
        $metadatas = ambil_satudata('metadata',1);
        $pasiens = ambil_semuadata('pasien');
        return view('pasien',['pasiens'=> $pasiens],['metadatas'=>$metadatas]);
    }

     public function importData()
    {
        $metadatas = ambil_satudata('metadata',1);
        $pasiens = ambil_semuadata('pasien');
        \LogActivity::addToLog('Pengguna Import Data Pasien');
        return view('pasien',['pasiens'=> $pasiens],['metadatas'=>$metadatas]);
    }

    public function ajax_create()
    {
      return view('tambah-pasien');
    }

    public function ajax_store(Request $request)
    {
        $datarequest = $request->pcs;
        $noUrutAkhir = \DB::table('pasien')->where('deleted','=',0)
          ->select(\DB::raw('max(RIGHT(no_pasien, 3)) as no_pasien'))          
          ->where('jenis_asuransi',$datarequest)
          ->get();

        foreach ($noUrutAkhir as $noUru) {
             $idsa = $noUru->no_pasien;
        }

        if (!empty($idsa)){
            $noUrus = $idsa+1;
        }
        else{
            $noUrus = 0001;
        }

        if ($datarequest == 'BPJS'){
            $datarequest ='BP';
        }
        else{
            $datarequest='UM';
        }
        $AWAL = 'PS';
        $no = 1;
        $nomer = $AWAL .'' .$datarequest. '' .sprintf("%03s", $noUrus);

        #create or update your data here
        return $nomer;
    }

    public function import()
    {
        $pasien = new PasienImport;
        $buka=route('pasien');
        $pesan='Data pasien berhasil Di Import';
        Excel::import(new $pasien, request()->file('file'));
        if ($pasien->getRowCount()==0)
        {
            return redirect($buka)->with('pesan','Data Excel Ada Kesalahan'); 
        }
        else{
            \LogActivity::addToLog('Pengguna Import Data Pasien');
            return redirect($buka)->with('pesan',$pesan); 
        }
        
    }

    public function export()
    {
        \LogActivity::addToLog('Pengguna Export Data Pasien');
        return Excel::download(new PasienExport, 'Data-Pasien-'. date("Y-m-d H:i:s") .'.xlsx');
    }

    public function cetak_pdf()
    {
        $idens = ambil_semuadata('pasien');
        $date= date("Y-m-d H:i:s");
        $pdf = PDF::loadview('cetakpasien', compact('idens'))->setPaper('a4', 'landscape');
        \LogActivity::addToLog('Pengguna Cetak PDF Data Pasien');
        return $pdf->stream('data-rekap-pasien-'.$date.'.pdf', array('Attachment' => 0));
    }

    public function pasien_print()
    {
        $idens = ambil_semuadata('pasien');
        \LogActivity::addToLog('Pengguna Cetak Print Data Pasien');
        return view('cetakpasien', compact('idens'));
    }



    //Halaman tambah pasien baru
    public function tambah_pasien()
    {
        $metadatas = ambil_satudata('metadata',2);
        return view('tambah-pasien',['metadatas'=>$metadatas]);
    }
    
    //Hallaman Edit Pasien
        public function edit_pasien($id)
    {
        $metadatas = ambil_satudata('metadata',3);
        $datas= ambil_satudata('pasien',$id);
        if ($datas->count() <= 0) {
            return abort(404, 'Halaman Tidak Ditemukan.');
        }
        return view('edit-pasien',['metadatas'=>$metadatas],['datas'=>$datas]);
    }
    
    
    //Proses menyimpan pasien baru
    public function simpan_pasien(Request $request)
    { 
        $this->validate($request, [
            'Nama_Lengkap' => 'required|min:3|max:35',
            'Tanggal_Lahir' => 'required|before:today',
            'Alamat' => 'required',
            'Pekerjaan' => 'nullable',
            'no_handphone' => 'nullable|numeric',
            'Jenis_Kelamin' => 'nullable',
            'no_bpjs' => 'nullable|numeric|digits_between:1,25'
        ]);
        DB::table('pasien')->insert([
            'no_pasien' => $request->no_pasien,
            'nama' => $request->Nama_Lengkap,
            'tgl_lhr' => $request->Tanggal_Lahir,
            'alamat' => $request->Alamat,
            'pekerjaan' => $request->Pekerjaan,
            'hp' => $request->no_handphone,
            'jk' => $request->Jenis_Kelamin,
            'pendidikan' => $request->Pendidikan_terakhir,
            'jenis_asuransi' => $request->Jenis_Asuransi,
            'no_bpjs' => $request->no_bpjs,
            'alergi' => $request ->alergi,
            'created_time' => Carbon::now(),
            'updated_time' => Carbon::now(),
        ]);
           $ids= DB::table('pasien')->latest('created_time')->first();         
            switch($request->simpan) {
                case 'simpan': 
                    $buka=route('pasien.edit', $ids->id);
                    $pesan='Data pasien berhasil disimpan!';
                break;
                case 'simpan_rm': 
                    $buka=route('rm.list',$ids->id);
                    $pesan='Data pasien berhasil disimpan!';
                break;              
                case 'simpan_baru': 
                    $buka=route('pasien.tambah');
                    $pesan='Data pasien berhasil disimpan!';
                break;
            }
        \LogActivity::addToLog('Pengguna menambah Data Pasien');
        return redirect($buka)->with('pesan',$pesan);
    }
    
        //Proses Update Pasien
        public function update_pasien(Request $request)
    {
            $this->validate($request, [
                'Nama_Lengkap' => 'required|min:3|max:35',
                'Tanggal_Lahir' => 'required|before:today',
                'Alamat' => 'required',
                'Pekerjaan' => 'nullable',
                'no_handphone' => 'nullable|numeric',
                'Jenis_Kelamin' => 'nullable',
                'no_bpjs' => 'nullable|numeric|digits_between:1,25'
            ]);
            
            DB::table('pasien')->where('id',$request->id)->update([
                'no_pasien' => $request->no_pasien,
                'nama' => $request->Nama_Lengkap,
                'tgl_lhr' => $request->Tanggal_Lahir,
                'alamat' => $request->Alamat,
                'pekerjaan' => $request->Pekerjaan,
                'pendidikan' => $request->Pendidikan_terakhir,
                'hp' => $request->no_handphone,
                'jk' => $request->Jenis_Kelamin,
                'jenis_asuransi' => $request->Jenis_Asuransi,
                'no_bpjs' => $request->no_bpjs,
                'tb' => $request ->tb,
                'bb' => $request ->bb,
                'lp' => $request ->lp,
                'imt' => $request ->imt,
                'stole' => $request ->stole,
                'dtole' => $request ->dtole,
                'rr' => $request ->rr,
                'hr' => $request ->hr,
                'updated_time' => Carbon::now(),
            ]);
     
            switch($request->simpan) {
                 case 'simpan': 
                    $buka=route('pasien.edit', $request->id);
                    $pesan='Data pasien berhasil disimpan!';
                break;
                case 'simpan_rm': 
                    $buka=route('rm.list',$request->id);
                    $pesan='Data pasien berhasil disimpan!';
                break;              
                case 'simpan_baru': 
                    $buka=route('pasien.tambah');
                    $pesan='Data pasien berhasil disimpan!';
                break;
            }
        \LogActivity::addToLog('Pengguna Mengubah Data Pasien ID : '.$request->id);
        return redirect($buka)->with('pesan',$pesan);
    }
    
        public function hapus_pasien($id)
    {
        DB::table('pasien')->where('id',$id)->update([
            'deleted' => 1,
        ]);
        $pesan="Data pasien berhasil dihapus!";
        \LogActivity::addToLog('Pengguna Menghapus Data Pasien ID: '.$id);
        return redirect(route("pasien"))->with('pesan',$pesan);
    }
    
}