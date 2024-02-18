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
                            <h3 class="nk-block-title page-title mt-4"><?=translate_phrase('Campaign Promotion');?></h3>
                            <div class="nk-block-des text-soft">
                            
                                <p><?=translate_phrase('You have total');?> <span id="listCount">0</span> <?=translate_phrase('promotion');?></p>
                            </div>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="more-options">
                                    <ul class="nk-block-tools g-3">
                                        <li class="nk-block-tools-opt">
                                            <div class="drodown">
                                                <a href="javascript:;" class="btn btn-icon btn-lg btn-primary pop" pagetitle="<?=translate_phrase('Add Promotion');?>" pagesize="modal-md" pagename="<?=site_url('campaign/promotion/manage'); ?>"><em class="icon ni ni-plus-c"></em></a>   
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-search"></em>
                                                </div>
                                                <input type="text" class="form-control" id="search" name="search" placeholder="Search" oninput="load('', '')" >
                                            </div>
                                        </li>
                                        <?php if($role == 'developer' || $role == 'administrator'){?>
                                            <li>
                                                <select class="form-control js-select2"  name="partner" id="partner" onchange="load('', '')">
                                                    <option value="all"><?=translate_phrase('All Partner');?></option>
                                                    <?php $pat =$this->Crud->read_single_order('role_id', 3, 'user', 'fullname', 'asc');
                                                        if(!empty($pat)){
                                                            foreach($pat as $part){?>
                                                                <option value="<?=$part->id; ?>"><?=ucwords($part->fullname); ?></option>
                                                        <?php } }?>
                                                </select>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .nk-block-head-content -->
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
   
    function load(x, y) {
        var more = 'no';
        var methods = '';
        if (parseInt(x) > 0 && parseInt(y) > 0) {
            more = 'yes';
            methods = '/' + x + '/' + y;
        }

        if (more == 'no') {
            $('#load_data').html('<div class="col-sm-12 text-center"><br/><br/><br/><br/><span class="ni ni-loader fa-spin" style="font-size:38px;"></span></div>');
        } else {
            $('#loadmore').html('<div class="col-sm-12 text-center"><span class="ni ni-loader fa-spin"></span></div>');
        }

        var partner = $('#partner').val();
        var search = $('#search').val();
        //alert(status);

        $.ajax({
            url: site_url + 'campaign/promotion/load' + methods,
            type: 'post',
            data: { partner: partner, search: search },
            success: function (data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }
                $('#listCount').html(dt.count);
                if (dt.offset > 0) {
                    $('#loadmore').html('<a href="javascript:;" class="btn btn-dim btn-light btn-block p-30" onclick="load(' + dt.limit + ', ' + dt.offset + ');"><em class="icon ni ni-redo fa-spin"></em> Load ' + dt.left + ' More</a>');
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