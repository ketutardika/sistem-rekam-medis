<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Imports\DiagnosaImport;
use App\Exports\DiagnosaExport;
use App\Diagnosa;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Datatables;
use PDF;

class DiagnosaController extends Controller
{
    public function index () 
    {    
        $metadatas = ambil_satudata('metadata',22);
        $diagnosas = ambil_semuadata('diagnosa');
        return view('diagnosa',['diagnosas'=> $diagnosas],['metadatas'=>$metadatas]);   
    }
    
    public function tambah_diagnosa () 
    {    
        $metadatas = ambil_satudata('metadata',22);
        return view('tambah-diagnosa',['metadatas'=>$metadatas]);   
    }

    public function datajson()
    {
        $disgnosas = Diagnosa::select(['id', 'kode_diagnosa', 'nama_diagnosa']);
        return Datatables::of($disgnosas)
        ->addIndexColumn()
        ->addColumn('tindakan', function($disgnosas){
                    $actionBtn = '<a href="'.route('diagnosa.edit',$disgnosas->id).'" class="btn btn-sm btn-icon-split btn-warning">
                            <span class="icon"><i class="fa fa-pen" style="padding-top: 4px;"></i></span><span class="text">Edit</span>
                        </a>';
                    return $actionBtn;
                })
        ->rawColumns(['tindakan'])
        ->make(true);
    }

    public function import()
    {
        $diagnosa = new DiagnosaImport;
        $buka=route('diagnosa');
        $pesan='Data Diagnosa berhasil Di Import';
        Excel::import(new $diagnosa, request()->file('file'));
        if ($diagnosa->getRowCount()==0)
        {
            return redirect($buka)->with('pesan','Data Excel Ada Kesalahan'); 
        }
        else{
            \LogActivity::addToLog('Pengguna Import Data Diagnosa');
            return redirect($buka)->with('pesan',$pesan); 
        }
        
    }

    public function export()
    {
        \LogActivity::addToLog('Pengguna Export Data Diagnosa');
        return Excel::download(new DiagnosaExport, 'Data-Diagnosa-'. date("Y-m-d H:i:s") .'.xlsx');
    }

    public function cetak_pdf()
    {
        $diagnosa = ambil_semuadata('diagnosa');
        $date= date("Y-m-d H:i:s");
        $pdf = PDF::loadview('cetakdiagnosa', compact('diagnosa'));
        \LogActivity::addToLog('Pengguna Cetak PDF Data Diagnosa');
        return $pdf->stream('data-rekap-diagnosa-'.$date.'.pdf', array('Attachment' => 0));
    }

    public function diagnosa_print()
    {
        $diagnosa = ambil_semuadata('diagnosa');
        \LogActivity::addToLog('Pengguna Cetak Print Data Diagnosa');
        return view('cetakdiagnosa', compact('diagnosa'));
    }

    
       public function simpan_diagnosa(Request $request)
    { 
        $this->validate($request, [
            'kode_diagnosa' => 'required|min:2|max:25',
            'nama_diagnosa' => 'required|min:2|max:25',
        ]);
        DB::table('diagnosa')->insert([
            'kode_diagnosa' => $request->kode_diagnosa,
            'nama_diagnosa' => $request->nama_diagnosa,
            'keterangan' => $request->keterangan,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
           $ids= DB::table('diagnosa')->orderby('id','desc')->first();         
            switch($request->simpan) {
                case 'simpan': 
                    $buka=route('diagnosa.edit', $ids->id);
                    $pesan='Data diagnosa berhasil disimpan!';
                break;             
                case 'simpan_baru': 
                    $buka=route('diagnosa.tambah');
                    $pesan='Data diagnosa berhasil disimpan!';
                break;
            }
         \LogActivity::addToLog('Pengguna Menambah Data Diagnosa');
        return redirect($buka)->with('pesan',$pesan);
    }
    
        //Proses Update Pasien
        public function update_diagnosa(Request $request)
    {
            $this->validate($request, [
                'kode_diagnosa' => 'required|min:2|max:25',
            ]);
            
            DB::table('diagnosa')->where('id',$request->id)->update([
                'kode_diagnosa' => $request->kode_diagnosa,
                'nama_diagnosa' => $request->nama_diagnosa,
                'keterangan' => $request->keterangan,
                'updated_at' => Carbon::now()
            ]);
     
            switch($request->simpan) {
                 case 'simpan': 
                    $buka=route('diagnosa.edit',$request->id);
                    $pesan='Data pasien berhasil disimpan!';
                break;           
                case 'simpan_baru': 
                    $buka=route('diagnosa.tambah');
                    $pesan='Data pasien berhasil disimpan!';
                break;
            }
         \LogActivity::addToLog('Pengguna Mengubah Data Diagnosa ID: '.$request->id);
        return redirect($buka)->with('pesan',$pesan);
    }
    
    public function edit_diagnosa($id)
    {
        $metadatas = ambil_satudata('metadata',22);
        $datas= ambil_satudata('diagnosa',$id);
        if ($datas->count() <= 0) {
            return abort(404, 'Halaman Tidak Ditemukan.');
        }
        return view('edit-diagnosa',['metadatas'=>$metadatas],['datas'=>$datas]);
    }
    
    public function hapus_diagnosa($id)
    {
        DB::table('diagnosa')->where('id',$id)->update([
            'deleted' => 1,
        ]);
        $pesan="Data diagnosa berhasil dihapus!";
        \LogActivity::addToLog('Pengguna Hapus Data Diagnosa ID: '.$id);
        return redirect(route("diagnosa"))->with('pesan',$pesan);
    }
}
