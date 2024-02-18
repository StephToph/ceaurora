<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>
<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
    <!-- delete view -->
    <?php if($param2 == 'personal') { ?>
        <div id="bb_ajax_msg"></div>
        <div class="row">
            <div class="mb-2 col-md-4">
                <label for="img-upload" class="pointer text-center" style="width:100%;">
                    <input type="hidden" name="img_id" value="<?php if(!empty($img_id)){echo $img_id;} ?>" />
                    <img id="img0" src="<?php if(!empty($img_id) && file_exists($img_id)){echo site_url($img_id);} else {echo site_url('assets/images/avatar.png');} ?>" style="max-width:100%;" />
                    <span class="btn btn-default btn-block no-mrg-btm d-grid btn btn-secondary waves-effect"><i class="mdi mdi-cloud-upload me-1"></i><?=translate_phrase('Choose Image'); ?></span>
                    <input class="d-none" type="file" name="pics" id="img-upload">
                </label>
            </div>
            <div class="mb-2 col-md-8">
                <div class="row">
                    
                    <div class="mb-2 col-md-12">
                        <label for="country_id" class="form-label"><?=translate_phrase('LGA');?></label>
                        <?php $countries = $this->Crud->read_single_order('state_id', 316, 'city', 'name', 'asc'); ?>
                        <select class="form-control select2"  name="lga_id" id="lga_id" required>
                            <option value=""><?=translate_phrase('Select LGA'); ?></option>
                            <?php
                                if(!empty($countries)) {
                                    foreach($countries as $c) {
                                        $c_sel = '';
                                        if(!empty($lga_id)) if($lga_id == $c->id) $c_sel = 'selected';
                                        echo '<option value="'.$c->id.'" '.$c_sel.'>'.$c->name.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-2 col-md-12">
                        <label for="phone" class="form-label"><?=translate_phrase('Address'); ?></label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="<?=translate_phrase('Address'); ?>" value="<?=$address;?>">
                    </div>
                    <div class="mb-2 col-md-12">
                        <label for="phone" class="form-label"><?=translate_phrase('Reset Password'); ?></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" align="center">
                <button type="submit" class="btn btn-primary bb_form_bn"><?=translate_phrase('Update Profile'); ?></button>
            </div>
        </div>
    <?php } ?>
    <?php if($param2 == 'bank') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>
        <div class="row">
            <div class="col-sm-12 mb-2">
                <div class="form-group">
                    <label for="email"><?=translate_phrase('Bank Account'); ?></label>
                    <?php $countries = $this->Crud->read_order('bank', 'name', 'asc'); ?>
                    <select class="form-control select2"  name="bank" id="bank" required onchange="validate_account();">
                        <option value=""><?=translate_phrase('Select') ;?></option>
                        <?php
                            if(!empty($countries)) {
                                foreach($countries as $c) {
                                    $c_sel = '';
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
                        <input type="text" class="form-control" id="account" name="account" maxlength="10" minlength="10"  oninput="validate_account();">
                    </div>
                </div>
            </div>
        
            <div class="col-sm-12" id="account_resp">
                
            </div>
            <div class="col-sm-12 text-center">
                <hr />
                <button id="btn" class="btn btn-primary bb_form_btn" type="submit" >
                    <i class="anticon anticon-wallet"></i> <?=translate_phrase('Submit'); ?>
                </button>
            </div>
        </div>
    <?php } ?>
    
<?php echo form_close(); ?>
    <script src="<?=site_url();?>assets/js/jsform.js"></script>
    <script>
        var site_url = '<?=site_url();?>';
        $('.select2').select2();

        <?php if($param2 == 'personal'){ ?>
            $(function() {
                get_state();
            });

            function get_state() {
                $('#state_id').html('');
                var country_id = $('#country_id').val();
                var state_id = '<?=$state_id;?>';
                $.ajax({
                    url: site_url + 'auth/get_state/' + country_id + '?state_id=' + state_id,
                    success: function(data) {
                        $('#state_id').html(data);
                    }
                });
            }
        <?php } ?>
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
    </script>