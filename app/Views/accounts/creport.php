<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>

<?=$this->extend('designs/backend');?>
<?=$this->section('title');?>
    <?=$title;?>
<?=$this->endSection();?>

<?=$this->section('content');?>
<div class="nk-content" >
    <div class="container-fluid mt-3">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title"><?=translate_phrase('Cell Report');?></h3>
                            
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="card-title-group">
                                    <div class="card-tools">
                                        
                                    </div><!-- .card-tools -->
                                    <div class="card-tools me-n1">
                                        <ul class="btn-toolbar gx-1">
                                            <li>
                                                <a href="javascript:;"  id="add_btn" class="btn btn-icon btn-outline-primary"><em class="icon ni ni-plus-c"></em></a>
                                            </li><!-- li -->
                                           
                                        </ul><!-- .btn-toolbar -->
                                    </div><!-- .card-tools -->
                                </div><!-- .card-title-group -->
                                
                            </div><!-- .card-inner -->
                            <div class="card-inner" id="show">
                                <div class="nk-tb-list nk-tb-ulist" id="load_data">
                                </div><!-- .nk-tb-list -->
                            
                                <div class="nk-block-between-md g-3" id="loadmore">
                                </div><!-- .nk-block-between -->
                            </div>
                            <div class="card-inner" id="form" style="display:none;">
                               <div class="row">
                                    <div class="nk-block-head-sub mb-3" id="prev" style="display:none;">
                                        <a class="back-to" id="back_btn" href="javascript:;"><em class="icon ni ni-arrow-left"></em><span>Cell Reports</span></a>
                                    </div>
                                    <h5>Enter the Details for the Cell Meeting Below</h5>
                                    
                                    <?php echo form_open_multipart('accounts/creport/manage', array('id'=>'bb_ajax_form', 'class'=>'row mt-4')); ?>
                                        <input type="hidden" name="creport_id" id="report_id" value="<?php if(!empty($e_id)){echo $e_id;}?>">
                                        <?php if($role == 'developer' || $role == 'administrator'){?>
                                        <div class="col-sm-4 mb-3">
                                            <div class="form-group">
                                                <label for="name">*<?=translate_phrase('Cell'); ?></label>
                                                <select data-search="on" class=" js-select2" id="cells_id" name="cell_id" onchange="updatePageName()">
                                                    <option value="">Select</option>
                                                    <?php
                                                        $cell = $this->Crud->read_order('cells', 'name', 'asc');
                                                        if(!empty($cell)){
                                                            foreach($cell as $c){
                                                                $sel = '';
                                                                if(!empty($e_cell_id)){
                                                                    if($e_cell_id == $c->id)$sel = 'selected';    
                                                                }
                                                                echo '<option value="'.$c->id.'" '.$sel.'>'.ucwords($c->name).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php } else{?>
                                            <input type="hidden" name="cell_id" value="">
                                        <?php } ?>
                                        <div class="col-sm-4 mb-3">
                                            <div class="form-group">
                                                <label for="name">*<?=translate_phrase('Meeting Type'); ?></label>
                                                <select data-search="on" class=" js-select2" id="type" name="type">
                                                    <option value="">Select</option>
                                                    <option value="wk1" >WK1 - Prayer and Planning</option>
                                                    <option value="wk2" >WK2 - Bible Study</option>
                                                    <option value="wk3" >WK3 - Bible Study</option>
                                                    <option value="wk4" >WK4 - Fellowship / Outreach</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <div class="form-group">    
                                                <label class="name">*Date</label>    
                                                <div class="form-control-wrap">        
                                                    <input type="text" name="dates" id="dates" class="form-control date-picker" required>   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <div class="form-group">
                                                <label for="name">*<?=translate_phrase('Attendance'); ?></label>
                                                <div class="form-control-wrap">    
                                                    <div class="input-group">        
                                                        <input type="text" name="attendance" id="attendance" oninput="this.value = this.value.replace(/[^\d.]/g,'');this.value = this.value.replace(/(\..*)\./g,'$1')" class="form-control" placeholder="">        
                                                        <div class="input-group-append">            
                                                            <button type="button"  class="btn btn-outline-primary btn-dim pop" pageTitle="Mark Meeting Attendance" pageSize="modal-lg" pageName="<?php echo  site_url('accounts/creport/manage/attendance'); ?>" id="markButton">MARK</button>        
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <div class="form-group">
                                                <label for="name"><?=translate_phrase('New Convert'); ?></label>
                                                <div class="form-control-wrap">    
                                                    <div class="input-group">        
                                                        <input type="text" id="new_convert" class="form-control" oninput="this.value = this.value.replace(/[^\d.]/g,'');this.value = this.value.replace(/(\..*)\./g,'$1')" name="new_convert" placeholder="">        
                                                        <div class="input-group-append">            
                                                            <button type="button"  class="btn btn-outline-primary btn-dim pop" pageTitle="Mark Meeting Attendance" pageSize="modal-lg" pageName="<?=site_url('accounts/creport/manage/new_convert'); ?>">ADD</button>        
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <div class="form-group">
                                                <label for="name"><?=translate_phrase('First Timer'); ?></label>
                                                <div class="form-control-wrap">    
                                                    <div class="input-group">        
                                                        <input type="text" id="first_timer" name="first_timer" oninput="this.value = this.value.replace(/[^\d.]/g,'');this.value = this.value.replace(/(\..*)\./g,'$1')" class="form-control" placeholder="">        
                                                        <div class="input-group-append">            
                                                            <button type="button"  class="btn btn-outline-primary btn-dim pop" pageTitle="Mark Meeting Attendance" pageSize="modal-lg" pageName="<?=site_url('accounts/creport/manage/first_timer'); ?>">ADD</button>        
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <div class="form-group">
                                                <label for="name">*<?=translate_phrase('Offering'); ?></label>
                                                <input class="form-control" id="offering" type="text" id="offering" oninput="this.value = this.value.replace(/[^\d.]/g,'');this.value = this.value.replace(/(\..*)\./g,'$1')" name="offering"  required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <div class="form-group">
                                                <label for="name"><?=translate_phrase('Note'); ?></label>
                                                <textarea class="form-control"  id="note" name="note" ></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 text-center mt-3">
                                            <button class="btn btn-primary bb_fo_btn" type="submit">
                                                <em class="icon ni ni-save"></em> <span><?=translate_phrase('Save Record');?></span>
                                            </button>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-sm-12 my-3"><div id="bb_ajax_msg"></div></div>
                                    </div>
                               </div>
                            </div><!-- .card-inner -->
                        </div><!-- .card-inner-group -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
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
    
    var initialInfo = {
        class: 'btn-outline-primary',
        onclick: 'add_report();',
        iconClass: 'ni-plus-c'
    };

    var newInfo = {
        class: 'btn-outline-success',
        onclick: 'load();',
        iconClass: 'ni-eye'
    };
    var currentInfo = initialInfo;

    $('#add_btn').click(function() {
        $('#show').toggle(500);
        $('#form').toggle(500);
        
        $('#prev').hide(500);
        // Toggle between initial and new info
        currentInfo = (currentInfo === initialInfo) ? newInfo : initialInfo;

        // Update button class, onclick function, and icon class
        $(this).removeClass().addClass('btn btn-icon ' + currentInfo.class);
        // $(this).attr('onclick', currentInfo.onclick);
        $(this).find('em').removeClass().addClass('icon ni ' + currentInfo.iconClass);
    });

    $('#back_btn').click(function() {
        $('#show').show(500);
        $('#form').hide(500);
        
        $('#prev').hide(500);

    });

    function edit_report(id){
        $('#show').hide(500);
        $('#form').show(500);
        $('#prev').show(500);

        $.ajax({
            url: site_url + 'accounts/creport/edit/' + id,
            type: 'get',
            success: function (data) {
                var dt = JSON.parse(data);
                $('#report_id').val(dt.e_id);
                $('#type').val(dt.e_type).change();;
                $("#cells_id").val(dt.e_cell_id).change();
                $('#dates').val(dt.e_date);
                $('#attendance').val(dt.e_attendance);
                $('#new_convert').val(dt.e_new_convert);
                $('#first_timer').val(dt.e_first_timer);
                $('#offering').val(dt.e_offering);
                $('#note').val(dt.e_note);
                
                var url = site_url + 'accounts/creport/manage/attendance';
                var updatedPageName = url + "/" + dt.e_cell_id;
                markButton.setAttribute("pageName", updatedPageName);
            }
        });

    }

    function updatePageName() {
        var selectElement = document.getElementById("cells_id");
        var markButton = document.getElementById("markButton");

        var selectedValue = selectElement.value;
        var pageName = markButton.getAttribute("pageName");
        var url = site_url + 'accounts/creport/manage/attendance';
        var updatedPageName = url + "/" + selectedValue;
        markButton.setAttribute("pageName", updatedPageName);
    }

    function load(x, y) {
        var more = 'no';
        var methods = '';
        if (parseInt(x) > 0 && parseInt(y) > 0) {
            more = 'yes';
            methods = '/' + x + '/' + y;
        }

        if (more == 'no') {
            $('#load_data').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        } else {
            $('#loadmore').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        }

       
        var search = $('#search').val();
        //alert(status);

        $.ajax({
            url: site_url + 'accounts/creport/load' + methods,
            type: 'post',
            data: { search: search },
            success: function (data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }
                $('#counta').html(dt.count);
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

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script>
<?=$this->endSection();?>