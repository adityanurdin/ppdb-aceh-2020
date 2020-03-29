@if (\session('cat_ujian')!="start")
<script>
    document.location="{!! route('dashboard') !!}"
</script>
@endif
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="ROBOTS" content="noindex, nofollow" />
    <meta name="author" content="https://codingers.id/ | Frandika Septa" />
    <meta name="application-name" content="SIM PPDB MADRASAH KOTA BANDA ACEH" />
    <meta name="msapplication-TileImage" content="{{ asset('img/favicon/ms-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/favicon/apple-icon-57x57.png') }}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/favicon/apple-icon-60x60.png') }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/favicon/apple-icon-72x72.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicon/apple-icon-76x76.png') }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/favicon/apple-icon-114x114.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/favicon/apple-icon-120x120.png') }}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/favicon/apple-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/favicon/apple-icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-icon-180x180.png') }}" />
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/favicon/android-icon-192x192.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicon/favicon-96x96.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ asset('img/favicon/manifest.json') }}" />
    <title>{{ strtoupper(isset(Dits::DataPeserta()->nama)) ? Dits::DataPeserta()->nama : Auth::user()->role }} - SIM
        PPDB Madrasah Kota Banda Aceh</title>
    <script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/timer-cat.js?v=290320') }}"></script>
    <script type="text/javascript" src="{{ asset('js/cat_frandikasepta.js?v=290320') }}"></script>
    <link rel="stylesheet" type="text/css" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cat_frandikasepta.css?v=290320') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/res_cat_frandikasepta.css?v=290320') }}" />
    <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
<script>
        
</script>
</head>

<body onload="SoalOnReload();" oncontextmenu="return false;" oncopy="return false" oncut="return false"
onpaste="return false">
    {{--  Wrapper  --}}
    <div class="wrapper">
        <div id="tess"></div>
        {{--  Header  --}}
        <section id="header">
            <div class="judul">
                <h1>Aplikasi CAT SIM PPDB Madrasah</h1>
                <h2>Kota Banda Aceh Tahun {{ date('Y') }}</h2>
            </div>
            <div class="logo">
                <img src="{{ asset('img/logo-min.png') }}" alt="SIM PPDB Madrasah Kota Banda Aceh">
            </div>
            <div class="timer">
                <h1>Sisa Waktu Ujian:</h1>
                <h2 id="timer"></h2>
            </div>
            {{--  MODALS  --}}
            <div class="modal fade" id="selesaiModal">
                <div class="modal-dialog">
                    <div class="modal-content bg-success">
                        <div class="modal-header text-white">
                            <h5 class="modal-title"><i class="fa fa-check-circle"></i> Selesaikan Ujian&quest;</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-left bg-white">
                            <h5>Anda Yakin Untuk Mengakhiri Ujian CAT&quest;</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-outline-light" data-dismiss="modal"><i
                                    class="fa fa-times-circle"></i> Tutup</button>
                            <button type="button" class="btn btn-sm btn-outline-light" data-dismiss="modal"
                                onclick="selesai('{!! route('cat.end') !!}');"><i class="fa fa-check-circle"></i> Ya</button>
                        </div>
                    </div>
                </div>
            </div>
            {{--  MODALS  --}}
        </section>
        {{--  Header  --}}

        {{--  Content  --}}
        <section id="content">
            <div class="container-fluid">
                <div class="row">
                    {{--  Informasi Ujian  --}}
                    <div class="col-lg-3 col-md-12">
                        <div class="data_diri">
                            <div class="judul">
                                <h1><i class="fa fa-info-circle"></i> Informasi Ujian</h1>
                            </div>
                            <div class="data">
                                <div class="pt-2">
                                    <label>Nama Peserta :</label>
                                    <p>{{ Dits::DataPeserta()->nama }}</p>
                                </div>
                                <div class="pt-2">
                                    <label>NIK :</label>
                                    <p>{{ Dits::DataPeserta()->NIK }}</p>
                                </div>
                                <div class="pt-2">
                                    <label>Kode Pendaftaran :</label>
                                    <p>{{ $pendaftaran->kode_pendaftaran }}</p>
                                </div>
                                <div class="pt-2">
                                    <label>Kode Soal :</label>
                                    <p>{{ $bank_soal->kode_soal }}</p>
                                </div>
                                <div class="pt-2">
                                    <label>Waktu Sesi Ujian :</label>
                                    <p>{{ $bank_soal->timer_cat }} Menit</p>
                                </div>
                                <div class="pt-2">
                                    <label>Nama Madrasah :</label>
                                    <p>{{ $bank_soal->madrasah->nama_madrasah }}</p>
                                </div>
                                <div class="pt-2">
                                    <label>Tanggal Ujian :</label>
                                    <p>{{ date('D, d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  Informasi Ujian  --}}

                    {{--  Soal Ujian  --}}
                    <div class="col-lg-6 col-md-12">
                        <div class="soal">
                            <div class="judul">
                                <h1><i class="fa fa-file-alt"></i> Soal Ujian</h1>
                            </div>

                            @foreach ($soal as $data)
                            @php
                            $jawab = \App\Models\Jawaban::where('kode_soal' , $data->kode_soal)
                            ->where('kode_pendaftaran' , $pendaftaran->kode_pendaftaran)
                            ->where('nomor_soal' , $data->nomor_soal)
                            ->first();
                            @endphp
                            {{--  Data Soal  --}}
                            <div class="data" id="Soal_{{$data->nomor_soal}}">
                                <div class="nomor">
                                    <label>Soal Nomor : <span>{{ $data->nomor_soal }}</span></label>
                                    <div class="sparator">&nbsp;</div>
                                    <label>Mata Pelajaran : <span>{{ $data->jenis_soal }}</span></label>
                                </div>
                                <hr>
                                <div class="text">
                                    {!! $data->soal !!}
                                    @if (!empty($data->gambar))
                                    <img src="{{Dits::imageUrl($data->gambar)}}" alt="">
                                    @endif
                                </div>
                                <div class="jawaban">
                                    <form action="" id="form_soal_{{ $data->nomor_soal}}" method="POST">
                                        @csrf
                                        {{--  Hidden  --}}
                                        <input type="hidden" name="uuid_jawaban" id="id_jawaban_{{ $data->nomor_soal}}"
                                            value="{{Dits::encodeDits($jawab['uuid'])}}" readonly>
                                        <input type="hidden" name="nomor_soal" id="nomor_soal_{{ $data->nomor_soal}}"
                                            value="{{Dits::encodeDits($data->nomor_soal)}}" readonly>
                                        <input type="hidden" name="kode_soal" id="kode_soal_{{ $data->nomor_soal}}"
                                            value="{{Dits::encodeDits($data->kode_soal)}}" readonly>
                                        <input type="hidden" name="kode_pendaftaran" id="kode_pendaftaran_{{ $data->nomor_soal}}"
                                            value="{{Dits::encodeDits($pendaftaran->kode_pendaftaran)}}" readonly>
                                        <input type="hidden" name="nums" id="nums__{{ $data->nomor_soal}}"
                                            value="{{Dits::encodeDits($data->nomor_soal)}}" readonly>
                                        {{--  Hidden  --}}
                                        {{--  Pilihan Jawaban  --}}
                                        {{ $data->jawaban }}
                                        <div class="pilihan">
                                            <div class="icheck-success d-inline">
                                                <input type="radio" name="jawaban[]" id="jawaban_A_{{ $data->nomor_soal}}" value="A"
                                                    @if($jawab->jawaban=="A") checked @endif
                                                onclick="SendTable('{{$data->nomor_soal}}','A')">
                                                <label for="jawaban_A_{{ $data->nomor_soal}}">{{ $data->a }}</label>
                                            </div>
                                        </div>
                                        <div class="pilihan">
                                            <div class="icheck-success d-inline">
                                                <input type="radio" name="jawaban[]" id="jawaban_B_{{ $data->nomor_soal}}" value="B"
                                                    @if($jawab->jawaban=="B") checked @endif
                                                onclick="SendTable('{{$data->nomor_soal}}','B')">
                                                <label for="jawaban_B_{{ $data->nomor_soal}}">{{ $data->a }}</label>
                                            </div>
                                        </div>
                                        <div class="pilihan">
                                            <div class="icheck-success d-inline">
                                                <input type="radio" name="jawaban[]" id="jawaban_C_{{ $data->nomor_soal}}" value="C"
                                                    @if($jawab->jawaban=="C") checked @endif
                                                onclick="SendTable('{{$data->nomor_soal}}','C')">
                                                <label for="jawaban_C_{{ $data->nomor_soal}}">{{ $data->a }}</label>
                                            </div>
                                        </div>
                                        <div class="pilihan">
                                            <div class="icheck-success d-inline">
                                                <input type="radio" name="jawaban[]" id="jawaban_D_{{ $data->nomor_soal}}" value="D"
                                                    @if($jawab->jawaban=="D") checked @endif
                                                onclick="SendTable('{{$data->nomor_soal}}','D')">
                                                <label for="jawaban_D_{{ $data->nomor_soal}}">{{ $data->a }}</label>
                                            </div>
                                        </div>
                                        {{--  Pilihan Jawaban  --}}
                                    </form>
                                </div>
                                <div id="notifikasi_{{ $data->nomor_soal}}" class="py-1">
                                    {{--  Notifikasi  --}}
                                </div>
                                <hr>
                            </div>
                            {{--  Data Soal  --}}
<script type="text/javascript">
$(document).ready(function() {
    var jwb = "{{ $jawab['jawaban'] }}";
    var form = $("#form_soal_{{$data->nomor_soal}}");
    $('#form_soal_{{$data->nomor_soal}}').on('click' , 'input:radio' , function() {
        $.ajax({
            url: "{!! route('save-ujian') !!}",
            type: "POST",
            data:  form.serialize(),
            beforeSend: function() {        
                $('#notifikasi_{!! $data->nomor_soal !!}').html('<div class="notifikasi"><i class="fa fa-clock"></i> Sedang Menyimpan, Tunggu Sampai Berhasil.</div>');
            },
            success: function(data) {
                if ( data.status == 'stop') {
                    alert('Sesi Ujian Anda Telah Selesai!');
                } else if ( data.status == true ) {
                    $('#notifikasi_{!! $data->nomor_soal !!}').html('<div class="notifikasi"><i class="fa fa-check-circle"></i> Berhasil Disimpan!</div>');
                    $('#daftar{{$data->nomor_soal}}').addClass('active');
                } else if ( data.status == false) {
                    $('#notifikasi_{!! $data->nomor_soal !!}').html('<div class="notifikasi"><i class="fa fa-check-circle"></i> Gagal Disimpan!</div>');
                    
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    if(jwb != ""){
        $('#daftar{{$data->nomor_soal}}').addClass('active');
        $('#td_{{$data->nomor_soal}}').html(jwb);
    }
    return false;
})
</script>
                            @endforeach
                            <div class="footer clearfix">
                                <a href="javascript:void(0);" onclick="Prev();"
                                    class="btn btn-sm btn-warning float-left m-1">
                                    <i class="fa fa-chevron-circle-left"></i> Prev
                                </a>
                                <a href="javascript:void(0);" onclick="Next('{!! $soal->count() !!}');"
                                    class="btn btn-sm btn-info float-left m-1">Next
                                    <i class="fa fa-chevron-circle-right"></i>
                                </a>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#selesaiModal" class="btn btn-sm btn-success float-right m-1"><i
                                        class="fa fa-check-circle"></i> Selesai Ujian</a>
                                <a href="javascript:void(0);" onclick="KirimSemuaJawaban();" class="btn btn-sm btn-primary float-right m-1"><i class="fa fa-save"></i>
                                    Simpan Semua Jawaban</a>
                            </div>
                        </div>
                        {{--  Keterangan  --}}
                        <div class="keterangan_cat">
                            <h1><i class="fa fa-info-circle"></i> Perhatian !</h1>
                            <p>Tekan Tombol <a class="btn btn-sm btn-primary m-1 text-white disabled"><i class="fa fa-save"></i>
                                Simpan Semua Jawaban</a> Sebelum Menyelesaikan Ujian CAT.</p>
                        </div>
                        {{--  Keterangan  --}}
                    </div>
                    {{--  Soal Ujian  --}}

                    {{--  Nomor Ujian  --}}
                    <div class="col-lg-3 col-md-12">
                        <div class="navigasi">
                            <div class="judul">
                                <h1><i class="fa fa-list-ol"></i> Daftar Nomor</h1>
                            </div>
                            <div class="data">
                                <div class="container">
                                    <div class="row">
                                        <input type="hidden" id="nomor_soal" value="1">
                                        @for ($i=1; $i <= $soal->count(); $i++)
                                            <div class="col-2 tombol">
                                                <a onclick="Soal('{{ $i }}');" id="daftar{{ $i }}"
                                                    class="nomor">{{ $i }}</a>
                                            </div>
                                            @endfor
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="footer">
                                <h6><span class="non-active">&nbsp;</span>Belum Terjawab</h6>
                                <h6><span class="active">&nbsp;</span>Sudah Terjawab</h6>
                                <h6><span class="in-active">&nbsp;</span>Soal Yang Sedang Aktif</h6>
                            </div>
                        </div>
                    </div>
                    {{--  Nomor Ujian  --}}
                </div>
            </div>
        </section>
        {{--  Content  --}}
        <section>
            <div class="container">
                <div style="display: none;">
                    <table class="table bg-white" id="frans_table">
                        <thead>
                            <tr>
                                <th width="30px;">No</th>
                                <th width="30%">Kode Soal</th>
                                <th width="30%">Kode Pendaftaran</th>
                                <th width="30px;">Nomor Soal</th>
                                <th width="20%">Jawaban</th>
                            </tr>
                        </thead>
                        <tbody id="table_jawaban">
                            @php
                            $no= 1;
                            @endphp
                            @foreach ($soal as $data)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$data->kode_soal}}</td>
                                <td>{{$pendaftaran->kode_pendaftaran}}</td>
                                <td>{{$data->nomor_soal}}</td>
                                <td id="td_{{$data->nomor_soal}}">{{$jawab['jawaban']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="notifikasi_all"></div>
            </div>
        </section>
    </div>
    {{--  Wrapper  --}}

    {{--  Footer  --}}
    <section>
        <footer>
            <h6>Copyright &copy; 2019-{{ date('Y') }} | Kemenag Kota Banda Aceh</h6>
            <h6>Made With <i class="icon ion-heart"></i> By <a target="_BLANK"
                    href="http://codingers.id/">CODINGERS.ID</a></h6>
        </footer>
    </section>
    {{--  Footer  --}}

    {{--  @include('sweetalert::alert')  --}}
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/moment/moment.js') }}"></script>
    <script src="{{ $cdn?? asset('vendor/sweetalert/sweetalert.all.js')  }}"></script>

<script type="text/javascript">
countdown('{!!$bank_soal->timer_cat!!}',true,"{!! route('cat.end.js') !!}");
function UpdateSemuaJawaban(){
    var nums = "{{$soal->count()}}";
    var i;
    for(var i=1; i <= nums; i++){
        SimpanJawabanOnClick(i);
    }
}
function SimpanJawabanOnClick(id){
    var form = $("#form_soal_"+id);
    $.ajax({
        url: "{!! route('save-ujian') !!}",
        type: "POST",
        data:  form.serialize(),
        success: function(sising){
            console.log(sising.status);
        },
        error : function (data) {
            console.log(data);
        },
    });
}
function KirimSemuaJawaban() {
    $('#notifikasi_all').html('');
    var nums = "{!! $soal->count() !!}";
    var i;
    for(var i=1; i <= nums; i++) {
        SimpanJawaban(i);
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Disimpan!',
            text: 'Semua Jawaban Soal Anda Berhasil Disimpan!'
        });
    }
    ExportJawaban('frans_table');
}
function SimpanJawaban(id) {
    var form = $("#form_soal_"+id);
    $.ajax({
        url: "{!! route('save-ujian') !!}",
        type: "POST",
        data:  form.serialize(),
        success: function(sising){
            if(sising.status==true){
                console.log(sising.status);
            }else if(sising.status==false){
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Disimpan!',
                    text: 'Jawaban Anda Pada Soal Nomor '+id+' Gagal Disimpan!'
                });
            }
        },
        error : function (data) {
            console.log(data);
        },
    });
}
function ExportJawaban(tableID, filename = ''){
    var downloadLink = "";
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    filename = filename?filename+'.xls':'[{{Auth::user()->email}}]-[{{$pendaftaran->kode_pendaftaran}}]-[{{date('H:i:s')}}].xls';
    downloadLink = document.createElement("a");    
    document.body.appendChild(downloadLink);    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
    }
}
</script>
</body>

</html>