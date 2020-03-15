<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Excel;
use Dits;
use Carbon\Carbon;
use Validator;

use App\User;
use App\Models\Operator;
use App\Models\Peserta;
use App\Models\Madrasah;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;
class JalurKhususImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $item) 
        {
            $data0 = explode(';' ,$item[0]);
            $data1 = explode(';' ,$item[1]);
            $data2 = explode(';' ,$item[2]);
            // $data3 = explode(';' ,$item[3]);
            $data = array_merge($data0 , $data1 , $data2);
            $alamat = $data[11].$data[12].$data[13];
            unset($data[11] , $data[12] , $data[13]);
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
                    'alamat_rumah' => $alamat,
                    'sekolah_asal' => $data[14],
                    'npsn_sekolah_asal' => $data[15],
                    'nama_sekolah_asal' => $data[16],
                    'alamat_sekolah_asal' => $data[17],
                    'jenis_prestasi' => $data[31],
                    'yatim_piatu' => $data[32],
                    'kartu_program' => $data[33],
                    'nama_ayah' => $data[18],
                    'nik_ayah'  => $data[19],
                    'tmp_ayah'  => $data[20],
                    'tgl_ayah'  => $data[21],
                    'pekerjaan_ayah'  => $data[22],
                    'nama_ibu' => $data[23],
                    'nik_ibu'  => $data[24],
                    'tmp_ibu'  => $data[25],
                    'tgl_ibu'  => $data[26],
                    'pekerjaan_ibu'  => $data[27],
                    'kontak_peserta' => $data[28],
                    'email'     => $data[29],
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
                    'jalur_diterima'    => $data[30],
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
