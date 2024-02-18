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
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="content-page wide-sm m-auto">
                    <div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
                        <div class="nk-block-head-content text-center">
                            <h2 class="nk-block-title text-danger fw-normal"><em class="icon ni ni-hot"></em></h2>
                            <div class="nk-block-des">
                                <h1 class="text-danger fw-normal"><?=translate_phrase('Coming Soon'); ?>!!!</h2>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    
                </div><!-- .content-page -->
            </div>
        </div>
    </div>
</div>
                <!-- content @e -->

<?=$this->endSection();?>