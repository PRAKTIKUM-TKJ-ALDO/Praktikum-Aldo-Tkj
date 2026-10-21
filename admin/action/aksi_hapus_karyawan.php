<?php
//memanggil koneksi database
 include "../../config/koneksi.php";

 //cek apakah tombol submit ditekan
 if(isset($_POST['delete'])){

// ambil data dari form
    $ID_Karyawan = $_POST['ID_Karyawan'];

//query delete
  $query = "DELETE FROM karyawan WHERE ID_Karyawan = '$ID_Karyawan'";
    

  $result = mysqli_query($koneksi, $query);

 if ($result) {
        echo "<script>
            alert('Data karyawan berhasil dihapus!');
                window.location.href ='../index_karyawan.php';
                    </script>";
         } else {
        echo "<script>
            alert('Gagal menghapus data karyawan!');
                window.location.href ='../index_karyawan.php';
                    </script>";
    }
 }
?>