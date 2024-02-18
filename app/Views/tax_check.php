<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>

<?=$this->extend('designs/backend');?>
<?=$this->section('title');?>
    <?=$title;?>
<?=$this->endSection();?>

<?=$this->section('content');?>
<div class="nk-content" style="background-image: url(<?=site_url('assets/sitebk.png'); ?>);background-size: cover;">
    <div class="container wide-xl ">
        <div class="nk-content-inner mt-5">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm  mt-3">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title"><?=translate_phrase('Tax Status Check'); ?></h3>
                            
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <div class="row g-4">
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="link">Virtual Account Number</label>
                                                <input class="form-control" type="text" id="account_number" name="account_number" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 text-center">
                                            <hr />
                                            <button class="btn btn-primary bb_form_btn" onclick="check_status();" type="button">
                                                <i class="icon ni ni-save"></i> Check Status
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div id="status_resp"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .card-preview -->
                                        
            </div>
        </div>
    </div>
</div>

<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>
<script>
    function check_status() {
        var account_number = $('#account_number').val();
        $('#status_resp').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><?=translate_phrase('Loading.. PLease Wait'); ?></div>');
        $.ajax({
            url: site_url + 'dashboard/tax_check/validate/' + account_number,
            type: 'post',
            success: function (data) {
                $('#status_resp').html(data);
            }
        });
    }
</script>   

<?=$this->endSection();?>