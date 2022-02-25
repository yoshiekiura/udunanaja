<form action="share-udunan.html" method="get">
    
    <div class="form-group">
        <label class="font-semiBold" for="norek">Transaksi Id</label>
        <div class="d-flex">
            <input type="text"  class="form-control bg-light-color br-10" id="reffid" value="<?= $history['reffid'];?>"  readonly>
            <a onClick="copyok('reffid')" class="btn green-btn-1 text-white ml-2 br-10"> <i class="fa fa-copy text-red"></i></a>
        </div>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="norek">Nama</label>
        <div class="d-flex">
            <input type="text"  class="form-control bg-light-color br-10" id="name" value="<?= $history['name'];?>"  readonly>
            <a onClick="copyok('name')" class="btn green-btn-1 text-white ml-2 br-10"> <i class="fa fa-copy text-red"></i></a>
        </div>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="norek">Nomer Hp</label>
        <div class="d-flex">
            <input type="text"  class="form-control bg-light-color br-10" id="phone" value="<?= $history['phone'];?>"  readonly>
            <a onClick="copyok('phone')" class="btn green-btn-1 text-white ml-2 br-10"> <i class="fa fa-copy text-red"></i></a>
        </div>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="norek">Email</label>
        <div class="d-flex">
            <input type="text"  class="form-control bg-light-color br-10" id="email" value="<?= $history['email'];?>"  readonly>
            <a onClick="copyok('email')" class="btn green-btn-1 text-white ml-2 br-10"> <i class="fa fa-copy text-red"></i></a>
        </div>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Metode Pembayaran</label>
        <input type="text" class="form-control bg-light-color br-10"  value="<?= $history['method'];?>" readonly>
    </div><div class="form-group">
        <label class="font-semiBold" for="keterangan">Status Transaksi</label>
        <input type="text" class="form-control bg-light-color br-10"  value="<?= strtoupper($history['status']);?>" readonly>
    </div>
    <div class="form-group">
        <label class="font-semiBold" for="keterangan">Subtotal Pembayaran</label>
        <div class="input-group">
            <span class="input-group-append">
                <div class="btn border-0 mr-n5 cursor-default">
                    <p>IDR</p>
                </div>
            </span>
            <input class="form-control bg-light-color-2 py-2 br-10 pl-5 disable-control" placeholder="<?= number_format($history['transfer']);?>"  readonly>
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