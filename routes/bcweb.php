<?php

use Illuminate\Support\Facades\Route;
Use App\PasienImport;
use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Storage;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$file = public_path('maintenance.php');

Route::get('/', function () {
    return view('welcome');
    }
);

//Main
                      
if(file_exists($file)){
Route::get('/dashboard', 'MainController@index')->name('dashboard')->middleware('auth');
}
else{
Route::get('/', 'MainController@index')->name('dashboard')->middleware('auth');
}
//Pasien
Route::get('/pasien', 'PasienController@index')->name('pasien')->middleware('auth');

Route::post('/pasien/import', 'PasienController@import')->name('pasien.import')->middleware('auth');

Route::get('/pasien/export', 'PasienController@export')->name('pasien.export')->middleware('auth');

Route::get('/pasien/tambah/', 'PasienController@tambah_pasien')->name('pasien.tambah')->middleware('auth');

Route::get('/pasien/ajax-request/', 'PasienController@ajax_create')->name('pasien.ajaxcreate')->middleware('auth');

Route::post('/pasien/ajax-request/', 'PasienController@ajax_store')->name('pasien.ajaxstore')->middleware('auth');

Route::post('/pasien/tambah/simpan', 'PasienController@simpan_pasien')->name('pasien.simpan')->middleware('auth');

Route::post('/pasien/edit/update/', 'PasienController@update_pasien')->name('pasien.update')->middleware('auth');

Route::delete('/pasien/hapus/{id}','PasienController@hapus_pasien')->name('pasien.destroy')->middleware('auth');

Route::get('/pasien/edit/{id}','PasienController@edit_pasien')->name('pasien.edit')->middleware('auth');
//End Pasien

//Obat

Route::get('/obat', 'ObatController@index')->name('obat')->middleware('auth');

Route::delete('/obat/hapus/{id}','ObatController@hapus_obat')->name('obat.destroy')->middleware('auth','staff');

Route::get('/obat/edit/{id}', 'ObatController@edit_obat')->name('obat.edit')->middleware('auth','staff');

Route::get('/obat/tambah/', 'ObatController@tambah_obat')->name('obat.tambah')->middleware('auth','staff');

Route::post('/obat/tambah/simpan', 'ObatController@simpan_obat')->name('obat.simpan')->middleware('auth','staff');

Route::post('/obat/edit/update/', 'ObatController@update_obat')->name('obat.update')->middleware('auth','staff');
//End Obat

//Lab
Route::get('/lab', 'LabController@index')->name('lab')->middleware('auth');

Route::delete('/lab/hapus/{id}','LabController@hapus_lab')->name('lab.destroy')->middleware('auth','staff');

Route::get('/lab/edit/{id}', 'LabController@edit_lab')->name('lab.edit')->middleware('auth','staff');

Route::get('/lab/tambah', 'LabController@tambah_lab')->name('lab.tambah')->middleware('auth','staff');

Route::post('/lab/tambah/simpan', 'LabController@simpan_lab')->name('lab.simpan')->middleware('auth','staff');

Route::post('/lab/edit/update/', 'LabController@update_lab')->name('lab.update')->middleware('auth','staff');
//End Lab

//diagnosa
Route::get('/diagnosa', 'DiagnosaController@index')->name('diagnosa')->middleware('auth');

Route::post('/diagnosa/import', 'DiagnosaController@import')->name('diagnosa.import')->middleware('auth');

Route::get('/diagnosa/export', 'DiagnosaController@export')->name('diagnosa.export')->middleware('auth');

Route::get('/diagnosa/cetak-pdf', 'DiagnosaController@cetak_pdf')->name('diagnosa.cetakpdf')->middleware('auth');

Route::delete('/diagnosa/hapus/{id}','DiagnosaController@hapus_diagnosa')->name('diagnosa.destroy')->middleware('auth','staff');

Route::get('/diagnosa/edit/{id}', 'DiagnosaController@edit_diagnosa')->name('diagnosa.edit')->middleware('auth','staff');

Route::get('/diagnosa/tambah', 'DiagnosaController@tambah_diagnosa')->name('diagnosa.tambah')->middleware('auth','staff');

Route::post('/diagnosa/tambah/simpan', 'DiagnosaController@simpan_diagnosa')->name('diagnosa.simpan')->middleware('auth','staff');

Route::post('/diagnosa/edit/update/', 'DiagnosaController@update_diagnosa')->name('diagnosa.update')->middleware('auth','staff');
//End Tindakan

//Diagnosa
Route::get('/tindakan', 'TindakanController@index')->name('tindakan')->middleware('auth');

Route::delete('/tindakan/hapus/{id}','TindakanController@hapus_tindakan')->name('tindakan.destroy')->middleware('auth','staff');

Route::get('/tindakan/edit/{id}', 'TindakanController@edit_tindakan')->name('tindakan.edit')->middleware('auth','staff');

Route::get('/tindakan/tambah', 'TindakanController@tambah_tindakan')->name('tindakan.tambah')->middleware('auth','staff');

Route::post('/tindakan/tambah/simpan', 'TindakanController@simpan_tindakan')->name('tindakan.simpan')->middleware('auth','staff');

Route::post('/tindakan/edit/update/', 'TindakanController@update_tindakan')->name('tindakan.update')->middleware('auth','staff');
//End Tindakan

//rm

Route::get('/rm', 'RMController@index')->name('rm')->middleware('auth');

Route::delete('/rm/hapus/{id}','RMController@hapus_rm')->name('rm.destroy')->middleware('auth');

Route::get('/rm/edit/{id}', 'RMController@edit_rm')->name('rm.edit')->middleware('auth');

Route::get('/rm/tambah', 'RMController@tambah_rm')->name('rm.tambah')->middleware('auth');

Route::get('/rm/laporan', 'RMController@laporan_rm')->name('rm.laporan')->middleware('auth');

Route::get('/rm/laporan/cetak_pdf', 'RMController@cetak_pdf')->name('rm.cetaklaporan')->middleware('auth');

Route::get('/rm/tambah/{idpasien}', 'RMController@tambah_rmid')->name('rm.tambah.id')->middleware('auth');

Route::post('/rm/simpan/', 'RMController@simpan_rm')->name('rm.simpan')->middleware('auth');

Route::post('/rm/update/', 'RMController@update_rm')->name('rm.update')->middleware('auth');

Route::get('/rm/list/{idpasien}', 'RMController@list_rm')->name('rm.list')->middleware('auth');

Route::get('/rm/lihat/{id}', 'RMController@lihat_rm')->name('rm.lihat')->middleware('auth');

Route::get('/rm/lihat/{id}/cetak_pdf', 'RMController@lihatcetak_pdf')->name('rm.lihatcetak')->middleware('auth');
//End rm

//Tagihan
Route::get('/tagihan/{id}', 'RMController@tagihan')->name('tagihan')->middleware('auth');
Route::get('/tagihan/{id}/cetak/', 'RMController@tagihan_cetak')->name('tagihan.cetak')->middleware('auth');
Route::post('/tagihan/print/', 'RMController@tagihan_print')->name('tagihan.print')->middleware('auth');
//Endtagihan

//Tagihan
Route::get('/pengaturan', 'PengaturanController@index')->name('pengaturan')->middleware('auth','admin');


Route::patch('/pengaturan/simpan', 'PengaturanController@simpan')->name('pengaturan.simpan')->middleware('auth','admin');

Route::get('/pengaturan/refresh', 'PengaturanController@refresh_db')->name('pengaturan.refreshdb')->middleware('auth','admin');

Route::get('/pengaturan/refreshdatabase', 'PengaturanController@refresh_database')->name('pengaturan.refreshdatabase')->middleware('auth','admin');


//Endtagihan

//Profile
Auth::routes([
  'register' => true,
  'verify' => false,
  'reset' => true,
]);

Route::group(['prefix' => 'users'], function(){
    Route::auth();
    });

Route::get('users/profile', 'ProfileController@index')->name('profile.edit')->middleware('auth');

Route::get('users/profile/{id}', 'ProfileController@edit')->name('profile.edit.admin')->middleware('auth','admin');

Route::patch('users/profile/simpan', 'ProfileController@simpan')->name('profile.simpan')->middleware('auth');
//endProfile

//Users
Route::get('/users', 'UserController@index')->name('user')->middleware('auth','admin');

Route::delete('/users/delete/{id}', 'UserController@hapus')->name('user.destroy')->middleware('auth','admin');

//endUsers

Route::get('/backup', 'BackupController@index')->name('backup');
Route::get('/backup/create', 'BackupController@create')->name('backup.create')->middleware('auth');
Route::get('/backup/seluruh', 'BackupController@createall')->name('backup.seluruh')->middleware('auth');
Route::get('/backup/download/{file_name}', 'BackupController@download')->name('backup.create')->middleware('auth');
Route::get('/backup/delete/{file_name}', 'BackupController@delete')->name('backup.create')->middleware('auth');
Route::get('/backup/kirim-email/{file_name}', 'BackupController@sendmails')->name('backup.kirim')->middleware('auth');


Route::get('migrate', function () {
	try {        
              $files = public_path('maintenance.php');
              Artisan::call('migrate:fresh');
              Artisan::call('make:seeder temp1Seeder');
              Artisan::call('db:seed --class=MetadataTableSeeder');
              Artisan::call('make:seeder temp2Seeder');
              Artisan::call('db:seed --class=PengaturanTableSeeder');
              Artisan::call('make:seeder temp3Seeder');
              Artisan::call('db:seed --class=UsersTableSeeder');
              File::delete($files);
              Artisan::call('config:cache');
              Artisan::call('config:clear');
                Artisan::call('cache:clear');
               $output = Artisan::output();
               return redirect()->back()->with('pesan',"Refresh Database Berhasil!");
          } catch (Exception $e) {
               session()->flash('danger', $e->getMessage());
               return redirect()->back();               
          }
})->name('migrate-database');

Route::get('/recovery-mode', function () {
    return view('welcome');
    }
);

Route::get('cache', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
              $data = time() .rand(). '_file.json';
              $destinationPath=public_path();
              $file = 'maintenance.php';
              File::put(public_path($file),$data);
    return redirect()->back();
})->name('refresh-cache');