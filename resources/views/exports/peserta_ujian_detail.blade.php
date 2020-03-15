<table>

    <thead>
        <tr>
            <td style="font-size: 15px; font-weight: bold;">Hasil Ujian CAT Dengan Kode Pendaftaran [ {{$kode_pendaftaran}} ] Dan Kode Soal [{{$kode_soal}}]</td>
        </tr>

        <tr>
        </tr>
        <tr>
        </tr>
    </thead>

    <tr>
        <td style="font-weight:bold; text-align: center; width: 25px;">Kode Pendaftaran</td>
        <td style="background: #d6d6d6; color:tomato; text-align: center; width: 75px;">{{$kode_pendaftaran}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 25px;">Kode Pendaftaran</td>
        <td style="background: #d6d6d6; color:tomato; text-align: center; width: 75px;">{{$peserta->nama}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 25px;">Tempat Lahir</td>
        <td style="background: #d6d6d6; color:tomato; text-align: center; width: 75px;">{{$peserta->tmp}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 25px;">Tanggal Lahir</td>
        <td style="background: #d6d6d6; color:tomato; text-align: center; width: 75px;">{{$peserta->tgl}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 25px;">Jenis Kelamin</td>
        <td style="background: #d6d6d6; color:tomato; text-align: center; width: 75px;">{{$peserta->jkl}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 25px;">Agama</td>
        <td style="background: #d6d6d6; color:tomato; text-align: center; width: 75px;">{{$peserta->agama}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 25px;">Alamat</td>
        <td style="background: #d6d6d6; color:tomato; text-align: center; width: 75px;">{{$peserta->alamat_rumah}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 25px;">Nama Ayah</td>
        <td style="background: #d6d6d6; color:tomato; text-align: center; width: 75px;">{{$peserta->nama_ayah}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 25px;">Nama Ibu</td>
        <td style="background: #d6d6d6; color:tomato; text-align: center; width: 75px;">{{$peserta->nama_ibu}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 25px;">Bukti Pendaftaran</td>
        <td style="background: #d6d6d6; color:tomato; text-align: center; width: 75px;"><a href="{{route('print.data' , [$peserta->NIK , Dits::encodeDits($pendaftaran->uuid) ])}}" target="_blank" class="btn btn-sm btn-success btn-block"><i class="fas fa-print"></i> Print / Cetak Data</a></td>
    </tr>

    <tr>
    </tr>
    <tr>
    </tr>

    <tr>
        <td style="font-size: 15px; font-weight: bold;">Jawaban Peserta Pada Kode Soal [{{$kode_soal}}]</td>
    </tr>

    <thead>
        <tr>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 5px;">No</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">Nomor Soal</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">Jawaban Peserta</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">Status Jawaban</th>
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1;
        @endphp
        @foreach ($jawaban as $item)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$item->nomor_soal}}</td>
            <td>{{$item->jawaban}}</td>
            <td>{{$item->status_jawaban}}</td>
        </tr>
        @endforeach
    </tbody>

    <tr colspan="2">
        <td>Keterangan Jawaban : </td>
    </tr>
    <tr>
        <td>Jumlah Benar</td>
        <td>0</td>
    </tr>
    <tr>
        <td>Jumlah Salah</td>
        <td>0</td>
    </tr>
    <tr>
        <td>Tidak Terjawab</td>
        <td>0</td>
    </tr>

</table>