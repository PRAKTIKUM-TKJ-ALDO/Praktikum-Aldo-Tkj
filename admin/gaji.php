<?php
    // Memanggil koneksi
    session_start();
    include "../config/koneksi.php";

    // Menangkap input pencarian dan filter status (PHP Murni)
    $cari = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';
    $status_filter = isset($_GET['status']) ? mysqli_real_escape_string($koneksi, $_GET['status']) : '';

    // --- LOGIKA HITUNG STATISTIK UNTUK UTAS ATAS ---
    $bulan_ini = date('m');
    
    // 1. Total Pengeluaran Gaji Bersih Bulan Ini
    $q_total_gaji = mysqli_query($koneksi, "SELECT SUM(gaji_pokok + tunjangan + lembur) as total_bruto FROM gaji");
    $r_total_gaji = mysqli_fetch_assoc($q_total_gaji);
    $total_pengeluaran = $r_total_gaji['total_bruto'] ?? 0;

    // 2. Total Karyawan Terdaftar
    $q_total_kar = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM karyawan");
    $r_total_kar = mysqli_fetch_assoc($q_total_kar);
    $total_karyawan = $r_total_kar['jml'] ?? 0;

    // 3. Rasio Pembayaran Selesai/Dibayar
    $q_dibayar = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM gaji WHERE status_pengajuan = 'Selesai'");
    $r_dibayar = mysqli_fetch_assoc($q_dibayar);
    $sudah_dibayar = $r_dibayar['jml'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penggajian Karyawan</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .konten-utama {
            padding: 30px;
        }

        /* --- DASHBOARD STAT CARDS STYLE --- */
        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.01);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
        }

        .icon-blue { background-color: #e0f2fe; color: #0369a1; }
        .icon-green { background-color: #dcfce7; color: #15803d; }
        .icon-purple { background-color: #f3e8ff; color: #6b21a8; }

        .stat-label { font-size: 13px; color: #64748b; margin-bottom: 4px; font-weight: 500; }
        .stat-value { font-size: 22px; font-weight: 700; color: #1e293b; }

        /* --- CONTROL PANEL FILTER & SEARCH --- */
        .search-input {
            padding: 10px 16px;
            font-size: 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            max-width: 320px;
        }

        .filter-select {
            padding: 10px 16px;
            font-size: 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #ffffff;
            color: #1e293b;
        }

        /* --- CARD TABLE WRAPPER MODERN --- */
        .card-table-wrapper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            margin-top: 20px;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-bottom: 0 ;
        }

        .table-custom thead th {
            background-color: #f8fafc ;
            color: #475569 ;
            padding: 14px 20px;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-custom tbody td {
            padding: 16px 20px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc ;
        }

        /* --- BADGE STATUS MODERN --- */
        .badge-payment {
            padding: 6px 14px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 12px;
            display: inline-block;
        }
        .status-dibayar { background-color: #dcfce7 ; color: #15803d ; }
        .status-pending { background-color: #fef9c3 ; color: #a16207 ; }
        .status-belum { background-color: #f1f5f9 ; color: #475569 ; }

        .text-capitalize { text-transform: capitalize; }
    </style>
</head>

<body>
    <div class="navbar">
        <ul>
            <i><img src="../icon/Modern logo design for Gajian Gak.png" alt="icon"></i>
            <li><a href="../index.php"><img src="../icon/home.png" alt="icon"> Beranda</a></li>
            <li><a href="../admin/index_karyawan.php"><img src="../icon/users-alt.png" alt="icon"> Karyawan</a></li>
            <li><a href="../admin/index_absensi.php"><img src="../icon/calendar.png" alt="icon"> Absensi</a></li>
            <li><a href="../admin/gaji.php"><img src="../icon/sack-dollar.png" alt="icon"> Gaji</a></li>
        </ul>
    </div>

    <div class="konten-utama">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark" style="margin: 0;">Sistem Penggajian Karyawan</h2>
                <p class="text-muted small mb-0">Periode saat ini: <?= date('F Y') ?></p>
            </div>
            <button type="button" class="btn btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#tambah_gaji" style="border-radius: 8px; font-weight: 500;">
                Tambah Gaji
            </button>
        </div>

        <?php include "modal/add_gaji.php"; ?>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon icon-blue">$</div>
                    <div>
                        <div class="stat-label">Total Gaji Terhitung</div>
                        <div class="stat-value">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon icon-green">👥</div>
                    <div>
                        <div class="stat-label">Total Karyawan</div>
                        <div class="stat-value"><?= $total_karyawan ?> Orang</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon icon-purple">📅</div>
                    <div>
                        <div class="stat-label">Status Pembayaran</div>
                        <div class="stat-value"><?= $sudah_dibayar ?> / <?= $total_karyawan ?></div>
                    </div>
                </div>
            </div>
        </div>

        <form action="" method="GET" class="row g-2 align-items-center mb-3">
            <div class="col-auto">
                <input type="text" name="cari" class="form-control search-input" placeholder="Cari nama karyawan..." value="<?= htmlspecialchars($cari) ?>">
            </div>
            <div class="col-auto">
                <select name="status" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Selesai" <?= $status_filter == 'Selesai' ? 'selected' : '' ?>>Selesai / Dibayar</option>
                    <option value="Pending" <?= $status_filter == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Belum Diajukan" <?= $status_filter == 'Belum Diajukan' ? 'selected' : '' ?>>Belum Diajukan</option>
                </select>
            </div>
            <?php if($cari != '' || $status_filter != ''): ?>
                <div class="col-auto">
                    <a href="gaji.php" class="btn btn-outline-secondary" style="border-radius: 8px;">Reset Filter</a>
                </div>
            <?php endif; ?>
        </form>

        <div class="card-table-wrapper">
            <div class="table-responsive">
                <table id="tabelGaji" class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Karyawan</th>
                            <th>Gapok</th>
                            <th>Tunjangan</th>
                            <th>Lembur</th>
                            <th>Potongan</th>
                            <th>Gaji Bersih</th>
                            <th>Tanggal Gaji</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        
                        // Membangun kondisi penyaringan query SQL dinamis
                        $conditions = array();
                        if ($cari != '') {
                            $conditions[] = "karyawan.Nama_Karyawan LIKE '%$cari%'";
                        }
                        if ($status_filter != '') {
                            if ($status_filter == 'Belum Diajukan') {
                                $conditions[] = "(gaji.status_pengajuan IS NULL OR gaji.status_pengajuan = 'Belum Diajukan')";
                            } else {
                                $conditions[] = "gaji.status_pengajuan = '$status_filter'";
                            }
                        }

                        $where_sql = "";
                        if (count($conditions) > 0) {
                            $where_sql = " WHERE " . implode(' AND ', $conditions);
                        }

                        $sql = "SELECT gaji.*, karyawan.Nama_Karyawan, karyawan.ID_Karyawan as IDK 
                                FROM gaji 
                                INNER JOIN karyawan ON gaji.ID_Karyawan = karyawan.ID_Karyawan" . $where_sql;
                        
                        $hasil = mysqli_query($koneksi, $sql);

                        if(mysqli_num_rows($hasil) == 0) {
                            echo "<tr><td colspan='11' class='text-center py-4 text-muted'>Data riwayat gaji tidak ditemukan.</td></tr>";
                        }

                        while($data = mysqli_fetch_assoc($hasil)){
                            $id_kar = $data['IDK'];
                            $bulan = date('m');
                            
                            // Menghitung denda komparasi kehadiran harian
                            $a_absen = mysqli_query($koneksi, "SELECT COUNT(*) as total_alpa FROM absensi WHERE ID_Karyawan = '$id_kar' AND status_hadir = 'Alpa' AND MONTH(tanggal) = '$bulan'");
                            $a_absen2 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM absensi WHERE ID_Karyawan = '$id_kar' AND status_hadir IN ('Sakit', 'Izin', 'Cuti') AND MONTH(tanggal) = '$bulan'");
                            $b_absen = mysqli_fetch_assoc($a_absen);
                            $b_absen2 = mysqli_fetch_assoc($a_absen2);

                            
                            $potongan_alpa = $b_absen['total_alpa'] * 50000;
                            $potongan_izin = $b_absen2['total'] * 10000;
                            $total_potongan = $potongan_alpa + $potongan_izin;

                            $gaji_bersih = ($data['gaji_pokok'] + $data['tunjangan'] + $data['lembur']) - $total_potongan;
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-secondary fw-medium"><?= $data['IDK'] ?></td>
                            <td><span class="fw-semibold text-capitalize"><?= $data['Nama_Karyawan'] ?></span></td>
                            <td>Rp <?= number_format($data['gaji_pokok'],0,',','.') ?></td>
                            <td>Rp <?= number_format($data['tunjangan'],0,',','.') ?></td>
                            <td>Rp <?= number_format($data['lembur'],0,',','.') ?></td>
                            <td class="text-danger fw-medium">Rp <?= number_format($total_potongan,0,',','.') ?></td>
                            <td class="fw-bold text-dark">Rp <?= number_format($gaji_bersih,0,',','.') ?></td>
                            <td class="text-secondary"><?= !empty($data['tanggal_input']) ? date('d M Y', strtotime($data['tanggal_input'])) : '-' ?></td>
                            <td>
                                <?php 
                                    $st = $data['status_pengajuan'] ?? 'Belum Diajukan';
                                    if($st == 'Selesai' || $st == 'Dibayar') {
                                        echo '<span class="badge-payment status-dibayar">Dibayar</span>';
                                    } elseif($st == 'Pending') {
                                        echo '<span class="badge-payment status-pending">Pending</span>';
                                    } else {
                                        echo '<span class="badge-payment status-belum">Belum Diajukan</span>';
                                    }
                                ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm px-3 fw-medium text-dark" data-bs-toggle="modal" data-bs-target="#edit_gaji<?= $data['id_gaji'] ?>" style="border-radius:6px; font-size:13px;">
                                    Edit
                                </button>
                            </td>
                        </tr>
                        <?php 
                        include "modal/edit_gaji.php";
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