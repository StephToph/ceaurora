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
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title"><?=translate_phrase('Environment Set-Up'); ?></h3>
                                <div class="nk-block-des text-soft">
                                    <p><?=translate_phrase('Manage Environmental Levy Set-Up'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="nk-block">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row g-gs">
                                    <div class="col-sm-9"></div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="state_id"><?=translate_phrase('State') ;?></label>
                                            <select class="form-control js-select2" id="state_id" name="state_id" style="width: 100%;" data-placeholder="<?=translate_phrase('Choose one'); ?>.." onchange="get_lga();">
                                                <option value=""><?=translate_phrase('Select') ;?></option>
                                                <?php 
                                                    $allrole = $this->Crud->read_single_order('country_id', 161, 'state', 'name', 'asc');
                                                if(!empty($allrole)): ?>
                                                <?php foreach($allrole as $rol):
                                                    if($rol->id != 300)continue;
                                                    ?>
                                                    <option value="<?php echo $rol->id; ?>" <?php if(!empty($e_role_id)){if($e_role_id == $rol->id){echo 'selected';}} ?>><?php echo $rol->name; ?></option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12 table-responsive" style="max-height:400px;">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th><?=translate_phrase('State'); ?></th>
                                                    <th><?=translate_phrase('L.G.A') ;?></th>
                                                    <th><?=translate_phrase('Residential Fee'); ?></th>
                                                    <th><?=translate_phrase('Commercial Fee'); ?></th>
                                                    <th width="100px"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="module_list">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?=$this->endSection();?>

<?=$this->section('scripts');?>
<script>
    $(function() {
        $('.js-select2').select2();
    });
    
    function get_lga() {
        var state_id = $('#state_id').val();
        $('#module_list').html('<div class="col-sm-12 text-center"><br/><br/><span class="ni ni-loader fa-spin" style="font-size:38px;"></span></div>');
        $.ajax({
            url: '<?php echo site_url('collections/get_lga/'); ?>' + state_id,
            type: 'post',
            success: function(data) {
                $('#module_list').html(data);
            },
            complete: function() {
                // icheck();
            }
      });
    }
    
    function isNumeric(event) {
        var keyCode = event.which;
        if (keyCode < 48 || keyCode > 57) {
            event.preventDefault();
        }
    }


    function save_fee(event) {
        var id = $(event).attr("id");
        var val = $(event).val();
        
        if(isEmpty(val)){
            $(event).val(0);
            val = 0;
        }

        var delimiter = "_";

        var result = id.split(delimiter);
        console.log(result[1]);
        $('#resp_'+result[1]).html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><span>Updating.. Please Wait</span></div>');
        $.ajax({
            url: '<?php echo site_url('collections/setup/save'); ?>',
            data: {id:id,val:val},
            type: 'post',
            success: function(data) {
                $('#resp_'+result[1]).html(data);
            },
            complete: function() {
                // icheck();
            }
      });
    }

    function isEmpty(value) {
        if (value === null || value === undefined) {
            return true;
        }

        if (typeof value === 'string' && value.trim() === '') {
            return true;
        }

        if (Array.isArray(value) && value.length === 0) {
            return true;
        }

        if (typeof value === 'object' && Object.keys(value).length === 0) {
            return true;
        }

        return false;
    }
  </script>
  
  <?=$this->endSection();?>