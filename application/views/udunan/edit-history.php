<form method="POST">
        <?php echo  form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());  ?>
        <?= form_hidden('reffid', $history['id']);?>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Judul</label>
        <input type="text" class="form-control bg-light-color br-10" id="name" value="<?= $history['judul'];?>" readonly>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Max User Udunan</label>
        <input type="number" class="form-control bg-light-color br-10" name="max_user" value="<?= $history['max_user'];?>">
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Nominal Udunan</label>
        <div class="input-group">
            <span class="input-group-append">
                <div class="btn border-0 mr-n5 cursor-default">
                    <p>IDR</p>
                </div>
            </span>
            <input class="form-control bg-light-color-2 py-2 br-10 pl-5 disable-control" name="nominal" value="<?= $history['nominal'];?>">
        </div>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="type">Status</label>
        <select class="form-control bg-light-color br-10" id="status" name="status">
            <option value='<?= $history['status'];?>'selected>-- <?= strtoupper($history['status']);?> --</option>
            <?php
            if($history['status'] == "active"){
                echo "<option value='expired'>-- EXPIRED --</option>";
            }else if($history['status'] == "expired"){
                echo "<option value='active'>-- ACTIVE --</option>";
            }
            ?>
        </select>
    </div>
    <div class="text-center mt-2">
        <button type="submit" name="save_history" value="1" class="button primary-button login-btn font-bold w-50">SAVE</button>
    </div>
    <div class="text-center mt-2">
        <button data-dismiss="modal" class="btn btn-danger font-bold w-50">BACK</button>
    </div>
</form>