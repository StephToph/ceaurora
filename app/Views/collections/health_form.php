
<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>
<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
    <!-- delete view -->
    <?php if($param1 == 'pay') { ?>
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
                        <tbody>
                            <tr>
                                <td><?=translate_phrase('Insurance Plan'); ?></td>
                                <th ><?=translate_phrase($e_sub_plan.' Plan'); ?></th>
                            </tr>  
                            <tr>
                                <td>Price (<?=$e_duration; ?>)</td>
                                <th ><?=curr.number_format($e_price_duration,2); ?> </th>
                            </tr>  
                            <tr>
                                <td><?=translate_phrase('Payment Date'); ?></td>
                                <th ><?=date('d F Y',strtotime($e_cur_date)); ?> </th>
                            </tr>    
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="health_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                <input type="hidden" name="pay_date" value="<?php if(!empty($e_cur_date)){echo $e_cur_date;} ?>" />
                
                <input type="hidden" name="price_duration" value="<?php if(!empty($e_price_duration)){echo $e_price_duration;} ?>" />
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

<?php echo form_close(); ?>
<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>