<?php

namespace App\Imports;

use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\User;
use Carbon\Carbon;
use Dits;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Str;

class JalurKhususImport implements ToCollection
{

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $i = 0;
        foreach ($rows as $item) {
            // Data Explode
            $data = explode(';', $item);
            // CEK NIK PADA PESERTAS
            $cek_nik = Peserta::whereNik($data[1])->first();
            if($cek_nik===NULL){
                // Ambil Dari Data Pertama
                if ($i>1 && $data[1] !="") {
                    $uid_pembukaan = $this->id;
                    $uid_peserta = Str::uuid();
                    // Alamat Peserta
                    $alamat_peserta = [
                        '0' => $data[11],
                        '1' => $data[12],
                        '2' => $data[13],
                        '3' => $data[14],
                        '4' => $data[15],
                    ];
                    $alamat_peserta = \implode(", ",$alamat_peserta);
                    $alamat_peserta = \str_replace('-,','',$alamat_peserta);
                    // Alamat Sekolah
                    $alamat_sekolah = [
                        '0' => $data[19],
                        '1' => $data[20],
                        '2' => $data[21],
                        '3' => $data[22],
                        '4' => $data[23],
                    ];
                    $alamat_sekolah = \implode(", ",$alamat_sekolah);
                    $alamat_sekolah = \str_replace('-,','',$alamat_peserta);
                    $tgl_peserta = date('Y-m-d',\strtotime(\str_replace(".","-",$data[4])));
                    $tgl_ayah = date('Y-m-d',\strtotime(\str_replace(".","-",$data[30])));
                    $tgl_ibu = date('Y-m-d',\strtotime(\str_replace(".","-",$data[35])));
                    $tgl_reg = date('Y-m-d',\strtotime(\str_replace(".","-",$data[37])));
                    $tgl_ppdb = date('Y-m-d',\strtotime(\str_replace(".","-",$data[41])));
                    try {
                        Peserta::create([
                            "uuid" => $uid_peserta,
                            "nama" => strtoupper(\str_replace('["',"",$data[0])),
                            "NIK" => $data[1],
                            "nisn" => $data[2],
                            "tmp" => $data[3],
                            "tgl" => $tgl_peserta,
                            "jkl" => $data[5],
                            "agama" => $data[6],
                            "hobi" => $data[7],
                            "cita2" => $data[8],
                            "anak_ke" => $data[9],
                            "jml_saudara" => $data[10],
                            "alamat_rumah" => $alamat_peserta,
                            "sekolah_asal" => $data[16],
                            "npsn_sekolah_asal" => $data[17],
                            "nama_sekolah_asal" => $data[18],
                            "alamat_sekolah_asal" => $alamat_sekolah,
                            "jenis_prestasi" => $data[24],
                            "yatim_piatu" => $data[25],
                            "kartu_program" => $data[26],
                            "nama_ayah" => $data[27],
                            "nik_ayah" => $data[28],
                            "tmp_ayah" => $data[29],
                            "tgl_ayah" => $tgl_ayah,
                            "pekerjaan_ayah" => $data[31],
                            "nama_ibu" => $data[32],
                            "nik_ibu" => $data[33],
                            "tmp_ibu" => $data[34],
                            "tgl_ibu" => $tgl_ibu,
                            "pekerjaan_ibu" => $data[36],
                            "tgl_registrasi" => $tgl_reg,
                            "kontak_peserta" => $data[38],
                            "email" => strtolower($data[39]),
                            "status_aktif" => "yes",
                            'created_at' => date('Y-m-d H:i:s',strtotime($tgl_reg)),
                            'updated_at' => date('Y-m-d H:i:s',strtotime($tgl_reg)),
                        ]);
                        User::create([
                            "uuid" => Str::uuid(),
                            "uuid_login" => $uid_peserta,
                            "username" => $data[1],
                            "email" => strtolower($data[39]),
                            "password" => \bcrypt('1234'),
                            "remember_token" => Str::random('60'),
                            "role" => "Peserta",
                            "status_aktif" => "yes",
                            "img" => "",
                            'created_at' => date('Y-m-d H:i:s',strtotime($tgl_reg)),
                            'updated_at' => date('Y-m-d H:i:s',strtotime($tgl_reg)),
                        ]);
                        $nomor_pendaftaran = Dits::interval('pendaftarans', $uid_pembukaan, 'nomor_pendaftaran');
                        Pendaftaran::create([
                            'uuid' => Str::uuid(),
                            'uuid_pembukaan' => $uid_pembukaan,
                            'uuid_peserta' => $uid_peserta,
                            'kode_pendaftaran' => Dits::generateCode(),
                            'nomor_pendaftaran' => $nomor_pendaftaran,
                            'status_pendaftaran' => 'Lolos Tahap Dokumen',
                            'status_diterima' => 'Diterima',
                            'jalur_diterima' => \str_replace('"]',"",$data[41]),
                            'url_transfer' => '',
                            'status_transfer' => '',
                            'tgl_pendaftaran' => $tgl_ppdb,
                            'created_at' => date('Y-m-d H:i:s',strtotime($tgl_ppdb)),
                            'updated_at' => date('Y-m-d H:i:s',strtotime($tgl_ppdb)),
                        ]);
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                }
                $i++;
            }else{
                return true;
            }
        }
    }
}
