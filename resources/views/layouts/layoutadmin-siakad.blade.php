@php
    if(empty($pages)){
        $pages='kosong';
    }

    $ambilsettings = DB::table('settings')
      ->where('id', '=', '1')
      ->get();
      foreach ($ambilsettings as $settings) {
      }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title') - [SIAKAD] {{ $settings->aplikasijudul }} </title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset("assets/") }}/css/style.css">
  <link rel="stylesheet" href="{{ asset("assets/") }}/css/components.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
crossorigin="anonymous"></script>
  @yield('csshere')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
       
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            
          <figure class="avatar avatar-sm">
                <img alt="image" src="{{ Auth::user()->profile_photo_url }}" class="rounded-circle mr-1"  >

          </figure>
                {{-- <img alt="image" src="{{ asset("assets/") }}/img/avatar/avatar-1.png" class="rounded-circle mr-1"> --}}
            
            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in</div>
            
              <a href="{{ route('profile.show') }}"  class="dropdown-item has-icon">
                <i class="fas fa-user"></i>
                {{ __('Profile') }}
            </a>
          
              <div class="dropdown-divider"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf

            
                    <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt">    
                        </i> Logout
                      </a>
            </form>
             
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ route('siakad.admin.beranda') }}">SIAKAD SEKOLAH</a>
          </div>

          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('siakad.admin.beranda') }}">SIAKAD</a>
          </div>
          <ul class="sidebar-menu">

              <li class="menu-header">SIAKAD</li>
        @if(((Auth::user()->tipeuser)=='admin')||((Auth::user()->tipeuser)=='kepsek'))
            
              <li @if ($pages==='beranda')
              class="active"
              @endif >
                <a href="{{ route('siakad.admin.beranda') }}" class="nav-link"><i class="fas fa-home"></i><span>Beranda</span></a>
              </li>
          @endif



              <li @if ($pages==='profil')
                class="active"
                @endif >
                <a href="{{ route('profile.show') }}" class="nav-link"><i class="far fa-address-card"></i><span>Profile</span></a>
              </li>

@php
if((Auth::user()->tipeuser)=='admin'){
    @endphp

               
              <li class="menu-header">Mastering</li>

              {{--  <li @if ($pages==='kategori')
                class="active"
                @endif >
                <a href="{{ route('kategori') }}" class="nav-link"><i class="fab fa-korvue"></i><span>Kategori</span></a>
              </li> --}}

              <li @if ($pages==='siakadtapel')
                class="active"
                @endif >
                <a href="{{ route('siakadtapel') }}" class="nav-link"><i class="fas fa-calendar-alt"></i><span>Tahun Pelajaran</span></a>
              </li>
              <li @if ($pages==='siakadkelas')
                class="active"
                @endif >
                <a href="{{ route('siakadkelas') }}" class="nav-link"><i class="fas fa-school"></i><span>Kelas dan Wali kelas</span></a>
              </li>

              <li @if ($pages==='siakadjenisnilai')
                class="active"
                @endif >
                <a href="{{ route('siakadjenisnilai') }}" class="nav-link"><i class="fas fa-building"></i><span>Jenis Nilai</span></a>
              </li>
              <li @if ($pages==='siakadpelajaran')
                class="active"
                @endif >
                <a href="{{ route('siakadpelajaran') }}" class="nav-link"><i class="fas fa-building"></i><span>Mata Pelajaran</span></a>
              </li>

              <li @if ($pages==='pegawai')
                class="active"
                @endif >
                <a href="{{ route('siakadpegawai') }}" class="nav-link"><i class="fas fa-building"></i><span>Kepribadian</span></a>
              </li>

              <li @if ($pages==='pegawai')
                class="active"
                @endif >
                <a href="{{ route('siakadpegawai') }}" class="nav-link"><i class="fas fa-building"></i><span>Ekstrakulikuler</span></a>
              </li>
              <li @if ($pages==='siswa')
                class="active"
                @endif >
                <a href="{{ route('siakadsiswa') }}" class="nav-link"><i class="fas fa-user-graduate"></i><span>Siswa</span></a>
              </li>
              <li @if ($pages==='siakadguru')
                class="active"
                @endif >
                <a href="{{ route('siakadguru') }}" class="nav-link"><i class="fas fa-building"></i><span>Guru</span></a>
              </li>
              <li @if ($pages==='pegawai')
                class="active"
                @endif >
                <a href="{{ route('siakadpegawai') }}" class="nav-link"><i class="fas fa-building"></i><span>Pegawai</span></a>
              </li>
              
         
              {{-- <li class="active"><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li> --}}
             
              <li class="menu-header">Transaksi</li>
              {{--   <li @if ($pages==='siakadpegawai')
                class="active"
                @endif >
                <a href="{{ route('pegawai') }}" class="nav-link"><i class="fas fa-building"></i><span>Wali Kelas</span></a>
              </li>--}}
              <li @if ($pages==='siakaddataajar')
                class="active"
                @endif >
                <a href="{{ route('siakaddataajar') }}" class="nav-link"><i class="fas fa-building"></i><span>Data Ajar</span></a>
              </li>
              <li @if ($pages==='siakadpegawai')
                class="active"
                @endif >
                <a href="{{ route('pegawai') }}" class="nav-link"><i class="fas fa-building"></i><span>Nilai Pelajaran</span></a>
              </li>
              <li @if ($pages==='siakadpegawai')
                class="active"
                @endif >
                <a href="{{ route('pegawai') }}" class="nav-link"><i class="fas fa-building"></i><span>Nilai Kepribadian</span></a>
              </li>
              <li @if ($pages==='siakadpegawai')
                class="active"
                @endif >
                <a href="{{ route('siakadpegawai') }}" class="nav-link"><i class="fas fa-building"></i><span>Nilai Ekstrakulikuler</span></a>
              </li>


              <li class="menu-header">Reporting</li>
              <li @if ($pages==='laporan')
                class="active"
                @endif >
                <a href="{{ route('siakadlaporan') }}" class="nav-link"><i class="fab fa-resolving"></i><span>Raport Siswa</span></a>
              </li>
              <li @if ($pages==='laporan')
                class="active"
                @endif >
                <a href="{{ route('siakadlaporan') }}" class="nav-link"><i class="fab fa-resolving"></i><span>Laporan Nilai Siswa</span></a>
              </li>
              <li @if ($pages==='laporan')
                class="active"
                @endif >
                <a href="{{ route('siakadlaporan') }}" class="nav-link"><i class="fab fa-resolving"></i><span>Laporan Absensi</span></a>
              </li>
             
              <li class="menu-header">Menu Tahunan</li>
              

              <li @if ($pages==='eoy')
                class="active"
                @endif >
                <a href="{{ route('siakadeoy') }}" class="nav-link"><i class="far fa-calendar-check"></i><span>EoY</span></a>
              </li>

              <li @if ($pages==='soy')
                class="active"
                @endif >
                <a href="{{ route('siakadsoy') }}" class="nav-link"><i class="far fa-calendar-plus"></i><span>SoY</span></a>
              </li>

              <li class="menu-header">Menu Arsip</li>
              

              <li @if ($pages==='arsip')
                class="active"
                @endif >
                <a href="{{ route('siakadarsip') }}" class="nav-link"><i class="fas fa-history"></i><span>Arsip</span></a>
              </li>

            </ul>

            @php
    }elseif((Auth::user()->tipeuser)=='kepsek'){
        @endphp
              <li class="menu-header">Menu Kepala Sekolah</li>
              <li @if ($pages==='laporan')
                class="active"
                @endif >
                <a href="{{ route('laporan') }}" class="nav-link"><i class="fab fa-korvue"></i><span>Laporan Keuangan</span></a>
              </li>

              <li @if ($pages==='tagihansiswa')
                class="active"
                @endif >
                <a href="{{ route('kepsek.tagihansiswa') }}" class="nav-link"><i class="fab fa-korvue"></i><span>Pembayaran Siswa</span></a>
              </li>

        @php
    }elseif((Auth::user()->tipeuser)=='siswa'){
        @endphp
              <li class="menu-header">Menu Siswa</li>
              <li @if ($pages==='tagihansiswa')
                class="active"
                @endif >
                <a href="{{ route('siswa.tagihansiswa') }}" class="nav-link"><i class="fab fa-korvue"></i><span>Tagihanku</span></a>
              </li>

        @php
    }
        @endphp
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">


        <section class="section">

          {{-- HEADER-START --}}
          <div class="section-header">
            <h1>@yield('title')</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                {{-- <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div> --}}
              <div class="breadcrumb-item">@yield('halaman')</div>
            </div>
          </div>
          {{-- HEADER-END --}}

          @yield('notif')

            @yield('container')



        </section>
        @yield('container-modals')




      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2022
        </div>
        @php
        // exec('git rev-parse --verify HEAD 2> /dev/null', $output);
        // $hash = $output[0];
        // dd($hash)

        $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));

        $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
        $commitDate->setTimezone(new \DateTimeZone('UTC'));

        // dd($commitDate);
        // dd($commitDate->format('Y-m-d H:i:s'));
        $versi=$commitDate->format('Ymd.H.i.s');
    @endphp
        <div class="footer-right">
          v2. {{ $versi }}
        </div>
      </footer>
    </div>
  </div>

  @yield('jshere')
  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset("assets/") }}/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="{{ asset("assets/") }}/js/scripts.js"></script>
  <script src="{{ asset("assets/") }}/js/custom.js"></script>
  <script src="{{ asset("assets/") }}/js/page/bootstrap-modal.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>