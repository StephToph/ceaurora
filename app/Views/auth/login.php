<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>
<!DOCTYPE html>
<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="green">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?=site_url(); ?>assets/fav.png">
    <!-- Page Title  -->
    <title><?=$title; ?></title>
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
                height: 70vh;
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
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6596ffd10ff6374032bca25d/1hjatej6s';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
</script>
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
                            <img class="logo-dark pt-5 " src="<?=site_url(); ?>assets/logo.png" srcset="<?=site_url(); ?>assets/logo.png 2x" alt="logo-dark" height="180">
                        </a>
                        <h3>Welcome to TIDREMS</h3>
                        <p class="mx-5" style="font-style:italic;">Tax ID DIrect Remittance System for easy and secure Enrolment and Payment of government taxes.</p>
                        <img class="logo-dark py-1 mb-2" src="<?=site_url(); ?>assets/delta.png" srcset="<?=site_url(); ?>assets/delta.png 2x" alt="logo-dark" height="60">
                    </div>
                    <div class="card card-bordered" style="border-radius:25px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content text-center">
                                    <h1 class="nk-block-title text-dark"><?=translate_phrase('Login')?></h1>
                                    <div class="nk-block-des">
                                        <p><?=translate_phrase('Sign in to Continue'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_open_multipart('auth/login', array('id'=>'bb_ajax_form', 'class'=>'')); ?>
                                <div class="row mb-3"><div id="bb_ajax_msg"></div></div>
                                <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="email-address"><?=translate_phrase('Email or Phone Number'); ?> </label>
                                </div>
                                <div class="form-control-wrap">
                                    <input autocomplete="off"name="email" type="text" id="email" class="form-control form-control-lg" required placeholder="<?=translate_phrase('Enter your email or phone number'); ?>">
                                </div>
                                </div><!-- .form-group -->
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="password"><?=translate_phrase('Password'); ?></label>
                                        <a class="link link-primary link-sm" tabindex="-1" href="<?=site_url('auth/forgot'); ?>"><?=translate_phrase('Reset Password' ); ?></a>
                                    </div>
                                    <div class="form-control-wrap">
                                        <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input autocomplete="new-password" type="password" name="password" class="form-control form-control-lg" required id="password" placeholder="<?=translate_phrase('Enter your password'); ?>">
                                    </div>
                                </div><!-- .form-group -->
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary btn-block bb_fom_btn mb-3 mt-3" type="submit"><?=translate_phrase('Sign in'); ?></button>
                                </div>
                                <?=form_close();?>
                                <div class="form-note-s2 pt-4 text-center"> <?=translate_phrase('New on our platform?');?>? <a href="<?=site_url('auth/register'); ?>"><?=translate_phrase('Create an account'); ?></a>
                                </div>
                                <div class="form-note-s2 pt-4 text-center"> <?=translate_phrase('Account not Activated?');?>? <a href="<?=site_url('auth/otp'); ?>"><?=translate_phrase('Verify OTP'); ?></a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>

    </div>
    
    <script>
        var site_url = '<?=site_url(); ?>';
        function lang_session(lang_id){
            if(lang_id !== ''){
                $.ajax({
                    url: site_url + 'auth/language/' + lang_id,
                    success: function (data) {
                        $('#bb_ajax_msg').html(data);                   
                    }
                });
            }
        }
    </script>
    
     <script src="<?=site_url(); ?>assets/js/bundle.js"></script>
    <script src="<?=site_url(); ?>assets/js/scripts.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/jsform.js"></script> 
    <!-- select region modal -->
</body>

</html>