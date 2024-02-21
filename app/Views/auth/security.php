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
    <div class="nk-content" >
        <div class="container wide-xl  mt-5">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-content-wrap">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title"><?=translate_phrase('My Profile');?></h3>
                                <div class="nk-block-des">
                                    <p><?=translate_phrase('You have full control to manage your own account setting.');?></p>
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->
                        <div class="nk-block">
                            <div class="card card-bordered">
                                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?=site_url('auth/profile'); ?>"><em class="icon ni ni-user-fill-c"></em><span><?=translate_phrase('Personal');?></span></a>
                                    </li>
                                    <li class="nav-item active">
                                        <a class="nav-link" href="<?=site_url('auth/setup'); ?>"><em class="icon ni ni-wallet-fill"></em><span><?=translate_phrase('Payment Setup');?></span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?=site_url('auth/profile_view'); ?>"><em class="icon ni ni-qr"></em><span><?=translate_phrase('QR CODE'); ?></span></a>
                                    </li>
                                </ul><!-- .nav-tabs -->
                                <div class="card-inner card-inner-lg">
                                    
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title"><?=translate_phrase('Payment Setup'); ?></h4>
                                            <div class="nk-block-des">
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                     <!-- Page Content -->
                                    <div class="nk-block">
                                        <div class="card">
                                            <div class="card-inner">
                                                
                                                <?=form_open_multipart(site_url('auth/security'), array('id'=>'bb_ajax_form', 'class'=>''));?>
                                                    <div id="bb_ajax_msg"></div>
                                                    <div class="row">
                                                        <div class="mb-2 col-md-12">
                                                            <div class="row">
                                                                <div class="mb-2 col-md-4">
                                                                    <?php
                                                                        $trade = $this->Crud->read_field('id', $log_id, 'user', 'trade');
                                                                        $name = $this->Crud->read_field('id', $trade, 'trade', 'name');
                                                                        $price =  $this->Crud->read_field('id', $trade, 'trade', 'medium');
                                                                        if(empty($price))$price = 0;
                                                                            echo '<input type="hidden" id="total" value="'.$price.'">
                                                                            <h4>';
                                                                            if($this->Crud->check2('id', $log_id, 'trade', 0, 'user') > 0){?>

                                                                                <div class="form-group">
                                                                                    <div class="form-label-group">
                                                                                        <label class="form-label">Trade/Business Type <span class="text-danger">*</span></label>
                                                                                    </div>
                                                                                    <div class="form-control-group">
                                                                                        <select class="form-control form-control-lg js-select2" id="trade" data-search="on" name="trade"  onchange="trades();"  required>
                                                                                            <option value=""><?=translate_phrase('--Select Trade Type--'); ?></option>
                                                                                            <?php
                                                                                                $country = $this->Crud->read_order('trade', 'name', 'asc');
                                                                                                if(!empty($country)){
                                                                                                    foreach($country as $c){
                                                                                                        $sels = '';
                                                                                                        // if($sel == $c->id)$sels = 'selected';
                                                                                                        echo '<option value="'.$c->id.'" '.$sels.'>'.$c->name.'</option>';
                                                                                                    }
                                                                                                } 
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <span id="trade_resp"></span>
                                                                                </div>

                                                                        <?php } else {

                                                                    ?>
                                                                        <label for="question1" class="form-label"><?=translate_phrase('Medium Presumptive Tax'); ?></label>
                                                                        <?php
                                                                            
                                                                            echo strtoupper($name);
                                                                        ?></h4>
                                                                        <h5 class="text-info"><?=curr.number_format($price, 2); ?></h5>
                                                                     <?php } ?>
                                                                </div>
                                                                <input type="hidden" id="total" value="<?=$price; ?>">
                                                                <div class="mb-2 col-md-4">
                                                                    <label for="answer1" class="form-label"><?=translate_phrase('Payment Duration');?></label>
                                                                    <select class="form-control select2" id="duration" data-search="on" name="duration" required onchange="pays();">
                                                                        <option value=" "><?=translate_phrase('--Select Duration--'); ?></option>
                                                                        <option value="daily" <?php if(!empty($duration)){if($duration == 'daily'){echo 'selected'; }}?>><?=translate_phrase('Daily'); ?></option>
                                                                        <option value="weekly" <?php if(!empty($duration)){if($duration == 'weekly'){echo 'selected'; }}?>><?=translate_phrase('Weekly'); ?></option>
                                                                        <option value="monthly" <?php if(!empty($duration)){if($duration == 'monthly'){echo 'selected'; }}?>><?=translate_phrase('Monthly'); ?></option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div class="mb-2 col-md-4">
                                                                    <label for="question2" class="form-label"><?=translate_phrase('Amount Per Duration Selected');?></label>
                                                                    <input type="text" class="form-control" id="price" value="0" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12" align="center">
                                                            <button type="submit" class="btn btn-primary bb_form_bn"><?=translate_phrase('Save Settings'); ?></button>
                                                        </div>
                                                    </div>
                                                    
                                                <?=form_close();?>
                                            </div>
                                        </div>
                                    </div>
                
                                </div><!-- .card-inner -->
                            </div><!-- .card -->
                        </div><!-- .nk-block -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?=$this->endSection();?>

<?=$this->section('scripts');?>
    <script src="<?=site_url();?>assets/js/jsform.js"></script>
    <script>
        var site_url = '<?=site_url();?>';
        $('.select2').select2();
        <?php if(!empty($duration)){ ?>
            $(function() {
                setTimeout(function(){ pays();}, 1000);
               
            });
        <?php }
        ?>

       function trades(){
            var trade = $('#trade').val();
            if(trade !== ''){
                $.ajax({
                    url: site_url + 'auth/security/get_trade/' + trade,
                    success: function (data) {
                        $('#trade_resp').val(data); 
                        $('#total').val(data); 
                          
                        pays();                
                    }
                });
            }
       }


       function pays(){
            var total = $('#total').val();
            var duration = $('#duration').val();
            // console.log(duration);
            if(total !== '' && duration !== ''){
                var total = parseFloat($('#total').val());
                var duration = $('#duration').val();
                var res = 0;
                
                if(duration == 'monthly'){
                    var res = total / 12;
                }
                if(duration == 'weekly'){
                    var res = total / 52;
                }
                if(duration == 'daily'){
                    var res = total / 365;
                }
                
                $('#price').val(res.toFixed(2));
            }
        }
    </script>
<?=$this->endSection();?>