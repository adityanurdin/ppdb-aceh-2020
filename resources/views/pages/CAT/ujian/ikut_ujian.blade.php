<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('bootstrap/dist/css/bootstrap-custom.css')}}">
    <!-- Our CSS -->
    <link rel="stylesheet" href="{{asset('css/style_home.css')}}">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <style>
        .navigasi_soal{
            width: auto;
            height: auto;
            padding: 10px;
            margin: auto;
            position: relative;
        }
        .navigasi_soal a{
            display: inline-block;
            padding: 8px 15px;
            margin: 10px 6px 0px 0px;
            background: #ddd;
            color: #000;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .navigasi_soal a:hover{
            background: rgba(4,5,6,0.8);
            color: #ffffff
        }
        .notifikasi{
            width: auto;
            height: auto;
            padding: 5px;
            margin: auto;
            background: rgba(3, 3, 3, 1);
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #fff;
            font-size: 14pt;
            text-align: left;
            cursor: pointer;
            margin-bottom: 5px;
            display: block;
            margin-bottom: 10px;

        }
        .notifikasi i{
            margin-right: 10px;
            color: #fff000;
        }
        .notifikasi:before,.notifikasi:after{
            content:"";
            display:table;
            clear:both;
        }
    </style>
    
    <title>SIMPPDB</title>
</head>
<body>

    <nav class="navbar navbar-expand-md navbar-dark navsgrad">
        <div class="mx-auto order-0">
            <a class="navbar-brand mr-auto" href="#">SIMPPDB Madrasah Kota Banda Aceh</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i> {{Auth::user()->username}}</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{route('cat.end')}}"><i class="fas fa-door-open"></i> Keluar Halaman Ujian</a>
                    </div>
              </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        @php
                $no = 1;
            @endphp
            @foreach ($soal as $item)
            @php
                $jawab = \App\Models\Jawaban::where('kode_soal' , $item->kode_soal)
                                                ->where('kode_pendaftaran' , $pendaftaran->kode_pendaftaran)
                                                ->where('nomor_soal' , $item->nomor_soal)
                                                ->first();
            @endphp
            <div class="divs">
                <div class="divss" id="Soal_{{$item->nomor_soal}}">
                    <div class="row">
                        <div class="col">
                            <h1 class="px-5">Soal No. <span class="badge badge-primary">{{$item->nomor_soal}}</span></h1>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <h4 class="px-5 text-secondary"><i class="fas fa-hourglass-half"></i> Sisa Waktu <span class="badge badge-warning"><div id="timer"></div></span></h4>
                        </div>
                    </div>
                    <div class="card-header">
                        <h6>Kode Soal : <b style="color:red;">{{$item->kode_soal}}</b></h6>
                        <h6>Jenis Soal : <b>{{$item->jenis_soal}}</b></h6>
                    </div>
                    <div class="row no-gutters mt-5">

                        <div class="col-12 col-sm-6 col-md-8">

                            <h4>{!!$item->soal!!}</h4>
                            <br>
                            @if (!empty($item->gambar))
                                <img src="{{Dits::imageUrl($item->gambar)}}" alt="">
                            @endif
                        
                            <form action="" id="form_soal_{{$item->nomor_soal}}" method="POST">
                                @csrf
                                <input type="hidden" name="uuid_jawaban" id="id_jawaban{{$item->nomor_soal}}" value="{{Dits::encodeDits($jawab['uuid'])}}" readonly>
                                <input type="hidden" name="nomor_soal" id="nomor_soal{{$item->nomor_soal}}" value="{{Dits::encodeDits($item->nomor_soal)}}" readonly>
                                <input type="hidden" name="kode_soal" id="kode_soal{{$item->nomor_soal}}" value="{{Dits::encodeDits($item->kode_soal)}}" readonly>
                                <input type="hidden" name="kode_pendaftaran" id="kode_pendaftaran{{$item->nomor_soal}}" value="{{Dits::encodeDits($pendaftaran->kode_pendaftaran)}}" readonly>
                                <input type="hidden" name="nums" id="nums_{{$item->nomor_soal}}" value="{{Dits::encodeDits($item->nomor_soal)}}" readonly>
                                <div class="form-group">
                                    <input type="radio" name="jawaban[]" id="" value="a" {{Dits::selected($item->jawaban , 'a' , 'selected')}} onclick="SendTable('{{$item->nomor_soal}}','a')">
                                    <label for="" class="label_radio">A. {{$item->a}}</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="jawaban[]" id="" value="b" {{Dits::selected($item->jawaban , 'b' , 'selected')}} onclick="SendTable('{{$item->nomor_soal}}','b')">
                                    <label for="" class="label_radio">B. {{$item->b}}</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="jawaban[]" id="" value="c" {{Dits::selected($item->jawaban , 'c' , 'selected')}} onclick="SendTable('{{$item->nomor_soal}}','c')">
                                    <label for="" class="label_radio">C. {{$item->c}}</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="jawaban[]" id="" value="d" {{Dits::selected($item->jawaban , 'd' , 'selected')}} onclick="SendTable('{{$item->nomor_soal}}','d')">
                                    <label for="" class="label_radio">D. {{$item->d}}</label>
                                </div>
                            </form>
                        <div id="notifikasi_{{$item->nomor_soal}}"></div>
                        </div>

                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function() {
                    document.addEventListener('contextmenu', event => event.preventDefault());
                    document.onkeydown = function() 
                    {
                        switch (event.keyCode) 
                        {
                            case 116 : //F5 button
                                event.returnValue = false;
                                event.keyCode = 0;
                                return false;
                            case 27 : //ESC button
                                event.returnValue = false;
                                event.keyCode = 0;
                                return false;
                            case 82 : //R button
                                if (event.ctrlKey) 
                                {
                                    event.returnValue = false;
                                    event.keyCode = 0;
                                    return false;
                                }
                        }
                    }
                    var jwb = "{{ $jawab['jawaban'] }}"
                    var form = $("#form_soal_{{$item->nomor_soal}}");
                    $('#form_soal_{{$item->nomor_soal}}').on('click' , 'input:radio' , function() {
                        $.ajax({
                            url: "{{route('save-ujian')}}",
                            type: "POST",
                            data:  form.serialize(),
                            beforeSend: function() {        
                                $('#notifikasi_'+{{$item->nomor_soal}}).html('<div class="notifikasi"><i class="fa fa-clock"></i> Sedang Menyimpan, Tunggu Sampai Berhasil.</div>');
                            },
                            success: function(data) {
                                if ( data.status == 'stop') {
                                    alert('Sesi Ujian Anda Telah Selesai!')
                                } else if ( data.status == true ) {
                                    $('#notifikasi_'+{{$item->nomor_soal}}).html('<div class="notifikasi"><i class="fa fa-check-circle"></i> Berhasil Disimpan!</div>')
                                    
                                } else if ( data.status == false) {
                                    $('#notifikasi_'+{{$item->nomor_soal}}).html('<div class="notifikasi"><i class="fa fa-check-circle"></i> Gagal Disimpan!</div>');
                                    
                                }
                            },
                            error: function(err) {
                                console.log(err)
                            }
                        })
                        UpdateSemuaJawaban();
                    })

                    if(jwb != ""){
                            $('#daftar{{$item->nomor_soal}}').addClass('terjawab');
                    }
                    return false;
        
                })
            </script>
            @endforeach

            <div class="navigasi_soal">
                    <input type="hidden" id="nomor_soal" value="1">
                    @for ($i=1; $i <= $soal->count(); $i++)
                            <a onclick="Soal('{!!$i!!}');" id="daftar{{$i}}">{{$i}}<span class="badge badge-light"></span></a>
                        {{-- </div> --}}
                    @endfor
            </div>

            <div class="card card-body">
                <a title="Selesai Ujian CAT" onclick="ExportJawaban('frans_table');return confirm('Apakah Anda Yakin Sudah Menjawab Semua Soal?');" href="{{route('cat.end')}}" class="btn btn-sm btn-info float-right"><i class="fas fa-check-circle"></i> Selesai Ujian CAT</a> &nbsp
                <a title="Simpan Semua Jawaban" class="btn btn-sm btn-info float-right" onclick="KirimSemuaJawaban();"><i class="fa fa-save"></i> Simpan Semua Jawaban</a>
            </div>


            <div style="display:none;">
                <table class="table" id="frans_table">
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
                            $no = 1;
                        @endphp
                        @foreach ($soal as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$item->kode_soal}}</td>
                            <td>{{$pendaftaran->kode_pendaftaran}}</td>
                            <td>{{$item->nomor_soal}}</td>
                            <td id="td_{{$item->nomor_soal}}">{{$jawab['jawaban']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="notifikasi_all"></div>

            

    </div>

    

    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('js/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('js/timer-cat.js')}}"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $(".divs > .divss").each(function(e) {
            if (e != 0)
            $(this).hide();
        });
        $(".navbar").hide();
    });
    
                    
    addEventListener("load", function() {
        var
            el = document.documentElement
            , rfs =
                el.requestFullScreen
                || el.webkitRequestFullScreen
                || el.mozRequestFullScreen
        ;
        rfs.call(el);
        console.log('Fullscreen Mode On')

    });
        
    function Soal(i) {
        $('.divss').hide();
        $('#Soal_'+i).show();
        $('.list').removeClass('active');
        // $('#daftar'+i).addClass('active');
        $('#nomor_soal').val(i);
    }

    function SendTable(no,val) {
        $('#td_'+no).html(val);
    }

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
            url: "{{route('save-ujian')}}",
            type: "POST",
            data:  form.serialize(),
            success: function(sising){
                if(sising.status == true){
                    $('#notifikasi_'+id).html('<div class="notifikasi"><i class="fa fa-check-circle"></i> Berhasil Disimpan!</div>');
                }else if(sising.status == false){
                    $('#notifikasi_'+id).html('<div class="notifikasi"><i class="fa fa-times-circle" style="background:red;color:#fff;"></i> Gagal Disimpan!</div>');
                }
            },
            error : function (data) {
                console.log(data)
            },
        });
    }
    function KirimSemuaJawaban() {
        $('#notifikasi_all').html('');
        var nums = "{{$soal->count()}}";
        var i;
        for(var i=1; i <= nums; i++) {
            SimpanJawaban(i);
        }
        ExportJawaban('frans_table');
    }
    function SimpanJawaban(id) {
        var form = $("#form_soal_"+id);
        $.ajax({
            url: "{{route('save-ujian')}}",
            type: "POST",
            data:  form.serialize(),
            success: function(sising){
                if(sising=="berhasil"){
                    $('#notifikasi_all').append('<div class="notifikasi" id="'+id+'" onclick="$(\'#'+id+'\').hide();"><i class="fa fa-check-circle"></i> Soal '+id+' Berhasil Disimpan!</div>');
                    $('#daftar'+id).addClass('terjawab');
                }else if(sising=="gagal"){
                    $('#notifikasi_all').append('<div class="notifikasi" id="'+id+'" onclick="$(\'#'+id+'\').hide();"><i class="fa fa-times-circle" style="background:red;color:#fff;"></i> Soal '+id+' Gagal Disimpan!</div>');
                }
            },
            error : function (data) {
                alert(data);
            },
        });
    }
    function ExportJawaban(tableID, filename = ''){
        var downloadLink;
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

    countdown('{{$bank_soal->timer_cat}}',true,"{{route('cat.end')}}");
    </script>
    
</body>
</html>