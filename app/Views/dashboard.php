<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>
<?=$this->extend('designs/backend');?>
<?=$this->section('title');?>
<?=$title;?>
<?=$this->endSection();?>

<?=$this->section('content');?>
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Dashboard Overview</h3>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#"
                                    class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em>
                                </a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <input type="hidden" id="date_type" value="This Month">

                                        <li>
                                            <div class="drodown">
                                                <a href="javascript:;" class="dropdown-toggle btn btn-white btn  btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-calender-date"></em><span id="filter_type"><span class="d-none d-md-inline" id="filter_type"><?=translate_phrase('This'); ?></span> <?=translate_phrase('Month'); ?></span></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="javascript:;" class="typeBtn" data-value="Today"><span><?=translate_phrase('Today');?></span></a></li>
                                                        <li><a href="javascript:;" class="typeBtn" data-value="Yesterday"><span><?=translate_phrase('Yesterday');?></span></a></li>
                                                        <li><a href="javascript:;" class="typeBtn" data-value="Last_Week"><span><?=translate_phrase('Last 7 Days');?></span></a></li>
                                                        <li><a href="javascript:;" class="typeBtn active" data-value=""><span><?=translate_phrase('This Month');?></span></a></li>
                                                        <li><a href="javascript:;" class="typeBtn" data-value="This_Year"><span><?=translate_phrase('This Year');?></span></a></li>
                                                        <li><a href="javascript:;" class="typeBtn" data-value="Last_Month"><span><?=translate_phrase('Last 30 Days');?></span></a></li>
                                                        <li><a href="javascript:;" class="typeBtn" data-value="Date_Range"><span><?=translate_phrase('Date Range');?></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="btn-group align-items-center" id="data-resp" style="display:none;">
                                                &nbsp;|&nbsp;<b><?=translate_phrase('Date');?>:</b>&nbsp;
                                                <input type="date" class="form-control" name="date_from" id="date_from" oninput="load()" style="border:1px solid #ddd;" placeholder="<?=translate_phrase('START DATE');?>">
                                                &nbsp;<i class="anticon anticon-arrow-right"></i>&nbsp;
                                                <input type="date" class="form-control" name="date_to" id="date_to" oninput="load()" style="border:1px solid #ddd;" placeholder="<?=translate_phrase('END DATE');?>">
                                            </div>

                                            <div class="col-md-12" style="color:transparent;  text-white align:right;"><span id="date_resul"></span></div>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-md-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <h6 class="title">Total Offering</h6>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Total Offering"></em>
                                            </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount" id="offering"> 0.00 <span
                                                class="currency currency-usd">USD</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <h6 class="title">Total Tithe</h6>
                                        </div>
                                        <div class="card-tools"><em class="card-hint icon ni ni-help-fill"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Total Tithe"></em></div>
                                    </div>
                                    <div class="card-amount"><span class="amount" id="tithe"> 0.00 
                                        <span class="currency currency-usd">USD</span></span>
                                    </div>
                                    <div class="invest-data">
                                        <div class="invest-data-amount g-2">
                                            <div class="invest-data-history">
                                                <div class="title">Participant</div>
                                                <div class="amount" id="tithe_part">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-bordered  card-full">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <h6 class="title">Total Partnership</h6>
                                        </div>
                                        <div class="card-tools"><em class="card-hint icon ni ni-help-fill"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Total Partnership"></em>
                                            </div>
                                    </div>
                                    <div class="card-amount"><span class="amount" id="partnership"> 0.00 <span
                                                class="currency currency-usd">USD</span></span></div>
                                    <div class="invest-data">
                                        <div class="invest-data-amount g-2">
                                            <div class="invest-data-history">
                                                <div class="title">Participant</div>
                                                <div class="amount" id="partnership_part">0 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card card-bordered card-full">
                                <div class="card-inner d-flex flex-column h-100">
                                    <div class="card-title-group mb-3">
                                        <div class="card-title me-1">
                                            <h6 class="title">Partnership Section</h6>
                                        </div>
                                    </div>
                                    <div class="progress-list gy-3" id="partnership_list">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card card-bordered h-100">
                                <div class="card-inner mb-n2">
                                    <div class="card-title-group">
                                        <div class="card-title card-title-sm">
                                            <h6 class="title">Cell Report</h6>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="nk-tb-list is-loose traffic-channel-table" id="cell_data">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card card-bordered h-100">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Service Attendance Chart</h6>
                                            <p id="service_date">In last 30 days top selected package.</p>
                                        </div>
                                        <div class="card-tools">
                                            <div class="drodown">
                                                <a href="javascript:;" class="btn btn-sm btn-outline-light btn-white"  data-bs-toggle="dropdown">VIEW MORE</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="traffic-channel">
                                        <div class="traffic-channel-doughnut-ck"><canvas class="analytics-doughnut"
                                                id="BookingData"></canvas>
                                        </div>
                                        <div class="traffic-channel-group g-2" id="service_key">
                                            
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card card-bordered h-100">
                                <div class="card-inner">
                                    <div class="card-title-group pb-3 g-2">
                                        <div class="card-title">
                                            <h6 class="title">Sunday vs Wednesday</h6>
                                        </div>
                                        <div class="card-tools shrink-0 d-none d-sm-block">
                                            <ul class="nav nav-switch-s2 nav-tabs bg-white">
                                                <li class="nav-item"><a href="#" class="nav-link">Offering</a></li>
                                                <li class="nav-item"><a href="#" class="nav-link active">Tithe</a></li>
                                                <li class="nav-item"><a href="#" class="nav-link">Partnership</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="analytic-ov">
                                        <div class="analytic-data-group analytic-ov-group g-3">
                                            <div class="analytic-data analytic-ov-data">
                                                <div class="title text-primary">Income</div>
                                                <div class="amount">2.57K</div>
                                                <div class="change down"><em
                                                        class="icon ni ni-arrow-long-down"></em>12.37%
                                                </div>
                                            </div>
                                            <div class="analytic-data analytic-ov-data">
                                                <div class="title text-danger">Expenses</div>
                                                <div class="amount">3.5K</div>
                                                <div class="change down"><em class="icon ni ni-arrow-long-up"></em>8.37%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="analytic-ov-ck"><canvas class="analytics-line-large"
                                                id="analyticOvData"></canvas></div>
                                        <div class="chart-label-group ms-5">
                                            <div class="chart-label">01 Jan, 2020</div>
                                            <div class="chart-label d-none d-sm-block">15 Jan, 2020
                                            </div>
                                            <div class="chart-label">30 Jan, 2020</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">First Timer</h6>
                                            </div>
                                            <div class="card-tools"><a href="customers.html" class="link">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim"><span>AB</span>
                                            </div>
                                            <div class="user-info"><span class="lead-text">Abu Bin
                                                    Ishtiyak</span><span class="sub-text">info@softnio.com</span></div>
                                            <div class="user-action">
                                                <div class="drodown"><a href="#"
                                                        class="dropdown-toggle btn btn-icon btn-trigger me-n1"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><em
                                                            class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-setting"></em><span>Action
                                                                        Settings</span></a></li>
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-notify"></em><span>Push
                                                                        Notification</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-pink-dim"><span>SW</span></div>
                                            <div class="user-info"><span class="lead-text">Sharon
                                                    Walker</span><span class="sub-text">sharon-90@example.com</span>
                                            </div>
                                            <div class="user-action">
                                                <div class="drodown"><a href="#"
                                                        class="dropdown-toggle btn btn-icon btn-trigger me-n1"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><em
                                                            class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-setting"></em><span>Action
                                                                        Settings</span></a></li>
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-notify"></em><span>Push
                                                                        Notification</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-warning-dim"><span>GO</span>
                                            </div>
                                            <div class="user-info"><span class="lead-text">Gloria
                                                    Oliver</span><span class="sub-text">gloria_72@example.com</span>
                                            </div>
                                            <div class="user-action">
                                                <div class="drodown"><a href="#"
                                                        class="dropdown-toggle btn btn-icon btn-trigger me-n1"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><em
                                                            class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-setting"></em><span>Action
                                                                        Settings</span></a></li>
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-notify"></em><span>Push
                                                                        Notification</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-success-dim"><span>PS</span>
                                            </div>
                                            <div class="user-info"><span class="lead-text">Phillip
                                                    Sullivan</span><span class="sub-text">phillip-85@example.com</span>
                                            </div>
                                            <div class="user-action">
                                                <div class="drodown"><a href="#"
                                                        class="dropdown-toggle btn btn-icon btn-trigger me-n1"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><em
                                                            class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-setting"></em><span>Action
                                                                        Settings</span></a></li>
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-notify"></em><span>Push
                                                                        Notification</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-danger-dim"><span>TI</span></div>
                                            <div class="user-info"><span class="lead-text">Tasnim
                                                    Ifrat</span><span class="sub-text">tasif-85@example.com</span></div>
                                            <div class="user-action">
                                                <div class="drodown"><a href="#"
                                                        class="dropdown-toggle btn btn-icon btn-trigger me-n1"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><em
                                                            class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-setting"></em><span>Action
                                                                        Settings</span></a></li>
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-notify"></em><span>Push
                                                                        Notification</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-bordered card-full">
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Activity Log</h6>
                                        </div>
                                        <div class="card-tools">
                                            <ul class="card-tools-nav">
                                                <li><a href="#"><span>Cancel</span></a></li>
                                                <li class="active"><a href="#"><span>All</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nk-activity">
                                    <li class="nk-activity-item">
                                        <div class="nk-activity-media user-avatar bg-success"><img
                                                src="<?=site_url(); ?>assets/images/avatar.png" alt=""></div>
                                        <div class="nk-activity-data">
                                            <div class="label">Keith Jensen requested for room.</div>
                                            <span class="time">2 hours ago</span>
                                        </div>
                                    </li>
                                    <li class="nk-activity-item">
                                        <div class="nk-activity-media user-avatar bg-warning">HS</div>
                                        <div class="nk-activity-data">
                                            <div class="label">Harry Simpson placed a Order.</div><span class="time">2
                                                hours ago</span>
                                        </div>
                                    </li>
                                    <li class="nk-activity-item">
                                        <div class="nk-activity-media user-avatar bg-azure">SM</div>
                                        <div class="nk-activity-data">
                                            <div class="label">Stephanie Marshall cancelled booking.
                                            </div><span class="time">2 hours ago</span>
                                        </div>
                                    </li>
                                    <li class="nk-activity-item">
                                        <div class="nk-activity-media user-avatar bg-purple"><img
                                                src="<?=site_url(); ?>assets/images/avatar.png" alt=""></div>
                                        <div class="nk-activity-data">
                                            <div class="label">Nicholas Carr confirmed booking.</div>
                                            <span class="time">2 hours ago</span>
                                        </div>
                                    </li>
                                    <li class="nk-activity-item">
                                        <div class="nk-activity-media user-avatar bg-pink">TM</div>
                                        <div class="nk-activity-data">
                                            <div class="label">Timothy Moreno placed a Order.</div><span class="time">2
                                                hours ago</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?=$this->endSection();?>
<?=$this->section('scripts');?>

   
<script>
    function analyticsLineLarge(selector, set_data) {
        var $selector = $(selector || ".analytics-line-large");
        $selector.each(function () {
            for (
                var $self = $(this), _self_id = $self.attr("id"), _get_data = void 0 === set_data ? eval(_self_id) : set_data, selectCanvas = document.getElementById(_self_id).getContext("2d"), chart_data = [], i = 0;
                i < _get_data.datasets.length;
                i++
            )
                chart_data.push({
                    label: _get_data.datasets[i].label,
                    tension: _get_data.lineTension,
                    backgroundColor: _get_data.datasets[i].background,
                    fill: !0,
                    borderWidth: 2,
                    borderDash: _get_data.datasets[i].dash,
                    borderColor: _get_data.datasets[i].color,
                    pointBorderColor: "transparent",
                    pointBackgroundColor: "transparent",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: _get_data.datasets[i].color,
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                    pointHitRadius: 4,
                    data: _get_data.datasets[i].data,
                });
            var chart = new Chart(selectCanvas, {
                type: "line",
                data: { labels: _get_data.labels, datasets: chart_data },
                options: {
                    plugins: {
                        legend: { display: _get_data.legend || !1, labels: { boxWidth: 12, padding: 20, color: "#6783b8" } },
                        tooltip: {
                            enabled: !0,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                label: function (a) {
                                    return "".concat(a.parsed.y, " ").concat(_get_data.dataUnit);
                                },
                            },
                            backgroundColor: "#fff",
                            borderColor: "#eff6ff",
                            borderWidth: 2,
                            titleFont: { size: 13 },
                            titleColor: "#6783b8",
                            titleMarginBottom: 6,
                            bodyColor: "#9eaecf",
                            bodyFont: { size: 12 },
                            bodySpacing: 4,
                            padding: 10,
                            footerMarginTop: 0,
                            displayColors: !1,
                        },
                    },
                    maintainAspectRatio: !1,
                    scales: {
                        y: {
                            display: !0,
                            position: NioApp.State.isRTL ? "right" : "left",
                            ticks: { beginAtZero: !0, font: { size: 12 }, color: "#9eaecf", padding: 8, stepSize: 2400 },
                            grid: { color: NioApp.hexRGB("#526484", 0.2), tickLength: 0, zeroLineColor: NioApp.hexRGB("#526484", 0.2), drawTicks: !1 },
                        },
                        x: {
                            display: !1,
                            ticks: { font: { size: 12 }, color: "#9eaecf", source: "auto", padding: 0, reverse: NioApp.State.isRTL },
                            grid: { color: "transparent", tickLength: 0, zeroLineColor: "transparent", offset: !0, drawTicks: !1 },
                        },
                    },
                },
            });
        });
    }

    function analyticsDoughnut(selector, set_data) {
        var $selector = $(selector || ".analytics-doughnut");
        $selector.each(function () {
            var $self = $(this),
                _self_id = $self.attr("id"),
                _get_data = void 0 === set_data ? eval(_self_id) : set_data,
                selectCanvas = document.getElementById(_self_id),
                ctx = selectCanvas.getContext("2d");

            // Clear the canvas
            ctx.clearRect(0, 0, selectCanvas.width, selectCanvas.height);

            // Destroy existing chart if it exists
            if (selectCanvas.chart) {
                selectCanvas.chart.destroy();
            }

            var chart_data = [];

            for (var i = 0; i < _get_data.datasets.length; i++) {
                chart_data.push({
                    backgroundColor: _get_data.datasets[i].background,
                    borderWidth: 2,
                    borderColor: _get_data.datasets[i].borderColor,
                    hoverBorderColor: _get_data.datasets[i].borderColor,
                    data: _get_data.datasets[i].data
                });
            }

            var chart = new Chart(selectCanvas, {
                type: "doughnut",
                data: {
                    labels: _get_data.labels,
                    datasets: chart_data
                },
                options: {
                    plugins: {
                        legend: {
                            display: _get_data.legend || false,
                            labels: {
                                boxWidth: 12,
                                padding: 20,
                                color: "#6783b8"
                            }
                        },
                        tooltip: {
                            enabled: true,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                label: function (a) {
                                    return "".concat(a.parsed, " ").concat(_get_data.dataUnit);
                                },
                            },
                            backgroundColor: "#fff",
                            borderColor: "#eff6ff",
                            borderWidth: 2,
                            titleFont: { size: 13 },
                            titleColor: "#6783b8",
                            titleMarginBottom: 6,
                            bodyColor: "#9eaecf",
                            bodyFont: { size: 12 },
                            bodySpacing: 4,
                            padding: 10,
                            footerMarginTop: 0,
                            displayColors: false
                        }
                    },
                    rotation: -1.5,
                    cutoutPercentage: 70,
                    maintainAspectRatio: false
                }
            });

            // Store the chart instance on the canvas element
            selectCanvas.chart = chart;
        });
    }

    var site_url = '<?php echo site_url(); ?>';

    $(function() {
        metric_load(); load();
    });

    $('.typeBtn').click(function() {
        $('#date_type').val($(this).attr('data-value'));
        $('#filter_type').html($(this).html());
        $(this).addClass('active');
        $(this).siblings().removeClass('active');

        if ($(this).attr('data-value') == 'Date_Range') {
            $('#data-resp').show(300);
        } else {
            $('#data-resp').hide(300);
            metric_load();
            load();
        }
    });

    function load() {
        $('#service_date').html( '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>' );
        $('#service_key').html( '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>' );


        var date_type = $('#date_type').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        $.ajax({
            url: site_url + 'dashboard/service_metric',
            data: {
                date_type: date_type,
                start_date: start_date,
                end_date: end_date
            },
            type: 'post',
            success: function(data) {
                var dt = JSON.parse(data);
                $('#service_date').html(dt.service_date);
                $('#service_key').html(dt.service_key);
                var dataArray = JSON.parse(dt.service_data);
                console.log(dataArray);
                var BookingData = { labels: ["Male", "Female", "Children", "First Timer"], dataUnit: "People", legend: !1, datasets: [{ borderColor: "#fff", background: ["#798bff", "#1ee0ac", "#f9db7b", "#ffa353"], data: dataArray }] };
                analyticsDoughnut('#BookingData', BookingData);
            }
        });
    }

    function metric_load() {
        $('#partnership').html(
            '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
        $('#partnership_part').html(
            '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
        $('#tithe_part').html(
            '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
        $('#tithe').html(
            '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
        $('#offering').html(
            '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
        $('#offering_part').html(
            '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
        $('#partnership_list').html(
            '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
        $('#cell_data').html(
        '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
        );
        var date_type = $('#date_type').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        $.ajax({
            url: site_url + 'dashboard/metric',
            type: 'post',
            data: {
                date_type: date_type,
                start_date: start_date,
                end_date: end_date
            },
            success: function(data) {
                var dt = JSON.parse(data);

                $('#tithe').html(dt.tithe);
                $('#tithe_part').html(dt.tithe_part);
                $('#offering_part').html(dt.offering_part);
                $('#offering').html(dt.offering);
                $('#partnership_part').html(dt.partnership_part);
                $('#partnership').html(dt.partnership);
                $('#partnership_list').html(dt.partnership_list);
                $('#cell_data').html(dt.cell_data);
                
                //Progress plugins
                NioApp.BS.progress('[data-progress]');

              
                var analyticOvData = {
                    labels: [
                        "01 Jan",
                        "02 Jan",
                        "03 Jan",
                        "04 Jan",
                        "05 Jan",
                        "06 Jan",
                        "07 Jan",
                        "08 Jan",
                        "09 Jan",
                        "10 Jan",
                        "11 Jan",
                        "12 Jan",
                        "13 Jan",
                        "14 Jan",
                        "15 Jan",
                        "16 Jan",
                        "17 Jan",
                        "18 Jan",
                        "19 Jan",
                        "20 Jan",
                        "21 Jan",
                        "22 Jan",
                        "23 Jan",
                        "24 Jan",
                        "25 Jan",
                        "26 Jan",
                        "27 Jan",
                        "28 Jan",
                        "29 Jan",
                        "30 Feb",
                    ],
                    dataUnit: "People",
                    lineTension: 0.1,
                    datasets: [
                        {
                            label: "Current Month",
                            color: "#e85347",
                            dash: [5, 5],
                            background: "transparent",
                            data: [3910, 4420, 4110, 5180, 4400, 5170, 6460, 8830, 5290, 5430, 4690, 4350, 4600, 5200, 5650, 6850, 6950, 4150, 4300, 6e3, 6800, 2250, 6900, 7950, 6900, 4200, 6250, 7650, 8950, 9750],
                        },
                        {
                            label: "Current Month",
                            color: "#798bff",
                            dash: [0, 0],
                            background: NioApp.hexRGB("#798bff", 0.15),
                            data: [4110, 4220, 4810, 5480, 4600, 5670, 6660, 4830, 5590, 5730, 4790, 4950, 5100, 5800, 5950, 5850, 5950, 4450, 4900, 8e3, 7200, 7250, 7900, 8950, 6300, 7200, 7250, 7650, 6950, 4750],
                        },
                    ],
                };
                analyticsLineLarge('.analytics-line-large', analyticOvData);
            }
        });
    }

</script>
<?=$this->endSection();?>