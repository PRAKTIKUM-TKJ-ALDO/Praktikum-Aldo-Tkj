<?php
//memanggil koneksi database
 include "../../config/koneksi.php";

 //cek apakah tombol submit ditekan
 if(isset($_POST['simpan'])){

// deklarasi variable untuk menyimpan inputan dari form

 $Nama_Karyawan = mysqli_real_escape_string($koneksi, $_POST['Nama_Karyawan']);
 $username = mysqli_real_escape_string($koneksi, $_POST['username']);
 $password = mysqli_real_escape_string($koneksi, $_POST['password']);
 $alamat = mysqli_real_escape_string($koneksi, $_POST['Alamat']);
 $agama = mysqli_real_escape_string($koneksi, $_POST['agama']);
 $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
 $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);

 // Query insert karyawan
 $query = "INSERT INTO karyawan (Nama_Karyawan, Alamat,agama, jenis_kelamin,jabatan)
 VALUES ('$Nama_Karyawan', '$alamat', '$agama','$jenis_kelamin','$jabatan')";

 $result = mysqli_query($koneksi, $query);

 if ($result) {
    $id_karyawan = mysqli_insert_id($koneksi);
    $hashed_password = md5($password);
    $userQuery = "INSERT INTO user (ID_Karyawan, username, password, nama, level) VALUES ('$id_karyawan', '$username', '$hashed_password', '$Nama_Karyawan', 'user')";
    $userResult = mysqli_query($koneksi, $userQuery);
    if ($userResult) {
        echo "<script>
            alert('Data karyawan dan login berhasil ditambahkan!');
                window.location.href ='../index_karyawan.php';
                    </script>";
    } else {
        mysqli_query($koneksi, "DELETE FROM karyawan WHERE ID_Karyawan = '$id_karyawan'");
        echo "<script>
            alert('Gagal membuat akun login untuk karyawan. Username mungkin sudah dipakai.');
                window.location.href ='../index_karyawan.php';
                    </script>";
    }
 } else {
        echo "<script>
            alert('Gagal menambahkan data karyawan!');
                window.location.href ='../index_karyawan.php';
                    </script>";
    }
 }
 ?>