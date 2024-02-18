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
    <div class="container-xl wide-lg mt-3">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title"><?=translate_phrase('Overview'); ?></h3>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <input type="hidden" id="date_type">
                                    <li>
                                        <div class="btn-group align-items-center">
                                            <select class="form-select js-select2" id="territory" data-placeholder="Select" onchange="metric_load();">
                                                <option value="all">All Territory</option>
                                                <?php
                                                    $sel = 161;
                                                    $country = $this->Crud->read_single_group_order('state_id', 316, 'city', 'territory', 'name', 'asc');
                                                    if(!empty($country)){
                                                        foreach($country as $c){
                                                            $sels = '';
                                                            if($sel == $c->id)$sels = 'selected';
                                                            // if($)
                                                            echo '<option value="'.$c->territory.'" '.$sels.'>'.ucwords(str_replace('_', ' ',$c->territory)).'</option>';
                                                        }
                                                    } 
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-12" style="color:transparent; text-align:right;"><span id="date_resul"></span></div>

                                    </li>
                                    <li>
                                        <div class="drodown">
                                            <a href="javascript:;" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-calender-date"></em><span id="filter_type"><span class="d-none d-md-inline" id="filter_type"><?=translate_phrase('This'); ?></span> <?=translate_phrase('Month'); ?></span></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="javascript:;" class="typeBtn" data-value="Today"><span><?=translate_phrase('Today'); ?></span></a></li>
                                                    <li><a href="javascript:;" class="typeBtn" data-value="Yesterday"><span><?=translate_phrase('Yesterday'); ?></span></a></li>
                                                    <li><a href="javascript:;" class="typeBtn" data-value="Last_Week"><span><?=translate_phrase('Last 7 Days'); ?></span></a></li>
                                                    <li><a href="javascript:;" class="typeBtn active" data-value=""><span><?=translate_phrase('This Month'); ?></span></a></li>
                                                    <li><a href="javascript:;" class="typeBtn" data-value="This_Year"><span><?=translate_phrase('This Year'); ?></span></a></li>
                                                    <li><a href="javascript:;" class="typeBtn" data-value="Last_Month"><span><?=translate_phrase('Last 30'); ?> Days</span></a></li>
                                                    <li><a href="javascript:;" class="typeBtn" data-value="Date_Range"><span><?=translate_phrase('Date Range'); ?></span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="btn-group align-items-center" id="data-resp" style="display:none;">
                                            &nbsp;|&nbsp;<b><?=translate_phrase('Date'); ?>:</b>&nbsp;
                                            <input type="date" class="form-control" name="date_from" id="date_from" oninput="load()" style="border:1px solid #ddd;" placeholder="<?=translate_phrase('START DATE'); ?>">
                                            &nbsp;<i class="anticon anticon-arrow-right"></i>&nbsp;
                                            <input type="date" class="form-control" name="date_to" id="date_to" oninput="load()" style="border:1px solid #ddd;" placeholder="<?=translate_phrase('END DATE'); ?>">
                                        </div>

                                        <div class="col-md-12" style="color:transparent; text-align:right;"><span id="date_resul"></span></div>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            
            <div class="nk-block">
                <div class="row gy-gs">
                    <div class="col-md-12 col-lg-4">
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
                    <div class="col-md-6 col-lg-4">
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
                    <div class="col-md-6 col-lg-4">
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
                    
                </div><!-- .row -->
            </div><!-- .nk-block -->
            <div class="nk-block">
                <div class="row gy-gs">
                    
                    <div class="col-lg-12">
                        <div class="card card-bordered h-100">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Transaction History</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner p-2" >
                                <div class="nk-tb-list nk-tb-ulist" id="load_data"></div>
                            </div><!-- .card-inner -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                    
                </div><!-- .row -->
            </div>
        </div>
    </div>
</div>
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
            metric_load();
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
            url: site_url + 'analytics/overview/tax_metric' + methods,
            type: 'post',
            data: { date_type: date_type, start_date: start_date, end_date: end_date,territory: territory, lga_id: lga_id },
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
        $('#wallet').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        var date_type = $('#date_type').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var territory = $('#territory').val();
        var lga_id = $('#lga_id').val();
        load();
        $.ajax({
            url: site_url + 'analytics/overview/metric',
            type: 'post',
            data: { date_type: date_type, start_date: start_date, end_date: end_date,territory: territory, lga_id: lga_id },
            success: function (data) {
                var dt = JSON.parse(data);
               
                $('#remittance').html(dt.remittance);
                $('#total_paid').html(dt.total_paid);
                $('#total_unpaid').html(dt.total_unpaid);
                $('#wallet').html(dt.wallet);
               
            }
        });
    }
</script> 

   
<?=$this->endSection();?>
