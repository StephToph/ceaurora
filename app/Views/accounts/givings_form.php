
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
                <input type="hidden" name="d_cell_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="icon ni ni-trash"></i> <?=translate_phrase('Yes - Delete');?>
                </button>
            </div>
        </div>
    <?php } ?>

    
<?php if($param2 == 'view'){?>
    <table id="dtable" class="table table-striped">
        <thead>
            <tr>
                <th>Day</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $pays = $this->Crud->read_single('id', $param3, 'cells');

                $total = 0;
                if(!empty($pays)){
                    foreach($pays as $p){
                        $time = $p->time;
                        if(!empty(json_decode($time))){
                            foreach(json_decode($time) as $t => $val){
                       
                        ?>
                            <tr>
                                <td><?=$t ?></td>
                                <td><?=date('h:iA', strtotime($val)); ?></td>
                            </tr>
                   <?php
                            }
                        }
                    }
                }
                
            ?>
        </tbody>
    </table>

<?php } ?>
    <!-- insert/edit view -->
    <?php if($param2 == 'edit' || $param2 == '') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        
        <div class="row">
            <input type="hidden" name="giving_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
            <div class="col-sm-12 mb-3">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Members'); ?></label>
                    <input class="form-control" type="text" id="name" name="name" value="<?php if(!empty($e_name)) {echo $e_name;} ?>" required>
                </div>
            </div>
            <div class="col-sm-12 mb-3">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Partnership'); ?></label>
                    <select id="role_id" name="partnership_id" class="js-select2" required>
                        <option value="">Select</option>
                        <?php
                            $part = $this->Crud->read_order('partnership', 'name', 'asc');
                            if(!empty($part)){
                                foreach($part as $p){
                                    echo '<option value="'.$p->id.'">'.ucwords($p->name).'</option>';
                                }
                            }
                        ?>
                    </select>
                    <input class="form-control" type="text" id="location" name="location" value="<?php if(!empty($e_location)) {echo $e_location;} ?>" required>
                </div>
            </div>
            <div class="col-sm-12 mb-3">
                <div class="form-group">
                    <label for="name">*<?=translate_phrase('Amount'); ?></label>
                    <input class="form-control" type="text" id="amount" name="amount" value="<?php if(!empty($e_amount)) {echo $e_amount;} ?>" required>
                </div>
            </div>
            
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
<script>
    $('.js-select2').select2();
   
</script>

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script