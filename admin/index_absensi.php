<?php
    // Memanggil koneksi
    include "../config/koneksi.php";

    // Ambil kata kunci pencarian dari URL (jika ada)
    $cari = "";
    if (isset($_GET['cari'])) {
        // mysqli_real_escape_string untuk keamanan agar tidak error jika mengetik tanda petik
        $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Karyawan</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- MODERN DASHBOARD THEME --- */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .konten-utama {
            padding: 30px;
        }

        /* --- STYLING FORM PENCARIAN PHP --- */
        .search-form {
            max-width: 500px;
            width: 100%;
        }

        .search-input {
            padding: 10px 16px;
            font-size: 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px 0 0 8px; /* Sudut melengkung di kiri saja */
            background-color: #ffffff;
            color: #1e293b;
        }

        .search-input:focus {
            outline: none;
            border-color: #cbd5e1;
            box-shadow: 0 0 0 3px rgba(226, 232, 240, 0.5);
        }

        .btn-search {
            background-color: #1e293b;
            color: #ffffff;
            border: 1px solid #1e293b;
            padding: 0 20px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 0 8px 8px 0; /* Sudut melengkung di kanan saja */
            transition: background-color 0.2s;
        }

        .btn-search:hover {
            background-color: #334155;
        }

        .btn-reset {
            border-radius: 8px;
            font-size: 14px;
            padding: 10px 16px;
        }

        /* Pembungkus tabel berkotak minimalis */
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
            margin-bottom: 0 !important;
        }

        .table-custom thead th {
            background-color: #f8fafc !important;
            color: #475569 !important;
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
            background-color: #f8fafc !important;
        }

        /* --- BADGE STATUS --- */
        .badge-status {
            padding: 6px 14px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 13px;
            display: inline-block;
        }

        .badge-hadir { background-color: #dcfce7 !important; color: #15803d !important; }
        .badge-sakit { background-color: #fef9c3 !important; color: #a16207 !important; }
        .badge-izin { background-color: #ffedd5 !important; color: #c2410c !important; }
        .badge-cuti { background-color: #e0f2fe !important; color: #0369a1 !important; }
        .badge-alpa { background-color: #fee2e2 !important; color: #b91c1c !important; }

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
                <h2 class="fw-bold text-dark" style="margin: 0;">Absensi</h2>
                <p class="text-muted small mb-0">Log kehadiran harian seluruh karyawan</p>
            </div>
        </div>

        <div class="d-flex gap-2 align-items-center">
            <form action="" method="GET" class="search-form class-pembungkus">
                <div class="input-group">
                    <input type="text" name="cari" class="form-control search-input" placeholder="Cari nama karyawan..." value="<?= htmlspecialchars($cari) ?>">
                    <button class="btn btn-search" type="submit">Cari</button>
                </div>
            </form>
            
            <?php if ($cari != ""): ?>
                <a href="index_absensi.php" class="btn btn-outline-secondary btn-reset">Sembunyikan Filter</a>
            <?php endif; ?>
        </div>
        
        <?php include "modal/add_absensi.php"; ?>
        
        <div class="card-table-wrapper">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;

                    // Logika Query PHP: Jika ada input pencarian, saring nama karyawan
                    if ($cari != "") {
                        $sql = "SELECT absensi.*, karyawan.Nama_Karyawan 
                                FROM absensi
                                INNER JOIN karyawan ON absensi.ID_Karyawan = karyawan.ID_Karyawan 
                                WHERE karyawan.Nama_Karyawan LIKE '%$cari%'
                                ORDER BY absensi.tanggal DESC";
                    } else {
                        // Jika tidak ada pencarian, tampilkan semua data normal seperti semula
                        $sql = "SELECT absensi.*, karyawan.Nama_Karyawan 
                                FROM absensi
                                INNER JOIN karyawan ON absensi.ID_Karyawan = karyawan.ID_Karyawan 
                                ORDER BY absensi.tanggal DESC";
                    }
                    
                    $hasil = mysqli_query($koneksi, $sql);

                    // Beri info jika hasil pencarian tidak ditemukan
                    if(mysqli_num_rows($hasil) == 0) {
                        echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Data Karyawan bernama \"<b>".htmlspecialchars($cari)."</b>\" tidak ditemukan.</td></tr>";
                    }

                    while($data = mysqli_fetch_assoc($hasil)){
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><span class="fw-semibold text-capitalize"><?= $data['Nama_Karyawan'] ?></span></td> 
                        <td class="text-secondary"><?= date('d M Y', strtotime($data['tanggal'])) ?></td>
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
                                <span class="badge-status badge-sakit text-capitalize"><?= $data['status_hadir'] ?></span>
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