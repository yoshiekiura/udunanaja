<div class="main-container pb-100 h100 bg-white mx-auto">
    <!-- ==== 1. Top Bar ==== -->
    <nav class="navbar bg-white navbar-light">
    </nav>
    <!-- ==== 2. Content ===== -->
    <div class="container-fluid bg-white pb-5 my-0">
        <h4 class="main-color mt-4 font-bold">Detail Pembayaran</h4>
        <p class="mt-4 f-14 pr-120 black">*Silahkan lakukan Pembayaran sesuai dengan dengan data dibawah ini</p>
        <div class="mt-2 text-center box-frame">
            <div>
                <p class="f-14 text-color-4">Metode Pembayaran</p>
                <img src="<?= base_url(); ?>assets/image/icon/cod.png" class="mt-2 logo-payment" height="40" />
            </div>
            <div class="mt-3">
                <p class="f-14 text-color-4">Kode Referensi</p>
                <p class="mt-1 f-16 black font-bold"><?= $payment['reffid']; ?>         <button onclick="" class="btn btn-info"><i class="fa fa-copy"></i></button></p>
            </div>
            <div class="mt-3">
                <p class="f-14 text-color-4">Nominal</p>
                <p class="mt-1 f-16 black font-bold">Rp <?= number_format($payment['amount']); ?></p>
            </div>
            <div class="mt-3">
                <p class="f-14 text-color-4">Biaya Admin</p>
                <p class="mt-1 f-16 black font-bold">Rp <?= number_format($payment['fee']); ?></p>
            </div>
            <div class="mt-3">
                <p class="f-14 text-color-4">SubTotal</p>
                <p class="mt-1 f-16 black font-bold">Rp <?= number_format($payment['transfer']); ?></p>
            </div>
            <p class="f-14 px-5 mt-4 text-danger">
                <?php
                $textToWa = "Hallo kak *".$author['name']."* Saya mau Bayar Udunan *".$campaign['judul']."* Berikut Kode Referensinya :\n".$payment['reffid'];
                ?>
                Silahkan Berikan Kode Referensi Untuk melakukan pembayaran kepada <a href="https://api.whatsapp.com/send/?phone=<?= $author['phone']; ?>&text=<?= urlencode($textToWa); ?>" target="_blank"><strong>BANDAR UDUNAN</strong></a> ini
            </p>
        </div>
        <p class="f-14 black mt-4 px-5 text-center">Kesulitan dalam melakukan Pembayaran ? Silahkan Bandar Udunan</p>
        <div class="text-center mt-2">
            <a class="btn whatsapp-btn" href="https://wa.me/<?= $author['phone']; ?>" target="_blank"><img src="<?= base_url(); ?>assets/image/icon/ic-whatsapp-2.svg"> <span class="ml-2">WhatsApp</span></a>
        </div>
    </div>
</div>
<script type='text/javascript'>
    setInterval(ajaxCall, 3000); //300000 MS == 5 minutes
    function ajaxCall() {
        //do your AJAX stuff here
        $.ajax({
            url: '<?= base_url('pay/status/' . $payment['reffid']); ?>',
            datatype: 'json',
            success: function(data) {
                var json = JSON.parse(data);
                if (json.status == true) {
                    location.reload();
                }
            },
            cache: false
        });
    }
</script>