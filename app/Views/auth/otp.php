<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?><!DOCTYPE html>
<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="green">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?=site_url(); ?>assets/zend.png">
    <!-- Page Title  -->
    <title><?=$title; ?></title>
    <link rel="manifest" href="<?=site_url(); ?>manifest.webmanifest">
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?=site_url(); ?>assets/css/dashlite.css">
    <link id="skin-default" rel="stylesheet" href="<?=site_url(); ?>assets/css/skins/theme-blue.css">
    <style>
          /* Small screens (up to 576px) */
          @media (max-width: 576px) {
            .logo-dark {
                max-width: 80%; /* Adjust styles for small screens */
              
            }

            .card-bordered{
                height: 50vh;
            }
        }

        /* Medium screens (577px to 992px) */
        @media (min-width: 577px) and (max-width: 992px) {
            .logo-dark {
                max-width: 60%; /* Adjust styles for medium screens */
            }
        }

        /* Large screens (993px and above) */
        @media (min-width: 993px) {
            .logo-dark {
                max-width: 60%; /* Adjust styles for large screens */
               
            }
            .card-bordered{
                margin-right:25%;margin-left:25%;
            }
        }
    </style>
</head>

<!--End of Tawk.to Script-->
<body class="nk-body bg-white npc-general pg-auth">
    <!-- app body @s -->
    <div class="nk-app-root">
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content " style="background-image: url(<?=site_url('assets/background-color.png'); ?>);
                    background-size: cover; /* Adjust to 'contain' or other values as needed */
                    background-position: center;
                    background-repeat: no-repeat;
                    margin: 0; /* Remove default body margin */">
                    <div class="brand-logo pb-2 pt-5 text-white text-center">
                        <a href="<?=site_url(); ?>" class="logo-link pt-4">
                            <img class="logo-dark pt-5 " src="<?=site_url(); ?>assets/zend.png" srcset="<?=site_url(); ?>assets/zend.png 2x" alt="logo-dark" height="180">
                        </a>
                        <h3>Welcome to TIDREMS</h3>
                        <p class="mx-5" style="font-style:italic;">Tax ID DIrect Remittance System for easy and secure Enrolment and Payment of government taxes.</p>
                        <img class="logo-dark py-1 mb-2" src="<?=site_url(); ?>assets/delta.png" srcset="<?=site_url(); ?>assets/delta.png 2x" alt="logo-dark" height="70">
                    </div>
                    <div class="card card-bordered" style="border-radius:25px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title"><?=translate_phrase('One Time Password');?></h5>
                                        <div class="nk-block-des">
                                            <p><?=translate_phrase('Enter the otp sent to your phone or email to verify you account.');?></p>
                                            <p class="text-danger small">Enter Phone number first when requesting for an OTP</p>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_open_multipart('auth/otp', array('id'=>'bb_ajax_form', 'class'=>'')); ?>
                                    <div class="row"><div id="bb_ajax_msg"></div></div>
                                    <input type="hidden" id="email" name="email" value="<?=$this->Crud->read_field('id', $user_id, 'user', 'email'); ?>">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01"><?=translate_phrase('Phone Number'); ?></label>
                                        </div>
                                        <div class="form-control-wrap mb-2">
                                            <input type="text" id="phone" name="phone"  class="form-control form-control-lg" required value="<?=$this->Crud->read_field('id', $user_id, 'user', 'phone'); ?>"  placeholder="<?=translate_phrase('Enter your phone Number');?>"> 
                                        </div>
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">OTP</label>
                                            <a class="link link-primary link-sm" onclick="resend();" href="javascript:;"><?=translate_phrase('Resend Code');?>?</a>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="otp" name="otp" required minlength="4" maxlength="4" placeholder="Enter your otp">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block"><?=translate_phrase('Confirm');?></button>
                                    </div>
                                </form>
                                <div class="form-note-s2 text-center pt-4">
                                    <a href="<?=site_url(); ?>"><strong><?=translate_phrase('Return to login');?></strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        
    </div><!-- app body @e -->
    <!-- JavaScript -->

    <script src="<?=site_url(); ?>assets/js/bundle.js?ver=3.1.2"></script>
    <script src="<?=site_url(); ?>assets/js/scripts.js?ver=3.1.2"></script>
    
    <script src="<?php echo site_url(); ?>assets/js/jsform.js"></script> 
    <script>
        var site_url = '<?=site_url(); ?>';
        
        function resend(){
            $('#bb_ajax_msg').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            var phone = $('#phone').val();
            var email = $('#email').val();
            if(phone !== ''){   
                $.ajax({
                    url: site_url + 'auth/otp/resend',
                    type: 'post',
                    data: {phone:phone, email:email},
                    success: function (data) {
                        $('#bb_ajax_msg').html(data);                   
                    }
                });
            } else {
                $('#bb_ajax_msg').html('<h5 class="text-danger">Phone Number cannot be Empty</h5>');   
            }
           
        }
    </script>
</body>

</html>