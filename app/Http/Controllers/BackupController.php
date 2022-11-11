<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Log;
use Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class BackupController extends Controller
{
    public function index(){
    	$metadatas =ambil_satudata('metadata',20);
        $disk = Storage::disk(config('laravel-backup.backup.destination.disks'));
        $files = $disk->files('Laravel');
        $backups = [];
        foreach ($files as $k => $f) {
           if (substr($f, -4) == '.zip' && $disk->exists($f)) {
               $backups[] = [
               'file_path' => $f,
               'file_name' => str_replace(config('laravel-backup.backup.name') . 'Laravel/', '', $f),
               'file_size' => $disk->size($f),
               'last_modified' => $disk->lastModified($f),
                ];
           }
        }
	$backups = array_reverse($backups);
        return view("backupd")->with(compact('backups','metadatas'));
    }

    public static function humanFileSize($size,$unit="") {
          if( (!$unit && $size >= 1<<30) || $unit == "GB")
               return number_format($size/(1<<30),2)."GB";
          if( (!$unit && $size >= 1<<20) || $unit == "MB")
               return number_format($size/(1<<20),2)."MB";
          if( (!$unit && $size >= 1<<10) || $unit == "KB")
               return number_format($size/(1<<10),2)."KB";
          return number_format($size)." bytes";
    }

    public function create()
    {
          try {
               /* only database backup*/
	          Artisan::call('backup:run --only-db');
               /* all backup */
               /* Artisan::call('backup:run'); */
               $output = Artisan::output();
               Log::info("Backpack\BackupManager -- new backup started \r\n" . $output);
               \LogActivity::addToLog('Pengguna Membuat Data Backup');
               return redirect(route('backup'))->with('pesan',"Backup Berhasil Disimpan!");
          } catch (Exception $e) {
               session()->flash('danger', $e->getMessage());
               return redirect()->back();               
          }
    }

    public function createall()
    {
          try {
               /* only database backup*/
            Artisan::call('backup:run');
               /* all backup */
               /* Artisan::call('backup:run'); */
               $output = Artisan::output();
               Log::info("Backpack\BackupManager -- new backup started \r\n" . $output);
               return redirect(route('backup'))->with('pesan',"Backup Berhasil Disimpan!");
          } catch (Exception $e) {
               session()->flash('danger', $e->getMessage());
               return redirect()->back();               
          }
    }

    public function download($file_name) {
        $file = config('laravel-backup.backup.name') .'/Laravel/'. $file_name;
        $disk = Storage::disk(config('laravel-backup.backup.destination.disks'));

        if ($disk->exists($file)) {
            $fs = Storage::disk(config('laravel-backup.backup.destination.disks'))->getDriver();
            $stream = $fs->readStream($file);
            \LogActivity::addToLog('Pengguna Mendownload Data Backup');
            return \Response::stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                "Content-Type" => $fs->getMimetype($file),
                "Content-Length" => $fs->getSize($file),
                "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
            ]);
        } else {
            abort(404, "Backup file doesn't exist.");
        }
    }

     public function delete($file_name){
            Storage::delete('Laravel/'.$file_name);
            \LogActivity::addToLog('Pengguna Menghapus Data Backup');
            return redirect(route('backup'))->with('pesan',"Backup " .$file_name. " Berhasil Terhapus!");
     }

    public function sendmails($file_name)
    {
        $users = Auth::user()->username; 
        $data["email"] = "drgedelistiana2903@gmail.com";
        $data["title"] = "Backup Aplikasi Rekam Medis ".$file_name;
        $data["body"] = "Backup Aplikasi Rekam Medis ".$file_name;
        $files = [
            storage_path('/app/Laravel/'.$file_name),
        ];
  
        Mail::send('mail-backup', $data, function($message)use($data, $files) {
            $message->to($data["email"])
                    ->subject($data["title"]);
 
            foreach ($files as $file){
                $message->attach($file);
            }
            
        });
        \LogActivity::addToLog('Pengguna Mengirim Email Data Backup');
        return redirect(route('backup'))->with('pesan',"Backup Berhasil Terkirim!");
    }
}