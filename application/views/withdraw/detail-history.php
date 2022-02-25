<form method="POST">
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Keterangan</label>
        <textarea class="form-control bg-light-color br-10 no-resize " readonly><?= $history['keterangan'];?></textarea>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Tujuan Pembayaran</label>
        <input type="text" class="form-control bg-light-color br-10"  value="<?= $history['tujuan'];?>" readonly>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Metode Pembayaran</label>
        <input type="text" class="form-control bg-light-color br-10"  value="<?= $this->db->get_where('withdraw_method',['code'=>$history['metode']])->row_array()['name'];?>" readonly>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Status Pembayaran</label>
        <input type="text" class="form-control bg-light-color br-10"  value="<?= strtoupper($history['status']);?>" readonly>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">SubTotal Pembayaran</label>
        <div class="input-group">
            <span class="input-group-append">
                <div class="btn border-0 mr-n5 cursor-default">
                    <p>IDR</p>
                </div>
            </span>
            <input class="form-control bg-light-color-2 py-2 br-10 pl-5 disable-control" placeholder="<?= number_format($history['quantity']);?>"  readonly>
        </div>
    </div>
    <div class="text-center mt-2">
        <button data-dismiss="modal" class="button info-button login-btn font-bold w-50">BACK</button>
    </div>
</form>