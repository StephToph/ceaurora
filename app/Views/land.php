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
 <div class="nk-content nk-content-fluid pt-5">
    <div class="container-xl wide-lg">
        <div class="nk-content-body"> 
            <input type="text" id="key" value="<?=time(); ?>">
            <div id="resp"></div>

            <?php
                //  echo time().'<br>'; 
                // $concat = time().'pUXAYr97v7UDUSxjteULaDbwlzBtR3eC';
                // $sha = hash('sha512', $concat);
                // $base = base64_encode($sha);
                // echo $concat.'<br>' .$sha.' <br>'. $base.' <br>'. strlen($base).'<br><br>'; 
            ?>
        </div>
    </div>
</div>
<!-- content @e -->
<?=$this->endSection();?>
<?=$this->section('scripts');?>

<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo site_url(); ?>assets/js/jquery.min.js"></script>

<?=$this->endSection();?>
