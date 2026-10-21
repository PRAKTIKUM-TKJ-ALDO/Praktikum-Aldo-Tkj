<div class="modal fade" id="hapus<?= $data['ID_Karyawan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <form action="action/aksi_hapus_karyawan.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="ID_Karyawan" value="<?=$data['ID_Karyawan']?>">
                        <h5>Apakah anda yakin ingin menghapus data ?</h5>
                        <p>Nama Karyawan :<b><?=$data['Nama_Karyawan']?></b></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" name="delete">Iya</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        