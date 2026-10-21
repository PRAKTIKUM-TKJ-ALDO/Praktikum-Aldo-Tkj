<?php
    //Memanggil koneksi
    //untuk keluar folder harus menggunakan../
    include "../config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .konten-utama {
            padding: 30px;
        }

        
        .card-table-wrapper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-bottom: 0 ;
        }

        
        .table-custom thead th {
            background-color: #1e293b ;
            color: #ffffff ;
            padding: 16px 20px;
            font-weight: 600;
            border: none;
            text-transform: none;
        }

        
        .table-custom tbody td {
            padding: 16px 20px;
            color: #334155;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        
        .table-custom tbody tr:hover {
            background-color: #f8fafc ;
        }

        
        .btn-action-green {
            background-color: #15803d ;
            color: #ffffff ;
            border: none;
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            margin-right: 4px;
            transition: background-color 0.2s;
        }

        .btn-action-green:hover {
            background-color: #166534 ;
        }

        
        .btn-action-red {
            background-color: #dc2626 ;
            color: #ffffff ;
            border: none;
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s;
        }

        .btn-action-red:hover {
            background-color: #b91c1c ;
        }

        .text-capitalize {
            text-transform: capitalize;
        }
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
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark" style="margin: 0;">Data Karyawan</h2>
            <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#tambah_karyawan" style="border-radius: 6px; font-weight: 500;">
                Tambah Karyawan
            </button>
        </div>
        
        <?php include "modal/add_karyawan.php"; ?>
        
        <div class="card-table-wrapper">
            <table class="table table-custom m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Agama</th>
                        <th>Jenis Kelamin</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        $sql = "SELECT * FROM karyawan ORDER BY Nama_Karyawan ASC";
                        $hasil = mysqli_query($koneksi, $sql);
                        while($data = mysqli_fetch_assoc($hasil)){
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-semibold text-capitalize"><?= $data['Nama_Karyawan'] ?></td>
                            <td><?= $data['Alamat'] ?></td>
                            <td class="text-capitalize"><?= $data['agama'] ?></td>
                            <td><?= $data['jenis_kelamin'] ?></td>
                            <td class="text-capitalize"><?= $data['jabatan'] ?></td>
                            <td>
                                <button type="button" class="btn-action-green" data-bs-toggle="modal" data-bs-target="#edit<?= $data['ID_Karyawan']?>">
                                    Edit
                                </button>
                                <button type="button" class="btn-action-red" data-bs-toggle="modal" data-bs-target="#hapus<?=$data['ID_Karyawan']?>">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    <?php   
                        include "modal/edit_karyawan.php";
                        include "modal/hapus_karyawan.php";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>