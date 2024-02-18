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
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="buysell wide-xs m-auto">
                <div class="buysell-title text-center">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title"><?=translate_phrase('Successfully sent payment'); ?>!</h4>
                </div><!-- .buysell-title -->
                <div class="buysell-block text-center">
                    <form action="javascript:;" class="buysell-form">
                        
                        <div class="form-note text-base text-center">
                            <ul class="btn-group gx-4">
                                <li><a href="<?=site_url('payments');?>" class="btn btn-lg btn-mw btn-primary"><?=translate_phrase('Return');?></a></li>
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
<script>
    $(function() {
        test('transfer');
    });

    function test(type){
        if(type == 'transfer'){
            $('#transfer').show();
            $('#deposit').hide();
            $('#withdraw').hide();
            $('#phone_card').show();
            $('#pay_method').hide();
        }
        if(type == 'deposit'){
            $('#transfer').hide();
            $('#deposit').show();
            $('#withdraw').hide();
            $('#phone_card').hide();
            $('#pay_method').show();
        }
        if(type == 'withdraw'){
            $('#transfer').hide();
            $('#deposit').hide();
            $('#withdraw').show();
            $('#phone_card').hide();
        }
        $('#type').html(type);
        $('#types').html('Continue to '+type);
        $('#type').css('textTransform', 'capitalize');
        $('#types').css('textTransform', 'capitalize');
    }
</script>   

<?=$this->endSection();?>