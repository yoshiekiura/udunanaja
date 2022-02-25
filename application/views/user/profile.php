    <!-- ==== 3. Content ===== -->
    
        <div class="container-fluid my-0">
        <?= $this->session->flashdata('message'); ?>
      <div class="row mt-4">
        <div class="col-md-2 w-auto-mobile">
          <img src="<?= base_url();?>assets/image/user/user-1.jpg" class="img-profile" />
        </div>
        <div class="col-md-8 w-60-mobile align-self-center">
          <h4 class="f-18 font-semiBold"><?= $user['name'];?></h4>
          <div class="d-flex">
            <p class="f-14 text-color-7 mr-2"><?= ($user['is_verif'] == true) ? "verified" : "unverified";?></p>
            <img src="<?= base_url();?>assets/image/icon/ic-small-<?= ($user['is_verif'] == true) ? "verified" : "unverified";?>.svg" />
          </div>
        </div>
        <div class="col-md-2 w-auto-mobile align-self-center">
          <a href="javascript:void(0)"  onclick="modal_detail('Edit Profile','<?= base_url('ajax/user/profile/edit/'.base64_encode($user['id']));?>')">
            <img src="<?= base_url();?>assets/image/icon/ic-edit.svg" width="20" />
          </a>
        </div>
      </div>
      <div id="information">
        <div class="mt-4">
          <p class="f-17 black">Email</p>
          <p class="f-15 mt-1 black font-bold"><?= $user['email'];?></p>
        </div>
        <div class="mt-3">
          <p class="f-17 black">Telepon</p>
          <p class="f-15 mt-1 black font-bold"><?= $user['phone'];?></p>
        </div>
        <div class="mt-3">
          <p class="f-17 black">Bergabung</p>
          <p class="f-15 mt-1 black font-bold"><?= $user['created_at'];?></p>
        </div>
      </div>
      <div class="text-center mt-5">
        <a class="btn btn-edit-profile" href="javascript:void(0)" onclick="modal_detail('Edit Profile','<?= base_url('ajax/user/profile/edit/'.base64_encode($user['id']));?>')">Edit Profil</a>
      </div>
      <div class="text-center mt-3">
        <a href="<?= base_url();?>logout" class="text-danger font-bold f-16">Logout</s>
      </div>
    </div>