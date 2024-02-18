
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
                <h3><b>Are you sure?</b></h3>
                <input type="hidden" name="d_branch_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="ri-delete-bin-4-line"></i> Yes - Delete
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
            <input type="hidden" name="branch_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
            
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="activate">Name</label>
                    <input type="text" class="form-control" name="name" id="name" required value="<?php if(!empty($e_name)){echo $e_name;} ?>">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="activate">Address</label>
                    <input type="text" class="form-control" name="address" id="address" required value="<?php if(!empty($e_address)){echo $e_address;} ?>">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="activate">Country</label>
                    <select class="form-select js-select2" data-search="on" id="country_id" name="country_id" onchange="statea();">
                        <option value=" ">Select</option>
                        <?php $cat = $this->Crud->read_order('country', 'name', 'asc');foreach ($cat as $ca) {?>
                                <option value="<?=$ca->id;?>" <?php if(!empty($e_country_id)){if($e_country_id == $ca->id){echo 'selected';}} ?>><?=ucwords($ca->name); ?></option>
                            <?php }?>
                    </select>
                </div>
            </div>
            <?php if(!empty($e_state_id)) {?>
                <div class="col-sm-12">
                    <div class="form-group" id="state_resp">
                        <label for="activate">State</label>
                        <select class="form-select js-select2" data-search="on" id="state" name="state" onchange="lgaa();">
                            <option value=" ">Select</option>
                            <?php $cat = $this->Crud->read_single_order('country_id', $e_country_id, 'state', 'name', 'asc');foreach ($cat as $ca) {?>
                                    <option value="<?=$ca->id;?>" <?php if(!empty($e_state_id)){if($e_state_id == $ca->id){echo 'selected';}} ?>><?=ucwords($ca->name); ?></option>
                                <?php }?>
                        </select>
                    </div>
                </div>
            <?php } else {?>
                <div class="col-sm-12">
                    <div class="form-group" id="state_resp">
                        <label for="activate">State</label>
                        <input type="text" class="form-control" name="state" id="state" readonly placeholder="Select Country First">
                    </div>
                </div>
            <?php } ?>

            <?php if(!empty($e_city_id)) {?>
                <div class="col-sm-12">
                    <div class="form-group" id="lga_resp">
                        <label for="activate">Local Goverment Area</label>
                        <select class="form-select js-select2" data-search="on" id="lga" name="lga">
                            <option value=" ">Select</option>
                            <?php $cat = $this->Crud->read_single_order('state_id', $e_state_id, 'city', 'name', 'asc');foreach ($cat as $ca) {?>
                                    <option value="<?=$ca->id;?>" <?php if(!empty($e_city_id)){if($e_city_id == $ca->id){echo 'selected';}} ?>><?=ucwords($ca->name); ?></option>
                                <?php }?>
                        </select>
                    </div>
                </div>
            <?php } else {?>
                <div class="col-sm-12">
                    <div class="form-group" id="lga_resp">
                        <label for="activate">Local Goverment Area</label>
                        <input type="text" class="form-control" name="lga" id="lga" readonly placeholder="Select State First">
                    </div>
                </div>
            <?php } ?>

            <div class="col-sm-12 text-center">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="ri-save-line"></i> Save Record
                </button>
            </div>
        </div>
    <?php } ?>

    <?php if($param2 == 'account') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        
        <div class="row">
            <input type="hidden" name="branch_id" value="<?php if(!empty($param3)){echo $param3;} ?>" />
            
            
            
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="activate">Bank Name</label>
                    <select class="form-select js-select2" data-search="on" id="bank_id" name="bank_id" onchange="statea();">
                        <option value=" ">Select</option>
                        <?php $cat = $this->Crud->read_order('bank', 'name', 'asc');foreach ($cat as $ca) {?>
                                <option value="<?=$ca->code;?>" <?php if(!empty($e_bank)){if($e_bank == $ca->code){echo 'selected';}} ?>><?=ucwords($ca->name); ?></option>
                            <?php }?>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="activate">Account Number</label>
                    <input type="text" class="form-control" name="account" id="account" minlength="10" maxlength="10" required value="<?php if(!empty($e_account)){echo $e_account;} ?>">
                </div>
            </div>

            <div class="col-sm-12 text-center">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="ri-save-line"></i> Save Record
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

</script>
<script src="<?php echo site_url(); ?>assets/backend/js/jsform.js"></script>
<script src="<?php echo site_url(); ?>assets/backend/js/scripts.js"></>