<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>

<?=$this->extend('designs/backend');?>
<?=$this->section('title');?>
    <?=$title;?>
<?=$this->endSection();?>


<?=$this->section('content');?>
    <!-- content @s -->
    <div class="nk-content">
        <div class="container wide-xl  mt-5">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-content-wrap">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title"><?=translate_phrase('My Profile'); ?></h3>
                                <div class="nk-block-des">
                                    <p><?=translate_phrase('You have full control to manage your own account setting.');?></p>
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->
                        <div class="nk-block">
                            <div class="card card-bordered">
                                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?=site_url('auth/profile'); ?>"><em class="icon ni ni-user-fill-c"></em><span><?=translate_phrase('Personal'); ?></span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?=site_url('auth/security'); ?>"><em class="icon ni ni-lock-alt-fill"></em><span><?=translate_phrase('Security'); ?></span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?=site_url('auth/bank'); ?>"><em class="icon ni ni-activity-round-fill"></em><span><?=translate_phrase('Bank Account'); ?></span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?=site_url('auth/profile_view'); ?>"><em class="icon ni ni-qr"></em><span><?=translate_phrase('QR CODE'); ?></span></a>
                                    </li>
                                </ul><!-- .nav-tabs -->
                                <div class="card-inner card-inner-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title"><?=translate_phrase('Bank Account Information'); ?></h4>
                                            <div class="nk-block-des">
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="nk-block">
                                        <div class="nk-data data-list data-list-s2">
                                            <div class="data-item pop" pageTitle="Bank Account" pageSize="modal-l" pageName="<?=site_url('auth/bank/manage/bank'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('Bank Name');?></span>
                                                    <span class="data-value text-dark fw-bold"><?php if($this->Crud->check('user_id', $log_id, 'account') == 0){echo translate_phrase('Click to Setup Bank Account');} else {echo $this->Crud->read_field('user_id', $log_id, 'account', 'bank'); }?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                            </div><!-- data-item -->
                                            <div class="data-item pop" pageTitle="Bank Account" pageSize="modal-l" pageName="<?=site_url('auth/bank/manage/bank'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('Account Number');?></span>
                                                    <span class="data-value text-dark fw-bold"><?php if($this->Crud->check('user_id', $log_id, 'account') == 0){echo translate_phrase('Click to Setup Bank Account');} else { echo $this->Crud->read_field('user_id', $log_id, 'account', 'account').' - '.ucwords($this->Crud->read_field('user_id', $log_id, 'account', 'name')); } ?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                            </div>
                                        </div><!-- data-list -->
                                    </div><!-- .nk-block -->
                                </div><!-- .card-inner -->
                            </div><!-- .card -->
                        </div><!-- .nk-block -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?=$this->endSection();?>

<?=$this->section('scripts');?>
    <script src="<?=site_url();?>assets/js/jsform.js"></script>
    <script>
        var site_url = '<?=site_url();?>';
        $('.select2').select2();

        $(function() {
            get_state();
        });
    </script>
    <script src="<?=site_url(); ?>assets/js/jsmodal.js"></script>
<?=$this->endSection();?>