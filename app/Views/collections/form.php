
<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>

<?php if($param2 == 'govt'){?>

<?=form_open_multipart(site_url('#'), array('id'=>'bb_ajax_form', 'class'=>''));?>
    <div id="bb_ajax_msg"></div>
    <div class="row">
        <span class="text-center text-dark mb-3"><?=translate_phrase('For payment of taxes, fees or levies'); ?> </span>
        <div class="mb-2 col-sm-12">
            <div  class="form-group mb-2" >
                <label for="activate"><?=translate_phrase('Daily  Fee'); ?></label>
                <input type="text" class="form-control" name="amount"> 
            </div>
        </div>
        <div class="mb-2 col-sm-12">
            <div  class="form-group mb-2" >
                <label for="activate"><?=translate_phrase('Security Fee'); ?></label>
                <input type="password" class="form-control" name="password"> 
            </div>
        </div>
        <button type="button" class="mt-3 mb-2 btn-block btn btn-success " id="start_scan"><i class="icon ni ni-card"></i> <span class="fw-200 text-white"><?=translate_phrase('Make Payment'); ?></span></button>
    </div>
    
<?=form_close();?>
<?php } ?>

<?php if($param2 == 'health'){?>

<?=form_open_multipart(site_url('auth/profile'), array('id'=>'bb_ajax_form', 'class'=>''));?>
    <div id="bb_ajax_msg"></div>
    <div class="row">
        <span class="text-center text-dark mb-3"><?=translate_phrase('Pay your contribution for mass health insurance scheme'); ?></span>
        <div class="mb-2 col-sm-12">
            <div  class="form-group mb-2" >
                <label for="activate"><?=translate_phrase('Daily  Fee'); ?></label>
                <input type="text" class="form-control" name="amount"> 
            </div>
        </div>
        <div class="mb-2 col-sm-12">
            <div  class="form-group mb-2" >
                <label for="activate"><?=translate_phrase('Security Fee'); ?></label>
                <input type="password" class="form-control" name="password"> 
            </div>
        </div>
        <button type="button" class="mt-3 mb-2 btn-block btn btn-success " id="start_scan"><i class="icon ni ni-card"></i> <span class="fw-200 text-white"><?=translate_phrase('Make Payment'); ?></span></button>
    </div>
    
<?=form_close();?>
<?php } ?>
<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>
