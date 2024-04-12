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
                                <div class="card-inner">
                                    <div class="card-title-group align-start pb-3 g-2">
                                        <div class="card-title">
                                            <h6 class="title">Sales Revenue</h6>
                                            <p>In last 30 days revenue from rent.</p>
                                        </div>
                                        <div class="card-tools"><em class="card-hint icon ni ni-help"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Revenue of this month"></em></div>
                                    </div>
                                    <div class="analytic-au">
                                        <div class="analytic-data-group analytic-au-group g-3">
                                            <div class="analytic-data analytic-au-data">
                                                <div class="title">Monthly</div>
                                                <div class="amount">9.28K</div>
                                                <div class="change up"><em class="icon ni ni-arrow-long-up"></em>4.63%
                                                </div>
                                            </div>
                                            <div class="analytic-data analytic-au-data">
                                                <div class="title">Weekly</div>
                                                <div class="amount">2.69K</div>
                                                <div class="change down"><em
                                                        class="icon ni ni-arrow-long-down"></em>1.92%
                                                </div>
                                            </div>
                                            <div class="analytic-data analytic-au-data">
                                                <div class="title">Daily (Avg)</div>
                                                <div class="amount">0.94K</div>
                                                <div class="change up"><em class="icon ni ni-arrow-long-up"></em>3.45%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="analytic-au-ck"><canvas class="analytics-au-chart"
                                                id="analyticAuData"></canvas></div>
                                        <div class="chart-label-group">
                                            <div class="chart-label">01 Jan, 2020</div>
                                            <div class="chart-label">30 Jan, 2020</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card card-bordered h-100">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Service Attendance Chart</h6>
                                        </div>
                                        <div class="card-tools">
                                            <div class="drodown"><a href="#"
                                                    class="dropdown-toggle dropdown-indicator btn btn-sm btn-outline-light btn-white"
                                                    data-bs-toggle="dropdown">30 Days</a>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><span>7 Days</span></a></li>
                                                        <li><a href="#"><span>15 Days</span></a></li>
                                                        <li><a href="#"><span>30 Days</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="traffic-channel">
                                        <div class="traffic-channel-doughnut-ck"><canvas class="analytics-doughnut"
                                                id="BookingData"></canvas>
                                        </div>
                                        <div class="traffic-channel-group g-2">
                                            <div class="traffic-channel-data">
                                                <div class="title"><span class="dot dot-lg sq"
                                                        data-bg="#9cabff"></span><span>Single</span>
                                                </div>
                                                <div class="amount">1913 <small>58.63%</small></div>
                                            </div>
                                            <div class="traffic-channel-data">
                                                <div class="title"><span class="dot dot-lg sq"
                                                        data-bg="#1ee0ac"></span><span>Double</span>
                                                </div>
                                                <div class="amount">859 <small>23.94%</small></div>
                                            </div>
                                            <div class="traffic-channel-data">
                                                <div class="title"><span class="dot dot-lg sq"
                                                        data-bg="#f9db7b"></span><span>Delux</span>
                                                </div>
                                                <div class="amount">482 <small>12.94%</small></div>
                                            </div>
                                            <div class="traffic-channel-data">
                                                <div class="title"><span class="dot dot-lg sq"
                                                        data-bg="#ffa353"></span><span>Suit</span></div>
                                                <div class="amount">138 <small>4.49%</small></div>
                                            </div>
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
                        <div class="col-md-12">
                            <div class="card card-bordered h-100">
                                <div class="card-inner mb-n2">
                                    <div class="card-title-group">
                                        <div class="card-title card-title-sm">
                                            <h6 class="title">Cell Report</h6>
                                        </div>
                                        <div class="card-tools">
                                            <div class="drodown"><a href="#"
                                                    class="dropdown-toggle dropdown-indicator btn btn-sm btn-outline-light btn-white"
                                                    data-bs-toggle="dropdown">30 Days</a>
                                                <div
                                                    class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><span>7 Days</span></a></li>
                                                        <li><a href="#"><span>15 Days</span></a></li>
                                                        <li><a href="#"><span>30 Days</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-tb-list is-loose traffic-channel-table">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col nk-tb-channel"><span>Channel</span></div>
                                        <div class="nk-tb-col nk-tb-sessions"><span>Sessions</span>
                                        </div>
                                        <div class="nk-tb-col nk-tb-prev-sessions"><span>Prev
                                                Sessions</span></div>
                                        <div class="nk-tb-col nk-tb-change"><span>Change</span></div>
                                        
                                    </div>
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col nk-tb-channel"><span
                                                class="tb-lead">Organic Search</span></div>
                                        <div class="nk-tb-col nk-tb-sessions"><span
                                                class="tb-sub tb-amount"><span>4,305</span></span></div>
                                        <div class="nk-tb-col nk-tb-prev-sessions"><span
                                                class="tb-sub tb-amount"><span>4,129</span></span></div>
                                        <div class="nk-tb-col nk-tb-change"><span
                                                class="tb-sub"><span>4.29%</span> <span
                                                    class="change up"><em
                                                        class="icon ni ni-arrow-long-up"></em></span></span>
                                        </div>
                                        
                                    </div>
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col nk-tb-channel"><span
                                                class="tb-lead">Social Media</span></div>
                                        <div class="nk-tb-col nk-tb-sessions"><span
                                                class="tb-sub tb-amount"><span>859</span></span></div>
                                        <div class="nk-tb-col nk-tb-prev-sessions"><span
                                                class="tb-sub tb-amount"><span>936</span></span></div>
                                        <div class="nk-tb-col nk-tb-change"><span
                                                class="tb-sub"><span>15.8%</span> <span
                                                    class="change down"><em
                                                        class="icon ni ni-arrow-long-down"></em></span></span>
                                        </div>
                                        
                                    </div>
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col nk-tb-channel"><span
                                                class="tb-lead">Referrals</span></div>
                                        <div class="nk-tb-col nk-tb-sessions"><span
                                                class="tb-sub tb-amount"><span>482</span></span></div>
                                        <div class="nk-tb-col nk-tb-prev-sessions"><span
                                                class="tb-sub tb-amount"><span>793</span></span></div>
                                        <div class="nk-tb-col nk-tb-change"><span
                                                class="tb-sub"><span>41.3%</span> <span
                                                    class="change down"><em
                                                        class="icon ni ni-arrow-long-down"></em></span></span>
                                        </div>
                                        
                                    </div>
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col nk-tb-channel"><span
                                                class="tb-lead">Others</span></div>
                                        <div class="nk-tb-col nk-tb-sessions"><span
                                                class="tb-sub tb-amount"><span>138</span></span></div>
                                        <div class="nk-tb-col nk-tb-prev-sessions"><span
                                                class="tb-sub tb-amount"><span>97</span></span></div>
                                        <div class="nk-tb-col nk-tb-change"><span
                                                class="tb-sub"><span>12.6%</span> <span
                                                    class="change up"><em
                                                        class="icon ni ni-arrow-long-up"></em></span></span>
                                        </div>
                                        
                                    </div>
                                </div>
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
var site_url = '<?php echo site_url(); ?>';
</script>
<script>
    $(function() {
        metric_load();
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

    function load(x, y) {


        var more = 'no';
        var methods = '';
        if (parseInt(x) > 0 && parseInt(y) > 0) {
            more = 'yes';
            methods = '/' + x + '/' + y;
        }

        if (more == 'no') {
            $('#load_data').html(
                '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><span><?=translate_phrase('Loading.. Please Wait'); ?></span></div>'
                );
            $('#total_id').html(
                '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                );
        } else {
            $('#loadmore').html(
                '<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><?=translate_phrase('Loading.. PLease Wait'); ?></div>'
                );
        }

        var loads = '<?=translate_phrase('Load More'); ?>';
        var date_type = $('#date_type').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var territory = $('#territory').val();
        var lga_id = $('#lga_id').val();

        $.ajax({
            url: site_url + 'dashboard/index/tax_metric' + methods,
            data: {
                date_type: date_type,
                start_date: start_date,
                end_date: end_date,
                territory: territory,
                lga_id: lga_id
            },
            type: 'post',
            success: function(data) {
                var dt = JSON.parse(data);
                if (more == 'no') {
                    $('#load_data').html(dt.item);
                } else {
                    $('#load_data').append(dt.item);
                }
            },
            complete: function() {
                $.getScript(site_url + '/assets/js/jsmodal.js');
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
                NioApp.BS.progress('[data-progress]');
            }
        });
    }

</script>
<?=$this->endSection();?>