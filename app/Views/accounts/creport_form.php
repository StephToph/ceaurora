
<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>
<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form2', 'class'=>'')); ?>
    <!-- delete view -->
    <?php if($param2 == 'delete') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg2"></div></div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <h3><b><?=translate_phrase('Are you sure?');?></b></h3>
                <input type="hidden" name="d_cell_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="icon ni ni-trash"></i> <?=translate_phrase('Yes - Delete');?>
                </button>
            </div>
        </div>
    <?php } ?>

    
    <?php if($param2 == 'attendance'){?>
        <?php if(empty($param3)){?>
            <div class="row">
                <div class="col-sm-12 text-danger text-center">Select a Cell First</div>
            </div>
        <?php }else{?>
        <table id="dtable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Member</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $cell_id = $this->Crud->read_field('id', $param3, 'cell_report', 'cell_id');
                    $roles = $this->Crud->read_field('name', 'Member', 'access_role', 'id');

                    $user = $this->Crud->read2('cell_id', $cell_id,'role_id', $roles, 'user');
                    $attends = json_decode($this->Crud->read_field('id', $param3, 'cell_report', 'attendant'));
                    // print_r($attends);
                    if(!empty($user)){
                        foreach($user as $p){
                            $sel = '';
                            if(!empty($attends)){
                                if(in_array($p->id, $attends)){
                                    $sel = 'checked';
                                }
                            }
                           
                            $img = $this->Crud->image($p->img_id, 'big');
                            ?>
                            <tr>
                                <td>
                                    <div class="user-card">
										<div class="user-avatar ">
											<img alt="" src="<?=site_url($img); ?>" height="40px"/>
										</div>
										<div class="user-info">
											<span class="tb-lead"><?=ucwords($p->firstname.' '.$p->surname); ?></span>
										</div>
									</div>
                                </td>
                                <td align="right"> 
                                    <div class="custom-control custom-switch">    
                                        <input type="checkbox" name="mark[]" class="custom-control-input" id="customSwitch<?=$p->id;?>" <?=$sel; ?> value="<?=$p->id;?>">    
                                        <label class="custom-control-label" for="customSwitch<?=$p->id;?>">Mark</label>
                                    </div>
                                    
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2" class="text-center">
                                <button class="btn btn-primary bb_fo_btn" type="submit">
                                    <i class="icon ni ni-save"></i> <?=translate_phrase('Save Record');?>
                                </button>
                            </td>
                        </tr> 
                   <?php } else{ ?>
                    <tr>
                        <td colspan="2">No Member in Cell</td>
                    </tr>
                  <?php  }
                       
                ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg2"></div></div>
        </div>
    <?php }} ?>
    <!-- insert/edit view -->
    <?php if($param2 == 'new_convert') { ?>
        <?php if(empty($param3)){?>
            <div class="row">
                <div class="col-sm-12 text-danger text-center">Select a Cell First</div>
            </div>
        <?php }else{?>
            
            
            <div class="row border mb-3">
                <div class="col-sm-6 mb-3">
                    <div class="form-group">
                        <label for="name">*<?=translate_phrase('First Name'); ?></label>
                        <input class="form-control" type="text" id="first_name" name="first_name[]" required>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="form-group">
                        <label for="name">*<?=translate_phrase('Surname'); ?></label>
                        <input class="form-control" type="text" id="surname" name="surname[]"  required>
                    </div>
                </div>
                <div class="col-sm-4 mb-3">
                    <div class="form-group">
                        <label for="name">*<?=translate_phrase('Email'); ?></label>
                        <input class="form-control" type="email" id="email" name="email[]"  >
                    </div>
                </div>
                <div class="col-sm-4 mb-3">
                    <div class="form-group">
                        <label for="name">*<?=translate_phrase('Phone'); ?></label>
                        <input class="form-control" type="text" id="phone" name="phone[]"  required>
                    </div>
                </div>
                <div class="col-sm-4 mb-3">
                    <div class="form-group">
                        <label for="name">*<?=translate_phrase('Birthday'); ?></label>
                        <input class="form-control" type="date" id="dob" name="dob[]" >
                    </div>
                </div>
                
            </div>
            <div class="col-sm-12 my-3 text-center">
                <button id="addMores" class="btn btn-ico btn-outline-info" type="button"><i class="icon ni ni-plus-c"></i>  <?=translate_phrase('Add More');?></button>
            </div>


            <div class="row" >
            <div class="col-sm-12 text-center mt-3">
                    <button class="btn btn-primary bb_fo_btn" type="submit">
                        <i class="icon ni ni-save"></i> <?=translate_phrase('Save Record');?>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><div id="bb_ajax_msg2"></div></div>
            </div>
    <?php } }?>

     <!-- insert/edit view -->
     <?php if($param2 == 'first_timer') { ?>
        <?php if(empty($param3)){?>
            <div class="row">
                <div class="col-sm-12 text-danger text-center">Select a Cell First</div>
            </div>
        <?php }else{?>
            
            
            <div class="row border mb-3">
                <div class="col-sm-6 mb-3">
                    <div class="form-group">
                        <label for="name">*<?=translate_phrase('First Name'); ?></label>
                        <input class="form-control" type="text" id="first_name" name="first_name[]" required>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="form-group">
                        <label for="name">*<?=translate_phrase('Surname'); ?></label>
                        <input class="form-control" type="text" id="surname" name="surname[]"  required>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="form-group">
                        <label for="name"><?=translate_phrase('Email'); ?></label>
                        <input class="form-control" type="email" id="email" name="email[]"  >
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="form-group">
                        <label for="name">*<?=translate_phrase('Phone'); ?></label>
                        <input class="form-control" type="text" id="phone" name="phone[]"  required>
                    </div>
                </div>
                <div class="col-sm-4 mb-3">
                    <div class="form-group">
                        <label for="name"><?=translate_phrase('Birthday'); ?></label>
                        <input class="form-control" type="date" id="dob" name="dob[]" >
                    </div>
                </div>
                <div class="col-sm-4 mb-3">
                    <div class="form-group">
                        <label for="name">*<?=translate_phrase('Invited By'); ?></label>
                        <select class=" js-select2" name="invited_by[]" required>
                            <option value="">Select</option>
                            <option value="Member">Member</option>
                            <option value="Online">Online</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-4 mb-3" name="channel-div" style="display: none;">
                    <div class="form-group">
                        <label for="name"><?=translate_phrase('Channel'); ?></label>
                        <input class="form-control" type="text" id="channel" name="channel[]" >
                    </div>
                </div>
                <div class="col-sm-4 mb-3" name="member-div" style="display: none;">
                    <div class="form-group">
                        <label for="name"><?=translate_phrase('Member'); ?></label>
                        <select class="js-select2" data-search="on" name="member_id[]">
                            <option value="">Select Member</option>
                            <?php 
                                $roles_id = $this->Crud->read_field('name', 'Member', 'access_role', 'id');
                                $mem = $this->Crud->read_single_order('role_id', $roles_id, 'user', 'firstname', 'asc');
                                    if(!empty($mem)){
                                        foreach($mem as $m){
                                            echo '<option value="'.$m->id.'">'.ucwords($m->firstname.' '.$m->surname).'</option>';
                                        }
                                    }
                            ?>
                        </select>
                    </div>
                </div>
                
            </div>
            <div class="col-sm-12 my-3 text-center">
                <button id="addMores" class="btn btn-ico btn-outline-info" type="button"><i class="icon ni ni-plus-c"></i>  <?=translate_phrase('Add More');?></button>
            </div>


            <div class="row" >
            <div class="col-sm-12 text-center mt-3">
                    <button class="btn btn-primary bb_fo_btn" type="submit">
                        <i class="icon ni ni-save"></i> <?=translate_phrase('Save Record');?>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><div id="bb_ajax_msg2"></div></div>
            </div>
    <?php } }?>
<?php echo form_close(); ?>

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>
<!-- Include jQuery library -->

<script>
    $(document).ready(function(){
       
        // Function to handle the click event of the "Add More Convert" button
        $('#addMores').click(function(){
            // Clone the first row
            var newRow = $('.row.border').first().clone();
            
            // Clear input values in the cloned row
            newRow.find('input[type="text"], input[type="email"], input[type="date"]').val('');
           // Destroy Select2 instances on the cloned select elements
            newRow.find('.js-select2').each(function() {
                $(this).select2('destroy');
            });
            
            // Append the cloned row after the last existing row
            $('.row.border').last().after(newRow);
            
            // Reinitialize Select2 for the cloned select dropdown
           
            // Add a delete button with icon to the cloned row
            newRow.append('<button class="btn btn-danger deleteRow"> <em class="icon ni ni-trash"></em> <span>Remove</span></button>');
            
            newRow.find('.deleteRow').addClass('d-flex justify-content-center align-items-center');
            newRow.find('.js-select2').select2();
        });

        // Function to handle the click event of the delete button for dynamically added rows
        $(document).on('click', '.deleteRow', function(){
            // Remove the corresponding row when delete button is clicked
            $(this).closest('.row.border').remove();
        });
    });
    
    $(document).on('change', 'select[name="invited_by[]"]', function(){
        var selectedOption = $(this).val();
        var channelDiv = $(this).closest('.row').find('div[name="channel-div"]');
        var memberDiv = $(this).closest('.row').find('div[name="member-div"]');
        
        // Hide all related divs initially
        $('div[name="related-div"]').hide();
        
         // Show the corresponding div based on the selected option
         if(selectedOption === "Member") {
            memberDiv.show(500);channelDiv.hide();
        } else if(selectedOption === "Online") {
            channelDiv.show(500);memberDiv.hide();
        }
    });
</script>

</script>

