</div>

<script type="text/javascript">
function modal_detail(name,link) {
    $.ajax({
        type: "GET",
        url: link,
        beforeSend: function() {
            $('#modal-detail-title').html(name);
            $('#modal-detail-body').html('Loading...');
        },
        success: function(result) {
            $('#modal-detail-title').html(name);
            $('#modal-detail-body').html(result);
        },
        error: function() {
            $('#modal-detail-title').html(name);
            $('#modal-detail-body').html('There is an error...');
        }
    });
    $('#modal-detail').modal();
}

function CopyMe(TextToCopy,info) {
        var TempText = document.createElement("input");
        TempText.value = TextToCopy;
        document.body.appendChild(TempText);
        TempText.select();

        document.execCommand('copy' );
        document.body.removeChild(TempText);
        if(info == true){
        Swal.fire(
            'Berhasil Copy',
            TempText.value,
            'success'
        )
        }
    }
</script>
<!-- ===== 4. Delete Confirmation ===== -->
<div id="confirm" class="modal fade">
    <div class="modal-dialog modal-confirm modal-dialog-centered">
        <div class="modal-content py-0">
            <div class="modal-header flex-column px-0">
                <div class="text-center w-100">
                    <img src="<?= base_url(); ?>assets/image/icon/ic-warning.svg" />
                </div>
                <h4 class="modal-title w-100 f-16 black font-bold">Yakin Mau Hapus Udunan Ini ?</h4>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="javascript:void(0)" class="text-danger f-16 mr-3">Iya</a>
                <a href="javascript:void(0)" data-dismiss="modal" class="text-success f-16">Tidak</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
  <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-detail-udunan modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title m-0 f-16 black font-bold" id="modal-detail-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-detail-body">
        </div>
      </div>
    </div>
  </div>
<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>-->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="<?= base_url(); ?>assets/vendor/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/bootstrap-4.4.1-dist/js/bootstrap.js"></script>
<script src="<?= base_url(); ?>assets/js/main.js"></script>
<!-- Histats.com  START  (aync)-->
<script type="text/javascript">var _Hasync= _Hasync|| [];
_Hasync.push(['Histats.start', '1,4631046,4,0,0,0,00010000']);
_Hasync.push(['Histats.fasi', '1']);
_Hasync.push(['Histats.track_hits', '']);
(function() {
var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
hs.src = ('//s10.histats.com/js15_as.js');
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
})();</script>
<noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?4631046&101" alt="" border="0"></a></noscript>
<!-- Histats.com  END  -->
</body>

</html>