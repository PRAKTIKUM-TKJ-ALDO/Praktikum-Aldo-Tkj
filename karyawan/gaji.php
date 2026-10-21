<?php
    //Memanggil koneksi
    //untuk keluar folder harus menggunakan../
    session_start();
    include "../config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penggajian Karyawan</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .navbar {
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
        }
        .konten-utama {
            padding: 30px;
            background-color: #f8fafc;
        }
        .card-table-wrapper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            overflow: hidden;
        }
        .table thead th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: none;
            font-size: 13px;
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .table tbody td {
            padding: 16px 20px;
            color: #1e293b;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .badge-dibayar {
            background-color: #dcfce7 ;
            color: #15803d ;
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 500;
        }
        .badge-pending {
            background-color: #fef9c3 ;
            color: #a16207 ;
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 500;
        }
        .btn-link-detail {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        .btn-link-detail:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <ul>
            <i><img src="../icon/Modern logo design for Gajian Gak.png" alt="icon"></i>
            <li><a href="../karyawan/index.php"><img src="../icon/home.png" alt="icon"> Beranda</a></li>
            <li><a href="../karyawan/index_absensi.php"><img src="../icon/calendar.png" alt="icon"> Absensi</a></li>
            <li><a href="../karyawan/gaji.php"><img src="../icon/sack-dollar.png" alt="icon"> Gaji</a></li>
        </ul>
    </div>

    <div class="konten-utama">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 fw-bold text-dark">Sistem Penggajian Karyawan</h1>
                <p class="text-muted small mb-0">Periode: <?= date('F Y') ?></p>
            </div>
        </div>

        <div class="card-table-wrapper">
            <div class="table-responsive">
                <table id="tabelGaji" class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Gapok</th>
                            <th>Tunjangan</th>
                            <th>Lembur</th>
                            <th>Potongan</th>
                            <th>Gaji Bersih</th>
                            <th>Tanggal Gaji</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px;">
                        <?php
                        $no = 1;
                        if (!empty($_SESSION['ID_Karyawan'])) {
                            $id_kar_login = mysqli_real_escape_string($koneksi, $_SESSION['ID_Karyawan']);
                            $sql = "SELECT gaji.*, karyawan.Nama_Karyawan, karyawan.ID_Karyawan as IDK 
                                    FROM gaji 
                                    JOIN karyawan ON gaji.ID_Karyawan = karyawan.ID_Karyawan 
                                    WHERE gaji.ID_Karyawan = '$id_kar_login'";
                        } else {
                            $sql = "SELECT gaji.*, karyawan.Nama_Karyawan, karyawan.ID_Karyawan as IDK 
                                    FROM gaji 
                                    JOIN karyawan ON gaji.ID_Karyawan = karyawan.ID_Karyawan";
                        }
                        $hasil = mysqli_query($koneksi, $sql);

                        while($data = mysqli_fetch_assoc($hasil)){
                            $id_kar = $data['IDK'];
                            $bulan = date('m');
                            $a_absen = mysqli_query($koneksi, "SELECT COUNT(*) as total_alpa FROM absensi WHERE ID_Karyawan = '$id_kar' AND status_hadir = 'Alpa' AND MONTH(tanggal) = '$bulan'");
                            $a_absen2 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM absensi WHERE ID_Karyawan = '$id_kar' AND status_hadir IN ('Sakit', 'Izin', 'Cuti') AND MONTH(tanggal) = '$bulan'");
                            $b_absen = mysqli_fetch_assoc($a_absen);
                            $b_absen2 = mysqli_fetch_assoc($a_absen2);

                            
                            $total_potongan_alpa = $b_absen['total_alpa'] * 50000; 
                            $total_potongan_izin = $b_absen2['total'] * 10000; 
                            $total_potongan = $total_potongan_alpa + $total_potongan_izin;

                            $gaji_bersih = ($data['gaji_pokok'] + $data['tunjangan'] + $data['lembur']) - $total_potongan;
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-secondary"><?= $data['IDK'] ?></td>
                            <td><span class="fw-semibold"><?= $data['Nama_Karyawan'] ?></span></td>
                            <td>Rp <?= number_format($data['gaji_pokok'],0,',','.') ?></td>
                            <td>Rp <?= number_format($data['tunjangan'],0,',','.') ?></td>
                            <td>Rp <?= number_format($data['lembur'],0,',','.') ?></td>
                            <td class="text-danger">Rp <?= number_format($total_potongan,0,',','.') ?></td>
                            <td class="fw-bold text-dark">Rp <?= number_format($gaji_bersih,0,',','.') ?></td>
                            <td><?= !empty($data['tanggal_input']) ? $data['tanggal_input'] : '-' ?></td>
                            <td>
                                <?php if(($data['status_pengajuan'] ?? '') == 'Selesai' || ($data['status_pengajuan'] ?? '') == 'Dibayar') : ?>
                                    <span class="badge badge-dibayar">Dibayar</span>
                                <?php else : ?>
                                    <span class="badge badge-pending">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(($data['status_pengajuan'] ?? '') == 'Selesai' || ($data['status_pengajuan'] ?? '') == 'Dibayar') : ?>
                                    <a href="struk_gaji.php?id=<?= $data['id_gaji'] ?>" target="_blank" class="btn-link-detail">👁️ Detail</a>
                                <?php else : ?>
                                    <small class="text-muted">Menunggu</small>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php 
                        include "../admin/modal/edit_gaji.php";
                        }
                         ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>