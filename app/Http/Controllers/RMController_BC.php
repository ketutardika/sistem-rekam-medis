<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use PDF;

class RMController extends Controller
{
    public function index() {
        $rms = ambil_semuadata('rm');
        $metadatas = ambil_satudata('metadata',12);
        return view('rm', compact('rms','metadatas'));
    }
    public function hapus_rm($id)
    {
        DB::table('rm')->where('id',$id)->update([
            'deleted' => 1,
        ]);
        $pesan="Data pasien berhasil dihapus!";
        \LogActivity::addToLog('Pengguna Menghapus Data RM ID: '.$id);
        return redirect ('rm')->with('pesan', $pesan);
    }
    public function update_rm(Request $request)
    {
        $this->validate($request, [
            'idpasien' => 'required|numeric|digits_between:1,4',
            'keluhan_utama' => 'required|max:400',
            'anamnesis' => 'required|max:1000',
            'dokter' => 'required',
        ]);
       // Decoding array input pemeriksaan lab
       if (isset($request->lab))
       {
            if (has_dupes(array_column($request->lab,'id'))){
                $errors = new MessageBag(['lab'=>['Lab yang sama tidak boleh dimasukan berulang']]);
                return back()->withErrors($errors);
            }


            $lab_id = decode('lab','id',$request->lab);
            $lab_hasil = decode('lab','hasil',$request->lab);
       }
       else {
        $lab_id ="";
        $lab_hasil ="";
       }

       // Decoding array input pemeriksaan Tindakan
       if (isset($request->tindakan))
       {
            if (has_dupes(array_column($request->tindakan,'id'))){
                $errors = new MessageBag(['tindakan'=>['tindakan yang sama tidak boleh dimasukan berulang']]);
                return back()->withErrors($errors);
            }
            $tindakan_id = decode('tindakan','id',$request->tindakan);
       }
       else {
        $tindakan_id ="";
       }

       // Decoding array input pemeriksaan Diagnosa
       if (isset($request->diagnosa))
       {
            if (has_dupes(array_column($request->diagnosa,'id'))){
                $errors = new MessageBag(['diagnosa'=>['diagnosa yang sama tidak boleh dimasukan berulang']]);
                return back()->withErrors($errors);
            }
            $diagnosa_id = decode('diagnosa','id',$request->diagnosa);
       }
       else {
        $diagnosa_id ="";
       }

       // Decoding array input resep
       if (isset($request->resep))
        {
            if (has_dupes(array_column($request->resep,'id'))){
                $errors = new MessageBag(['resep'=>['resep yang sama tidak boleh dimasukan berulang']]);
                return back()->withErrors($errors);
            }
            $this->validate($request, [
                'resep.*.jumlah' => 'required|numeric|digits_between:1,3',
                'resep.*.aturan' => 'required',
            ]);
            $resep_id = decode('resep','id',$request->resep);
            $resep_jumlah = decode('resep','jumlah',$request->resep);
            $resep_dosis = decode('resep','aturan',$request->resep); 
        }
        else {
            $resep_id = "";
            $resep_jumlah = "";
            $resep_dosis = "";
        }
        
        $newresep = array();

        $oldresep=array_combine(encode(get_value('rm',$request->id,'resep')),encode(get_value('rm',$request->id,'jumlah')));
        if ($request->resep != NULL){
        foreach ($request->resep as $resep){
            $newresep[$resep['id']] = $resep['jumlah'];
            
        }
        }
        else{
            $errors = new MessageBag(['resep'=>['resep tidak boleh kosong']]);
        }
        if (empty($oldresep)) {
            $resultanresep = resultan_resep($oldresep,$newresep);
        }
        else {$resultanresep=$newresep;}
        $errors = validasi_stok($resultanresep);
        if ($errors !== NULL) {
          return  back()->withErrors($errors);
        }
  
        foreach ($resultanresep as $key => $value) {
            $perintah=kurangi_stok($key,$value);
            if ($perintah === false) { $habis = array_push($habis,$key); }
        }
   
   
        DB::table('rm')->where('id',$request->id)->update([
            'idpasien' => $request->idpasien,
            'ku' => $request->keluhan_utama,
            'anamnesis' => $request->anamnesis,
            'pxfisik' => $request->px_fisik,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'lp' => $request->lp,
            'imt' => $request->imt,
            'stole' => $request->stole,
            'dtole' => $request->dtole,
            'rr' => $request->rr,
            'hr' => $request->hr,
            'tindakan' => $tindakan_id,
            'lab' => $lab_id,
            'hasil' => $lab_hasil,
            'diagnosa' => $diagnosa_id,
            'diagnosis' => $request->diagnosis,
            'resep' => $resep_id,
            'jumlah' => $resep_jumlah,
            'aturan' => $resep_dosis,
            'dokter' => $request->dokter,
            'updated_time' => Carbon::now(),
        ]);

        DB::table('pasien')->where('id',$request->idpasien)->update([
            'tb' => $request->tb,
            'bb' => $request->bb,
            'lp' => $request->lp,
            'imt' => $request->imt,
            'stole' => $request->stole,
            'dtole' => $request->dtole,
            'rr' => $request->rr,
            'hr' => $request->hr,
        ]);
           
            switch($request->simpan) {
                case 'simpan_edit': 
                    $buka=route('rm.edit',$request->id);
                    $pesan='Data Rekam Medis berhasil disimpan!';
                break;             
                case 'simpan_baru': 
                    $buka=route('rm.tambah.id',$request->idpasien);
                    $pesan='Data Rekam Medis berhasil disimpan!';
                break;
                case 'simpan_tagihan':
                    $buka=route('tagihan',$request->id);
                    $pesan='Data Rekam Medis berhasil disimpan!';
                break;
            }
         \LogActivity::addToLog('Pengguna Mengubah Data RM ID: '.$request->no_rm);
         return redirect($buka)->with('pesan',$pesan);        
        
    }
    //Hallaman Edit Pasien
    public function edit_rm($id)
    {
        // if (Auth::User()->admin !== 1) {
        //     if (Auth::User()->profesi !== "Dokter") {
        //         abort(403, 'Anda Tidak berhak Mengakses Halaman Ini.');
        //     }
        //     $dokters=DB::table('rm')->select('dokter')->where('id',$id)->get();;
        //     foreach ($dokters as $dokter) {            
        //         if (Auth::User()->id !== $dokter->dokter) {
        //         abort(403, 'Anda Tidak berhak Mengakses Halaman Ini.');
        //         }
        //     }
        // }
        
        $metadatas = ambil_satudata('metadata',13);
        $datas= ambil_satudata('rm',$id);
        if ($datas->count() <= 0) {
            return abort(404, 'Halaman Tidak Ditemukan.');
        }
        foreach ($datas as $data) {
            //mencari id pasien dari id RM
             if ($data->idpasien != NULL) {$idpasien = $data->idpasien;  $idens=DB::table('pasien')->where('id',$idpasien)->get();}
             if ($data->lab != NULL) {
                //mengcovert data lab di tabel RM kedalam arry
                $data->labhasil=array_combine(encode($data->lab),encode($data->hasil));
                $num['lab']=sizeof($data->labhasil);
             }
             else {
                $num['lab']=0;
             }

            $diagnosasa = $data->diagnosa;
            if ($diagnosasa != NULL) {
                $data->alldiagnosa=array_combine(encode($data->diagnosa),encode($data->diagnosa));
                $num['diagnosa']=sizeof($data->alldiagnosa);
             }           
             else {
                $num['diagnosa']=0;
             }

            $tindakansa = $data->tindakan;
            if ($tindakansa != NULL) {
                $data->alltindakan=array_combine(encode($data->tindakan),encode($data->tindakan));
                $num['tindakan']=sizeof($data->alltindakan);
            }           
            else {
                $num['tindakan']=0;
            }

             if ($data->resep != NULL) {
                $data->allresep=array_combine(encode($data->resep),encode($data->aturan));
                $data->jum=encode($data->jumlah);
                $num['resep']=sizeof($data->allresep);
             }
             else {
                $num['resep']=0;
             }
        }
        $dokters = DB::table('users')->where('profesi','Dokter')->where('deleted','<>',1)->get();
        $labs = ambil_semuadata('lab');
        $obats = ambil_semuadata('obat');
        $tindakans = ambil_semuadata('tindakan');
        $diagnosas = ambil_semuadata('diagnosa');
       
      return view('edit-rm',compact('metadatas','idens','datas','labs','obats','num','dokters','tindakans','diagnosas'));
    }
    
    public function list_rm($idpasien)
    {
        $metadatas = ambil_satudata('metadata',12);
        $idens = ambil_satudata('pasien',$idpasien);
        if ($idens->count() <= 0) {
            return abort(404, 'Halaman Tidak Ditemukan.');
        }
        $rms = DB::table('rm')->where('idpasien',$idpasien)->get();

        return view('list-rm',compact('metadatas','idens','rms'));

    }

    public function laporan_rm()
    {
        $rms = ambil_semuadatatgl('rm');
        $metadatas = ambil_satudata('metadata',19);
        return view('laporan-rm', compact('rms','metadatas'));  

    }

    public function cetak_pdf()
    {
        $rms = ambil_semuadatatgl('rm');
        $start_date = Carbon::parse(request()->start_date)->toDateString();
        $end_date = Carbon::parse(request()->end_date)->toDateString();
        $pdf = PDF::loadview('cetaklaporan-rm', compact('rms'));
        \LogActivity::addToLog('Pengguna Cetak Data Laporan RM');
        return $pdf->stream('laporan-data-pasien-'.$start_date.'-'.$end_date.'-web.pdf', array('Attachment' => 0));
    }

    function convert_customer_data_to_html(){
        $rms = ambil_semuadata('rm');
        $output = '
        <h3 align="center">Daftar Pegawai</h3>
        <table width="100%"" style="border-collapse: collapse; border: 0px;"">
        <tr>
        <th style="border: 1px solid; padding:12px;" width="15%">Nama</th>
        <th style="border: 1px solid; padding:12px;" width="15%">Alamat</th>
        <th style="border: 1px solid; padding:12px;" width="15%">Telepon</th>
        </tr>';
        foreach($rms as $rm){
        $output.='
        <tr>
        <td style="border: 1px solid; padding:12px;">'.$rm->id.'</td>
        <td style="border: 1px solid; padding:12px;">'.$rm->idpasien.'</td>
        <td style="border: 1px solid; padding:12px;">'.$rm->ku.'</td>
        </tr>';}
        $output.='</table>';
        return$output;}
    
    public function tambah_rm()
    {
        $metadatas = ambil_satudata('metadata',11);
        $pasiens = ambil_semuadata('pasien');
        $diagnosas = ambil_semuadata('diagnosa');
        $obats = ambil_semuadata('obat');
        $cont=[
          'aria'=>'true',
          'show'=>'show',
          'col'=>''  
        ];
        return view('tambah-rm',compact('metadatas','pasiens','cont','diagnosas','obats'));  
    }
    
        public function tambah_rmid($idpasien)
    {
        $metadatas = ambil_satudata('metadata',11);
        $pasiens = ambil_semuadata('pasien');
        $idens = ambil_satudata('pasien',$idpasien);
        $labs = ambil_semuadata('lab');
        $tindakans = ambil_semuadata('tindakan');
        $diagnosas = ambil_semuadata('diagnosa');
        $obats = ambil_semuadata('obat');
        $dokters = DB::table('users')->where('profesi','Dokter')->where('deleted','<>',1)->get();
        $cont=[
          'aria'=>'false',
          'show'=>'',
          'col'=>'collapsed'  
        ];
        $AWAL = 'RM';
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $noUrutAkhir = \DB::table('rm')->where('deleted','=',0)
          ->select(\DB::raw('max(RIGHT(no_rm, 3)) as no_rm'))
          ->get();

        foreach ($noUrutAkhir as $noUru) {
             $idsa = $noUru->no_rm;
        }

        if (!empty($idsa)){
            $noUrus = $idsa+1;
        }
        else{
            $noUrus = 0001;
        }

        foreach ($idens as $idenst) {
             $jenispasien = $idenst->jenis_asuransi;
        }

        if (!empty($idsa)){
            $noUrus = $idsa+1;
        }
        else{
            $noUrus = 0001;
        }

        if ($jenispasien=="BPJS"){
            $jnsps = "BP";
        }
        else{
            $jnsps = "UM";
        }

        $nomerrm = $AWAL .'-'.$jnsps.'-'.$bulanRomawi[date('n')] .'-' . date('Y'). '-' .sprintf("%03s", $noUrus);
            return view('tambah-rm',compact('metadatas','idens','pasiens','cont','labs','obats','dokters','nomerrm','tindakans', 'diagnosas' ));  
        }
    
        public function simpan_rm(Request $request)
    {  

        $this->validate($request, [
            'idpasien' => 'required|numeric|digits_between:1,4',
            'keluhan_utama' => 'required|max:100',
            'anamnesis' => 'required|max:1000',
            'dokter' => 'required',
        ]);
       // Decoding array input pemeriksaan lab
       if (isset($request->lab))
       {
            if (has_dupes(array_column($request->lab,'id'))){
                $errors = new MessageBag(['lab'=>['Lab yang sama tidak boleh dimasukan berulang']]);
                return back()->withErrors($errors);
            }
            $lab_id = decode('lab','id',$request->lab);
            $lab_hasil = decode('lab','hasil',$request->lab);
       }
       else {
        $lab_id ="";
        $lab_hasil ="";
       }

       if (isset($request->tindakan))
       {
            if (has_dupes(array_column($request->tindakan,'id'))){
                $errors = new MessageBag(['tindakan'=>['tindakan yang sama tidak boleh dimasukan berulang']]);
                return back()->withErrors($errors);
            }
            $tindakan_id = decode('tindakan','id',$request->tindakan);
       }
       else {
        $tindakan_id ="";
       }

       if (isset($request->diagnosa))
       {
            if (has_dupes(array_column($request->diagnosa,'id'))){
                $errors = new MessageBag(['diagnosa'=>['diagnosa yang sama tidak boleh dimasukan berulang']]);
                return back()->withErrors($errors);
            }
            $this->validate($request, [
                'diagnosa.*.kode_diagnosa' => 'required',          
            ]);
            $diagnosa_id = decode('diagnosa','id',$request->diagnosa);
       }
       else {
        $diagnosa_id ="";
       }

       // Decoding array input resep
       if (isset($request->resep))
        {
            if (has_dupes(array_column($request->resep,'id'))){
                $errors = new MessageBag(['resep'=>['resep yang sama tidak boleh dimasukan berulang']]);
                return back()->withErrors($errors);
            }
            $this->validate($request, [
                'resep.*.jumlah' => 'required|numeric|digits_between:1,3',
                'resep.*.aturan' => 'required',
            ]);
            $resep_id = decode('resep','id',$request->resep);
            $resep_jumlah = decode('resep','jumlah',$request->resep);
            $resep_dosis = decode('resep','aturan',$request->resep); 
        }
        else {
            $resep_id = "";
            $resep_jumlah = "";
            $resep_dosis = "";
        }
        $newresep = array();
        $oldresep=array();
        if ($request->resep != NULL){
        foreach ($request->resep as $resep){
            $newresep[$resep['id']] = $resep['jumlah'];
            
        }
        }
        else{
            $errors = new MessageBag(['resep'=>['resep tidak boleh kosong']]);
        }
        if (empty($oldresep)) {
            $resultanresep = resultan_resep($oldresep,$newresep);
        }
        else {$resultanresep=$newresep;}
        $errors = validasi_stok($resultanresep);
        if ($errors !== NULL) {
          return  back()->withErrors($errors);
        }
  
        foreach ($resultanresep as $key => $value) {
            $perintah=kurangi_stok($key,$value);
            if ($perintah === false) { $habis = array_push($habis,$key); }
        }

        DB::table('pasien')->where('id',$request->idpasien)->update([
            'tb' => $request->tb,
            'bb' => $request->bb,
            'lp' => $request->lp,
            'imt' => $request->imt,
            'stole' => $request->stole,
            'dtole' => $request->dtole,
            'rr' => $request->rr,
            'hr' => $request->hr,
        ]);


        DB::table('rm')->insert([
            'no_rm' => $request->no_rm,
            'idpasien' => $request->idpasien,
            'ku' => $request->keluhan_utama,
            'anamnesis' => $request->anamnesis,
            'pxfisik' => $request->px_fisik,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'lp' => $request->lp,
            'imt' => $request->imt,
            'stole' => $request->stole,
            'dtole' => $request->dtole,
            'rr' => $request->rr,
            'hr' => $request->hr,
            'tindakan' => $tindakan_id,
            'lab' => $lab_id,
            'hasil' => $lab_hasil,
            'diagnosa' => $diagnosa_id,
            'diagnosis' => $request->diagnosis,
            'resep' => $resep_id,
            'jumlah' => $resep_jumlah,
            'aturan' => $resep_dosis,
            'dokter' => $request->dokter,
            'created_time' => Carbon::now(),
            'updated_time' => Carbon::now(),
        ]);

           $ids= DB::table('rm')->latest('created_time')->first();         
            switch($request->simpan) {
                case 'simpan_edit': 
                    $buka=route('rm.edit',$ids->id);
                    $pesan='Data Rekam Medis berhasil disimpan!';
                break;             
                case 'simpan_baru': 
                    $buka=route('rm.tambah.id',$request->idpasien);
                    $pesan='Data Rekam Medis berhasil disimpan!';
                break;
                case 'simpan_tagihan':
                    $buka=route('tagihan',$ids->id);
                    $pesan='Data Rekam Medis berhasil disimpan!';
                break;
            }
        \LogActivity::addToLog('Pengguna Menambah Data RM ID: '.$request->no_rm);
         return redirect($buka)->with('pesan',$pesan);
         
    }
    
    public function tagihan($id)
    {
        $metadatas = ambil_satudata('metadata',14);
        $datas= ambil_satudata('rm',$id);
        foreach ($datas as $data) {
            //mencari id pasien dari id RM
             $idrm = $data->id;
             $no_rms = $data->no_rm;
             $idpasien = $data->idpasien;
             $labs_id= encode($data->lab);
             $tindakans_id= encode($data->tindakan);
             $obats_id=encode($data->resep);
             $jumlah_obat=encode($data->jumlah);
        }             
        $idens=DB::table('pasien')->where('id',$idpasien)->get();
        $idrms = $id;
        $no_rm = $no_rms;
        $items = array();
        $jasa=DB::table('pengaturan')->select('jasa')->first();
        foreach ($jasa as $j) {
            $items['Jasa Dokter'] = [$j,1,$j * 1];
        }
        
        foreach ($labs_id as $lab_id) {
            $entries = ambil_satudata ('lab',$lab_id);
                foreach ($entries as $entry) {
                    $items[$entry->nama] = [$entry->harga, $n=1, $entry->harga * $n];
                }
                
        }

        foreach ($tindakans_id as $tindakan_id) {
            $entries = ambil_satudata ('tindakan',$tindakan_id);
                foreach ($entries as $entry) {
                    $items[$entry->nama] = [$entry->harga, $n=1, $entry->harga * $n];
                }
                
        }
        
        for ($i=0;$i<sizeof($obats_id);$i++) {
            $entries = ambil_satudata ('obat',$obats_id[$i]);
                foreach ($entries as $entry) {
                    $items[$entry->nama_obat] = [$entry->harga, $n=$jumlah_obat[$i], $entry->harga * $n];
                }
                
        }
        

        return view('tagihan',compact('metadatas','datas','idrms','idens','items', 'no_rm'));      
        
    }

    public function tagihan_cetak($id)
    {
        $metadatas = ambil_satudata('metadata',14);
        $datas= ambil_satudata('rm',$id);
        foreach ($datas as $data) {
            //mencari id pasien dari id RM
             $no_rm = $data->no_rm;
             $tanggal = format_datefile($data->created_time);
             $idpasien = $data->idpasien;
             $labs_id= encode($data->lab);
             $tindakans_id= encode($data->tindakan);
             $obats_id=encode($data->resep);
             $jumlah_obat=encode($data->jumlah);
             $updated_time=$data->updated_time;
        }
        $no_rm_cetak = $no_rm;
        $gentanggal = $tanggal;       
        $idens=DB::table('pasien')->where('id',$idpasien)->get();
        foreach ($idens as $ident) {
            //mencari id pasien dari id RM
             $no_pasien = $ident->no_pasien;
        } 
        $idrms = $id;
        $items = array();
        $jasa=DB::table('pengaturan')->select('jasa')->first();
        foreach ($jasa as $j) {
            $items['Jasa Dokter'] = [$j,1,$j * 1];
        }
        
        foreach ($labs_id as $lab_id) {
            $entries = ambil_satudata ('lab',$lab_id);
                foreach ($entries as $entry) {
                    $items[$entry->nama] = [$entry->harga, $n=1, $entry->harga * $n];
                }
                
        }

        foreach ($tindakans_id as $tindakan_id) {
            $entries = ambil_satudata ('tindakan',$tindakan_id);
                foreach ($entries as $entry) {
                    $items[$entry->nama] = [$entry->harga, $n=1, $entry->harga * $n];
                }
                
        }
        
        for ($i=0;$i<sizeof($obats_id);$i++) {
            $entries = ambil_satudata ('obat',$obats_id[$i]);
                foreach ($entries as $entry) {
                    $items[$entry->nama_obat] = [$entry->harga, $n=$jumlah_obat[$i], $entry->harga * $n];
                }
                
        }
        \LogActivity::addToLog('Pengguna Cetak PDF Tagihan RM ID: '.$data->no_rm);
        $pdf = PDF::loadview('tagihan-cetak',compact('metadatas','datas','idrms','idens','items','no_rm_cetak'));
        return $pdf->stream('data-tagihan-'.$no_rm_cetak.'-'.$no_pasien.'-'.$gentanggal.'.pdf', array('Attachment' => 0));        
    }

    public function tagihan_print(Request $request)
    {
        $id = $request->id;
        $metadatas = ambil_satudata('metadata',14);
        $datas= ambil_satudata('rm',$id);
        foreach ($datas as $data) {
            //mencari id pasien dari id RM
             $no_rm = $data->no_rm;
             $tanggal = format_datefile($data->created_time);
             $idpasien = $data->idpasien;
             $labs_id= encode($data->lab);
             $tindakans_id= encode($data->tindakan);
             $obats_id=encode($data->resep);
             $jumlah_obat=encode($data->jumlah);
             $updated_time=$data->updated_time;
        }
        $no_rm_cetak = $no_rm;
        $gentanggal = $tanggal;       
        $idens=DB::table('pasien')->where('id',$idpasien)->get();
        foreach ($idens as $ident) {
            //mencari id pasien dari id RM
             $no_pasien = $ident->no_pasien;
        } 
        $idrms = $id;
        $items = array();
        $jasa=DB::table('pengaturan')->select('jasa')->first();
        foreach ($jasa as $j) {
            $items['Jasa Dokter'] = [$j,1,$j * 1];
        }
        
        foreach ($labs_id as $lab_id) {
            $entries = ambil_satudata ('lab',$lab_id);
                foreach ($entries as $entry) {
                    $items[$entry->nama] = [$entry->harga, $n=1, $entry->harga * $n];
                }
                
        }

        foreach ($tindakans_id as $tindakan_id) {
            $entries = ambil_satudata ('tindakan',$tindakan_id);
                foreach ($entries as $entry) {
                    $items[$entry->nama] = [$entry->harga, $n=1, $entry->harga * $n];
                }
                
        }
        
        for ($i=0;$i<sizeof($obats_id);$i++) {
            $entries = ambil_satudata ('obat',$obats_id[$i]);
                foreach ($entries as $entry) {
                    $items[$entry->nama_obat] = [$entry->harga, $n=$jumlah_obat[$i], $entry->harga * $n];
                }
                
        }
        \LogActivity::addToLog('Pengguna Cetak Print Tagihan RM ID: '.$data->no_rm);
        return view('tagihan-cetak',compact('metadatas','datas','idrms','idens','items','no_rm_cetak'));      
    }
    
    public function lihat_rm($id)
    {
        $metadatas = ambil_satudata('metadata',15);
        $datas= ambil_satudata('rm',$id);
        if ($datas->count() <= 0) {
            return abort(404, 'Halaman Tidak Ditemukan.');
        }
        foreach ($datas as $data) {
            //mencari id pasien dari id RM
             $idpasien = $data->idpasien;
             if ($data->lab != NULL) {
                //mengcovert data lab di tabel RM kedalam arry
                $data->labhasil=array_combine(encode($data->lab),encode($data->hasil));
                $num['lab']=sizeof($data->labhasil);
             }
             else {
                $num['lab']=0;
             }
            $diagnosasa = $data->diagnosa;
            if ($diagnosasa != NULL) {
                $data->alldiagnosa=array_combine(encode($data->diagnosa),encode($data->diagnosa));
                $num['diagnosa']=sizeof($data->alldiagnosa);
             }           
             else {
                $num['diagnosa']=0;
             }

            $tindakansa = $data->tindakan;
            if ($tindakansa != NULL) {
                $data->alltindakan=array_combine(encode($data->tindakan),encode($data->tindakan));
                $num['tindakan']=sizeof($data->alltindakan);
            }           
            else {
                $num['tindakan']=0;
            }

             if ($data->resep != NULL) {
                $data->allresep=array_combine(encode($data->resep),encode($data->aturan));
                $data->jum=encode($data->jumlah);
                $num['resep']=sizeof($data->allresep);
             }
             else {
                $num['resep']=0;
             }
        }
        $labs = ambil_semuadata('lab');
        $obats = ambil_semuadata('obat');
        $idens=DB::table('pasien')->where('id',$idpasien)->get();
        $tindakans = ambil_semuadata('tindakan');
        $diagnosas = ambil_semuadata('diagnosa');
      return view('lihat-rm',compact('metadatas','idens','datas','labs','obats','num','tindakans','diagnosas'));
    }

    public function lihatcetak_pdf($id)
    {
        $metadatas = ambil_satudata('metadata',15);
        $datas= ambil_satudata('rm',$id);
        if ($datas->count() <= 0) {
            return abort(404, 'Halaman Tidak Ditemukan.');
        }
        foreach ($datas as $data) {
            //mencari id pasien dari id RM
             $idpasien = $data->idpasien;
             if ($data->lab != NULL) {
                //mengcovert data lab di tabel RM kedalam arry
                $data->labhasil=array_combine(encode($data->lab),encode($data->hasil));
                $num['lab']=sizeof($data->labhasil);
             }
             else {
                $num['lab']=0;
             }
            $diagnosasa = $data->diagnosa;
            if ($diagnosasa != NULL) {
                $data->alldiagnosa=array_combine(encode($data->diagnosa),encode($data->diagnosa));
                $num['diagnosa']=sizeof($data->alldiagnosa);
             }           
             else {
                $num['diagnosa']=0;
             }

            $tindakansa = $data->tindakan;
            if ($tindakansa != NULL) {
                $data->alltindakan=array_combine(encode($data->tindakan),encode($data->tindakan));
                $num['tindakan']=sizeof($data->alltindakan);
            }           
            else {
                $num['tindakan']=0;
            }
             if ($data->resep != NULL) {
                $data->allresep=array_combine(encode($data->resep),encode($data->aturan));
                $data->jum=encode($data->jumlah);
                $num['resep']=sizeof($data->allresep);
             }
             else {
                $num['resep']=0;
             }
        $norm = $data->no_rm;
        $tanggal = format_datefile($data->created_time);
        }
        $labs = ambil_semuadata('lab');
        $obats = ambil_semuadata('obat');
        $idens=DB::table('pasien')->where('id',$idpasien)->get();
        $tindakans = ambil_semuadata('tindakan');
        $diagnosas = ambil_semuadata('diagnosa');
        foreach ($idens as $iden) {
            $namapasien=$iden->nama;
        }
        \LogActivity::addToLog('Pengguna Cetak Data Detail RM ID: '.$norm);
        $pdf = PDF::loadview('lihatcetak-rm',compact('metadatas','idens','datas','labs','obats','num','tindakans','diagnosas'));
        return $pdf->stream('data-'.$norm.'-'.$tanggal.'.pdf', array('Attachment' => 0));
    }

}