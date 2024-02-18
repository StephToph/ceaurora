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
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title"><?=('Account Successfully Created. Click the button below to login'); ?></h4>
                </div><!-- .buysell-title -->
                <div class="buysell-block text-center">
                    <form action="javascript:;" class="buysell-form">
                        
                        <div class="form-note text-base text-center mt-3">
                            <ul class="btn-group gx-4">
                                <li><a href="<?=site_url('login');?>" class="btn btn-lg btn-mw btn-primary"><?=translate_phrase('Login'); ?></a></li>
                            </ul>
                        </div>
                    </form><!-- .buysell-form -->
                </div><!-- .buysell-block -->
            </div><!-- .buysell -->
        </div>
    </div>
</div>
                <!-- content @e -->
<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo site_url(); ?>assets/js/jquery.min.js"></script>