
<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>
<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
  

<!-- insert/edit view -->
<?php if($param1 == 'view') { ?>
    
    <div class="row">
        <div  class="col-12 col-sm-8 mb-5" id="pdf_load"></div>
        <div class="col-12 col-sm-4 mb-3">
            <button class="btn btn-primary" type="button" onclick="getPDF();">
                <i class="icon ni ni-download"></i> <?=translate_phrase('Print Form'); ?>
            </button>
        </div>
    </div>
    <div class="row canvas_div_pdf">
        <input type="hidden" name="id" id="ids" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
        <input type="hidden" name="info" id="info" value="<?php if(!empty($e_environment_info)){echo $e_environment_info;} ?>" />

        <div class="col-12 col-sm-8 mb-3">
            <div style="background-color:#eee; padding: 15px;">
                <div class="text-muted"><?php echo $e_reg_date; ?></div>
                <div style="font-size:20px; font-weight:bold;"><?php echo $e_code; ?></div>
            </div>
        </div>

        <div class="col-12 col-sm-4 mb-3 float-right" align="right">
            
        </div>
        
        
        <!-- Customer -->
        <div class="col-sm-12 mb-3">
            <div style="background-color:#fcfcfc; padding: 15px;">
                <b class="text-muted"><?=translate_phrase('USER'); ?></b>
                <hr/>
                <div class="row">
                    <div class="col-sm-8 mb-2">
                        <div class="d-flex align-items-center">
                            <div class="user-card">       
                                <?php
                                    $img_id = $this->Crud->read_field('id', $e_user_id, 'user', 'img_id');
                                    $img = $this->Crud->image($img_id);
                                    $fullname = $this->Crud->read_field('id', $e_user_id, 'user','fullname');
                                    $middle_name = $this->Crud->read_field('id', $e_user_id, 'user','middle_name');
                                    $email = $this->Crud->read_field('id', $e_user_id, 'user','email');
                                    $dob = $this->Crud->read_field('id', $e_user_id, 'user','dob');
                                    $phone = $this->Crud->read_field('id', $e_user_id, 'user','phone');
                                    $gender = $this->Crud->read_field('id', $e_user_id, 'user','gender');
                                    
                                ?>    
                                <div class="user-info">      
                                    <span class="lead-text"><?php echo $fullname.' '.$middle_name; ?></span>  
                                    <span class="sub-text"><?php echo translate_phrase($gender); ?></span>
                                    
                                    <?php echo $email; ?>
                                    <div class="text-muted"><?php echo $phone; ?></div>
                                    <div class="text-muted"><?php echo date('d F Y', strtotime($dob)); ?></div>
                                </div>    
                            </div> 
                        </div>
                    </div>

                    <div class="col-sm-4 mb-2">
                        <img alt="profile" height="" src="<?php echo site_url($img); ?>" /> 
                    </div>
                </div>
               
            </div>
        </div>
        
        
        
        
        <?php 
            if($e_address_no > 0 && !empty($e_environment_info)){
                $fam = json_decode($e_environment_info);
                for($i=0; $i < $e_address_no;$i++){
        ?>
            <div class="col-sm-12 mb-3">
                <div style="background-color:#fdfcfa; padding: 15px;">
                    <b class="text-muted"><?translate_phrase('LOCATION'); ?> <?=$i +1; ?></b>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="user-card">       
                                    <?php
                                        $state_id = $fam[$i]->state_id;
                                        $city_id = $fam[$i]->city_id;
                                        $address = $fam[$i]->address;
                                        $address_type = $fam[$i]->address_type;
                                        $price = $fam[$i]->price;
                                        $name = $fam[$i]->name;
                                        $phone = $fam[$i]->phone;
                                        $status = $fam[$i]->status;
                                        $duration = $fam[$i]->duration;
                                        $price_duration = $fam[$i]->price_duration;
                                        $pay_type = $fam[$i]->pay_type;
                                        $bin_request = $fam[$i]->bin_request;
                                        
                                        $state = $this->Crud->read_field('id', $state_id, 'state', 'name');
                                        $city = $this->Crud->read_field('id', $city_id, 'city', 'name');
                                        
                                        $sta = '<span class="text-danger">'.translate_phrase('Not Approved').'</span>';
                                        if($status > 0)$sta = '<span class="text-success">'.translate_phrase('Approved').'</span>';

                                        $bin = '<span class="text-danger">'.translate_phrase('Not Requested').'</span>';
                                        if($bin_request > 0)$bin = '<span class="text-success">'.translate_phrase('Requested').'</span>';
                                    ?>    
                                    <div class="user-info">      
                                        <span class="lead-text">State: <?php echo strtoupper($state.', '.$city); ?></span>  
                                        <span class="sub-text text-dark"><?=translate_phrase('Address'); ?>: <?php echo $address; ?></span>
                                        
                                        <span class="text-info"><?=translate_phrase('Contact Person'); ?>: <b><?php echo ucwords($name).'</b> '.$phone; ?></span>
                                    </div>    
                                </div> 
                            </div>
                        </div>

                        <div class="col-sm-6 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="user-card">
                                    <div class="user-info">      
                                        <span class="lead-text"><?=translate_phrase('Address Type'); ?>: <?php echo strtoupper($address_type); ?></span>  
                                        <span class="sub-text text-dark"><?=translate_phrase('Price'); ?>: <?php echo curr. $price; ?></span>
                                        
                                        <?php echo 'Paying '. $duration; ?>
                                        <div class="text-muted"><?=translate_phrase('Price/Duration'); ?>: <?php echo curr.$price_duration; ?></div>
                                        <div class="text-muted"><?=translate_phrase('Payment Type'); ?>: <?php echo $pay_type; ?></div>
                                        <div class="text-muted"><?=translate_phrase('Bin Request'); ?>: <?php echo $bin; ?></div>
                                    </div>    
                                </div> 
                            </div>   
                        </div>
                    </div>
                
                </div>
            </div>
        <?php } }?>
        
        
        <?php if($e_status > 0){?>
        <!-- Pricing -->
        <div class="col-sm-12">
            <b class="text-muted"><?=translate_phrase('Subscription History'); ?></b>
            <table class="table table-response table-striped">
                <thead>
                    <tr>
                        <td><b><?=translate_phrase('DATE'); ?></b></td>
                        <td class="text-right" width="125px"><b><?=translate_phrase('PLAN'); ?></b></td>
                        <td class="text-right" width="125px"><b><?=translate_phrase('PRICE'); ?> (<?php echo curr; ?>)</b></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>-</td>
                        <td class="text-right">-</td>
                        <td class="text-right">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php } ?>
        <hr>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>
        <?php if($e_status == 0){?>
            <div class="row">
                <h3 class="col-sm-12 text-center mb-3"><?=translate_phrase('Update Subscription Status'); ?></h3>
                <div class="col-12 col-sm-8 mb-3">
                    <select name="status" class="form-select js-select2" id="status" data-search="on">
                        <option value="0"><?=translate_phrase('Pending'); ?></option>
                        <option value="1"><?=translate_phrase('Approve'); ?></option>
                    </select>
                </div>
                <div class="col-12 col-sm-4">
                    <button class="btn btn-primary bb_form_btn" type="submit" onclick="update_sub();">
                        <i class="icon ni ni-save"></i><?=translate_phrase('Update Status'); ?>
                    </button>
                </div>
            </div>
            <?php } ?>
        </div>
        
    </div>
    
<?php } ?>

<?php if($param1 == 'pay' && $param2 != 'bin') { ?>
    <div class="row">
        <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
    </div>

    <div class="row">
        <div class="col-sm-12  mb-2">

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=translate_phrase('Name'); ?></th>
                            <th ></th>
                        </tr>
                    </thead>
                    <?php $info = json_decode($e_environment_info); ?>
                    <tbody>
                        <tr>
                            <td><?=translate_phrase('Address Type'); ?></td>
                            <th ><?=ucwords($info[$param3]->address_type); ?> Address</th>
                        </tr>  
                        <tr>
                            <td>Price (<?=$info[$param3]->duration; ?>)</td>
                            <th ><?=curr.number_format($info[$param3]->price_duration,2); ?> </th>
                        </tr>  
                        <tr>
                            <td><?=translate_phrase('Payment Date'); ?></td>
                            <th ><?=date('d F Y',strtotime($e_cur_date)); ?> </th>
                        </tr>    
                    </tbody>
                </table>
            </div>
            <input type="hidden" name="environment_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
            <input type="hidden" name="address_no" value="<?php echo $param3; ?>" />
            <input type="hidden" name="pay_date" value="<?php if(!empty($e_cur_date)){echo $e_cur_date;} ?>" />
            
            <input type="hidden" name="price_duration" value="<?php if(!empty($info[$param3]->price_duration)){echo $info[$param3]->price_duration;} ?>" />
            <div class="mb-2 col-sm-12">
                <div  class="form-group mb-2" >
                    <label for="activate"><?=translate_phrase('Security Pin'); ?></label>
                    <input type="password" class="form-control" name="pin" id="pin" required> 
                </div>
            </div>
    
        </div>
        
        <div class="col-sm-12 text-center">
            <button class="btn btn-success text-uppercase" type="submit">
                <i class="ni ni-check-circle-cut"></i> <?=translate_phrase('Make Payment'); ?>
            </button>
        </div>
    </div>
<?php } ?>

<?php if($param2 == 'bin') { ?>
    <div class="row">
        <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
    </div>

    <div class="row">
        <div class="col-sm-12 mb-3 text-center">
            <h3><b><?=translate_phrase('You are about to make payment of N15,000 for Bin Basket for Address Location');?> <?=($param4 +1); ?></b></h3>
            <input type="hidden" name="environment_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
            <input type="hidden" name="address_no" value="<?php echo $param4; ?>" />
            <input type="hidden" name="pay_date" value="<?php if(!empty($e_cur_date)){echo $e_cur_date;} ?>" />
            
            <input type="hidden" name="price" value="15000" />
        </div>
        <div class="mb-2 col-sm-12">
            <div  class="form-group mb-2" >
                <label for="activate"><?=translate_phrase('Security Pin'); ?></label>
                <input type="password" class="form-control" name="pin" id="pin" required> 
            </div>
        </div>
        <div class="col-sm-12 text-center">
            <button class="btn btn-success text-uppercase" type="submit">
                <i class="ni ni-check-circle-cut"></i> <?=translate_phrase('Make Payment'); ?>
            </button>
        </div>
    </div>
<?php } ?>

    
<?php if($param1 == 'history') { ?>
    
    <div class="row canvas_div_pdf">
        
        <?php if($e_status > 0){?>
        <!-- Pricing -->
        <div class="col-sm-12">
            <table class="table table-response table-striped">
                <thead>
                    <tr>
                        <td><b><?=translate_phrase('DATE'); ?></b></td>
                        <td class="text-right" width=""><b><?=translate_phrase('Remark'); ?></b></td>
                        <td class="text-right" width=""><b><?=translate_phrase('PRICE'); ?> (<?php echo curr; ?>)</b></td>
                    </tr>
                </thead>
                <tbody>
                    <?=$e_table;?>
                </tbody>
            </table>
        </div>
        <?php } ?>
        
    </div>
    
<?php } ?>

    <?php echo form_close(); ?>
<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>
<script>
    function update_sub(){
        var status = $('#status').val();
        var id = $('#ids').val();
        $.ajax({
            url: site_url + 'collections/environment_sub/update',
            type: 'post',
            data: { id: id,status: status},
            success: function (data) {
                $('#bb_ajax_msg').html(data);
               
            }
        });
    }
</script>
