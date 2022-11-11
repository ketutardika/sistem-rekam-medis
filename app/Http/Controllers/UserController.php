<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Cache;
use Carbon\Carbon;
class UserController extends Controller
{
    public function index() {
        $users=user::where('deleted','<>',1)->get();
        $metadatas= ambil_satudata('metadata',18);
        
        return view('auth.users',compact('metadatas','users'));
        
    }
    
        public function hapus($id) {
        \LogActivity::addToLog('Pengguna Menghapus User Profile ID: '.$id);
        $user=user::find($id);
        $user->deleted = 1;
        $user->username = NULL;
        $user->email = NULL;
        $user->save();        
        return redirect()->route('user')->with('pesan','Data Pengguna Berhasil Dihapus!') ;
        
    }
    public function logout(Request $request)
    {
        \LogActivity::addToLog('Pengguna Log Out Sistem');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
