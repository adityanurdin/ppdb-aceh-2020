<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use \App\Models\Peserta;
use Dits;

class JalurKhususImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $item) 
        {
            $data = explode(';' ,$item[0]);
            try {
                $peserta = Peserta::create([
                    'uuid'  => \Str::uuid(),
                    'nama'  => $data[0],
                    'NIK'   => $data[1],
                    'nisn'  => $data[2],
                    'tmp'       => $data[3],
                    'tgl'       => $data[4],
                    'jkl'       => $data[5],
                    'agama'     => $data[6],
                    'hobi'      => $data[7],
                    'cita2'     => $data[8],
                    'anak_ke'   => $data[9],
                    'jml_saudara' => $data[10],
                    'alamat_rumah' => $data[11],
                    'sekolah_asal' => $data[12],
                    'npsn_sekolah_asal' => $data[13],
                    'nama_sekolah_asal' => $data[14],
                    'alamat_sekolah_asal' => $data[15],
                    'jenis_prestasi' => '',
                    'yatim_piatu' => '',
                    'kartu_program' => '',
                    'nama_ayah' => $data[16],
                    'nik_ayah'  => $data[17],
                    'tmp_ayah'  => $data[18],
                    'tgl_ayah'  => $data[19],
                    'pekerjaan_ayah'  => $data[20],
                    'nama_ibu' => $data[21],
                    'nik_ibu'  => $data[22],
                    'tmp_ibu'  => $data[23],
                    'tgl_ibu'  => $data[24],
                    'pekerjaan_ibu'  => $data[25],
                    'kontak_peserta' => $data[26],
                    'email'     => $data[27],
                ]);
                
                $nomor_pendaftaran = Dits::interval('pendaftarans' , 'nomor_pendaftaran');
                Pendaftaran::create([
                    'uuid'              => \Str::uuid(),
                    'uuid_pembukaan'    => \Str::uuid(),
                    'uuid_peserta'      => $peserta->uuid,
                    'kode_pendaftaran'  => Dits::generateCode(),
                    'nomor_pendaftaran' => $nomor_pendaftaran,
                    'status_pendaftaran'=> 'Baru',
                    'status_diterima'   => 'Tahap Seleksi',
                    'jalur_diterima'    => $data[28],
                    'url_transfer'      => '',
                    'status_transfer'   => '',
                    'tgl_pendaftaran'   => Carbon::now()
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }
            
        }
    }
}
