<div class="main-container pb-100 h100 bg-white mx-auto">
    <!-- ==== 2. Content ===== -->
    <div class="container-fluid bg-white pb-5 my-0">
        <h4 class="main-color mt-4 font-bold">Bukti Transfer</h4>
        <p class="mt-4 f-14 pr-120 black">*Berikut Detail Transfer anda</p>
        <div class="mt-2 text-center box-frame" id="printArea">
            <div>
                <p class="f-14 text-color-4">Metode Pembayaran</p>
                <p class="mt-1 f-16 black font-bold"><?= strtoupper($this->db->get_where("withdraw_method",['code'=>$payment['metode']])->row_array()['name']); ?></p>
            </div><div class="mt-3">
                <p class="f-14 text-color-4">Keterangan</p>
                <p class="mt-1 f-20 black font-bold"><?= strtoupper($payment['keterangan']); ?></p>
            </div>
            <div class="mt-3">
                <p class="f-14 text-color-4">Status</p>
                <?php
                if($payment['status'] == "success"){
                    $text='success';
                }else if($payment['status'] == "error"){
                    $text='danger';
                }else if($payment['status'] == "pending"){
                    $text='info';
                }
                ?>
                <p class="mt-1 f-20 text-<?= $text;?> font-bold"><?= strtoupper($payment['status']); ?></p>
                <?if($payment['status'] == "pending"){
                    echo '<p class="f-14 text-danger text-color-4">Status Transaksi ini sedang di proses.<br />silahkan ditunggu beberapa saat !</p>';
                }
                ?>
            </div>
            <div class="mt-3">
                <p class="f-14 text-color-4">Nominal</p>
                <p class="mt-1 f-16 black font-bold">Rp <?= number_format($payment['quantity']); ?></p>
            </div>
            <div class="mt-3">
                <p class="f-14 text-color-4">Biaya Admin</p>
                <p class="mt-1 f-16 black font-bold">Rp <?= number_format($payment['fee']); ?></p>
            </div>
            <div class="mt-3">
                <p class="f-14 text-color-4">Saldo Diterima</p>
                <p class="mt-1 f-16 black font-bold">Rp <?= number_format($payment['get_balance']); ?></p>
            </div>
            <p class="f-14 px-5 mt-4 text-danger">
                Halaman ini adalah bukti Transfer yang sah !
            </p>
        </div>
        <div class="text-center mt-4">
            <a class="btn btn-print" href="javascript:void(0)" onclick="printDiv('printArea')">Print</a>
        </div>
    </div>
</div>
<?php
if($payment['status'] == 'pending'){

?>
<script type='text/javascript'>
    setInterval(ajaxCall, 3000); //300000 MS == 5 minutes
    function ajaxCall() {
        //do your AJAX stuff here
        $.ajax({
            url: '<?= base_url('withdraw/status/' . $payment['reffid']); ?>',
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
<? }?>