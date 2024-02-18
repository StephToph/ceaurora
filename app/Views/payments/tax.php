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
    <div class="container wide-xl ">
        <div class="nk-content-inner mt-5">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Tax Invoice</h3>
                        </div>
                        <?php  if($role == 'developer' || $role == 'administrator'){?>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="javascript:;" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                <a href="javascript:;" class="float-right btn btn-primary" onclick="$('#filter_resp').toggle(500);">
                                                    <i class="icon ni ni-filter"></i> <?=translate_phrase('Filter'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <input type="hidden" id="date_type">
                    <div class="mt-5" id="filter_resp" style="display:none;">
                        <div class="row ">
                            
                            <div class="col-sm-4 mb-2">
                                <input type="text" id="search" class="form-control" placeholder="Search by Name or Email" oninput="loadPage();">
                            </div>
                            <div class="col-sm-2 mb-2">
                                <select class="form-select js-select2" id="role_ids" onchange="loadPage();">
                                    <option value="all">All Role</option>
                                    <?php
                                        $roles = $this->Crud->read_single_order('name !=', 'Developer', 'access_role', 'name', 'asc');
                                        if(!empty($roles)){
                                            foreach($roles as $r){
                                                if($r->name == 'Administrator')continue;
                                                echo '<option value="'.$r->id.'">'.$r->name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2 mb-2">
                                <select class="form-select js-select2" id="state_ids" data-search="on" onchange="get_territory();">
                                    <option value="all">All City</option>
                                    <?php
                                        $roles = $this->Crud->read_single_order('state_id', '316', 'city', 'name', 'asc');
                                        if(!empty($roles)){
                                            foreach($roles as $r){
                                                echo '<option value="'.$r->id.'">'.$r->name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2 mb-2">
                                <select class="form-select js-select2" id="territory" data-search="on" onchange="get_master();">
                                    <option value="all">All Territory</option>
                                    <?php
                                        $roles = $this->Crud->read_order('territory', 'name', 'asc');
                                        if(!empty($roles)){
                                            foreach($roles as $r){
                                                echo '<option value="'.$r->id.'">'.$r->name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2 mb-2">
                                <select class="form-select js-select2" id="master_id" data-search="on" onchange="get_operative();">
                                    <option value="all">All Tax Master</option>
                                    <?php
                                        $master = $this->Crud->read_field('name', 'Tax Master', 'access_role', 'id');
                                        $roles = $this->Crud->read_single_order('role_id', $master, 'user', 'fullname', 'asc');
                                        if(!empty($roles)){
                                            foreach($roles as $r){
                                                echo '<option value="'.$r->id.'">'.$r->fullname.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2 mb-2">
                                <select class="form-select js-select2" id="operative_id" data-search="on" onchange="loadPage();">
                                    <option value="all">All Field Operatives</option>
                                    <?php
                                        $master = $this->Crud->read_field('name', 'Field Operative', 'access_role', 'id');
                                        $roles = $this->Crud->read_single_order('role_id', $master, 'user', 'fullname', 'asc');
                                        if(!empty($roles)){
                                            foreach($roles as $r){
                                                echo '<option value="'.$r->id.'">'.$r->fullname.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                           
                            <div class="col-sm-2 mb-2">

                                <a href="javascript:;" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-calender-date"></em><span id="filter_type"><span class="d-none d-md-inline" id="filter_type"><?=translate_phrase('This'); ?></span> <?=translate_phrase('Month'); ?></span></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="javascript:;" class="typeBtn active" data-value="All"><span><?=translate_phrase('All'); ?></span></a></li>
                                        <li><a href="javascript:;" class="typeBtn" data-value="Today"><span><?=translate_phrase('Today'); ?></span></a></li>
                                        <li><a href="javascript:;" class="typeBtn" data-value="Yesterday"><span><?=translate_phrase('Yesterday'); ?></span></a></li>
                                        <li><a href="javascript:;" class="typeBtn" data-value="Last_Week"><span><?=translate_phrase('Last 7 Days'); ?></span></a></li>
                                        <li><a href="javascript:;" class="typeBtn " data-value="This_Month"><span><?=translate_phrase('This Month'); ?></span></a></li>
                                        <li><a href="javascript:;" class="typeBtn" data-value="This_Year"><span><?=translate_phrase('This Year'); ?></span></a></li>
                                        <li><a href="javascrip" class="typeBtn" data-value="Last_Month"><span><?=translate_phrase('Last 30'); ?> Days</span></a></li>
                                        <li><a href="javascript:;" class="typeBtn" data-value="Date_Range"><span><?=translate_phrase('Date Range'); ?></span></a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 mb-2" id="data-resp" style="display:none;">
                                <div class="row text-right" >
                                    <div class="col-sm-6 mb-2">
                                        <input type="date" class="form-control" name="date_from" id="date_from" oninput="loads()" style="border:1px solid #ddd;" placeholder="<?=translate_phrase('START DATE'); ?>">
                                        <span class="text-danger">Start Date</span>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <input type="date" class="form-control" name="date_to" id="date_to" oninput="loads()" style="border:1px solid #ddd;" placeholder="<?=translate_phrase('END DATE'); ?>">
                                        <span class="text-danger">End Date</span>
                                    </div>
                                   
                                </div>

                                <div class="col-sm-12" style="color:transparent; text-align:right;"><span id="date_resul"></span></div>

                            </div>
                            <div class="col-sm-2 mb-2">
                                <a href="<?=site_url('payments/tax/export'); ?>" class=" btn btn-info btn-block btn-outline-light text-white" ><em class="icon ni ni-printer"></em><span>Export</span></a>
                            </div>
                        </div>
                    </div>
                
                </div>
                <!-- .nk-block-head -->
                <?php  if($role == 'personal' || $role == 'business'){?>
                <!-- <div class="nk-block" >
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            <div class="row">
                                <div class="col-sm-8">
                                    <?php
                                       
                                        // $next_pay = $this->Crud->read_field3('user_id', $log_id, 'status', 'pending', 'payment_type', 'tax', 'transaction', 'payment_date');
                                        // $transact = $this->Crud->read3('user_id', $log_id, 'payment_type', 'tax', 'status', 'pending', 'transaction');
                                        // $amount = 0;$trans =0;$bal = 0;


                                        // $pay_date = 'No Payment Date';
                                        // if(!empty($next_pay)){
                                        //     $pay_date = date('d/m/Y', strtotime($next_pay));
                                        // }
                                        // if(!empty($transact)){
                                        //     foreach($transact as $t){
                                        //         // echo $t->payment_date;
                                        //         if(date(fdate) < $t->payment_date)continue;
                                        //         $amount += (int)$t->amount;
                                        //         $bal += (int)$t->balance;
                                        //         $trans++;
                                        //     }
                                        // }


                                        // if(date(fdate) > $next_pay){
                                        //     $code = 'info';
                                        //     $msg = 'You Have Outstanding Tax Payment of '.curr.number_format($amount,2);
                                        // } else {
                                        //     $code = 'success';
                                        //     $msg = '';
                                        //     if($bal > 0){
                                        //         $msg = 'You have a Tax Payment balance of '.curr.number_format($bal);
                                        //     } else {
                                        //         $msg = 'Your Tax Payment is up to Date. Your Next Payment Date is '.$next_pay;
                                        //     }
                                           
                                        // }
                
                                    ?>
                                    <h5 class="text-dark p-3">Next Payment Date: <?=$pay_date; ?>. <?=$msg; ?></h5>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                -->
                <?php } ?> 
                <div class="nk-block" >
                    <div class="nk-tb-list is-separate mb-3" id="load_data">
                        
                    </div>
                   <!-- .nk-tb-list -->
                   
                    <div class="nk-tb-list is-separate mb-3" >
                        <div class="col-12">
                            <nav>
                                <ul class="pagination justify-content-center pagination-lg" id="load_more">  
                                   
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="page_id" value="1">
<style>
    .showIcon::before {
        content: 'ni ni-eye'; /* Change to your desired icon for 'show' */
    }

    .hideIcon::before {
        content: ''; /* Change to your desired icon for 'hide' */
    }
</style>
<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>
<script>
    $(function() {
        <?php if($role != 'administrator' && $role != 'developer'){?>
            load('', '');
        <?php } else {?>
            // admin_load('', '');
            loadPage(1);
        <?php } ?>
        $('.js-select2').select2();
   
    });
    var page = $('#page_id').val();
   
    $('.typeBtn').click(function() {
        $('#date_type').val($(this).attr('data-value'));
        $('#filter_type').html($(this).html());
        $(this).addClass('active');
        $(this).siblings().removeClass('active');

        if($(this).attr('data-value') == 'Date_Range') {
            $('#data-resp').show(300);
        } else {
            $('#data-resp').hide(300);
            loadPage(page);
        }
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
            loadPage(page);
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
            $('#load_more').html('<div class="col-sm-12 text-center"><span class="ni ni-loader fa-spin"></span></div>');
        }

        var search = $('#search').val();
        var start_date = $('#start_date').val();
        var date_type = $('#date_type').val();
        var end_date = $('#end_date').val();
        //alert(status);

        $.ajax({
            url: site_url + 'payments/tax/load' + methods,
            type: 'post',
            data: { search: search,date_type: date_type,  start_date: start_date, end_date: end_date },
            success: function (data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }
                if (dt.offset > 0) {
                    $('#load_more').html('<a href="javascript:;" class="btn btn-dim btn-primary btn-block p-30" onclick="load(' + dt.limit + ', ' + dt.offset + ');"><em class="icon ni ni-redo fa-spin"></em> Load More</a>');
                } else {
                    $('#load_more').html('');
                }
            },
            complete: function () {
                $.getScript(site_url + '/assets/js/jsmodal.js');
            }
        });
    }

     // Function to load content for a specific page
    function loadPage(page) {
        $('#load_data').html('<div class="col-sm-12 text-center"><br/><br/><br/><br/><span class="ni ni-loader fa-spin" style="font-size:38px;"></span></div>');
        var search = $('#search').val();
        var role_id = $('#role_ids').val();
        var state_id = $('#state_ids').val();
        var start_date = $('#start_date').val();
        var territory = $('#territory').val();
        var end_date = $('#end_date').val();
        var master_id = $('#master_id').val();
        var operative_id = $('#operative_id').val();
        var date_type = $('#date_type').val();
        //alert(status);

        $.ajax({
            url: site_url + 'payments/tax/admin_loads',
            type: 'GET',
            data: { search: search, start_date: start_date, end_date: end_date, date_type: date_type, role_id: role_id, master_id: master_id, operative_id: operative_id,territory: territory, state_id: state_id },
            success: function(data) {
                var dt = JSON.parse(data);
                $('#load_data').html(dt.item);

                updatePaginationButtons(page, dt.totalPages, 4);
            },
            error: function(error) {
                console.error('Error loading page:', error);
            },
            complete: function () {
                $.getScript(site_url + '/assets/js/jsmodal.js');
            }
        });
    }

    function updatePaginationButtons(currentPage, totalPages, rangeSize) {
        $('#load_more').empty();

        var startPage = Math.max(1, currentPage - Math.floor(rangeSize / 2));
        var endPage = Math.min(totalPages, startPage + rangeSize - 1);
        $('#page_id').val(currentPage);
        // Add First button
        if (currentPage > 1) {
            $('#load_more').append('<li class="page-item"><a class="page-link" href="javascript:;" data-page="1">First</a></li>');
        }

        // Add Previous button
        if (currentPage > 1) {
            $('#load_more').append('<li class="page-item"><a class="page-link" href="javascript:;" data-page="' + (currentPage - 1) + '">Previous</a></li>');
        }

        for (var i = startPage; i <= endPage; i++) {
            var buttonClass = (i === currentPage) ? 'active' : '';
            $('#load_more').append('<li class="page-item ' + buttonClass + '"><a class="page-link" href="javascript:;" data-page="' + i + '">' + i + '</a></li>');
        }

        // Show the last two pages
        if (endPage < totalPages - 1) {
            $('#load_more').append('<li class="page-item disabled"><span class="page-link">...</span></li>');
            for (var i = totalPages - 1; i <= totalPages; i++) {
                var buttonClass = (i === currentPage) ? 'active' : '';
                $('#load_more').append('<li class="page-item ' + buttonClass + '"><a class="page-link" href="javascript:;" data-page="' + i + '">' + i + '</a></li>');
            }
        } else {
            for (var i = endPage + 1; i <= totalPages; i++) {
                var buttonClass = (i === currentPage) ? 'active' : '';
                $('#load_more').append('<li class="page-item ' + buttonClass + '"><a class="page-link" href="javascript:;" data-page="' + i + '">' + i + '</a></li>');
            }
        }

        // Add Next button
        if (currentPage < totalPages) {
            $('#load_more').append('<li class="page-item"><a class="page-link" href="javascript:;" data-page="' + (currentPage + 1) + '">Next</a></li>');
        }

        // Add Last button
        if (currentPage < totalPages) {
            $('#load_more').append('<li class="page-item"><a class="page-link" href="javascript:;" data-page="' + totalPages + '">Last</a></li>');
        }
    }

    // Handle pagination button clicks
    $(document).on('click', '.page-link', function() {
        var page = $(this).data('page');
        loadPage(page);
    });


    function admin_load(x, y) {
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
            $('#load_more').html('<div class="col-sm-12 text-center"><span class="ni ni-loader fa-spin"></span></div>');
        }

        var search = $('#search').val();
        var role_id = $('#role_ids').val();
        var state_id = $('#state_ids').val();
        var start_date = $('#start_date').val();
        var master_id = $('#master_id').val();
        var operative_id = $('#operative_id').val();
        var territory = $('#territory').val();
        var end_date = $('#end_date').val();
        var date_type = $('#date_type').val();
        //alert(status);

        $.ajax({
            url: site_url + 'payments/tax/admin_load' + methods,
            type: 'post',
            data: { search: search, start_date: start_date, end_date: end_date, date_type: date_type, role_id: role_id, master_id: master_id, operative_id: operative_id,territory: territory, state_id: state_id },
            success: function (data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }
                if (dt.offset > 0) {
                    $('#load_more').html('<a href="javascript:;" class="btn btn-dim btn-primary btn-block p-30" onclick="admin_load(' + dt.limit + ', ' + dt.offset + ');"><em class="icon ni ni-redo fa-spin"></em> Load More</a>');
                } else {
                    $('#loadmore').html('');
                }
            },
            complete: function () {
                $.getScript(site_url + '/assets/js/jsmodal.js');
            }
        });
    }

    function get_territory() {
        var state_ids = $('#state_ids').val();
        var page_id = $('#page_id').val();
        $.ajax({
            url: site_url + 'payments/tax/get_territory/' + state_ids,
            type: 'get',
            success: function (data) {
                $('#territory').html(data);
            },
            complete: function () {
                loadPage(page_id);
            }
        });
    }

    function get_master() {
        var territory = $('#territory').val();
        var page_id = $('#page_id').val();
        $.ajax({
            url: site_url + 'payments/tax/get_master/' + territory,
            type: 'get',
            success: function (data) {
                $('#master_id').html(data);
            },
            complete: function () {
                loadPage(page_id);
            }
        });
    }

    function get_operative() {
        var master_id = $('#master_id').val();
        var page_id = $('#page_id').val();
        $.ajax({
            url: site_url + 'payments/tax/get_operative/' + master_id,
            type: 'get',
            success: function (data) {
                $('#operative_id').html(data);
            },
            complete: function () {
                loadPage(page_id);
            }
        });
    }

    function view_pay(id){
        $('#pays_'+id).toggle(500);
        $('#eye_'+id).toggleClass('ni ni-eye ni ni-eye-off');
    }
</script>   

<?=$this->endSection();?>