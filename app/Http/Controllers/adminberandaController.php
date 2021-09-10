<?php

namespace App\Http\Controllers;

use App\Models\settings;
use App\Models\tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class adminberandaController extends Controller
{
    public function index()
    {

        if(($this->checkauth('siswa')==='404')&&($this->checkauth('admin')==='404')&&($this->checkauth('kepsek')==='404')){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }

        if($this->checkauth('siswa')==='success'){
            return redirect(route('siswa.tagihansiswa'));
        }

        $pages='beranda';
        $siswa = DB::table('siswa')->count();
        $kelas = DB::table('kelas')->count();
        $pemasukan = DB::table('pemasukan')->count();
        //lunas
        $lunas=0;
        $belumlunas=0;


        $counttagihansiswa = DB::table('tagihansiswa')
        ->count();
        // 1.ambil tagihansiswa >nominal , ambil total tagihansiswadetail where id
            $gettagihansiswa = DB::table('tagihansiswa')
            ->get();
            foreach ($gettagihansiswa as $ts){
                $siswa_nis=$ts->siswa_nis;
                $tapel_nama=$ts->tapel_nama;
                $kelas_nama=$ts->kelas_nama;

            $sumdetailbayar = DB::table('tagihansiswadetail')
            ->where('siswa_nis', '=', $ts->siswa_nis)
            ->where('tapel_nama', '=', $ts->tapel_nama)
            ->where('kelas_nama', '=', $ts->kelas_nama)
            ->sum('nominal');

            // dd($sumdetailbayar);
                $kurang=$ts->nominaltagihan-$sumdetailbayar;
                if($kurang<=0){
                    $lunas+=1;
                }
            }
            $belumlunas=$counttagihansiswa-$lunas;
            // dd($gettagihansiswa);
        

            $ttlpemasukan = DB::table('pemasukan')
            // ->where('tagihansiswa_id', '=', $ts->id)
            ->sum('nominal');

            $ttlpengeluaran = DB::table('pengeluaran')
            // ->where('tagihansiswa_id', '=', $ts->id)
            ->sum('nominal');

            $saldo=$ttlpemasukan-$ttlpengeluaran;
            $paginationjml=$this->paginationjml();
            $sekolahnama=$this->sekolahnama();
            $sekolahalamat=$this->sekolahalamat();
            $sekolahtelp=$this->sekolahtelp();
            $aplikasijudul=$this->aplikasijudul();
            $aplikasijudulsingkat=$this->aplikasijudulsingkat();
            $nominaltagihandefault=$this->nominaltagihandefault();
            $passdefaultsiswa=$this->passdefaultsiswa();
            $passdefaultortu=$this->passdefaultortu();
            $passdefaultpegawai=$this->passdefaultpegawai();
            $tapelaktif=$this->tapelaktif();
            $tapel=tapel::all();


        return view('admin.beranda',compact('pages'
        ,'pemasukan'
        ,'kelas'
        ,'tapel'
        ,'siswa',
        'lunas'
        ,'belumlunas'
        ,'ttlpemasukan'
        ,'ttlpengeluaran'
        ,'saldo'
        ,'paginationjml'
        ,'tapelaktif'
        ,'sekolahnama'
        ,'sekolahalamat'
        ,'sekolahtelp'
        ,'nominaltagihandefault'
        ,'aplikasijudul'
        ,'aplikasijudulsingkat'
        ,'passdefaultsiswa'
        ,'passdefaultortu'
        ,'passdefaultpegawai'
    ));
        // return view('admin.beranda');


            // $sumdetailbayar = DB::table('tagihansiswadetail')
            // ->where('tagihansiswa_id', '=', $tagihansiswa->id)
            // ->sum('nominal');
    }
    public function settingsstore(Request $request,settings $settings)
    {
        // dd($settings);

        $request->validate([
            'paginationjml'=>'required|numeric|min:3',
            'tapelaktif'=>'required',
            'sekolahnama'=>'required',
            'sekolahalamat'=>'required',
            'sekolahtelp'=>'required',
            'aplikasijudul'=>'required',
            'aplikasijudulsingkat'=>'required',
            'nominaltagihandefault'=>'required',
            'passdefaultsiswa'=>'required',
            'passdefaultortu'=>'required',
            'passdefaultpegawai'=>'required',

        ],
        [
            'paginationjml.required'=>'Nama harus diisi',

        ]);

        settings::where('id',$settings->id)
            ->update([
                'paginationjml'=>$request->paginationjml,
                'tapelaktif'=>$request->tapelaktif,
                'sekolahnama'=>$request->sekolahnama,
                'sekolahalamat'=>$request->sekolahalamat,
                'sekolahtelp'=>$request->sekolahtelp,
                'aplikasijudul'=>$request->aplikasijudul,
                'nominaltagihandefault'=>$request->nominaltagihandefault,
                'aplikasijudulsingkat'=>$request->aplikasijudulsingkat,
                'passdefaultsiswa'=>$request->passdefaultsiswa,
                'passdefaultortu'=>$request->passdefaultortu,
                'passdefaultpegawai'=>$request->passdefaultpegawai,
                'sekolahttd'=>$request->sekolahttd,
                'sekolahttd2'=>$request->sekolahttd2,
                'minimalpembayaranujian'=>$request->minimalpembayaranujian,
                'semesteraktif'=>$request->semesteraktif,
            ]);
            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');

    }

    public function notfound()
    {

        return view('404');
    }
}
