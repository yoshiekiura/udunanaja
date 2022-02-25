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
    <div class="form-group">
        <label class="font-semiBold" for="type">Status</label>
        <select class="form-control bg-light-color br-10" id="status" name="status">
            <option value='<?= $history['status'];?>'selected>-- <?= strtoupper($history['status']);?> --</option>
            <?php
            if($history['status'] == "unpaid"){
                echo "<option value='paid'>-- PAID --</option>";
                echo "<option value='cancel'>-- CANCEL --</option>";
            }else if($history['status'] == "paid"){
                echo "<option value='unpaid'>-- UNPAID --</option>";
                echo "<option value='cancel'>-- CANCEL --</option>";
            }else if($history['status'] == "cancel"){
                echo "<option value='paid'>-- PAID --</option>";
                echo "<option value='unpaid'>-- UNPAID --</option>";
            }
            ?>
        </select>
    </div>
    <div class="text-center mt-2">
        <button type="submit" name="save_history_user" value="1" class="button primary-button login-btn font-bold w-50">SAVE</button>
    </div>
    <div class="text-center mt-2">
        <button data-dismiss="modal" class="btn btn-danger font-bold w-50">BACK</button>
    </div>
</form>