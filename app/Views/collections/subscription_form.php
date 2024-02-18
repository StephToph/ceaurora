
<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>

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
                                    <span class="sub-text"><?php echo $gender; ?></span>
                                    
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
        
        
        <div class="col-sm-12 mb-3">
            <div style="background-color:#eee; padding: 15px;">
                <b class="text-muted"><?=translate_phrase('SUBSCRIPTION INFORMATION'); ?></b>
                <hr/>
                <div class="row">
                    <div class="col-sm-4 mb-2">
                        <div class="text-muted"><?=translate_phrase('Subscription Plan'); ?></div>
                        <?php echo $e_sub_plan; ?>
                    </div>
                    <div class="col-sm-4 mb-2 text-info">
                        <div class="text-muted"><?=translate_phrase('Price');?></div>
                        <b><?php echo curr.number_format($e_price,2); ?></b>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <div class="text-muted"><?=translate_phrase('Payment Duration'); ?></div>
                        <?php  echo $e_duration;?>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <div class="text-muted"><?=translate_phrase('Price/Payment Duration'); ?></div>
                        <?php  echo curr.number_format($e_price_duration,2);?>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <div class="text-muted"><?=translate_phrase('Payment Type'); ?></div>
                        <?php echo ucwords($e_pay_type); ?>
                    </div>
                    <?php if($e_sub_plan=='Family' && $e_family_no > 0){?>
                        <div class="col-sm-4 mb-2">
                            <div class="text-muted"><?=translate_phrase('Number of Family'); ?></div>
                            <?php echo ucwords($e_family_no); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <?php 
            if($e_family_no > 0 && !empty($e_family_info)){
                $fam = json_decode($e_family_info);
                for($i=0; $i < $e_family_no;$i++){
        ?>
            <div class="col-sm-12 mb-3">
                <div style="background-color:#fcfcfc; padding: 15px;">
                    <b class="text-muted"><?=translate_phrase('FAMILY MEMBER '.($i +1)); ?></b>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-8 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="user-card">       
                                    <?php
                                        $img_id = $this->Crud->read_field('id', $e_user_id, 'user', 'img_id');
                                        $img = $fam[$i]->passport;
                                        if(!file_exists($img)) $img = 'assets/images/avatar.png';
                                        $fullname = $fam[$i]->name;
                                        $middle_name = $fam[$i]->middle;
                                        $email = $fam[$i]->email;
                                        $dob = $fam[$i]->dob;
                                        $phone = $fam[$i]->phone;
                                        $gender = $fam[$i]->gender;
                                        
                                    ?>    
                                    <div class="user-info">      
                                        <span class="lead-text"><?php echo strtoupper($fullname.' '.$middle_name); ?></span>  
                                        <span class="sub-text"><?php echo $gender; ?></span>
                                        
                                        <?php echo $email; ?>
                                        <div class="text-muted"><?php echo $phone; ?></div>
                                        <div class="text-muted"><?php echo date('d F Y', strtotime($dob)); ?></div>
                                    </div>    
                                </div> 
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <img alt="profile" height="" src="<?php echo site_url($img); ?>" /> 
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
                        <option value="0"><?=translate_phrase('Pending');?></option>
                        <option value="1"><?=translate_phrase('Approve');?></option>
                    </select>
                </div>
                <div class="col-12 col-sm-4">
                    <button class="btn btn-primary bb_form_btn" type="submit" onclick="update_sub();">
                        <i class="icon ni ni-save"></i> <?=translate_phrase('Update Status');?>
                    </button>
                </div>
            </div>
            <?php } ?>
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
                        <td><b><?=translate_phrase('PAID DATE');?></b></td>
                        <td class="text-right" width=""><b><?=translate_phrase('Remark');?></b></td>
                        <td class="text-right" width=""><b><?=translate_phrase('PRICE');?> (<?php echo curr; ?>)</b></td>
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

<script>
    function update_sub(){
        var status = $('#status').val();
        var id = $('#ids').val();
        $.ajax({
            url: site_url + 'collections/subscription/update',
            type: 'post',
            data: { id: id,status: status},
            success: function (data) {
                $('#bb_ajax_msg').html(data);
               
            }
        });
    }
</script>