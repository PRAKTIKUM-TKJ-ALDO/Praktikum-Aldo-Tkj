<div class="modal fade" id="tambah_gaji" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="action/aksi_tambah_gaji.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Form Input Gaji Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php if (session_status() == PHP_SESSION_NONE) session_start(); ?>
                    <?php
                        $gaji_pokok_value = '';
                        $current_jabatan = '';
                        $selected_karyawan = '';
                        if (isset($_SESSION['level']) && $_SESSION['level'] == 'user' && !empty($_SESSION['ID_Karyawan'])) {
                            $idk = mysqli_real_escape_string($koneksi, $_SESSION['ID_Karyawan']);
                            $dq = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE ID_Karyawan = '$idk' LIMIT 1");
                            $drow = $dq ? mysqli_fetch_assoc($dq) : null;
                            if ($drow) {
                                $selected_karyawan = $drow['ID_Karyawan'];
                                $current_jabatan = $drow['jabatan'];
                                switch ($drow['jabatan']) {
                                    case 'Staf': $gaji_pokok_value = '1000000'; break;
                                    case 'Karyawan': $gaji_pokok_value = '3000000'; break;
                                    case 'Manajer': $gaji_pokok_value = '5000000'; break;
                                    case 'Direktur': $gaji_pokok_value = '7000000'; break;
                                    case 'Supervisor': $gaji_pokok_value = '10000000'; break;
                                }
                            }
                        }
                    ?>
                    <div class="mb-3">
                        <label class="form-label">Pilih Karyawan</label>
                        <select name="ID_Karyawan" id="select_karyawan" class="form-control" style="pointer-events:auto;" required>
                            <option value="">Pilih Karyawan</option>
                            <?php
                            $karyawan = mysqli_query($koneksi, "SELECT * FROM karyawan");
                            while($k = mysqli_fetch_array($karyawan)){
                                $jab = htmlentities($k['jabatan']);
                                $selected = ($selected_karyawan && $selected_karyawan == $k['ID_Karyawan']) ? 'selected' : '';
                                echo "<option value='$k[ID_Karyawan]' data-jabatan='$jab' $selected>$k[Nama_Karyawan]</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" id="current_jabatan" value="<?= htmlentities($current_jabatan) ?>">
                        <input type="hidden" id="current_gaji_pokok" value="<?= htmlentities($gaji_pokok_value) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Gaji</label>
                        <input type="date" name="tanggal_input" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Gaji Pokok</label>
                    <select id="gaji_pokok_select" class="form-control" aria-describedby="gajiPokokInfo">
                        <option value="" disabled selected>Pilih karyawan dulu</option>
                        <option value="1000000">Rp 1.000.000 (Staf)</option>
                        <option value="3000000">Rp 3.000.000 (Karyawan)</option>
                        <option value="5000000">Rp 5.000.000 (Manajer)</option>
                        <option value="7000000">Rp 7.000.000 (Direktur)</option>
                        <option value="10000000">Rp 10.000.000 (Supervisor)</option>
                    </select>
                    <input type="hidden" id="gaji_pokok" name="gaji_pokok" value="<?= isset($gaji_pokok_value) ? $gaji_pokok_value : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tunjangan</label>
                    <select name="tunjangan" class="form-control" required>
                        <option value="0">Rp 0 </option>
                        <option value="200000">Rp 200.000</option>
                        <option value="500000">Rp 500.000</option>
                        <option value="1000000">Rp 1.000.000</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lembur</label>
                    <select name="lembur" class="form-control" required>
                        <option value="0">Rp 0</option>
                        <option value="50000">Rp 50.000</option>
                        <option value="100000">Rp 100.000</option>
                        <option value="150000">Rp 150.000</option>
                    </select>
                </div>
                    <div class="mb-3">
                        <label class="form-label">Status Pengajuan</label>
                        <select name="status_pengajuan" class="form-control">
                            <option value="Belum Diajukan">Belum Diajukan</option>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="simpan_gaji">Simpan Data Gaji</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
// Mapping jabatan -> default gaji_pokok
const jabatanToGaji = {
    'Staf': '1000000',
    'Karyawan': '3000000',
    'Manajer': '5000000',
    'Direktur': '7000000',
    'Supervisor': '10000000'
};

function setGajiByJabatan(jab) {
    const sel = document.getElementById('gaji_pokok_select');
    const hidden = document.getElementById('gaji_pokok');
    const info = document.getElementById('gajiPokokInfo');
    if(!hidden) return;
    const val = jabatanToGaji[jab] || '';
    hidden.value = val;
    if(!sel) return;
    if(val) {
        sel.disabled = false;
        sel.value = val;
        sel.disabled = true;
        if(info) info.textContent = 'Gaji pokok otomatis menyesuaikan untuk jabatan ' + jab + '.';
    } else {
        sel.disabled = false;
        sel.value = '';
        if(info) info.textContent = 'Gaji pokok akan otomatis menyesuaikan setelah memilih karyawan.';
    }
}

document.addEventListener('DOMContentLoaded', function(){
    const select = document.getElementById('select_karyawan');
    const selGaji = document.getElementById('gaji_pokok_select');
    if(selGaji) {
        selGaji.disabled = true;
    }
    if(select) {
        select.addEventListener('focus', function(){
            if(selGaji) selGaji.disabled = false;
        });
        select.addEventListener('change', function(){
            const opt = select.options[select.selectedIndex];
            const jab = opt ? opt.getAttribute('data-jabatan') : '';
            setGajiByJabatan(jab);
        });
    }

    // jika user biasa, ambil jabatan dari hidden input
    const currentJ = document.getElementById('current_jabatan');
    if(currentJ) {
        setGajiByJabatan(currentJ.value);
    }
});
</script>