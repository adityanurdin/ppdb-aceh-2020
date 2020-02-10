<nav id="sidebar">
    <div class="sidebar-header">
        <img src="https://simppdbaceh.frandikasepta.com/assets/img/logo_1-min.png" class="img-thumbnail">
    </div>

    <ul class="list-unstyled components">
        <p>{{ucfirst(Auth::user()->username)}}</p>
        <li class="{{Request::route()->getName() == 'dashboard' ? 'active' : ''}}">
            <a href="{{route('dashboard')}}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        @if (Auth::user()->role == 'Admin System')
            <li class="">
                <a href="#menuKemenag" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-align-justify"></i> Menu Kemenag</a>
                <ul class="collapse list-unstyled" id="menuKemenag">
                    <li>
                        <a href="{{route('kemenag.index')}}">Data Operator</a>
                    </li>
                    <li class="">
                        <a href="#dataWeb" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Data Web</a>
                        <ul class="collapse list-unstyled" id="dataWeb">
                            <li>
                                <a href="#">Video</a>
                                <a href="#">Artikel</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        @endif

        @if (Auth::user()->role == 'Operator Kemenag' || Auth::user()->role == 'Operator Madrasah')
            <li class="">
                <a href="#dataWeb" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Web Informasi</a>
                <ul class="collapse list-unstyled" id="dataWeb">
                    <li>
                        <a href="#">Video</a>
                        <a href="#">Artikel</a>
                    </li>
                </ul>
            </li>
        @endif

        @if (Auth::user()->role == 'Peserta')    
            <li class="">
                <a href="#pilihPPDB" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pilih PPDB</a>
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
        @endif
        @if(Auth::user()->role != 'Peserta')
        <li>
            <a href="{{route('buka-ppdb')}}"><i class="fas fa-users"></i> Buka PPDB</a>
        </li>
        <li>
            <a href="#arsipPPDB" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-archive"></i> Arsip PPDB</a>
            <ul class="collapse list-unstyled" id="arsipPPDB">
                <li>
                    <a href="#">2019</a>
                    <a href="#">2020</a>
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
            <a href="#pengaturan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-cog"></i> Pengaturan</a>
            <ul class="collapse list-unstyled" id="pengaturan">
                <li>
                    <a href="#">Akun</a>
                </li>
                @if (Auth::user()->role == 'Admin System')
                <li>
                    <a href="#">Hapus Bank Soal</a>
                </li>
                @endif
            </ul>
        </li>
        <li>
            <a href="{{route('auth.logout')}}"><i class="fas fa-power-off"></i> Logout</a>
        </li>
    </ul>
</nav>