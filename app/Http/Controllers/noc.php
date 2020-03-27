<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\Models\Soal;
use App\User;
use Carbon\Carbon;
use Dits;
use Str;

class noc extends Controller
{
    public function index($name)
    {
        $name = strtolower($name);
        $columns = \DB::getSchemaBuilder()->getColumnListing($name);
        return $columns;
    }

    public function GenPeserta($jenjang, $uid_pembukaan)
    {
        if ($jenjang == "mi") {
            $nama = "PESERTA MI-";
            $nik = "180418010714";
            $tgl = "2014-07-01";
            $email = "pesertami";
            $akte = "document/peserta/1804180107140001/akte/1585197366.pdf";
            $kk = "document/peserta/1804180107140001/akte/1585197366.pdf";
            $raport_1 = "";
            $raport_2 = "";
            $raport_3 = "";
        } elseif ($jenjang == "mts") {
            $nama = "PESERTA MTS-";
            $nik = "180418010708";
            $tgl = "2008-07-01";
            $email = "pesertamts";
            $akte = "";
            $kk = "";
            $raport_1 = "document/peserta/1804180107140001/akte/1585197366.pdf";
            $raport_2 = "";
            $raport_3 = "";
        } elseif ($jenjang == "ma") {
            $nama = "PESERTA MA-";
            $nik = "180418010702";
            $tgl = "2002-07-01";
            $email = "pesertama";
            $akte = "";
            $kk = "";
            $raport_1 = "document/peserta/1804180107140001/akte/1585197366.pdf";
            $raport_2 = "";
            $raport_3 = "";
        }
        // GENERATE PESERTA 1.000
        for ($i = 1; $i <= 1000; $i++) {
            $uid_peserta = Str::uuid();
            $peserta = [
                "uuid" => $uid_peserta,
                "nama" => $nama . $i,
                "NIK" => $nik . sprintf("%04d", $i),
                "nisn" => rand('1000', '1000000') . $i,
                "tmp" => "Kota Banda Aceh",
                "tgl" => date('Y-m-d', strtotime($tgl)),
                "jkl" => "Laki-laki",
                "agama" => "Islam",
                "hobi" => "Olahraga",
                "cita2" => "PNS",
                "anak_ke" => "1",
                "jml_saudara" => "0",
                "alamat_rumah" => "Jl. Komp. Masjid Baiturahman",
                "sekolah_asal" => "Sekolah " . $i,
                "npsn_sekolah_asal" => "1008352" . $i,
                "nama_sekolah_asal" => "Sekolah " . $i,
                "alamat_sekolah_asal" => "Jl. Cut Nyak Dien " . $i,
                "jenis_prestasi" => "Juara 1 Qori Nasional",
                "yatim_piatu" => "Tidak",
                "kartu_program" => "KIP",
                "nama_ayah" => "Tekad BW " . $i,
                "nik_ayah" => "180418060976000" . $i,
                "tmp_ayah" => "Jl. Komp. Masjid Baiturahman",
                "tgl_ayah" => date('Y-m-d', strtotime("1976-09-06")),
                "pekerjaan_ayah" => "PNS",
                "nama_ibu" => "Syaroh " . $i,
                "nik_ibu" => "180418060976000" . $i,
                "tmp_ibu" => "Jl. Komp. Masjid Baiturahman",
                "tgl_ibu" => date('Y-m-d', strtotime("1976-09-06")),
                "pekerjaan_ibu" => "PNS",
                "tgl_registrasi" => date('Y-m-d'),
                "kontak_peserta" => "08151067951" . $i,
                "email" => $email . $i . "@gmail.com",
                "status_aktif" => "yes",
                "akte" => $akte,
                "kk" => $kk,
                "rapot_1" => $raport_1,
                "rapot_2" => $raport_2,
                "rapot_3" => $raport_3,
            ];
            $user = [
                "uuid" => Str::uuid(),
                "uuid_login" => $uid_peserta,
                "username" => $nik . $i,
                "email" => $email . $i . "@gmail.com",
                "password" => \bcrypt('1234'),
                "remember_token" => Str::random('60'),
                "role" => "Peserta",
                "status_aktif" => "yes",
                "img" => "",
            ];
            $nomor_pendaftaran = Dits::interval('pendaftarans', $uid_pembukaan, 'nomor_pendaftaran');
            $pendaftaran = [
                'uuid' => Str::uuid(),
                'uuid_pembukaan' => $uid_pembukaan,
                'uuid_peserta' => $uid_peserta,
                'kode_pendaftaran' => Dits::generateCode(),
                'nomor_pendaftaran' => $nomor_pendaftaran,
                'status_pendaftaran' => 'Baru',
                'status_diterima' => 'Tahap Seleksi',
                'jalur_diterima' => '',
                'url_transfer' => '',
                'status_transfer' => '',
                'tgl_pendaftaran' => Carbon::now(),
            ];
            Peserta::create($peserta);
            User::create($user);
            Pendaftaran::create($pendaftaran);
        }
    }

    public function GenSoal($kode_soal)
    {
        // GENERATE PESERTA 100 SOAL
        for ($i = 1; $i <= 100; $i++) {
            $jawaban = array_merge(range('A', 'D'));
            $uid = Str::uuid();
            $soal = [
                "uuid" => $uid,
                "uuid_operator" => "",
                "kode_soal" => $kode_soal,
                "jenis_soal" => "Agama",
                "nomor_soal" => $i,
                "soal" => "Tes Soal Agama " . $i,
                "a" => "Pilhan Jawaban A-" . $i,
                "b" => "Pilhan Jawaban B-" . $i,
                "c" => "Pilhan Jawaban C-" . $i,
                "d" => "Pilhan Jawaban D-" . $i,
                "kunci_jawaban" => $jawaban[rand(0, 3)],
                "tgl_soal" => date('Y-m-d H:i:s'),
            ];
            Soal::create($soal);
        }
    }
}