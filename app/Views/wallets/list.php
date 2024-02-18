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
                            <h3 class="nk-block-title page-title"><?=translate_phrase('Wallet');?></h3>
                        </div><!-- .nk-block-head-content -->
                    </div>
                </div>
                <div class="nk-lock">
                    <div class="row gy-gs">
                        <div class="col-lg-4">
                            <div class="nk-block">
                                <div class="nk-block">
                                    <div class="card card-bordered text-white bg-info h-100">
                                        <div class="card-inner">
                                            <div class="nk-wg7">
                                                <div class="nk-wg7-stats">
                                                    <div class="nk-wg7-title text-white"><?=translate_phrase('Available balance');?> </div>
                                                    <div class="number-lg amount" id="bal">&#8358;0</div>
                                                </div>
                                            </div><!-- .nk-wg7 -->
                                        </div><!-- .card-inner -->
                                    </div><!-- .card -->
                                </div> 
                            </div> 
                        </div>
                        <div class="col-lg-4">
                            <div class="nk-block">
                                <div class="nk-block">
                                    <div class="card card-bordered text-white bg-success h-100">
                                        <div class="card-inner">
                                            <div class="nk-wg7">
                                                <div class="nk-wg7-stats">
                                                    <div class="nk-wg7-title text-white"><?=translate_phrase('Credit');?> </div>
                                                    <div class="number-lg amount" id="credit">&#8358;0</div>
                                                </div>
                                            </div><!-- .nk-wg7 -->
                                        </div><!-- .card-inner -->
                                    </div><!-- .card -->
                                </div> 
                            </div> 
                        </div>
                        <div class="col-lg-4">
                            <div class="nk-block">
                                <div class="nk-block">
                                    <div class="card card-bordered text-white bg-danger h-100">
                                        <div class="card-inner">
                                            <div class="nk-wg7">
                                                <div class="nk-wg7-stats">
                                                    <div class="nk-wg7-title text-white"><?=translate_phrase('Debit');?> </div>
                                                    
                                                    <div class="number-lg amount" id="debit">&#8358;0</div>
                                                </div>
                                            </div><!-- .nk-wg7 -->
                                        </div><!-- .card-inner -->
                                    </div><!-- .card -->
                                </div> 
                            </div> 
                        </div>
                    </div><!-- .row -->
                </div> 
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title"></h3>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="more-options">
                                    <ul class="nk-block-tools g-5">
                                        <?php if($role == 'developer' || $role == 'administrator'){?>
                                            <li>
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 mt-2 "> 
                                                        <div class="custom-control custom-switch mb-5 mt-5">
                                                            <input type="checkbox" class="custom-control-input " onclick="load('','')"  id="roles">
                                                            <label class="custom-control-label" for="roles"><?=translate_phrase('View All Transaction');?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                        <li>
                                            <div class="row">
                                                <div class="col-12 col-sm-12"> 
                                                    <a href="javascript:;" class="mt-4 btn btn-white btn-outline-light" onclick="$('#filter_box').toggle();"><em class="icon ni ni-filter"></em><span><?=translate_phrase('Filter');?></span></a>
                                                </div>
                                            </div>
                                        </li>
                                        
                                    </ul>
                                    
                                </div>
                            </div>
                            
                        </div><!-- .nk-block-head-content -->
                    </div>
                    <div id="filter_box" class="nk-block-between row mt-1 mb-1" style="display:none;">
                                        
                        <div class="col-sm-4 mb-1">
                            <div class="row">
                                <div class="col-6 col-sm-6"> <label for="name" class="small text-muted"><?=translate_phrase('START DATE');?></label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" oninput="loads()" style="border:1px solid #ddd;">
                                </div>
                                <div class="col-6 col-sm-6"> <label for="name" class="small text-muted"><?=translate_phrase('END DATE');?></label>
                                    <input type="date" class="form-control" name="end_date" id="end_date" oninput="loads()" style="border:1px solid #ddd;">
                                </div>
                                <div class="col-md-12" style="color: transparent;"><span id="date_resul"></span></div>
                            </div>
                        </div>
                    
                        <div class="col-sm-3 mb-1">
                            <div class="col-12 col-sm-12"> <label for="name" class="small text-muted"></label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-search"></em>
                                    </div>
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search" oninput="load('', '')" >
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-sm-3 mb-1">
                            <div class="col-12 col-sm-12"> <label for="name" class="small text-muted"></label>
                                <select class="form-select js-select2" data-search="on" id="type" name="type" onchange="load();">
                                    <option value="all"><?=translate_phrase('All Transaction Type');?></option>
                                    <option value="deposit"><?=translate_phrase('Deposit');?></option>
                                    <option value="transfer"><?=translate_phrase('Send Cash');?></option>
                                    <option value="withdraw"><?=translate_phrase('Withdraw');?></option>
                                    <option value="transact"><?=translate_phrase('Cash Code');?></option>
                                    <option value="sms"><?=translate_phrase('SMS Charge');?></option>
                                    
                                </select>
                            </div>
                            
                        </div>
                        
                        <div class="col-sm-2 mb-1">
                            <div class="col-12 col-sm-12"> <label for="name" class="small text-muted"></label>
                                <select class="form-select js-select2" data-search="on" id="transact" name="transact" onchange="load();">
                                    <option value="all"><?=translate_phrase('All Type');?></option>
                                    <option value="debit"><?=translate_phrase('Debit');?></option>
                                    <option value="credit"><?=translate_phrase('Credit');?></option>
                                    
                                </select>
                            </div>
                            
                        </div>
                    
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            
                            
                            <div class="card-inner p-0">
                                <div class="nk-tb-list nk-tb-ulist"  id="load_data"> </div><!-- .nk-tb-list -->
                                <div class="nk-tb-list nk-tb-ulist"  id="loadmore"> </div>
                            </div><!-- .card-inner -->
                                
                        </div><!-- .card-inner-group -->
                    </div><!-- .card -->
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

    function loads() {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        if(!start_date || !end_date){
            $('#date_resul').css('color', 'Red');
            $('#date_resul').html('<?=translate_phrase('Enter Start and End Date');?>!!');
        } else if(start_date > end_date){
            $('#date_resul').css('color', 'Red');
            $('#date_resul').html('<?=translate_phrase('Start Date cannot be greater');?>!');
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
            $('#load_data').html('<div class="spinner-border" role="status">  <span class="visually-hidden">Loading...</span></div>');
            $('#total_id').html('<div class="col-sm-12 text-center"><span class="ni ni-loader fa-spin" ></span></div>');
        } else {
            $('#loadmore').html('<div class="spinner-border" role="status">  <span class="visually-hidden">Loading...</span></div>');
        }

        var search = $('#search').val();
        var type = $('#type').val();
        var transact = $('#transact').val();
        var role = $('#roles').prop('checked');
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        // Use the value of isChecked as needed
        if (role) {
            role = 'on';
        } else {
            role = 'off';
        }
        //alert(status);
        console.log(role);
        $.ajax({
            url: site_url + 'wallets/list/load' + methods,
            type: 'post',
            data: { search: search,type: type,transact: transact,role: role, start_date: start_date, end_date: end_date },
            success: function (data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }
                $('#bal').html('&#8358;'+dt.bal);
                $('#credit').html('&#8358;'+dt.credit);
                $('#debit').html('&#8358;'+dt.debit);
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