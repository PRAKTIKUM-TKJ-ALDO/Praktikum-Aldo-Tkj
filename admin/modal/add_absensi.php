<div class="modal fade" id="tambah_absensi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="action/aksi_tambah_absensi.php" method="POST"> 
                <div class="modal-header">
                    <h5 class="modal-title">Form Tambah Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php if (session_status() == PHP_SESSION_NONE) session_start(); ?>
                    <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 'user' && !empty($_SESSION['ID_Karyawan'])): ?>
                    <div class="mb-3">
                        <label class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" value="<?= htmlentities(
                            $_SESSION['nama']
                        ) ?>" disabled>
                        <input type="hidden" name="ID_Karyawan" value="<?= $_SESSION['ID_Karyawan'] ?>">
                    </div>
                    <?php else: ?>
                    <div class="mb-3">
                        <label class="form-label">Nama Karyawan</label>
                        <select name="ID_Karyawan" class="form-control" required>
                            <option value="">Pilih Karyawan</option>
                            <?php
                            $a = mysqli_query($koneksi, "SELECT * FROM karyawan");
                            while($b = mysqli_fetch_array($a)){
                                echo "<option value='$b[ID_Karyawan]'>$b[Nama_Karyawan]</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Kehadiran</label>
                        <select name="status_hadir" class="form-control" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Cuti">Cuti</option>
                            <option value="Alpa">Alpa</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>