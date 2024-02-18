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
    <div class="nk-content" style="background-image: url(<?=site_url('assets/sitebk.png'); ?>);background-size: cover;">
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
                                        <a class="nav-link active" href="<?=site_url('auth/profile'); ?>"><em class="icon ni ni-user-fill-c"></em><span><?=translate_phrase('Personal'); ?></span></a>
                                    </li>
                                    <?php
                                        if($this->Crud->check2('id', $log_id, 'setup', 0, 'user') > 0){
                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('auth/security'); ?>"><em class="icon ni ni-lock-alt-fill"></em><span><?=translate_phrase('Payment Setup'); ?></span></a>
                                        </li>
                                    <?php 
                                        }
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?=site_url('auth/profile_view'); ?>"><em class="icon ni ni-view-panel"></em><span>ID<?=translate_phrase(' Card'); ?></span></a>
                                    </li>
                                </ul><!-- .nav-tabs -->
                                <div class="card-inner card-inner-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title"><?=translate_phrase('Personal Information'); ?></h4>
                                            <div class="nk-block-des">
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="nk-block">
                                        <div class="nk-data data-list data-list-s2">
                                            <div class="data-head">
                                                <h6 class="overline-title"><?=translate_phrase('Basics'); ?></h6>
                                            </div>
                                            <div class="data-item pop" pageTitle="<?=translate_phrase('Manage Profile'); ?>" pageSize="modal-md" pageName="<?=site_url('auth/profile/manage/personal'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('Full Name');?></span>
                                                    <span class="data-value"><?=$fullname;?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                            </div><!-- data-item -->
                                            <div class="data-item pop" pageTitle="<?=translate_phrase('Manage Profile'); ?>" pageSize="modal-md" pageName="<?=site_url('auth/profile/manage/personal'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label"><?php 
                                                        echo translate_phrase('Tax ID');?></span>
                                                    <span class="data-value"><?=$tax_id;?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                            </div><!-- data-item -->
                                            <div class="data-item">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('Email'); ?></span>
                                                    <span class="data-value"><?=$email;?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                            </div><!-- data-item -->
                                            <div class="data-item">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('Phone Number'); ?></span>
                                                    <span class="data-value text-soft"><?=$phone;?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                            </div><!-- data-item -->
                                            <div class="data-item pop" pageTitle="<?=translate_phrase('Manage Profile'); ?>" pageSize="modal-md" pageName="<?=site_url('auth/profile/manage/personal'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('L.G.A'); ?></span>
                                                    <span class="data-value"><?=$this->Crud->read_field('id', $lga_id, 'city', 'name'); ?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                            </div><!-- data-item -->
                                            <div class="data-item pop" pageTitle="<?=translate_phrase('Manage Profile');?>" pageSize="modal-md" pageName="<?=site_url('auth/profile/manage/personal'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('Address'); ?></span>
                                                    <span class="data-value"><?=$address; ?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                            </div>
                                            <div class="data-item" pageTitle="<?=translate_phrase('Manage Profile');?>" pageSize="modal-md" pageName="<?=site_url('auth/profile/manage/personal'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('Territory'); ?></span>
                                                    <span class="data-value"><?=ucwords($territory); ?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                            </div>
                                            <div class="data-item" pageTitle="<?=translate_phrase('Manage Profile');?>" pageSize="modal-md" pageName="<?=site_url('auth/profile/manage/personal'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('Trade'); ?></span>
                                                    <span class="data-value"><?=$trade; ?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                            </div>
                                            <div class="data-item" pageTitle="<?=translate_phrase('Manage Profile');?>" pageSize="modal-md" pageName="<?=site_url('auth/profile/manage/personal'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('Duration'); ?></span>
                                                    <span class="data-value"><?=ucwords($duration); ?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                            </div>
                                            <div class="data-item" pageTitle="<?=translate_phrase('Manage Profile');?>" pageSize="modal-md" pageName="<?=site_url('auth/profile/manage/personal'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('Utilty'); ?></span>
                                                    <span class="data-value"><?=$utility; ?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                            </div>
                                            <div class="data-item" pageTitle="<?=translate_phrase('Manage Profile');?>" pageSize="modal-md" pageName="<?=site_url('auth/profile/manage/personal'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label">ID<?=translate_phrase(' Card'); ?></span>
                                                    <span class="data-value"><?=$id_card; ?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                            </div>
                                            <div class="data-item" pageTitle="<?=translate_phrase('Manage Profile');?>" pageSize="modal-md" pageName="<?=site_url('auth/profile/manage/personal'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label">QR<?=translate_phrase(' Code'); ?></span>
                                                    <span class="data-value"><?=$qrcode; ?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                            </div>
                                            <div class="data-item pop" pageTitle="<?=translate_phrase('Manage Profile');?>" pageSize="modal-md" pageName="<?=site_url('auth/profile/manage/personal'); ?>">
                                                <div class="data-col">
                                                    <span class="data-label"><?=translate_phrase('Passport'); ?></span>
                                                    <span class="data-value"><?=$passport; ?></span>
                                                </div>
                                                <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
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
    <script src="<?=site_url(); ?>assets/js/jsmodal.js"></script>
<?=$this->endSection();?>