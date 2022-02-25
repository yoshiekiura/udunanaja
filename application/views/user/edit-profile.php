<form method="POST">
        <?php echo  form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());  ?>
        <?= form_hidden('id', $user['id']);?>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Nama</label>
        <input type="text" class="form-control bg-light-color br-10" name="name" value="<?= $user['name'];?>" required>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">E-Mail</label>
        <input type="email" class="form-control bg-light-color br-10" name="email" value="<?= $user['email'];?>" required>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Telepon</label>
        <input type="text" class="form-control bg-light-color br-10" name="phone" value="<?= $user['phone'];?>" required>
    </div>
    <div class="text-center mt-2">
        <button type="submit" name="save_profile" value="1" class="button primary-button login-btn font-bold w-50">UPDATE</button>
    </div>
    <div class="text-center mt-2">
        <button data-dismiss="modal" class="btn btn-danger font-bold w-50">BACK</button>
    </div>
</form>