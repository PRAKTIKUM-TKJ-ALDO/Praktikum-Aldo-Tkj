<?php
session_start();

// Memanggil koneksi
include "../config/koneksi.php";

//QUERY PERHITUNGAN STATISTIK DASBOR 
$bulan_ini = date('m');
$hari_ini = date('Y-m-d');

// Hitung Total Karyawan Aktif
$q_kar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM karyawan");
$r_kar = mysqli_fetch_assoc($q_kar);
$total_karyawan = $r_kar['total'] ?? 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GajianGak</title>
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

        
        .welcome-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 16px;
            padding: 35px;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            border: none;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
        }

        .welcome-card h2 {
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .welcome-card p {
            color: #94a3b8;
            font-size: 15px;
            max-width: 500px;
        }

        
        .stat-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.01);
            height: 100%;
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .bg-card-blue { background-color: #e0f2fe; color: #0369a1; }
        .bg-card-green { background-color: #dcfce7; color: #15803d; }
        .bg-card-amber { background-color: #fef9c3; color: #a16207; }
        .bg-card-purple { background-color: #f3e8ff; color: #6b21a8; }

        .stat-text-label { font-size: 13px; color: #64748b; font-weight: 500; margin-bottom: 2px; }
        .stat-text-value { font-size: 22px; font-weight: 700; color: #1e293b; }

        
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin-top: 25px;
            margin-bottom: 15px;
        }

        .card-table-wrapper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .table-custom {
            width: 100%;
            margin-bottom: 0 ;
        }

        .table-custom thead th {
            background-color: #f8fafc ;
            color: #475569 ;
            padding: 14px 20px;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .table-custom tbody td {
            padding: 14px 20px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        /* --- STATUS BADGES --- */
        .badge-status {
            padding: 4px 12px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 12px;
            display: inline-block;
        }
        .badge-hadir { background-color: #dcfce7 ; color: #15803d ; }
        .badge-sakit { background-color: #fef9c3 ; color: #a16207 ; }
        .badge-izin { background-color: #ffedd5 ; color: #c2410c ; }
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
            <li class="mt-5 pt-4"><a href="../logout.php" class="btn btn-danger w-75 mx-auto text-white" style="margin-top:300px; padding: 10px 20px;" >Keluar</a></li>
        </ul>
    </div>

    <div class="konten-utama">
        <div class="welcome-card mb-4">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h2>Selamat Datang Kembali!</h2>
                    <p class="mb-0">Aplikasi GajianGak siap membantu Anda mengelola data karyawan, absensi harian, hingga kalkulasi slip gaji secara terintegrasi dan akurat.</p>
                </div>
                <div class="col-md-5 text-end d-none d-md-block">
                    <img src="../icon/orng.png" style="max-height: 120px; width: auto; object-fit: contain;" alt="ilustrasi">
                </div>
            </div>
        </div>

        <div class="row g-3 mb-2">
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="stat-icon-wrapper bg-card-blue">👥</div>
                    <div>
                        <div class="stat-text-label">Karyawan</div>
                        <div class="stat-text-value"><?= $total_karyawan ?> Orang</div>
                    </div>
                </div>
            </div>

        
        <div class="card-table-wrapper">
            <table class="table table-custom align-middle">
                
                <tbody>
                    <?php
                    $no = 1;
                    // Query memanggil status absensi seluruh karyawan khusus hari ini saja
                    $sql_hari_ini = "SELECT absensi.*, karyawan.Nama_Karyawan 
                                     FROM absensi 
                                     INNER JOIN karyawan ON absensi.ID_Karyawan = karyawan.ID_Karyawan 
                                     WHERE absensi.tanggal = '$hari_ini'
                                     ORDER BY absensi.id_absensi DESC LIMIT 5";
                    $res_hari_ini = mysqli_query($koneksi, $sql_hari_ini);

                    if(mysqli_num_rows($res_hari_ini) == 0){
                        echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada rekaman absensi masuk untuk hari ini.</td></tr>";
                    }

                    while($row_absen = mysqli_fetch_assoc($res_hari_ini)){
                    ?>
                    
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>