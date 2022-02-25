<form action="share-udunan.html" method="get">
    
    
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Judul</label>
        <textarea class="form-control bg-light-color br-10 no-resize " readonly><?= $history['judul'];?></textarea>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Keterangan</label>
        <textarea class="form-control bg-light-color br-10 no-resize " readonly><?= $history['keterangan'];?></textarea>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Dana Terkumpul</label>
        <input type="text" class="form-control bg-light-color br-10"  value="<?= $history['terkumpul'];?>" readonly>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Join / Max User</label>
        <input type="text" class="form-control bg-light-color br-10"  value="<?= $join_user;?> / <?= $history['max_user'];?>" readonly>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Total Udunan</label>
        <div class="input-group">
            <span class="input-group-append">
                <div class="btn border-0 mr-n5 cursor-default">
                    <p>IDR</p>
                </div>
            </span>
            <input class="form-control bg-light-color-2 py-2 br-10 pl-5 disable-control" placeholder="<?= number_format($history['nominal']);?>"  readonly>
        </div>
    </div>
    <div class="text-center mt-2">
        <button data-dismiss="modal" class="button info-button login-btn font-bold w-50">BACK</button>
    </div>
</form>
<script>
function copyok(text){
            const copyText = document.getElementById(text)
            
                copyText.select();    // Selects the text inside the input
                document.execCommand('copy'); 
}
        </script>