<?php
//memanggil koneksi database
 include "../../config/koneksi.php";

 //cek apakah tombol submit ditekan
 if(isset($_POST['delete'])){

// ambil data dari form
    $id_absensi = $_POST['id_absensi'];

//query update
  $query = "DELETE FROM absensi WHERE id_absensi = '$id_absensi'";
    

  $result = mysqli_query($koneksi, $query);

 if ($result) {
        echo "<script>
            alert('Data karyawan berhasil dihapus!');
                window.location.href ='../index_absensi.php';
                    </script>";
         } else {
        echo "<script>
            alert('Gagal menghapus data karyawan!');
                window.location.href ='../index_absensi.php';
                    </script>";
    }
 }
?>