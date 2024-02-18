<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>


<!-- content @s -->
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="buysell wide-xs m-auto">
                <div class="buysell-title text-center">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-caution-fill bg-danger"></em>
                    <h4 class="nk-modal-title"><?=('Error Creating Account. Try Again Later'); ?></h4>
                </div>
            </div><!-- .buysell -->
        </div>
    </div>
</div>
                <!-- content @e -->
<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo site_url(); ?>assets/js/jquery.min.js"></script>