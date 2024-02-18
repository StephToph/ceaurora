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
            <div class="nk-content-body mt-3">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between ">
                        <div class="nk-block-head-content ">
                            <h3 class="nk-block-title page-title"><?=translate_phrase('Support Ticket');?></h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle ">
                                <a href="javascript:;" pageTitle="<?=translate_phrase('Create');?>" pageName="<?=site_url('support/list/manage'); ?>" class="btn btn-icon btn-xl btn-success pop "><em class="icon ni ni-plus-c"></em></a>
                            </div>
                            
                        </div><!-- .nk-block-head-content -->
                    </div>
                </div><!-- .nk-block-head -->
                <div class="nk-msg" id="load_data">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
<input type="hidden" id="status" value="1">
<input type="hidden" id="page_active" value="1">
<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo site_url(); ?>assets/js/jquery.min.js"></script>

<script>
    $(function() {
        load('', '');
    });
    function supports(stat){
        if(stat == 1){
            stat = 'active';
            $('#status').val('1');
        }
        if(stat == 2){
            stat = 'close';
            $('#status').val('0');
        }
        if(stat == 3){
            stat = 'all';
            $('#status').val(stat);
        }
        load('','');
        
    }

    function page_active(x, id){
        $(".nk-msg-item").removeClass("current");
        $("#support_id"+x).addClass("current");
        $("#page_active").val(x);
        $("#support_body").html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div> Loading. Please Wait</div>');
        
        $.ajax({
            url: site_url + 'support/comment/'+id+ '/load',
            type: 'post',
            success: function (data) {
                var dt = JSON.parse(data);
                $("#support_body").html(dt.item);
       
            }
        });

    }

    function reply_btn(id){
        var reply = $('#reply').val();
        var page = $("#page_active").val();
        
        if(reply !== ''){
            $.ajax({
                url: site_url + 'support/save_comment',
                type: 'post',
                data: { reply: reply, id: id },
                success: function (data) {
                    page_active(page, id);
        
                }
            });

        }
        
    }

    function mark_reads(id){
        //alert(id);
        $.ajax({
            url: site_url + 'support/mark/' + id,
            type: 'post',
            success: function (data) {
               $('#support_resp').html('<li><span class="text-info><?=translate_phrase('Closed');?></span></li>');
            }
        });

        
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
        } else {
            $('#loadmore').html('<div class="col-sm-12 text-center"><span class="ni ni-loader fa-spin"></span></div>');
        }

        var status = $('#status').val();
        var page_active = $('#page_active').val();
        var search = $('#search').val();
        //alert(status);

        $.ajax({
            url: site_url + 'support/list/load' + methods,
            type: 'post',
            data: { status: status, search: search, page_active: page_active },
            success: function (data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }

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