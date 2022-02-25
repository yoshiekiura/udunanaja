<div class="main-container pb-100 h100 bg-white mx-auto">
    <div class="container-fluid bg-white pb-100 my-0 py-4">
        <div class="d-flex flex-row">
            <div class="p-2">
                <a href="<?= base_url('auth/'); ?>">
                    <img src="<?= base_url(); ?>assets/image/icon/ic-arrow.svg" />
                </a>
            </div>
            <div class="pt-2">
                <h4 class="main-color font-bold">Lupa Password</h4>
            </div>
        </div>
        <form action="<?= base_url('auth/forgot_password'); ?>" method="POST" class="p-4">
            <?= $this->session->flashdata('message'); ?>
            <?php echo  form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());  ?>
            <div class="form-group">
                <label class="font-semiBold" for="email">Email</label>
                <input type="email" class="form-control bg-light-color br-10 <?php echo (form_error('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Email" value="<?= set_value('email'); ?>">
                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <button class="button primary-button login-btn font-bold mt-3">Reset Password</button>
        </form>
        <div class="px-4 text-center">
            <p class="body-small text-center bg-secondary-color">Sudah Punya Akun?</p>
            <a href="<?= base_url('auth/'); ?>" class="body-small text-center mt-4">Login</a>
        </div>
    </div>
</div>