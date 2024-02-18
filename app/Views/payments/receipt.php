<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>


<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="FundMe Cash">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?=site_url(); ?>assets/favicon.png">
    <!-- Page Title  -->
    <title><?=$title; ?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?=site_url(); ?>assets/css/dashlite.css?ver=<?=time(); ?>">
    <link id="skin-default" rel="stylesheet" href="<?=site_url(); ?>assets/css/skins/theme-green.css?ver=<?=time(); ?>">
</head>

<body class="bg-white">
    <div class="nk-block">
        <div class="invoice invoice-print">
            <div class="invoice-wrap">
                <div class="invoice-brand text-center">
                    <img class="logo-dark logo-img" style="height:200px;" src="<?=site_url(); ?>assets/logo.png" srcset="<?=site_url(); ?>assets/logo.png 3x" alt="logo">
                </div>
                <?php
                    $tran_id = $this->Crud->read_fields('user_id', $log_id, 'electricity', 'id');
                    if(!empty($trans_id)){
                        $tran_id = $trans_id;
                    }

                    $date = $this->Crud->read_field('id', $tran_id, 'electricity', 'reg_date');
                    $ref = $this->Crud->read_field('id', $tran_id, 'electricity', 'transaction_reference');
                    $amount = $this->Crud->read_field('id', $tran_id, 'electricity', 'amount');
                    $meter_no = $this->Crud->read_field('id', $tran_id, 'electricity', 'meter_no');
                    $service = $this->Crud->read_field('id', $tran_id, 'electricity', 'service');
                    $type = $this->Crud->read_field('id', $tran_id, 'electricity', 'type');
                    $pay_type = $this->Crud->read_field('id', $tran_id, 'electricity', 'pay_type');
                    $user_id = $this->Crud->read_field('id', $tran_id, 'electricity', 'user_id');
                    $token = $this->Crud->read_field('id', $tran_id, 'electricity', 'token');
                    $qr_code = $this->Crud->read_field('id', $tran_id, 'electricity', 'qr_code');

                    $unit =$this->Crud->read_field('id', $tran_id, 'electricity', 'unit_no');

                    $fullname = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
                    $phone = $this->Crud->read_field('id', $user_id, 'user', 'phone');
                    $address = $this->Crud->read_field('id', $user_id, 'user', 'address');

                    $total = (int)$amount + 100;
                ?>
                <div class="row">
                    <h4 class="text-center mb-4"><?=translate_phrase('Transaction Receipt');?></h4>
                    <div class="col-12 p-3 mb-5" style="border: 1px solid #eee;">
                        <h6 class="text-center"><?=translate_phrase('TOKEN');?></h6>
                        <h4 class="text-success text-center"><?=$token; ?></h4>
                    </div>
                    <div class="col-sm-9 ">
                        <span class="p-2"><?=translate_phrase('Number of Units'); ?></span>
                        <h5 class="p-2 mb-3"><?=$unit; ?></h5>


                        <span class="p-2"><?=translate_phrase('Meter Number'); ?></span>
                        <h5 class="p-2 mb-3"><?=$meter_no; ?></h5>
                        <span class="p-2"><?=translate_phrase('Meter Type'); ?></span>
                        <h5 class="p-2 mb-3"><?=ucwords($type); ?></h5>

                        <span class="p-2"><?=translate_phrase('Date'); ?></span>
                        <h5 class="p-2 mb-3"><?=$date; ?></h5>

                        <span class="p-2"><?=translate_phrase('Reference'); ?></span>
                        <h5 class="p-2 mb-3"><?=$ref; ?></h5>

                         <span class="p-2"><?=translate_phrase('Amount Bought'); ?></span>
                        <h5 class="p-2 mb-3"><?=$amount; ?></h5>

                        <span class="p-2"><?=translate_phrase('Service'); ?></span>
                        <h5 class="p-2 mb-3"><?=$service; ?></h5>

                        <span class="p-2"><?=translate_phrase('Total Amount'); ?></span>
                        <h5 class="p-2 mb-3"><?=$total; ?></h5>

                        <span class="p-2"><?=translate_phrase('Payment Type'); ?></span>
                        <h5 class="p-2 mb-3"><?=$pay_type; ?></h5>

                        <span class="p-2"><?=translate_phrase('Account Name'); ?></span>
                        <h5 class="p-2 mb-3"><?=$fullname; ?></h5>

                        <span class="p-2"><?=translate_phrase('Account Address'); ?></span>
                        <h5 class="p-2 mb-3"><?=$address; ?></h5>
                    </div>
                    <div class="col-sm-3 text-center">
                        <img class="p-2" src="<?=site_url($qr_code); ?>">
                    </div>
                </div>
                <div class="buysell-field mt-4 form-action">
                    <button type="button" class="btn btn-lg btn-bloc btn-primary" onclick="printPromot();"><?=translate_phrase('Print Receipt'); ?></button>
                    <a href="<?=site_url('collections/electricity');?>" class="btn btn-lg btn-bloc btn-danger"><?=translate_phrase('Back to Payments');?></a>
                </div>
            </div><!-- .invoice-wrap -->
        </div><!-- .invoice -->
    </div><!-- .nk-block -->
    <script>
        function printPromot() {
            window.print();
        }
    </script>
</body>

</html>