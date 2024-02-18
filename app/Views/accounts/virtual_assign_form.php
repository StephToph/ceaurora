
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
                <input type="hidden" name="d_customer_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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
            <input type="hidden" name="user_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
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

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="activate"><?=translate_phrase('Ban');?></label>
                    <select class="form-control js-select2" data-toggle="select2" id="ban" name="ban" required>
                        <option value="1" <?php if(!empty($e_activate)){if($e_activate == 1){echo 'selected';}} ?>><?=translate_phrase('No');?></option>
                        <option value="0" <?php if(empty($e_activate)){if($e_activate == 0){echo 'selected';}} ?>><?=translate_phrase('Yes');?></option>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label">Trade/Business Type <span class="text-danger">*</span></label>
                    </div>
                    <div class="form-control-group">
                        <select class="form-control form-control-lg js-select2" id="trade" data-search="on" name="trade"  required>
                            <option value="0"><?=translate_phrase('--Select Trade Type--'); ?></option>
                            <?php
                                $country = $this->Crud->read_order('trade', 'name', 'asc');
                                if(!empty($country)){
                                    foreach($country as $c){
                                        $sels = '';
                                        // if($sel == $c->id)$sels = 'selected';
                                        if(!empty($e_trade))if($e_trade == $c->id)$sels='selected';
                                        echo '<option value="'.$c->id.'" '.$sels.'>'.$c->name.'</option>';
                                    }
                                } 
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group" id="">
                    <label for="activate"><?=translate_phrase('Role');?></label>
                    <select class="form-select js-select2" data-search="on" id="role" name="role">
                        <option value=" "><?=translate_phrase('Select');?></option>
                        <?php $cat = $this->Crud->read_single_order('name!=', 'Developer', 'access_role', 'name', 'asc');
                            foreach ($cat as $ca) {
                                // if($ca->name == 'Administrator') continue;
                                if($role == 'manager' && $ca->name == 'Manager') continue;
                                ?>
                                <option value="<?=$ca->id;?>" <?php if(!empty($e_role_id)){if($e_role_id == $ca->id){echo 'selected';}} ?>><?=ucwords($ca->name); ?></option>
                            <?php }?>
                    </select>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="activate"><?=translate_phrase('Reset Password');?></label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            </div>
           

            <div class="col-sm-12 text-center mt-3">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="ri-save-line"></i> <?=translate_phrase('Save Record');?>
                </button>
            </div>
        </div>
    <?php } ?>

    <!-- insert/edit view -->
    <?php if($param2 == 'generate') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Number of Tax ID'); ?></label>
                    <input class="form-control" type="number" id="tax_no" name="tax_no" required>
                </div>
            </div>

            <div class="col-sm-12 text-center mt-5">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="icon ni ni-save"></i> <?=translate_phrase('Generate');?>
                </button>
            </div>
        </div>
    <?php } ?>

    <!-- insert/edit view -->
    <?php if($param2 == 'assign') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>
        <input type="hidden" name="virtual_id" value="<?=$param3; ?>">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Unassgined User'); ?></label>
                    <select class="js-select2" name="user_id" required>
                        <option value="">--Select--</option>
                        <?php
                            $user = $this->Crud->read_order('user', 'fullname', 'asc');
                            if(!empty($user)){
                                foreach($user as $u){
                                    if($this->Crud->check('user_id', $u->id, 'virtual_account') == 0){
                                        echo '<option value="'.$u->id.'">'.ucwords($u->fullname).'</option>';
                                    }
                                }
                            }
                        ?>
                    </select> 
                </div>
            </div>

            <div class="col-sm-12 text-center mt-5">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="icon ni ni-save"></i> <?=translate_phrase('Assign');?>
                </button>
            </div>
        </div>
    <?php } ?>
<?php echo form_close(); ?>
<script>
    $('.js-select2').select2();
   
    function statea() {
        var country = $('#country_id').val();
        $.ajax({
            url: '<?=site_url('accounts/get_state/');?>'+ country,
            success: function(data) {
                $('#state_resp').html(data);
            }
        });
        
    }

    function lgaa() {
        var lga = $('#state').val();
        $.ajax({
            url: '<?=site_url('accounts/get_lga/');?>'+ lga,
            success: function(data) {
                $('#lga_resp').html(data);
            }
        });
    }

    function branc() {
        var lgas = $('#lga').val();
        $.ajax({
            url: '<?=site_url('accounts/get_branch/');?>'+ lgas,
            success: function(data) {
                $('#branch_resp').html(data);
            }
        });
    }

</script>
<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script