<div class="container-fluid bg-white pb-100 my-00">
    <h4 class="mt-4 f-18 font-bold">Share Udunan</h4>
    <?= $this->session->flashdata('message'); ?>
    <div class="mt-4 text-center box-frame">
        <p class="f-14">Ayo Bayar patungan “<strong><?= $campaign['judul']; ?></strong>” Sekarang !</p>
        <p class="f-14 text-color-2 mt-2">Bayar dengan klik link dibawah ini</p>
        <a href="<?= base_url("pay/" . $campaign['slug']); ?>" id="link_udunan" target="_blank" class="f-14 font-bold link-1 f-10-mobile"><?= base_url("pay/" . $campaign['slug']); ?></a>
        <div class="mt-3">
            <a href="javascript:void(0)" onclick="CopyMe('<?= base_url("pay/" . $campaign['slug']); ?>',true)" class="button primary-button copy-link f-14 font-bold">Copy
                Link</a>
        </div>
        <p class="f-14 text-color-3 font-bold mt-5 px-5">Klik tombol dibawah ini untuk share ke social media kamu</p>
        <div class="row justify-content-center-desktop mt-3">
            <div class="share-social-media col-3">
                <a href="javascript:void(0)" target="_blank">
                    <img src="<?= base_url(); ?>assets/image/icon/ic-line.svg" />
                </a>
            </div>
            <div class="share-social-media ml-2-rem col-4 ml-3">
                <a class="position-1" href="https://api.whatsapp.com/send/?text=<?= base_url("pay/" . $campaign['slug']); ?>" target="_blank">
                    <img src="<?= base_url(); ?>assets/image/icon/ic-whatsapp.svg" />
                </a>
            </div>
        </div>
    </div>
</div>