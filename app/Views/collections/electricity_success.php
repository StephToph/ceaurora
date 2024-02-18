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
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <meta name="theme-color" content="green">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?=site_url(); ?>assets/favicon.png">
    <!-- Page Title  -->
    <title><?=$title; ?></title>
    <link rel="manifest" href="<?=site_url(); ?>manifest.webmanifest">
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?=site_url(); ?>assets/css/dashlite.css">
    <link id="skin-default" rel="stylesheet" href="<?=site_url(); ?>assets/css/skins/theme-green.css">
    
</head>

<body class="nk-body npc-crypto bg-white pg-auth">
    <!-- app body @s -->
    <div class="nk-app-root">
        <div class="nk-split nk-split-page nk-split-lg">
            <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white" style="width:100%">
                <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                    <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                </div>
                <div class="nk-block nk-block-middle nk-auth-body" style="margin-top:0px;margin-bottom: 0px;">
                    <div class="brand-logo pb-5">
                        <a href="<?=site_url(); ?>" class="logo-link">
                            <img class="logo-light logo-img logo-img-lg" src="<?=site_url(); ?>assets/logo.png" srcset="<?=site_url(); ?>assets/logo.png 2x" alt="logo">
                            <img class="logo-dark logo-img logo-img-lg" src="<?=site_url(); ?>assets/logo.png" srcset="<?=site_url(); ?>assets/logo.png 2x" alt="logo-dark">
                        </a>
                    </div>
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h5 class="nk-block-title"><?=translate_phrase('Transaction History'); ?></h5>
                        </div>
                    </div><!-- .nk-block-head -->
                    
                    <div class="col-sm-12">
                        <table class="table table-response table-striped">
                            <thead>
                                <tr>
                                    <td><b><?=translate_phrase('DATE'); ?></b></td>
                                    <td class="text-right" width=""><b><?=translate_phrase('Remark'); ?></b></td>
                                    <td class="text-right" width=""><b><?=translate_phrase('PRICE'); ?> (<?php echo curr; ?>)</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div><!-- .nk-split -->
    </div>
    
     <script src="<?=site_url(); ?>assets/js/bundle.js"></script>
    <script src="<?=site_url(); ?>assets/js/scripts.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/jsform.js"></script> 
    <!-- select region modal -->
</body>

</html>