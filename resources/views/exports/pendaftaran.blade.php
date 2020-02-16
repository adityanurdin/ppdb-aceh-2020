<body style="background-color: white;">
    
    <table>
        <thead>
            <tr>
                <th>Export Time</th>
            </tr>
            <tr>
                <td>{{Carbon\Carbon::now()}}</td>
            </tr>
            <tr>
            </tr>
            <tr>
            </tr>
        <tr>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 5px;">No</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">Kode Pendaftaran</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 25px;">Nomor Pendaftaran</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 20px;">Status Pendaftaran</th>
            <th style="background: #31b76b; font-weight:bold; text-align: center; width: 20px;">Status Diterima</th>
            {{-- <th class="table-header">Nama Madrasah</th> --}}
        </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
        @foreach($data as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->kode_pendaftaran }}</td>
                <td>{{ $item->nomor_pendaftaran }}</td>
                <td>{{ $item->status_pendaftaran }}</td>
                <td>{{ $item->status_diterima }}</td>
                {{-- <td>{{ $item->nama_madrasah }}</td> --}}
            </tr>
        @endforeach
        </tbody>
    </table>
</body>