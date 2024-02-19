<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
    
    $username = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
    $email = $this->Crud->read_field('id', $log_id, 'user', 'email');
    $log_role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
	$log_role = strtolower($this->Crud->read_field('id', $log_role_id, 'access_role', 'name'));
    $log_user_img_id = 0;
    $log_user_img = $this->Crud->image($log_user_img_id, 'big');
    $balance = 0;
    $earnings = 0;
    $withdrawns = 0;

    $query = $this->Crud->read_single('user_id', $log_id, 'wallet');
    if(!empty($query)) {
        foreach($query as $q) {
            if($q->type == 'credit') {
                $earnings += (float)$q->amount;
            } else {
                $withdrawns += (float)$q->amount;
            }
        }
        $balance = $earnings - $withdrawns;
    }

    
    header("Access-Control-Allow-Origin: *");  // Replace * with the specific origin(s) you want to allow
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
?>

<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../">
    <meta charset="utf-8">
    <meta name="author" content="TiDREM">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Add Money, Make Transfers, Pay Bills">
    <meta name="theme-color" content="blue">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?=site_url(); ?>assets/fav.png">
    <title><?=$title; ?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?=site_url(); ?>assets/css/dashlitee5ca.css?ver=3.2.3">
    <link id="skin-default" rel="stylesheet" href="<?=site_url(); ?>assets/css/themee5ca.css?ver=3.2.3">
    <style>
        
       @media (max-width: 768px) {
        
            .navbars {
                background-color: #333;
                padding: 15px;
                text-align: center;
                color: white;
                position: fixed;
                bottom: 0;
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000; 
            }

            .nav-linkss {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                justify-content: center;
            }

            .nav-linkss li {
                margin: 0 15px;
            }

            .nav-linkss a {
                color: white;
                text-decoration: none;
            }
        }
    </style>
    
</head>


<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger"><a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none"
                        data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a><a href="#"
                        class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex"
                        data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-header-brand">
                        <a href="<?=site_url(); ?>" class="logo-link">
                            <img class="logo-light logo-img logo-img-lg" src="<?=site_url(); ?>assets/logo.png" srcset="<?=site_url(); ?>assets/logo.png 2x" style="max-width:70%" alt="logo">
                            <img class="logo-dark logo-img logo-img-lg" src="<?=site_url(); ?>assets/logo.png" srcset="<?=site_url(); ?>assets/logo.png 2x" style="max-width:70%" alt="logo-dark">
                        </a>
                    </div>
                </div>
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                <li class="nk-menu-item"><a href="index.html" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span><span
                                            class="nk-menu-text">Dashboard</span></a></li>
                                <li class="nk-menu-item has-sub"><a href="#" class="nk-menu-link nk-menu-toggle"><span
                                            class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span><span
                                            class="nk-menu-text">Lead</span></a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item"><a href="people.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">People</span></a></li>
                                        <li class="nk-menu-item"><a href="organizations.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Organization</span></a></li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item"><a href="customer-list.html" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-user-list-fill"></em></span><span
                                            class="nk-menu-text">Customers</span></a></li>
                                <li class="nk-menu-item has-sub"><a href="#" class="nk-menu-link nk-menu-toggle"><span
                                            class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span><span
                                            class="nk-menu-text">Sales</span></a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item"><a href="invoices.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Invoices</span></a></li>
                                        <li class="nk-menu-item"><a href="payment.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Payment</span></a></li>
                                        <li class="nk-menu-item"><a href="recent-sale.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Recent Sale</span></a></li>
                                        <li class="nk-menu-item"><a href="estimates.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Estimates</span></a></li>
                                        <li class="nk-menu-item"><a href="expenses.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Expenses</span></a></li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub"><a href="#" class="nk-menu-link nk-menu-toggle"><span
                                            class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span><span
                                            class="nk-menu-text">Transaction</span></a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item"><a href="deposit.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Recent Deposits</span></a></li>
                                        <li class="nk-menu-item"><a href="transaction.html" class="nk-menu-link"><span
                                                    class="nk-menu-text"> All Transaction</span></a></li>
                                        <li class="nk-menu-item"><a href="transfer-report.html"
                                                class="nk-menu-link"><span class="nk-menu-text">Transfer
                                                    Report</span></a></li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub"><a href="#" class="nk-menu-link nk-menu-toggle"><span
                                            class="nk-menu-icon"><em class="icon ni ni-task-fill-c"></em></span><span
                                            class="nk-menu-text">Task</span></a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item"><a href="running-task.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Running Task</span></a></li>
                                        <li class="nk-menu-item"><a href="archive-task.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Archived Task</span></a></li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub"><a href="#" class="nk-menu-link nk-menu-toggle"><span
                                            class="nk-menu-icon"><em class="icon ni ni-coin"></em></span><span
                                            class="nk-menu-text">Account</span></a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item"><a href="client-payment.html"
                                                class="nk-menu-link"><span class="nk-menu-text">Client
                                                    Payment</span></a></li>
                                        <li class="nk-menu-item"><a href="expense-management.html"
                                                class="nk-menu-link"><span class="nk-menu-text">Expense
                                                    Management</span></a></li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub"><a href="#" class="nk-menu-link nk-menu-toggle"><span
                                            class="nk-menu-icon"><em class="icon ni ni-truck"></em></span><span
                                            class="nk-menu-text">Product Management</span></a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item"><a href="products.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Products</span></a></li>
                                        <li class="nk-menu-item"><a href="warehouse.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Warehouse</span></a></li>
                                        <li class="nk-menu-item"><a href="product-transfer.html"
                                                class="nk-menu-link"><span class="nk-menu-text">Product
                                                    Transfer</span></a></li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub"><a href="#" class="nk-menu-link nk-menu-toggle"><span
                                            class="nk-menu-icon"><em class="icon ni ni-growth-fill"></em></span><span
                                            class="nk-menu-text">Report</span></a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item"><a href="dealing-info.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Dealing Info</span></a></li>
                                        <li class="nk-menu-item"><a href="client-report.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Client Report</span></a></li>
                                        <li class="nk-menu-item"><a href="expense-report.html"
                                                class="nk-menu-link"><span class="nk-menu-text">Expense
                                                    Report</span></a></li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item"><a href="employee.html" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-layers-fill"></em></span><span
                                            class="nk-menu-text">Employees</span></a></li>
                                <li class="nk-menu-item"><a href="projects.html" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em
                                                class="icon ni ni-list-index-fill"></em></span><span
                                            class="nk-menu-text">Projects</span></a></li>
                                <li class="nk-menu-item has-sub"><a href="#" class="nk-menu-link nk-menu-toggle"><span
                                            class="nk-menu-icon"><em class="icon ni ni-coins"></em></span><span
                                            class="nk-menu-text">Payroll</span></a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item"><a href="salary-grade.html" class="nk-menu-link"><span
                                                    class="nk-menu-text">Salary grade</span></a></li>
                                        <li class="nk-menu-item"><a href="employee-salary-list.html"
                                                class="nk-menu-link"><span class="nk-menu-text">Employee Salary
                                                    List</span></a></li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item"><a href="time-history.html" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em
                                                class="icon ni ni-calendar-check-fill"></em></span><span
                                            class="nk-menu-text">Attendance</span></a></li>
                                <li class="nk-menu-item"><a href="subscription.html" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-invest"></em></span><span
                                            class="nk-menu-text">Subscription</span></a></li>
                                <li class="nk-menu-item"><a href="notice-board.html" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-notice"></em></span><span
                                            class="nk-menu-text">Notice Board</span></a></li>
                                <li class="nk-menu-item"><a href="support.html" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em
                                                class="icon ni ni-chat-circle-fill"></em></span><span
                                            class="nk-menu-text">Support</span></a></li>
                                <li class="nk-menu-item"><a href="settings.html" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em
                                                class="icon ni ni-setting-alt-fill"></em></span><span
                                            class="nk-menu-text">Settings</span></a></li>
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Return to</h6>
                                </li>
                                <li class="nk-menu-item"><a href="../index.html" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-dashlite-alt"></em></span><span
                                            class="nk-menu-text">Main Dashboard</span></a></li>
                                <li class="nk-menu-item"><a href="../components.html" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-layers-fill"></em></span><span
                                            class="nk-menu-text">All Components</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-wrap ">
                <div class="nk-header nk-header-fixed">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1"><a href="#"
                                    class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em
                                        class="icon ni ni-menu"></em></a></div>
                            <div class="nk-header-brand d-xl-none"><a href="../index.html" class="logo-link"><img
                                        class="logo-light logo-img" src="../images/logo.png"
                                        srcset="/demo1/images/logo2x.png 2x" alt="logo"><img class="logo-dark logo-img"
                                        src="../images/logo-dark.png" srcset="/demo1/images/logo-dark2x.png 2x"
                                        alt="logo-dark"></a></div>
                            
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown language-dropdown d-none d-sm-block me-n1"><a href="#"
                                            class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div class="quick-icon border border-light"><img class="icon"
                                                    src="../images/flags/english-sq.png" alt=""></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-s1">
                                            <ul class="language-list">
                                                <li><a href="#" class="language-item"><img
                                                            src="../images/flags/english.png" alt=""
                                                            class="language-flag"><span
                                                            class="language-name">English</span></a></li>
                                                <li><a href="#" class="language-item"><img
                                                            src="../images/flags/spanish.png" alt=""
                                                            class="language-flag"><span
                                                            class="language-name">Español</span></a></li>
                                                <li><a href="#" class="language-item"><img
                                                            src="../images/flags/french.png" alt=""
                                                            class="language-flag"><span
                                                            class="language-name">Français</span></a></li>
                                                <li><a href="#" class="language-item"><img
                                                            src="../images/flags/turkey.png" alt=""
                                                            class="language-flag"><span
                                                            class="language-name">Türkçe</span></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="dropdown user-dropdown"><a href="#" class="dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm"><em class="icon ni ni-user-alt"></em></div>
                                                <div class="user-info d-none d-md-block">
                                                    <div class="user-status">Administrator</div>
                                                    <div class="user-name dropdown-indicator">Abu Bin Ishityak</div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar"><span>AB</span></div>
                                                    <div class="user-info"><span class="lead-text">Abu Bin
                                                            Ishtiyak</span><span
                                                            class="sub-text">info@softnio.com</span></div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="../user-profile-regular.html"><em
                                                                class="icon ni ni-user-alt"></em><span>View
                                                                Profile</span></a></li>
                                                    <li><a href="../user-profile-setting.html"><em
                                                                class="icon ni ni-setting-alt"></em><span>Account
                                                                Setting</span></a></li>
                                                    <li><a href="../user-profile-activity.html"><em
                                                                class="icon ni ni-activity-alt"></em><span>Login
                                                                Activity</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="#"><em class="icon ni ni-signout"></em><span>Sign
                                                                out</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown notification-dropdown me-n1"><a href="#"
                                            class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                                            <div class="dropdown-head"><span
                                                    class="sub-title nk-dropdown-title">Notifications</span><a
                                                    href="#">Mark All as Read</a></div>
                                            <div class="dropdown-body">
                                                <div class="nk-notification">
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon"><em
                                                                class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">You have requested to
                                                                <span>Widthdrawl</span></div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon"><em
                                                                class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">Your <span>Deposit
                                                                    Order</span> is placed</div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon"><em
                                                                class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">You have requested to
                                                                <span>Widthdrawl</span></div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon"><em
                                                                class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">Your <span>Deposit
                                                                    Order</span> is placed</div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon"><em
                                                                class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">You have requested to
                                                                <span>Widthdrawl</span></div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon"><em
                                                                class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">Your <span>Deposit
                                                                    Order</span> is placed</div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-foot center"><a href="#">View All</a></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-content ">
                    
                </div>
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; 2023 DashLite. Template by <a
                                    href="https://softnio.com/" target="_blank">Softnio</a></div>
                            <div class="nk-footer-links">
                                <ul class="nav nav-sm">
                                    <li class="nav-item dropup"><a href="#"
                                            class="dropdown-toggle dropdown-indicator has-indicator nav-link"
                                            data-bs-toggle="dropdown" data-offset="0,10"><span>English</span></a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                            <ul class="language-list">
                                                <li><a href="#" class="language-item"><span
                                                            class="language-name">English</span></a></li>
                                                <li><a href="#" class="language-item"><span
                                                            class="language-name">Español</span></a></li>
                                                <li><a href="#" class="language-item"><span
                                                            class="language-name">Français</span></a></li>
                                                <li><a href="#" class="language-item"><span
                                                            class="language-name">Türkçe</span></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item"><a data-bs-toggle="modal" href="#region" class="nav-link"><em
                                                class="icon ni ni-globe"></em><span class="ms-1">Select
                                                Region</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- wrap @s -->
        <!-- <div class="nk-wrap ">
             main header @s 
            <div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
                <div class="container-xl wide-xl">
                    <div class="nk-header-wrap">
                        <div class="nk-menu-trigger me-sm-2 d-lg-none">
                            <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
                        </div>
                        <div class="nk-header-brand">
                            <a href="<?=site_url(); ?>" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="<?=site_url(); ?>assets/logo-white.png" srcset="<?=site_url(); ?>assets/logo-white.png 2x" style="max-width:70%" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="<?=site_url(); ?>assets/logo-white.png" srcset="<?=site_url(); ?>assets/logo-white.png 2x" style="max-width:70%" alt="logo-dark">
                            </a>
                        </div>
                        <div class="nk-header-menu" data-content="headerNav">
                            <div class="nk-header-mobile">
                                <div class="nk-header-brand">
                                    <a href="<?=site_url(); ?>" class="logo-link">
                                        <img class="logo-light logo-img logo-img-lg" src="<?=site_url(); ?>assets/logo-white.png" srcset="<?=site_url(); ?>assets/logo-white.png 2x"  style="max-width:70%" alt="logo">
                                        <img class="logo-dark logo-img logo-img-lg" src="<?=site_url(); ?>assets/logo-white.png" srcset="<?=site_url(); ?>assets/logo-white.png 2x" style="max-width:70%"  alt="logo-dark">
                                    </a>
                                </div>
                                <div class="nk-menu-trigger me-n2">
                                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                                </div>
                            </div>
                            
                            
                            <ul class="nk-menu nk-menu-main mt-3">
                                <li class="nk-menu-item <?php if($page_active == 'dashboard'){echo 'active';} ?>">
                                    <a href="<?=site_url('dashboard'); ?>" class="nk-menu-link">
                                        <span class="nk-menu-text"><?=translate_phrase('Dashboard');?></span>
                                    </a>
                                </li>
                                <li class="nk-menu-item <?php if($page_active == 'payments/tax'){echo 'active';} ?>">
                                    <a href="<?=site_url('payments/tax'); ?>" class="nk-menu-link">
                                        <span class="nk-menu-text"><?=translate_phrase('Tax Invoices'); ?></span>
                                    </a>
                                </li>
                                <li class="nk-menu-item <?php if($page_active == 'payments/transaction'){echo 'active';} ?>">
                                    <a href="<?=site_url('payments/transaction'); ?>" class="nk-menu-link">
                                        <span class="nk-menu-text"><?=translate_phrase('Transactions'); ?></span>
                                    </a>
                                </li>
                                <?php
                                    if($log_role != 'personal' && $log_role != 'business'){?>
                                    <li class="nk-menu-item <?php if($page_active == 'tax_check'){echo 'active';} ?>">
                                        <a href="<?=site_url('dashboard/tax_check'); ?>" class="nk-menu-link">
                                            <span class="nk-menu-text"><?=translate_phrase('Tax Check');?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li class="nk-menu-item active has-sub">
                                    <a href="javascript:;" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">Menu</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <?php
                                            $menu = '';
                                            $modules = $this->Crud->read_single_order('parent', 0, 'access_module', 'priority', 'asc');
                                            if(!empty($modules)) {
                                                foreach($modules as $mod) {
                                                    if($mod->link == 'dashboard')continue;
                                                    if($mod->link == 'dashboard/tax_check' || $mod->link == 'payments/tax')continue;
                                                    // get level 2
                                                    $level2 = '';
                                                    if($this->Crud->mod_read($log_role_id, $mod->link) == 1) {
                                                        $mod_level2 = $this->Crud->read_single_order('parent', $mod->id, 'access_module', 'priority', 'asc');
                                                        if(!empty($mod_level2)) {
                                                            $open = false;
                                                            foreach($mod_level2 as $mod2) {
                                                                if($this->Crud->mod_read($log_role_id, $mod2->link) == 1) {
                                                                    // add parent to first
                                                                    if(empty($level2)) {
                                                                        // $level2 = '
                                                                        //     <li>
                                                                        //         <a href="'.site_url($mod->link).'">'.$mod->name.'</a>
                                                                        //     </li>
                                                                        // ';
                                                                    }
                                                                    if($page_active == $mod2->link){$open = true; $a_active = 'active';} else {$a_active = '';}
                                                                    
                                                                    // add the rest
                                                                    $level2 .= '
                                                                        <li class="nk-menu-item '.$a_active.'">
                                                                            <a href="'.site_url($mod2->link).'" class="nk-menu-link">'.translate_phrase($mod2->name).'</a>
                                                                        </li>
                                                                    '; 
                                                                }
                                                            }
                                                            
                                                            $level2 = '
                                                                <ul class="nk-menu-sub">
                                                                    '.$level2.'
                                                                </ul>
                                                            ';
                                                        }

                                                        if($page_active == $mod->link){$a_active = 'active';} else {$a_active = '';}
                                                        if($level2){
                                                            $topmenu = 'has-sub';
                                                            $submenu = 'nk-menu-toggle';
                                                            $dlink = 'javascript:;';
                                                            $menu_arrow = '<span class="arrow"><i class="arrow-icon"></i></span>';
                                                        } else {
                                                            $topmenu = '';
                                                            $submenu = ''; 
                                                            $dlink = site_url($mod->link);
                                                            $menu_arrow = '';
                                                        }

                                                        $menu .= '
                                                            <li class="nk-menu-item '.$topmenu .' '.$a_active.'">
                                                                <a class="nk-menu-link '.$submenu.'" href="'.$dlink.'">
                                                                    <span class="nk-menu-icon">
                                                                        <em class="'.$mod->icon.'"></em>
                                                                    </span>
                                                                    <span class="nk-menu-text">'.translate_phrase($mod->name).'</span>
                                                                    '.$menu_arrow.'
                                                                </a>
                                                                '.$level2.'
                                                            </li>
                                                        ';
                                                    }
                                                }
                                            }

                                            echo $menu;
                                        ?>
                                         <!-- Modules and log_roles -->
                                        <?php if($log_role == 'developer' || $log_role == 'administrator') { ?>
                                        <li class="nk-menu-item has-sub">
                                            <a class="nk-menu-link nk-menu-toggle" href="javascript:;">
                                                <span class="nk-menu-icon"><em
                                                        class="icon ni ni-setting-alt-fill"></em></span>
                                                <span class="nk-menu-text"><?=translate_phrase('Access Roles');?></span>
                                            </a>
                                            <ul class="nk-menu-sub mb-5">
                                                <li class="nk-menu-item <?php if($page_active=='language') {echo 'active';} ?>">
                                                    <a href="<?php echo site_url('settings/language'); ?>"
                                                        class="nk-menu-link"><?=translate_phrase('Language Settings'); ?></a>
                                                </li>
                                                <?php if($log_role == 'developer'){?>
                                                    <li
                                                        class="nk-menu-item <?php if($page_active=='module') {echo 'active';} ?>">
                                                        <a href="<?php echo site_url('settings/modules'); ?>"
                                                            class="nk-menu-link"><?=translate_phrase('Modules'); ?></a>
                                                    </li>
                                                    <li class="nk-menu-item <?php if($page_active=='role') {echo 'active';} ?>">
                                                        <a href="<?php echo site_url('settings/roles'); ?>"
                                                            class="nk-menu-link"><?=translate_phrase('Roles'); ?></a>
                                                    </li>
                                                    <li
                                                        class="nk-menu-item <?php if($page_active=='access') {echo 'active';} ?>">
                                                        <a href="<?php echo site_url('settings/access'); ?>"
                                                            class="nk-menu-link"><?=translate_phrase('Access CRUD'); ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="nk-header-tools">
                            <ul class="nk-quick-nav">
                                <li class="dropdown notification-dropdown me-n1">
                                    <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                        <?php 
                                            $sta = '';
                                            if($this->Crud->check2('to_id', $log_id, 'new', '1', 'notify') > 0){
                                                $sta = 'icon-status-info';
                                            }
                                        
                                        ?>
                                        <div class="icon-status <?=$sta; ?>"><em class="icon ni ni-bell"></em></div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                                        <div class="dropdown-head">
                                            <span class="sub-title nk-dropdown-title"><?=translate_phrase('Notifications'); ?></span>
                                        </div>
                                        <div class="dropdown-body">
                                            <div class="nk-notification">
                                                <?php 
                                                    $notify = $this->Crud->read2('to_id', $log_id, 'new', 1, 'notify');
                                                    if(!empty($notify)){
                                                        
                                                        $a = 0;
                                                        foreach($notify as $n){
                                                            if($a>5) continue;
                                                            $pos = 'left';
                                                            $code = 'success';

                                                            if($n->item == 'withdraw' || $n->item == 'transact'){
                                                                $pos = 'right';
                                                                $code = 'danger';
                                                            }
                                                        
                                                ?><a href="javascript:;" onclick="mark_read(<?=$n->id; ?>)">
                                                    <div class="nk-notification-item dropdown-inner">

                                                        <div class="nk-notification-icon">
                                                            <em
                                                                class="icon icon-circle bg-<?=$code; ?>-dim ni ni-curve-down-<?=$pos; ?>"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">
                                                                <?=(ucwords($n->content)); ?></div>
                                                            <div class="nk-notification-time">
                                                                <?=$this->Crud->timespan(strtotime($n->reg_date));; ?>
                                                            </div>
                                                        </div>

                                                    </div><!-- .dropdown-inner -->
                                                </a>
                                                <?php 
                                                    $a++;
                                                    }

                                                } else {
                                                    echo '<div class="text-center">'.translate_phrase('No Notification').'</div>';
                                                }
                                                ?>
                                            </div>
                                        </div><!-- .nk-dropdown-body -->
                                        <div class="dropdown-foot center">
                                            <a href="<?=site_url('notification/list'); ?>"><?=translate_phrase('View All'); ?></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown language-dropdown d-sm-block me-n1">
                                    <a href="javascript:;" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                        <div class="quick-icon border border-light">
                                            <?php
                                                $flags = $current_language;
                                                // echo $flags;
                                                if($current_language == 'Hausa' || $current_language == 'Igbo' || $current_language == 'Yoruba')$flags = 'Nigerian';

                                            ?>
                                            <img class="icon" src="<?=site_url(); ?>assets/images/flags/<?=strtolower($flags); ?>.png" alt="">
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-s1">
                                        <ul class="language-list">
                                        <?php
                                            $lang = $this->Crud->read_single_order('status', 1,'language_code', 'name', 'asc');
                                            if(!empty($lang)){
                                                foreach($lang as $l){
                                                    $l_name = $l->name;
                                                    if($l->name == 'Hausa' || $l->name == 'Igbo' || $l->name == 'Yoruba')$l_name = 'Nigerian';
                                            
                                        ?>
                                            <li>
                                                <a href="javascript:;" onclick="lang_session(<?=$l->id; ?>)" class="language-item">
                                                    <img src="<?=site_url(); ?>assets/images/flags/<?=strtolower($l_name); ?>.png" alt="" class="language-flag">
                                                    <span class="language-name"><?=$l->name; ?></span>
                                                </a>
                                            </li>
                                            <?php

                                                }
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </li><!-- .dropdown -->
                                <li class="hide-mb-sm"><a href="<?=site_url('logout'); ?>" class="nk-quick-nav-icon"><em class="icon ni ni-signout"></em></a></li>
                                <li class="dropdown user-dropdown order-sm-first">
                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                        <div class="user-toggle">
                                            <div class="user-avatar sm">
                                                <em class="icon ni ni-user-alt"></em>
                                            </div>
                                            <div class="user-info d-none d-xl-block">
                                                <div class="user-status text-white user-status-unverified"><?=strtoupper($log_role); ?></div>
                                                <div class="user-name dropdown-indicator"><?=ucwords($username); ?></div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1 is-light">
                                        <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                            <div class="user-card">
                                                <div class="user-avatar">
                                                    <span>AB</span>
                                                </div>
                                                <div class="user-info">
                                                    <span class="lead-text"><?=ucwords($username); ?></span>
                                                    <span class="sub-text"><?=ucwords($email); ?></span>
                                                </div>
                                                <div class="user-action">
                                                    <a class="btn btn-icon me-n2" href="<?=site_url('profile'); ?>"><em class="icon ni ni-setting"></em></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li><a href="<?=site_url('profile'); ?>"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                                <li><a href="<?=site_url('activity'); ?>"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li>
                                            </ul>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li><a href="<?=site_url('auth/logout'); ?>"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li><!-- .dropdown -->
                            </ul><!-- .nk-quick-nav -->
                        </div><!-- .nk-header-tools -->
                    </div><!-- .nk-header-wrap -->
                </div><!-- .container-fliud -->
            </div>
            
            <?=$this->renderSection('content');?>

            <!-- content @e -->
            <div class="nk-footer nk-footer-fluid bg-lighter">
                <div class="container-xl wide-lg">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright">&copy;<?=date('Y'); ?> <?=app_name;?>. <?=translate_phrase('All Rights Reserved.'); ?>
                        </div>
                        <div class="nk-footer-links">
                            <ul class="nav nav-sm">
                                <li class="nav-item dropup">
                                    <a class="dropdown-toggle dropdown-indicator has-indicator nav-link" data-bs-toggle="dropdown" data-offset="0,10"><small><?=$current_language; ?></small></a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                        <ul class="language-list">
                                            <?php
                                                $lang = $this->Crud->read_single_order('status', 1,'language_code', 'name', 'asc');
                                                if(!empty($lang)){
                                                    foreach($lang as $l){
                                                        $l_name = $l->name;
                                                        if($l->name == 'Hausa' || $l->name == 'Igbo' || $l->name == 'Yoruba')$l_name = 'Nigerian';
                                                
                                            ?>
                                            <li>
                                                <a href="javascript:;" onclick="lang_session(<?=$l->id; ?>)" class="language-item">
                                                    <img src="<?=site_url(); ?>assets/images/flags/<?=strtolower($l_name); ?>.png" alt="" class="language-flag">
                                                    <span class="language-name"><?=$l->name; ?></span>
                                                </a>
                                            </li>

                                            <?php
                                                }
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="bb_ajax_msgs"></div>
                
            <!-- wrap @e -->
        </div> -->
        <!-- wrap @e -->
    </div>
    <div class="modal modal-center fade" tabindex="-1" id="modal" role="dialog" data-keyboard="false"
        data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="javascript:;" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                <div class="modal-header">
                    <h6 class="modal-title"></h6>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
                                                
    <div id="output"></div>
</body>


    <script src="<?=site_url(); ?>assets/js/bundle.js?ver=3.2.3"></script>
    <script src="<?=site_url(); ?>assets/js/scripts.js?ver=3.2.3"></script>
    <script src="<?=site_url(); ?>assets/js/demo-settingse5ca.js?ver=3.2.3"></script>
    <script src="<?=site_url(); ?>assets/js/charts/chart-crme5ca.js?ver=3.2.3"></script>
   
    <script>
         var site_url = '<?=site_url(); ?>';
        function lang_session(lang_id){
            if(lang_id !== ''){
                $.ajax({
                    url: site_url + 'auth/language/' + lang_id,
                    success: function (data) {
                        $('#bb_ajax_msgs').html(data);                   
                    }
                });
            }
        }
    
    </script>
    <script src="<?php echo site_url(); ?>assets/js/apps/messages.js?ver=3.1.2"></script>
    <?=$this->renderSection('scripts');?>
    <script>
    function mark_read(id) {
        $.ajax({
            url: site_url + 'notification/mark_read/' + id,
            type: 'post',
            success: function(data) {
                window.location.replace("<?=site_url('notification/list'); ?>");

            }
        });
    }
    
    </script>
    <?php 
            $notify = $this->Crud->read2('to_id', $log_id, 'new', 1, 'notify');
            if(!empty($notify)){?>
    <script>
    $(function() {
        plays();
    });
    </script>
    <?php }
        
        ?>
    <script>
    function plays() {
        var src = '<?=site_url(); ?>' + 'assets/audio/2.wav';
        var audio = new Audio(src);
        audio.play();
    }
    
    </script>
    <?php if(!empty($table_rec)){ ?>
    <!-- <script src="<?=site_url();?>assets/backend/vendors/datatables/jquery.dataTables.min.js"></script>
        <script src="<?=site_url();?>assets/backend/vendors/datatables/dataTables.bootstrap.min.js"></script>
        <script src="<?=site_url();?>assets/backend/js/pages/datatables.js"></script> -->
    <script type="text/javascript">
    $(document).ready(function() {
        //datatables
        var table = $('#dtable').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [<?php if(!empty($order_sort)){echo '['.$order_sort.']';} ?>], //Initial order.
            "language": {
                "processing": "<i class='anticon anticon-loading' aria-hidden='true'></i> <?=translate_phrase('Processing... please wait'); ?>"
            },
            // "pagingType": "full",

            // Load data for the table's content from an Ajax source
            "ajax": {
                url: "<?php echo site_url($table_rec); ?>",
                type: "POST",
                complete: function() {
                    $.getScript('<?php echo site_url(); ?>assets/js/jsmodal.js');
                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [
                <?php if(!empty($no_sort)){echo $no_sort;} ?>], //columns not sortable
                "orderable": false, //set not orderable
            }, ],

        });

    });
    </script>
    <?php } ?>


    <script>
        function saveDivAsPDF() {
            console.log('test');
            $('#card_response').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                        // Get the div element
            var divToCapture = document.getElementById('qrcode');
            html2canvas(divToCapture, { scale: 8 }).then(function (canvas) {
                var imgData = canvas.toDataURL('image/png', 3.0); // Set quality to 1.0 (max quality) for JPEG
                    // Open the image in a new browser window for printing
                var imgWindow = window.open();
                
                // Set the width of the image to match the page width
                imgWindow.document.write('<img src="' + imgData + '" style="width: 100%; image-rendering: crisp-edges;" />');
                imgWindow.document.close();

                // Trigger the print dialog
                imgWindow.print();
                $('#card_response').html('<div class="col-sm-12 text-center">Printing..</div>');
            });
        }
        function qrcodes() {
            console.log('test');
            $('#qr_response').html('<div class="col-sm-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            
                        // Get the div element
            var divToCapture = document.getElementById('qrcodes');
            html2canvas(divToCapture, {
                useCORS: true,  // Enable cross-origin resource sharing for stylesheets
                scale: 10       // Set the scale for higher quality (adjust as needed)
            }).then(function(canvas) {
                // Convert the canvas content to a data URI in PNG format
                var data = canvas.toDataURL('image/png');

                // Create an image element
                var img = document.createElement('img');
                img.src = data;

                // Append the image to the document (you can replace 'output' with the ID of the container where you want to display the image)
                // document.getElementById('output').appendChild(img);

                // Create a link element
                var link = document.createElement('a');
                link.href = data;
                link.download = 'my_qr.png';
                
                $('#qr_response').html('<div class="col-sm-12 text-center">Printing</div>');
                // Append the image to the document (you can replace 'output' with the ID of the container where you want to display the image)
                // document.getElementById('output').appendChild(img);

                // Create a link element for downloading
                var link = document.createElement('a');
                link.href = data;
                link.download = 'qrcode.png';

                // Trigger a click event on the link to initiate the download
                // link.click();
                var pdf = new window.jspdf.jsPDF(); // Use window.jspdf.jsPDF to avoid "jsPDF is not defined" error
                pdf.addImage(data, 'PNG', 10, 10, 190, 100); // Adjust the position and size as needed

                // Save the PDF or display it
                pdf.save('qrcode.pdf');
                
                
                $('#qr_response').html('');
            });
        }

    </script>

</html>