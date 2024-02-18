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
  <!-- content @s -->
    <div class="nk-content" style="background-image: url(<?=site_url('assets/sitebk.png'); ?>);background-size: cover;">
        <div class="container wide-xl ">
            <div class="nk-content-inner mt-5">
                <div class="nk-content-body">
                        <div class="nk-block-between-md g-3">
                            <div class="nk-block-head-content">
                                <div class="nk-block-head-sub"><span><?=translate_phrase('Welcome');?>!</span></div>
                                <div class="align-center flex-wrap pb-2 gx-4 gy-3">
                                    <div>
                                        <h2 class="nk-block-title fw-normal"><?=$username; ?></h2>
                                    </div>
                                    <div><a href="<?=site_url('profile'); ?>" class="btn btn-white btn-light"><?=translate_phrase('View Profile');?><em class="icon ni ni-arrow-long-right ms-2"></em></a></div>
                                </div>
                                <div class="nk-block-des">
                                    <p><?=translate_phrase('At a glance summary of your Dashboard. Have fun'); ?>!</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            
                            <div class="nk-block-head-content">
                                <div class="nk-slider nk-slider-s1">
                                    <div class="slider-init" data-slick='{"dots": true, "arrows": false, "fade": true}'>
                                        <div class="slider-item">
                                            <div class="nk-iv-wg1">
                                                <div class="nk-iv-wg1-sub sub-text">My Tax ID</div>
                                                <span id="copy_resp"></span>
                                                <?php if(!empty($this->Crud->read_field('user_id', $log_id, 'virtual_account', 'acc_no'))){?>
                                                    <h5 class="nk-iv-wg1-info title" id="tax_id" onclick="copyToClipboard()"  style="font-weight:bold;cursor:pointer;"><?=$this->Crud->read_field('user_id', $log_id, 'virtual_account', 'acc_no');?></h5><?php } else{ ?>
                                                        <div id="virtual_resp">
                                                            <button class="btn btn-info btn-block m-2" onclick="virtual_create();" type="button">Generate My Virtual Account/Tax ID</button>
                                                        </div>
                                                <?php }?>
                                                <a href="javascript:;" onclick="copyToClipboard()" class="nk-iv-wg1-link link link-light"><span>Providus Bank</span></a><br>
                                                <span class="small text-danger">Click Tax ID to copy</span>
                                            </div>
                                        </div><!-- .slider-item -->
                                    </div>
                                </div><!-- .nk-slider -->
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    
                    <!-- <div class="nk-block"><?php if($role != 'administrator' && $role != 'developer'){?>
                        <div class="nk-news card card-bordered mt-4 bg-primary">
                            <div class="card-inner" style="padding:10px;">
                                <div class="nk-news-list">
                                
                                    <a class="nk-news-item" href="javascript:;">
                                        <div class="nk-news-icon">
                                            <em class="icon ni ni-card-view " style="color:white"></em>
                                        </div>
                                        <div class="nk-news-text">
                                        <?php
                                            $next_pay = $this->Crud->read_fields2('user_id', $log_id, 'payment_type', 'tax', 'transaction', 'payment_date');
                                            $transact = $this->Crud->read3('user_id', $log_id, 'payment_type', 'tax', 'status', 'pending', 'transaction');
                                            $amount = 0;$trans =0;$bal = 0;


                                            $pay_date = 'No Payment Date';
                                            if(!empty($next_pay)){
                                                $pay_date = date('d/m/Y', strtotime($next_pay));
                                            }
                                            if(!empty($transact)){
                                                foreach($transact as $t){
                                                    $amount += (int)$t->amount;
                                                    $bal += (int)$t->balance;
                                                    $trans++;
                                                }
                                            }


                                            if(date(fdate) > $next_pay){
                    
                                                $code = 'info';
                                                $msg = 'You Have '.$trans.' Outstanding Tax Payment of '.curr.number_format($amount,2);
                                            } else {
                                                $code = 'success';
                                                $msg = '';
                                                if($bal > 0){
                                                    $msg = 'You have a Tax Payment balance of '.curr.number_format($bal);
                                                } else {
                                                    $msg = 'Your Tax Payment is up to Date. Your Next Payment Due Date is '.$next_pay;
                                                }
                                            
                                            }
                    
                                        ?>
                                            
                                                <h6 class="text-white"><span class="text-dark">Next Payment Due Date: <?=$pay_date; ?>.</span> <?=$msg; ?></h6>
                                            
                                        </div>
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>.nk-block -->
                    <div class="nk-block">
                        <div class="row gy-gs">
                            <div class="col-md-6 col-lg-3">
                                <div class="nk-wg-card card card-bordered"  style="background-color:#24a859;">
                                    <div class="card-inner">
                                        <div class="nk-iv-wg2">
                                            <div class="nk-iv-wg2-title">
                                                <h6 class="title text-white"><?=translate_phrase('Annual Remittance'); ?></h6>
                                            </div>
                                            <div class="nk-iv-wg2-text">
                                                <div class="nk-iv-wg2-amount text-white"><?=curr; ?> <span id="remittance">0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-md-6 col-lg-3">
                                <div class="nk-wg-card is-s1 card card-bordered">
                                    <div class="card-inner">
                                        <div class="nk-iv-wg2">
                                            <div class="nk-iv-wg2-title">
                                                <h6 class="title"><?=translate_phrase('Total Paid'); ?> </h6>
                                            </div>
                                            <div class="nk-iv-wg2-text">
                                                <div class="nk-iv-wg2-amount"><?=curr; ?> <span id="total_paid">0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-md-6 col-lg-3">
                                <div class="nk-wg-card is-s3 card card-bordered">
                                    <div class="card-inner">
                                        <div class="nk-iv-wg2">
                                            <div class="nk-iv-wg2-title">
                                                <h6 class="title"><?=translate_phrase('Total Unpaid' ); ?> </h6>
                                            </div>
                                            <div class="nk-iv-wg2-text">
                                                <div class="nk-iv-wg2-amount"> <?=curr; ?> <span id="total_unpaid">0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-md-6 col-lg-3">
                                <div class="nk-wg-card is-s2 card card-bordered">
                                    <div class="card-inner">
                                        <div class="nk-iv-wg2">
                                            <div class="nk-iv-wg2-title">
                                                <h6 class="title"><?=translate_phrase('Payment Cycle').' - '.translate_phrase($this->Crud->read_field('id', $log_id, 'user', 'duration')); ?> </h6>
                                            </div>
                                            <div class="nk-iv-wg2-text">
                                                <?php
                                                    $duration = $this->Crud->read_field('id', $log_id, 'user', 'duration');
                                                    $trade = $this->Crud->read_field('id', $log_id, 'user', 'trade');
                                                    $amount = $this->Crud->read_field('id', $trade, 'trade', 'medium');
                                                    
                                                    $cycle = $this->Crud->trade_duration($amount, $duration);
                                                    if(empty($cycle)){
                                                        $cycle = 0;
                                                    }
                                                ?>
                                                <div class="nk-iv-wg2-amount"> <?=curr; ?> <span id="total_unpaid"><?=number_format($cycle,2); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->

                            <?php if($role != 'personal' && $role != 'business'){?>
                                <div class="col-md-6 col-lg-3">
                                    <div class="nk-wg-card bg-primary card card-bordered">
                                        <div class="card-inner">
                                            <div class="nk-iv-wg2">
                                                <div class="nk-iv-wg2-title">
                                                    <h6 class="title text-white"><?=translate_phrase('Personal Tax Payer'); ?></h6>
                                                </div>
                                                <div class="nk-iv-wg2-text">
                                                    <div class="nk-iv-wg2-amount text-white"> <span id="personal">0</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->
                                <div class="col-md-6 col-lg-3">
                                    <div class="nk-wg-card bg-azure card card-bordered">
                                        <div class="card-inner">
                                            <div class="nk-iv-wg2">
                                                <div class="nk-iv-wg2-title">
                                                    <h6 class="title text-white"><?=translate_phrase('Business Tax Payer'); ?> </h6>
                                                </div>
                                                <div class="nk-iv-wg2-text">
                                                    <div class="nk-iv-wg2-amount text-white"> <span id="business">0</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->
                                <div class="col-md-6 col-lg-3">
                                    <div class="nk-wg-card is-s3  card card-bordered">
                                        <div class="card-inner">
                                            <div class="nk-iv-wg2">
                                                <div class="nk-iv-wg2-title">
                                                    <h6 class="title"><?=translate_phrase('Field Operatives'); ?> </h6>
                                                </div>
                                                <div class="nk-iv-wg2-text">
                                                    <div class="nk-iv-wg2-amount">  <span id="field">0</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->
                                <div class="col-md-6 col-lg-3">
                                    <div class="nk-wg-card is-s2 card card-bordered">
                                        <div class="card-inner">
                                            <div class="nk-iv-wg2">
                                                <div class="nk-iv-wg2-title">
                                                    <h6 class="title"><?=translate_phrase('Tax Master'); ?> </h6>
                                                </div>
                                                <div class="nk-iv-wg2-text">
                                                    <div class="nk-iv-wg2-amount">  <span id="master">0</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->
                            <?php } ?>
                        </div><!-- .row -->
                    </div><!-- .nk-block -->
                    <div class="nk-block">
                        <div class="row gy-gs">
                            
                            <div class="col-lg-9">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner border-bottom">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Transaction History</h6>
                                            </div>
                                            <div class="card-tools">
                                                <a href="<?=site_url('payments/tax'); ?>" class="link">See Details</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner p-2" >
                                        <div class="nk-tb-list nk-tb-ulist" id="load_data"></div>
                                    </div><!-- .card-inner -->
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-lg-3">
                                <img src="<?=site_url('assets/bg.jpeg'); ?>">
                            </div><!-- .col -->
                            <div class="col-lg-12 col-xxl-12">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner card-inner-lg">
                                        <div class="align-center flex-wrap g-4">
                                            <div class="nk-block-image w-120px flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 118">
                                                    <path d="M8.916,94.745C-.318,79.153-2.164,58.569,2.382,40.578,7.155,21.69,19.045,9.451,35.162,4.32,46.609.676,58.716.331,70.456,1.845,84.683,3.68,99.57,8.694,108.892,21.408c10.03,13.679,12.071,34.71,10.747,52.054-1.173,15.359-7.441,27.489-19.231,34.494-10.689,6.351-22.92,8.733-34.715,10.331-16.181,2.192-34.195-.336-47.6-12.281A47.243,47.243,0,0,1,8.916,94.745Z" transform="translate(0 -1)" fill="#f6faff" />
                                                    <rect x="18" y="32" width="84" height="50" rx="4" ry="4" fill="#fff" />
                                                    <rect x="26" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                                    <rect x="50" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                                    <rect x="74" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                                    <rect x="38" y="60" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                                    <rect x="62" y="60" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                                    <path d="M98,32H22a5.006,5.006,0,0,0-5,5V79a5.006,5.006,0,0,0,5,5H52v8H45a2,2,0,0,0-2,2v4a2,2,0,0,0,2,2H73a2,2,0,0,0,2-2V94a2,2,0,0,0-2-2H66V84H98a5.006,5.006,0,0,0,5-5V37A5.006,5.006,0,0,0,98,32ZM73,94v4H45V94Zm-9-2H54V84H64Zm37-13a3,3,0,0,1-3,3H22a3,3,0,0,1-3-3V37a3,3,0,0,1,3-3H98a3,3,0,0,1,3,3Z" transform="translate(0 -1)" fill="#798bff" />
                                                    <path d="M61.444,41H40.111L33,48.143V19.7A3.632,3.632,0,0,1,36.556,16H61.444A3.632,3.632,0,0,1,65,19.7V37.3A3.632,3.632,0,0,1,61.444,41Z" transform="translate(0 -1)" fill="#6576ff" />
                                                    <path d="M61.444,41H40.111L33,48.143V19.7A3.632,3.632,0,0,1,36.556,16H61.444A3.632,3.632,0,0,1,65,19.7V37.3A3.632,3.632,0,0,1,61.444,41Z" transform="translate(0 -1)" fill="none" stroke="#6576ff" stroke-miterlimit="10" stroke-width="2" />
                                                    <line x1="40" y1="22" x2="57" y2="22" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                    <line x1="40" y1="27" x2="57" y2="27" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                    <line x1="40" y1="32" x2="50" y2="32" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                    <line x1="30.5" y1="87.5" x2="30.5" y2="91.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                                    <line x1="28.5" y1="89.5" x2="32.5" y2="89.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                                    <line x1="79.5" y1="22.5" x2="79.5" y2="26.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                                    <line x1="77.5" y1="24.5" x2="81.5" y2="24.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                                    <circle cx="90.5" cy="97.5" r="3" fill="none" stroke="#9cabff" stroke-miterlimit="10" />
                                                    <circle cx="24" cy="23" r="2.5" fill="none" stroke="#9cabff" stroke-miterlimit="10" />
                                                </svg>
                                            </div>
                                            <div class="nk-block-content">
                                                <div class="nk-block-content-head">
                                                    <h5>We’re here to help you!</h5>
                                                    <p style="font-size:16px;" class="text-soft">Ask a question or file a support ticket, manage request, report an issues. Our team support team will get back to you by email.</p>
                                                </div>
                                            </div>
                                            <div class="nk-block-content flex-shrink-0">
                                                <a href="mailto:admin@zend.ng?subject=Support%20Ticket" class="btn btn-lg btn-outline-primary">Get Support Now</a>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                </div><!-- .card -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
            <!-- content @e -->
<!-- content @e -->
<?=$this->endSection();?>
<?=$this->section('scripts');?>

<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>
<script>
    $(function() {
        load('', '');
        metric_load();
    });

    $('.typeBtn').click(function() {
        $('#date_type').val($(this).attr('data-value'));
        $('#filter_type').html($(this).html());
        $(this).addClass('active');
        $(this).siblings().removeClass('active');

        if($(this).attr('data-value') == 'Date_Range') {
            $('#data-resp').show(300);
        } else {
            $('#data-resp').hide(300);
            metric_load();load();
        }
    });
    function load(x, y) {
        

        var more = 'no';
        var methods = '';
        if (parseInt(x) > 0 && parseInt(y) > 0) {
            more = 'yes';
            methods = '/' + x + '/' + y;
        }

        if (more == 'no') {
            $('#load_data').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><span><?=translate_phrase('Loading.. Please Wait'); ?></span></div>');
            $('#total_id').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        } else {
            $('#loadmore').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><?=translate_phrase('Loading.. PLease Wait'); ?></div>');
        }

        var loads = '<?=translate_phrase('Load More'); ?>';
        var date_type = $('#date_type').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var territory = $('#territory').val();
        var lga_id = $('#lga_id').val();

        $.ajax({
            url: site_url + 'dashboard/index/tax_metric' + methods,
            data: { date_type: date_type, start_date: start_date, end_date: end_date,territory: territory, lga_id: lga_id },
            type: 'post',
            success: function (data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }
            },
            complete: function () {
                $.getScript(site_url + '/assets/js/jsmodal.js');
            }
        });
    }

    function metric_load() {
        $('#remittance').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#total_paid').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#total_unpaid').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#personal').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#business').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#master').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#field').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        var date_type = $('#date_type').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var territory = $('#territory').val();
        var lga_id = $('#lga_id').val();
      
        $.ajax({
            url: site_url + 'dashboard/metric',
            type: 'post',
            data: { date_type: date_type, start_date: start_date, end_date: end_date,territory: territory, lga_id: lga_id },
            success: function (data) {
                var dt = JSON.parse(data);
               
                $('#remittance').html(dt.remittance);
                $('#total_paid').html(dt.total_paid);
                $('#total_unpaid').html(dt.total_unpaid);
                $('#personal').html(dt.personal);
                $('#business').html(dt.business);
                $('#master').html(dt.master);
                $('#field').html(dt.field);
               
            }
        });
    }

    function virtual_create(){
        $('#virtual_resp').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $.ajax({
            url: site_url + 'dashboard/create_virtual',
            type: 'post',
            success: function (data) {
                $('#virtual_resp').html(data);
               
            }
        });
    }

    function copyToClipboard() {
        // Get the text content of the div
        var textToCopy = document.getElementById('tax_id').innerText;

        // Create a textarea element to temporarily hold the text
        var textarea = document.createElement('textarea');
        textarea.value = textToCopy;
        document.body.appendChild(textarea);

        // Select the text in the textarea
        textarea.select();
        textarea.setSelectionRange(0, textarea.value.length);

        // Copy the selected text to the clipboard
        document.execCommand('copy');

        // Remove the textarea from the DOM
        document.body.removeChild(textarea);
        $('#copy_resp').html('<span class="text-danger">Tax ID Copied</span>');
        // Optionally, provide some visual feedback (e.g., an alert)
        setTimeout(function() {
            $('#copy_resp').html('');
        }, 3000);
    }
</script> 
<?=$this->endSection();?>
