<div class="main-container pb-100 h100 bg-white mx-auto">
    <div class="container-fluid bg-white pb-100 my-0 py-4">
        <div class="d-flex flex-row">
            <div class="p-2">
                <a href="<?= base_url('auth/forgot_password'); ?>">
                    <img src="<?= base_url(); ?>assets/image/icon/ic-arrow.svg" />
                </a>
            </div>
            <div class="pt-2">
                <h4 class="main-color font-bold">Create New Password</h4>
            </div>
        </div>
        <form method="POST" class="p-4">
            <?= $this->session->flashdata('message'); ?>
            <?php echo  form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());  ?>
            <div class="form-group">
                <label for="password" class="font-semiBold">Password</label>
                <input type="password" class="form-control bg-light-color br-10 <?php echo (form_error('password')) ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password">
                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group">
                <label for="confirm_password" class="font-semiBold">Konfirmasi Password</label>
                <input type="password" class="form-control bg-light-color br-10 <?php echo (form_error('confirm_password')) ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password">
                <?= form_error('confirm_password', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <button class="button primary-button login-btn font-bold mt-3">Change Password</button>
        </form>
        <div class="px-4 text-center">
            <p class="body-small text-center bg-secondary-color">Sudah Punya Akun?</p>
            <a href="<?= base_url('auth/'); ?>" class="body-small text-center mt-4">Login</a>
        </div>
    </div>
</div>