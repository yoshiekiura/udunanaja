<div class="main-container pb-100 h100 bg-white mx-auto">
    <div class="container-fluid bg-white pb-100 my-0 py-5">
        <div class="text-center ">
            <img src="<?= base_url(); ?>assets/image/logo/logo.svg" class="logo-icon-1" />
        </div>
        <form action="<?= base_url('auth'); ?>" method="POST" class="mt-4 p-4">
            <?= $this->session->flashdata('message'); ?>
            <?php echo  form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());  ?>

            <div class="form-group">
                <label class="font-semiBold" for="email">Email</label>
                <input type="email" class="form-control bg-light-color br-10 <?php echo (form_error('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Email" value="<?= set_value('email'); ?>">
                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group">
                <label class="font-semiBold" for="password">Password</label>
                <input type="password" class="form-control bg-light-color br-10 <?php echo (form_error('email')) ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password">
                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <button type="submit" class="button primary-button login-btn font-bold">Masuk</button>
        </form>
        <div class="px-4 text-center">
            <a href="<?= base_url('auth/forgot_password'); ?>" class="body-small text-center">Lupa Password?</a>
            <hr>
            <p class="body-small text-center bg-secondary-color">Tidak Punya Akun?</p>
            <a href="<?= base_url('auth/registration'); ?>" class="body-small text-center mt-4">Daftar</a>
        </div>
    </div>
</div>