<?php

namespace App\Http\Controllers;

use App\Models\BankSoal;
use App\Models\Madrasah;
use App\Models\Operator;
use App\Models\Pembukaan;
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

    public function GenUuidMadrasah()
    {
        // GENERATE UUID MDRASAHS
        // Digunakan Ketika Mengcopy Database Madrasah Dari PPDB 2019
        // Membuat Primary Key Dengan Generate UUID
        // Akses Function Ini Di URL : /noc/gen/uuid/madrasah
        $mdr = Madrasah::all();
        foreach ($mdr as $data) {
            Madrasah::whereNsm($data->nsm)->update([
                'uuid' => \Str::uuid(),
            ]);
        }
    }

    public function GenPeserta($jenjang)
    {
        // GENERATE PESERTAS + USERS + PENDAFTARANS
        // Syarat Sudah Ada Pembukaan
        // Generate Saja Pertama Kali GenOpPembukaan()
        // Akses URL GenOpPembukaan() : /noc/gen/operator/pembukaan
        // Akses Function Ini Di URL : /noc/gen/peserta/{jenjang}
        if ($jenjang == "mi") {
            $jenjang_w = "MI";
        } elseif ($jenjang == "mts") {
            $jenjang_w = "MTs";
        } elseif ($jenjang == "ma") {
            $jenjang_w = "MA";
        }
        $pembukaan = Pembukaan::whereStatusPembukaan('Dibuka')->get();
        foreach ($pembukaan as $data) {
            if($data->madrasah->jenjang == $jenjang_w){
                $uuid_pembukaan = $data->uuid;
                $pendaftaran = Pendaftaran::whereUuidPembukaan($uuid_pembukaan)->first();
                if ($pendaftaran === null) {
                    // Nomor Generate
                    $nog = \rand(1,999);
                    if ($jenjang == "mi") {
                        $nama = "PESERTA MI-";
                        $nik = "180".sprintf("%03d", $nog)."010714";
                        $tgl = "2014-07-01";
                        $email = "pesertami".$nog;
                        $akte = "";
                        $kk = "";
                        $raport_1 = "";
                        $raport_2 = "";
                        $raport_3 = "";
                        $sekolah_asal = "RA";
                    } elseif ($jenjang == "mts") {
                        $nama = "PESERTA MTS-";
                        $nik = "180".sprintf("%03d", $nog)."010708";
                        $tgl = "2008-07-01";
                        $email = "pesertamts".$nog;
                        $akte = "";
                        $kk = "";
                        $raport_1 = "";
                        $raport_2 = "";
                        $raport_3 = "";
                        $sekolah_asal = "MI";
                    } elseif ($jenjang == "ma") {
                        $nama = "PESERTA MA-";
                        $nik = "180".sprintf("%03d", $nog)."010702";
                        $tgl = "2002-07-01";
                        $email = "pesertama".$nog;
                        $akte = "";
                        $kk = "";
                        $raport_1 = "";
                        $raport_2 = "";
                        $raport_3 = "";
                        $sekolah_asal = "MTs";
                    }
                    // GENERATE PESERTA 100
                    for ($i = 1; $i <= 100; $i++) {
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
                            "sekolah_asal" => $sekolah_asal,
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
                            "username" => $nik . sprintf("%04d", $i),
                            "email" => $email . $i . "@gmail.com",
                            "password" => \bcrypt('1234'),
                            "remember_token" => Str::random('60'),
                            "role" => "Peserta",
                            "status_aktif" => "yes",
                            "img" => "",
                        ];
                        $nomor_pendaftaran = Dits::interval('pendaftarans', $uuid_pembukaan, 'nomor_pendaftaran');
                        $pendaftaran = [
                            'uuid' => Str::uuid(),
                            'uuid_pembukaan' => $uuid_pembukaan,
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
            }
        }
    }

    public function GenOpPembukaan()
    {
        // GENERATE OPERATORS + USERS+ PEMBUKAANS
        // Syarat Sudah Ada Madrasah
        // Akses Function Ini Di URL :  /noc/gen/operator/pembukaan
        $mdr = Madrasah::all();
        foreach ($mdr as $data) {
            // Operators
            $uid_operator = Str::uuid();
            $username = 'OP-' . rand(1, 5000);
            $email = strtolower($username) . "@gmail.com";
            $operator = [
                "uuid" => $uid_operator,
                "uuid_madrasah" => $data->uuid,
                "satker" => $data->kode_satker,
                "nama_operator" => "OP " . strtoupper($data->nama_madrasah),
                "kontak_operator" => "888888888888",
                "email_operator" => $email,
                "img" => "",
            ];

            // User
            $user = [
                "uuid" => Str::uuid(),
                "uuid_login" => $uid_operator,
                "username" => $username,
                "email" => $email,
                "password" => \bcrypt('1234'),
                "remember_token" => Str::random('60'),
                "role" => "Operator Madrasah",
                "status_aktif" => "yes",
                "img" => "",
            ];

            // Pembukaans
            $pembukaan = [
                "uuid" => Str::uuid(),
                "uuid_madrasah" => $data->uuid,
                "uuid_operator" => $uid_operator,
                "tgl_pembukaan" => \date('Y-m-d'),
                "tgl_penutupan" => \date('Y-m-d', strtotime('+1 month')),
                "tgl_pengumuman" => \date('Y-m-d', strtotime('+2 month')),
                "url_brosur" => "",
                "status_pembukaan" => "Dibuka",
                "tahun_akademik" => "2019/2020",
                "status_nomor" => "Aktif",
                "tgl_post" => Carbon::now(),
            ];
            Operator::create($operator);
            User::create($user);
            Pembukaan::create($pembukaan);
        }
    }

    public function GenBankSoal()
    {
        // GENERATE BANK SOALS
        // Syarat Sudah Operator Permadrasah
        // Generate Saja Pertama Kali GenOpPembukaan()
        // Akses URL GenOpPembukaan() : /noc/gen/operator/pembukaan
        // Akses Function Ini Di URL :  /noc/gen/bank-soal
        $operator = Operator::where('uuid_madrasah','!=','')->get();
        foreach($operator as $data){
            $uid = Str::uuid();
            $kode_soal = Dits::genKodeSoal('4');
            $bank_soal = [
                'uuid' => $uid,
                'uuid_madrasah' => $data->uuid_madrasah,
                'uuid_operator' => $data->uuid,
                'kode_soal' => $kode_soal,
                'status_bank_soal' => 'Aktif',
                'crash_session' => 'No',
                'timer_cat' => 90,
                'tgl_bank_soal' => Carbon::now(),
            ];
            BankSoal::create($bank_soal);
        }
    }

    public function GenDataSoal()
    {
        // GENERATE 100 SOALS
        // Syarat Sudah Ada Bank Soal
        // Akses Function Ini Di URL :  /noc/gen/data-soal
        $bank_soal = BankSoal::whereStatusBankSoal('Aktif')->get();
        foreach($bank_soal as $data){
            for ($i = 1; $i <= 100; $i++) {
                $jawaban = array_merge(range('A', 'D'));
                $uid = Str::uuid();
                $soal = [
                    "uuid" => $uid,
                    "uuid_operator" => $data->uuid_operator,
                    "kode_soal" => $data->kode_soal,
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
}
