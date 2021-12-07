<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kelas;
use App\Models\pembayaran;
use App\Models\siswa;
use App\Models\tagihan;
use App\Models\tagihandetail;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class adminpembayarancontroller extends Controller
{
    protected $kelasid;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(Request $request)
    {
        $datas=new Collection();

        #WAJIB
        $pages='pembayaran';
        $kelas=kelas::first();
        $getsiswa=siswa::
        where('kelas_id',$kelas->id)
        ->get();
        foreach($getsiswa as $s){
            $this->kelasid=$s->kelas_id;

            $getNominal=tagihan::where('id',function($query){
                $query->select('tagihan_id')->from('tagihandetail')->where('deleted_at',null)->where('kelas_id',$this->kelasid)
                ->orderBy('created_at','desc')->first();
            })->sum('total');
            $getPembayaran=pembayaran::where('siswa_id',$s->id)->sum('nominal');
            $getKurang=$getNominal-$getPembayaran;
            if($getKurang<0){
                $getKurang=0;
            }

            $datas->push((object)[
                'siswa'=>$s,
                'totaltagihan'=>$getNominal,
                'terbayar'=>$getPembayaran,
                'kurang'=>$getKurang,
                'persen'=>$getPembayaran/$getNominal*100,
            ]);

        }

        // dd($datas);

        return view('pages.admin.pembayaran.index',compact('datas','request','pages','kelas'));
    }
    // public function cari(Request $request)
    // {

    //     $cari=$request->cari;
    //     #WAJIB
    //     $pages='pembayaran';
    //     $datas=tagihandetail::where('nama','like',"%".$cari."%")
    //     ->paginate(Fungsi::paginationjml());

    //     return view('pages.admin.pembayaran.index',compact('datas','request','pages'));
    // }
}
