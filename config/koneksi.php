<?php
    //deklarasi variable
    $hostname = "localhost";//nama host
    $username = "root";//defaultnya adalah root
    $password = "";//secara default password kosong
    $db_name = "penggajian_karyawan"; // sesuaikan dengan nama DB yang dibuat

    //menghubungkan ke database
    $koneksi = mysqli_connect($hostname, $username, $password, $db_name);
    //cek apakah koneksi berhasil atau tidak 
    if(!$koneksi){
        die("Database gagal terhubung". mysqli_connect_error());
    }
?>