<form method="POST">
        <?php echo  form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());  ?>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Transaksi ID</label>
        <input type="text" class="form-control bg-light-color br-10" id="reffid" name="reffid" value="<?= $history['reffid'];?>" readonly>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Nama</label>
        <input type="text" class="form-control bg-light-color br-10" id="name" value="<?= $history['name'];?>" readonly>
    </div>
    <div class="text-center mt-2">
        <button type="submit" name="delete_history_user" value="1" class="button primary-button login-btn font-bold w-50">DELETE</button>
    </div>
    <div class="text-center mt-2">
        <button data-dismiss="modal" class="btn btn-danger font-bold w-50">BACK</button>
    </div>
</form>