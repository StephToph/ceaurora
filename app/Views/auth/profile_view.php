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
    <style>
       

        /* Small screens (up to 576px) */
        @media (max-width: 767px) {
            .idcard {
                height: 230px;
               
            }
            .idcards {
                height: 300px;
               
            }
            .hexagon-container {
                width: 35%;
                height: 113.96px;
                position: relative;
                overflow: hidden;
                top: 17%;
                left: 3%;
            }
            .qr-container {
                width: 18%;
                height: 54.96px;
                position: relative;
                overflow: hidden;
                top: 1%;
                left: 60%;
            }
            .qr-image {
                width: 100%;
                height: 100%;
                background-color: #2263b3 ; 
            }
            .qr-image img {
                width: 100%;
                height: 100%;
                object-fit: fill; /* Ensure the image covers the hexagon shape */
            }

            .hexagon-image {
                width: 100%;
                height: 100%;
                background-color: #2263b3 ; /* Background color for the hexagon */
            }

            .hexagon-image img {
                width: 100%;
                height: 100%;
                object-fit: fill; /* Ensure the image covers the hexagon shape */
            }
            #qrcode{
                margin:1%;
                margin-top:0%;
                margin-bottom:1%;
            }
            .name{
                position: relative;
                overflow: hidden;
                left: 18%;
                top: 0%;
                font-size: 15px;
            }
            .tax{
                position: relative;
                overflow: hidden;
                left: 27%;
                top: 0%;
                font-size: 16px;
                width: 100%;
            }
            .qr-containers {
                width: 41%;
                height: 36%;
                position: relative;
                overflow: hidden;
                top: 14%;
                left: 30%;
            }
            
            .qr-images {
                width: 100%;
                height: 100%;
                background-color: #2263b3 ; 
            }
            .qr-images img {
                width: 100%;
                height: 100%;
                object-fit: fill; /* Ensure the image covers the hexagon shape */
            }
            .taxs{
                position: relative;
                overflow: hidden;
                color: black;
                left: 3%;
                top: 23%;
                font-size: 28px;
                width:100%;
            }
            #qrcodes{
                margin:10%;
                margin-top:0%;
                margin-bottom:1%;
            }
        }

        /* Medium screens (577px to 992px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .idcard {
                height: 300px;
               
            }
            
            .idcards {
                height: 300px;
               
            }
            .hexagon-container {
                width: 158px;
                height: 147.96px;
                position: relative;
                overflow: hidden;
                top: 17%;
                left: 5%;
            }
            .qr-container {
                width: 77px;
                height: 71.96px;
                position: relative;
                overflow: hidden;
                top: -3%;
                left: 60%;
            }
            .qr-image {
                width: 100%;
                height: 100%;
                background-color: #2263b3 ; 
            }
            .qr-image img {
                width: 100%;
                height: 100%;
                object-fit: fill; /* Ensure the image covers the hexagon shape */
            }

            .hexagon-image {
                width: 100%;
                height: 100%;
                background-color: #2263b3 ; /* Background color for the hexagon */
            }
            .hexagon-image::before{
                
                z-index: -1;
            }

            .hexagon-image img {
                width: 100%;
                height: 100%;
                object-fit: fill; /* Ensure the image covers the hexagon shape */
            }
            #qrcode{
                margin:8%;
                margin-top:0%;
                margin-bottom:1%;
            }
            #qrcodes{
                margin:8%;
                margin-top:0%;
                margin-bottom:1%;
            }
            .name{
                position: relative;
                overflow: hidden;
                left: 12%;
                top: 0%;
                font-size: 21px;
            }
            .tax{
                position: relative;
                overflow: hidden;
                left: 26%;
                top: -3%;
                font-size: 28px;
                width: 100%;
            }
            
            .qr-containers {
                width: 41%;
                height: 36%;
                position: relative;
                overflow: hidden;
                top: 14%;
                left: 30%;
            }
            
            .qr-images {
                width: 100%;
                height: 100%;
                background-color: #2263b3 ; 
            }
            .qr-images img {
                width: 100%;
                height: 100%;
                object-fit: fill; /* Ensure the image covers the hexagon shape */
            }
            .taxs{
                position: relative;
                overflow: hidden;
                color: black;
                left: 3%;
                top: 23%;
                font-size: 28px;
                width:100%;
            }
            #qrcodes{
                margin:20%;
                margin-top:0%;
                margin-bottom:1%;
            }
        }

        /* Large screens (993px and above) */
        @media (min-width: 992px) {
            .idcard {
                height: 400px;
               
            }
            
            .idcards {
                height: 400px;
               
            }
            .hexagon-container {
                width: 34.5%;
                height: 198px;
                position: relative;
                overflow: hidden;
                top: 17%;
                left: 5%;   
            }
            .qr-container {
                width: 102px;
                height: 100.96px;
                position: relative;
                overflow: hidden;
                top: 1%;
                left: 60%;
            }
            .qr-image {
                width: 100%;
                height: 100%;
                background-color: #2263b3 ; 
            }
            .qr-image img {
                width: 100%;
                height: 100%;
                object-fit: fill; /* Ensure the image covers the hexagon shape */
            }
            .qr-containers {
                width: 41%;
                height: 36%;
                position: relative;
                overflow: hidden;
                top: 14%;
                left: 30%;
            }
            
            .qr-images {
                width: 100%;
                height: 100%;
                background-color: #2263b3 ; 
            }
            .qr-images img {
                width: 100%;
                height: 100%;
                object-fit: fill; /* Ensure the image covers the hexagon shape */
            }

            .hexagon-image {
                width: 100%;
                height: 100%;
                background-color: #2263b3 ; /* Background color for the hexagon */
            }

            .hexagon-image img {
                width: 100%;
                height: 100%;
                object-fit: fill; /* Ensure the image covers the hexagon shape */
            }
            #qrcode{
                margin:20%;
                margin-top:0%;
                margin-bottom:1%;
            }
            #qrcodes{
                margin:30%;
                margin-top:0%;
                margin-bottom:1%;
            }
            .name{
                position: relative;
                overflow: hidden;
                left: 8%;
                top: 0%;
                font-size: 23px;
            }
            .tax{
                position: relative;
                overflow: hidden;
                left: 23%;
                top: 1%;
                font-size: 29px;
                width:100%;
            }

            .taxs{
                position: relative;
                overflow: hidden;
                left: 0%;
                top: 25%;
                font-size: 30px;
                width:100%;
            }
           
        }
        
    </style>
    <div class="nk-content" style="background-image: url(<?=site_url('assets/sitebk.png'); ?>);background-size: cover;margin-top:4%">
        <div class="container wide-xl ">
            <div class="nk-content-inner ">
                <div class="nk-content-body">
                    <div class="nk-content-wrap mt-5">
                        <div class="nk-block-head  mt-5">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title"><?=translate_phrase('My Profile'); ?></h3>
                                <div class="nk-block-des">
                                    <p><?=translate_phrase('You have full control to manage your own account setting.'); ?></p>
                                   
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->

                        <div class="nk-block">
                            <div class="card card-bordered">
                                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                    <li class="nav-item">
                                        <a class="nav-link " href="<?=site_url('auth/profile'); ?>"><em class="icon ni ni-user-fill-c"></em><span><?=translate_phrase('Personal'); ?></span></a>
                                    </li>
                                    <?php
                                        if($this->Crud->check2('id', $log_id, 'setup', 0, 'user') > 0){
                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('auth/security'); ?>"><em class="icon ni ni-lock-alt-fill"></em><span><?=translate_phrase('Payment Setup'); ?></span></a>
                                        </li>
                                    <?php 
                                        }
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="<?=site_url('auth/profile_view'); ?>"><em class="icon ni ni-view-panel"></em><span>ID<?=translate_phrase(' Card'); ?></span></a>
                                    </li>
                                </ul><!-- .nav-tabs -->
                                <div class="card-inner card-inner-xl">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">ID<?=translate_phrase(' Card');?></h4>
                                            <div class="nk-block-des">
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="nk-block">
                                        <div class="nk-data data-list data-list-s2">
                                            <div class="data-head">
                                                <h6 class="overline-title"></h6>
                                            </div>
                                            <div class="row text-center bg-white" id="qrcode">
                                                
                                                <div class="col-12 idcard" style="background: url(<?=site_url('assets/id.png'); ?>)  no-repeat center center;background-size: 100% 100%; margin-right: 5%;color: #fff;   " >
                                                   
                                                    
                                                    <div class="hexagon-container">
                                                        <div class="hexagon-image">
                                                            <?=($passport);?>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="name"> <b><?=$fullname; ?></b></div>
                                                    <div class="tax"> <?=$tax_id; ?></b></div>
                                                    <div class="qr-container">
                                                        <div class="qr-image">
                                                            <?=($qrcode);?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row text-center mt-3" style="font-size:18px;margin:1% 10%;">
                                                <div class="col-sm-12 mb-2"> 
                                                    <a href="javascript:;" class="btn btn-primary btn-block" onclick="saveDivAsPDF()"><?=translate_phrase('Download ID Card'); ?></a>
                                                    <span id="ref_resp"  class="text-danger"></span>
                                                </div>
                                                <div class="col-sm-12" id="card_response"></div>
                                            </div>
                                        </div><!-- data-list -->
                                    </div><!-- .nk-block -->
                                </div>
                                <div class="card-inner card-inner-xl">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">QR<?=translate_phrase(' Code');?></h4>
                                            <div class="nk-block-des">
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="nk-block">
                                        <div class="nk-data data-list data-list-s2">
                                            <div class="data-head">
                                                <h6 class="overline-title"></h6>
                                            </div>
                                            <div class="row text-center bg-white" id="qrcodes">
                                                
                                                <div class="col-12 mb-4 idcards" style="background: url(<?=site_url('assets/qr.jpeg'); ?>)  no-repeat center center;background-size: 100% 100%; margin-right: 5%;color: #fff;   " >
                                                   
                                                    <div class="qr-containers">
                                                        <div class="qr-images">
                                                            <?=($qrcode);?>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="taxs text-dark"> <?=$tax_id; ?></b></div>
                                                </div>
                                            </div>
                                            <div class="row text-center" style="font-size:18px;">
                                                <div class="col-12 mb-2"> 
                                                    <button class="btn btn-primary btn-block"  onclick="qrcodes()" ><?=translate_phrase('Download Qr Code'); ?></button>
                                                    <span id="ref_resp" class="text-danger"></span>
                                                    </div>
                                                    
                                                    <div class="col-sm-12" id="qr_response"></div>
                                                
                                            </div>
                                                    
                                        </div><!-- data-list -->
                                    </div><!-- .nk-block -->
                                </div><!-- .card-inner -->
                            </div><!-- .card -->
                        </div><!-- .nk-block -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="output"></div>
    <?=$this->endSection();?>

<?=$this->section('scripts');?>
    <script src="<?=site_url(); ?>assets/js/jsmodal.js"></script>
    
   
<?=$this->endSection();?>