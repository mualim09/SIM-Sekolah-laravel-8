@extends('layouts.layoutadminv3')

@section('title','Beranda')
@section('halaman')
<div class="breadcrumb-item"> Index</div>
@endsection

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

@if (session('status'))

  <div class="alert alert-{{ $tipe }} alert-has-icon alert-dismissible show fade">
    <div class="alert-icon"><i class="{{ $icon }}"></i></div>
                      <div class="alert-body">
                        <div class="alert-title">{{ Str::ucfirst($tipe) }}</div>
                        <button class="close" data-dismiss="alert">
                          <span>&times;</span>
                        </button>
                        {{ session('status') }}
                      </div>
                    </div>
@endif
@endsection

@php
$tipeuser=(Auth::user()->tipeuser);
@endphp

@if(($tipeuser)==='kepsek')
  @php
      $hakakses='Kepala Sekolah';
  @endphp
@elseif(($tipeuser)==='admin')
@php
    $hakakses='Administrator';
@endphp
@elseif(($tipeuser)==='siswa')
@php
    $hakakses='Siswa';
@endphp
@elseif(($tipeuser)==='guru')
@php
    $hakakses='guru';
@endphp
@endif



{{-- DATALAPORAN --}}
@php
// $sumpemasukan = DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])
//   ->sum('nominal');
$sumpemasukan = DB::table('pemasukan')
  ->sum('nominal');

$countpemasukan = DB::table('pemasukan')
  ->count();

// $sumpemasukanbos = DB::table('pemasukan')->where('kategori_nama','Dana Bos')
//   ->sum('nominal');

// $countpemasukanbos = DB::table('pemasukan')->where('kategori_nama','Dana Bos')
//   ->count();

$countpengeluaran = DB::table('pengeluaran')
  ->count();


$sumpengeluaran = DB::table('pengeluaran')
  ->sum('nominal');

$sumtagihansiswa = DB::table('tagihansiswadetail')
  ->sum('nominal');

$counttagihansiswa = DB::table('tagihansiswadetail')
  ->count();

// $totalpemasukan=$sumpemasukan+$sumtagihansiswa+$sumpemasukanbos;
$totalpemasukan=$sumpemasukan+$sumtagihansiswa;
$sisasaldo=$totalpemasukan-$sumpengeluaran;


$ambilkepsek = DB::table('users')
->where('tipeuser','kepsek')
  ->get();
  foreach ($ambilkepsek as $kepsek) {
      # code...
  }
@endphp
{{-- DATALAPORAN-END --}}
@section('container')


{{-- <div class="section-header">
    <h1>Typography</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>
      <div class="breadcrumb-item">Typography</div>
    </div>
  </div> --}}


  <div class="section-body">
    <h2 class="section-title">Hi, {{ Auth::user()->name }} dari {{ $sekolahnama }} ! Anda Login sebagai {{ $hakakses }}</h2>
    <p class="section-lead">
     Berikut beberapa Informasi tetang data dan menu di Sistem Ini.
    </p>



    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-6">
        <div class="card profile-widget">
          <div class="profile-widget-header">
            <img alt="image" src="../assets/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Kelas</div>
                <div class="profile-widget-item-value"> {{ $kelas }} Kelas</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Siswa</div>
                <div class="profile-widget-item-value">{{ $siswa }} Siswa</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Lunas</div>
                <div class="profile-widget-item-value">{{ $lunas }} </div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Belum Lunas</div>
                <div class="profile-widget-item-value"> {{ $belumlunas }} </div>
              </div>
            </div>
          </div>

          {{-- <div class="card-footer text-center">
            <div class="font-weight-bold mb-2">Lihat Selengkapnya</div>
            <a href="#" class="btn btn-info mr-1">
              <i class="fas fa-angle-double-right"></i>
            </a>

          </div> --}}


        </div>







          @if($tipeuser==='admin')


          <div class="card profile-widget mt-5">
            <div class="profile-widget-header">
              <img alt="image" src="https://ui-avatars.com/api/?name=Download dan Guide&color=FFEDDA&background=3DB2FF" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">
                <h3 class="ml-5 mt-4">Download dan Guide</h3>
              </div>


                <div class="card-body">
                  <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                    <a  href="{{ route('formatimport') }}" type="button" class="btn btn-warning"><i class="fab fa-korvue"></i> Download Format Import</a>
                  </div>

                  <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                    <a  href="{{ route('guide') }}" type="button" class="btn btn-primary"><i class="fas fa-calendar-alt"></i> Pentunjuk Penggunaan</a>
                    {{-- <a  href="{{ route('kelas') }}" type="button" class="btn btn-primary"><i class="fas fa-school"></i> Kelas</a>    --}}
                  </div>
                  </div>

            </div>



          </div>




          @endif


      </div>

    @if($tipeuser==='admin')
    <div class="col-12 col-md-12 col-lg-6">

      <div class="card profile-widget mt-5">
        <div class="profile-widget-header">
          <img alt="image" src="https://ui-avatars.com/api/?name=Menu Penting&color=FFEDDA&background=3DB2FF" class="rounded-circle profile-widget-picture">
          <div class="profile-widget-items">
            <h3 class="ml-5 mt-4">Menu Penting</h3>

          </div>

          <div class="card-body">
          <div class="btn-group btn-group-lg mt-3" role="group" aria-label="Basic example">

            <button type="button" class="btn btn-icon btn-info btn-md" data-toggle="modal"  data-placement="top" title="File sampah sisa export dan import! Agar tidak membebani server."  data-target="#cleartemp"><i class="fas fa-trash"></i>
              Hapus File Sampah
            </button>

          <a href="/admin/datatagihan/addall"  class="btn btn-icon btn-warning btn-md" data-toggle="tooltip" data-placement="top" title="Tambah semua kelas yang belum di setting. Kemudian Syncron ke menu tagihan siswa!"><span
            class="pcoded-micon"> <i class="far fa-plus-square"></i> Fungsi Tambah Semua </span></a >

              </div>
              </div>
      </div>
      </div>







    </div>
    @endif


@if($tipeuser==='admin')
<div class="col-12 col-md-12 col-lg-6">




</div>
@endif



  </div>


  <div class="row">
    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4>Statistik Pembayaran terakhir</h4>
          <div class="card-header-action">
            <div class="btn-group">
              <a href="#" class="btn btn-primary">Week</a>
              <a href="#" class="btn">Month</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="myChart" height="182"></canvas>
          <div class="statistic-details mt-sm-4">
            <div class="statistic-details-item">
              <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span>
              <div class="detail-value">$243</div>
              <div class="detail-name">Today's Sales</div>
            </div>
            <div class="statistic-details-item">
              <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>
              <div class="detail-value">$2,902</div>
              <div class="detail-name">This Week's Sales</div>
            </div>
            <div class="statistic-details-item">
              <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</span>
              <div class="detail-value">$12,821</div>
              <div class="detail-name">This Month's Sales</div>
            </div>
            <div class="statistic-details-item">
              <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</span>
              <div class="detail-value">$92,142</div>
              <div class="detail-name">This Year's Sales</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
<script>
"use strict";

var statistics_chart = document.getElementById("myChart").getContext('2d');

var myChart = new Chart(statistics_chart, {
type: 'line',
data: {
labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
datasets: [{
  label: 'Statistics',
  data: [640, 387, 530, 302, 430, 270, 488],
  borderWidth: 5,
  borderColor: '#6777ef',
  backgroundColor: 'transparent',
  pointBackgroundColor: '#fff',
  pointBorderColor: '#6777ef',
  pointRadius: 4
}]
},
options: {
legend: {
  display: false
},
scales: {
  yAxes: [{
    gridLines: {
      display: false,
      drawBorder: false,
    },
    ticks: {
      stepSize: 150
    }
  }],
  xAxes: [{
    gridLines: {
      color: '#fbfbfb',
      lineWidth: 2
    }
  }]
},
}
});

$('#visitorMap').vectorMap(
{
map: 'world_en',
backgroundColor: '#ffffff',
borderColor: '#f2f2f2',
borderOpacity: .8,
borderWidth: 1,
hoverColor: '#000',
hoverOpacity: .8,
color: '#ddd',
normalizeFunction: 'linear',
selectedRegions: false,
showTooltip: true,
pins: {
id: '<div class="jqvmap-circle"></div>',
my: '<div class="jqvmap-circle"></div>',
th: '<div class="jqvmap-circle"></div>',
sy: '<div class="jqvmap-circle"></div>',
eg: '<div class="jqvmap-circle"></div>',
ae: '<div class="jqvmap-circle"></div>',
nz: '<div class="jqvmap-circle"></div>',
tl: '<div class="jqvmap-circle"></div>',
ng: '<div class="jqvmap-circle"></div>',
si: '<div class="jqvmap-circle"></div>',
pa: '<div class="jqvmap-circle"></div>',
au: '<div class="jqvmap-circle"></div>',
ca: '<div class="jqvmap-circle"></div>',
tr: '<div class="jqvmap-circle"></div>',
},
});

// weather
getWeather();
setInterval(getWeather, 600000);

function getWeather() {
$.simpleWeather({
location: 'Bogor, Indonesia',
unit: 'c',
success: function(weather) {
var html = '';
html += '<div class="weather">';
html += '<div class="weather-icon text-primary"><span class="wi wi-yahoo-' + weather.code + '"></span></div>';
html += '<div class="weather-desc">';
html += '<h4>' + weather.temp + '&deg;' + weather.units.temp + '</h4>';
html += '<div class="weather-text">' + weather.currently + '</div>';
html += '<ul><li>' + weather.city + ', ' + weather.region + '</li>';
html += '<li> <i class="wi wi-strong-wind"></i> ' + weather.wind.speed+' '+weather.units.speed + '</li></ul>';
html += '</div>';
html += '</div>';

$("#myWeather").html(html);
},
error: function(error) {
$("#myWeather").html('<div class="alert alert-danger">'+error+'</div>');
}
});
}
</script>

@endsection

@section('container-modals')

              <!-- Import Excel -->
              <div class="modal fade" id="cleartemp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route('cleartemp') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Temporari</h5>
                      </div>
                      <div class="modal-body">

                        {{ csrf_field() }}

                        <label></label>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus!</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
@endsection
