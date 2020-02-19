<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="ROBOTS" content="noindex, nofollow" />
        <title>[ {{$data->kode_pendaftaran}} ]-[ {{ $data->peserta['nama'] }} ]-({{ date('dmy-His') }})</title>
        <link rel="stylesheet" type="text/css" href="{{asset('/css/cetak_pendaftaran.css')}}" />
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <style type="text/css">
        @page {
            size: A4;
            margin: 8;
        }
        @media print {
          html, body {
            width: 210mm;
            height: 297mm;
          }
        }
        .grid_keterangan{
            width: auto;
            height: auto;
            padding: 10px 0px;
            margin: auto;
            margin-top: 10px;
        }
        .grid_keterangan:before,.grid_keterangan:after{
            content: "";
            clear: both;
            display: table;
        }
        .grid_keterangan h1{
            font-weight: normal;
            font-size: 10pt;
            line-height: 0.8em;
            padding: 3px 0px;
            margin: auto;
            text-align: left;
            font-weight: bolder;
            text-decoration: underline;
        }
        .grid_keterangan h2{
            font-weight: normal;
            font-size: 9pt;
            line-height: 1em;
            padding: 1px 0px;
            margin: auto;
            text-align: left;
            font-weight: bolder;
            padding-left: 10px;
        }
        .grid_keterangan h2 i{
            width: 15px;
            font-size: 8pt;
        }
        .grid_keterangan h3{
            font-weight: normal;
            font-size: 8pt;
            line-height: 1.3em;
            padding: 1px 0px;
            margin: auto;
            text-align: left;
            font-weight: bolder;
            padding-left: 30px;
        }
        .grid_keterangan h3 i{
            width: 15px;
            font-size: 7pt;
        }
        .grid_persyaratan{
            width: 80%;
            height: auto;
            float: left;
            padding: 5px;
        }
        .grid_pasfoto{
            width: 20%;
            height: auto;
            float: left;
            padding: 5px;
            text-align: center;
        }
        .grid_pasfoto img{
            width: 30mm;
            height: 40mm;
            border: 2px solid #000;
            margin-bottom: 5px;
        }
        .grid_nomerurut{
            width: auto;
            height: auto;
            padding: 5px 0px 5px 5px;
            border: 5px;
            border-style: double;
            border-radius: 10px;
            border-color: green;
            font-size: 20pt;
            font-weight: bolder;
            color: green;
            letter-spacing: 5px;
            font-family: 'arial',cursive;
        }
        </style>
        
        <script language="JavaScript">
        window.onload = function () {
        document.addEventListener("contextmenu", function (e) {
        e.preventDefault();
        }, false);
        document.addEventListener("keydown", function (e) {
        //document.onkeydown = function(e) {
        // "I" key
        if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
        disabledEvent(e);
        }
        // "J" key
        if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
        disabledEvent(e);
        }
        // "S" key + macOS
        if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
        disabledEvent(e);
        }
        // "U" key
        if (e.ctrlKey && e.keyCode == 85) {
        disabledEvent(e);
        }
        // "F12" key
        if (event.keyCode == 123) {
        disabledEvent(e);
        }
        }, false);
        function disabledEvent(e) {
        if (e.stopPropagation) {
        e.stopPropagation();
        } else if (window.event) {
        window.event.cancelBubble = true;
        }
        e.preventDefault();
        return false;
        }
        }
        //edit: removed ";" from last "}" because of javascript error
        </script>
        
        <script type="text/javascript">
          window.print();
          window.onfocus=function(){ window.close();}
        </script>
        </head>
        <body onload="window.print()" class="body_wrapper">
            <!--WRAPPER START-->
            <div class="body_content">
            
                <!--HEADER-->
                <div class="grid_header">
                    <div class="logo_kemenag">
                        <img src="{{asset('img/kemenag-min.png')}}">
                    </div>
                    <div class="logo_kemenag_2">
                        <img src="{{asset('img/logo_1-min.png')}}">
                    </div>
                    <div class="header_kemenag">
                        <h1><b>SIM PPDB MADRASAH</b></h1>
                        <h1><b>KOTA BANDA ACEH</b></h1>
                        <h2>{{$madrasah->nama_madrasah}}</h2>
                        <h3>Tahun Akademik&nbsp; {{$data->pembukaan['tahun_akademik']}}</h3>
                    </div>
                </div>
            
                <!--BIODATA CALON PESERTA DIDIK BARU-->
                <div class="grid_body">
                    <div class="biodata">
                        <h1><i class="fa fa-user"></i>BIODATA PESERTA DIDIK BARU</h1>
                    </div>
                    <div class="data_diri">
                        <div class="nilai_proposal">
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="35%">Kode Pendaftaran</td>
                                        <td width="65%">: <b style="color:red;font-size:16pt;text-decoration:underline;">{{$data->kode_pendaftaran}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Pendaftaran</td>
                                        <td>: <b>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s' , $data->tgl_pendaftaran)->toDateString()}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Siswa</td>
                                        <td>: <b>{{$data->peserta['nama']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Tempat, Tanggal Lahir</td>
                                        <td>: <b>{{$data->peserta['tmp']}}, {{$data->peserta['tgl']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td>
                                        <td>: <b>{{$data->peserta['jkl']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Agama</td>
                                        <td>: <b>{{$data->peserta['agama']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Rumah</td>
                                        <td>: <b>{{$data->peserta['alamat_rumah']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ayah</td>
                                        <td>: <b>{{$data->peserta['nama_ayah']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>NIK KTP Ayah</td>
                                        <td>: <b>{{$data->peserta['nik_ayah']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Pekerjaan Ayah</td>
                                        <td>: <b>{{$data->peserta['pekerjaan_ayah']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ibu</td>
                                        <td>: <b>{{$data->peserta['nama_ibu']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>NIK KTP Ibu</td>
                                        <td>: <b>{{$data->peserta['nik_ibu']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Pekerjaan Ibu</td>
                                        <td>: <b>{{$data->peserta['pekerjaan_ibu']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Registrasi PPDB</td>
                                        <td>: <b>{{Carbon\Carbon::createFromFormat('Y-m-d h:i:s' , $data->peserta['tgl_registrasi'])->toDateString()}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Kontak/No.HP</td>
                                        <td>: <b>{{$data->peserta['kontak_peserta']}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>: <b>{{$data->peserta['email']}}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            
                <!--TTD-->
                <div class="grid_ttd">
                    <div class="ttd_">
                        <div class="div_ttd">
                            <h1>Peserta Didik</h1>
                            <h2>Kota Banda Aceh,<span></span>{{Carbon\Carbon::now()->format('F Y')}}</h2>
                            <h3>qsdasd</h3>
                            <h4>NISN. {{$data->peserta['nisn']}}</h4>
                        </div>
                    </div>
                    <div class="ttd_">
                        <div class="div_ttd">
                            <h1>Mengetahui, Orang Tua/Wali</h1>
                            <h2>Kota Banda Aceh,<span></span>{{Carbon\Carbon::now()->format('F Y')}}</h2>
                            <h3>&nbsp;</h3>
                            <h4>NIP.</h4>
                        </div>
                    </div>
                    <div class="ttd_">
                        <div class="div_ttd">
                            <h1>Panitia PPDB Madrasah</h1>
                            <h2>Kota Banda Aceh,<span></span>{{Carbon\Carbon::now()->format('F Y')}}</h2>
                            <h3>&nbsp;</h3>
                            <h4>NIP.</h4>
                        </div>
                    </div>
                </div>
            
                <!--TTD-->
                <div class="grid_keterangan">
                    <div class="grid_persyaratan">
                        <h1>Keterangan :</h1>
                        <h2><i class="fa fa-chevron-circle-right"></i>Bawa Bukti Pendaftaran Ini Ke Madrasah Yang Dituju/Didaftar.</h2>
                        <h2><i class="fa fa-chevron-circle-right"></i>Tanda Tangan Sebelum Menyerahkan Ke Panitia Pendaftaran.</h2>
                        <h2><i class="fa fa-chevron-circle-right"></i>Bawa Kelengkapan Lainnya Seperti :</h2>
                        @foreach ($persyaratan as $item)
                            <h3> <i class="fa fa-chevron-circle-right"></i> {{$item}} </h3>
                        @endforeach
                    </div>
                    <div class="grid_pasfoto">
                        <h5>PAS FOTO</h5>
                        <img src="{{ Dits::ImageUrl($data->peserta['pas_foto']) }}" draggable="false">
            
                        <h6>NOMOR PENDAFTARAN</h6>
                        <div class="grid_nomerurut">

                            @if ($data->pembukaan['status_nomor'] == 'yes')
                                {{ sprintf("%04d",$data->nomor_pendaftaran) }}
                            @else 
                                &nbsp;
                            @endif
                        </div>
                    </div>
                    <div class="frans_kecah"></div>
                </div>
            
            <!--WRAPPER END-->
            </div>
            </body>
            </html>
            
            {{-- @else
            <script type="text/javascript">
              window.onload=function(){ window.close();}
            </script>
            @else
            
            <script type="text/javascript">
              window.onload=function(){ window.close();}
            </script>
            @endif --}}