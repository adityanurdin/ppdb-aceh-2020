<table>
    
    <thead>
        <tr>
            <td style="font-size: 15px; font-weight: bold;">Hasil Ujian CAT dengan Kode Soal [ {{ $id }} ]</td>
        </tr>

        <tr>
        </tr>
        <tr>
        </tr>

        <tr>

        </tr>
        
        <tr>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 5px;">No</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">Kode Pendaftaran</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">Nomor Pendaftaran</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 30px;">Nama Peserta</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">Jumlah Jawaban Benar</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">Jumlah Jawaban Salah</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">Jumlah Tidak Terjawab</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">Detail Jawaban CAT</th>
        </tr>
    </thead>
    <tbody>
        @php
                $no = 1;
        @endphp

        @foreach ($result as $item)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$item['kode_pendaftaran']}}</td>
            <td>{{$item['nomor_pendaftaran']}}</td>
            <td>{{$item['nama_peserta']}}</td>
            <td>{{$item['jawab_benar']}}</td>
            <td>{{$item['jawab_salah']}}</td>
            <td>{{$item['tidak_jawab']}}</td>
            <td><a href="{{route('export.peserta-ujian.detail' , [$item['kode_pendaftaran'] , $id])}}">Export Jawaban</a></td>
        </tr>
        @endforeach
    </tbody>

</table>