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
            $cell_report = $this->Crud->date_range($start_date, 'date', $end_date, 'date', 'cell_report');
            $service_report = $this->Crud->date_range($start_date, 'date', $end_date, 'date', 'service_report');
            
            
            if(!empty($partners)){
                foreach($partners as $u){
                    $partnership += (float)$u->amount_paid;
                }
                $partnership_part = count($partners);
            }

            if(!empty($cell_report)){
                foreach($cell_report as $u){
                    $offering += (float)$u->offering;
                }
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
                    
                    
                    $paids = ((float)$paid * 100)/(float)$partnership;
                    // Select a random key
                    $random_key = array_rand($col);

                    // Get the value at the random key
                    $cols = $col[$random_key];


                    
                    $partnership_list .= '
                        <div class="progress-wrap">
                            <div class="progress-text">
                                <div class="progress-label">'.ucwords($p->name).'</div>
                                <div class="progress-amount">'.number_format($paid,2).'</div>
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

        
        echo json_encode($resp);
        die;
    }

}
