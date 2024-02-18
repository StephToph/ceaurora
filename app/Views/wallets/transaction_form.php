<?php
use App\Models\Crud;
$this->Crud = new Crud();
?>
<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
     <?php if($param1 == 'view') { ?>
        <div class="row">
            <div class="col-sm-12"><div id="bb_ajax_msg"></div></div>
        </div>

        <div class="row" id="trans_resp">
            <input type="hidden" name="order_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="col-12 mb-5 col-sm-12 text-center">
                <img style="height:100px;"  src="<?=site_url(); ?>assets/logo.png" alt="logo-dark">
            </div> 

            <div class="col-12 col-sm-4 mb-3">
                <div style="background-color:#eee; padding: 15px;">
                    <div class="text-muted"><?php echo $e_reg_date; ?></div>
                    <div style="font-size:20px; font-weight:bold;"><?php echo $e_code; ?></div>
                </div>
            </div>

            <div class="col-12 mb-3 col-sm-8 text-right">
                
            </div> 
            
            <!-- Customer -->
            <div class="col-sm-6 mb-5">
                <div style="background-color:#fcfcfc; padding: 15px;">
                    <b class="text-muted"><?=translate_phrase('SENDER');?></b>
                    <hr/>
                    <div class="d-flex align-items-center">
                        <div class="m-l-10">
                            <div class="mb-0 ml-2 text-dark font-weight-semibold"><?php echo $e_customer; ?></div>
                            <div class="mb-0 ml-2 opacity-07 font-size-13"><?php echo $e_customer_phone; ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vendor -->
            <?php if(!empty($e_merchant)){?>
                <div class="col-sm-6 m-b-15">
                    <div style="background-color:#fcfcfc; padding: 15px;">
                        <b class="text-muted"><?=translate_phrase('RECEIVER');?></b>
                        <hr/>
                        <div class="d-flex align-items-center">
                            <div class="m-l-10">
                                <div class="m-b-0 text-dark font-weight-semibold"><?php echo $e_merchant; ?></div>
                                <div class="m-b-0 opacity-07 font-size-13"><?php echo $e_merchant_phone; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Pricing -->
            <div class="col-sm-12">
                <table class="table table-response table-striped">
                    <thead>
                        <tr>
                            <td><b><?=translate_phrase('TRANSACTION TYPE');?></b></td>
                            <?php if(!empty($e_payment_method)){?><td class="text-right"><b><?=translate_phrase('TRANSACTION METHOD');?></b></td><?php } ?>
                            <td class="text-right"><b><?=translate_phrase('AMOUNT');?> (<?php echo $e_curr; ?>)</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                                if($e_payment_type == 'sms'){
                                    $payment_type = 'SMS Charge';
                                }
                                if($e_payment_type == 'transact'){
                                    $payment_type = 'Cash Code';
                                }

                                if($e_payment_type == 'transfer'){
                                    $payment_type = 'Send Money';
                                }
                                if($e_payment_type == 'deposit'){
                                    $payment_type = 'Deposit';
                                }

                                if($e_payment_type == 'withdraw'){
                                    $payment_type = 'Withdraw';
                                }
                            ?>
                            <td class=""><?php echo $payment_type; ?></td>
                            <?php if(!empty($e_payment_method)){?><td class=""><?php echo ucwords($e_payment_method)  ; ?></td><?php } ?>
                            <td class="text-right"><?php echo number_format($e_amount,2); ?></td>
                        </tr>
                    </tbody>
                    
                </table>
                <?php if(!empty($e_merchant)){?>
                
            <?php } ?>
            </div>
            <?php if(!empty($e_transaction_code)){?>
                <div class="col-sm-6 m-b-15">
                    <div style="background-color:#fcfcfc; padding: 15px;">
                        <b class="text-muted"><?=translate_phrase('Transaction Code');?></b>
                        <hr/>
                        <div class="d-flex align-items-center">
                            <div class="m-l-10">
                                <div class="m-b-0 text-dark font-weight-semibold"><?php echo $e_transaction_code; ?></div>
                                <?php 
                                    $used_by = $this->Crud->read_field('code', $e_transaction_code, 'voucher', 'used_by');
                                    $used_date = $this->Crud->read_field('code', $e_transaction_code, 'voucher', 'used_date');
                                    
                                    $status = '<span class="text-danger">'.translate_phrase('UNUSED').'</span>';
                                    $used = '';
                                    if($used_by > 0){
                                        $used = $this->Crud->read_field('id', $used_by, 'user', 'fullname');
                                        $status = '<span class="text-success">'.translate_phrase('USED').'</span>';
                                        $u_date = 	'<span class="text-muted">'.$used_date.'</span><br>';
                                    }
                                    
                                    echo $status.$used_date.'<br>'.$used;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if(!empty($e_remark) && $e_remark != 'NULL'){?>
                <div class="col-sm-12 m-b-15">
                    <div style="background-color:#fcfcfc; padding: 15px;">
                        <b class="text-muted"><?=translate_phrase('Remark'); ?></b>
                        <hr/>
                        <div class="d-flex align-items-center">
                            <div class="m-l-10">
                                <div class="m-b-0 text-dark font-weight-semibold"><?php echo translate_phrase($e_remark); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- <?php if(!empty($e_remark) && $e_payment_type == 'withdraw'){?>
                <div class="col-sm-12 m-b-15">
                    <div style="background-color:#fcfcfc; padding: 15px;">
                        <b class="text-muted">Account Number</b>
                        <hr/>
                        <div class="d-flex align-items-center">
                            <div class="m-l-10">
                                <div class="m-b-0 text-dark font-weight-semibold"><?php echo $e_remark; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?> -->
        </div><hr>
        <div class="row mt-4">
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-primary btn-block"><em class="icon ni ni-printer"></em><span><?=translate_phrase('Print'); ?></span> </button>
            </div>
            <div class="col-sm-6">
                <button type="button" id="shareButton"  onclick="shareAsPdfAndSendEmail('trans_resp')" class="btn btn-info btn-block"><em class="icon ni ni-share-alt"></em><span><?=translate_phrase('Share');?></span> </button>
            </div>
        </div>
    <?php } ?>
<?php echo form_close(); ?>

<script>
   function shareAsPdfAndSendEmail(divId) {
    const contentDiv = document.getElementById(divId);
    const content = contentDiv.innerHTML;

    convertToPdf(content)
        .then((pdfDataUrl) => {
        sendEmailWithAttachment(pdfDataUrl, 'content.pdf');
        })
        .catch((error) => {
        console.error('Error converting content to PDF:', error);
        });
    }

    function convertToPdf(content) {
        return new Promise((resolve, reject) => {
            const pdfDoc = new jsPDF();
            const source = content;

            pdfDoc.fromHTML(
            source,
            10,
            10,
            { width: 180 },
            () => {
                const pdfDataUrl = pdfDoc.output('datauristring');
                resolve(pdfDataUrl);
            },
            () => {
                reject(new Error('Error generating PDF'));
            }
            );
        });
    }

    function sendEmailWithAttachment(dataUrl, filename) {
        const link = document.createElement('a');
        link.href = dataUrl;
        link.download = filename;
        link.click();
    }


    

    function printDiv(divId) {
        const content = document.getElementById(divId).innerHTML;
        const printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print</title></head><body>');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

</script>