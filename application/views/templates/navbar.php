<!-- ==== 1. Top Bar ==== -->
<nav class="navbar bg-white navbar-light">
    <img src="<?= base_url(); ?>assets/image/logo/UdunanAja.svg" class="mt-4" alt="" />
</nav>
<!-- ==== 2. Bottom Navigation ===== -->
<nav class="bottom-navigation">
    <div class="row no-gutters mt-2">
        <div class="col-2 align-self-center text-center">
            <a href="<?= base_url(); ?>">
                <img src="<?= base_url(); ?>assets/image/menu/ic-home<?= ($navbar == "home") ? '-active' : ''; ?>.svg" alt="">
            </a>
        </div>
        <div class="col-2 align-self-center text-center">
            <a href="<?= base_url('user/udunan'); ?>">
                <img src="<?= base_url(); ?>assets/image/menu/ic-wallet<?= ($navbar == "wallet") ? '-active' : ''; ?>.svg" alt="">
            </a>
        </div>
        <div class="col-4 align-self-center text-center">
            <a href="<?= base_url('withdraw'); ?>">
                <img src="<?= base_url(); ?>assets/image/menu/ic-transfer<?= ($navbar == "transfer") ? '-active' : ''; ?>.svg" alt="">
            </a>
        </div>
        <div class="col-2 align-self-center text-center">
            <a href="<?= base_url('udunan/history'); ?>">
                <img src="<?= base_url(); ?>assets/image/menu/ic-history<?= ($navbar == "history") ? '-active' : ''; ?>.svg" alt="">
            </a>
        </div>
        <div class="col-2 align-self-center text-center">
            <a href="<?= base_url('user/profile'); ?>">
                <img id="avatar" class="avatar-o<?= ($navbar == "profile") ? '-active' : ''; ?>" src="<?= base_url(); ?>assets/image/user/user-1.jpg" alt="">
            </a>
        </div>
    </div>
</nav>