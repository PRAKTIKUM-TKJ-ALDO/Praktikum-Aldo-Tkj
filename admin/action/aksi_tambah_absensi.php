<?php
//memanggil koneksi database

 include "../../config/koneksi.php";

 //cek apakah tombol submit ditekan
 if(isset($_POST['simpan'])){
    if(session_status() == PHP_SESSION_NONE) session_start();
    // jika user biasa, ambil ID dari session
    if(isset($_SESSION['level']) && $_SESSION['level'] == 'user' && !empty($_SESSION['ID_Karyawan'])){
        $kayawan = $_SESSION['ID_Karyawan'];
    } else {
        $kayawan  = $_POST['ID_Karyawan'];
    }
    $tgl     = $_POST['tanggal'];
    $status  = $_POST['status_hadir'];
    $today = date('Y-m-d');
    if ($tgl !== $today) {
        echo "<script>
            alert('Absensi hanya dapat diproses untuk tanggal hari ini.');
            window.location.href ='../index_absensi.php';
            </script>";
        exit;
    }

    $cek_duplikat = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM absensi WHERE ID_Karyawan = '$kayawan' AND tanggal = '$tgl'");
    $data_duplikat = mysqli_fetch_assoc($cek_duplikat);
    if (!empty($data_duplikat['total'])) {
        echo "<script>
            alert('Absensi untuk tanggal ini sudah dicatat.');
            window.location.href ='../index_absensi.php';
            </script>";
        exit;
    }
    
    $query = "INSERT INTO absensi (ID_Karyawan, tanggal, status_hadir) VALUES ('$kayawan', '$tgl', '$status')";
    $result = mysqli_query($koneksi, $query);

 if ($result) {
        echo "<script>
            alert('Data absensi berhasil ditambahkan!');
                window.location.href ='../index_absensi.php';
                    </script>";
         } else {
        echo "<script>
            alert('Gagal menambahkan data absensi!');
                window.location.href ='../index_absensi.php';
                    </script>";
    }
}
?>