<div class="modal fade" id="tambah_karyawan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <form action="action/aksi_tambah_karyawan.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Tambah Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb3">
                            <label for="Nama_Karyawan" class="form-label">Nama Karyawan</label>
                            <input type="text" name="Nama_Karyawan" id="Nama_Karyawan"
                            class="form-control" required>
                        </div>
                        <div class="mb3">
                            <label for="username" class="form-label">Username Login</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb3">
                            <label for="password" class="form-label">Password Login</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb3">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <input type="text" name="Alamat" id="Alamat"
                            class="form-control" required>

                        </div>
                        <div class="mb3">
                            <label for="agama" class="form-label">Agama</label>
                            <select name="agama" id="agama" class="form-control">
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Hindu">Hindu</option>
                            </select>
                        </div>
                        <div class="mb3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                            </select>
                        </div>
                    <div class="mb3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <select name="jabatan" id="jabatan" class="form-control">
                    <option value="Staf">Staf</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Manajer">Manajer</option>
                    <option value="Direktur">Direktur</option>
                    </select>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </Form>
        </div>
     </div>
</div> 