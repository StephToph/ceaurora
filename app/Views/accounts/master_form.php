
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
                <input type="hidden" name="d_master_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="icon ni ni-trash"></i> <?=translate_phrase('Yes - Delete'); ?>
                </button>
            </div>
        </div>
    <?php } ?>

    <!-- insert/edit view -->
    <?php if($param2 == 'edit' || $param2 == '') { ?>
       
        
        <div class="row">
            <input type="hidden" name="master_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
            
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Full Name'); ?></label>
                    <input class="form-control" type="text" id="name" name="name" value="<?php if(!empty($e_fullname)) {echo $e_fullname;} ?>" required>
                </div>
            </div>

            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Email');?></label>
                    <input class="form-control" type="text" id="email" name="email" value="<?php if(!empty($e_email)) {echo $e_email;} ?>" required>
                </div>
            </div>

            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Phone');?></label>
                    <input class="form-control" type="text" id="phone" name="phone" value="<?php if(!empty($e_phone)) {echo $e_phone;} ?>" required>
                </div>
            </div>

            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('LGA');?></label>
                    <?php $country_id = 316; $states = $this->Crud->read_single_order('state_id', $country_id, 'city', 'name', 'asc'); ?>
                    <select id="lga_id" name="lga_id" class="js-select2" required  data-search="on" onchange="get_territory();">
                        <option value="0" selected><?=translate_phrase('All LGA'); ?>...</option>
                        <?php 
                            foreach($states as $s) {
                                $s_sel = '';
                                if(!empty($e_lga_id)) {
                                    if($e_lga_id == $s->id) { $s_sel = 'selected'; }
                                }
                                echo '<option value="'.$s->id.'" '.$s_sel.'>'.$s->name.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>

            <?php if(!empty($e_territory)){?>
                <div class="col-sm-6 mb-3">
                    <div class="form-group">
                        <label for="name">*<?=translate_phrase('Territory');?></label>
                        <?php $country_id = 316; $states = $this->Crud->read_order('territory', 'name', 'asc'); ?>
                        <select id="territorys" name="territory[]" multiple class="js-select2" required  data-search="on" >
                            <?php 
                                foreach($states as $s) {
                                    $s_sel = '';
                                    if(!empty($e_territory) && is_array(json_decode($e_territory))) {
                                        if(in_array($s->id, json_decode($e_territory))) { $s_sel = 'selected'; }
                                    }
                                    echo '<option value="'.$s->id.'" '.$s_sel.'>'.$s->name.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            
            <?php } else{?>
                <div class="col-sm-6 mb-3">
                    <div class="form-group" id="">
                        <label for="activate"><?=translate_phrase('Territory');?></label>
                        <select class="form-select js-select2" data-search="on" multiple id="territorys" name="territory[]" required>
                            
                        </select>
                    </div>
                </div>
            <?php } ?>
            
            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="activate"><?=translate_phrase('Ban');?></label>
                    <select class="form-control js-select2" data-toggle="select2" id="ban" name="ban" required>
                        <option value="1" <?php if(!empty($e_activate)){if($e_activate == 1){echo 'selected';}} ?>><?=translate_phrase('No');?></option>
                        <option value="0" <?php if(!empty($e_activate)){if($e_activate == 0){echo 'selected';}} ?>><?=translate_phrase('Yes');?></option>
                    </select>
                </div>
            </div>

           
            
            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="password"><?php if($param2 ==''){echo translate_phrase('Password');}else{echo translate_phrase('Reset Password');}?></label>
                    <input class="form-control" type="text" id="password" name="password">
                </div>
            </div> 
            
            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Passport Photograph');?></label>
                    <label for="img-upload" class="pointer text-center" style="width:100%;">
                        <input type="hidden" name="passport" value="<?php if(!empty($e_passport)){echo $e_passport;} ?>" />
                        <img id="img0" src="<?php if(!empty($e_passport)){echo site_url($e_passport);}?>" style="max-width:100%;" />
                        <span class="btn btn-default btn-block no-mrg-btm d-grid btn btn-secondary waves-effect"><i class="mdi mdi-cloud-upload me-1"></i><?=translate_phrase('Upload Passport'); ?></span>
                        <input class="d-none" type="file" name="passports" id="img-upload" >
                    </label>
                </div>
            </div> 
           
            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Valid ID Card');?></label>
                    <label for="img-upload1" class="pointer text-center" style="width:100%;">
                        <input type="hidden" name="id_card" value="<?php if(!empty($e_id_card)){echo $e_id_card;} ?>" />
                        <img id="img1" src="<?php if(!empty($e_id_card)){echo site_url($e_id_card);}?>" style="max-width:100%;" />
                        <span class="btn btn-default btn-block no-mrg-btm d-grid btn btn-secondary waves-effect"><i class="mdi mdi-cloud-upload me-1"></i><?=translate_phrase('Upload ID Card'); ?></span>
                        <input class="d-none" type="file"  name="id_cards" id="img-upload1">
                    </label>
                </div>
            </div> 
           
            <div class="col-sm-6 mb-3">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Utility Bill');?></label>
                    <label for="img-upload2" class="pointer text-center" style="width:100%;">
                        <input type="hidden" name="utility" value="<?php if(!empty($e_utility)){echo $e_utility;} ?>" />
                        <img id="img2" src="<?php if(!empty($e_utility)){echo site_url($e_utility);}?>" style="max-width:100%;" />
                        <span class="btn btn-default btn-block no-mrg-btm d-grid btn btn-secondary waves-effect"><i class="mdi mdi-cloud-upload me-1"></i><?=translate_phrase('Upload Utility Bill'); ?></span>
                        <input class="d-none" type="file" name="utilitys" id="img-upload2">
                    </label>
                </div>
            </div> 

            <div class="col-sm-6 mb-3">
                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="form-group">
                            <label for="email"><?=translate_phrase('Bank Account'); ?></label>
                            <?php $countries = $this->Crud->read_order('bank', 'name', 'asc'); ?>
                            <select class="form-control js-select2" data-search="on"  name="bank" id="bank" required onchange="validate_account();">
                                <option value=""><?=translate_phrase('Select') ;?></option>
                                <?php
                                    if(!empty($countries)) {
                                        foreach($countries as $c) {
                                            $c_sel = '';
                                            if(!empty($e_bank_code)) {if($e_bank_code == $c->code){$c_sel = 'selected';}} 
                                            echo '<option value="'.$c->code.'" '.$c_sel.'>'.$c->name.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="email"><?=translate_phrase('Account Number'); ?></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="account" name="account" maxlength="10" minlength="10"  oninput="validate_account();"  value="<?php if(!empty($e_account)) {echo $e_account;} ?>">
                            </div>
                        </div>
                    </div>
                
                    <div class="col-sm-12" id="account_resp">
                        <?php
                            if(!empty($e_account_name)){
                                echo '<h5>'.$e_account_name.'</h5><input type="hidden" name="account_name" value="'.$e_account_name.'">';
                                
                            }?>
                    </div>
                            

                </div>

            </div>
           
            

            <div class="col-sm-12 mt-3 text-center">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="icon ni ni-save"></i> <?=translate_phrase('Save Record');?>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 mt-4"><div id="bb_ajax_msg"></div></div>
        </div>

    <?php } ?>
<?php echo form_close(); ?>
<script>
    $('.js-select2').select2();
   
                        
    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                if(id != 'vid') {
                    $('#' + id).attr('src', e.target.result);
                } else {
                    $('#' + id).show(500);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#img-upload").change(function(){
        readURL(this, 'img0');
    });
    $("#img-upload1").change(function(){
        readURL(this, 'img1');
    });
    $("#img-upload2").change(function(){
        readURL(this, 'img2');
    });

    function validate_account(){
        var bank = $('#bank').val();
        var account = $('#account').val();

        if(bank !== '' && account.length == 10){
            $('#account_resp').html('<div class="spinner-border" role="status">  <span class="visually-hidden">Loading...</span></div>');
            $.ajax({
                url: site_url + 'auth/validate_account/' + account + '/'+ bank,
                success: function(data) {
                    $('#account_resp').html(data);
                    $('#btn').prop('disabled', false);
                }
            });
        }
        
    }

    function get_territory(){
        var lga_id = $('#lga_id').val();
        $.ajax({
            url: site_url + 'accounts/get_territory/' + lga_id,
            success: function(data) {
                $('#territorys').html(data);
            }
        });
        
    }
</script>
<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>