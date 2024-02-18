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
<div class="nk-content" style="background-image: url(<?=site_url('assets/sitebk.png'); ?>);background-size: cover;">
    <div class="container-fluid">
        <div class="nk-content-inner mt-3">
            <div class="nk-content-body">
                <div class="components-preview wide-xl mx-auto">
                    <div class="nk-block-head nk-block-head-lg wide-sm">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title fw-normal"><?=translate_phrase('Collections Subscription'); ?></h2>
                            <div class="nk-block-des">
                                <p class="lead"><?=translate_phrase('Pay your subscription fee.'); ?></p>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="row py-3">
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label class="overline-title overline-title-alt"><?=translate_phrase('Collection'); ?></label>
                                <select class="form-select js-select2" data-search="on" id="collection_id" onchange="load('', '')">
                                    <option value="0"><?=translate_phrase('Select Collection'); ?></option>
                                    <?php
                                        if(!empty($collection)){
                                            foreach($collection as $s => $val){
                                                if($val == 'health')$name = 'Health Insurance';
                                                if($val == 'environment')$name = 'Environment Levy';
                                                
                                                echo '
                                                    <option value="'.$val.'">'.translate_phrase($name).'</option>
                                                ';
                                            }
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-3 " id="col_resp" style="display:none;">
                            <div class="form-group">
                                <label class="overline-title overline-title-alt"><?=translate_phrase('Environment Address');?></label>
                                <select class="form-select js-select2" data-search="on" id="address_id" onchange="address('', '')">
                                    <option value="0"><?=translate_phrase('Select Address');?></option>
                                    <?php
                                        if(!empty($addresses)){$a=1;
                                            for($i=0;$i<$addresses;$i++){
                                                echo '
                                                    <option value="'.$a.'"> Address Location '.$a.'</option>
                                                ';
                                                $a++;
                                            }
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6  mb-3 card card-bordered" id="address_resp" style="display:none">
                            <?php
                                if(!empty($addresses_info)){
                                    $info = json_decode($addresses_info);$a=1;
                                    for($i=0;$i<$addresses; $i++){
                                        $ad_type = $info[$i]->address_type;
                                        $state_id = $info[$i]->state_id;
                                        $city_id = $info[$i]->city_id;
                                        $address = $info[$i]->address;
                                        $price = $info[$i]->price;
                                        $state = $this->Crud->read_field('id', $state_id, 'state', 'name');
                                        $city = $this->Crud->read_field('id', $city_id, 'city', 'name');
                                        
                                        echo '<span class="text-danger p-2 span_add" id="span_ad'.$a.'" style="display:none;"><b>'.ucwords($ad_type).' Address:</b> '.$address.', '.$city.', '.$state.'</span>';
                                        $a++;
                                    }
                                }

                            ?>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered">
                            
                            <div class="nk-block" >
                                <div class="nk-tb-list is-separate mb-3" id="load_data">
                                    
                                </div>
                                
                            </div><!-- .nk-block -->    
                                
                        </div>
                    </div><!-- .nk-block -->
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
<script>var site_url = '<?php echo site_url(); ?>'; 
</script> 

<script src="<?php echo site_url(); ?>assets/js/jquery.min.js"></script>

<script src="<?php echo site_url(); ?>assets/js/jsform.js"></script> 
<script>

    function load(){
        var collection_id = $('#collection_id').val();
            
        if(collection_id == 'environment'){
            $('#col_resp').show(500);
            $('#load_data').html('');
        } else {
            $('#col_resp').hide(500);$('#address_resp').hide();
            if(collection_id == 0){
                $('#load_data').html('');
            } else {
                loads('','');
            }
        }
        
    }

    function address(){
        var address_id = $('#address_id').val();
        $('.span_add').hide(500);
        $('#address_resp').hide();
        if(address_id == 0){
            $('#load_data').html('');
        } else {
            $('#span_ad'+address_id).show(500);
            $('#address_resp').show(500);
            loads('','');
        }
        
        
    }
    function loads(x, y) {
        var collection_id = $('#collection_id').val();
        
        var address_id = $('#address_id').val();
        
       
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

        if(collection_id == 'health'){
            var urls =  site_url + 'collections/health/load' + methods;
        }

        if(collection_id == 'environment'){
            var urls =  site_url + 'collections/environment_sub/list' + methods;
        }

        var search = $('#search').val();
        //alert(status);

        $.ajax({
            url: urls,
            type: 'post',
            data: { search: search, address_id: address_id},
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