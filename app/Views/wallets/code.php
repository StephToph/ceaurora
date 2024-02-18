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
                <div class="nk-block-head nk-block-head-sm mt-5">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title"><?=translate_phrase('Cash Code');?></h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="more-options">
                                    <ul class="nk-block-tools g-5">
                                        <li>
                                            <div class="col-12 col-sm-12"> <label for="name" class="small text-muted"></label>
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-right">
                                                        <em class="icon ni ni-search"></em>
                                                    </div>
                                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search" oninput="load('', '')" >
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-6 col-sm-6"> <label for="name" class="small text-muted"><?=translate_phrase('START DATE');?></label>
                                                    <input type="date" class="form-control" name="start_date" id="start_date" oninput="loads()" style="border:1px solid #ddd;">
                                                </div>
                                                <div class="col-6 col-sm-6"> <label for="name" class="small text-muted"><?=translate_phrase('END DATE');?></label>
                                                    <input type="date" class="form-control" name="end_date" id="end_date" oninput="loads()" style="border:1px solid #ddd;">
                                                </div>
                                                <div class="col-md-12" style="color: transparent;"><span id="date_resul"></span></div>
                                            </div>
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div>
                            
                        </div><!-- .nk-block-head-content -->
                    </div>
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            
                            <div class="card-inner p-0">
                                <div class="nk-tb-list nk-tb-ulist"  id="load_data"> </div><!-- .nk-tb-list -->
                            </div><!-- .card-inner -->
                            <div class="card-inner p-0"  id="loadmore">
                            </div>
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
            $('#load_data').html('<div class="col-sm-12 text-center"><br/><br/><br/><br/><span class="ni ni-loader fa-spin" style="font-size:38px;"></span></div>');
            $('#total_id').html('<div class="col-sm-12 text-center"><span class="ni ni-loader fa-spin" ></span></div>');
        } else {
            $('#loadmore').html('<div class="col-sm-12 text-center"><span class="ni ni-loader fa-spin"></span></div>');
        }

        var search = $('#search').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        //alert(status);

        $.ajax({
            url: site_url + 'wallets/code/load' + methods,
            type: 'post',
            data: { search: search, start_date: start_date, end_date: end_date },
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

    function copys(text){
        var code = $("#copy_text"+text).val();
       
        // Copy the text inside the text field
        navigator.clipboard.writeText(code);
        $("#copy_resp"+text).html('Transaction Code Copied');
        setTimeout(function(){$("#copy_resp"+text).html('');}, 5000);
    }
</script>   

<?=$this->endSection();?>