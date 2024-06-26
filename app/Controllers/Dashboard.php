<?php

namespace App\Controllers;

class Dashboard extends BaseController {

 
    public function index($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('td_id');
       if(empty($log_id)) return redirect()->to(site_url('auth'));

    
       $mod = 'dashboard';
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, $mod, 'create');
        $role_r = $this->Crud->module($role_id, $mod, 'read');
        $role_u = $this->Crud->module($role_id, $mod, 'update');
        $role_d = $this->Crud->module($role_id, $mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('profile'));	
        }
        $username = $this->Crud->read_field('id', $log_id, 'user', 'firstname').' '.$this->Crud->read_field('id', $log_id, 'user', 'surname');
        
        $data['log_id'] = $log_id;
        $data['param1'] = $param1;
        $data['param2'] = $param2;
        $data['param3'] = $param3;


        
		// record listing
		if($param1 == 'activity_load') {
			$limit = $param2;
			$offset = $param3;

			$count = 0;
			$rec_limit = 7;
			$item = '';
            $timer_item = '';

			if($limit == '') {$limit = $rec_limit;}
			if($offset == '') {$offset = 0;}
			
			$search = $this->request->getVar('search');
			if(!empty($this->request->getPost('start_date'))) { $start_date = $this->request->getPost('start_date'); } else { $start_date = ''; }
			if(!empty($this->request->getPost('end_date'))) { $end_date = $this->request->getPost('end_date'); } else { $end_date = ''; }
			
			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				$all_rec = $this->Crud->filter_activity('', '', $log_id, $search);
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }

				$query = $this->Crud->filter_activity($limit, $offset, $log_id, $search);
				$data['count'] = $counts;
				
				if (!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$type = $q->item;
						$type_id = $q->item_id;
						$action = $q->action;
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

						$timespan = $this->Crud->timespan(strtotime($q->reg_date));

						$icon = 'article';
						if($type == 'orders') $icon = 'template';
						if($type == 'branch') $icon = 'reports-alt';
						if($type == 'business') $icon = 'briefcase';
						if($type == 'order') $icon = 'bag';
						if($type == 'user') $icon = 'users';
						if($type == 'pump') $icon = 'cc-secure';
						if($type == 'authentication') $icon = 'article';
						if($type == 'enrolment') $icon = 'property-add';
						if($type == 'scholarship') $icon = 'award';

						$item .= '
                            <li class="nk-activity-item">
                                <div class="nk-activity-media user-avatar bg-success"><img
                                        src="'.site_url().'assets/images/avatar.png" alt=""></div>
                                <div class="nk-activity-data">
                                    <div class="label lead-text"> '.translate_phrase($action).'</div>
                                    <span class="time">'.$timespan.'</span>
                                </div>
                            </li>    
						';
					}
				}

                //timer Records
                $timer_data = [];
                $service_query = $this->Crud->read_order('service_report', 'id', 'desc');
				
				if (!empty($service_query)) {
					foreach($service_query as $q) {
						$datas['type'] = 'service';
						$datas['id'] = $q->id;
						$datas['date'] = $q->date;
						$datas['timers'] = $q->timers;

                        $timer_data[] = $datas;

                    }
                }
                $cell_query = $this->Crud->read_order('cell_report', 'id', 'desc');
				
				if (!empty($cell_query)) {
					foreach($cell_query as $q) {
						$datas['type'] = 'cell';
						$datas['id'] = $q->id;
						$datas['date'] = $q->date;
						$datas['timers'] = $q->timers;
                        $timer_data[] = $datas;
                    }
                }

                // Sort array by 'date' in descending order
                usort($timer_data, function($a, $b) {
                    return strtotime($b['date']) - strtotime($a['date']);
                });

                // print_r($timer_data);
                if(!empty($timer_data)){
                    foreach($timer_data as $td){
                        if(empty($td['timers']))continue;
                        $timer = $td['timers'];
                        $date = date('d F Y', strtotime($td['date']));
                        if(!empty($timer)){
                            $timer = json_decode($timer);
                            if(is_array($timer) && !empty($timer)){
                               
                                foreach($timer as $val){
                                    $time = (array)$val;
                                    
                                    foreach($time as $t=> $vals){
                                        if($t == 'fullname'){
                                            $timer_item .= '
                                                <div class="card-inner card-inner-md">
                                                    <div class="user-card">
                                                        
                                                        <div class="user-info"><span class="lead-text">'.ucwords($vals).'</span>
                                                        <span class="sub-text text-info">'.strtoupper($td['type']).'</span></div>
                                                        <div class="user-action">
                                                            <span class="sub-text">'.$date.'</span>
                                                        </div>
                                                    </div>
                                                </div>  
                                            ';
                                        }
                                    }
                                }
                            }
                        }
					}
				}
				
			}
			if(empty($item)) {
				$resp['item'] = '
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<em class="icon ni ni-property" style="font-size:150px;"></em><br/><br/>'.translate_phrase('No Activity Returned').'
					</div>
				';
			} else {
				$resp['item'] = $item;
			}

            if(empty($timer_item)) {
				$resp['timer_item'] = '
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<em class="icon ni ni-users" style="font-size:150px;"></em><br/><br/>'.translate_phrase('No First Timer Returned').'
					</div>
				';
			} else {
				$resp['timer_item'] = $timer_item;
			}

			$resp['count'] = $counts;

			$more_record = $counts - ($offset + $rec_limit);
			$resp['left'] = $more_record;

			if($counts > ($offset + $rec_limit)) { // for load more records
				$resp['limit'] = $rec_limit;
				$resp['offset'] = $offset + $limit;
			} else {
				$resp['limit'] = 0;
				$resp['offset'] = 0;
			}

			echo json_encode($resp);
			die;
		}


        $data['log_id'] = $log_id;
        $data['log_name'] = $username;
        $data['current_language'] = $this->session->get('current_language');
        $data['role'] = $role;
        $data['role_c'] = $role_c;
        $data['title'] = translate_phrase('Dashboard').' - '.app_name;
        $data['page_active'] = $mod;
        return view('dashboard', $data);
    }
    
    

    ///// LOGIN
    public function land() {
        $log_id = 1;
        $data['log_id'] = 1;
        $data['current_language'] = $this->session->get('current_language');
        $data['page_active'] = 'Welcome | '.app_name;
        $data['title'] = 'Welcome | '.app_name;
        return view('land', $data);
    }


    public function email_test() {
        $api_key = $this->Crud->read_field('name', 'termil_api', 'setting', 'value'); // pick from DB
		$email_template = $this->Crud->read_field('name', 'termil_email_template', 'setting', 'value'); // pick from DB
        $email = 'tofunmi015@gmail.com';

        // echo $this->Crud->send_email($email, 'Test', 'Testing', $bcc='');
        // send email
    		if($email) {
    			$dataa['email_address'] = $email;
    			$dataa['code'] = '1546';
    			$dataa['api_key'] = $api_key;
    			$dataa['email_configuration_id'] = $email_template;
    			// $this->Crud->termii('post', 'email/otp/send', $dataa);
    		}
            
            
            $phone = '09068308070';
            $api_key = $this->Crud->read_field('name', 'termil_api', 'setting', 'value'); // pick from DB
						
            if($phone) {
                $phone = '234'.substr($phone,1);echo $phone;
                $datass['to'] = $phone;
                $datass['from'] = 'N-Alert';
                $datass['sms'] = 'Testing Message';
                $datass['api_key'] = $api_key;
                $datass['type'] = 'plain';
                $datass['channel'] = 'dnd';
              echo  $this->Crud->termii('post', 'sms/send', $datass);
            }
    
    }

    public function lang_code(){
        $language = file_get_contents(base_url('assets/js/language.js'));
        $language = json_decode($language);
        // print_r($language);
        $ct = 1;
        foreach($language->data->languages as $lang) {
            $langName = $lang->name;
            $langCode = $lang->language;
            
            $langs['name'] = $langName;
            $langs['code'] = $langCode;
            
            $this->Crud->create('language_code', $langs);
            // if($text == strtolower($langName)) {
            //     $result = $langCode;
            //     break; // stop the loop, one code is retrieved 
            // }
            $ct += 1;
        }


    }

    public function metric(){
        $log_id = $this->session->get('td_id');
        
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));

        $tithe = 0;
        $tithe_part = 0;
        $partnership = 0;
        $partnership_part = 0;
        $offering = 0;
        $partnership_list = '';
        $cell_data = '';
        $date_type = $this->request->getPost('date_type');
		$date_type = $this->request->getPost('date_type');
		if(!empty($this->request->getPost('start_date'))) { $start_dates = $this->request->getPost('start_date'); } else { $start_dates = ''; }
		if(!empty($this->request->getPost('end_date'))) { $end_dates = $this->request->getPost('end_date'); } else { $end_dates = ''; }
		if($date_type == 'Today'){
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d');
		} elseif($date_type == 'Yesterday'){
			$start_date = date('Y-m-d', strtotime( '-1 days' ));
			$end_date = date('Y-m-d', strtotime( '-1 days' ));
		} elseif($date_type == 'Last_Week'){
			$start_date = date('Y-m-d', strtotime( '-7 days' ));
			$end_date = date('Y-m-d');
		} elseif($date_type == 'Last_Month'){
			$start_date = date('Y-m-d', strtotime( '-30 days' ));
			$end_date = date('Y-m-d');
		} elseif($date_type == 'Date_Range'){
			$start_date = $start_dates;
			$end_date = $end_dates;
		} elseif($date_type == 'This_Year'){
			$start_date = date('Y-01-01');
			$end_date = date('Y-m-d');
		} else {
			$start_date = date('Y-m-01');
			$end_date = date('Y-m-d');
		}
        
        if($role == 'developer' || $role == 'administrator'){
            $partners = $this->Crud->date_range1($start_date, 'reg_date', $end_date, 'reg_date', 'status', 1, 'partners_history');
            $cells = $this->Crud->read('cells');
             $service_report = $this->Crud->date_range($start_date, 'date', $end_date, 'date', 'service_report');
            
             $partnership = 0;
            if(!empty($partners)){
                foreach($partners as $u){
                    $partnership += (float)$u->amount_paid;
                }
                $partnership_part = count($partners);
            }

            if(!empty($cells)){
                $cell_data .= '
                        <div class="nk-tb-item nk-tb-head">
                        <div class="nk-tb-col nk-tb-channel"><span>Cell</span></div>
                        <div class="nk-tb-col nk-tb-channel"><span>Date</span></div>
                            <div class="nk-tb-col nk-tb-sessions"><span>ATT</span>
                            </div>
                            <div class="nk-tb-col nk-tb-prev-sessions"><span>N.C</span></div>
                            <div class="nk-tb-col nk-tb-change"><span>F.T</span></div>
                            
                        </div>
                ';
                foreach($cells as $u){
                    $cell_report = $this->Crud->read_single_order('cell_id', $u->id, 'cell_report', 'id', 'asc');
                    $date = '-';
                    $attendance = 0;$attends = 0;
                    $new_convert = 0;$converts = 0;
                    $first_timer = 0;$timers = 0;
                    $ca = count($cell_report);$ca--;
                    $i = 1;

                    $attend_stat = ''; $convert_stat = ''; $timer_stat = '';
                    if(!empty($cell_report)){
                        foreach($cell_report as $cs){
                            if($i == $ca){
                                $attendances = $cs->attendance;
                                $new_converts = $cs->new_convert;
                                $first_timers = $cs->first_timer;
                            }

                            $i++;
                        }
                        
                        $date = $cs->date;
                        $attendance = $cs->attendance;
                        $new_convert = $cs->new_convert;
                        $first_timer = $cs->first_timer;
                        $date = date('d F Y', strtotime($date));

                        if(count($cell_report) >=2){
                            if($attendances > 0){
                                $attend = ((int)$attendance - (int)$attendances)/(int)$attendances;
                                $attends = $attend * 100;
                                if($attends > 0){
                                    $attend_stat = '<span class="change up"><em class="icon ni ni-arrow-long-up"></em></span>';
                                } else {
                                    $attend_stat = '<span class="change down"><em class="icon ni ni-arrow-long-down"></em></span>';
                                }
                            }

                            if($new_converts > 0){
                                $convert = ((int)$new_convert - (int)$new_converts)/(int)$new_converts;
                                $converts = $convert * 100;
                                if($converts > 0){
                                    $convert_stat = '<span class="change up"><em class="icon ni ni-arrow-long-up"></em></span>';
                                } else {
                                    $convert_stat = '<span class="change down"><em class="icon ni ni-arrow-long-down"></em></span>';
                                }
                            }

                            if($first_timers > 0){
                                $timer = ((int)$first_timer - (int)$first_timers)/(int)$first_timers;
                                $timers = $timer * 100;
                                if($timers > 0){
                                    $timer_stat = '<span class="change up"><em class="icon ni ni-arrow-long-up"></em></span>';
                                } else {
                                    $timer_stat = '<span class="change down"><em class="icon ni ni-arrow-long-down"></em></span>';
                                }
                            }
                        }

                    }
                    
                    $cell_data .= '
                        
                            <div class="nk-tb-item">
                                <div class="nk-tb-col nk-tb-channel"><span class="tb-lead">'.ucwords($u->name).'</span></div>
                                <div class="nk-tb-col nk-tb-channel"><span class="tb-lead">'.$date.'</span></div>
                                <div class="nk-tb-col nk-tb-sessions"><span class="tb-sub tb-amount"><span>'.number_format((int)$attendance).'</span>'.$attend_stat.'</span></div>
                                <div class="nk-tb-col nk-tb-prev-sessions"><span class="tb-sub tb-amount"><span>'.number_format((int)$new_convert).'</span>'.$convert_stat.'</span></div>
                                <div class="nk-tb-col nk-tb-change"><span class="tb-sub"><span>'.number_format((int)$first_timer).'</span>'.$timer_stat.'</span>
                                </div>
                                
                            </div>
                    ';

                }
            } else {
                $cell_data .= '<div class="text-center text-muted">
                <br/><br/><br/><br/>
                <em class="icon ni ni-property" style="font-size:150px;"></em><br/><br/>'.translate_phrase('No Cell Report Returned').'
            </div>';
            }

            if(!empty($service_report)){
                foreach($service_report as $u){
                    $offering += (float)$u->offering;
                    $tithe += (float)$u->tithe;
                    $convertsa = json_decode($u->tithers);
					$converts =(array) $convertsa->list;
					$tithe_part += count($converts);	
                }
            }

            $parts = $this->Crud->read('partnership');
            if(!empty($parts)){
                $col = array('success', 'primary', 'danger', 'info', 'warning', 'azure', 'gray','blue', 'indigo', 'orange', 'teal', 'purple');
                
                foreach($parts as $p){
                    $paid = 0;
                    $partners = $this->Crud->date_range2($start_date, 'reg_date', $end_date, 'reg_date', 'status', 1, 'partnership_id', $p->id, 'partners_history');
                    if(!empty($partners)){
                        foreach($partners as $u){
                            $paid += (float)$u->amount_paid;
                        }
                       
                    }
                    
                    
                    if($partnership > 0){
                        $paids = ((float)$paid * 100)/(float)$partnership;
                    } else {
                        $paids = 0;
                    }
                    // Select a random key
                    $random_key = array_rand($col);

                    // Get the value at the random key
                    $cols = $col[$random_key];


                    
                    $partnership_list .= '
                        <div class="progress-wrap">
                            <div class="progress-text">
                                <div class="progress-label">'.ucwords($p->name).' <b>($'.number_format($paid,2).')</b></div>
                                <div class="progress-amount">'.number_format($paids,1).'%</div>
                            </div>
                            <div class="progress ">
                                <div class="progress-bar bg-'.$cols.' progress-bar-striped progress-bar-animated" data-progress="'.$paids.'"></div>
                            </div>
                        </div>
                    ';
                    // Remove the element from the array
                    unset($col[$random_key]);

                    // Re-index the array if needed
                    $col = array_values($col);
                }
            }
           
        }
        // print_r($service_report);
        // echo $offering.' e';

        if($role != 'developer' && $role != 'administrator'){
            $trade_id = $this->Crud->read_field('id', $log_id, 'user', 'trade');
            $duration = $this->Crud->read_field('id', $log_id, 'user', 'duration');
            if(!empty($trade_id)){
                $remittance = $this->Crud->read_field('id', $trade_id, 'trade', 'medium');
                $paids = $this->Crud->read_single('user_id', $log_id, 'history');
                if(!empty($paids)){
                    foreach($paids as $p){
                        $total_paid  += (float)$p->amount;
                    }
                }
                
            }
        }

       
        $resp['tithe'] = '$'.number_format($tithe,2);
        $resp['tithe_part'] = number_format($tithe_part);
        $resp['offering'] = '$'.number_format($offering,2);
        $resp['partnership'] = '$'.number_format($partnership,2);
        $resp['partnership_part'] = number_format($partnership_part);
        $resp['partnership_list'] = ($partnership_list);
        $resp['cell_data'] = ($cell_data);

        
        echo json_encode($resp);
        die;
    }

    public function service_metric(){
        $log_id = $this->session->get('td_id');
        
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));

        $service_date = '';
        $service_key = '';
      
        
        $date_type = $this->request->getPost('date_type');
		$date_type = $this->request->getPost('date_type');
		if(!empty($this->request->getPost('start_date'))) { $start_dates = $this->request->getPost('start_date'); } else { $start_dates = ''; }
		if(!empty($this->request->getPost('end_date'))) { $end_dates = $this->request->getPost('end_date'); } else { $end_dates = ''; }
		if($date_type == 'Today'){
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d');
		} elseif($date_type == 'Yesterday'){
			$start_date = date('Y-m-d', strtotime( '-1 days' ));
			$end_date = date('Y-m-d', strtotime( '-1 days' ));
		} elseif($date_type == 'Last_Week'){
			$start_date = date('Y-m-d', strtotime( '-7 days' ));
			$end_date = date('Y-m-d');
		} elseif($date_type == 'Last_Month'){
			$start_date = date('Y-m-d', strtotime( '-30 days' ));
			$end_date = date('Y-m-d');
		} elseif($date_type == 'Date_Range'){
			$start_date = $start_dates;
			$end_date = $end_dates;
		} elseif($date_type == 'This_Year'){
			$start_date = date('Y-01-01');
			$end_date = date('Y-m-d');
		} else {
			$start_date = date('Y-m-01');
			$end_date = date('Y-m-d');
		}
        
        $male = 0;$female = 0;$children=0;$ft=0;$nc=0;
        $male_per = 0;$female_per = 0;$children_per=0;$ft_per=0;$nc_per=0;
        if($role == 'developer' || $role == 'administrator'){
            $service = $this->Crud->read_order('service_report','id', 'asc');
            
            if(!empty($service)){
                foreach($service as $u){
                   
                }
                $type = $this->Crud->read_field('id', $u->type, 'service_type', 'name');
                $service_date = $type.' - '.date('d F Y', strtotime($u->date));
                $attend = $u->attendance;
                $attendance = $u->attendant;
                $attendant = json_decode($attendance);
                $attendant = (array)$attendant;

                // echo $attendant['male'];
                $male = $attendant['male'];
                $female = $attendant['female'];
                $children = $attendant['children'];
                
                $ft = $u->first_timer;

                $male_per = ((int)$male * 100)/(int)$attend;
                $female_per = ((int)$female * 100)/(int)$attend;
                $children_per = ((int)$children * 100)/(int)$attend;
                $ft_per = ((int)$ft * 100)/(int)$attend;

                // $female = 110;$children = 11;
            }
           
            $service_key .= '
            <div class="traffic-channel-data">
                <div class="title"><span class="dot dot-lg sq bg-info" data-bg="#ffa353"></span><span>Male</span></div>
                <div class="amount">'.number_format($male).' <small>'.number_format($male_per,2).'%</small></div>
            </div>
            <div class="traffic-channel-data">
                <div class="title"><span class="dot dot-lg sq  bg-teal" data-bg="#ffa353"></span><span>Female</span></div>
                <div class="amount">'.number_format($female).' <small>'.number_format($female_per,2).'%</small></div>
            </div>
            <div class="traffic-channel-data">
                <div class="title"><span class="dot dot-lg sq  bg-warning" data-bg="#ffa353"></span><span>Children</span></div>
                <div class="amount">'.number_format($children).' <small>'.number_format($children_per,2).'%</small></div>
            </div>
            <div class="traffic-channel-data">
                <div class="title"><span class="dot dot-lg sq  bg-danger" data-bg="#ffa353"></span><span>First Timer</span></div>
                <div class="amount">'.number_format($ft).' <small>'.number_format($ft_per,2).'%</small></div>
            </div>
           

            ';
           
        }
        // print_r($service);
        // echo $offering.' e';

        if($role != 'developer' && $role != 'administrator'){
            $trade_id = $this->Crud->read_field('id', $log_id, 'user', 'trade');
            $duration = $this->Crud->read_field('id', $log_id, 'user', 'duration');
            if(!empty($trade_id)){
                $remittance = $this->Crud->read_field('id', $trade_id, 'trade', 'medium');
                $paids = $this->Crud->read_single('user_id', $log_id, 'history');
                if(!empty($paids)){
                    foreach($paids as $p){
                        $total_paid  += (float)$p->amount;
                    }
                }
                
            }
        }
        $service_data = array((int)$male, (int)$female, (int)$children, (int)$ft);
        $resp['service_date'] = ($service_date);
        $resp['service_key'] = ($service_key);
        $resp['service_data'] = json_encode($service_data);

        
        echo json_encode($resp);
        die;
    }
    public function finance_metric(){
        $log_id = $this->session->get('td_id');
        
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));

        $finance_wednesday = [];
      
        
        $finance_type = strtolower($this->request->getPost('finance_type'));
		$current_year = $this->request->getPost('current_year');
		$start_date = date($current_year.'-01-01');
        $end_date = date($current_year.'-12-31');
        // Get the first day of the current year
        $startDate = strtotime("first Sunday of January $current_year");

        // Get the last day of the current year
        $endDate = strtotime("last day of December $current_year");
        if($role == 'developer' || $role == 'administrator'){
            $sunday_id = $this->Crud->read_field('name', 'Sunday Service', 'service_type', 'id');
            $sunday = $this->Crud->date_range1($start_date, 'date', $end_date,'date', 'type', $sunday_id, 'service_report');
            $wednesday_id = $this->Crud->read_field('name', 'Wednesday Service', 'service_type', 'id');
            $wednesday = $this->Crud->date_range1($start_date, 'date', $end_date, 'date','type', $wednesday_id, 'service_report');
            
            // print_r($wednesday);
            while ($startDate <= $endDate) {
                if(!empty($sunday)){
                    foreach($sunday as $s){ 
                        if($finance_type == 'offering')$amount = (float)$s->offering;
                        if($finance_type == 'tithe')$amount = (float)$s->tithe;
                        if($finance_type == 'partnership')$amount = (float)$s->partnership;
                        if($s->date == date('Y-m-d', $startDate)){
                            $finance_sunday[] = $amount;
                        }else{
                            $finance_sunday[] = 0;
                        }
    
                    }
                    
                }else{
                    $finance_sunday[] = 0;
                }

                if(!empty($wednesday)){
                    foreach($wednesday as $s){ 
                        if($finance_type == 'offering')$amount = (float)$s->offering;
                        if($finance_type == 'tithe')$amount = (float)$s->tithe;
                        if($finance_type == 'partnership')$amount = (float)$s->partnership;
                        if($s->date == date('Y-m-d', strtotime('next Wednesday', $startDate))){
                            $finance_wednesday[] = $amount;
                        }else{
                            $finance_wednesday[] = 0;
                        }
                    }
                } else{
                    $finance_wednesday[] = 0;
                }
                $startDate = strtotime('+1 week', $startDate);
            }
           
        }
        
        if($role != 'developer' && $role != 'administrator'){
            $trade_id = $this->Crud->read_field('id', $log_id, 'user', 'trade');
            $duration = $this->Crud->read_field('id', $log_id, 'user', 'duration');
            if(!empty($trade_id)){
                $remittance = $this->Crud->read_field('id', $trade_id, 'trade', 'medium');
                $paids = $this->Crud->read_single('user_id', $log_id, 'history');
                if(!empty($paids)){
                    foreach($paids as $p){
                        $total_paid  += (float)$p->amount;
                    }
                }
                
            }
        }
        
        $resp['finance_sunday'] = json_encode($finance_sunday);
        $resp['finance_wednesday'] = json_encode($finance_wednesday);

        
        echo json_encode($resp);
        die;
    }

}
