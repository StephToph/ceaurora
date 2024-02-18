<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>
<!DOCTYPE html>
<head>
    <base href="<?=site_url(); ?>assets/../">
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
<!--End of Tawk.to Script-->
<body class="nk-body bg-white npc-general pg-auth">
    <!-- app body @s -->
    <div class="nk-app-root">
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-md">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="<?=site_url(); ?>" class="logo-link">
                                        <img class="logo-light logo-img logo-img-lg" src="<?=site_url(); ?>assets/logo.png" srcset="/demo1/images/logo2x.png 2x" alt="logo">
                                        <img class="logo-dark logo-img logo-img-lg" src="<?=site_url(); ?>assets/logo.png" srcset="/demo1/images/logo-dark2x.png 2x" alt="logo-dark">
                                    </a>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Sign-In</h5>
                                        <div class="nk-block-des">
                                            <p>Access the DashLite panel using your email and passcode.</p>
                                        </div>
                                    </div>
                                </div>
                                <form action="#">
                                    <div class="form-group">
                                        <div class="form-label-group"><label class="form-label" for="default-01">Email
                                                or Username</label><a class="link link-primary link-sm" tabindex="-1"
                                                href="#">Need Help?</a></div>
                                        <div class="form-control-wrap"><input type="text"
                                                class="form-control form-control-lg" id="default-01"
                                                placeholder="Enter your email address or username"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group"><label class="form-label"
                                                for="password">Passcode</label><a class="link link-primary link-sm"
                                                tabindex="-1" href="auth-reset-v3.html">Forgot Code?</a></div>
                                        <div class="form-control-wrap"><a tabindex="-1" href="#"
                                                class="form-icon form-icon-right passcode-switch lg"
                                                data-target="password"><em
                                                    class="passcode-icon icon-show icon ni ni-eye"></em><em
                                                    class="passcode-icon icon-hide icon ni ni-eye-off"></em></a><input
                                                type="password" class="form-control form-control-lg" id="password"
                                                placeholder="Enter your passcode"></div>
                                    </div>
                                    <div class="form-group"><button class="btn btn-lg btn-primary btn-block">Sign
                                            in</button></div>
                                </form>
                                <div class="form-note-s2 pt-4"> New on our platform? <a
                                        href="auth-register-v3.html">Create an account</a></div>
                                <div class="text-center pt-4 pb-3">
                                    <h6 class="overline-title overline-title-sap"><span>OR</span></h6>
                                </div>
                                <ul class="nav justify-center gx-4">
                                    <li class="nav-item"><a class="link link-primary fw-normal py-2 px-3"
                                            href="#">Facebook</a></li>
                                    <li class="nav-item"><a class="link link-primary fw-normal py-2 px-3"
                                            href="#">Google</a></li>
                                </ul>
                                <div class="text-center mt-5"><span class="fw-500">I don't have an account? <a
                                            href="#">Try 15 days free</a></span></div>
                            </div>
                            <div class="nk-block nk-auth-footer">
                                <div class="nk-block-between">
                                    <ul class="nav nav-sm">
                                        <li class="nav-item"><a class="link link-primary fw-normal py-2 px-3"
                                                href="#">Terms & Condition</a></li>
                                        <li class="nav-item"><a class="link link-primary fw-normal py-2 px-3"
                                                href="#">Privacy Policy</a></li>
                                        <li class="nav-item"><a class="link link-primary fw-normal py-2 px-3"
                                                href="#">Help</a></li>
                                        <li class="nav-item dropup"><a
                                                class="dropdown-toggle dropdown-indicator has-indicator link link-primary fw-normal py-2 px-3"
                                                data-bs-toggle="dropdown" data-offset="0,10"><small>English</small></a>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                <ul class="language-list">
                                                    <li><a href="#" class="language-item"><img
                                                                src="<?=site_url(); ?>assets/images/flags/english.png" alt=""
                                                                class="language-flag"><span
                                                                class="language-name">English</span></a></li>
                                                    <li><a href="#" class="language-item"><img
                                                                src="<?=site_url(); ?>assets/images/flags/spanish.png" alt=""
                                                                class="language-flag"><span
                                                                class="language-name">Español</span></a></li>
                                                    <li><a href="#" class="language-item"><img
                                                                src="<?=site_url(); ?>assets/images/flags/french.png" alt=""
                                                                class="language-flag"><span
                                                                class="language-name">Français</span></a></li>
                                                    <li><a href="#" class="language-item"><img
                                                                src="<?=site_url(); ?>assets/images/flags/turkey.png" alt=""
                                                                class="language-flag"><span
                                                                class="language-name">Türkçe</span></a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <p>&copy; 2023 DashLite. All Rights Reserved.</p>
                                </div>
                            </div>
                        </div>
                        <div class="nk-split-content nk-split-stretch bg-abstract"></div>
                    </div>
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