
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
        
     <!-- delete view -->
     <?php if($param2 == 'report') { ?>
        <ul class="nav nav-tabs">    
            <li class="nav-item">        
                <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1"><em class="icon ni ni-reports"></em><span>Overview</span></a>    
            </li>    
            <li class="nav-item">        
                <a class="nav-link" data-bs-toggle="tab" href="#tabItem2"><em class="icon ni ni-users"></em><span>Attendance</span></a>    
            </li>    
            <li class="nav-item">        
                <a class="nav-link" data-bs-toggle="tab" href="#tabItem3"><em class="icon ni ni-user-add"></em><span>First Timer</span></a>    
            </li>    
            <li class="nav-item">       
                <a class="nav-link" data-bs-toggle="tab" href="#tabItem4"><em class="icon ni ni-repeat"></em><span>New Convert</span></a>    
            </li>
        </ul>
        <div class="tab-content">    
            <div class="tab-pane active" id="tabItem1">    
                <?php 
                    $r_id = $param3;
                    $reports = $this->Crud->read_single('id', $r_id, 'cell_report');
                    if(empty($reports)){
                        echo '
                            <div class="col-sm-12">No Record</div>
                        ';
                    } else{
                        foreach($reports as $r){
                            $types = '';
                            if($r->type == 'wk1')$types = 'WK1 - Prayer and Planning';
                            if($r->type == 'wk2')$types = 'Wk2 - Bible Study';
                            if($r->type == 'wk3')$types = 'Wk3 - Bible Study';
                            if($r->type == 'wk4')$types = 'Wk4 - Fellowship / Outreach';
                ?>    
                    <div class="row">
                        <div class="col-sm-3 mb-3">
                            <label class="fw-bold">Meeting Date</label>
                        </div>
                        <div class="col-sm-9 mb-3">
                            <p><?=date('d F Y', strtotime($r->date)); ?></p>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label class="fw-bold">Meeting</label>
                        </div>
                        <div class="col-sm-9 mb-3">
                            <p><?=$types; ?></p>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label class="fw-bold">Offering</label>
                        </div>
                        <div class="col-sm-9 mb-3">
                            <p><?='$'.number_format($r->offering, 2); ?></p>
                        </div>
                        
                        <div class="col-sm-3 mb-3">
                            <label class="fw-bold">Attendance</label>
                        </div>
                        <div class="col-sm-9 mb-3">
                            <p><?=$r->attendance; ?></p>
                        </div>
                        
                        <div class="col-sm-3 mb-3">
                            <label class="fw-bold">First Timer</label>
                        </div>
                        <div class="col-sm-9 mb-3">
                            <p><?=$r->first_timer; ?></p>
                        </div>
                        
                        <div class="col-sm-3 mb-3">
                            <label class="fw-bold">New Converts</label>
                        </div>
                        <div class="col-sm-9 mb-3">
                            <p><?=$r->new_convert; ?></p>
                        </div>
                        
                        <div class="col-sm-3 mb-3">
                            <label class="fw-bold">Note</label>
                        </div>
                        <div class="col-sm-9 mb-3">
                            <p><?=ucwords($r->note); ?></p>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label class="fw-bold">Input Date</label>
                        </div>
                        <div class="col-sm-9 mb-3">
                            <p><?=date('d M Y h:iA', strtotime($r->reg_date)); ?></p>
                        </div>
                        
                    </div>
                <?php } } ?>
            </div>    
            <div class="tab-pane" id="tabItem2">        
                <?php if(empty($reports)){
                    echo '
                        <div class="col-sm-12">No Record</div>
                    ';
                } else {
                    echo '<div class="row"> 
                        <div class="col-sm-3  mb-3">
                            <label class="fw-bold">Attendance</label>
                        </div>
                        <div class="col-sm-9  mb-3">
                            <p>'.$r->attendance.'</p>
                        </div>';
                    $attendant = json_decode($r->attendant);
                    if(!empty($attendant)){
                       
                        foreach($attendant as $at => $val){
                            $name = $this->Crud->read_field('id', $val, 'user', 'firstname').' '.$this->Crud->read_field('id', $val, 'user', 'surname');
                        ?>
                        <div class="col-sm-4 mb-2 border"><?=ucwords($name); ?></div>
                    <?php } echo '</div>';
                    } else {
                        echo '
                            <div class="col-sm-12">No Attendance Record</div>
                        ';
                    }
                }?>
            </div>    
            <div class="tab-pane" id="tabItem3">        
                <?php if(empty($reports)){
                    echo '
                        <div class="col-sm-12">No Record</div>
                    ';
                } else {
                    echo '<div class="row"> 
                        <div class="col-sm-2 mb-3">
                            <label class="fw-bold">First Timer</label>
                        </div>
                        <div class="col-sm-10 mb-3">
                            <p>'.$r->first_timer.'</p>
                        </div></div>';
                    $timers = json_decode($r->timers);
                    if(!empty($timers)){
                        foreach($timers as $at => $val){
                            $time = (array)$val;
                           
                        ?>
                        <div class="row border mb-2 p-2"> 
                            <div class="col-sm-4 mb-2 ">
                                <label class="fw-bold">Name</label>
                                <p><?=ucwords($time['fullname']); ?></p>
                            </div>
                            <div class="col-sm-4 mb-2 ">
                                <label class="fw-bold">Email</label>
                                <p><?=ucwords($time['email']); ?></p>
                            </div>
                            <div class="col-sm-4 mb-2 ">
                                <label class="fw-bold">Phone</label>
                                <p><?=ucwords($time['phone']); ?></p>
                            </div>
                            <div class="col-sm-4 mb-2 ">
                                <label class="fw-bold">Birthday</label>
                                <p><?=ucwords($time['dob']); ?></p>
                            </div>
                        </div>
                    <?php }
                    } else {
                        echo '
                            <div class="col-sm-12">No First Timer Record</div>
                        ';
                    }
                }?>  
            </div>    
            <div class="tab-pane" id="tabItem4">        
            <?php if(empty($reports)){
                    echo '
                        <div class="col-sm-12">No Record</div>
                    ';
                } else {
                    echo '<div class="row"> 
                        <div class="col-sm-3 mb-3">
                            <label class="fw-bold">New Convert</label>
                        </div>
                        <div class="col-sm-9 mb-3">
                            <p>'.$r->new_convert.'</p>
                        </div></div>';
                    $timers = json_decode($r->converts);
                    if(!empty($timers)){
                        foreach($timers as $at => $val){
                            $time = (array)$val;
                           
                        ?>
                        <div class="row border mb-2 p-2"> 
                            <div class="col-sm-4 mb-2 ">
                                <label class="fw-bold">Name</label>
                                <p><?=ucwords($time['fullname']); ?></p>
                            </div>
                            <div class="col-sm-4 mb-2 ">
                                <label class="fw-bold">Email</label>
                                <p><?=ucwords($time['email']); ?></p>
                            </div>
                            <div class="col-sm-4 mb-2 ">
                                <label class="fw-bold">Phone</label>
                                <p><?=ucwords($time['phone']); ?></p>
                            </div>
                            <div class="col-sm-4 mb-2 ">
                                <label class="fw-bold">Birthday</label>
                                <p><?=ucwords($time['dob']); ?></p>
                            </div>
                            <div class="col-sm-4 mb-2 ">
                                <label class="fw-bold">Invited By</label>
                                <p><?=ucwords($time['invited_by']); ?></p>
                            </div>
                            <?php if($time['invited_by'] == 'Member'){?>
                                <div class="col-sm-4 mb-2 ">
                                    <label class="fw-bold">Channel</label>
                                    <p><?=ucwords($this->Crud->read_field('id', $time['channel'], 'user', 'firstname').' '.$this->Crud->read_field('id', $time['channel'], 'user', 'surname')); ?></p>
                                </div>
                            <?php } else{?>
                                <div class="col-sm-4 mb-2 ">
                                    <label class="fw-bold">Channel</label>
                                    <p><?=ucwords($time['channel']); ?></p>
                                </div>
                            <?php } ?>
                            
                        </div>
                    <?php }
                    } else {
                        echo '
                            <div class="col-sm-12">No New Convert Record</div>
                        ';
                    }
                }?>     
            </div>
        </div>
    <?php } ?>
        
    
    <?php if($param2 == 'attendance'){?>
        <div class="row">
            <span class="text-danger mb-2">Mark Member's Attendance in the Table Below</span>
            <div class="col-sm-4 mb-3 ">
                <label>Total</label>
                <input class="form-control" id="total" type="text" name="total"  readonly value="0">
            </div>
            <div class="col-sm-4 mb-3">
                <label>Member</label>
                <input class="form-control" id="member" type="text" name="member"  readonly value="0">
            </div>
            <div class="col-sm-4 mb-3">
                <label>First Timer</label>
                <input class="form-control" id="guest" type="text" name="guest" readonly value="<?=$timer_count; ?>">
            </div>
            <div class="col-sm-4 mb-3">
                <label>Male</label>
                <input class="form-control" id="male" type="text" name="male"  readonly value="<?=$timer_male; ?>">
            </div>
            <div class="col-sm-4 mb-3">
                <label>Female</label>
                <input class="form-control" id="female" type="text" name="female"  readonly value="<?=$timer_female; ?>">
            </div>
            <div class="col-sm-4 mb-3">
                <label>Children</label>
                <input class="form-control" id="children" type="text" name="children"  readonly value="<?=$timer_child; ?>">
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table id="dtable" class="table table-striped table-hover mt-5">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="row mt-5" >
            <div class="col-sm-12 text-center mt-5">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="icon ni ni-save"></i> <?=translate_phrase('Save Record');?>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg2"></div></div>
        </div>
    <?php } ?>
     
    <?php if($param2 == 'tithe'){?>
        <div class="row">
            <span class="text-danger mb-2">Enter Member's Tithe in the Table Below</span>
            <div class="col-sm-4 mb-3 ">
                <label>Total</label>
                <input class="form-control" id="total_tithe" type="text" name="total_tithe"  readonly value="0">
            </div>
            <div class="col-sm-4 mb-3">
                <label>Member</label>
                <input class="form-control" id="member_tithe" type="text" name="member_tithe"  readonly value="0">
            </div>
            <div class="col-sm-4 mb-3">
                <label>Guest</label>
                <input class="form-control" id="guest_tithe" type="text" name="guest_tithe" oninput="get_tithe();this.value = this.value.replace(/[^\d.]/g,'');this.value = this.value.replace(/(\..*)\./g,'$1')" value="0">
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table id="dtable" class="table table-striped table-hover mt-5">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th width="200px">Tithe</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="row mt-5" >
            <div class="col-sm-12 text-center mt-5">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="icon ni ni-save"></i> <?=translate_phrase('Save Record');?>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg2"></div></div>
        </div>
    <?php } ?>
    
    <?php if($param2 == 'partnership'){?>
        <div class="row">
            <span class="text-danger mb-2">Enter Member's Partnership in the Table Below</span>
            <div class="col-sm-4 mb-3 ">
                <label>Total</label>
                <input class="form-control" id="total_part" type="text" name="total_part"  readonly value="0">
            </div>
            <div class="col-sm-4 mb-3">
                <label>Member</label>
                <input class="form-control" id="member_part" type="text" name="member_part"  readonly value="0">
            </div>
            <div class="col-sm-4 mb-3">
                <label>First Timer</label>
                <input class="form-control" id="guest_part" type="text" name="guest_part" oninput="get_part();this.value = this.value.replace(/[^\d.]/g,'');this.value = this.value.replace(/(\..*)\./g,'$1')" readonly value="0">
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <?php
                $first = json_decode($first);
                if(!empty($first)){
            ?>
                <table class="table table-striped table-hover mt-5" id="dataTable">
                    <thead>
                        <tr>
                            <th >First Timer</th>
                            <?php  
                                $parts = $this->Crud->read_order('partnership', 'name', 'asc');
                                if(!empty($parts)){
                                    foreach($parts as $pp){
                                        $name = $pp->name;
                                        if(strtoupper($pp->name) == 'BIBLE SPONSOR')$name = 'Bible';
                                        if(strtoupper($pp->name) == 'CHILDREN MINISTRY')$name = 'Children';
                                        if(strtoupper($pp->name) == 'HEALING SCHOOL MAGAZINE')$name = 'H.S.M';
                                        if(strtoupper($pp->name) == 'HEALING STREAM')$name = 'H.S';
                                        if(strtoupper($pp->name) == 'LOVEWORLD LWUSA')$name = 'lwusa';
                                        if(strtoupper($pp->name) == 'MINISTRY PROGRAM')$name = 'Ministry';
                                        // if($pp->name == 'BIBLE SPONSOR')$name = 'Bible';
                                        
                                        echo ' <th >'.strtoupper($name).'</th>';
                                    }
                                }
                            ?>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="original-row">
                            <td>
                                <select class="js-select2 firsts"  data-search="on" name="first_timer[]" id="firsts" data-placeholder="Select First Timer" required>
                                    <option value="0">Select</option>
                                    <?php 
                                        if(!empty((array)$first)){
                                            foreach($first as $mm => $val){
                                                echo '<option value="'.$val->fullname.'">'.strtoupper($val->fullname).'</option>';
                                            }
                                        } 
                                    ?>
                                </select>
                            </td>
                            <?php 
                                if(!empty($parts)){
                                    foreach($parts as $pp){
                                        echo '<td><input type="text" style="width:100px;" class="form-control amountInput" name="amount[]" value="0" oninput="updateTotal()"></td>';
                                    }
                                }
                            ?>
                            <td></td> <!-- Empty cell for Action -->
                        </tr>
                    </tbody>
                </table>
                <div class="col-12 my-3 text-center">
                    <p id="first_resp"></p>
                    <button type="button" class="btn btn-info" id="more_btn">Add More</button>
                </div>
            <?php } ?>
            <table class="table table-striped table-hover mt-5" id="member_table">
                <thead>
                    <tr>
                        <th >Member</th>
                        <?php 
                            $parts = $this->Crud->read_order('partnership', 'name', 'asc');
                            if(!empty($parts)){
                                foreach($parts as $pp){
                                    $name = $pp->name;
                                    if(strtoupper($pp->name) == 'BIBLE SPONSOR')$name = 'Bible';
                                    if(strtoupper($pp->name) == 'CHILDREN MINISTRY')$name = 'Children';
                                    if(strtoupper($pp->name) == 'HEALING SCHOOL MAGAZINE')$name = 'H.S.M';
                                    if(strtoupper($pp->name) == 'HEALING STREAM')$name = 'H.S';
                                    if(strtoupper($pp->name) == 'LOVEWORLD LWUSA')$name = 'lwusa';
                                    if(strtoupper($pp->name) == 'MINISTRY PROGRAM')$name = 'Ministry';
                                    // if($pp->name == 'BIBLE SPONSOR')$name = 'Bible';
                                    
                                    echo ' <th >'.strtoupper($name).'</th>';
                                }
                            }
                        ?>
                       <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="original-rows">
                        <td>
                            <select class="js-select2 members" name="member[]" id="members" required>
                               
                                <?php 
                                    $mem_id = $this->Crud->read_field('name', 'Member', 'access_role', 'id');
                                    $mem = $this->Crud->read_single_order('role_id', $mem_id, 'user', 'firstname', 'asc');
                                    if(!empty($mem)){
                                        foreach($mem as $mm){
                                            echo '<option value="'.$mm->id.'">'.strtoupper($mm->firstname.' '.$mm->surname).'</option>';
                                        }
                                    } 
                                ?>
                            </select>
                        </td>
                        <?php 
                           if(!empty($parts)){
                                foreach($parts as $pp){
                                    echo ' <td ><input type="text" style="width:100px;" class="form-control  amountInput" name="amount[]" value="0" oninput="updateTotal()"></td>';
                                }
                            }
                        ?>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="col-12 my-3 text-center">
                <p id="mem_resp"></p>
                <button type="button" class="btn btn-primary" id="mem_btn" onclick="addRow()">Add More</button>
            </div>
        </div>
        <hr>
        <div class="row mt-5" >
            <div class="col-sm-12 text-center mt-5">
                <button class="btn btn-primary bb_fo_btn" type="submit">
                    <i class="icon ni ni-save"></i> <?=translate_phrase('Save Record');?>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg2"></div></div>
        </div>
    <?php } ?>
    <!-- insert/edit view -->
    <?php if($param2 == 'new_convert') { ?>
        
            <?php 
                $cell_id = $this->Crud->read_field('id', $param4, 'cell_report', 'cell_id');
                $roles = $this->Crud->read_field('name', 'Member', 'access_role', 'id');

                $converts = json_decode($this->Crud->read_field('id', $param4, 'cell_report', 'converts'));
                if(!empty($converts)){
                    $firstIteration = true; // Flag to track the first iteration

                    foreach($converts as $c => $val){
                        $vals = (array)$val;
                        // Split the string into an array of words
                        $words = explode(" ", $vals['fullname']);

                        // Get the last word
                        $surname = array_pop($words);

                        // Reassemble the remaining words
                        $first_name = implode(" ", $words);
                        // echo $vals['fullname'];
                         // Check if it's not the first iteration
                         $btn = '';
                        if (!$firstIteration) {
                            $btn = '<button class="btn btn-danger deleteRow d-flex justify-content-center align-items-center"> <em class="icon ni ni-trash"></em> <span>Remove</span></button>';
                        }
                        
                        // After the first iteration, set the flag to false
                        $firstIteration = false;
            ?>
                <div class="row border mb-3">
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="name">*<?=translate_phrase('First Name'); ?></label>
                            <input class="form-control" value="<?php if(!empty($first_name)){echo $first_name; }?>" type="text" id="first_name" name="first_name[]" required>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="name">*<?=translate_phrase('Surname'); ?></label>
                            <input class="form-control" type="text" value="<?php if(!empty($surname)){echo $surname; }?>" id="surname" name="surname[]"  required>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name">*<?=translate_phrase('Email'); ?></label>
                            <input class="form-control" value="<?php if(!empty($vals['email'])){echo $vals['email']; }?>" type="email" id="email" name="email[]"  >
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name">*<?=translate_phrase('Phone'); ?></label>
                            <input class="form-control" value="<?php if(!empty($vals['phone'])){echo $vals['phone']; }?>" type="text" id="phone" name="phone[]"  required>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name">*<?=translate_phrase('Birthday'); ?></label>
                            <input class="form-control" value="<?php if(!empty($vals['dob'])){echo $vals['dob']; }?>" type="date" id="dob" name="dob[]" >
                        </div>
                    </div>
                    <?=$btn; ?>
                </div>
            <?php } }else{?>
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
            <?php } ?>
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
    <?php } ?>

     <!-- insert/edit view -->
     <?php if($param2 == 'first_timer') { ?>
        
            <?php 
                $cell_id = $this->Crud->read_field('id', $param4, 'cell_report', 'cell_id');
                $roles = $this->Crud->read_field('name', 'Member', 'access_role', 'id');

                $converts = json_decode($this->Crud->read_field('id', $param4, 'cell_report', 'timers'));
                if(!empty($converts)){
                    $firstIteration = true; // Flag to track the first iteration

                    foreach($converts as $c => $val){
                        $vals = (array)$val;
                        // Split the string into an array of words
                        $words = explode(" ", $vals['fullname']);
                        $email = $vals['email'];
                        $phone = $vals['phone'];
                        $dob = $vals['dob'];
                        $invited_by = $vals['invited_by'];
                        $channel = $vals['channel'];
                        $email = $vals['email'];
                        
                        // Get the last word
                        $surname = array_pop($words);

                        // Reassemble the remaining words
                        $first_name = implode(" ", $words);
                        // echo $vals['fullname'];
                         // Check if it's not the first iteration
                         $btn = '';
                        if (!$firstIteration) {
                            $btn = '<button class="btn btn-danger deleteRow d-flex justify-content-center align-items-center"> <em class="icon ni ni-trash"></em> <span>Remove</span></button>';
                        }
                        
                        // After the first iteration, set the flag to false
                        $firstIteration = false;
            ?>
            
                <div class="row border mb-3">
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name">*<?=translate_phrase('First Name'); ?></label>
                            <input class="form-control" value="<?php if(!empty($first_name)){echo $first_name; }?>"  type="text" id="first_name" name="first_name[]" required>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name">*<?=translate_phrase('Surname'); ?></label>
                            <input class="form-control" value="<?php if(!empty($surname)){echo $surname; }?>"  type="text" id="surname" name="surname[]"  required>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name"><?=translate_phrase('Email'); ?></label>
                            <input class="form-control" value="<?php if(!empty($email)){echo $email; }?>"  type="email" id="email" name="email[]"  >
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name">*<?=translate_phrase('Phone'); ?></label>
                            <input class="form-control" value="<?php if(!empty($phone)){echo $phone; }?>"  type="text" id="phone" name="phone[]"  required>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name"><?=translate_phrase('Gender'); ?></label>
                            <div class="form-control-wrap">
                                <select
                                    class="form-select js-select2" name="gender" required
                                    data-placeholder="Select Gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php if(!empty($e_gender)){if($e_gender == 'Male'){echo 'selected';}}?>>Male</option>
                                    <option value="Female" <?php if(!empty($e_gender)){if($e_gender == 'Female'){echo 'selected';}}?>>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name"><?=translate_phrase('Family Position'); ?></label>
                            <div class="form-control-wrap">
                                <select class="form-select js-select2" id="family_position" name="family_position"
                                    data-placeholder="Select Position" onchange="posit();">
                                    <option value="">Select</option>
                                    <option value="Child" <?php if(!empty($e_family_position)){if($e_family_position == 'Child'){echo 'selected';}} ?>>Child </option>
                                    <option value="Parent" <?php if(!empty($e_family_position)){if($e_family_position == 'Parent'){echo 'selected';}} ?>>Parent </option>
                                    <option value="Other" <?php if(!empty($e_family_position)){if($e_family_position == 'Other'){echo 'selected';}} ?>>Other </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name"><?=translate_phrase('Birthday'); ?></label>
                            <input class="form-control" value="<?php if(!empty($dob)){echo $dob; }?>"  type="date" id="dob" name="dob[]" >
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name">*<?=translate_phrase('Invited By'); ?></label>
                            <select class="form-select js-select2" name="invited_by[]" required>
                                <option value="">Select</option>
                                <option <?php if(!empty($invited_by)){if($invited_by == 'Member'){echo 'selected';}} ?> value="Member">Member</option>
                                <option <?php if(!empty($invited_by)){if($invited_by == 'Online'){echo 'selected';}} ?> value="Online">Online</option>
                                <option <?php if(!empty($invited_by)){if($invited_by == 'Others'){echo 'selected';}} ?> value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-4 mb-3" name="channel-div" style="display: none;">
                        <div class="form-group">
                            <label for="name"><?=translate_phrase('Channel'); ?></label>
                            <input class="form-control" type="text" value="<?php if(!empty($channel)){echo $channel;} ?>"  id="channel" name="channel[]" >
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3" name="member-div" style="display: none;">
                        <div class="form-group">
                            <label for="name"><?=translate_phrase('Member'); ?></label>
                            <select class="form-select js-select2" data-search="on" name="member_id[]">
                                <option value="">Select Member</option>
                                <?php 
                                    $roles_id = $this->Crud->read_field('name', 'Member', 'access_role', 'id');
                                    $mem = $this->Crud->read_single_order('role_id', $roles_id, 'user', 'firstname', 'asc');
                                        if(!empty($mem)){
                                            
                                            foreach($mem as $m){
                                                $mrm = '';
                                                if(!empty($channel)){if($channel == $m->id){$mrm = 'selected';}}
                                                echo '<option value="'.$m->id.'" '.$mrm.'>'.ucwords($m->firstname.' '.$m->surname).'</option>';
                                            }
                                        }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                </div>

            <?php } }else{ ?>
                <div class="row border mb-3 p-2">
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name">*<?=translate_phrase('First Name'); ?></label>
                            <input class="form-control" type="text" id="first_name" name="first_name[]" required>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name">*<?=translate_phrase('Surname'); ?></label>
                            <input class="form-control" type="text" id="surname" name="surname[]"  required>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name"><?=translate_phrase('Email'); ?></label>
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
                            <label for="name"><?=translate_phrase('Gender'); ?></label>
                            <div class="form-control-wrap">
                                <select
                                    class="form-select js-select2" name="gender[]" required
                                    data-placeholder="Select Gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php if(!empty($e_gender)){if($e_gender == 'Male'){echo 'selected';}}?>>Male</option>
                                    <option value="Female" <?php if(!empty($e_gender)){if($e_gender == 'Female'){echo 'selected';}}?>>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="name"><?=translate_phrase('Family Position'); ?></label>
                            <div class="form-control-wrap">
                                <select class="form-select js-select2" id="family_position" name="family_position[]" data-placeholder="Select Position">
                                    <option value="">Select</option>
                                    <option value="Child" <?php if(!empty($e_family_position)){if($e_family_position == 'Child'){echo 'selected';}} ?>>Child </option>
                                    <option value="Parent" <?php if(!empty($e_family_position)){if($e_family_position == 'Parent'){echo 'selected';}} ?>>Parent </option>
                                    <option value="Other" <?php if(!empty($e_family_position)){if($e_family_position == 'Other'){echo 'selected';}} ?>>Other </option>
                                </select>
                            </div>
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
                            <select class="form-select js-select2" name="invited_by[]" required>
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
                            <select class="form-select js-select2" data-search="on" name="member_id[]">
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

            <?php } ?>
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
    <?php }?>
<?php echo form_close(); ?>
<input type="hidden" id="respo">
<input type="hidden" id="applicant">
<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>
<!-- Include jQuery library -->

<script>
     var rowIndex = 1;
    // Array to store selected values
    var selectedValues = [];

    function clearSelectedValues() {
        selectedValues = [];
    }
    $(function() {
        clearSelectedValues();
    });
    $(document).ready(function() {
        
        var selectCounter = 1; 
       
        function initializeSelect2(selectElement) {
            selectElement.select2( );
            selectElement.attr('data-search', 'true'); // Add data-search attribute
        }

        // Function to create and return a new select element
        function createSelectElement() {
            var select = $('<select class="js-select2 firsts" data-search="on" name="first_timer[]" data-placeholder="Select First Timer" required></select>');

            <?php if(!empty((array)$first)) { ?>
                <?php foreach($first as $mm => $val) { ?>
                    var optionValue = '<?php echo htmlspecialchars($val->fullname); ?>';
                    var optionText = '<?php echo strtoupper(htmlspecialchars($val->fullname)); ?>';

                    // Check if this option is selected in any existing row
                    var isSelected = selectedValues.includes(optionValue);

                    // If the option is not selected in any existing row, add it to the new select element
                    if (!isSelected) {
                        select.append('<option value="' + optionValue + '">' + optionText + '</option>');
                    }
                <?php } ?>
            <?php } ?>

          
            return select;

        }
        

        function addNewRow() {
            
            var remainingOptions = $('.original-row select option:not(:selected)');
            if (remainingOptions.length === 0) {
                $('#first_resp').html("<span class='text-danger'>No more options available.</span>");
                return;
            }
            var selectedValue = $('.original-row select').val();
            if (selectedValue === "0") {
                $('#first_resp').html("<span class='text-danger'>Select a First Time.</span>");
                return; // Stop further execution
            } 
            $('#first_resp').html('')
            var newRow = $('<tr class="new-row"></tr>');

            var firstTimerSelect = createSelectElement();

            // Assign a new unique id to the cloned select element
            var newSelectId = 'firsts_' + selectCounter;
            firstTimerSelect.attr('id', newSelectId);

            newRow.append('<td>' + firstTimerSelect.prop('outerHTML') + '</td>');

            // Add input fields for each partnership
            $('#dataTable th').each(function (index) {
                if (index > 1) {
                    newRow.append('<td><input type="text" style="width:100px;" class="form-control amountInput" name="amount[]" value="0" oninput="updateTotal()"></td>');
                }
            });

            // Add delete button in the action cell
            newRow.append('<td><button class="btn btn-danger btn-sm delete-row">Delete</button></td>');
            $('#dataTable tbody').append(newRow);

            // Initialize select2 plugin for the new select element
            initializeSelect2(newRow.find('select'));

            // Increment the counter
            selectCounter++;

              // Update Add More button state
            updateAddMoreButtonState();
        }

        function updateAddMoreButtonState() {
            // Count the number of selected values except when value is 0
            var selectedCount = selectedValues.filter(function(value) {
                return value !== "0";
            }).length;

            // Get the number of options in the last select element
            var lastSelectOptionsCount = $('.new-row:last .firsts option').length;

            // Disable "Add More" button if the number of selected values matches the number of original options minus 1
            // or if the number of options in the last select element is 1
            if (lastSelectOptionsCount === 1 || selectedCount === lastSelectOptionsCount - 1) {
                $('#more_btn').prop('disabled', true);
            } else {
                $('#more_btn').prop('disabled', false);
            }
        }



        // Event listener for the Add More button
        $('#more_btn').click(function() {
           
            // Add a new row with a fresh select element
            addNewRow();
        });

        
        // Event listener for selecting an option
        $(document).on('change', '.firsts', function() {
            var selectedValue = $(this).val();
            if (selectedValue) {
                selectedValues.push(selectedValue);
            }
        });

        // Event listener for dynamically added delete buttons
        $('#dataTable').on('click', '.delete-row', function() {
            var selectedValue = $(this).closest('tr').find('.firsts').val();
            if (selectedValue) {
                // Remove the selected value from the array
                var index = selectedValues.indexOf(selectedValue);
                if (index !== -1) {
                    selectedValues.splice(index, 1);
                }
            }
            // Update Add More button state
            updateAddMoreButtonState();

            $(this).closest('tr').remove();
        });
    });
    var rowIndex = 1; // Initialize row index

    function addRow() {
        var originalSelect = document.querySelector('.original-rows select');
        var selectedValue = originalSelect.value;

        if (selectedValue === '') {
            $('#mem_resp').html('<span class="text-danger">Please select a value from the Member.</span>');
            return; // Exit the function if no value is selected
        }

        var selectedOptions = $('.members').map(function() {
            return $(this).val();
        }).get();

        if (selectedOptions.includes(selectedValue)) {
            $('#mem_resp').html('<span class="text-danger">This value has already been selected.</span>');
            // xit the function if the value is already selected in another row
        }

        var selectId = 'member' + rowIndex;
        var newRow = '<tr>' +
            '<td>' +
            '<select class="js-select2 members" id="'+selectId+'" data-search="on" name="member[]" required>' +
            '' +
            $('#members').html() + // Clone options from original select
            '</select>' +
            '</td>';

        <?php 
            if(!empty($parts)){
                foreach($parts as $pp){
                    echo 'newRow += \'<td><input type="text" style="width:100px;" class="form-control amountInput" name="amount[]" value="0" oninput="updateTotal()"></td>\';';
                }
            }
        ?>

       
        newRow += '<td><button type="button" class="btn btn-danger" onclick="deleteRow(this)">Delete</button></td>';
        newRow += '</tr>';

        // Append the new row
        $('#member_table tbody').append(newRow);

        // Initialize select2 for the new select element
        $('#' + selectId).select2();

        // Remove selected options from all select elements
        $('.member').each(function() {
            var value = $(this).val();
            $(this).find('option').each(function() {
                if (selectedOptions.includes($(this).val()) && $(this).val() !== value) {
                    $(this).remove();
                }
            });
        });

        // Increment the rowIndex for unique IDs
        rowIndex++;
        
        // Disable "Add More" button if all options are selected
        var remainingOptions = $('select.js-select2 option:not([value=""])').length;
        if (remainingOptions === 0) {
            $('#mem_btn').prop('disabled', true);
        }
    }

    function deleteRow(btn) {
        var row = $(btn).closest('tr');
        var selectValue = row.find('select').val();

        row.remove();

        // Add the deleted value back to the select dropdown
        $('#members').append('<option value="' + selectValue + '">' + selectValue + '</option>');

        // Update select2
        $('.js-select2').select2();

        // Update total if needed
        updateTotal();
    }

    function deleteRow(btn) {
        var row = btn.parentNode.parentNode;
        var selectValue = row.querySelector('select').value;

        // Find the closest previous row
        var closestRow = $(row).prev('tr');
        var closestSelect = closestRow.find('select.js-select2');

        row.parentNode.removeChild(row);

        // Add the deleted value back to the closest select dropdown
        closestSelect.append('<option value="' + selectValue + '">' + selectValue.toUpperCase() + '</option>');

        // Update select2
        closestSelect.select2();

        updateTotal();
    }



    function updateTotal() {
        var inputs = document.getElementsByClassName('amountInput');
        var total = 0;
        for (var i = 0; i < inputs.length; i++) {
            if (!isNaN(inputs[i].value) && inputs[i].value !== '') {
                total += parseFloat(inputs[i].value);
            }
        }
        console.log(total);
        document.getElementById('total_part').value = total;
    }

    $(document).ready(function(){
        // Initialize Select2 for the original select dropdown
        $('.js-select2').each(function() {
            if (!$(this).data('select2')) {
                $(this).select2();
            }
        });
        // Function to handle the click event of the "Add More Convert" button
        $('#addMores').click(function(){
            // Clone the first row
            var newRow = $('.row.border').first().clone();
            
            // Clear input values in the cloned row
            newRow.find('input[type="text"], input[type="email"], input[type="date"]').val('');
            
            // Append the cloned row after the last existing row
            $('.row.border').last().after(newRow);
            
            // Add a delete button with icon to the cloned row
            newRow.append('<button class="btn btn-danger deleteRow"> <em class="icon ni ni-trash"></em> <span>Remove</span></button>');
             // Reinitialize Select2 for the cloned select dropdown
             newRow.find('.js-select2').select2();
            // Center align the delete button
            newRow.find('.deleteRow').addClass('d-flex justify-content-center align-items-center');
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
        } else if(selectedOption === "Online" || selectedOption === "Others") {
            channelDiv.show(500);memberDiv.hide();
        }
    });

    function calculateTotal() {
        
        var tithesInputs = document.querySelectorAll('.tithes');
        var total = 0;
        tithesInputs.forEach(function(input) {
            var value = parseFloat(input.value);
            total += isNaN(value) ? 0 : value;
        });
        console.log(total);
        var guest = $('#guest_tithe').val();
        
        $('#member_tithe').val(total.toFixed(2));
        total += parseFloat(guest);
        total = total.toFixed(2);
        $('#total_tithe').val(total);

        // Set value to 0 if the textbox is empty
        tithesInputs.forEach(function(input) {
            if (input.value === '') {
                input.value = '';
            }
        });
    }
    // Trigger the change event on page load
    $('select[name="invited_by[]"]').trigger('change');

    function marks(id){
        // console.log(id);
        var total = $('#total').val();
        var member = $('#member').val();
        var male = $('#male').val();
        var female = $('#female').val();
        var children = $('#children').val();
        var guest = $('#guest').val();
        var applicant = $('#applicant').val();
        
        if($('#customSwitch'+id).prop('checked')){
            var vals = 1;
        } else{
            var vals = 0;
        }

        $.ajax({
            url: site_url + 'service/report/gets/' + id,
            type: 'post',
            data: {total:total,member:member,male:male,female:female,children:children,guest:guest, vals:vals, applicant:applicant},
            success: function (data) {
                $('#respo').html(data);
                
            }
        });
    }

    function get_total(){
        var member = $('#member').val();
        var guest = $('#guest').val();
        
        var total = parseInt(member) + parseInt(guest);
        $('#total').val(total);
    }
    get_total();
    function get_tithe(){
        var member = $('#member_tithe').val();
        var guest = $('#guest_tithe').val();
        
        var total = parseFloat(member) + parseFloat(guest);
        total = total.toFixed(2);
        $('#total_tithe').val(total);
    }

   
</script>
<?php if(!empty($table_rec)){ ?>
    <!-- <script src="<?=site_url();?>assets/backend/vendors/datatables/jquery.dataTables.min.js"></script>
        <script src="<?=site_url();?>assets/backend/vendors/datatables/dataTables.bootstrap.min.js"></script>
        <script src="<?=site_url();?>assets/backend/js/pages/datatables.js"></script> -->
    <script type="text/javascript">
    $(document).ready(function() {
        //datatables
        var table = $('#dtable').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [<?php if(!empty($order_sort)){echo '['.$order_sort.']';} ?>], //Initial order.
            "language": {
                "processing": "<i class='icon ni ni-loader' aria-hidden='true'></i> <?=translate_phrase('Processing... please wait'); ?>"
            },
            // "pagingType": "full",

            // Load data for the table's content from an Ajax source
            "ajax": {
                url: "<?php echo site_url($table_rec); ?>",
                type: "POST",
               
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [
                <?php if(!empty($no_sort)){echo $no_sort;} ?>], //columns not sortable
                "orderable": false, //set not orderable
            }, ],

        });

    });
    
    </script>
<?php } ?>
