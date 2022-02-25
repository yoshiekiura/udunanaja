<div class="container-fluid bg-white pb-100 my-0">
    <div class="card bg-green-1 border-0 br-20 shadow-none mt-3">
        <div class="mb-3">
            <p class="text-center f-17 text-color-5">Saldo Anda</p>
            <h4 class="text-center text-white font-bold"><small>Rp. </small> <?= number_format($user['balance']); ?></h4>
            <img class="substract" src="<?= base_url(); ?>assets/image/icon/ic-substract.svg" />
            <a class="saldo-plus-o btn btn-info" href="<?= base_url();?>withdraw/history">
                <i class="fa fa-history"></i>
            </a>
        </div>
    </div>
    <form method="POST" class="mt-5">
        <?= $this->session->flashdata('message'); ?>
        <?php echo  form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());  ?>
        <div class="form-group">
            <label class="font-semiBold" for="keterangan">Keterangan</label>
            <input type="text" class="form-control bg-light-color br-10 <?php echo (form_error('keterangan')) ? 'is-invalid' : ''; ?>" id="keterangan" name="keterangan" placeholder="Keterangan" value="<?= set_value('keterangan'); ?>">
            <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label class="font-semiBold" for="nominal">Nominal Penarikan</label>
            <input type='number' class="form-control bg-light-color br-10 <?php echo (form_error('nominal')) ? 'is-invalid' : ''; ?>" id="nominal" name="nominal" placeholder="Nominal" value="<?= set_value('nominal'); ?>">
            <?= form_error('nominal', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label class="font-semiBold" for="get_saldo">Saldo Diterima</label>
            <input type="text" class="form-control bg-light-color br-10 " id="get_saldo" placeholder="0" readonly>
        </div>
        <div class="form-group">
            <label class="font-semiBold" for="type">Tipe Pembayaran</label>
            <select class="form-control form-control bg-light-color br-10" id="type" name='type'>
                <option disabled selected>--Pilih Tipe Pembayaran--</option>
                <?php
                foreach ($type as $row) {
                    echo "<option value='" . $row['code'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label class="font-semiBold" for="type">Metode Pembayaran</label>
            <select class="form-control form-control bg-light-color br-10 theSelect" id="metode" name="metode">
                <option disabled selected>--Pilih Metode Pembayaran--</option>
            </select>
        </div>
        <div class="form-group">
            <label class="font-semiBold" for="norek">No Rekening Tujuan</label>
            <div class="d-flex">
                <input type="text" pattern="[0-9]+" class="form-control bg-light-color br-10 <?php echo (form_error('norek')) ? 'is-invalid' : ''; ?>" id="norek" name="norek" placeholder="No Rekening Tujuan" value="<?= set_value('norek'); ?>">
                <a onclick="check_rekening()" class="btn green-btn-1 text-white ml-2 br-10">Cek</a>
            </div>
            <?= form_error('norek', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label class="font-semiBold" for="bankname">Nama Rekening</label>
            <input type="text" class="form-control bg-light-color br-10 " id="bankname" name="bankname" placeholder="Checking..." readonly>
        </div>
        <div class="text-center mt-2">
            <button type='submit' class="button primary-button login-btn font-bold w-50">Transfer</button>
        </div>
    </form>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#type").change(function() {
            var type = $("#type").val();
            $.ajax({
                type: 'GET',
                url: '<?= base_url('ajax/type/'); ?>' + type,
                dataType: 'html',
                success: function(msg) {
                    $("#metode").html(msg);
                }
            });
        });
        
        $("#nominal").keyup(function() {
            var nominal = $("#nominal").val();
            var hasil = nominal - 2500;
            if(hasil > 0)
             $("#get_saldo").val(hasil);
            });
    });
    
        function check_rekening(){
            var norek = $("#norek").val();
            var metode = $("#metode").val();
            $.ajax({
                type: 'GET',
                url: '<?= base_url('ajax/check/rekening/'); ?>' + norek + '/' + metode,
                dataType: 'JSON',
                beforeSend: function() {
                $("#bankname").val('sedang mengecek');
                Swal.fire({title:"Checking...",showConfirmButton:false,allowOutsideClick:false});
                },
                success: function(msg) {
                    if (msg.result == true) {
                        Swal.fire(msg.name);
                        $("#bankname").val(msg.name);
                    }
                }
            });
        }
    
    $(".theSelect").select2();
</script>