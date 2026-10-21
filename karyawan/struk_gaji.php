<?php
include "../config/koneksi.php";
session_start();

// Ambil id dari URL
$id_gaji = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';

// Ambil data gaji + karyawan
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT gaji.*, k.Nama_Karyawan, k.jabatan 
    FROM gaji gaji
    JOIN karyawan k ON gaji.ID_Karyawan = k.ID_Karyawan
    WHERE gaji.id_gaji='$id_gaji'
"));

$id_kar = $data['ID_Karyawan'];
$bulan = date('m');

// HITUNG POTONGAN ALPA 
$a_absen = mysqli_query($koneksi, "
    SELECT COUNT(*) as total_alpa 
    FROM absensi 
    WHERE ID_Karyawan='$id_kar' 
    AND status_hadir='Alpa' 
    AND MONTH(tanggal)='$bulan'
");
$b_absen = mysqli_fetch_assoc($a_absen);
$potongan_alpa = $b_absen['total_alpa'] * 50000;

// HITUNG POTONGAN SAKIT, IZIN, CUTI 
$a_absen2 = mysqli_query($koneksi, "
    SELECT COUNT(*) as total_izin 
    FROM absensi 
    WHERE ID_Karyawan='$id_kar' 
    AND status_hadir IN ('Sakit', 'Izin', 'Cuti') 
    AND MONTH(tanggal)='$bulan'
");
$b_absen2 = mysqli_fetch_assoc($a_absen2);
$potongan_izin = $b_absen2['total_izin'] * 10000;

// Akumulasi total seluruh potongan variabel agar tidak saling menimpa
$total_potongan = $potongan_alpa + $potongan_izin;

// Hitung akumulasi hasil akhir Take Home Pay
$gaji_bersih = ($data['gaji_pokok'] + $data['tunjangan'] + $data['lembur']) - $total_potongan;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - <?= $data['Nama_Karyawan'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- CORE STYLES --- */
        :root {
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
            --color-green: #16a34a; 
            --color-red: #dc2626;  
            --bg-total: #1e293b;   
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: var(--text-dark);
            margin: 0;
            padding: 40px 20px;
        }

        /* --- CONTAINER SLIP --- */
        .slip-container {
            max-width: 700px;
            margin: 0 auto;
            background: #ffffff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        /* --- HEADER (Disesuaikan Mockup Resmi) --- */
        .slip-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .slip-header h2 {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0 0 4px 0;
            text-transform: uppercase;
        }

        .slip-header p {
            color: var(--text-muted);
            font-size: 14px;
            margin: 0;
        }

        .slip-divider {
            border: none;
            border-top: 1px solid var(--border-light);
            margin: 16px 0 24px 0;
        }

        /* --- METADATA KARYAWAN (GRID) --- */
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 40px;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .meta-item {
            display: flex;
        }

        .meta-label {
            width: 110px;
            color: var(--text-dark);
        }

        .meta-colon {
            width: 20px;
            color: var(--text-dark);
        }

        .meta-value {
            font-weight: 500;
        }

        /* --- JUDUL SEKSI --- */
        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 12px 0;
        }

        /* --- TABEL RINCIAN --- */
        .table-rincian {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .table-rincian th {
            background-color: #f8fafc;
            border: 1px solid var(--border-light);
            padding: 12px 16px;
            font-weight: 700;
            text-align: left;
        }

        .table-rincian th:last-child,
        .table-rincian td:last-child {
            text-align: right;
        }

        .table-rincian td {
            border: 1px solid var(--border-light);
            padding: 14px 16px;
            color: #334155;
        }

        .text-tunjangan {
            color: var(--color-green);
            font-weight: 500;
        }

        .text-potongan {
            color: var(--color-red);
            font-weight: 500;
        }

        .row-total td {
            background-color: var(--bg-total) ;
            color: #ffffff ;
            font-weight: 700;
            font-size: 15px;
            padding: 16px;
            border: 1px solid var(--bg-total);
        }
       
        .action-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 24px;
        }

        .btn-slip {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: background 0.2s;
        }

        .btn-kembali {
            background-color: #64748b;
            color: white;
        }

        .btn-kembali:hover {
            background-color: #475569;
        }

        .btn-cetak {
            background-color: #2563eb;
            color: white;
        }

        .btn-cetak:hover {
            background-color: #1d4ed8;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .slip-container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .action-footer {
                display: none; 
            }
        }
    </style>
</head>

<body>

    <div class="slip-container">
        <div class="slip-header">
            <h2>GajianGak</h2>
            <p>Slip Gaji Karyawan</p>
        </div>

        <hr class="slip-divider">

        <div class="meta-grid">
            <div>
                <div class="meta-item" style="margin-bottom: 8px;">
                    <div class="meta-label">NIK</div>
                    <div class="meta-colon">:</div>
                    <div class="meta-value"><?= !empty($data['ID_Karyawan']) ? $data['ID_Karyawan'] : '-' ?></div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Nama</div>
                    <div class="meta-colon">:</div>
                    <div class="meta-value" style="text-transform: capitalize;"><?= $data['Nama_Karyawan'] ?></div>
                </div>
            </div>
            <div>
                <div class="meta-item" style="margin-bottom: 8px;">
                    <div class="meta-label">Jabatan</div>
                    <div class="meta-colon">:</div>
                    <div class="meta-value" style="text-transform: capitalize;"><?= $data['jabatan'] ?? 'Karyawan' ?></div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Tanggal</div>
                    <div class="meta-colon">:</div>
                    <div class="meta-value"><?= date('d F Y') ?></div>
                </div>
            </div>
        </div>

        <h3 class="section-title">Rincian Pendapatan & Potongan</h3>

        <table class="table-rincian">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Gaji Pokok</td>
                    <td>Rp <?= number_format($data['gaji_pokok'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>Tunjangan Jabatan</td>
                    <td class="text-tunjangan">+ Rp <?= number_format($data['tunjangan'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>Uang Lembur</td>
                    <td class="text-tunjangan">+ Rp <?= number_format($data['lembur'], 0, ',', '.') ?></td>
                </tr>
                
                <?php if($potongan_alpa > 0): ?>
                <tr>
                    <td>Potongan Absensi </td>
                    <td class="text-potongan">- Rp <?= number_format($potongan_alpa, 0, ',', '.') ?></td>
                </tr>
                <?php endif; ?>

                <?php if($potongan_izin > 0): ?>
                <tr>
                    <td>Potongan Absensi</td>
                    <td class="text-potongan">- Rp <?= number_format($potongan_izin, 0, ',', '.') ?></td>
                </tr>
                <?php endif; ?>

                <?php if($total_potongan == 0): ?>
                <tr>
                    <td>Potongan Absensi</td>
                    <td class="text-secondary">Rp 0</td>
                </tr>
                <?php endif; ?>

                <tr class="row-total">
                    <td>TOTAL GAJI BERSIH</td>
                    <td>Rp <?= number_format($gaji_clean = max(0, $gaji_bersih), 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>

        <div class="action-footer">
            <a href="javascript:void(0);" onclick="keHalamanSebelumnya()" class="btn-slip btn-kembali">Kembali</a>
            <button onclick="window.print()" class="btn-slip btn-cetak">Cetak Slip Gaji</button>
        </div>
    </div>

    <script>
    function keHalamanSebelumnya() {
        if (document.referrer) {
            window.location.href = document.referrer;
        } else {
            window.location.href = "gaji.php";
        }
    }
    </script>

</body>
</html>