
<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>
<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>

<?php if($param2 == 'view'){?>
    <table id="dtable" class="table table-striped">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Amount</th>
                <th>Paid Date</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $pays = $this->Crud->read_single_order('transaction_id', $param3, 'payment', 'id', 'asc');
                $tax = $this->Crud->read_field('id', $param3, 'transaction', 'amount');
                $payment_date = $this->Crud->read_field('id', $param3, 'transaction', 'payment_date');
                
                $total = 0;
                if(!empty($pays)){
                    foreach($pays as $p){?>
                        <tr>
                            <td><?=$p->reference; ?></td>
                            <td><?=curr.number_format($p->amount, 2); ?></td>
                            <td><?=date('d F Y h:iA', strtotime($p->reg_date)); ?></td>
                        </tr>
                   <?php
                    $total += (float)$p->amount;
                    }
                }
                $rem = (float)$tax - (float)$total;
            ?>
        </tbody>
    </table>
    <div class="row mt-3">
        <div class="col-sm-6  mb-2 fw-bold">
           Payment Date: <?=date('d F Y', strtotime($payment_date)); ?>
        </div>

        <div class="col-sm-6 mb-2  fw-bold">
            Tax Amount: <?=curr.number_format($tax, 2); ?>
        </div>

        <div class="col-sm-6 mb-2  fw-bold text-success">
            Paid: <?=curr.number_format($total, 2); ?>
        </div>
        <div class="col-sm-6 mb-2  fw-bold text-danger">
            Balance: <?=curr.number_format($rem, 2); ?>
        </div>
    </div>


<?php } ?>

<?php if($param2 == 'history'){?>
    <table id="dtable" class="table table-striped">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Paid Date</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $pays = $this->Crud->read_single('user_id', $param3, 'history');
                
                $total = 0;
                if(!empty($pays)){
                    foreach($pays as $p){?>
                        <tr>
                            <td><?=$p->ref; ?></td>
                            <td><?=curr.number_format($p->amount, 2); ?></td>
                            <td><?=strtoupper($p->payment_method); ?></td>
                            <td><?=date('d F Y h:iA', strtotime($p->reg_date)); ?></td>
                        </tr>
                   <?php
                   $total += (float)$p->amount;
                    }
                } else{
                    echo '
                        <tr>
                            <td colspan="4" class="text-center">No Payment History</td>
                        </tr>
                    ';
                }
                
            ?>

        </tbody>
    </table>
    <div class="row mt-3">
        <div class="col-sm-12 text-end mb-2 fw-bold">
          Total: <?=curr.number_format($total,2); ?>
        </div>

    </div>

<?php } ?>

<?php if($param2 == 'invoice'){?>
    <table id="dtable" class="table table-striped">
        <thead>
            <tr>
                <th>Payment Date</th>
                <th>Tax Amount</th>
                <th>Amount Paid</th>
                <th>Payment Status</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            <?php 
               $query = $this->Crud->filter_transact('', '', $param3, 'tax');
               if(!empty($all_rec)) { $count = count($all_rec); } else { $count = 0; }
               $curr = '&#8358;';
               $item = '';
               if(!empty($query)) {
                   foreach($query as $q) {
                       $id = $q->id;
                       $user_id = $q->user_id;

                       $tax_id = $this->Crud->read_field('user_id', $user_id, 'virtual_account', 'acc_no');
                       $payment_type = $q->payment_type.' Payments';
                       $payment_method = $q->payment_method;
                       $status = $q->status;
                       $ref = $q->ref;
                       $remark = $q->remark;
                       $amount = number_format((float)$q->amount, 2);
                       $balance = curr.number_format((float)$q->balance, 2);
                       $reg_date = date('M d, Y h:i A', strtotime($q->reg_date));
                       $payment_date = date('d M, Y', strtotime($q->payment_date));

                       $st = '<span class="text-danger">'.ucwords($status).'</span>';
                       if($status != 'pending'){
                           $st = '<span class="text-success">'.ucwords($status).'</span>';
                       }
                       $rem = (float)$q->amount - (float)$q->balance;


                       // user 
                       $user = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
                       $user_image_id = $this->Crud->read_field('id', $user_id, 'user', 'img_id');
                       $user_image = $this->Crud->image($user_image_id, 'big');
                       $btn = '
                           <br><a href="javascript:;" class="btn btn-info pop mt-2" pageTitle="Tax Payment Statement" pageName="'.site_url('payments/tax/manage/view/'.$id).'" pageSize="modal-lg">
                               <i class="ni ni-eye"></i> <span class=""><b>View</b></span>
                           </a>';
                       $bal ='<br><span class="text-danger fw-bold">Bal: '.$balance.'</span>';
                       $paid = '<br><span class="text-success fw-bold">PAID: '.curr.number_format((float)$rem, 2).'</span>';

                       if($status == 'pending'){
                           $bal = '<br><span class="text-danger fw-bold">Bal: '.$balance.'</span>';
                           if($rem > 0){
                               $paid = '<br><span class="text-success fw-bold">PAID: '.curr.number_format((float)$rem, 2).'</span>';
                               $st = '<span class="text-warning">'.ucwords('Part Payment').'</span>';
                           } else {
                               $btn = '';
                           }
                       }
                       // currency

                       $item .= '
                           <tr class="nk-tb-item">
                               <td class="nk-tb-col">
                                   <span class="fw-bold text-success">'.$reg_date.'</span>
                               </td>
                               <td class="nk-tb-col">
                                   <span class="text-info">'.$curr.$amount.'</span>
                                   <div class="d-sm-none">
                                   '.$st.'
                                   </div>
                               </td>
                               <td class="nk-tb-col">
                                   '.$bal.$paid.'
                               </td>
                               <td class="nk-tb-col tb-col-md">
                                   '.$st.'
                               </td>
                               <td class="nk-tb-col tb-col-">
                                   <span class="text-dark">'.$payment_date.'</span>
                               </td>
                           </tr>
                           
                       ';
                   }
               }
               
                echo $item;
                
            ?>

        </tbody>
    </table>

<?php } ?>

<?php if($param2 == 'sms'){?>
    <div class="row">
        <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
    </div>

        
    <div class="row">
        <input type="hidden" name="user_id" value="<?php if(!empty($param3)){echo $param3;} ?>" />
        
        
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="activate"><?=translate_phrase('Message');?></label>
                <textarea class="form-control" id="message" name="message" required></textarea>
            </div>
        </div>
        <div class="col-sm-4 mb-3">
            <div class="form-group">
                <label for="activate"><?=translate_phrase('Channel');?></label>
                <select class="form-select" name="chanel" id="chanel">
                    <option value="both">SMS and Email</option>
                    <option value="sms">SMS Only</option>
                    <option value="email">Email Only</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4 mb-3">
            <div class="form-group">
                <label for="activate"><?=translate_phrase('Phone Number');?></label>
                <input type="text" readonly disabled class="form-control" value="<?=$this->Crud->read_field('id', $param3, 'user', 'phone'); ?>">
            </div>
        </div>
        <div class="col-sm-4 mb-3">
            <div class="form-group">
                <label for="activate"><?=translate_phrase('Email');?></label>
                <input type="text" readonly disabled class="form-control" value="<?=$this->Crud->read_field('id', $param3, 'user', 'email'); ?>">
            </div>
        </div>
        

        <div class="col-sm-12 text-center">
            <button class="btn btn-primary bb_fo_btn" type="submit">
                <i class="icon ni ni-send"></i> <?=translate_phrase('Send');?>
            </button>
        </div>
    </div>

<?php } ?>
<?php echo form_close(); ?>
<script>
    $('.js-select2').select2();
   
   

</script>
<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>