<div class="main-container pb-100 h100 bg-white mx-auto">
    <div class="container-fluid bg-white pb-100 my-0 py-4">
        <div class="d-flex flex-row">
            <div class="p-2">
                <a href="<?= base_url('auth'); ?>">
                    <img src="<?= base_url(); ?>assets/image/icon/ic-arrow.svg" />
                </a>
            </div>
            <div class="pt-2">
                <h4 class="main-color font-bold">Register</h4>
            </div>
        </div>
        <form action="<?= base_url('auth/registration'); ?>" method="POST" class="p-4">
            <?= $this->session->flashdata('message'); ?>
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
                <label for="phone" class="font-semiBold">No WhatsApp</label>
                <input type="number" class="form-control bg-light-color br-10 phone-number <?php echo (form_error('phone')) ? 'is-invalid' : ''; ?>" id="phone" name="phone" placeholder="Phone" value="<?= set_value('phone'); ?>" pattern="/(\()?(\+62|62|0)(\d{2,3})?\)?[ .-]?\d{2,4}[ .-]?\d{2,4}[ .-]?\d{2,4}/">
                <?= form_error('phone', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
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
            <button type="submit" class="button primary-button login-btn font-bold">Register</button>
        </form>
        <div class="px-4 text-center">
            <p class="body-small text-center bg-secondary-color">Sudah Punya Akun?</p>
            <a href="<?= base_url('auth/'); ?>" class="body-small text-center mt-4">Login</a>
        </div>
    </div>
</div>