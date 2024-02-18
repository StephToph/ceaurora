<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>

<?=$this->extend('designs/backend');?>
<?=$this->section('title');?>
    <?=$title;?>
<?=$this->endSection();?>

<?=$this->section('content');?>
<div class="nk-content" style="background-image: url(<?=site_url('assets/sitebk.png'); ?>);background-size: cover;">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Transaction History</h3>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                
                <div class="nk-block" >
                <div class="row">
                            <input type="hidden" id="date_type">
                            
                            <div class="col-md-12 mb-2 text-end">
                                            
                                <div class="btn-group align-items-center">
                                    <?php if($role != 'personal' && $role != 'business'){?>
                                    <select class="form-select js-select2 mr-2 mx-2" id="lga_id" data-placeholder="Select" onchange="metric_load();">
                                        <option value="all">All LGA</option>
                                        <?php
                                            $sel = 161;
                                            $country = $this->Crud->read_single_order('state_id', 316, 'city', 'name', 'asc');
                                            if(!empty($country)){
                                                foreach($country as $c){
                                                    $sels = '';
                                                    if($sel == $c->id)$sels = 'selected';
                                                    // if($)
                                                    echo '<option value="'.$c->id.'" '.$sels.'>'.ucwords(str_replace('_', ' ',$c->name)).'</option>';
                                                }
                                            } 
                                        ?>
                                    </select>
                                    <select class="form-select js-select2 ml-2 mx-2" id="territory" data-placeholder="Select" onchange="metric_load();">
                                        <option value="all">All Territory</option>
                                        <?php
                                            $sel = 161;
                                            $country = $this->Crud->read_order( 'territory', 'name', 'asc');
                                            if(!empty($country)){
                                                foreach($country as $c){
                                                    $sels = '';
                                                    if($sel == $c->id)$sels = 'selected';
                                                    // if($)
                                                    echo '<option value="'.$c->id.'" '.$sels.'>'.ucwords(str_replace('_', ' ',$c->name)).'</option>';
                                                }
                                            } 
                                        ?>
                                    </select>
                                    <?php } ?>
                                    <div class="dropdown mx-2">
                                        <a href="javascript:;" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class=" d-sm-inline icon ni ni-calender-date"></em><span id="filter_type"><span class="d-none d-md-inline" id="filter_type"><?=translate_phrase('This'); ?></span> <?=translate_phrase('Month'); ?></span></a>
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

                                    <div class="btn-group" id="data-resp" style="display:none;">
                                        <b><?=translate_phrase('Date'); ?>:</b>&nbsp;
                                        <input type="date" class="form-control" name="date_from" id="date_from" oninput="load()" style="border:1px solid #ddd;" placeholder="<?=translate_phrase('START DATE'); ?>">
                                        &nbsp;<i class="icon ni  ni-arrow-right"></i>&nbsp;
                                        <input type="date" class="form-control" name="date_to" id="date_to" oninput="load()" style="border:1px solid #ddd;" placeholder="<?=translate_phrase('END DATE'); ?>">
                                    </div>
                                </div>
                                            
                                <div class="col-md-12" style="color:transparent; text-align:right;"><span id="date_resul"></span></div>
                            </div>
                        </div>
                        
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            <div class="nk-tb-list nk-tb-ulist mb-3" id="load_data">
                        
                            </div>
                            <div id="loadmore"></div><!-- .nk-tb-list -->
                        </div><!-- .nk-block -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>
<script>
    $(function() {
        load('', '');
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
            load();
        }
    });
    function loads() {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        if(!start_date || !end_date){
            $('#date_resul').css('color', 'Red');
            $('#date_resul').html('Enter Start and End Date!!');
        } else if(start_date > end_date){
            $('#date_resul').css('color', 'Red');
            $('#date_resul').html('Start Date cannot be greater!');
        } else {
            $('#date_resul').html('');
            load('', '');
        }
    }
   
    function load(x, y) {
        var more = 'no';
        var methods = '';
        if (parseInt(x) > 0 && parseInt(y) > 0) {
            more = 'yes';
            methods = '/' + x + '/' + y;
        }

        if (more == 'no') {
            $('#load_data').html('<div class="col-sm-12 text-center"><br/><br/><br/><br/><span class="ni ni-loader fa-spin" style="font-size:38px;"></span></div>');
            $('#total_id').html('<div class="col-sm-12 text-center"><span class="ni ni-loader fa-spin" ></span></div>');
        } else {
            $('#loadmore').html('<div class="col-sm-12 text-center"><span class="ni ni-loader fa-spin"></span></div>');
        }

        var date_type = $('#date_type').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var territory = $('#territory').val();
        var lga_id = $('#lga_id').val();
        //alert(status);

        $.ajax({
            url: site_url + 'payments/transaction/load' + methods,
            type: 'post',
            data: { date_type: date_type, start_date: start_date, end_date: end_date,territory: territory, lga_id: lga_id },
            success: function (data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }
                if (dt.offset > 0) {
                    $('#loadmore').html('<a href="javascript:;" class="btn btn-dim btn-light btn-block p-30" onclick="load(' + dt.limit + ', ' + dt.offset + ');"><em class="icon ni ni-redo fa-spin"></em> Load More</a>');
                } else {
                    $('#loadmore').html('');
                }
            },
            complete: function () {
                $.getScript(site_url + '/assets/js/jsmodal.js');
            }
        });
    }
</script>   

<?=$this->endSection();?>