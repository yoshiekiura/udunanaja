<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<?php
if($payment['method']=="BANK BCA"){
    $image = "ic-bca-logo.svg";
}else if($payment['method']=="BANK BNI"){
    $image = "ic-bni-logo.svg";
}else if($payment['method']=="BANK MANDIRI"){
    $image = "ic-mandiri-logo.svg";
}else if($payment['method']=="BANK BRI"){
    $image = "ic-bri-logo.svg";
}else if($payment['method']=="QRIS"){
    $image = "ic-qris-logo.svg";
}else if($payment['method']=="BANK ARTA GRAHA"){
    $image = "BAG.png";
}else if($payment['method']=="BANK MUAMALAT"){
    $image = "muamalat.png";
}else if($payment['method']=="BANK CIMB NIAGA"){
    $image = "cimb-niaga.svg";
}else if($payment['method']=="CASH TO BANDAR"){
    $image = "cod.png";
}

?>
<div class="main-container pb-100 h100 bg-white mx-auto">
    <!-- ==== 1. Top Bar ==== -->
    <nav class="navbar bg-white navbar-light">
    </nav>

    <!-- ==== 2. Content ===== -->
    <div class="container-fluid bg-white pb-5 my-0">
        <h4 class="main-color mt-4 font-bold">Bukti Pembayaran</h4>
        <p class="mt-4 f-14 pr-120 black">*Terimakasih telah melakukan pembayaran</p>
        <div class="mt-2 text-center box-frame" id="printArea">
            <div>
                <p class="f-14 text-color-4">Metode Pembayaran</p>
                <?php
                if($payment['method'] == "qris"){?>
                <img src="<?= base_url(); ?>assets/image/icon/ic-qris.svg" class="mt-2" height='70' />
                <?}else{?>
                <img src="<?= base_url(); ?>assets/image/icon/<?= $image; ?>" class="mt-2 logo-payment" height='40'/>
                <?}?>
            </div>
            <div class="mt-3">
                <p class="f-14 text-color-4">Status</p>
                <p class="mt-1 f-20 text-<?= ($payment['status'] == "paid")? "success" : "danger" ;?> font-bold"><?= strtoupper($payment['status']); ?></p>
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
            
            <div class="mt-3">
            <table style="width:100%">
              <tr>
                <td>Nama</td>
                <td><?= $payment['name']; ?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><?= $payment['email']; ?></td>
              </tr>
              <tr>
                <td>Phone</td>
                <td><?= $payment['phone']; ?></td>
              </tr>
            </table>
            </div>
            <p class="f-14 px-5 mt-4 text-danger">
                Halaman ini adalah bukti Pembayaran yang sah !
            </p>
        </div>
        <div class="text-center mt-4">
            <a class="btn btn-print" href="javascript:void(0)" onclick="printDiv('printArea')">Print</a>
        </div>
    </div>
</div>