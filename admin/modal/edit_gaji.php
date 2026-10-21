<div class="modal fade" id="edit_gaji<?= $data['id_gaji'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="action/aksi_edit_gaji.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Update Status Gaji: <?= $data['Nama_Karyawan'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_gaji" value="<?= $data['id_gaji'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran/Pengajuan</label>
                        <select name="status_pengajuan" class="form-control">
                            <option value="Belum Diajukan" <?= $data['status_pengajuan'] == 'Belum Diajukan' ? 'selected' : '' ?>>Belum Diajukan</option>
                            <option value="Proses" <?= $data['status_pengajuan'] == 'Proses' ? 'selected' : '' ?>>Proses</option>
                            <option value="Selesai" <?= $data['status_pengajuan'] == 'Selesai' ? 'selected' : '' ?>>Selesai (Sudah Dibayar)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-modal="modal">Batal</button>
                    <button type="submit" class="btn btn-success" name="update_status">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>