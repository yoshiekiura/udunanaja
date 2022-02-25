<!-- ===== 3. Content ===== -->
<div class="container-fluid my-0">
    <h4 class="mt-4 f-18 font-bold">Mau Udunan Apa ?</h4>
    <form method="POST" class="mt-4">
        <?= $this->session->flashdata('message'); ?>
        <?php echo  form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());  ?>
        <div class="form-group">
            <label class="font-semiBold" for="nama_udunan">Nama Udunan</label>
            <input type="text" class="form-control bg-light-color br-10 <?php echo (form_error('email')) ? 'is-invalid' : ''; ?>" id="nama_udunan" name="nama_udunan" placeholder="Nama Udunan" value="<?= set_value('nama_udunan'); ?>">
            <?= form_error('nama_udunan', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label class="font-semiBold" for="keterangan">Keterangan</label>
            <textarea class="form-control bg-light-color br-10 no-resize <?php echo (form_error('email')) ? 'is-invalid' : ''; ?>" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan"><?= set_value('keterangan'); ?></textarea>
            <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label class="font-semiBold" for="nominal">Nominal</label>
            <input type='number' class="form-control bg-light-color br-10 <?php echo (form_error('email')) ? 'is-invalid' : ''; ?>" id="nominal" name="nominal" placeholder="Nominal" value="<?= set_value('nominal'); ?>">
            <?= form_error('nominal', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label class="font-semiBold" for="jumlah">Jumlah Peserta Maximal</label>
            <input type="number" class="form-control bg-light-color br-10 disable-control <?php echo (form_error('email')) ? 'is-invalid' : ''; ?>" id="jumlah" name="jumlah" placeholder="Jumlah" min="1" value="<?= set_value('jumlah'); ?>">
            <?= form_error('jumlah', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <div class="text-center mt-2">
            <button type="submit" class="button primary-button login-btn font-bold w-50">Submit</button>
        </div>
    </form>
</div>