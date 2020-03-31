<table>
    <thead>
        <tr>
            <th>Data Akun Operator Madrasah :</th>
        </tr>
        <tr></tr>
        <tr>
            <th>No.</th>
            <th>Nama Operator</th>
            <th>Kontak Operator</th>
            <th>Email Operator</th>
            <th>Madrasah</th>
            <th>NSM</th>
            <th>Username</th>
            <th>Password</th>
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1;
        @endphp
        @foreach ($operator as $data)
        <tr>
            <td>{{$no++}}</td>
            <td>{{ $data->nama_operator }}</td>
            <td>{{ $data->kontak_operator }}</td>
            <td>{{ $data->email_operator }}</td>
            <td>{{ $data->madrasah->nama_madrasah }}</td>
            <td>{{ $data->madrasah->nsm }}</td>
            <td>{{ $data->user->username }}</td>
            <td>1234</td>
        </tr>
        @endforeach
    </tbody>
</table>