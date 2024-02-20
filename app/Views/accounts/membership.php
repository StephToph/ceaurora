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
        <div class="nk-content-inner mt-5">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm  mt-3">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title"><?=translate_phrase('New Membership'); ?></h3>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            
                            <?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
                            <div class="row gy-4">
                                <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label">Title</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-placeholder="Select Title" required>
                                                <option value="">Select Title</option>
                                                <option value="Brother">Brother</option>
                                                <option value="Sister">Sister</option>
                                                <option value="Pastor">Pastor</option>
                                                <option value="Elder">Elder</option>
                                                <option value="Deacon">Deacon</option>
                                                <option value="Deaconess">Deaconess</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label"
                                            for="last-name">Last Name</label><input type="text"
                                            class="form-control" name="lastname" id="last-name" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label"
                                            for="first-name">First Name</label><input type="text"
                                            class="form-control" name="firstname" id="first-name"
                                            placeholder="First Name" required></div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label"
                                            for="last-name">Other Name</label><input type="text"
                                            class="form-control" name="othername" id="last-name" placeholder="Last Name">
                                    </div>
                                </div>
                               <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label">Gender</label>
                                        <div class="form-control-wrap"><select
                                                class="form-select js-select2" name="gender" required
                                                data-placeholder="Select Gender">
                                                <option value="">Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label"
                                            for="phone-no">Phone</label><input type="number"
                                            class="form-control" name="phone" id="phone-no" placeholder="Phone no">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label" for="email">Email
                                            Address</label><input type="email" name="email" class="form-control"
                                            id="email" placeholder="Email Address"></div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label" for="email">Kingchat Handle</label><input type="text" name="chat_handle" class="form-control"
                                            id="email" placeholder="Email Address"></div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label">Birth Date</label>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right"><em
                                                    class="icon ni ni-calendar"></em></div><input
                                                type="text" name="dob" class="form-control date-picker"
                                                data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label"
                                            for="address">Adddress</label><input type="text"
                                            class="form-control" name="address" id="address" placeholder="Address">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label">Family Status</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" name="family_status"
                                                data-placeholder="Select Status">
                                                <option value="">Select</option>
                                                <option value="single">Single
                                                </option>
                                                <option value="married">Married
                                                </option>
                                                <option value="sepreated">Seperated
                                                </option>
                                                <option value="divorced">Divorced
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xxl-3">
                                    <div class="form-group"><label class="form-label">Family Unit Position</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" id="family_position" name="family_position"
                                                data-placeholder="Select Position" onchange="posit();">
                                                <option value="">Select</option>
                                                <option value="Child">Child
                                                </option>
                                                <option value="Parent">Parent
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xxl-3" id="parent_resp" style="display:none;">
                                    <div class="form-group"><label class="form-label">Parent</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" name="parent_id"
                                                data-placeholder="Select Parent">
                                                <option value="">Select</option>
                                                <?php
                                                    $parent  = $this->Crud->read_single_order('family_position', 'Parent', 'user', 'surname', 'asc');
                                                    if(!empty($parent)){
                                                        foreach($parent as $p){
                                                            echo '<option value="'.$p->id.'">'.ucwords($p->surname.' '.$p->firstname).'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 mb-3 text-center">
                                    <div class="form-group  mt-4"><button type="submit"
                                            class="btn btn-primary">Save Membership</button></div>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
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
        // load('', '');
    });

    function posit(){
        var position = $('#family_position').val();
        if(position == 'Child'){
            $('#parent_resp').show(500);
        } else{
            $('#parent_resp').hide(500);
        }
    }
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
            $('#load_data').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>Loading Please Wait</div>');
        } else {
            $('#loadmore').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>Loading Please Wait</div>');
        }

        
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var state_id = $('#state_id').val();
        var status = $('#status').val();
        var ref_status = $('#ref_status').val();
        var verify = $('#verify').val();
        var search = $('#search').val();
        //alert(status);

        $.ajax({
            url: site_url + 'accounts/business/load' + methods,
            type: 'post',
            data: { state_id: state_id, search: search,start_date: start_date,end_date: end_date , status: status, verify: verify, ref_status: ref_status },
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

<?=$this->endSection();?>