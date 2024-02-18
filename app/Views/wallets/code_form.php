<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>
<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
    <!-- delete view -->
    <?php if($param2 == 'recall') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <h3><b><?=translate_phrase('Are you sure?');?></b></h3>
                <input type="hidden" name="code_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            </div>
            
            <div class="col-sm-12 text-center">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <i class="ri-delete-bin-4-line"></i> <?=translate_phrase('Yes - Recall Transaction Code');?>
                </button>
            </div>
        </div>
    <?php } ?>
    <?php if($param2 == 'send') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>
        
        <input type="hidden" id="code_id" name="code_id" value="<?=$e_id; ?>">
        <input type="hidden" id="user_id" name="user_id" value="">

        <div class="row">
            <span class="text-danger mb-3"><?=translate_phrase('An SMS fee of N5 would be deducted from your wallet to send this Cash Code');?></span>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="email"><?=translate_phrase('Recipient Phone Number');?></label>
                    <input class="form-control" type="text" id="email" name="email" minlength="11" oninput="check_account();" required>
                </div>
            </div>
            <div class="col-sm-12">
                <div id="fullname" class="text-center"></div>
            </div>
            
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="email"><?=translate_phrase('Cash Code');?></label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="code" name="code" placeholder="20000" aria-label="20000" aria-describedby="amount-addon" value="<?=$e_code; ?>" readonly>
                    </div>
                </div>
            </div>
        

            <div class="col-sm-12 text-center">
                <hr />
                <button id="btn" class="btn btn-primary bb_form_btn" type="submit" disabled>
                    <i class="anticon anticon-wallet"></i> <?=translate_phrase('Send Code');?>
                </button>
            </div>
        </div>
    <?php } ?>
    
<?php echo form_close(); ?>

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>
<script>
   
    function check_account() {
        $('#fullname').html('<?=translate_phrase('Verifying');?>...');
        var email = $('#email').val();
        
        $.ajax({
            url: '<?php echo base_url('wallets/check_account'); ?>',
            type: 'post',
            data: {email: email},
            success: function(data) {
                var dt = JSON.parse(data);
                $('#user_id').val(dt.id);
                $('#fullname').html(dt.fullname);
                
                if(email.length == 11) {
                    $('#btn').prop('disabled', false);;
                } else {
                    $('#btn').prop('disabled', true);;
                }
            }
      });
    }
    
    
</script>