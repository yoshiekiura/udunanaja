<!-- ===== 3. Content ===== -->
<div class="container-fluid bg-white pb-100 my-0">
    <?= $this->session->flashdata('message'); ?>
    <div>
        <div class="row mt-4">
            <div class="col pr-2">
                <div class="card-saldo bg-card-saldo">
                    <div class="row">
                        <div class="col-3 align-self-center text-center">
                            <img class="responsive-img-1" src="<?= base_url(); ?>assets/image/icon/ic-dollar.svg">
                        </div>
                        <div class="col-9">
                            <p class="body-small lh-35 text-color-1">Saldo</p>
                            <p class="body-small-bold text-white">Rp <?= number_format($user['balance']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col pl-2">
                <div class="card-saldo bg-card-transaction">
                    <div class="row">
                        <div class="col-3 align-self-center text-center">
                            <img class="responsive-img-1" src="<?= base_url(); ?>assets/image/icon/ic-transaction-card.svg">
                        </div>
                        <div class="col-9">
                            <p class="body-small text-color-1">Total Udunan</p>
                            <p class="body-small-bold text-white"><?= number_format($this->db->query("SELECT * FROM patungan WHERE email='".$user['email']."'")->num_rows()); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col pr-2">
                <div class="card-saldo bg-total-udunan">
                    <div class="row">
                        <div class="col-3 align-self-center text-center">
                            <img class="responsive-img-1" src="<?= base_url(); ?>assets/image/icon/ic-wallet.svg">
                        </div>
                        <div class="col-9">
                            <p class="body-small text-color-1">Total Pembayaran</p>
                            <p class="body-small-bold text-white"><?= number_format($this->db->query("SELECT * FROM withdraw_history WHERE email='".$user['email']."'")->num_rows()); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col pl-2">
                <div class="card-saldo bg-card-verified">
                    <div class="row">
                        <div class="col-3 align-self-center text-center">
                            <img class="responsive-img-1" src="<?= base_url(); ?>assets/image/icon/ic-verified.svg">
                        </div>
                        <div class="col-9">
                            <p class="body-small text-color-1">Status Account</p>
                            <p class="body-small-bold text-white"><?= ($user['is_verif'] == true) ? "Verified" : "Unverified"; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <h4 class="mt-4 f-18 font-bold">10 Udunan Terakhir</h4>
        <ul class="mt-4 list-group list-group-flush">
            <?php
                foreach ($history as $row) {
                    if ($row['status'] == 'active') {
                        $status_badge = "success";
                    } else {
                        $status_badge = "expired";
                    }

                    if (substr($row['judul'], 30)) {
                        $judul = substr($row['judul'], 0, 30) . "...";
                    } else {
                        $judul = $row['judul'];
                    }

                    if (!$row) {
                        echo '<div class="alert alert-danger" role="alert">Data ' . $search . 'Tidak Ditemukan </div>';
                        break;
                    }
            ?>
                    <li class="list-group-item">
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="f-16 font-bold"><?= $judul; ?></p>
                                <p class="body-small"><?= $row['max_user']; ?> Orang</p>
                            </div>
                            <div class="col-6 align-self-center">
                                <span class="dropdown float-right">
                                    <a href="<?= base_url("udunan/detail/" . base64_encode($row['id'])); ?>" class="btn btn-sm dropdown-toggle hide-arrow">
                                        <i data-feather="arrow-right-circle"></i>
                                    </a>
                                </span>
                                <div>
                                    <span class="badge badge-outline-<?= $status_badge; ?> float-right mr-2 mt-2"><?= $row['status']; ?></span>
                                </div>
                            </div>
                        </div>
                    </li>

            <? } ?>
        </ul>
</div>