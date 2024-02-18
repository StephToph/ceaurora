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
                                <h3 class="nk-block-title page-title"><a href="<?=site_url('support/list');?>"><em class="ni ni-arrow-left"></em></a>                      
                                    <?=translate_phrase('Support Comment');?></h3>
                            </div><!-- .nk-block-head-content -->
                            
                        </div><!-- .nk-block-between -->
                    </div>
                    <div class="nkmsg">
                        <div class="nk-msg-bod nk-msg-aide bg-white profile-shn">
                            <div class="nk-msg-head">
                                <h4 class="title d-none d-lg-block"><?=ucwords(translate_phrase($titles)); ?></h4>
                            </div><!-- .nk-msg-head -->
                            <div class="nk-msg-reply nk-reply" data-simplebar>
                                <div class="nk-msg-head py-4 d-lg-none">
                                    <h4 class="title"><?=ucwords(translate_phrase($titles)); ?></h4>
                                   
                                </div>
                                <div class="nk-reply-item">
                                    <div class="nk-reply-header">
                                        <div class="user-card">
                                            <div class="user-avatar bg-blue">
                                                <?=$image; ?>
                                            </div>
                                            <div class="user-name"><?=ucwords($name); ?></div>
                                        </div>
                                        <div class="date-time"><?=date('M d, Y H:ia', strtotime($reg_date)); ?></div>
                                    </div>
                                    <div class="nk-reply-body">
                                        <div class="nk-reply-entry entry">
                                            <?=ucwords($details); ?>
                                        </div>
                                        <?php if(!empty($file)){ ?>
                                            <div class="attach-files">
                                                <img src="<?=site_url($file);?>">
                                            </div>
                                        <?php } else echo ' <hr>'; ?>
                                    </div>
                                   
                                </div><!-- .nk-reply-item -->
                                
                                <div class="m-5" id="load_data">
                                    
                                </div>
                                <div id="loadmore"></div><!-- .nk-reply-item -->

                                <div class="nk-reply-form">
                                    <div class="nk-reply-form-header">
                                        <ul class="nav nav-tabs-s2 nav-tabs nav-tabs-sm">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#reply-form"><?=translate_phrase('Reply');?></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content" >
                                        <div class="tab-pane active" id="reply-form">
                                            <input type="hidden" id="support_id" name="support_id" value="<?=$param1; ?>">
                                            <span id=""></span>
                                            <div class="nk-reply-form-editor">
                                                <div class="nk-reply-form-field">
                                                    <textarea class="form-control form-control-simple no-resize" id="comment" placeholder="<?=translate_phrase('Hello');?>"></textarea>
                                                </div>
                                                <div class="nk-reply-form-tools">
                                                    <ul class="nk-reply-form-actions g-1">
                                                        <li class="me-2"><button class="btn btn-primary" type="submit" onclick="com();"><?=translate_phrase('Reply');?></button></li>
                                                       
                                                    </ul>
                                                </div><!-- .nk-reply-form-tools -->
                                            </div><!-- .nk-reply-form-editor -->
                                        </div>
                                    </div>
                                </div><!-- .nk-reply-form -->
                            </div><!-- .nk-reply -->
                        </div><!-- .nk-msg-body -->
                    </div><!-- .nk-msg -->
                </div>
            </div>
        </div>
    </div>
<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo site_url(); ?>/assets/backend/js/jquery.min.js"></script>
<script>
    function com(){
        var comment = $('#comment').val();
        var support_id = $('#support_id').val();
        if(comment !== ''){
            $.ajax({
                url: site_url + 'support/save_comment',
                type: 'post',
                data: { comment: comment, support_id: support_id},
                success: function(data) {
                    $('#email_response').html(data);
                    var comment = $('#comment').val('');
                    load('', '');
                }
            });
        }
    }
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

        var status = $('#status').val();
        var search = $('#search').val();
        //alert(status);

        $.ajax({
            url: site_url + 'support/comment/'+<?=$param1;?>+'/load' + methods,
            type: 'post',
            data: { status: status, search: search },
            success: function (data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }

                if (dt.offset > 0) {
                    $('#loadmore').html('<a href="javascript:;" class="btn btn-dim btn-light btn-block p-30" onclick="load(' + dt.limit + ', ' + dt.offset + ');"><em class="icon ni ni-redo fa-spin"></em> Load More Comment</a>');
                } else {
                    $('#loadmore').html('');
                }
            },
            complete: function () {
                $.getScript(site_url + '/assets/backend/js/jsmodal.js');
            }
        });
    }
</script>   

<?=$this->endSection();?>