<?php
include "../../config/koneksi.php";

if(isset($_POST['update_status'])){
    $id_gaji = $_POST['id_gaji'];
    $status  = $_POST['status_pengajuan'];

    $query = "UPDATE gaji SET status_pengajuan = '$status' WHERE id_gaji = '$id_gaji'";
    $update = mysqli_query($koneksi, $query);

    if($update){
        echo "<script>
                alert('Status Gaji Berhasil Diperbarui!');
                window.location.href='../gaji.php';
              </script>";
    } else {
        echo "<script>
                alert('Status Gaji gagal Diperbarui!');
                window.location.href='../gaji.php';
              </script>";
    }
}
?>