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
        <td style="background: #d6d6d6; text-align: center; width: 75px;">{{$kode_pendaftaran}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 35px;">Nama Peserta</td>
        <td style="background: #d6d6d6; text-align: center; width: 75px;">{{$peserta->nama}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 35px;">NIK Peserta</td>
        <td style="background: #d6d6d6; text-align: center; width: 75px;">({{ $peserta->NIK}})</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 35px;">Tempat Lahir</td>
        <td style="background: #d6d6d6; text-align: center; width: 75px;">{{$peserta->tmp}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 35px;">Tanggal Lahir</td>
        <td style="background: #d6d6d6; text-align: center; width: 75px;">{{$peserta->tgl}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 35px;">Jenis Kelamin</td>
        <td style="background: #d6d6d6; text-align: center; width: 75px;">{{$peserta->jkl}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 35px;">Agama</td>
        <td style="background: #d6d6d6; text-align: center; width: 75px;">{{$peserta->agama}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 35px;">Alamat</td>
        <td style="background: #d6d6d6; text-align: center; width: 75px;">{{$peserta->alamat_rumah}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 35px;">Nama Ayah</td>
        <td style="background: #d6d6d6; text-align: center; width: 75px;">{{$peserta->nama_ayah}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 35px;">Nama Ibu</td>
        <td style="background: #d6d6d6; text-align: center; width: 75px;">{{$peserta->nama_ibu}}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; text-align: center; width: 35px;">Bukti Pendaftaran</td>
        <td style="background: #d6d6d6; text-align: center; width: 75px;"><a href="{{route('print.data' , [$peserta->NIK , Dits::encodeDits($kode_pendaftaran) ])}}" target="_blank" class="btn btn-sm btn-success btn-block"><i class="fas fa-print"></i> Print / Cetak Data</a></td>
    </tr>

    <tr>
    </tr>
    <tr>
    </tr>

</table>

<table>
    <tr>
        <td style="font-size: 15px; font-weight: bold;">Jawaban Peserta Pada Kode Soal [{{$kode_soal}}]</td>
    </tr>

    <thead>
        <tr>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">No</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 35px;">Nomor Soal</th>
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

    <tr>
        <td>Keterangan Jawaban : </td>
    </tr>
    <tr>
        <td>Jumlah Benar</td>
        <td>{{$result['jawab_benar']}}</td>
    </tr>
    <tr>
        <td>Jumlah Salah</td>
        <td>{{$result['jawab_salah']}}</td>
    </tr>
    <tr>
        <td>Tidak Terjawab</td>
        <td>{{$result['tidak_jawab']}}</td>
    </tr>
</table>