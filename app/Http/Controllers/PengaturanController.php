<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

use Artisan;

class PengaturanController extends Controller
{
    public function index() {
        $metadatas =ambil_satudata('metadata',16);
        $datas=DB::table('pengaturan')->where('id',1)->get();
        
        return view('setting',['metadatas'=>$metadatas],['datas'=>$datas]);
    }
    public function simpan(Request $request){
            $this->validate($request, [
                'nama_klinik' => 'required|min:4|max:25',
                'slogan' => 'required',
                'logo' => 'required',
                'jasa' => 'required|numeric|digits_between:1,7',
                'gambar' => ['sometimes','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],

            ]);
            if ($request->gambarbool === NULL) {$request->gambarbool=0; }
           if ($request->gambar !== NULL) {
            $avatarname='logo'.time().'.'.request()->gambar->getClientOriginalExtension();
            $request->gambar->storeAs('public/logo',$avatarname);
            $oldpic = get_setting('gambar');
            Storage::delete('public/logo/'. $oldpic);

            
            
            DB::table('pengaturan')->where('id',1)->update([
                'gambar' => $avatarname,               
                ]);
        }
   
            DB::table('pengaturan')->where('id',1)->update([
                'n_Klinik' => $request->nama_klinik,
                'Slogan' => $request->slogan,
                'logo' => $request->logo,
                'jasa' => $request->jasa,
                'gambarbool' => $request->gambarbool,
            ]);
        \LogActivity::addToLog('Pengguna Menyimpan Data Pengaturan');
        return redirect(route('pengaturan'))->with('pesan',"Pengaturan Berhasil Disimpan!");
    }
     public function backup(){

     Artisan::call('backup:run');
     $path = storage_path('app/laravel/*');
     $latest_ctime = 0;
     $latest_filename = '';
     $files = glob($path);
     foreach($files as $file)
     {
             if (is_file($file) && filectime($file) > $latest_ctime)
             {
                     $latest_ctime = filectime($file);
                     $latest_filename = $file;
             }
     }
     return response()->download($latest_filename);
    }

    public function refresh_db()
    {
        $metadatas =ambil_satudata('metadata',23);        
        return view('refreshdb',['metadatas'=>$metadatas]);
    }

    public function refresh_database()
    {
            try {
              Artisan::call('migrate:fresh');
              Artisan::call('make:seeder temp1Seeder');
              Artisan::call('db:seed --class=MetadataTableSeeder');
              Artisan::call('make:seeder temp2Seeder');
              Artisan::call('db:seed --class=PengaturanTableSeeder');
              Artisan::call('make:seeder temp3Seeder');
              Artisan::call('db:seed --class=UsersTableSeeder');
               $output = Artisan::output();
               \LogActivity::addToLog('Pengguna Mereset Databae');
               return redirect(route('pengaturan.refreshdb'))->with('pesan',"Refresh Database Berhasil!");
          } catch (Exception $e) {
               session()->flash('danger', $e->getMessage());
               return redirect()->back();               
          }
    }

    public function reset(){

     Artisan::call('backup:run');
     $path = storage_path('app/laravel/*');
     $latest_ctime = 0;
     $latest_filename = '';
     $files = glob($path);
     foreach($files as $file)
     {
             if (is_file($file) && filectime($file) > $latest_ctime)
             {
                     $latest_ctime = filectime($file);
                     $latest_filename = $file;
             }
     }
     return response()->download($latest_filename);
    }

    public function myTestAddToLog()
    {
        \LogActivity::addToLog('My Testing Add To Log.');
        dd('log insert successfully.');
    }

    public function logActivity()
    {
        $metadatas =ambil_satudata('metadata',16);
        $logs = \LogActivity::logActivityLists();
        return view('logactivity',compact('logs','metadatas'));
    }
}
