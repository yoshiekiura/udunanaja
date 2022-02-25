    <!-- ==== 3. Content ===== -->
    <div class="container-fluid bg-white pb-100 my-0">
        <h4 class="mt-4 f-18 font-bold">History Udunan</h4>
        <form method="POST" class="mt-2">
            <?php echo  form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());  ?>
            <div class="input-group">
                <span class="input-group-append">
                    <button class="btn rounded-pill border-0 mr-n5" type="submit">
                        <i class="fas fa-search text-color-6"></i>
                    </button>
                </span>
                <input class="form-control bg-light-color-2 py-2 rounded-pill pl-5" type="text" name='search' placeholder="Search...">
            </div>
        </form>
        <?= $this->session->flashdata('message'); ?>
        <ul class="mt-4 list-group list-group-flush">
            <?php
            if (!$history) {
                echo '<div class="alert alert-info" role="alert">Data ' . $search . 'Tidak Ditemukan </div>';
            } else {
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
                        echo '<div class="alert alert-danger" role="alert">Data <strong>' . $search . '</strong> Tidak Ditemukan </div>';
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
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                        <i data-feather="more-horizontal"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-left-custom p-0">
                                        <div class="d-inline-flex">
                                            <a class="dropdown-item p-0 mr-1" href="<?= base_url("share/" .$row['slug']); ?>">
                                                <i class="fa fa-copy text-info"></i>
                                            </a>
                                            <a class="dropdown-item p-0 mr-1" href="javascript:;" onclick="modal_detail('Detail Udunan','<?= base_url('ajax/udunan/detail/history/'.base64_encode($row['id'])) ?>')">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="dropdown-item p-0 mr-1" href="javascript:;" onclick="modal_detail('Edit Udunan','<?= base_url('ajax/udunan/edit/history/'.base64_encode($row['id'])) ?>')">
                                                <i class="fa fa-pencil-alt text-success"></i>
                                            </a>
                                        </div>
                                    </div>
                                </span>
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

            <? }
            } ?>
        </ul>
    </div>