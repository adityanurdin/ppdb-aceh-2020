-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Mar 2020 pada 01.00
-- Versi server: 10.4.8-MariaDB
-- Versi PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ppdb_2020_adit`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `madrasahs`
--

CREATE TABLE `madrasahs` (
  `uuid` varchar(191) NOT NULL,
  `kode_satker` varchar(100) DEFAULT NULL,
  `nsm` varchar(15) DEFAULT NULL,
  `npsn` varchar(15) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `jenjang` varchar(3) DEFAULT NULL,
  `nama_madrasah` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `kabupaten` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `email_madrasah` varchar(100) DEFAULT NULL,
  `kontak_madrasah` varchar(100) DEFAULT NULL,
  `akreditasi` varchar(50) DEFAULT NULL,
  `logo_madrasah` text DEFAULT NULL,
  `preview` text DEFAULT NULL,
  `persyaratan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `madrasahs`
--

INSERT INTO `madrasahs` (`uuid`, `kode_satker`, `nsm`, `npsn`, `status`, `jenjang`, `nama_madrasah`, `alamat`, `kelurahan`, `kecamatan`, `kabupaten`, `provinsi`, `email_madrasah`, `kontak_madrasah`, `akreditasi`, `logo_madrasah`, `preview`, `persyaratan`, `created_at`, `updated_at`) VALUES
('1109020b-6d64-4858-ae87-1e08a1235a01', '601000', '111111710001', '60703472', 'Negeri', 'MI', 'MIN 1 MESJID RAYA KOTA BANDA ACEH', 'Jalan Makam Pahlawan Lrg. Min No. 9', 'Ateuk Pahlawan', 'Baiturrahman', 'Kota Banda Aceh', 'Aceh', 'minmesjidraya@yahoo.com', '085360799190', 'Terakreditasi A', '', '', 'Foto Copy Akte Kelahiran (perlihatkan yang asli), Foto Coy KK (perlihatkan yang asli), Foto Copy Kartu NISN (Jika ada), Foto Copy Kartu KIP/PKH/KKS (Jika ada), Pemeriksaan Dokumen dan Pengesahan Dokumen diterima sampai dengan tanggal 01 Mei 2019 ( Pukul 09 s/d 11.30 WIB), Bagi Peserta yang Formulirnya tidak disahkan (stempel) Panitia PPDB MIN 1 tidak dibenarkan mengikuti Uji Kesiapan pada MIN 1 ', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('1bc61df7-3dce-4af6-a4e4-3ce69890098b', '601098', '111111710007', '60703474', 'Negeri', 'MI', 'MIN 8 LHONG RAYA KOTA BANDA ACEH', 'Jl. Sultan Malikul Saleh', 'Lhong Raya', 'Banda Raya', 'Kota Banda Aceh', 'Aceh', '025.601098.kd@gmail.com', '(0651)24531', 'Terakreditasi A', '', '', 'Asli dan Fotocopy Akte Kelahiran, Asli dan Fotocopy Kartu Keluarga (KK), Pas Photo Warna 3x4 cm Latar Belakang Merah 2 Lembar, Kartu NISN Siswa (Jika Ada), Semua Berkas Dimasukkan Ke Dalam Map (Laki-laki Map Merah Perempuan Map Kuning), Semua Berkas Verifikasi Kami Terima Mulai Tanggal 25 sd. 30 April 2019', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('2a870cbb-2fc1-4077-bdb0-4ef2004b8b85', '96398', '131211060004', '546596398', 'Negeri', 'MA', 'DARUL IHSAN', 'Jl. Darussalam', 'Darussalam', 'Darussalam', 'Aceh Besar', 'Aceh', 'darul@gmail.com', '089900880099', 'Terakreditasi A', '', '', NULL, '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('2f53758c-f071-4cce-9d1b-750fa4459b2d', '025.04.2.614464/2016', '131111710003', '10113772', 'Negeri', 'MA', 'MAN 3 RUKOH KOTA BANDA ACEH', 'Jl.lingkar Kampus Uin Ar-Raniry', 'Rukoh', 'Syiah Kuala', 'Kota Banda Aceh', 'Aceh', '', '', 'Terakreditasi A', '', '', 'Pas Photo Ukuran 4x6 sebanyak 3 lembar,Fotocopy Akte Kelahiran,Fotocopy KK,Fotocopy KTP Orang Tua,Fotocopy Rapor,Fotocopy SK/Sertifikat/Piagam Prestasi Akademik atau Non Akademik (Jika Ada),Fotocopy Ijazah SMP/MTs,Fotocopy SKHUN/Surat Keterangan Lulus SMP/MTs,Fotocopy KIP/KPS/KMS/SKTM/KKM/KRM (Jika Ada)', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('37baed0a-c277-45ee-ab5f-2363b30e2b45', '614251', '121111710004', '10114183', 'Negeri', 'MTs', 'MTsN 4 RUKOH KOTA BANDA ACEH', 'Rukoh Utama', 'Kopelma Darussalam', 'Syiah Kuala', 'Kota Banda Aceh', 'Aceh', 'mtsnempatbna@gmail.com', '', 'Terakreditasi A', '', '', ' Kartu NISN, Fotocopy Rapor Kelas V (Sem 1 &amp; 2) dan VI (Sem 1) yang telah dilegalisir, Pas photo 3x4 latar Merah 2 lbr, Semua Berkas dimasukkan dalam Map Biru (Laki-Laki) dan Map Merah (Perempuan) dibawa saat masa pendaftaran mulai tanggal 15 - 27 April Pada Saat Jam Kerja, Pengumuman Lulus Seleksi Administrasi akan diumumkan pada Tanggal 28 April 2019 di Website simppdbmadrasah.com atau Di Sekolah MTsN 4, Cetak Bukti Pendaftaran Sebanyak 2 lembar', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('4e5a7b2c-e034-4df8-a198-5ab6a9906468', '573762', '121111710003', '10114175', 'Negeri', 'MTs', 'Meuraxa Kota Banda Aceh', 'Jln. Kampus Unida', 'Punge Blang Cut', 'Jaya Baru', 'Kota Banda Aceh', 'Aceh', '', '', '', '', '', NULL, '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('500a6686-c36d-4a09-ab99-2abbb3d62707', '601081', '111111710010', '60703476', 'Negeri', 'MI', 'MIN 7 TELADAN KOTA BANDA ACEH', 'Jln. Cut Nyak Dhien Lamteumen Barat', 'Lamteumen Barat', 'Jaya Baru', 'Kota Banda Aceh', 'Aceh', 'minteladanaceh@gmail.com', '', 'Terakreditasi A', '', '', ' Calon Peserta Didik Baru tidak perlu membawa perlengkapan apa-apa selain kartu ini, Setelah diprint kartu ini dibawa ke Madrasah pada hari Uji Kesiapan tanggal 2 Mei 2019, Kartu ini tidak perlu dibawa ke Madrasah sebelum hari Uji Kesiapan, Print Kartu Ujian ini di kertas Linen putih/tebal, Pada Kolom Nama Ketua Panitia PPDB Madrasah ditulis secara manual (Fuanni S. Pd. I NIP. 198308012005011007), Uji Kesiapan dilaksanakan pada tanggal 2 Mei 2019 Pukul 08.00 S/d Selesai, Pada hari Uji Kesiapan kartu ini diserahkan kepada Panitia untuk distempel, Nomor Pendaftaran akan diberikan oleh Panitia setelah selesai Uji Kesiapan, Apabila ada hal yang kurang jelas silahkan hubungi kami di Nomor Handphone 081275199207', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('60d83229-09d2-4aa5-b245-aa14a9e9ab89', '613718', '111111710009', '60703480', 'Negeri', 'MI', 'MIN 11 RUKOH BANDA ACEH', 'Jl. Lingkar Kampus UIN Ar-Raniry Darsussalam', 'Rukoh', 'Syiah Kuala', 'Kota Banda Aceh', 'Aceh', 'min.rukohkotabna@gmail.com', '', 'Terakreditasi A', '', '', 'Calon Peserta Didik Baru tidak perlu membawa persyaratan apapun selain Kartu UJian,Print Kartu Ujian ini Pada Kertas Lineu putih/tebal,Kartu Ujian ini diserahkan kepada panitia untuk di stempel sebelum pelaksanaan Uji Kesiapan,Uji Kesiapan dilaksanakan pada tanggal 2 Mei 2019 Pukul 08.00 s/d Selesai,1. Kartu Ujian,2. Pas Photo 3 x 4 = 2 Lembar (Latar Merah),3. Fotocopy Akte Kelahiran,4. Fotocopy Kartu Keluarga(KK),5. Fotocopy NISN (Jika Ada),6. Fotocopy KTP orang Tua,7. Fotocopy Kartu KIP/PKH/KKS (Jika ada),Berkas Persyaratan point 1 s.d 7 diatas diserahkan setelah siswa dinyatakan &quot;LULUS&quot;,Semua berkas dimasukkan ke dalam MAP (Perempuan=Merah.Laki-Laki=Biru). Tuliskan Nama dan Nomor Ujian,Ikuti terus update informasi terbaru di akun Anda masing-masing', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('6a4e4fde-44ec-440b-8d29-8111cf4606ac', '601042', '111111710005', '60703478', 'Negeri', 'MI', 'MIN 6 MODEL KOTA BANDA ACEH', 'Jl. Syiah Kuala No. 9', 'Kp. Keuramat', 'Kuta Alam', 'Kota Banda Aceh', 'Aceh', 'min.modelbandaaceh@gmail.com', '', 'Terakreditasi A', '', '', NULL, '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('80042a7e-3584-468c-8d8e-072aa56f4938', '601077', '111111710008', '60703475', 'Negeri', 'MI', 'MIN 10 ULEE LHEU KOTA BANDA ACEH', 'Jl. Meusara, Kel. Punge Blang Cut, Kec. Jaya Baru, Kota Banda Aceh', 'Punge Blang Cut', 'Jaya Baru', 'Kota Banda Aceh', 'Aceh', '', '', 'Terakreditasi B', '', '', 'Fotocopy Akte Kelahiran,Fotocopy KK,Fotocopy Ijazah TK/RA bagi yang ada, Fotocopy Kartu NISN bagi Yang Ada,Tes Tanggal 2 Mei 2019,Biodata Peserta Online harap dibawa saat Tes, Pengumuman hasil Tes Tanggal 4 Mei 2019,Daftar Ulang Kelulusan tanggal 13 s.d 18 Mei 2019 dengan melampirkan bukti Pendaftaran Secara Online', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('81f00113-cb3d-4e8a-829f-f3fb5405364f', '298402', '121111710001', '10114176', 'Negeri', 'MTs', 'MTsN 1 MODEL KOTA BANDA ACEH', 'Jalan Pocut Baren No.114 Banda Aceh', 'Keuramat', 'Kuta Alam', 'Kota Banda Aceh', 'Aceh', 'mtsnmodel.bna@gmail.com', '0651- 23965', 'Belum Akreditasi', '', '', 'Kartu tanda peserta atau Surat keterangan sebagai peserta UN atau UAMP/UASBN dari Kepala Madrasah/ Sekolah, Kartu NISN,Fotocopy Rapor kelas V (sem 1&amp;2) dan VI (sem 1) yang telah dilegalisir,Pas photo 3x4 1 lembar layar merah,Semua Berkas dimasukkan dalam Map Biru (Laki-laki) dan Map Merah (Perempuan) dibawa pada saat masa pendaftaran mulai tanggal 15-27 april pada jam kerja,Pengumuman lulus seleksi Administrasi akan diumumkan pada tanggal 28 april 2019 di Website. https://mtsnmodelbandaaceh.sch.id/  atau simppdbmadrasah.com, Cetak bukti pendaftaran sebanyak 2 lembar', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('90c085e3-5a03-4e64-9fd2-bc756458c094', '601014', '111111710002', '60703473', 'Negeri', 'MI', 'MIN 4 SEUTUI KOTA BANDA ACEH', 'Jln. Sultan Alaidin Jhohansyah No. 36', 'Seutui', 'Baiturrahman', 'Kota Banda Aceh', 'Aceh', '', '', 'Terakreditasi A', '', '', 'Pasfoto 3x4 4 lembar, Fotocopy KK. Fotocopy Akte Kelahiran, Fotocopy Ijazah TK/RA/PAUD (Jika Ada), Fotocopy Kartu NISN (Jika Ada), Fotocopy Sertifikat Perlombaan (Jika Ada)', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('a0f39cd2-200b-402b-826a-350b120b03ba', '601035', '111111710004', '60703477', 'Negeri', 'MI', 'MIN 2 MERDUATI KOTA BANDA ACEH', 'Jl.twk.hasyim Banta Muda No.19', 'Mulia', 'Kuta Alam', 'Kota Banda Aceh', 'Aceh', 'min.merduati@gmail.com', '', 'Terakreditasi A', '', '', 'Akta lahir legalisir,Foto Copi KK, ijazah TK/RA,Pas foto Warna merah 3x4 2 lembar', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('b87c4100-a548-4aff-834e-b9103cd78cac', '298419', '131111710001', '10113769', 'Negeri', 'MA', 'MAN 1 MODEL KOTA BANDA ACEH', 'Pocut Baren No. 116', 'Keuramat', 'Kuta Alam', 'Kota Banda Aceh', 'Aceh', 'mandelbandaaceh@gmail.com', '0651 636804', 'Terakreditasi A', '', '', ' Foto copy rapor sem 3 sd. 5 dengan nilai rata-rata per semester min. 75 (Dilegalisir), Pas foto terbaru 3x4 (2 lembar), Sertifikat prestasi min. tk. Kab/Kota 3 tahun terakhir (Jika ada), Berkas persyaratan diserahkan paling telat saat ujian tulis (CBT), Semua berkas dimasukkan ke dalam map (Laki-laki: biru. Perempuan: merah). Tuliskan nama &amp; asal sekolah, Pengumuman jadwal pembagian SESI Ujian CBT dan Tes Lisan/Wawancara: 24 April 2019 (info selengkapnya di: www.manmodelbna.sch.id), Ikuti terus update informasi terbaru di akun Anda masing-masing', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('e10c736e-9b94-49ee-b1dc-3c480d146470', '601060', '111111710011', '60703482', 'Negeri', 'MI', 'MIN 9 LAMBHUK KOTA BANDA ACEH', 'Jln. Prof. Dr.t. Syarief Thayeb No. 18', 'Lambhuk', 'Ulee Kareng', 'Kota Banda Aceh', 'Aceh', '', '', 'Terakreditasi A', '', '', 'Pasphoto warna 3x4 layar merah 1 lembar, Fotocopy Ijazah 1 lembar ( bila ada), Fotocopy Akte Kelahiran 1 lembar, Fotocopy Kartu Keluarga (KK) 1 lembar, Semua Berkas dimasukkan dalam Map Biru (laki-laki) dan Map Merah (Perempuan) dibawa pada saat masa pendaftaran mulai tanggal 25-30 April 2019 pada jam kerja, Pengumuman lulus Administrasi akan diumumkan pada tanggal 1 Mei 2019 di Website www.min9bandaaceh.com atau simppdbmadrasah.com, Cetak bukti Pendaftaran sebanyak 2 lembar', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('f28de61f-6658-4257-a2ab-5cc3845b5cd3', '601056', '111111710006', '60703481', 'Negeri', 'MI', 'MIN 5 ULEE KARENG KOTA BANDA ACEH', 'Jalan Mesjid Tuha No.02', 'Ie Masen', 'Ulee Kareng', 'Kota Banda Aceh', 'Aceh', '', '', 'Terakreditasi A', '', '', 'Fotocopy Akte Kelahiran, Fotocopy KK', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('f5ddde14-b11e-4145-8ac5-5d6ea64f7f2e', '298397', '131111710002', '10113768', 'Negeri', 'MA', 'MAN 2 KOTA BANDA ACEH', 'Jln. Cut Nyak Dhien No. 590', 'Lamteumen Barat', 'Jaya Baru', 'Kota Banda Aceh', 'Aceh', 'man2bna.nad@gmail.com', '(0651) 41105', 'Terakreditasi A', '', '', 'Formulir &amp; Kelengkapan ini Serahkan Saat Siswa Daftar Ulang (Sudah Lulus),Menyerahkan Pas Foto Latar Belakang Merah 3x4  -  6 Lembar,Menyerahkan Pas Foto Latar Belakang Merah 2x3  -  6 Lembar,Mengisi Buku Biodata yang telah disediakan Panitia,Foto Copy Rapor SMP/MTSN,Melampirkan Foto Copy Sertifikat/Piagam Prestasi(Jika ada),Foto Copy Ijazah /  SKHUN,Surat Keterangan Telah Mengikuti Ujian Akhir Madrasah dari Kepala Madrasah.(Apabila belum keluar Ijazah dan SKHUN),Foto Copy Kartu KIP/KPS/KMS/SKTM/KKM/KRM (Jika ada),Foto Copy Kartu Ujian UNBK Sekolah Asal,Foto Copy Akte Kelahiran,Foto Copy Kartu Keluarga,Foto Copy KTP Ayah dan Ibu,File Pas Foto dan Akte Kelahiran serta Kartu Keluarga di Scan di Masukkan ke dalam CD/DVD,Semua Berkas di Masukkan dalam MAP yang telah disediakan', '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('fc5d65f3-0e7c-444a-9e07-9237a5fc8b85', '309044', '121111710002', '10114180', 'Negeri', 'MTs', 'Banda Aceh II', 'Jl.tgk Imuem Lueng Bata', 'Lueng Bata', 'Lueng Bata', 'Kota Banda Aceh', 'Aceh', '', '', '', '', '', NULL, '2020-03-27 16:04:33', '2020-03-27 17:39:16'),
('fe0f2dff-c5f2-430e-89fa-be205dcb1271', '601021', '111111710003', '60703479', 'Negeri', 'MI', 'MIN 3 SUKADAMAI KOTA BANDA ACEH', 'Jln.kutilang No.7 Sukadamai', 'Sukadamai', 'Lueng bata', 'Kota Banda Aceh', 'Aceh', '02504.601021kd@gmail.com', '065122789', 'Terakreditasi B', '', '', 'Calon Peserta didik Baru tidak perlu membawa perlengkapan apa-apa selain kartu ini, Print kartu Ujian ini di kertas putih dan tebal, kartu ini tidak perlu dibawa ke Madrasah Sebelum Uji Kesiapan, Uji Kesiapan dilaksanakan pada tanggal 2 Mei 2019 pada pukul 08.00 s/d 12.00, Pada hari Uji Kesiapan kartu ini diserahkan kepada Panitia untuk di stempel dan di tanda tangani Panitia PPDB', '2020-03-27 16:04:33', '2020-03-27 17:39:16');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `madrasahs`
--
ALTER TABLE `madrasahs`
  ADD PRIMARY KEY (`uuid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
