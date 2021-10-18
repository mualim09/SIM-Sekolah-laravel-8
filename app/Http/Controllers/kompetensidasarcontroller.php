<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kompetensidasar;
use App\Models\materipokok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class kompetensidasarcontroller extends Controller
{
    public function index(Request $request,$pelajaran_nama,$kelas_nama,$tapel_nama){

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        $p_nama=base64_decode($pelajaran_nama);
        $k_nama=base64_decode($kelas_nama);
        $t_nama=base64_decode($tapel_nama);
        // dd($p_nama,$k_nama,$t_nama);

        #WAJIB
        $pages='kompetensidasar';
        $jmldata='0';
        $datas='0';


        $datastanpauniq=DB::table('kompetensidasar')
                ->where('pelajaran_nama',$p_nama)
                ->where('kelas_nama',$k_nama)
                ->where('tapel_nama',$t_nama)
                // ->where('kode',1)
                // ->orWhere('pelajaran_nama',$p_nama)
                // ->where('kelas_nama',$k_nama)
                // ->where('tapel_nama',$t_nama)
                // ->where('kode',2)
                ->orderBy('kode','asc')
                ->orderBy('tipe','desc')
                ->get();

        $datas=$datastanpauniq->unique('kode');



        $generate_kode=Fungsi::kompetensidasargeneratekode($t_nama,$k_nama,$p_nama);
// a

        // 1. ambil datas dari tabel kompetensi dasar where tapel kelas dan pelajarannama
        // 1. ambil last id (Fungsi generatekompetesiid)


        return view('admin.kompetensidasar.index',compact('pages','datas','datastanpauniq','request','generate_kode','pelajaran_nama','kelas_nama','tapel_nama','t_nama','p_nama','k_nama'));
    }
    public function show(kompetensidasar $id)
    {
        // $kela lihat di route:list
        // $kelas=$kelas;

        #WAJIB
        $pages='kompetensidasar';

        $datas=$id;
        return view('admin.kompetensidasar.edit',compact('datas','pages'));
    }
    public function proses_update($request,$id)
    {

        $request->validate([
            'nama'=>'required'
        ],
        [
            'nama.required'=>'Nama harus diisi'


        ]);
        // dd($id->tapel_nama,$id->kelas_nama,$id->pelajaran_nama);
        kompetensidasar::where('id',$id->id)
            ->update([
                'nama'=>$request->nama,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            // dd($id);
        materipokok::where('tapel_nama',$id->tapel_nama)
        ->where('kelas_nama',$id->kelas_nama)
        ->where('pelajaran_nama',$id->pelajaran_nama)
        ->where('kompetensidasar_kode',$id->kode)
        ->update([
            'kompetensidasar_nama'=>$request->nama,
            'updated_at'=>date("Y-m-d H:i:s")
        ]);
    }
    public function update(Request $request, kompetensidasar $id)
    {
        $this->proses_update($request,$id);

            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function materipokokshow(materipokok $id)
    {
        // $kela lihat di route:list
        // $kelas=$kelas;

        #WAJIB
        $pages='kompetensidasar';

        $datas=$id;
        return view('admin.kompetensidasar.materipokok_edit',compact('datas','pages'));
    }
    public function materipokokproses_update($request,$id)
    {

        $request->validate([
            'nama'=>'required',
        ],
        [
            'nama.required'=>'Nama harus diisi'


        ]);


        $files = $request->file('link');
        $namafileku=null;
        if($files!=null){

        $request->validate([
            'nama'=>'required',
            'link' => 'max:10000|mimes:pdf,png,jpeg,xml,ppt,pptx,doc,docx,xls,xlsx', //10MB
        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);
            // dd(!Input::hasFile('files'));
            // dd($files,'aaa');
            $namafilebaru=date('YmdHis');

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('link');
                      // nama file
            echo 'File Name: '.$file->getClientOriginalName();
            echo '<br>';

                      // ekstensi file
            echo 'File Extension: '.$file->getClientOriginalExtension();
            // dd()
            echo '<br>';

                      // real path
            echo 'File Real Path: '.$file->getRealPath();
            echo '<br>';

                      // ukuran file
            echo 'File Size: '.$file->getSize();
            echo '<br>';

                      // tipe mime
            echo 'File Mime Type: '.$file->getMimeType();

                      // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'materi/';

                    // upload file
            $file->move($tujuan_upload,"materi/".$namafilebaru.'.'.$file->getClientOriginalExtension());
                $namafileku="materi/".$namafilebaru.'.'.$file->getClientOriginalExtension();


        materipokok::where('id',$id->id)
        ->update([
            'nama'=>$request->nama,
            'link'=>$namafileku,
            'updated_at'=>date("Y-m-d H:i:s")
        ]);
            }else{
            materipokok::where('id',$id->id)
            ->update([
                'nama'=>$request->nama,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

            }


    }
    public function materipokokupdate(Request $request, materipokok $id)
    {
        $this->materipokokproses_update($request,$id);

            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function store(Request $request,$pelajaran_nama,$kelas_nama,$tapel_nama){
        // RELASI
            // 1.tabel kompetensidasar
            // 2.tabel materipokok

        $p_nama=base64_decode($pelajaran_nama);
        $k_nama=base64_decode($kelas_nama);
        $t_nama=base64_decode($tapel_nama);

        $cekdatas=DB::table('kompetensidasar')->where('pelajaran_nama',$p_nama)
                ->where('kelas_nama',$k_nama)
                ->where('tapel_nama',$t_nama)
                ->where('kode',$request->kode)
                ->where('tipe',$request->tipe)
                  ->count();
                //   dd($request,$cekdatas);

        if($cekdatas>0){
            // update
            // dd('update');

            kompetensidasar::where('pelajaran_nama',$p_nama)
            ->where('kelas_nama',$k_nama)
            ->where('tapel_nama',$t_nama)
            ->where('tipe',$request->tipe)
            ->where('kode',$request->kode)
                ->update([
                    'nama'     =>   $request->nama,
                    'kode'     =>   $request->kode,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);


            materipokok::where('pelajaran_nama',$p_nama)
            ->where('kelas_nama',$k_nama)
            ->where('tapel_nama',$t_nama)
            ->where('kompetensidasar_tipe',$request->tipe)
            ->where('kompetensidasar_kode',$request->kode)
                ->update([
                    'kompetensidasar_nama'     =>   $request->nama,
                    'kompetensidasar_kode'     =>   $request->kode,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
                return redirect()->back()->with('status','Data berhasil di ubah!')->with('tipe','success')->with('icon','fas fa-feather');

        }else{
            // dd('insert');
            // insert
       DB::table('kompetensidasar')->insert(
        array(
               'nama'     =>   $request->nama,
               'kode'     =>   $request->kode,
               'tipe'     =>   $request->tipe,
               'pelajaran_nama'     =>   $p_nama,
               'kelas_nama'     =>   $k_nama,
               'tapel_nama'     =>   $t_nama,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
        }

            dd($request,$cekdatas);
    }

    public function materistore(Request $request,$pelajaran_nama,$kelas_nama,$tapel_nama){
        // dd($request);

        $request->validate([
            'nama'=>'required',
            'link' => 'max:10000|mimes:pdf,png,jpeg,xml,ppt,pptx,doc,docx,xls,xlsx', //10MB
        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);

        $p_nama=base64_decode($pelajaran_nama);
        $k_nama=base64_decode($kelas_nama);
        $t_nama=base64_decode($tapel_nama);

        $ambildatakompetensidasar=DB::table('kompetensidasar')->where('id',$request->kompetensidasar_id)->first();
        // dd($request,$ambildatakompetensidasar);

        $files = $request->file('link');

        $namafileku=null;
        if($files!=null){
            // dd(!Input::hasFile('files'));
            // dd($files,'aaa');
            $namafilebaru=date('YmdHis');

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('link');
                      // nama file
            echo 'File Name: '.$file->getClientOriginalName();
            echo '<br>';

                      // ekstensi file
            echo 'File Extension: '.$file->getClientOriginalExtension();
            // dd()
            echo '<br>';

                      // real path
            echo 'File Real Path: '.$file->getRealPath();
            echo '<br>';

                      // ukuran file
            echo 'File Size: '.$file->getSize();
            echo '<br>';

                      // tipe mime
            echo 'File Mime Type: '.$file->getMimeType();

                      // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'materi/';

                    // upload file
            $file->move($tujuan_upload,"materi/".$namafilebaru.'.'.$file->getClientOriginalExtension());
                $namafileku="materi/".$namafilebaru.'.'.$file->getClientOriginalExtension();
            }


        $cekdatas=DB::table('materipokok')->where('pelajaran_nama',$p_nama)
                ->where('kelas_nama',$k_nama)
                ->where('tapel_nama',$t_nama)
                ->where('kompetensidasar_kode',$ambildatakompetensidasar->kode)
                ->where('kompetensidasar_tipe',$ambildatakompetensidasar->tipe)
                ->where('nama',$request->nama)
                  ->count();
                //   dd($request,$cekdatas);

        if($cekdatas>0){

                return redirect()->back()->with('status','Data ditemukan, Sudah pernah ditambahkan!')->with('tipe','warning')->with('icon','fas fa-feather');
        }else{

       DB::table('materipokok')->insert(
        array(
               'nama'     =>   $request->nama,
               'link' => $namafileku,
            //    'link'     =>   $request->link,
               'kompetensidasar_tipe'     =>   $ambildatakompetensidasar->tipe,
               'kompetensidasar_nama'     =>   $ambildatakompetensidasar->nama,
               'kompetensidasar_kode'     =>   $ambildatakompetensidasar->kode,
               'pelajaran_nama'     =>   $p_nama,
               'kelas_nama'     =>   $k_nama,
               'tapel_nama'     =>   $t_nama,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    }
    public function materidestroy($id){
        // dd($id);
        // $p_nama=base64_decode($pelajaran_nama);
        // $k_nama=base64_decode($kelas_nama);
        // $t_nama=base64_decode($tapel_nama);

        DB::table('materipokok')->where('id', $id)->delete();
        return redirect()->back()->with('status','Data berhasil di hapus!')->with('tipe','danger')->with('icon','fas fa-feather');

    }

    public function destroy($id){
        // dd($id);
        // $p_nama=base64_decode($pelajaran_nama);
        // $k_nama=base64_decode($kelas_nama);
        // $t_nama=base64_decode($tapel_nama);

        DB::table('kompetensidasar')->where('id', $id)->delete();
        return redirect()->back()->with('status','Data berhasil di hapus!')->with('tipe','danger')->with('icon','fas fa-feather');

    }

}
