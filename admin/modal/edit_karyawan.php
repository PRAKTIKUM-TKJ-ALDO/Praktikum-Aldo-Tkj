<div class="modal fade" id="edit<?= $data['ID_Karyawan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <form action="action/aksi_edit_karyawan.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Edit Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" value="<?= $data['ID_Karyawan']?>">
                        <div class="mb3">
                            <label for="Nama_Karyawan" class="form-label">Nama_Karyawan</label>
                            <input type="text" name="Nama_Karyawan" id="Nama_Karyawan"
                            class="form-control" value="<?= $data['Nama_Karyawan']?>" >
                        </div>
                        <div class="mb3">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <input type="text" name="Alamat" id="Alamat"
                            class="form-control" value="<?= $data['Alamat']?>">

                        </div>
                        <div class="mb3">
                            <label for="agama" class="form-label">agama</label>
                            <select name="agama" id="agama" class="form-control" >
                                <option value="Islam" <?= $data['agama'] == 'Islam' ? 'selected' : ''?>>Islam</option>
                                <option value="Kristen" <?= $data['agama'] == 'Kristen' ? 'selected' : ''?>>Kristen</option>
                                <option value="Hindu" <?= $data['agama'] == 'Hindu' ? 'selected' : ''?>>Hindu</option>
                                </select>
                                

                        </div>
                        <div class="mb3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                <option value="Pria" <?= $data['jenis_kelamin'] == 'Pria' ? 'selected' : ''?>>Pria</option>
                                <option value="Wanita" <?= $data['jenis_kelamin'] == 'Wanita' ? 'selected' : ''?>>Wanita</option>
                                </select>
                                

                        </div>
                        <div class="mb3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <select name="jabatan" id="jabatan" class="form-control" >
                                <option value="Staf" <?= $data['jabatan'] == 'Staf' ? 'Selected' : ''?>>Staf</option>
                                <option value="Supervisor" <?= $data['jabatan'] == 'Supervisor' ? 'selected' : ''?>>Supervisor</option>
                                <option value="Manajer" <?= $data['jabatan'] == 'Manajer' ? 'selected' : ''?>>Manajer</option>
                                <option value="Direktur" <?= $data['jabatan'] == 'Direktur' ? 'selected' : ''?>>Direktur</option>
                                </select>
                                

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="update">update</button>
                    </div>
                </Form>
                </div>
            </div>
        </div>

        