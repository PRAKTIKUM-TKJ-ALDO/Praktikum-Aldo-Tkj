<?php
//memanggil koneksi database
 include "../../config/koneksi.php";

 //cek apakah tombol submit ditekan
 if(isset($_POST['update'])){

// ambil data dari form
    $id = $_POST['id'];
    $Nama_Karyawan = $_POST['Nama_Karyawan'];
    $alamat = $_POST['Alamat'];
    $agama = $_POST['agama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $jabatan = $_POST['jabatan'];

//query update
  $query = "UPDATE karyawan SET Nama_Karyawan = '$Nama_Karyawan', 
  Alamat = '$alamat', 
  agama = '$agama', 
  jenis_kelamin = '$jenis_kelamin', 
  jabatan = '$jabatan' WHERE ID_Karyawan = '$id'";

  $result = mysqli_query($koneksi, $query);

 if ($result) {
        echo "<script>
            alert('Data siswa berhasil diubah!');
                window.location.href ='../index_karyawan.php';
                    </script>";
         } else {
        echo "<script>
            alert('Gagal mengubah data siswa!');
                window.location.href ='../index_karyawan.php';
                    </script>";
    }
 }
?>