<?php
session_start();

// Memanggil database
include "../config/koneksi.php";

// Mengecek apakah form login sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Mengambil data dari form
    $username = $_POST["username"];
    $password = md5($_POST["password"]); //memakai md5

    // Query untuk mengecek username dan password
    $sql = "SELECT * FROM user WHERE username = ? AND password = ?";

    // Menyiapkan query dengan prepared statement
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);

    // Eksekusi query
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    
    // Cek apakah data user ditemukan
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $level = $row['level'];

        //menyimpan data user login ke session
        $_SESSION['username'] = $row['username'];
        $_SESSION['level'] = $row['level'];
        $_SESSION['nama'] = $row['nama'];

        // Jika user memiliki data karyawan, simpan ID_Karyawan juga ke session
        if (!empty($row['ID_Karyawan'])) {
            $_SESSION['ID_Karyawan'] = $row['ID_Karyawan'];
        } else {
            $_SESSION['ID_Karyawan'] = null;
        }

        //cek level admin atau user
        if ($level == 'admin') {
            header("Location: ../index.php"); 
        }elseif($level == 'user'){
            header("Location: ../karyawan/index.php"); 
        }else {
            echo "tidak ada hak akses";
        }

        }else {
        echo "<script>
            alert('Username atau Password Salah!');
            window.location.href = 'index.php'; 
        </script>";
    }
}
?>