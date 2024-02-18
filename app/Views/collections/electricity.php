<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>

<?=$this->extend('designs/backend');?>
<?=$this->section('title');?>
    <?=$title;?>
<?=$this->endSection();?>

<?=$this->section('content');?>


<!-- content @s -->
<div class="nk-content" style="background-image: url(<?=site_url('assets/sitebk.png'); ?>);background-size: cover;">
    <div class="container-fluid">
        <div class="nk-content-inner mt-3">
        <div class="nk-content-body">
            <div class="buysell wide-xs m-auto">
                <div class="buysell-title text-center">
                    <h2 class="title"><?=translate_phrase('FundME Power') ;?></h2>
                </div><!-- .buysell-title -->
                <div class="buysell-block" id="pay_card" >
                    <?php echo form_open_multipart('payments/electricity', array('id'=>'bb_ajax_form', 'class'=>'buysell-form')); ?>
                       
                        <div id="form_card">
                            <div class="buysell-field form-group" id="phone_card">
                                <div class="form-label-group">
                                    <label class="form-label" for="buysell-amount"><?=translate_phrase('Phone Number'); ?></label>
                                </div>
                                <div class="form-control-group">
                                    <input type="text" class="form-control form-control-nuber" id="phone" name="phone" oninput="user_verify();" placeholder="<?=translate_phrase('Enter Phone Number'); ?>" value="<?=$merchant; ?>">
                                </div>
                            </div>
                            <div class="buysell-field form-group" id="user_card" ></div>
                            <div class="buysell-field form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="buysell-amount"><?=translate_phrase('State'); ?></label>
                                </div>
                                <div class="form-control-group">
                                    <select class="form-select js-select2" data-search="on" id="state_id" name="state_id">
                                        <option value=" "><?=translate_phrase('Select'); ?></option>
                                        <?php $cat = $this->Crud->read_single_order('country_id', 161, 'state', 'name', 'asc');foreach ($cat as $ca) {
                                            if($ca->name != 'Kano' && $ca->name != 'Katsina' && $ca->name != 'Jigawa')continue;
                                            ?>
                                                <option value="<?=$ca->id;?>"><?=ucwords($ca->name); ?></option>
                                            <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="buysell-field form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="buysell-amount"><?=translate_phrase('Type'); ?></label>
                                </div>
                                <div class="form-control-group">
                                    <select class="form-select js-select2" data-search="on" id="type" name="type">
                                        <option value=" "><?=translate_phrase('Select'); ?></option>
                                        <option value="prepaid"><?=translate_phrase('Prepaid'); ?></option>
                                        <option value="postpaid"><?=translate_phrase('Postpaid'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="buysell-field form-group" id="amount">
                                <div class="form-label-group">
                                    <label class="form-label" for="buysell-amount"><?=translate_phrase('Amount'); ?> </label>
                                </div>
                                <div class="form-control-group">
                                    <input type="text" class="form-control form-control-umber" id="amounts" name="amount" placeholder="<?=translate_phrase('Enter Amount'); ?>"  oninput="validateInput(this)" onkeyup="amount_verify();">
                                </div>
                            </div><!-- .buysell-field -->


                            <div class="buysell-field form-group" id="amount_card" ></div>

                        </div>

                        <div id="review_card" style="display:none;">
                            <div class="row">
                                <h5 class="text-center mt-3 mb-2"><?=translate_phrase('Review Your Order'); ?></h5>
                                <hr>
                                <div class="col-6 mb-2"><?=translate_phrase('Meter Number'); ?></div><div class="text-dark col-6 mb-2"  align="right" id="meter_nos">0</div>
                                <div class="col-6 mb-2"><?=translate_phrase('Name'); ?></div><div class="text-dark col-6 mb-2"  align="right" id="names">0</div>
                                <div class="col-6 mb-2"><?=translate_phrase('Meter Type'); ?></div><div class="text-dark col-6 mb-2"  align="right" id="types">0</div>
                                <div class="col-6 mb-2"><?=translate_phrase('Phone'); ?></div><div class="text-dark col-6 mb-2"  align="right" id="phones">0</div>
                                <div class="col-6 mb-2"><?=translate_phrase('Address'); ?></div><div class="text-dark col-6 mb-2"  align="right" id="addresss">0</div>
                                <div class="col-6 mb-2"><?=translate_phrase('Amount to Buy'); ?></div><div class="text-dark col-6 mb-2"  align="right" id="amountss">0</div>
                                <div class="col-6 mb-2"><?=translate_phrase('Service Charge'); ?></div><div class="text-dark col-6 mb-2"  align="right" id="services">0</div>
                                <div class="col-6 mb-2"><?=translate_phrase('Total Amount'); ?></div><div class="text-dark col-6 mb-2"  align="right" id="totals">0</div>
                                
                            </div>
                            <hr>
                        </div>
                        <div class="buysell-field form-group mt-3" id="pay_method" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label"><?=translate_phrase('Payment Method'); ?></label>
                            </div>
                            <div class="form-pm-group">
                                <ul class="buysell-pm-list">
                                    <li class="buysell-pm-item">
                                        <input class="buysell-pm-control" type="radio" name="payment_method" value="wallet" id="wallet" />
                                        <label class="buysell-pm-label" for="wallet">
                                            <span class="pm-name"><?=translate_phrase('Wallet'); ?></span>
                                            <span class="pm-icon"><em class="icon ni ni-wallet"></em></span>
                                        </label>
                                    </li>
                                    <li class="buysell-pm-item">
                                        <input class="buysell-pm-control" type="radio" name="payment_method" id="card" value="card" />
                                        <label class="buysell-pm-label" for="card">
                                            <span class="pm-name"><?=translate_phrase('Debit Card'); ?></span>
                                            <span class="pm-icon"><em class="icon ni ni-cc-alt-fill"></em></span>
                                        </label>
                                    </li>
                                    <li class="buysell-pm-item">
                                        <input class="buysell-pm-control" type="radio" name="payment_method" id="code" value="code" />
                                        <label class="buysell-pm-label" for="code">
                                            <span class="pm-name"><?=translate_phrase('USSD Code'); ?></span>
                                            <span class="pm-icon"><em class="icon ni ni-cc-secure-fill"></em></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        
                        <div class="buysell-field form-group" id="pin_box" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label" for="buysell-amount"><?=translate_phrase('Security Pin'); ?></label>
                            </div>
                            <div class="form-control-group">
                                <input type="password" class="form-control form-control-umber" id="pin" name="pin" required placeholder="<?=translate_phrase('Enter Pin'); ?>">
                            </div>
                        </div><!-- .buysell-field -->
                        
                       
                        <div class="buysell-field form-action">
                            <button type="button" class="btn btn-lg btn-block btn-primary" id="pay_btn" onclick="payment();"><?=translate_phrase('Proceed to Payment Page'); ?></button>
                            <button type="submit" class="btn btn-lg btn-block btn-primary" id="pays_btn" style="display:none;"><?=translate_phrase('Pay Now'); ?></button><button type="button" class="btn btn-lg btn-block btn-danger mt-2"  onclick="backs();" id="back_btn" style="display:none;"><?=translate_phrase('Make Changes'); ?></button>

                        </div><!-- .buysell-field -->
                        
                    </form><!-- .buysell-form -->
                    
                    <div class="row mt-3"><div id="bb_ajax_msg"></div></div>
                </div><!-- .buysell-block -->
                
                    
            </div><!-- .buysell -->
        </div>
        </div>
    </div>
</div>
<!-- content @e -->
<script>var site_url = '<?php echo site_url(); ?>'; 
                            
    function validateInput(input) {
        // Remove non-numeric characters using a regular expression
        input.value = input.value.replace(/\D/g, '');
    }

    function isEmpty(value) {
        if (value === null || value === undefined) {
            return true;
        }

        if (typeof value === 'string' && value.trim() === '') {
            return true;
        }

        if (Array.isArray(value) && value.length === 0) {
            return true;
        }

        if (typeof value === 'object' && Object.keys(value).length === 0) {
            return true;
        }

        return false;
    }

    function backs(){
        $('#pays_btn').hide(500);$('#pay_btn').show(500);  $('#pay_method').hide(500);$('#pin_box').hide(500);
        $('#bb_ajax_msg').html('');$('#back_btn').hide(200);
        $('#form_card').show(200);$('#review_card').hide(200);
    }

    function payment(){
        var meter_no = $('#meter_no').val();
        var name = $('#name').val();
        var type = $('#type').val();
        var phone = $('#phone').val();
        var amount = $('#amounts').val();
        var address = $('#address').val();
        
        // console.log(meter_no);console.log(name);console.log(type);console.log(phone);console.log(amount);console.log(address);
        if(isEmpty(meter_no) || isEmpty(name) || isEmpty(type) || isEmpty(phone) || isEmpty(amount) || isEmpty(address)){
            $('#bb_ajax_msg').html('<h5 class="text-danger text-center"><?=translate_phrase('Please Enter Valid Phone Number and Amount to Proceed'); ?></h5>');
            $('#pays_btn').hide();$('#pay_btn').show(500);  $('#pay_method').hide(500);$('#pin_box').hide(500);
            $('#form_card').show(200); $('#back_btn').hide(200); $('#review_card').hide(200);

        } else {
            var totals = parseFloat(amount) + 100;
            $('#pays_btn').show(500);$('#pay_btn').hide(500);  $('#pay_method').show(500);$('#pin_box').show(500);
            $('#bb_ajax_msg').html('');$('#back_btn').show(200);
            $('#form_card').hide(200); $('#review_card').show(200);

            $('#meter_nos').html(meter_no);$('#names').html(name);$('#types').html(type);$('#phones').html(phone);$('#amountss').html(amount);$('#addresss').html(address);$('#services').html(100);$('#totals').html(totals);
        }
    }

    function langs(){
        var lang = $('#lang').val();
        if(lang !== ' '){
            $('#pay_card').show(500);
            $('#lang_card').hide(500);
            
        } else{
            $('#pay_card').hide(500);
            $('#lang_card').show(500);
           
        }
    }


    function user_verify(){
        var phone = $('#phone').val();
        if(phone !== '' && phone.length == 11){
            $('#user_card').show(500);
            $('#user_card').html('<div class="col-sm-12 text-center"><br/><br/><br/><br/><div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div><?=translate_phrase('Loading'); ?>..</div>');
            $.ajax({
                url: site_url + 'payments/user_verifys/' +phone,
                type: 'post',
                success: function (data) {
                    $('#user_card').html(data);
                }
            });
        } else {
            $('#user_card').html('<div class="coin-item coin-btc text-danger" ><?=translate_phrase('Enter Phone Number'); ?>!</div>');
            
        }
    }

    function amount_verify(){
        var amounts = $('#amounts').val();
        if(amounts !== ''){
            $('#amount_card').show(500);
            $('#amount_card').html('<div class="col-sm-12 text-center"><br/><br/><br/><br/><div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div><?=translate_phrase('Loading'); ?>..</div>');
            $.ajax({
                url: site_url + 'payments/amount_verifys/' +amounts,
                type: 'post',
                success: function (data) {
                    $('#amount_card').html(data);
                }
            });
        } else {
            $('#amount_card').html('<div class="coin-item coin-btc text-danger" ><?=translate_phrase('Enter Amount'); ?>!</div>');
            
        }
    }
</script> 

<script src="<?php echo site_url(); ?>assets/js/jquery.min.js"></script>

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script> 

<?=$this->endSection();?>