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
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="buysell wide-xs m-auto">
                <div class="buysell-title text-center">
                    <h5 class="nk-block-title">Confirm Order</h5>
                    <div class="nk-block-text">
                        <div class="caption-text">You are about to transfer <strong>&#8358;5,968</strong> for <strong>John Doe</strong> *</div>
                    </div>
                </div><!-- .buysell-title -->
                <div class="nk-block">
                    <div class="buysell-overview">
                        <ul class="buysell-overview-list">
                            <li class="buysell-overview-item">
                                <span class="pm-title">Pay with</span>
                                <span class="pm-currency"><em class="icon ni ni-sign-kobo-alt"></em> <span>Wallet</span></span>
                            </li>
                            <li class="buysell-overview-item">
                                <span class="pm-title">Total</span>
                                <span class="pm-currency">&#8358;500.00</span>
                            </li>
                        </ul>
                        <div class="sub-text-sm">* Our transaction fee are included. <a href="javascript:;" >See transaction fee</a></div>
                    </div>
                    <!-- <div class="buysell-field form-group">
                        <div class="form-label-group">
                            <label class="form-label">Choose what you want to get</label>
                            <a href="javascript:;"  class="link">Add Wallet</a>
                        </div>
                        <input type="hidden" value="btc" name="bs-currency" id="buysell-choose-currency-modal">
                        <div class="dropdown buysell-cc-dropdown">
                            <a href="javascript:;"  class="buysell-cc-chosen dropdown-indicator" data-bs-toggle="dropdown">
                                <div class="coin-item coin-btc">
                                    <div class="coin-icon">
                                        <em class="icon ni ni-sign-btc-alt"></em>
                                    </div>
                                    <div class="coin-info">
                                        <span class="coin-name">FundME Cash Wallet</span>
                                        <span class="coin-text">1X38 * * * * YW94</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-auto dropdown-menu-mxh">
                                <ul class="buysell-cc-list">
                                    <li class="buysell-cc-item selected">
                                        <a href="javascript:;"  class="buysell-cc-opt" data-currency="btc">
                                            <div class="coin-item coin-btc">
                                                <div class="coin-icon">
                                                    <em class="icon ni ni-sign-btc-alt"></em>
                                                </div>
                                                <div class="coin-info">
                                                    <span class="coin-name">FundME Cash Wallet</span>
                                                    <span class="coin-text">1X38 * * * * YW94</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li> 
                                    <li class="buysell-cc-item">
                                        <a href="javascript:;"  class="buysell-cc-opt" data-currency="eth">
                                            <div class="coin-item coin-eth">
                                                <div class="coin-icon">
                                                    <em class="icon ni ni-sign-eth-alt"></em>
                                                </div>
                                                <div class="coin-info">
                                                    <span class="coin-name">FundME Cash Wallet</span>
                                                    <span class="coin-text">2Y68 * * * * YW94</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div><
                    </div>.buysell-field -->
                    <div class="buysell-field form-action text-center">
                        <div>
                            <a class="btn btn-primary btn-lg" href="<?=site_url('payments/success'); ?>">Confirm the Order</a>
                        </div>
                        <div class="pt-3">
                            <a href="<?=site_url('payments'); ?>"  class="link link-danger">Cancel Order</a>
                        </div>
                    </div>
                </div><!-- .buysell-block -->
            </div><!-- .buysell -->
        </div>
    </div>
</div>
                <!-- content @e -->
<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo site_url(); ?>assets/js/jquery.min.js"></script>
<script>
    $(function() {
        test('transfer');
    });

    function test(type){
        if(type == 'transfer'){
            $('#transfer').show();
            $('#deposit').hide();
            $('#withdraw').hide();
            $('#phone_card').show();
            $('#pay_method').hide();
        }
        if(type == 'deposit'){
            $('#transfer').hide();
            $('#deposit').show();
            $('#withdraw').hide();
            $('#phone_card').hide();
            $('#pay_method').show();
        }
        if(type == 'withdraw'){
            $('#transfer').hide();
            $('#deposit').hide();
            $('#withdraw').show();
            $('#phone_card').hide();
        }
        $('#type').html(type);
        $('#types').html('Continue to '+type);
        $('#type').css('textTransform', 'capitalize');
        $('#types').css('textTransform', 'capitalize');
    }
</script>   

<?=$this->endSection();?>