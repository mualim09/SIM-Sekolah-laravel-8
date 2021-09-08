
@section('title','Data Kepribadian')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','siakaddataajar')

@section('csshere')
@endsection

@section('jshere')
@endsection


@section('notif')

@if (session('tipe'))
        @php
        $tipe=session('tipe');    
        @endphp
@else
        @php
            $tipe='light';
        @endphp
@endif

@if (session('icon'))
        @php
        $icon=session('icon');    
        @endphp
@else
        @php
            $icon='far fa-lightbulb';
        @endphp
@endif

@php
  $message=session('status');
@endphp
@if (session('status'))
<x-alert tipe="{{ $tipe }}" message="{{ $message }}" icon="{{ $icon }}"/>

@endif
@endsection 


{{-- DATATABLE --}}
@section('headtable')
  <th width="5%" class="text-center">
    <input type="checkbox" id="chkCheckAll"> <label for="chkCheckAll"> All</label></th>
    <th>Nama Penilaian</th>
      @foreach ($datakelas as $dk)
        <th class="text-center"> {{ $dk->nama }} </th>
      @endforeach
  <th width="200px" class="text-center">Aksi</th>
@endsection

@section('bodytable')

<script>
  console.log('asdad');
  $().jquery;
  $.fn.jquery;
  $(function(e){
      $("#chkCheckAll").click(function(){
          $(".checkBoxClass").prop('checked',$(this).prop('checked'));
      })

      $("#deleteAllSelectedRecord").click(function(e){
          e.preventDefault();
          var allids=[];
              $("input:checkbox[name=ids]:checked").each(function(){
                  allids.push($(this).val());
              });

      $.ajax({
          url:"{{ route('kelas.multidel') }}",
          type:"DELETE",
          data:{
              _token:$("input[name=_token]").val(),
              ids:allids
          },
          success:function(response){
              $.each(allids,function($key,val){
                      $("#sid"+val).remove();
              })
          }
      });

      })

  });
</script>
@foreach ($datakepribadian as $dp)
<tr>
  <td> </td>
  <td> {{ $dp->nama }}</td>
  @foreach ($datakelas as $dk)
  @php
    $nama=$dk->nama;
  @endphp
    <td class="text-center">
      @php
        $tombol='';
        $guru='Belum diisi';
        $warna='warning';
      @endphp
   
        <br>
        <a href="{{ url('/admin/inputnilai/kepribadian') }}/{{ $dp->id }}/{{ $dk->id }}"  type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Input nilai Kepribadian"><i class="fas fa-ribbon"></i></a>
    </td>
  @endforeach
</tr>
@endforeach

<tr>
  <td class="text-left" colspan="2">
    <a href="#" class="btn btn-sm  btn-danger" id="deleteAllSelectedRecord"
    onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><i class="fas fa-trash"></i> Hapus Terpilih</a></td>
</tr>
@endsection

@section('foottable') 
  
@endsection

{{-- DATATABLE-END --}}
@section('container')


  <div class="section-body">
    <div class="row mt-sm-4">

      <div class="col-12 col-md-12 col-lg-12">
        <x-layout-table2 pages="{{ $pages }}" pagination=""/>
      </div>    
    
    </div>
  </div>
@endsection

@section('container-modals')

              <!-- Import Excel -->
              <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route('kelas.import') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                      </div>
                      <div class="modal-body">
           
                        {{ csrf_field() }}
           
                        <label>Pilih file excel(.xlsx)</label>
                        <div class="form-group">
                          <input type="file" name="file" required="required">
                        </div>
           
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

              @foreach ($datakepribadian as $dp)
                @foreach ($datakelas as $dk)

                    @php
                    $tombol='';
                  @endphp
                
                  <div class="modal fade" id="pilihguru{{ $dp->id }}_{{ $dk->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <form method="post" action="/admin/{{ $pages }}" enctype="multipart/form-data">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pilih Guru Pengampu</h5>
                          </div>
                          <div class="modal-body">
               
                            {{ csrf_field() }}
               
                            <label>Pilih</label>
                            <div class="form-group">
                              <input type="hidden" name="pelajaran_nama" value="{{ $dp->nama }}">
                              {{-- <input type="hidden" name="pelajaran_kelas_nama" value="{{ $dp->kelas_nama }}"> --}}
                              <input type="hidden" name="kelas_nama" value="{{ $dk->nama }}">
                              <select class="form-control form-control-lg" required name="guru_nomerinduk">  
                               
                              </select>
                            </div>
               
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  
                @endforeach
                
              @endforeach
          

@endsection
