
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
                    $roles = $this->Crud->read_field('name', 'Member', 'access_role', 'id');
                    $user = $this->Crud->read2('cell_id', $param3,'role_id', $roles, 'user');
                    if(!empty($user)){
                        foreach($user as $p){
                            
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
                                        <input type="checkbox" name="mark[]" class="custom-control-input" id="customSwitch<?=$p->id;?>" value="<?=$p->id;?>">    
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
    <?php if($param2 == 'edi' || $param2 == '') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        
        <div class="row">
            <input type="hidden" name="cell_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
            <div class="col-sm-12 mb-3">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Name'); ?></label>
                    <input class="form-control" type="text" id="name" name="name" value="<?php if(!empty($e_name)) {echo $e_name;} ?>" required>
                </div>
            </div>
            <div class="col-sm-12 mb-3">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Location'); ?></label>
                    <input class="form-control" type="text" id="location" name="location" value="<?php if(!empty($e_location)) {echo $e_location;} ?>" required>
                </div>
            </div>
            
        </div>
        <div  id="containers">
            <?php if(!empty($e_time)){$a = 0;
                foreach($e_time as $k => $val){
                    $r_val = 'style="display:none;"';$req = 'required';
                    if($a > 0){
                        $r_val = 'style="display:display;"';$req = '';
                    }
                    ?>
                        <div class="row">
                        <div class="col-sm-4 mb-3">
                            <div class="form-group">
                                <label for="name">*<?=translate_phrase('Meeting Day'); ?></label>
                                <select class="form-control" name="days[]"  <?=$req; ?>>
                                    <option value="">Select</option>
                                    <option value="Sunday" <?php if($k == 'Sunday'){echo 'selected';} ?>>Sunday</option>
                                    <option value="Monday" <?php if($k == 'Monday'){echo 'selected';} ?>>Monday</option>
                                    <option value="Tuesday" <?php if($k == 'Tuesday'){echo 'selected';} ?>>Tuesday</option>
                                    <option value="Wednesday" <?php if($k == 'Wednesday'){echo 'selected';} ?>>Wednesday</option>
                                    <option value="Thursday" <?php if($k == 'Thursday'){echo 'selected';} ?>>Thursday</option>
                                    <option value="Friday" <?php if($k == 'Friday'){echo 'selected';} ?>>Friday</option>
                                    <option value="Saturday" <?php if($k == 'Saturday'){echo 'selected';} ?>>Saturday</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-8 mb-3">
                            <label for="name">*<?=translate_phrase('Meeting Time'); ?></label>
                            <div class="form-group input-group">
                                <input class="form-control" type="time" id="location" value="<?php if(!empty($val)){echo $val;} ?>" name="times[]"  <?=$req; ?>>
                                <button <?=$r_val; ?>  class="btn btn-icon btn-outline-danger deleteBtns" type="button"><i class="icon ni ni-trash"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $a++; }} else {?>
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <div class="form-group">
                        <label for="name">*<?=translate_phrase('Meeting Day'); ?></label>
                        <select class="form-control" name="days[]" required>
                            <option value="">Select</option>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-8 mb-3">
                        <label for="name">*<?=translate_phrase('Meeting Time'); ?></label>
                    <div class="form-group input-group">
                        <input class="form-control" type="time" id="location" name="times[]" required>
                        <button style="display:none;"  class="btn btn-icon btn-outline-danger deleteBtns" type="button"><i class="icon ni ni-trash"></i> </button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="col-sm-12 mb-3 text-center">
            <button id="addMores" class="btn btn-ico btn-outline-info" type="button"><i class="icon ni ni-plus-c"></i>  <?=translate_phrase('Add More Days');?></button>
        </div>

        <label for="name">*<?=translate_phrase('Cell Role');?></label>
        <div class="row" id="container">
            <?php if(!empty($e_roles)){$a = 0;
                foreach($e_roles as $k => $val){
                    $r_val = 'style="display:none;"';$req = 'required';
                    if($a > 0){
                        $r_val = 'style="display:display;"';$req = '';
                    }
                    ?>
                <div class="col-sm-12 mb-3 ">
                    <div class="form-group input-group">
                        <input class="form-control" type="text" id="role" placeholder="Enter Cell Roles" name="roles[]" value="<?php if(!empty($val)) {echo $val;} ?>" <?=$req; ?>>
                        <button <?=$r_val; ?>  class="btn btn-icon btn-outline-danger deleteBtn" type="button"><i class="icon ni ni-trash"></i> </button>
                    </div>
                    
                </div>
            <?php $a++; }} else {?>
                <div class="col-sm-12 mb-3 ">
                    <div class="form-group input-group">
                        <input class="form-control" type="text" id="role" placeholder="Enter Cell Roles" name="roles[]" value="<?php if(!empty($val)) {echo $val;} ?>" required>
                        <button style="display:none;" class="btn btn-icon btn-outline-danger deleteBtn" type="button"><i class="icon ni ni-trash"></i> </button>
                    </div>
                    
                </div>
            <?php }?>
        </div>

        <div class="row" >
            <div class="col-sm-12 mb-3 text-center">
                <button id="addMore" class="btn btn-ico btn-outline-primary" type="button"><i class="icon ni ni-plus"></i> <?=translate_phrase('Add More Roles');?></button>
            </div>
            <div class="col-sm-12 text-center mt-3">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="icon ni ni-save"></i> <?=translate_phrase('Save Record');?>
                </button>
            </div>
        </div>
    <?php } ?>
<?php echo form_close(); ?>

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>