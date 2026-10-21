<?php
    // Memanggil koneksi
    include "../config/koneksi.php";
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Mengamankan ID Karyawan dari Session login
    $id_kar = !empty($_SESSION['ID_Karyawan']) ? mysqli_real_escape_string($koneksi, $_SESSION['ID_Karyawan']) : '';

   
    $sudah_absen_hari_ini = false;
    if (!empty($id_kar)) {
        $cek_hari_ini = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM absensi WHERE ID_Karyawan = '$id_kar' AND tanggal = CURDATE()");
        $row_cek = mysqli_fetch_assoc($cek_hari_ini);
        $sudah_absen_hari_ini = ($row_cek['total'] > 0);
    }

    //  Pencarian Bulan 
    $filter_bulan = isset($_GET['bulan']) ? mysqli_real_escape_string($koneksi, $_GET['bulan']) : '';

    //  Hitung Ringkasan Data Absensi Karyawan 
    $hadir_count = 0; $izin_count = 0; $alpa_count = 0;
    if (!empty($id_kar)) {
        $stat_hadir = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM absensi WHERE ID_Karyawan = '$id_kar' AND status_hadir = 'Hadir'"));
        $hadir_count = $stat_hadir['total'] ?? 0;

        $stat_izin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM absensi WHERE ID_Karyawan = '$id_kar' AND status_hadir IN ('Izin', 'Sakit', 'Cuti')"));
        $izin_count = $stat_izin['total'] ?? 0;

        $stat_alpa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM absensi WHERE ID_Karyawan = '$id_kar' AND status_hadir = 'Alpa'"));
        $alpa_count = $stat_alpa['total'] ?? 0;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Saya</title>
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

        
        .widget-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .widget-title {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 6px;
        }
        .widget-value {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
        }

        
        .filter-select {
            max-width: 220px;
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #ffffff;
        }

        .card-table-wrapper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
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
            color: #1e293b;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc ;
        }

        
        .badge-status {
            padding: 6px 14px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 13px;
            display: inline-block;
        }
        .badge-hadir { background-color: #dcfce7 ; color: #15803d ; }
        .badge-sakit { background-color: #fef9c3 ; color: #a16207 ; }
        .badge-izin { background-color: #ffedd5 ; color: #c2410c ; }
        .badge-cuti { background-color: #e0f2fe ; color: #0369a1 ; }
        .badge-alpa { background-color: #fee2e2 ; color: #b91c1c ; }
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
                <h2 class="fw-bold text-dark" style="margin: 0;">Absensi Saya</h2>
                <p class="text-muted small mb-0">Riwayat pencatatan kehadiran Anda pribadi</p>
            </div>
            <div>
                <?php if ($sudah_absen_hari_ini): ?>
                    <span class="badge bg-secondary px-3 py-2" style="border-radius:6px; font-weight:500;">Absensi hari ini sudah dicatat</span>
                <?php else: ?>
                    <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#tambah_absensi" style="border-radius:6px; font-weight:500;">
                        Isi Absensi Hari Ini
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <?php include "../admin/modal/add_absensi.php"; ?>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="widget-card">
                    <div class="widget-title">Total Hadir Bulan Ini</div>
                    <div class="widget-value text-success"><?= $hadir_count ?> Hari</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-card">
                    <div class="widget-title">Total Izin / Sakit / Cuti</div>
                    <div class="widget-value text-warning"><?= $izin_count ?> Hari</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-card">
                    <div class="widget-title">Mangkir (Alpa)</div>
                    <div class="widget-value text-danger"><?= $alpa_count ?> Hari</div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <form action="" method="GET" class="d-flex gap-2 align-items-center">
                <select name="bulan" class="filter-select" onchange="this.form.submit()">
                    <option value=""> Semua Bulan </option>
                    <option value="01" <?= $filter_bulan == '01' ? 'selected' : '' ?>>Januari</option>
                    <option value="02" <?= $filter_bulan == '02' ? 'selected' : '' ?>>Februari</option>
                    <option value="03" <?= $filter_bulan == '03' ? 'selected' : '' ?>>Maret</option>
                    <option value="04" <?= $filter_bulan == '04' ? 'selected' : '' ?>>April</option>
                    <option value="05" <?= $filter_bulan == '05' ? 'selected' : '' ?>>Mei</option>
                    <option value="06" <?= $filter_bulan == '06' ? 'selected' : '' ?>>Juni</option>
                    <option value="07" <?= $filter_bulan == '07' ? 'selected' : '' ?>>Juli</option>
                    <option value="08" <?= $filter_bulan == '08' ? 'selected' : '' ?>>Agustus</option>
                    <option value="09" <?= $filter_bulan == '09' ? 'selected' : '' ?>>September</option>
                    <option value="10" <?= $filter_bulan == '10' ? 'selected' : '' ?>>Oktber</option>
                    <option value="11" <?= $filter_bulan == '11' ? 'selected' : '' ?>>November</option>
                    <option value="12" <?= $filter_bulan == '12' ? 'selected' : '' ?>>Desember</option>
                </select>
                <?php if($filter_bulan != ''): ?>
                    <a href="index_absensi.php" class="btn btn-sm btn-link text-decoration-none text-muted">Clear</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="card-table-wrapper">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Tanggal Absen</th>
                        <th>Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    
                    // Membuat filter pencarian SQL dinamis berdasarkan bulan
                    $where_clause = "WHERE absensi.ID_Karyawan = '$id_kar'";
                    if ($filter_bulan != "") {
                        $where_clause .= " AND MONTH(absensi.tanggal) = '$filter_bulan'";
                    }

                    // Menjalankan query panggil data riwayat
                    $sql = "SELECT absensi.*, karyawan.Nama_Karyawan 
                            FROM absensi
                            INNER JOIN karyawan ON absensi.ID_Karyawan = karyawan.ID_Karyawan 
                            $where_clause
                            ORDER BY absensi.tanggal DESC";
                    
                    $hasil = mysqli_query($koneksi, $sql);

                    if(mysqli_num_rows($hasil) == 0) {
                        echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada riwayat absensi tercatat.</td></tr>";
                    }

                    while($data = mysqli_fetch_assoc($hasil)){
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-semibold text-capitalize"><?= $data['Nama_Karyawan'] ?></td>
                        <td class="text-secondary"><?= date('d F Y', strtotime($data['tanggal'])) ?></td>
                        <td>
                            <?php if($data['status_hadir'] == 'Hadir'): ?>
                                <span class="badge-status badge-hadir">Hadir</span>
                            <?php elseif($data['status_hadir'] == 'Alpa'): ?>
                                <span class="badge-status badge-alpa">Alpa</span>
                            <?php elseif($data['status_hadir'] == 'Sakit'): ?>
                                <span class="badge-status badge-sakit">Sakit</span>
                            <?php elseif($data['status_hadir'] == 'Izin'): ?>
                                <span class="badge-status badge-izin">Izin</span>
                            <?php elseif($data['status_hadir'] == 'Cuti'): ?>
                                <span class="badge-status badge-cuti">Cuti</span>
                            <?php else: ?>
                                <span class="badge-status badge-sakit"><?= $data['status_hadir'] ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>