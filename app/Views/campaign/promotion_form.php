
<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>
<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
    <!-- delete view -->
    <?php if($param2 == 'delete') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <h3><b><?=translate_phrase('Are you sure?');?></b></h3>
                <input type="hidden" name="d_promotion_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="ri-delete-bin-4-line"></i> <?=translate_phrase('Yes - Delete');?>
                </button>
            </div>
        </div>
    <?php } ?>

    <!-- insert/edit view -->
    <?php if($param2 == 'edit' || $param2 == '') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        
        <div class="row">
            <input type="hidden" name="promotion_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
            
            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="activate"><?=translate_phrase('Name');?></label>
                    <input type="text" name="name" class="form-control" id="name" value="<?php if(!empty($e_name)){echo $e_name;} ?>" required>
                </div>
            </div>
            
            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="activate"><?=translate_phrase('Start Date');?></label>
                    <input type="datetime-local" class="form-control" name="start_date" id="start_date" required value="<?php if(!empty($e_start_date)){echo $e_start_date;} ?>">
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="activate"><?=translate_phrase('End Date');?></label>
                    <input type="datetime-local" class="form-control" name="end_date" id="end_date" required value="<?php if(!empty($e_end_date)){echo $e_end_date;} ?>">
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="activate"><?=translate_phrase('Least Amount/Transaction');?></label>
                    <input type="text" class="form-control" name="min_amount" id="min_amount" oninput="this.value=this.value.replace(/\D/g,'')" required value="<?php if(!empty($e_min_amount)){echo $e_min_amount;} ?>">
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="activate"><?=translate_phrase('Least Total Transaction');?></label>
                    <input type="text" class="form-control" name="min_total" id="min_total" oninput="this.value=this.value.replace(/\D/g,'')" required value="<?php if(!empty($e_min_total)){echo $e_min_total;} ?>">
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="activate"> <?=translate_phrase('Duration (Days)');?></label>
                    <input type="number" class="form-control" name="duration" id="duration" required value="<?php if(!empty($e_duration)){echo $e_duration;} ?>">
                </div>
            </div>
           <div class="col-sm-12 mb-3">
                <div class="form-group">
                    <label for="activate"><?=translate_phrase('Description');?></label>
                    <textarea class="form-control" id="description" name="description"><?php if(!empty($e_description)){echo $e_description;} ?></textarea>
                </div>
            </div>

            <div class="col-sm-12 mb-3">
                <div class="form-group">
                    <label for="activate"><?=translate_phrase('Status');?></label>
                    <select class="form-select" name="status" id="status">
                        <option value="0" <?php if(empty($status)){if($status == 0){echo 'selected';}} ?>><?=translate_phrase('Not Active');?></option>
                        <option value="1" <?php if(!empty($status)){if($status == 1){echo 'selected';}} ?>><?=translate_phrase('Active');?></option>
                    </select>
                </div>
            </div>
            

            <div class="col-sm-12 text-center">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="ri-save-line"></i> <?=translate_phrase('Save Record');?>
                </button>
            </div>
        </div>
    <?php } ?>
<?php echo form_close(); ?>
<script>
    $('.js-select2').select2();
   
   

</script>
<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>