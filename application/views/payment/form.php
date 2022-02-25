<div class="main-container h100 bg-white mx-auto">
    <!-- ==== 1. Top Bar ==== -->
    <nav class="navbar bg-white navbar-light">
    </nav>

    <!-- ==== 2. Content ===== -->
    <div class="container-fluid bg-white pb-5 my-0">

        <?= $this->session->flashdata('message'); ?>
        <h4 class="main-color mt-4 font-bold">Pembayaran</h4>
        <h4 class="mt-4 black font-bold"><?= $campaign['judul']; ?></h4>
        <div class="mt-4">
            <p class="f-16 text-color-4">Bandar Udunan</p>
            <p class="f-18 mt-1 black font-bold"><?= $author['name']; ?></p>
        </div>
        <div class="mt-3">
            <p class="f-16 text-color-4">Nominal</p>
            <p class="f-18 mt-1 black font-bold">Rp <?= number_format($campaign['nominal']); ?></p>
        </div>
        <div class="mt-3">
            <p class="f-16 text-color-4">Keterangan</p>
            <div class="description mt-2" contentEditable="false">
                <?= nl2br($campaign['keterangan']); ?>
            </div>
        </div>
        <hr>
        <?php

        if ($campaign['status'] == "expired") {
            echo '<br /><div class="alert alert-danger" role="alert">Mohon Maaf, Udunan ini sudah <strong>Tidak Dapat di Ikuti Kembali</strong><br />Silahkan Bandar Udunan ! !</div>';
        } else if ($campaign['max_user'] == $max_user) {
            echo '<br /><div class="alert alert-danger" role="alert">Mohon Maaf, Udunan ini sudah <strong>Mencapai Maximal User Pengikut</strong><br />Silahkan Bandar Udunan ! !</div>';
        } else {
        ?>
            <form method="POST" class="mt-3">
                <?php echo  form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());  ?>
                <div class="form-group">
                    <label for="name" class="font-semiBold">Nama</label>
                    <input type="text" class="form-control bg-light-color br-10 <?php echo (form_error('name')) ? 'is-invalid' : ''; ?>" id="name" name="name" placeholder="Nama" value="<?= set_value('name'); ?>">
                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="email" class="font-semiBold">Email</label>
                    <input type="email" class="form-control bg-light-color br-10 <?php echo (form_error('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Email" value="<?= set_value('email'); ?>">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="phone" class="font-semiBold">Phone</label>
                    <input type="number" class="form-control bg-light-color br-10 phone-number <?php echo (form_error('phone')) ? 'is-invalid' : ''; ?>" id="phone" name="phone" placeholder="Phone" value="<?= set_value('phone'); ?>" pattern="/(\()?(\+62|62|0)(\d{2,3})?\)?[ .-]?\d{2,4}[ .-]?\d{2,4}[ .-]?\d{2,4}/">
                    <?= form_error('phone', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <hr>
                <p class="f-14 black font-bold">Pilih Metode Pembayaran</p>
                <div>
                    <button onclick="loading()" name="qris" value="1" class="btn border-1 d-flex justify-content-between btn-payment-2 mt-3 w-100 py-2 px-3 br-10" <?= ($campaign['nominal'] < 1000) ? "disabled" : ""; ?>>
                        <img src="<?= base_url(); ?>assets/image/icon/ic-qris-small.svg" class="icon-payment" /> Rp <?= number_format($campaign['nominal'] + ($campaign['nominal'] * 0.008)); ?>
                    </button>
                    <button onclick="loading()" name="bca" value="1" class="btn border-1 d-flex justify-content-between btn-payment-2 mt-3 w-100 py-2 px-3 br-10" <?= ($campaign['nominal'] < 10000) ? "disabled" : ""; ?>>
                        <img src="<?= base_url(); ?>assets/image/icon/ic-bca-small.svg" class="icon-payment" /> Rp <?= number_format($campaign['nominal'] + 4000); ?>
                    </button>
                    <button onclick="loading()" name="bni" value="1" class="btn border-1 d-flex justify-content-between btn-payment-2 mt-3 w-100 py-2 px-3 br-10" <?= ($campaign['nominal'] < 10000) ? "disabled" : ""; ?>>
                        <img src="<?= base_url(); ?>assets/image/icon/ic-bni-small.svg" class="icon-payment" /> Rp <?= number_format($campaign['nominal'] + 4000); ?>
                    </button>
                    <button onclick="loading()" name="bri" value="1" class="btn border-1 d-flex justify-content-between btn-payment-2 mt-3 w-100 py-2 px-3 br-10" <?= ($campaign['nominal'] < 10000) ? "disabled" : ""; ?>>
                        <img src="<?= base_url(); ?>assets/image/icon/ic-bri-small.svg" class="icon-payment" /> Rp <?= number_format($campaign['nominal'] + 4000); ?>
                    </button>
                    <button onclick="loading()" name="mandiri" value="1" class="btn border-1 d-flex justify-content-between btn-payment-2 mt-3 w-100 py-2 px-3 br-10" <?= ($campaign['nominal'] < 10000) ? "disabled" : ""; ?>>
                        <img src="<?= base_url(); ?>assets/image/icon/ic-mandiri-small.svg" class="icon-payment" /> Rp <?= number_format($campaign['nominal'] + 4000); ?>
                    </button>
                    <button onclick="loading()" name="artagraha" value="1" class="btn border-1 d-flex justify-content-between btn-payment-2 mt-3 w-100 py-2 px-3 br-10" <?= ($campaign['nominal'] < 10000) ? "disabled" : ""; ?>>
                        <img src="<?= base_url(); ?>assets/image/icon/BAG.png" class="icon-payment" height="30"/> Rp <?= number_format($campaign['nominal'] + 4000); ?>
                    </button>
                    <button onclick="loading()" name="muamalat" value="1" class="btn border-1 d-flex justify-content-between btn-payment-2 mt-3 w-100 py-2 px-3 br-10" <?= ($campaign['nominal'] < 10000) ? "disabled" : ""; ?>>
                        <img src="<?= base_url(); ?>assets/image/icon/muamalat.png" class="icon-payment" height="30"/> Rp <?= number_format($campaign['nominal'] + 4000); ?>
                    </button>
                    <button onclick="loading()" name="cimbniaga" value="1" class="btn border-1 d-flex justify-content-between btn-payment-2 mt-3 w-100 py-2 px-3 br-10" <?= ($campaign['nominal'] < 10000) ? "disabled" : ""; ?>>
                        <img src="<?= base_url(); ?>assets/image/icon/cimb-niaga.svg" class="icon-payment" height="30"/> Rp <?= number_format($campaign['nominal'] + 4000); ?>
                    </button>
                    <button onclick="loading()" name="cod" value="1" class="btn border-1 d-flex justify-content-between btn-payment-2 mt-3 w-100 py-2 px-3 br-10" <?= ($campaign['nominal'] < 1000) ? "disabled" : ""; ?>>
                        <img src="<?= base_url(); ?>assets/image/icon/cod.png" class="icon-payment" height="30"/> Rp <?= number_format($campaign['nominal']); ?>
                    </button>
                </div>
            </form>
        <? } ?>
    </div>
</div>
<script type="text/javascript">
    function loading(){
        Swal.fire({
  title: 'Processing...',
  timer: 5000,
  timerProgressBar: true,
  showConfirmButton:false,
  allowOutsideClick:false
})
    }
</script>