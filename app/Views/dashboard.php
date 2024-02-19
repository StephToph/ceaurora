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
  <!-- content @s -->
   
            <!-- content @e -->
<!-- content @e -->
<?=$this->endSection();?>
<?=$this->section('scripts');?>

<script>var site_url = '<?php echo site_url(); ?>';</script>
<script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>
<script>
    $(function() {
        
    });

    $('.typeBtn').click(function() {
        $('#date_type').val($(this).attr('data-value'));
        $('#filter_type').html($(this).html());
        $(this).addClass('active');
        $(this).siblings().removeClass('active');

        if($(this).attr('data-value') == 'Date_Range') {
            $('#data-resp').show(300);
        } else {
            $('#data-resp').hide(300);
            metric_load();load();
        }
    });
    function load(x, y) {
        

        var more = 'no';
        var methods = '';
        if (parseInt(x) > 0 && parseInt(y) > 0) {
            more = 'yes';
            methods = '/' + x + '/' + y;
        }

        if (more == 'no') {
            $('#load_data').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><span><?=translate_phrase('Loading.. Please Wait'); ?></span></div>');
            $('#total_id').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        } else {
            $('#loadmore').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><?=translate_phrase('Loading.. PLease Wait'); ?></div>');
        }

        var loads = '<?=translate_phrase('Load More'); ?>';
        var date_type = $('#date_type').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var territory = $('#territory').val();
        var lga_id = $('#lga_id').val();

        $.ajax({
            url: site_url + 'dashboard/index/tax_metric' + methods,
            data: { date_type: date_type, start_date: start_date, end_date: end_date,territory: territory, lga_id: lga_id },
            type: 'post',
            success: function (data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }
            },
            complete: function () {
                $.getScript(site_url + '/assets/js/jsmodal.js');
            }
        });
    }

    function metric_load() {
        $('#remittance').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#total_paid').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#total_unpaid').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#personal').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#business').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#master').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#field').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        var date_type = $('#date_type').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var territory = $('#territory').val();
        var lga_id = $('#lga_id').val();
      
        $.ajax({
            url: site_url + 'dashboard/metric',
            type: 'post',
            data: { date_type: date_type, start_date: start_date, end_date: end_date,territory: territory, lga_id: lga_id },
            success: function (data) {
                var dt = JSON.parse(data);
               
                $('#remittance').html(dt.remittance);
                $('#total_paid').html(dt.total_paid);
                $('#total_unpaid').html(dt.total_unpaid);
                $('#personal').html(dt.personal);
                $('#business').html(dt.business);
                $('#master').html(dt.master);
                $('#field').html(dt.field);
               
            }
        });
    }

    function virtual_create(){
        $('#virtual_resp').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $.ajax({
            url: site_url + 'dashboard/create_virtual',
            type: 'post',
            success: function (data) {
                $('#virtual_resp').html(data);
               
            }
        });
    }

    function copyToClipboard() {
        // Get the text content of the div
        var textToCopy = document.getElementById('tax_id').innerText;

        // Create a textarea element to temporarily hold the text
        var textarea = document.createElement('textarea');
        textarea.value = textToCopy;
        document.body.appendChild(textarea);

        // Select the text in the textarea
        textarea.select();
        textarea.setSelectionRange(0, textarea.value.length);

        // Copy the selected text to the clipboard
        document.execCommand('copy');

        // Remove the textarea from the DOM
        document.body.removeChild(textarea);
        $('#copy_resp').html('<span class="text-danger">Tax ID Copied</span>');
        // Optionally, provide some visual feedback (e.g., an alert)
        setTimeout(function() {
            $('#copy_resp').html('');
        }, 3000);
    }
</script> 
<?=$this->endSection();?>
