<?php
include "../../config/koneksi.php";

if(isset($_POST['simpan_gaji'])){
  if(session_status() == PHP_SESSION_NONE) session_start();
  if(isset($_SESSION['level']) && $_SESSION['level'] == 'user' && !empty($_SESSION['ID_Karyawan'])){
    $id_kar = $_SESSION['ID_Karyawan'];
  } else {
    $id_kar    = $_POST['ID_Karyawan'];
  }
  $gapok     = $_POST['gaji_pokok'];
    $tunjangan = $_POST['tunjangan'];
    $lembur    = $_POST['lembur'];
    $status    = $_POST['status_pengajuan'];
    $tgl_input = !empty($_POST['tanggal_input']) ? $_POST['tanggal_input'] : date('Y-m-d');

    // Query insert ke tabel gaji
    $query = "INSERT INTO gaji (ID_Karyawan, gaji_pokok, tunjangan, lembur, status_pengajuan, tanggal_input) 
              VALUES ('$id_kar', '$gapok', '$tunjangan', '$lembur', '$status', '$tgl_input')";
    
    $insert = mysqli_query($koneksi, $query);

    if($insert){
        echo "<script>
                alert('Berhasil menginput data gaji!');
                window.location.href='../gaji.php';
              </script>";
    } else {
        echo "<script>
                alert('gagal menginput data gaji!');
                window.location.href='../gaji.php';
              </script>";
    }
}
?>