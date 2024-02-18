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
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg pt-5">
        <div class="nk-content-body">
            <div class="buysell wide-xs m-auto">
                <div class="buysell-title text-center">
                    <h2 class="title"><?=translate_phrase('What do you want to do!'); ?></h2>
                </div><!-- .buysell-title -->
                <div class="buysell-block">
                    <?php echo form_open_multipart('payments/make_payment', array('id'=>'bb_ajax_form', 'class'=>'buysell-form')); ?>
                    <div class="row"><div id="bb_ajax_msg"></div></div>
                        <div class="buysell-field form-group">
                            <div class="form-label-group">
                                <label class="form-label"><?=translate_phrase('Choose what you want to do'); ?></label>
                            </div>
                            <input type="hidden" value="btc" name="bs-currency" id="buysell-choose-currency">
                            <div class="dropdown buysell-cc-dropdown">
                                <a href="javascript:;" id="deposit"  class="buysell-cc-choosen dropdown-indicator" data-bs-toggle="dropdown">
                                    <div class="coin-item coin-btc">
                                        <div class="coin-icon">
                                            <em class="icon ni ni-sign-kobo-alt"></em>
                                        </div>
                                        <div class="coin-info">
                                            <span class="coin-name"><?=translate_phrase('Deposit via Bank or Cash Code'); ?></span>
                                            <!-- <span class="coin-text">Last Transactions: Nov 23, 2022</span> -->
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:;" id="transfer"  class="buysell-cc-choosen dropdown-indicator" data-bs-toggle="dropdown" style="display:none;">
                                    <div class="coin-item coin-btc">
                                        <div class="coin-icon">
                                            <em class="icon ni ni-sign-kobo-alt"></em>
                                        </div>
                                        <div class="coin-info">
                                            <span class="coin-name"><?=translate_phrase('Send Cash'); ?></span>
                                            <!-- <span class="coin-text">No Transactions yet!</span> -->
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:;" id="withdraw"  class="buysell-cc-choosen dropdown-indicator" data-bs-toggle="dropdown" style="display:none;">
                                    <div class="coin-item coin-btc">
                                        <div class="coin-icon">
                                            <em class="icon ni ni-sign-kobo-alt"></em>
                                        </div>
                                        <div class="coin-info">
                                            <span class="coin-name"><?=translate_phrase('Withdraw into Bank Account?'); ?></span>
                                            <!-- <span class="coin-text">No Transactions yet!</span> -->
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:;" id="transact"  class="buysell-cc-choosen dropdown-indicator" data-bs-toggle="dropdown" style="display:none;">
                                    <div class="coin-item coin-btc">
                                        <div class="coin-icon">
                                            <em class="icon ni ni-sign-kobo-alt"></em>
                                        </div>
                                        <div class="coin-info">
                                            <span class="coin-name"><?=translate_phrase('Generate and Pay with Cash Code'); ?></span>
                                            <!-- <span class="coin-text">No Transactions yet!</span> -->
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-auto dropdown-menu-mxh">
                                    <ul class="buysell-cc-list">
                                        <li class="buysell-cc-item ">
                                            <a href="javascript:;" onclick="test('transfer');"  class="buysell-cc-opt" data-currency="btc">
                                                <div class="coin-item coin-btc">
                                                    <div class="coin-icon">
                                                        <em class="icon ni ni-sign-kobo-alt"></em>
                                                    </div>
                                                    <div class="coin-info">
                                                        <span class="coin-name"><?=translate_phrase('Send Cash') ;?></span>
                                                        <!-- <span class="coin-text">Last Transactions: Nov 23, 2019</span> -->
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="buysell-cc-item ">
                                            <a href="javascript:;" onclick="test('deposit');"  class="buysell-cc-opt" data-currency="btc">
                                                <div class="coin-item coin-btc">
                                                    <div class="coin-icon">
                                                        <em class="icon ni ni-sign-kobo-alt"></em>
                                                    </div>
                                                    <div class="coin-info">
                                                        <span class="coin-name"><?=translate_phrase('Deposit via Bank or Cash Code'); ?></span>
                                                        <!-- <span class="coin-text">No Transactions yet!</span> -->
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="buysell-cc-item">
                                            <a href="javascript:;" onclick="test('withdraw');"  class="buysell-cc-opt" data-currency="btc">
                                                <div class="coin-item coin-btc">
                                                    <div class="coin-icon">
                                                        <em class="icon ni ni-sign-kobo-alt"></em>
                                                    </div>
                                                    <div class="coin-info">
                                                        <span class="coin-name"><?=translate_phrase('Withdraw into Bank Account?'); ?></span>
                                                        <!-- <span class="coin-text">No Transactions yet!</span> -->
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="buysell-cc-item">
                                            <a href="javascript:;" onclick="test('transact');"  class="buysell-cc-opt" data-currency="btc">
                                                <div class="coin-item coin-btc">
                                                    <div class="coin-icon">
                                                        <em class="icon ni ni-sign-kobo-alt"></em>
                                                    </div>
                                                    <div class="coin-info">
                                                        <span class="coin-name"><?=translate_phrase('Generate and Pay with Cash Code'); ?> </span>
                                                        <!-- <span class="coin-text">No Transactions yet!</span> -->
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="buysell-cc-item">
                                            <a href="<?=site_url('collections/electricity'); ?>"   class="buysell-cc-opt" data-currency="btc">
                                                <div class="coin-item coin-btc">
                                                    <div class="coin-icon">
                                                        <em class="icon ni ni-sign-kobo-alt"></em>
                                                    </div>
                                                    <div class="coin-info">
                                                        <span class="coin-name"><?=translate_phrase('FundME Power'); ?></span>
                                                        <!-- <span class="coin-text">No Transactions yet!</span> -->
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div><!-- .dropdown-menu -->
                            </div><!-- .dropdown -->
                        </div><!-- .buysell-field -->
                        <input type="hidden" id="payment_type" name="payment_type" value="<?=$param1; ?>">
                        <div class="buysell-field form-group" id="beneficiary_type_card" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label" for="buysell-amount"><?=translate_phrase('Beneficiary Type'); ?></label>
                            </div>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" name="beneficiary_type" data-placeholder="<?=translate_phrase('Select Beneficiary Type'); ?>" id="beneficiary_type" data-search="on" data-ui="lg" onchange="ben_type();">
                                    <option value=""><?=translate_phrase('Select Beneficiary'); ?></option>
                                    <option value="Saved"><?=translate_phrase('Saved Beneficiary'); ?></option>
                                    <option value="New"><?=translate_phrase('New Beneficiary'); ?></option>
                                </select>
                            </div>
                        </div><!-- .buysell-field -->
                        <div class="buysell-field form-group" id="phone_card" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label" for="buysell-amount"><?=translate_phrase('Phone Number'); ?></label>
                            </div>
                            <div class="form-control-group">
                                <input type="text" class="form-control form-control-number" id="phone" name="phone" oninput="user_verify();" placeholder="<?=translate_phrase('Enter Phone Number'); ?>" value="<?=$merchant; ?>">
                            </div>
                        </div><!-- .buysell-field -->
                        <div class="buysell-field form-group" id="beneficiary_card" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label" for="buysell-amount"><?=translate_phrase('Beneficiary'); ?></label>
                            </div>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" name="beneficiary" data-placeholder="<?=translate_phrase('Select Beneficiary');?>" id="beneficiary" data-search="on" data-ui="lg" onchange="sel_beneficiary();">
                                    <option value=""><?=translate_phrase('Select Beneficiary');?></option>
                                    <?php
                                       
                                    ?>
                                        
                                </select>
                            </div>
                        </div><!-- .buysell-field -->
                        <div class="buysell-field form-group" id="save_beneficiary_card" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label" for="buysell-amount"><?=translate_phrase('Add to Beneficary List'); ?></label>
                            </div>
                            <div class="form-control-wrap">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="save_beneficiary" onchange="save_list();">
                                    <label class="custom-control-label" for="save_beneficiary"><?=translate_phrase('ADD'); ?></label>
                                </div>
                            </div>
                            <div class="ben_resp" class="text-center"></div>
                        </div><!-- .buysell-field -->
                        <div class="buysell-field form-group" id="pay_for_card" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label" for="pay_fora"><?=translate_phrase('Paying For'); ?></label>
                            </div>
                            <div class="form-control-group">
                                <select class="form-control js-select2" name="pay_for" data-placeholder="Select Payment For" id="pay_for" data-search="on" data-ui="lg" onchange="sel_paying_for();">
                                    <option value=""><?=translate_phrase('Select Payment For'); ?></option>
                                    <option value="personal"><?=translate_phrase('Personal Transaction'); ?></option>
                                    <option value="transport"><?=translate_phrase('Transportation');?></option>
                                        
                                </select>
                            </div>
                        </div>
                        <div class="buysell-field form-group" id="amount" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label" for="buysell-amount"><?=translate_phrase('Amount to'); ?> <span id="type"><?=translate_phrase('Transfer'); ?></span></label>
                            </div>
                            <div class="form-control-group">
                                <input type="text" class="form-control form-control-number" id="amounts" name="amount" placeholder="<?=translate_phrase('Enter Amount'); ?>">
                            </div>
                        </div><!-- .buysell-field -->
                        <div class="buysell-field form-group" id="pay_method" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label"><?=translate_phrase('Payment Method'); ?></label>
                            </div>
                            <div class="form-pm-group">
                                <ul class="buysell-pm-list">
                                    <li class="buysell-pm-item">
                                        <input class="buysell-pm-control" type="radio" name="payment_method" value="bank" id="bank" onclick="check_virtual_account()"/>
                                        <label class="buysell-pm-label" for="bank">
                                            <span class="pm-name"><?=translate_phrase('Bank Transfer'); ?></span>
                                            <span class="pm-icon"><em class="icon ni ni-building-fill"></em></span>
                                        </label>
                                    </li>
                                    <li class="buysell-pm-item">
                                        <input class="buysell-pm-control" type="radio" name="payment_method" id="code" value="code" onclick="meth('code')"/>
                                        <label class="buysell-pm-label" for="code">
                                            <span class="pm-name"><?=translate_phrase('Cash Code'); ?></span>
                                            <span class="pm-icon"><em class="icon ni ni-cc-alt-fill"></em></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="buysell-field form-group" id="deposit_calc" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label"> <?=translate_phrase('Amount to Receive'); ?></label>
                            </div>
                            <div class="form-pm-group mb-3">
                                <div class="form-control-group">
                                    <input type="text" class="form-control form-control-number" id="deposit_amount" name="deposit_amount" oninput="dep_calc(this);" value="0" min="0" placeholder="<?=translate_phrase('Enter Deposit Amount'); ?>">
                                </div>
                            </div>
                            <div class="form-label-group">
                                <label class="form-label"><?=translate_phrase('FundMe Fee'); ?>(1%)</label>
                            </div>
                            <div class="form-pm-group  mb-3">
                                <div class="form-control-group">
                                    <input type="text" class="form-control form-control-number" id="deposit_fee" name="deposit_fee" disabled>
                                </div>
                            </div>
                            <div class="form-label-group">
                                <label class="form-label"><?=translate_phrase('Amount to Send'); ?></label>
                            </div>
                            <div class="form-pm-group">
                                <div class="form-control-group">
                                    <input type="text" class="form-control form-control-number" id="deposit_total" name="deposit_total" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="buysell-field form-group" id="withdraw_method" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label"><?=translate_phrase('Withdraw Type'); ?></label>
                            </div>
                            <div class="form-pm-group">
                                <ul class="buysell-pm-list">
                                    <li class="buysell-pm-item">
                                        <input class="buysell-pm-control" type="radio" name="withdraw" value="personal" id="personal" onclick="withdraws('personal')"/>
                                        <label class="buysell-pm-label" for="personal">
                                            <span class="pm-name"><?=translate_phrase('Personal Bank Account'); ?></span>
                                            <span class="pm-icon"><em class="icon ni ni-building-fill"></em></span>
                                        </label>
                                    </li>
                                    <li class="buysell-pm-item">
                                        <input class="buysell-pm-control" type="radio" name="withdraw" id="other" value="other" onclick="withdraws('other')"/>
                                        <label class="buysell-pm-label" for="other">
                                            <span class="pm-name"><?=translate_phrase('Other Bank Acount'); ?></span>
                                            <span class="pm-icon"><em class="icon ni ni-cc-alt-fill"></em></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .buysell-field -->
                        <div class="buysell-field row" id="bank_view" style="display:none;">
                            <div class="col-sm-5 mb-2">
                                <div class="form-group">
                                    <label for="email"><?=translate_phrase('Bank Account'); ?></label>
                                    <?php $countries = $this->Crud->read_order('bank', 'name', 'asc'); ?>
                                    <select class="form-select js-select2" data-search="on" name="bank_account" id="bank_account"  onchange="validate_account();">
                                        <option value=""><?=translate_phrase('Select'); ?></option>
                                        <?php
                                            if(!empty($countries)) {
                                                foreach($countries as $c) {
                                                    $c_sel = '';
                                                    echo '<option value="'.$c->code.'" '.$c_sel.'>'.$c->name.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <label for="email"><?=translate_phrase('Account Number'); ?></label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="account_number" name="account_number" maxlength="10" minlength="10"  oninput="validate_account();">
                                    </div>
                                </div>
                            </div>
                        </div><!-- .buysell-field -->
                        <div class="buysell-field form-group" id="code_card" style="display:none;">
                            <div class="form-label-group">
                                <label class="form-label" for="buysell-amount"><?=translate_phrase('Code'); ?></label>
                            </div>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="transaction_code" name="transaction_code" placeholder="Cash Code">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-primary btn-dim" id="verify" onclick="verify_code();"><?=translate_phrase('Verify');?></button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .buysell-field -->
                        <div class="buysell-field form-group" id="remark_box">
                            <div class="form-label-group">
                                <label class="form-label" for="buysell-amount"><?=translate_phrase('Remark'); ?></label>
                            </div>
                            <div class="form-control-group">
                                <input type="text" class="form-control form-control-number" id="remark" name="remark" placeholder="<?=translate_phrase('Enter Remark'); ?>">
                            </div>
                        </div><!-- .buysell-field -->
                        <div class="buysell-field form-group" id="pin_box">
                            <div class="form-label-group">
                                <label class="form-label" for="buysell-amount"><?=translate_phrase('Security Pin'); ?></label>
                            </div>
                            <div class="form-control-group">
                                <input type="password" class="form-control form-control-number" id="pin" name="pin" required placeholder="<?=translate_phrase('Enter Pin');?>">
                            </div>
                        </div><!-- .buysell-field -->
                        
                        <div class="buysell-field form-group" id="resp" style="display:none; border: 1px solid #eee; padding: 25px;">
                            <div class="coin-item coin-btc" >
                                <div class="coin-icon">
                                    <em class="icon ni ni-user"></em>
                                </div>
                                <div class="coin-info" id="account_resp">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="buysell-field form-action">
                            <button type="submit" class="btn btn-lg btn-block btn-primary" id="types" disabled><?=translate_phrase('Continue to Transfer'); ?></button>
                        </div><!-- .buysell-field -->
                        <div class="form-note text-base text-center" id="fee_resp"><?=translate_phrase('Note: our transfer fee included, see our fees.'); ?></div>
                    </form><!-- .buysell-form -->
                </div><!-- .buysell-block -->
            </div><!-- .buysell -->
        </div>
    </div>
</div>
                <!-- content @e -->
<script>var site_url = '<?php echo site_url(); ?>'; 
</script> 

<script src="<?php echo site_url(); ?>assets/js/jquery.min.js"></script>

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script> 
<script src="<?php echo site_url(); ?>assets/js/payment.js"></script> 
<script>

    $(function() {
        test('<?=$param1;?>');
        <?php 
            if($param1 == 'transfer'){
                echo 'user_verify();';
            }
            if($param1 == 'deposit' && $param2 == 'code'){?>
               $('#code').prop('checked', true).trigger('click');
               <?php
                if(!empty($param3)){?>
                    $('#transaction_code').val('<?=$param3; ?>');
                    verify_code();
               <?php }
               ?>
            <?php }
        ?>
    });

</script>   


<?=$this->endSection();?>