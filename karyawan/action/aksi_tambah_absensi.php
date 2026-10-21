<?php
//memanggil koneksi database

 include "../../config/koneksi.php";

 //cek apakah tombol submit ditekan
 if(isset($_POST['simpan'])){
    $kayawan  = mysqli_real_escape_string($koneksi, $_POST['ID_Karyawan']);
    $tgl     = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $status  = mysqli_real_escape_string($koneksi, $_POST['status_hadir']);
    
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