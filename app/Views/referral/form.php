
<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>

    <!-- insert/edit view -->
    <?php if($param1 == 'view') { ?>
        <div class="row">
            <div class="col-sm-12">
                <!-- <b class="text-muted">Referral List</b> -->
                <table class="table table-response table-striped">
                    <thead>
                        <tr>
                            <td><b><?=translate_phrase('Date');?></b></td>
                            <td class=""><b><?=translate_phrase('Referral');?></b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(!empty($param2)){
                                $refs = $this->Crud->date_range1($e_start_date, 'reg_date', $e_end_date, 'reg_date', 'user_id', $param2, 'referral');
                                if(!empty($refs)){
                                    foreach($refs as $r){          
                        ?>
                                <tr>
                                    <td class=""><?php echo date('d F Y h:i A', strtotime($r->reg_date)); ?></td>
                                    <td class=""><?php echo ucwords($this->Crud->read_field('id', $r->referral_id, 'user', 'fullname')); ?></td>
                                </tr>
                        <?php  }
                                }
                            }?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
<script>