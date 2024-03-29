<nav id="sidebar">
    <div class="sidebar-header">
        <img src="{{asset('/img/logo_1-min.png')}}" class="img-thumbnail">
        {{-- <img src="https://simppdbaceh.frandikasepta.com/assets/img/logo_1-min.png" width="70%"> --}}
    </div>

    <ul class="list-unstyled components">
        <p style="text-align: center;">{{ucfirst(Auth::user()->username)}}</p>
        <li class="{{Request::route()->getName() == 'home' ? 'active' : ''}}">
            <a href="{{route('home')}}"><i class="fas fa-globe"></i> Portal Berita</a>
        </li>
        <li class="{{Request::route()->getName() == 'dashboard' ? 'active' : ''}}">
            <a href="{{route('dashboard')}}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        @if (Auth::user()->role == 'Admin System')
        <li class="">
            <a href="#menuKemenag" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                    class="fas fa-align-justify"></i> Menu Kemenag</a>
            <ul class="collapse list-unstyled" id="menuKemenag">
                <li>
                    <a href="{{route('kemenag.index')}}">Data Operator</a>
                </li>
                <li class="">
                    <a href="#dataWeb" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Data Web</a>
                    <ul class="collapse list-unstyled" id="dataWeb">
                        <li>
                            <a href="{{route('video.list')}}">Video</a>
                            <a href="{{route('artikel.list')}}">Artikel</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        @endif

        @if (Auth::user()->role == 'Operator Kemenag' || Auth::user()->role == 'Operator Madrasah')
        <li class="">
            <a href="#dataWeb" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                    class="fab fa-chrome"></i> Web Informasi</a>
            <ul class="collapse list-unstyled" id="dataWeb">
                <li>
                    <a href="{{route('video.list')}}">Video</a>
                    <a href="{{route('artikel.list')}}">Artikel</a>
                </li>
            </ul>
        </li>
        @endif

        @if (Auth::user()->role == 'Peserta')
        <li class="">
            <a href="#pilihPPDB" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                    class="fas fa-users"></i> Pilih PPDB</a>
            <ul class="collapse list-unstyled" id="pilihPPDB">
                <li>
                    <a href="{{route('ppdb.list.id' , base64_encode('DITSMI'))}}">MI</a>
                </li>
                <li>
                    <a href="{{route('ppdb.list.id' , base64_encode('DITSMTs'))}}">MTs</a>
                </li>
                <li>
                    <a href="{{route('ppdb.list.id' , base64_encode('DITSMA'))}}">MA</a>
                </li>
            </ul>
        </li>
        @php
        $uuid_peserta = \Auth::user()->uuid_login;
        $pendaftaran = \App\Models\Pendaftaran::where('uuid_peserta' , $uuid_peserta)
        ->first();
        @endphp
        @isset($pendaftaran)
        <li>
            <a href="{{route('buka-ppdb.madrasah-terpilih')}}"><i class="fas fa-check"></i> Madrasah Terpilih</a>
        </li>
        @php
        $tahun = date('Y');
        $pendaftaran =
        \App\Models\Pendaftaran::whereUuidPeserta($uuid_peserta)->whereYear('created_at',$tahun)->first();
        $jenjang = $pendaftaran->pembukaan->madrasah->jenjang;
        @endphp
        @if ($jenjang!="MI")
        <li>
            <a href="{{route('cat.index')}}"><i class="fas fa-tv"></i> Ujian CAT</a>
        </li>
        @endif
        @endisset
        @endif
        @if(Auth::user()->role != 'Peserta')
        <li>
            <a href="{{route('buka-ppdb')}}"><i class="fas fa-users"></i> Buka PPDB</a>
        </li>
        <li>
            <a href="#arsipPPDB" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                    class="fas fa-archive"></i> Arsip PPDB</a>
            <ul class="collapse list-unstyled" id="arsipPPDB">
                <li>
                    @php
                    $tahun = \App\Models\Pembukaan::groupBy(DB::raw('YEAR(created_at)'))->orderBy('created_at' ,
                    'ASC')->get();
                    @endphp
                    @foreach ($tahun as $item)
                    <a
                        href="{{route('arsip.ppdb' , [substr($item->tgl_pembukaan , 0 , 4)])}}">{{substr($item->tgl_pembukaan , 0 , 4)}}</a>
                    @endforeach
                </li>
            </ul>
        </li>
        <li>
            <a href="{{route('bank-soal.index')}}"><i class="fas fa-tv"></i> Bank Soal CAT</a>
        </li>
        <li>
            <a href="#arsipCAT" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                    class="fas fa-archive"></i> Arsip Soal CAT</a>
            <ul class="collapse list-unstyled" id="arsipCAT">
                <li>
                    @php
                    $tahun = \App\Models\BankSoal::groupBy(DB::raw('YEAR(created_at)'))->orderBy('created_at' ,
                    'ASC')->get();
                    @endphp
                    @foreach ($tahun as $item)
                    <a
                        href="{{route('arsip.cat' , [substr($item->tgl_bank_soal , 0 , 4)])}}">{{substr($item->tgl_bank_soal , 0 , 4)}}</a>
                    @endforeach
                </li>
            </ul>
        </li>
        @if (Auth::user()->role != 'Operator Madrasah' && Auth::user()->role != 'Peserta')
        <li class="{{Request::route()->getName() == 'madrasah.index' ? 'active' : ''}}">
            <a href="{{route('madrasah.index')}}"><i class="fas fa-building"></i> Database Madrasah</a>
        </li>
        @endif
        @endif
        <li>
            <a href="#pengaturan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                    class="fas fa-cog"></i> Pengaturan</a>
            <ul class="collapse list-unstyled" id="pengaturan">
                <li>
                    <a href="{{route('auth.akun')}}">Akun</a>
                </li>
                @if (Auth::user()->role == 'Operator Madrasah')
                <li>
                    <a href="{{route('madrasah.self.edit')}}">Edit Profile Madrasah</a>
                </li>
                @endif
            </ul>
        </li>
        <li>
            <a href="{{route('auth.logout')}}"><i class="fas fa-power-off"></i> Logout</a>
        </li>
    </ul>
</nav>