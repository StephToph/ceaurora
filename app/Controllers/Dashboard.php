<?php

namespace App\Controllers;

class Dashboard extends BaseController {

 
    public function index($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('td_id');
       if(empty($log_id)) return redirect()->to(site_url('auth'));

       if($this->Crud->check2('id', $log_id, 'setup', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
       if($this->Crud->check2('id', $log_id, 'trade', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
       if($this->Crud->check2('id', $log_id, 'state_id', 0, 'user')> 0)return redirect()->to(site_url('auth/profile'));
       if($this->Crud->check2('id', $log_id, 'country_id', 0, 'user')> 0)return redirect()->to(site_url('auth/profile'));
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
        $username = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
        
        $data['log_id'] = $log_id;
        $data['param1'] = $param1;
        $data['param2'] = $param2;
        $data['param3'] = $param3;


            // record listing
		if($param1 == 'tax_metric') {
			$limit = $param2;
			$offset = $param3;

			$count = 0;
			$rec_limit = 8;
			$items = '	
                <div class="nk-tb-item nk-tb-head">
                    <div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Date').'</span></div>
                    <div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Tax Account').'</span></div>
                    <div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Amount Paid').'</span></div>
                    <div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Reference').'</span></div>
                    <div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Method').'</span></div>
                </div><!-- .nk-tb-item -->
                    
                
            ';
            $item = '';
			if($limit == '') {$limit = $rec_limit;}
			if($offset == '') {$offset = 0;}
			
            $date_type = $this->request->getPost('date_type');
            $lga_id = $this->request->getPost('lga_id');
            $territory = $this->request->getPost('territory');
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
            
            $search = $this->request->getVar('search');

			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$query = $this->Crud->filter_history($limit, $offset, $log_id, $search, $lga_id, $territory);
				$all_rec = $this->Crud->filter_history('', '', $log_id, $search, $lga_id, $territory);
				if(!empty($all_rec)) { $count = count($all_rec); } else { $count = 0; }
				$curr = '&#8358;';
                
				if(!empty($query)) {
					foreach($query as $q) {
                        $id = $q->id;
                        $user_id = $q->user_id;
                        $tax_id = $this->Crud->read_field('user_id', $user_id, 'virtual_account', 'acc_no');
                        $payment_method = $q->payment_method;
                        $ref = $q->ref;
                        $remark = $q->remark;
                        $amount = number_format((float)$q->amount, 2);
                        $reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

                        // user 
                        $user = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
                        
                       

                        $item .= '
                            <div class="nk-tb-item">
                                <div class="nk-tb-col tb-col-md">
                                    <span class="text-dark">'.$reg_date.'</span>
                                </div>
                                <div class="nk-tb-col">
                                    <div class="d-md-none">'.$reg_date.'</div>
                                    <span class="fw-bold text-success">'.$tax_id.'</span><br>
                                    <span class="fw-bold text-secondary">'.translate_phrase(strtoupper($user)).'</span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="text-info">'.$curr.$amount.'</span>
                                    <div class="d-md-none">
                                        '.strtoupper($payment_method).'
                                    </div>
                                </div>
                                <div class="nk-tb-col">
                                    <span>'.$ref.'</span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    '.strtoupper($payment_method).'
                                </div>
                                
                            </div>
                            
                        ';
                    }
				}
			}

			$total = 0;
			
			if(empty($item)) {
				$resp['item'] = '
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="icon ni ni-tranx" style="font-size:150px;"></i><br/><br/>No Tax Payment Returned
					</div>
				';
			} else {
				$resp['item'] = $items.$item;
			}

			$more_record = $count - ($offset + $rec_limit);
			$resp['left'] = $more_record;
			$resp['total'] = $curr . number_format($total, 2);

			if($count > ($offset + $rec_limit)) { // for load more records
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
        $data['username'] = $username;
        $data['current_language'] = $this->session->get('current_language');
        $data['role'] = $role;
        $data['role_c'] = $role_c;
        $data['title'] = translate_phrase('Dashboard').' | '.app_name;
        $data['page_active'] = $mod;
        return view('dashboard', $data);
    }
    
    

    public function faq($param1='', $param2='', $para3='') {
        // check login
        $log_id = $this->session->get('td_id');
       if(empty($log_id)) return redirect()->to(site_url('auth'));

       if($this->Crud->check2('id', $log_id, 'setup', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
       if($this->Crud->check2('id', $log_id, 'trade', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
       if($this->Crud->check2('id', $log_id, 'state_id', 0, 'user')> 0)return redirect()->to(site_url('auth/profile'));
       if($this->Crud->check2('id', $log_id, 'country_id', 0, 'user')> 0)return redirect()->to(site_url('auth/profile'));
       $mod = 'dashboard';
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, $mod, 'create');
        $role_r = $this->Crud->module($role_id, $mod, 'read');
        $role_u = $this->Crud->module($role_id, $mod, 'update');
        $role_d = $this->Crud->module($role_id, $mod, 'delete');
       
        $username = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
    
        $data['log_id'] = $log_id;
        $data['username'] = $username;
        $data['current_language'] = $this->session->get('current_language');
        $data['role'] = $role;
        $data['role_c'] = $role_c;
        $data['title'] = translate_phrase('Frequently Asked Questions').' | '.app_name;
        $data['page_active'] = $mod;
        return view('designs/faq', $data);
    }

    //Beneficiary List
    public function tax_check($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'tax_check';

        $log_id = $this->session->get('td_id');
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, 'dashboard/'.$mod, 'create');
        $role_r = $this->Crud->module($role_id, 'dashboard/'.$mod, 'read');
        $role_u = $this->Crud->module($role_id, 'dashboard/'.$mod, 'update');
        $role_d = $this->Crud->module($role_id, 'dashboard/'.$mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }
        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;
       
		$table = 'beneficiary';
		$form_link = site_url('dashboard/'.$mod);
		if($param1){$form_link .= '/'.$param1;}
		if($param2){$form_link .= '/'.$param2.'/';}
		if($param3){$form_link .= $param3;}
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		$data['form_link'] = $form_link;
		
		// manage record
		if($param1 == 'manage') {
						
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
                    //echo var_dump($edit);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}
					
					if($this->request->getMethod() == 'post'){
                        $del_id =  $this->request->getVar('d_vendor_id');
                        
                        $del = $this->Crud->deletes('id', $del_id, 'beneficiary');

                        if($del > 0){	
                        
							echo $this->Crud->msg('success', translate_phrase('Beneficiary  Deleted Successfully'));
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', translate_phrase('Please try later'));
						}
						die;	
					}
				}
			} else {
				// prepare for edit
				if($param2 == 'edit') {
					if($param3) {
						
						$edit = $this->Crud->read_single('id', $param3, $table);
						if(!empty($edit)) {
							foreach($edit as $e) {
								$data['e_id'] = $e->id;
								$data['e_activate'] = $e->activate;
								$data['e_role_id'] = $e->role_id;
							}
						}
						
					}
				}
				
				if($this->request->getMethod() == 'post'){
					$user_i = $this->request->getPost('user_id');
					$role = $this->request->getPost('role');
					$password = $this->request->getPost('password');
					
					$role_ids =  $this->Crud->read_field('name', 'Business', 'access_role', 'id');
			
					if($this->request->getPost('ban')) { $set_activate = 1; } else { $set_activate = 0; }
					
					$data['password'] = md5($password);
					$data['activate'] = $set_activate;
					$data['role'] = $role;
					$data['role_id'] = $role_ids;
					
					
					// do create or update
					if($user_i) {
                        $update = $this->Crud->api('post', 'users/update/' . $user_i, $data);
                        $update = json_decode($update);
						
						if($update->status == true){
							echo $this->Crud->msg('success', translate_phrase($update->msg));
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg($update->code, translate_phrase($update->msg));	
						}
                        die;
					} 
						
				}
			}
		}

        if($param1 == 'validate'){
            if(!empty($param2)){
                $valid = $this->Crud->api('post', 'zend/tax_status', array('account_number'=>$param2));
                $valids = json_decode($valid);
                
                echo $this->Crud->msg($valids->code, $valids->msg);
                if($valids->status == 'true'){
                    if(!empty($valids->data)){
                        foreach($valids->data as $dt){
                            $name = $dt->account_name;
                            $passport = $dt->account_passport;
                            $tax_id = $dt->tax_id;
                            $pend = $dt->pend_payment;

                            $pends = '';
                            if(!empty($pend)){
                                foreach($pend as $p){
                                    $paid = $p->amount;
                                    if($p->amount != $p->balance){
                                        $paid = (float)$p->amount - (float)$p->balance;
                                    } else {
                                        $paid = 0;
                                    }
                                    $pends .= '<div class="col-sm-4"><span class="text-info">Due Date: '.$p->payment_date.'</span></div> 
                                            <div class="col-sm-4"><span class="text-success">Paid: '.curr.number_format($paid,2).'</span></div> 
                                            <div class="col-sm-4 mb-2"><span class="text-danger">Bal: '.curr.number_format($p->balance,2).'</span></div> ';
                                }
                            }
                        }
                        
                        echo '
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="'.$passport.'">
                                </div>
                                <div class="col-sm-9">
                                    <b>Name: '.ucwords($name).'</b><br>
                                    <b>Tax ID: '.strtoupper($tax_id).'</b>
                                    <p><b>Pending Payment(s)</b>
                                        <div class="row">'.$pends.'</div>
                                    </p>

                                </div>
                            </div>
                        ';
                    }
                   
                }
            } else {
                echo $this->Crud->msg('danger', 'Account Number cannot be Empty');
               
            } 
            
            die;
        }

        
        $data['current_language'] = $this->session->get('current_language');
		if($param1 == 'manage') { // view for form data posting
			return view($mod.'_form', $data);
		} else { // view for main page
			
			$data['title'] = translate_phrase('Tax Status Check').' | '.app_name;
			$data['page_active'] = 'dashboard/tax_check';
			return view($mod, $data);
		}
    }


    public function text($time=''){
        
		$bank = '
             {"status":"success","message":"Banks fetched successfully","data":[{"id":825,"code":"000019","name":"Enterprise Bank"},{"id":964,"code":"000025","name":"Titan Trust Bank"},{"id":395,"code":"000026","name":"Taj Bank Limited"},{"id":301,"code":"000027","name":"Globus Bank"},{"id":1978,"code":"000028","name":"Central Bank Of Nigeria"},{"id":1977,"code":"000029","name":"Lotus Bank"},{"id":988,"code":"000030","name":"Parallex Bank"},{"id":1318,"code":"000031","name":"PremiumTrust Bank"},{"id":1355,"code":"000033","name":"ENaira"},{"id":2050,"code":"000034","name":"SIGNATURE BANK"},{"id":2010,"code":"000036","name":"Optimus Bank"},{"id":2298,"code":"000037","name":"ALTERNATIVE BANK LIMITED"},{"id":5,"code":"011","name":"First Bank PLC"},{"id":2,"code":"023","name":"Citi Bank"},{"id":186,"code":"030","name":"Heritage Bank"},{"id":14,"code":"032","name":"Union Bank PLC"},{"id":13,"code":"033","name":"United Bank for Africa"},{"id":15,"code":"035","name":"Wema Bank PLC"},{"id":1,"code":"044","name":"Access Bank"},{"id":4,"code":"050","name":"EcoBank PLC"},{"id":1976,"code":"050001","name":"County Finance Ltd"},{"id":1975,"code":"050002","name":"Fewchore Finance Company Limited"},{"id":1974,"code":"050003","name":"Sagegrey Finance Limited"},{"id":1973,"code":"050004","name":"Newedge Finance Ltd"},{"id":1972,"code":"050005","name":"Aaa Finance"},{"id":1971,"code":"050006","name":"Branch International Financial Services"},{"id":2042,"code":"050007","name":"Tekla Finance Ltd"},{"id":2072,"code":"050008","name":"SIMPLE FINANCE LIMITED"},{"id":2035,"code":"050009","name":"FAST CREDIT"},{"id":2048,"code":"050010","name":"FUNDQUEST FINANCIAL SERVICES LTD"},{"id":2056,"code":"050012","name":"Enco Finance"},{"id":2060,"code":"050013","name":"Dignity Finance"},{"id":2067,"code":"050014","name":"TRINITY FINANCIAL SERVICES LIMITED"},{"id":2299,"code":"050020","name":"VALE FINANCE LIMITED"},{"id":16,"code":"057","name":"Zenith bank PLC"},{"id":8,"code":"058","name":"Guaranty Trust Bank"},{"id":826,"code":"060001","name":"Coronation Merchant Bank"},{"id":827,"code":"060002","name":"FBNQUEST Merchant Bank"},{"id":828,"code":"060003","name":"Nova Merchant Bank"},{"id":987,"code":"060004","name":"Greenwich Merchant Bank"},{"id":11,"code":"068","name":"Standard Chaterted bank PLC"},{"id":7,"code":"070","name":"Fidelity Bank"},{"id":811,"code":"070001","name":"NPF MicroFinance Bank"},{"id":847,"code":"070002","name":"Fortis Microfinance Bank"},{"id":659,"code":"070006","name":"Covenant Microfinance Bank"},{"id":829,"code":"070007","name":"Omoluabi savings and loans"},{"id":848,"code":"070008","name":"Page Financials"},{"id":836,"code":"070009","name":"Gateway Mortgage Bank"},{"id":837,"code":"070010","name":"Abbey Mortgage Bank"},{"id":838,"code":"070011","name":"Refuge Mortgage Bank"},{"id":839,"code":"070012","name":"Lagos Building Investment Company"},{"id":840,"code":"070013","name":"Platinum Mortgage Bank"},{"id":841,"code":"070014","name":"First Generation Mortgage Bank"},{"id":842,"code":"070015","name":"Brent Mortgage Bank"},{"id":843,"code":"070016","name":"Infinity Trust Mortgage Bank"},{"id":845,"code":"070017","name":"Haggai Mortgage Bank Limited"},{"id":1970,"code":"070019","name":"Mayfresh Mortgage Bank"},{"id":1969,"code":"070021","name":"Coop Mortgage Bank"},{"id":1968,"code":"070022","name":"Stb Mortgage Bank"},{"id":1967,"code":"070023","name":"Delta Trust Mortgage Bank"},{"id":1966,"code":"070024","name":"Homebase Mortgage"},{"id":1965,"code":"070025","name":"Akwa Savings & Loans Limited"},{"id":1964,"code":"070026","name":"Fha Mortgage Bank Ltd"},{"id":9,"code":"076","name":"Polaris bank"},{"id":1963,"code":"080002","name":"Tajwallet"},{"id":183,"code":"082","name":"Keystone Bank"},{"id":830,"code":"090001","name":"ASOSavings & Loans"},{"id":844,"code":"090003","name":"Jubilee-Life Mortgage Bank"},{"id":849,"code":"090004","name":"Parralex Microfinance bank"},{"id":831,"code":"090005","name":"Trustbond Mortgage Bank"},{"id":832,"code":"090006","name":"SafeTrust "},{"id":850,"code":"090097","name":"Ekondo MFB"},{"id":833,"code":"090107","name":"FBN Mortgages Limited"},{"id":846,"code":"090108","name":"New Prudential Bank"},{"id":660,"code":"090110","name":"VFD Micro Finance Bank"},{"id":851,"code":"090112","name":"Seed Capital Microfinance Bank"},{"id":1962,"code":"090113","name":"Microvis Microfinance Bank"},{"id":852,"code":"090114","name":"Empire trust MFB"},{"id":258,"code":"090115","name":"TCF MFB"},{"id":853,"code":"090116","name":"AMML MFB"},{"id":854,"code":"090117","name":"Boctrust Microfinance Bank"},{"id":855,"code":"090118","name":"IBILE Microfinance Bank"},{"id":856,"code":"090119","name":"Ohafia Microfinance Bank"},{"id":857,"code":"090120","name":"Wetland Microfinance Bank"},{"id":858,"code":"090121","name":"Hasal Microfinance Bank"},{"id":859,"code":"090122","name":"Gowans Microfinance Bank"},{"id":860,"code":"090123","name":"Verite Microfinance Bank"},{"id":861,"code":"090124","name":"Xslnce Microfinance Bank"},{"id":862,"code":"090125","name":"Regent Microfinance Bank"},{"id":863,"code":"090126","name":"Fidfund Microfinance Bank"},{"id":864,"code":"090127","name":"BC Kash Microfinance Bank"},{"id":865,"code":"090128","name":"Ndiorah Microfinance Bank"},{"id":866,"code":"090129","name":"Money Trust Microfinance Bank"},{"id":867,"code":"090130","name":"Consumer Microfinance Bank"},{"id":868,"code":"090131","name":"Allworkers Microfinance Bank"},{"id":869,"code":"090132","name":"Richway Microfinance Bank"},{"id":870,"code":"090133","name":" AL-Barakah Microfinance Bank"},{"id":871,"code":"090134","name":"Accion Microfinance Bank"},{"id":872,"code":"090135","name":"Personal Trust Microfinance Bank"},{"id":873,"code":"090136","name":"Baobab Microfinance Bank"},{"id":874,"code":"090137","name":"PecanTrust Microfinance Bank"},{"id":875,"code":"090138","name":"Royal Exchange Microfinance Bank"},{"id":876,"code":"090139","name":"Visa Microfinance Bank"},{"id":877,"code":"090140","name":"Sagamu Microfinance Bank"},{"id":878,"code":"090141","name":"Chikum Microfinance Bank"},{"id":879,"code":"090142","name":"Yes Microfinance Bank"},{"id":880,"code":"090143","name":"Apeks Microfinance Bank"},{"id":881,"code":"090144","name":"CIT Microfinance Bank"},{"id":882,"code":"090145","name":"Fullrange Microfinance Bank"},{"id":883,"code":"090146","name":"Trident Microfinance Bank"},{"id":884,"code":"090147","name":"Hackman Microfinance Bank"},{"id":885,"code":"090148","name":"Bowen Microfinance Bank"},{"id":886,"code":"090149","name":"IRL Microfinance Bank"},{"id":887,"code":"090150","name":"Virtue Microfinance Bank"},{"id":888,"code":"090151","name":"Mutual Trust Microfinance Bank"},{"id":889,"code":"090152","name":"Nagarta Microfinance Bank"},{"id":890,"code":"090153","name":"FFS Microfinance Bank"},{"id":891,"code":"090154","name":"CEMCS Microfinance Bank"},{"id":892,"code":"090155","name":"La Fayette Microfinance Bank"},{"id":893,"code":"090156","name":"e-Barcs Microfinance Bank"},{"id":894,"code":"090157","name":"Infinity Microfinance Bank"},{"id":895,"code":"090158","name":"Futo Microfinance Bank"},{"id":896,"code":"090159","name":"Credit Afrique Microfinance Bank"},{"id":897,"code":"090160","name":"Addosser Microfinance Bank"},{"id":898,"code":"090161","name":"Okpoga Microfinance Bank"},{"id":899,"code":"090162","name":"Stanford Microfinance Bak"},{"id":1961,"code":"090163","name":"First Multiple Microfinance Bank"},{"id":900,"code":"090164","name":"First Royal Microfinance Bank"},{"id":901,"code":"090165","name":"Petra Microfinance Bank"},{"id":902,"code":"090166","name":"Eso-E Microfinance Bank"},{"id":903,"code":"090167","name":"Daylight Microfinance Bank"},{"id":904,"code":"090168","name":"Gashua Microfinance Bank"},{"id":905,"code":"090169","name":"Alpha Kapital Microfinance Bank"},{"id":1960,"code":"090170","name":"Rahama Microfinance Bank"},{"id":906,"code":"090171","name":"Mainstreet Microfinance Bank"},{"id":907,"code":"090172","name":"Astrapolaris Microfinance Bank"},{"id":908,"code":"090173","name":"Reliance Microfinance Bank"},{"id":909,"code":"090174","name":"Malachy Microfinance Bank"},{"id":253,"code":"090175","name":"Rubies Microfinance Bank"},{"id":910,"code":"090175","name":"HighStreet Microfinance Bank"},{"id":911,"code":"090176","name":"Bosak Microfinance Bank"},{"id":912,"code":"090177","name":"Lapo Microfinance Bank"},{"id":913,"code":"090178","name":"GreenBank Microfinance Bank"},{"id":914,"code":"090179","name":"FAST Microfinance Bank"},{"id":597,"code":"090180","name":"AMJU Unique Microfinance Bank"},{"id":1959,"code":"090181","name":"Balogun Fulani Microfinance Bank"},{"id":1958,"code":"090182","name":"Standard Microfinance Bank"},{"id":1957,"code":"090186","name":"Girei Microfinance Bank"},{"id":915,"code":"090188","name":"Baines Credit Microfinance Bank"},{"id":916,"code":"090189","name":"Esan Microfinance Bank"},{"id":917,"code":"090190","name":"Mutual Benefits Microfinance Bank"},{"id":918,"code":"090191","name":"KCMB Microfinance Bank"},{"id":919,"code":"090192","name":"Midland Microfinance Bank"},{"id":920,"code":"090193","name":"Unical Microfinance Bank"},{"id":921,"code":"090194","name":"NIRSAL Microfinance Bank"},{"id":922,"code":"090195","name":"Grooming Microfinance Bank"},{"id":923,"code":"090196","name":"Pennywise Microfinance Bank"},{"id":924,"code":"090197","name":"ABU Microfinance Bank"},{"id":925,"code":"090198","name":"RenMoney Microfinance Bank"},{"id":1956,"code":"090201","name":"Xpress Payments"},{"id":1955,"code":"090202","name":"Accelerex Network"},{"id":926,"code":"090205","name":"New Dawn Microfinance Bank"},{"id":1954,"code":"090211","name":"Itex Integrated Services Limited"},{"id":927,"code":"090251","name":"UNN MFB"},{"id":1953,"code":"090252","name":"Yobe Microfinance Bank"},{"id":1952,"code":"090254","name":"Coalcamp Microfinance Bank"},{"id":928,"code":"090258","name":"Imo State Microfinance Bank"},{"id":929,"code":"090259","name":"Alekun Microfinance Bank"},{"id":930,"code":"090260","name":"Above Only Microfinance Bank"},{"id":931,"code":"090261","name":"Quickfund Microfinance Bank"},{"id":932,"code":"090262","name":"Stellas Microfinance Bank"},{"id":933,"code":"090263","name":"Navy Microfinance Bank"},{"id":934,"code":"090264","name":"Auchi Microfinance Bank"},{"id":935,"code":"090265","name":"Lovonus Microfinance Bank"},{"id":936,"code":"090266","name":"Uniben Microfinance Bank"},{"id":254,"code":"090267","name":"Kuda"},{"id":937,"code":"090268","name":"Adeyemi College Staff Microfinance Bank"},{"id":938,"code":"090269","name":"Greenville Microfinance Bank"},{"id":939,"code":"090270","name":"AB Microfinance Bank"},{"id":940,"code":"090271","name":"Lavender Microfinance Bank"},{"id":941,"code":"090272","name":"Olabisi Onabanjo University Microfinance Bank"},{"id":942,"code":"090273","name":"Emeralds Microfinance Bank"},{"id":1951,"code":"090274","name":"Prestige Microfinance Bank"},{"id":1950,"code":"090275","name":"Meridian Microfinance Bank"},{"id":943,"code":"090276","name":"Trustfund Microfinance Bank"},{"id":944,"code":"090277","name":"Al-Hayat Microfinance Bank"},{"id":1949,"code":"090278","name":"Glory Microfinance Bank "},{"id":1948,"code":"090279","name":"Ikire Microfinance Bank"},{"id":1947,"code":"090280","name":"Megapraise Microfinance Bank"},{"id":640,"code":"090281","name":"Mint-Finex MICROFINANCE BANK"},{"id":1946,"code":"090282","name":"Arise Microfinance Bank"},{"id":1945,"code":"090283","name":"Thrive Microfinance Bank"},{"id":1944,"code":"090285","name":"First Option Microfinance Bank"},{"id":996,"code":"090286","name":"Safe Haven MFB"},{"id":1943,"code":"090287","name":"Assets Matrix Microfinance Bank"},{"id":1942,"code":"090289","name":"Pillar Microfinance Bank"},{"id":1941,"code":"090290","name":"Fct Microfinance Bank"},{"id":1940,"code":"090291","name":"Halacredit Microfinance Bank"},{"id":1939,"code":"090292","name":"Afekhafe Microfinance Bank"},{"id":1938,"code":"090293","name":"Brethren Microfinance Bank"},{"id":1937,"code":"090294","name":"Eagle Flight Microfinance Bank"},{"id":1936,"code":"090295","name":"Omiye Microfinance Bank"},{"id":1935,"code":"090296","name":"Polyuwanna Microfinance Bank"},{"id":1934,"code":"090297","name":"Alert Microfinance Bank"},{"id":1933,"code":"090298","name":"Federalpoly Nasarawamfb"},{"id":1932,"code":"090299","name":"Kontagora Microfinance Bank"},{"id":1931,"code":"090302","name":"Sunbeam Microfinance Bank"},{"id":1930,"code":"090303","name":"Purplemoney Microfinance Bank"},{"id":1929,"code":"090304","name":"Evangel Microfinance Bank"},{"id":1928,"code":"090305","name":"Sulsap Microfinance Bank"},{"id":1927,"code":"090307","name":"Aramoko Microfinance Bank"},{"id":1926,"code":"090308","name":"Brightway Microfinance Bank"},{"id":1925,"code":"090310","name":"Edfin Microfinance Bank"},{"id":1924,"code":"090315","name":"U And C Microfinance Bank"},{"id":1923,"code":"090316","name":"Bayero Microfinance Bank"},{"id":661,"code":"090317","name":"PatrickGold Microfinance Bank"},{"id":1922,"code":"090318","name":"Federal University Dutse Microfinance Bank"},{"id":1921,"code":"090319","name":"Bonghe Microfinance Bank"},{"id":1920,"code":"090320","name":"Kadpoly Microfinance Bank"},{"id":1919,"code":"090321","name":"Mayfair Microfinance Bank"},{"id":1918,"code":"090322","name":"Rephidim Microfinance Bank"},{"id":1917,"code":"090323","name":"Mainland Microfinance Bank"},{"id":1916,"code":"090324","name":"Ikenne Microfinance Bank"},{"id":728,"code":"090325","name":"Sparkle"},{"id":1915,"code":"090326","name":"Balogun Gambari Microfinance Bank"},{"id":1914,"code":"090327","name":"Trust Microfinance Bank"},{"id":639,"code":"090328","name":"Eyowo MFB"},{"id":1913,"code":"090329","name":"Neptune Microfinance Bank"},{"id":1912,"code":"090330","name":"Fame Microfinance Bank"},{"id":1911,"code":"090331","name":"Unaab Microfinance Bank"},{"id":1910,"code":"090332","name":"Evergreen Microfinance Bank"},{"id":1909,"code":"090333","name":"Oche Microfinance Bank"},{"id":2034,"code":"090335","name":"Grant MF Bank"},{"id":1908,"code":"090336","name":"Bipc Microfinance Bank"},{"id":1907,"code":"090337","name":"Iyeru Okin Microfinance Bank Ltd"},{"id":1906,"code":"090338","name":"Uniuyo Microfinance Bank"},{"id":1905,"code":"090340","name":"Stockcorp Microfinance Bank"},{"id":1904,"code":"090341","name":"Unilorin Microfinance Bank"},{"id":1903,"code":"090343","name":"Citizen Trust Microfinance Bank Ltd"},{"id":1902,"code":"090345","name":"Oau Microfinance Bank Ltd"},{"id":1901,"code":"090349","name":"Nasarawa Microfinance Bank"},{"id":1900,"code":"090350","name":"Illorin Microfinance Bank"},{"id":1899,"code":"090352","name":"Jessefield Microfinance Bank"},{"id":1898,"code":"090353","name":"Isuofia Microfinance Bank"},{"id":1897,"code":"090360","name":"Cashconnect Microfinance Bank"},{"id":1896,"code":"090362","name":"Molusi Microfinance Bank"},{"id":1895,"code":"090363","name":"Headway Microfinance Bank"},{"id":1894,"code":"090364","name":"Nuture Microfinance Bank"},{"id":1893,"code":"090365","name":"Corestep Microfinance Bank"},{"id":989,"code":"090366","name":"Firmus MFB"},{"id":1892,"code":"090369","name":"Seedvest Microfinance Bank"},{"id":1891,"code":"090370","name":"Ilasan Microfinance Bank"},{"id":1890,"code":"090371","name":"Agosasa Microfinance Bank"},{"id":1889,"code":"090372","name":"Legend Microfinance Bank"},{"id":1888,"code":"090373","name":"Tf Microfinance Bank"},{"id":1887,"code":"090374","name":"Coastline Microfinance Bank"},{"id":1886,"code":"090376","name":"Apple Microfinance Bank"},{"id":1885,"code":"090377","name":"Isaleoyo Microfinance Bank"},{"id":1884,"code":"090378","name":"New Golden Pastures Microfinance Bank"},{"id":1883,"code":"090379","name":"Peniel Micorfinance Bank Ltd"},{"id":1882,"code":"090380","name":"Kredi Money Microfinance Bank"},{"id":992,"code":"090383","name":"Manny Microfinance bank"},{"id":1881,"code":"090385","name":"Gti Microfinance Bank"},{"id":1880,"code":"090386","name":"Interland Microfinance Bank"},{"id":1879,"code":"090389","name":"Ek-Reliable Microfinance Bank"},{"id":1878,"code":"090390","name":"Parkway Mf Bank"},{"id":1877,"code":"090391","name":"Davodani Microfinance Bank"},{"id":1876,"code":"090392","name":"Mozfin Microfinance Bank"},{"id":638,"code":"090393","name":"BRIDGEWAY MICROFINANCE BANK"},{"id":1875,"code":"090394","name":"Amac Microfinance Bank"},{"id":1874,"code":"090395","name":"Borgu Microfinance Bank"},{"id":1873,"code":"090396","name":"Oscotech Microfinance Bank"},{"id":1872,"code":"090397","name":"Chanelle Bank"},{"id":1871,"code":"090398","name":"Federal Polytechnic Nekede Microfinance Bank"},{"id":1870,"code":"090399","name":"Nwannegadi Microfinance Bank"},{"id":1869,"code":"090400","name":"Finca Microfinance Bank"},{"id":1868,"code":"090401","name":"Shepherd Trust Microfinance Bank"},{"id":1867,"code":"090402","name":"Peace Microfinance Bank"},{"id":1866,"code":"090403","name":"Uda Microfinance Bank"},{"id":1865,"code":"090404","name":"Olowolagba Microfinance Bank"},{"id":1864,"code":"090405","name":"Moniepoint Microfinance Bank"},{"id":1863,"code":"090406","name":"Business Support Microfinance Bank"},{"id":1862,"code":"090408","name":"Gmb Microfinance Bank"},{"id":1861,"code":"090409","name":"Fcmb Microfinance Bank"},{"id":1860,"code":"090410","name":"Maritime Microfinance Bank"},{"id":1859,"code":"090411","name":"Giginya Microfinance Bank"},{"id":1858,"code":"090412","name":"Preeminent Microfinance Bank"},{"id":1857,"code":"090413","name":"Benysta Microfinance Bank"},{"id":1856,"code":"090414","name":"Crutech Microfinance Bank"},{"id":1855,"code":"090415","name":"Calabar Microfinance Bank"},{"id":1854,"code":"090416","name":"Chibueze Microfinance Bank"},{"id":1853,"code":"090417","name":"Imowo Microfinance Bank"},{"id":1852,"code":"090418","name":"Highland Microfinance Bank"},{"id":1851,"code":"090419","name":"Winview Bank"},{"id":994,"code":"090420","name":"Letshego MFB"},{"id":1850,"code":"090421","name":"Izon Microfinance Bank"},{"id":1849,"code":"090422","name":"Landgold Microfinance Bank"},{"id":986,"code":"090423","name":"MAUTECH Microfinance Bank"},{"id":1848,"code":"090424","name":"Abucoop Microfinance Bank"},{"id":1847,"code":"090425","name":"Banex Microfinance Bank"},{"id":998,"code":"090426","name":"Tangerine Bank"},{"id":1846,"code":"090427","name":"Ebsu Microfinance Bank"},{"id":1845,"code":"090428","name":"Ishie Microfinance Bank"},{"id":1844,"code":"090429","name":"Crossriver Microfinance Bank"},{"id":1843,"code":"090430","name":"Ilora Microfinance Bank"},{"id":1842,"code":"090431","name":"Bluewhales Microfinance Bank"},{"id":1841,"code":"090432","name":"Memphis Microfinance Bank"},{"id":1840,"code":"090433","name":"Rigo Microfinance Bank"},{"id":1839,"code":"090434","name":"Insight Microfinance Bank"},{"id":1353,"code":"090435","name":"Links Microfinance Bank"},{"id":1838,"code":"090436","name":"Spectrum Microfinance Bank"},{"id":1837,"code":"090437","name":"Oakland Microfinance Bank"},{"id":1836,"code":"090438","name":"Futminna Microfinance Bank"},{"id":1835,"code":"090439","name":"Ibeto Microfinance Bank"},{"id":1834,"code":"090440","name":"Cherish Microfinance Bank"},{"id":1833,"code":"090441","name":"Giwa Microfinance Bank"},{"id":1832,"code":"090443","name":"Rima Microfinance Bank"},{"id":1831,"code":"090444","name":"Boi Mf Bank"},{"id":1830,"code":"090445","name":"Capstone Mf Bank"},{"id":1829,"code":"090446","name":"Support Mf Bank"},{"id":1828,"code":"090448","name":"Moyofade Mf Bank"},{"id":1827,"code":"090449","name":"Sls Mf Bank"},{"id":1826,"code":"090450","name":"Kwasu Mf Bank"},{"id":1825,"code":"090451","name":"Atbu Microfinance Bank"},{"id":1824,"code":"090452","name":"Unilag Microfinance Bank"},{"id":1823,"code":"090453","name":"Uzondu Mf Bank"},{"id":1822,"code":"090454","name":"Borstal Microfinance Bank"},{"id":2045,"code":"090455","name":"MKOBO MICROFINANCE BANK LTD"},{"id":1821,"code":"090456","name":"Ospoly Microfinance Bank"},{"id":1820,"code":"090459","name":"Nice Microfinance Bank"},{"id":1819,"code":"090460","name":"Oluyole Microfinance Bank"},{"id":1818,"code":"090461","name":"Uniibadan Microfinance Bank"},{"id":1817,"code":"090462","name":"Monarch Microfinance Bank"},{"id":1816,"code":"090463","name":"Rehoboth Microfinance Bank"},{"id":1815,"code":"090464","name":"Unimaid Microfinance Bank"},{"id":1814,"code":"090465","name":"Maintrust Microfinance Bank"},{"id":1813,"code":"090466","name":"Yct Microfinance Bank"},{"id":1812,"code":"090467","name":"Good Neighbours Microfinance Bank"},{"id":1811,"code":"090468","name":"Olofin Owena Microfinance Bank"},{"id":1810,"code":"090469","name":"Aniocha Microfinance Bank"},{"id":1317,"code":"090470","name":"DOT MICROFINANCE BANK"},{"id":1809,"code":"090471","name":"Oluchukwu Microfinance Bank"},{"id":1808,"code":"090472","name":"Caretaker Microfinance Bank"},{"id":1807,"code":"090473","name":"Assets Microfinance Bank"},{"id":1806,"code":"090474","name":"Verdant Microfinance Bank"},{"id":1805,"code":"090475","name":"Giant Stride Microfinance Bank"},{"id":1804,"code":"090476","name":"Anchorage Microfinance Bank"},{"id":1803,"code":"090477","name":"Light Microfinance Bank"},{"id":1802,"code":"090478","name":"Avuenegbe Microfinance Bank"},{"id":1801,"code":"090479","name":"First Heritage Microfinance Bank"},{"id":1800,"code":"090480","name":"KOLOMONI MICROFINANCE BANK"},{"id":1799,"code":"090481","name":"Prisco Microfinance Bank"},{"id":1154,"code":"090482","name":"FEDETH MICROFINANCE BANK"},{"id":1798,"code":"090483","name":"Ada Microfinance Bank"},{"id":1797,"code":"090484","name":"Garki Microfinance Bank"},{"id":1796,"code":"090485","name":"Safegate Microfinance Bank"},{"id":1795,"code":"090486","name":"Fortress Microfinance Bank"},{"id":1794,"code":"090487","name":"Kingdom College Microfinance Bank"},{"id":1793,"code":"090488","name":"Ibu-Aje Microfinance"},{"id":1792,"code":"090489","name":"Alvana Microfinance Bank"},{"id":1791,"code":"090490","name":"Chukwunenye Microfinance Bank"},{"id":1790,"code":"090491","name":"Nsuk Microfinance Bank"},{"id":1789,"code":"090492","name":"Oraukwu Microfinance Bank"},{"id":1788,"code":"090493","name":"Iperu Microfinance Bank"},{"id":1787,"code":"090494","name":"Boji Boji Microfinance Bank"},{"id":1398,"code":"090495","name":"GOODNEWS MFB"},{"id":1786,"code":"090496","name":"Radalpha Microfinance Bank"},{"id":1785,"code":"090497","name":"Palmcoast Microfinance Bank"},{"id":1784,"code":"090498","name":"Catland Microfinance Bank"},{"id":1783,"code":"090499","name":"Pristine Divitis Microfinance Bank"},{"id":1782,"code":"090500","name":"Gwong Microfinance Bank"},{"id":1781,"code":"090501","name":"Boromu Microfinance Bank"},{"id":1780,"code":"090502","name":"Shalom Microfinance Bank"},{"id":1779,"code":"090503","name":"Projects Microfinance Bank"},{"id":1778,"code":"090504","name":"Zikora Microfinance Bank"},{"id":1777,"code":"090505","name":"Nigeria Prisonsmicrofinance Bank"},{"id":1776,"code":"090506","name":"Solid Allianze Microfinance Bank"},{"id":1775,"code":"090507","name":"Fims Microfinance Bank"},{"id":1774,"code":"090508","name":"Borno Renaissance Microfinance Bank"},{"id":1773,"code":"090509","name":"Capitalmetriq Swift Microfinance Bank"},{"id":1772,"code":"090510","name":"Umunnachi Microfinance Bank"},{"id":1771,"code":"090511","name":"Cloverleaf Microfinance Bank"},{"id":1770,"code":"090512","name":"Bubayero Microfinance Bank"},{"id":1769,"code":"090513","name":"Seap Microfinance Bank"},{"id":1768,"code":"090514","name":"Umuchinemere Procredit Microfinance Bank"},{"id":1767,"code":"090515","name":"Rima Growth Pathway Microfinance Bank "},{"id":1766,"code":"090516","name":"Numo Microfinance Bank"},{"id":1765,"code":"090517","name":"Uhuru Microfinance Bank"},{"id":1764,"code":"090518","name":"Afemai Microfinance Bank"},{"id":1763,"code":"090519","name":"Ibom Fadama Microfinance Bank"},{"id":1762,"code":"090520","name":"Ic Globalmicrofinance Bank"},{"id":1761,"code":"090521","name":"Foresight Microfinance Bank"},{"id":1760,"code":"090523","name":"Chase Microfinance Bank"},{"id":1759,"code":"090524","name":"Solidrock Microfinance Bank"},{"id":1758,"code":"090525","name":"Triple A Microfinance Bank"},{"id":1757,"code":"090526","name":"Crescent Microfinance Bank"},{"id":1756,"code":"090527","name":"Ojokoro Microfinance Bank"},{"id":1755,"code":"090528","name":"Mgbidi Microfinance Bank"},{"id":1754,"code":"090529","name":"Bankly Microfinance Bank"},{"id":1753,"code":"090530","name":"Confidence Microfinance Bank Ltd"},{"id":1752,"code":"090531","name":"Aku Microfinance Bank"},{"id":1751,"code":"090532","name":"Ibolo Micorfinance Bank Ltd"},{"id":1750,"code":"090534","name":"Polyibadan Microfinance Bank"},{"id":1749,"code":"090535","name":"Nkpolu-Ust Microfinance"},{"id":1748,"code":"090536","name":"Ikoyi-Osun Microfinance Bank"},{"id":1747,"code":"090537","name":"Lobrem Microfinance Bank"},{"id":1746,"code":"090538","name":"Blue Investments Microfinance Bank"},{"id":1745,"code":"090539","name":"Enrich Microfinance Bank"},{"id":1744,"code":"090540","name":"Aztec Microfinance Bank"},{"id":1743,"code":"090541","name":"Excellent Microfinance Bank"},{"id":1742,"code":"090542","name":"Otuo Microfinance Bank Ltd"},{"id":1741,"code":"090543","name":"Iwoama Microfinance Bank"},{"id":1740,"code":"090544","name":"Aspire Microfinance Bank Ltd"},{"id":1739,"code":"090545","name":"Abulesoro Microfinance Bank Ltd"},{"id":1738,"code":"090546","name":"Ijebu-Ife Microfinance Bank Ltd"},{"id":1737,"code":"090547","name":"Rockshield Microfinance Bank"},{"id":1736,"code":"090548","name":"Ally Microfinance Bank"},{"id":1735,"code":"090549","name":"Kc Microfinance Bank"},{"id":1734,"code":"090550","name":"Green Energy Microfinance Bank Ltd"},{"id":1733,"code":"090551","name":"Fairmoney Microfinance Bank Ltd"},{"id":1732,"code":"090552","name":"Ekimogun Microfinance Bank"},{"id":1731,"code":"090553","name":"Consistent Trust Microfinance Bank Ltd"},{"id":1730,"code":"090554","name":"Kayvee Microfinance Bank"},{"id":1729,"code":"090555","name":"Bishopgate Microfinance Bank"},{"id":1728,"code":"090556","name":"Egwafin Microfinance Bank Ltd"},{"id":1727,"code":"090557","name":"Lifegate Microfinance Bank Ltd"},{"id":1726,"code":"090558","name":"Shongom Microfinance Bank Ltd"},{"id":1725,"code":"090559","name":"Shield Microfinance Bank Ltd"},{"id":1397,"code":"090560","name":"TANADI MFB (CRUST)"},{"id":1724,"code":"090561","name":"Akuchukwu Microfinance Bank Ltd"},{"id":1723,"code":"090562","name":"Cedar Microfinance Bank Ltd"},{"id":1722,"code":"090563","name":"Balera Microfinance Bank Ltd"},{"id":1721,"code":"090564","name":"Supreme Microfinance Bank Ltd"},{"id":1720,"code":"090565","name":"Oke-Aro Oredegbe Microfinance Bank Ltd"},{"id":1719,"code":"090566","name":"Okuku Microfinance Bank Ltd"},{"id":1718,"code":"090567","name":"Orokam Microfinance Bank Ltd"},{"id":1717,"code":"090568","name":"Broadview Microfinance Bank Ltd"},{"id":1716,"code":"090569","name":"Qube Microfinance Bank Ltd"},{"id":1715,"code":"090570","name":"Iyamoye Microfinance Bank Ltd"},{"id":1714,"code":"090571","name":"Ilaro Poly Microfinance Bank Ltd"},{"id":1713,"code":"090572","name":"Ewt Microfinance Bank"},{"id":1712,"code":"090573","name":"Snow Microfinance Bank"},{"id":2039,"code":"090574","name":"GOLDMAN MICROFINANCE BANK"},{"id":1711,"code":"090575","name":"Firstmidas Microfinance Bank Ltd"},{"id":1710,"code":"090576","name":"Octopus Microfinance Bank Ltd"},{"id":1709,"code":"090578","name":"Iwade Microfinance Bank Ltd"},{"id":1708,"code":"090579","name":"Gbede Microfinance Bank"},{"id":1707,"code":"090580","name":"Otech Microfinance Bank Ltd"},{"id":2026,"code":"090581","name":"BANC CORP MICROFINANCE BANK"},{"id":2036,"code":"090583","name":"STATESIDE MFB"},{"id":2037,"code":"090584","name":"ISLAND MICROFINANCE BANK "},{"id":2041,"code":"090584","name":"Island MFB"},{"id":2038,"code":"090586","name":"GOMBE MICROFINANCE BANK LTD"},{"id":2040,"code":"090587","name":"Microbiz Microfinance Bank"},{"id":2043,"code":"090588","name":"Orisun MFB"},{"id":2011,"code":"090589","name":"Mercury MFB"},{"id":2044,"code":"090590","name":"WAYA MICROFINANCE BANK LTD"},{"id":2076,"code":"090590","name":"Waya Microfinance Bank"},{"id":2049,"code":"090591","name":"Gabsyn Microfinance Bank"},{"id":2046,"code":"090592","name":"KANO POLY MFB"},{"id":2047,"code":"090593","name":"TASUED MICROFINANCE BANK LTD"},{"id":2052,"code":"090598","name":"IBA MFB "},{"id":2051,"code":"090599","name":"Greenacres MFB"},{"id":2053,"code":"090600","name":"AVE MARIA MICROFINANCE BANK LTD"},{"id":2054,"code":"090602","name":"KENECHUKWU MICROFINANCE BANK"},{"id":2055,"code":"090603 ","name":"Macrod MFB"},{"id":2071,"code":"090606","name":"KKU Microfinance Bank"},{"id":2057,"code":"090608","name":"Akpo Microfinance Bank"},{"id":2058,"code":"090609","name":"Ummah Microfinance Bank "},{"id":2063,"code":"090610","name":"AMOYE MICROFINANCE BANK"},{"id":2059,"code":"090611","name":"Creditville Microfinance Bank"},{"id":2064,"code":"090612","name":"Medef Microfinance Bank"},{"id":2061,"code":"090613","name":"Total Trust Microfinance Bank"},{"id":2027,"code":"090614","name":"FLOURISH MFB"},{"id":2065,"code":"090615","name":"Beststar Microfinance Bank"},{"id":2066,"code":"090616","name":"RAYYAN Microfinance Bank"},{"id":2069,"code":"090620","name":"LOMA Microfinance Bank"},{"id":2070,"code":"090621","name":"GIDAUNIYAR ALHERI MICROFINANCE BANK"},{"id":2068,"code":"090623","name":"Mab Allianz MFB"},{"id":2297,"code":"090649","name":"CASHRITE MICROFINANCE BANK"},{"id":2295,"code":"090657","name":"PYRAMID MICROFINANCE BANK"},{"id":2296,"code":"090659","name":"MICHAEL OKPARA UNIAGRIC MICROFINANCE BANK"},{"id":231,"code":"100","name":"Suntrust Bank"},{"id":945,"code":"100001","name":"FET"},{"id":946,"code":"100003","name":"Parkway-ReadyCash"},{"id":1435,"code":"100004","name":"Opay"},{"id":947,"code":"100005","name":"Cellulant"},{"id":948,"code":"100006","name":"eTranzact"},{"id":949,"code":"100007","name":"Stanbic IBTC @ease wallet"},{"id":950,"code":"100008","name":"Ecobank Xpress Account"},{"id":951,"code":"100009","name":"GTMobile"},{"id":952,"code":"100010","name":"TeasyMobile"},{"id":953,"code":"100011","name":"Mkudi"},{"id":954,"code":"100012","name":"VTNetworks"},{"id":955,"code":"100013","name":"AccessMobile"},{"id":956,"code":"100014","name":"FBNMobile"},{"id":957,"code":"100015","name":"Kegow"},{"id":958,"code":"100016","name":"FortisMobile"},{"id":959,"code":"100017","name":"Hedonmark"},{"id":960,"code":"100018","name":"ZenithMobile"},{"id":824,"code":"100019","name":"Fidelity Mobile"},{"id":822,"code":"100020","name":"MoneyBox"},{"id":821,"code":"100021","name":"Eartholeum"},{"id":596,"code":"100022","name":"GoMoney"},{"id":820,"code":"100023","name":"TagPay"},{"id":834,"code":"100024","name":"Imperial Homes Mortgage Bank"},{"id":819,"code":"100025","name":"Zinternet Nigera Limited"},{"id":818,"code":"100026","name":"One Finance"},{"id":1158,"code":"100026","name":"Carbon"},{"id":813,"code":"100027","name":"Intellifin"},{"id":835,"code":"100028","name":"AG Mortgage Bank"},{"id":817,"code":"100029","name":"Innovectives Kesh"},{"id":816,"code":"100030","name":"EcoMobile"},{"id":815,"code":"100031","name":"FCMB Easy Account"},{"id":814,"code":"100032","name":"Contec Global Infotech Limited (NowNow)"},{"id":990,"code":"100033","name":"PALMPAY"},{"id":1434,"code":"100034","name":"ZENITH EAZY WALLET"},{"id":995,"code":"100035","name":"M36"},{"id":1433,"code":"100036","name":"Kegow(Chamsmobile)"},{"id":1432,"code":"100039","name":"PAYSTACK-TITAN"},{"id":1431,"code":"100052","name":"Beta-Access Yello"},{"id":18,"code":"101","name":"ProvidusBank PLC"},{"id":812,"code":"110001","name":"PayAttitude Online"},{"id":961,"code":"110002","name":"Flutterwave Technology Solutions Limited"},{"id":1430,"code":"110003","name":"Interswitch Limited"},{"id":2031,"code":"110004","name":"First Apple Limited"},{"id":1429,"code":"110005","name":"3Line Card Management Limited"},{"id":1428,"code":"110006","name":"Paystack Payments Limited"},{"id":1354,"code":"110007","name":"TeamApt"},{"id":1427,"code":"110008","name":"Kadick Integration Limited"},{"id":2032,"code":"110009","name":"Venture Garden Nigeria Limited"},{"id":1426,"code":"110010","name":"Interswitch Financial Inclusion Services (Ifis)"},{"id":1425,"code":"110011","name":"Arca Payments"},{"id":1424,"code":"110012","name":"Cellulant Pssp"},{"id":1423,"code":"110013","name":"Qr Payments"},{"id":2033,"code":"110014","name":"Cyberspace Limited"},{"id":1422,"code":"110015","name":"Vas2Nets Limited"},{"id":1421,"code":"110017","name":"Crowdforce"},{"id":1420,"code":"110018","name":"Microsystems Investment And Development Limited"},{"id":1419,"code":"110019","name":"Nibssussd Payments"},{"id":1418,"code":"110021","name":"Bud Infrastructure Limited"},{"id":1417,"code":"110022","name":"Koraypay"},{"id":1416,"code":"110023","name":"Capricorn Digital"},{"id":1415,"code":"110024","name":"Resident Fintech Limited"},{"id":1414,"code":"110025","name":"Netapps Technology Limited"},{"id":1413,"code":"110026","name":"Spay Business"},{"id":1412,"code":"110027","name":"Yello Digital Financial Services"},{"id":1411,"code":"110028","name":"Nomba Financial Services Limited"},{"id":1410,"code":"110029","name":"Woven Finance"},{"id":2062,"code":"110044","name":"Leadremit Limited"},{"id":997,"code":"120001","name":"9 Payment Service Bank"},{"id":1409,"code":"120002","name":"Hopepsb"},{"id":1408,"code":"120003","name":"Momo Psb"},{"id":1406,"code":"120004","name":"Smartcash Payment Service Bank"},{"id":1404,"code":"120005","name":"Money Master Psb"},{"id":6,"code":"214","name":"First City Monument Bank"},{"id":17,"code":"215","name":"Unity Bank PLC"},{"id":10,"code":"221","name":"Stanbic IBTC Bank"},{"id":12,"code":"232","name":"Sterling Bank PLC"},{"id":184,"code":"301","name":"Jaiz Bank"},{"id":965,"code":"303","name":"ChamsMobile"},{"id":784,"code":"305","name":"Paycom"},{"id":389,"code":"327","name":"Paga"},{"id":259,"code":"400001","name":"FSDH Merchant Bank"},{"id":260,"code":"502","name":"Rand merchant Bank"},{"id":252,"code":"608","name":"FINATRUST MICROFINANCE BANK"},{"id":2030,"code":"999001","name":"CBN_TSA"},{"id":962,"code":"999999","name":"NIP Virtual Bank"}]}
        
        ';
        // echo $bank;
        $banks = json_decode($bank);
        // print_r($banks);
        if(!empty($banks)){
            if($banks->status == 'success'){
                if(!empty($banks->data)){
                    foreach($banks->data as $ban){
                        if($this->Crud->check('code', $ban->code, 'bank') == 0){
                            $ins['code'] = $ban->code;
                            $ins['name'] = $ban->name;
                            
                            $this->Crud->create('bank', $ins);
                            
                        }
                    }
                }
            }
        }

        echo 'yey<br>';
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

    public function update(){
        $acc = $this->Crud->read('virtual_account');
        if(!empty($acc)){
            foreach($acc as $a){
                $data['beneficiary_account'] = NULL;
                $data['virtual_account_number'] = $a->acc_no;

                echo $this->Crud->update_squad('patch', 'virtual-account/update/beneficiary/account', $data);
            }
        }
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

    public function create_virtual(){
        $user_id = $this->session->get('td_id');
        $name = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
        $p_data['account_name']= $name;
		$p_data['bvn']= "";
		
        $resp = '';
        //Create Virtual Account
        if($this->Crud->check('user_id', $user_id, 'virtual_account') == 0){
            $virtual = $this->Crud->providus('post', 'PiPCreateReservedAccountNumber', $p_data);
            $virtuals =json_decode($virtual);
            if(empty($virtuals)){
                $resp = 'Refresh Page and Try Again';
            } else{
                if($virtuals->requestSuccessful == true){
                    $v_data['acc_no'] = $virtuals->account_number;
                    $v_data['user_id'] = $user_id;
                    $v_data['response'] = $virtual;
                    $v_data['reg_date'] = date(fdate);
                    $this->Crud->create('virtual_account',  $v_data);

                    if($this->Crud->check('user_id', $user_id, 'virtual_account') == 0){
						$virtual = $this->Crud->providus('post', 'PiPCreateReservedAccountNumber', $p_data);
						$virtuals =json_decode($virtual);
		
						if($virtuals->requestSuccessful == true){
							$v_data['acc_no'] = $virtuals->account_number;
							$v_data['user_id'] = $user_id;
							$v_data['response'] = $virtual;
							$v_data['reg_date'] = date(fdate);
							$this->Crud->create('virtual_account',  $v_data);

							$fullname  = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
							$phone  = $this->Crud->read_field('id', $user_id, 'user', 'phone');
							$email  = $this->Crud->read_field('id', $user_id, 'user', 'email');
							
						
							$first_msg = 'Hi '.ucwords($fullname).', Welcome to ZEND-TIDREMS. Your Tax ID is '.$virtuals->account_number.'. Kindly make your allocated tax payment to Account No: '.$virtuals->account_number.' (Providus Bank). Thank you. TIDREM Team';
                            $api_key = $this->Crud->read_field('name', 'termil_api', 'setting', 'value'); // pick from DB
						
                            if($phone) {
                                $phone = '234'.substr($phone,1);
                                $datass['to'] = $phone;
                                $datass['from'] = 'N-Alert';
                                $datass['sms'] = $first_msg;
                                $datass['api_key'] = $api_key;
                                $datass['type'] = 'plain';
                                $datass['channel'] = 'dnd';
                                $this->Crud->termii('post', 'sms/send', $datass);
                            }
					
							// send email
							if($email) {
								$data['email_address'] = $email;
								$this->Crud->send_email($email, 'Welcome Message', $first_msg);
							}
							$this->Crud->notify('0', $user_id, $first_msg, 'authentication', $user_id);


						}
					}

                    ///// store activities
                    
                    $action = $name.' Generated Virtual Account/Tax ID ';
                    $this->Crud->activity('profile', $user_id, $action);

                    $resp = $virtuals->account_number;
                } else {
                    $resp = 'Refresh Page and Try Again';
                }
            }
            
        }
        echo '<h5 class="nk-iv-wg1-info title m-2"  id="tax_id" onclick="copyToClipboard()"  style="font-weight:bold;cursor:pointer;">'.$resp.'</h5>';
    }

    public function create_virtuals($user_id){
        $name = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
        $p_data['account_name']= $name;
		$p_data['bvn']= "";
		
        $resp = '';
        //Create Virtual Account
        if($this->Crud->check('user_id', $user_id, 'virtual_account') == 0){
            $virtual = $this->Crud->providus('post', 'PiPCreateReservedAccountNumber', $p_data);
            $virtuals =json_decode($virtual);
            if(empty($virtuals)){
                $resp = 'Refresh Page and Try Again';
            } else{
                if($virtuals->requestSuccessful == true){
                    $v_data['acc_no'] = $virtuals->account_number;
                    $v_data['user_id'] = $user_id;
                    $v_data['response'] = $virtual;
                    $v_data['reg_date'] = date(fdate);
                    $this->Crud->create('virtual_account',  $v_data);

                    if($this->Crud->check('user_id', $user_id, 'virtual_account') == 0){
						$virtual = $this->Crud->providus('post', 'PiPCreateReservedAccountNumber', $p_data);
						$virtuals =json_decode($virtual);
		
						if($virtuals->requestSuccessful == true){
							$v_data['acc_no'] = $virtuals->account_number;
							$v_data['user_id'] = $user_id;
							$v_data['response'] = $virtual;
							$v_data['reg_date'] = date(fdate);
							$this->Crud->create('virtual_account',  $v_data);

							$fullname  = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
							$phone  = $this->Crud->read_field('id', $user_id, 'user', 'phone');
							$email  = $this->Crud->read_field('id', $user_id, 'user', 'email');
							
						
							$first_msg = 'Hi '.ucwords($fullname).', Welcome to ZEND-TIDREMS. Your Tax ID is '.$virtuals->account_number.'. Kindly make your allocated tax payment to Account No: '.$virtuals->account_number.' (Providus Bank). Thank you. TIDREM Team';
                            $api_key = $this->Crud->read_field('name', 'termil_api', 'setting', 'value'); // pick from DB
						
                            if($phone) {
                                $phone = '234'.substr($phone,1);
                                $datass['to'] = $phone;
                                $datass['from'] = 'N-Alert';
                                $datass['sms'] = $first_msg;
                                $datass['api_key'] = $api_key;
                                $datass['type'] = 'plain';
                                $datass['channel'] = 'dnd';
                                $this->Crud->termii('post', 'sms/send', $datass);
                            }
					
							// send email
							if($email) {
								$data['email_address'] = $email;
								$this->Crud->send_email($email, 'Welcome Message', $first_msg);
							}
							$this->Crud->notify('0', $user_id, $first_msg, 'authentication', $user_id);


						}
					}

                    ///// store activities
                    
                    $action = $name.' Generated Virtual Account/Tax ID ';
                    $this->Crud->activity('profile', $user_id, $action);

                    $resp = $virtuals->account_number;
                } else {
                    $resp = 'Refresh Page and Try Again';
                }
            }
            
        }
        echo '<h5 class="nk-iv-wg1-info title m-2"  id="tax_id" onclick="copyToClipboard()"  style="font-weight:bold;cursor:pointer;">'.$resp.'</h5>';
    }
    public function virtual(){
        $p_data['account_name']= 'Admin';
        $p_data['bvn']= "";
        $virtual = $this->Crud->providus('post', 'PiPCreateReservedAccountNumber', $p_data);
		echo $virtual;
    }

    public function metric(){
        $log_id = $this->session->get('td_id');
        
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));

        $remittance = 0;
        $total_paid = 0;
        $total_unpaid = 0;
        $wallet = 0;

        $date_type = $this->request->getPost('date_type');
		$lga_id = $this->request->getPost('lga_id');
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
			$start_date = date('2023-01-01');
			$end_date = date('Y-m-d');
		}
        
        $personal = 0;$business = 0;$field=0;$master=0;
        if($role == 'developer' || $role == 'administrator'){
            $users = $this->Crud->read_single('trade >', 0, 'user');
            
            $per_role = $this->Crud->read_field('name', 'Personal', 'access_role', 'id');
            $personal = $this->Crud->date_check1($start_date, 'reg_date', $end_date, 'reg_date', 'role_id', $per_role, 'user');
            $bus_role = $this->Crud->read_field('name', 'Business', 'access_role', 'id');
            $business = $this->Crud->date_check1($start_date, 'reg_date', $end_date, 'reg_date', 'role_id', $bus_role, 'user');
            $field_role = $this->Crud->read_field('name', 'Field Operative', 'access_role', 'id');
            $field = $this->Crud->date_check1($start_date, 'reg_date', $end_date, 'reg_date', 'role_id', $field_role, 'user');
            $master_role = $this->Crud->read_field('name', 'Tax Master', 'access_role', 'id');
            $master = $this->Crud->date_check1($start_date, 'reg_date', $end_date, 'reg_date', 'role_id', $master_role, 'user');
            
            if(!empty($users)){
                foreach($users as $u){
                    // echo $u->id.' ';
                    $remittance += (int)$this->Crud->read_field('id', $u->trade, 'trade', 'medium');
                    
                    
                }
            }

            $paids = $this->Crud->read('history');
            if(!empty($paids)){
                foreach($paids as $p){
                    $total_paid  += (float)$p->amount;
                }
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

        $total_unpaid = $remittance - $total_paid;


        
        $debit = 0;
        $credit = 0;

        $wallets = $this->Crud->read_single('user_id', $log_id, 'wallet');
        if(!empty($wallets)){
            foreach($wallets as $w){
                if($w->type == 'debit') {$debit += (float)$w->amount;}

				if($w->type == 'credit') {$credit += (float)$w->amount;}

            }
        }
        $bal = $credit - $debit;
        if($bal < 0)$bal = 0;
        $resp['personal'] = number_format($personal);
        $resp['business'] = number_format($business);
        $resp['master'] = number_format($master);
        $resp['field'] = number_format($field);
        $resp['remittance'] = number_format($remittance,2);
        $resp['total_paid'] = number_format($total_paid,2);
        $resp['total_unpaid'] = number_format($total_unpaid,2);

        
        echo json_encode($resp);
        die;
    }

    public function update_trans(){
        $response = $this->Crud->read('webhook');
        if(!empty($response)){
            foreach($response  as $resp){
                if(empty($resp->response))continue;
                
			    $body = json_decode($resp->response);

                $session_id = $body->sessionId;
				$settlement_id = $body->settlementId;
				$account_number = $body->accountNumber;
				$amount = $body->transactionAmount;
				$ref = $body->initiationTranRef;
				$remark = $body->tranRemarks;
				$trans_date = $body->tranDateTime;

                // echo $session_id.'<br> ';
				
                $post_datas['payment_method'] = 'bank';
                $post_datas['remark'] = $remark;
                $post_datas['ref'] = $ref;
                $post_datas['amount'] = $amount;
                $post_datas['session_id'] = $session_id;
                $post_datas['trans_date'] = $trans_date;
				$user_id = $this->Crud->read_field('acc_no', $account_number, 'virtual_account', 'user_id');

                //Save transaction in transaction table
               $this->Crud->api('post', 'payments/transaction/'.$user_id, $post_datas).'<br> ';
            }
        }
    }
    public function update_pay(){
        $history = $this->Crud->read('history');
        if(!empty($history)){
            foreach($history as $h){
                if($this->Crud->check('id', $h->user_id, 'user') > 0){
                    $id = $h->user_id;
                    $role_id = $this->Crud->read_field('id', $id, 'user', 'role_id');
                    $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
                    if($this->Crud->check2('user_id', $h->user_id, 'status', 'pending', 'transaction') == 0){
                        $tax_data['user_id'] = $id;
                        $tax_data['territory'] = $this->Crud->read_field('id', $id, 'user', 'territory');
                        $tax_data['lga_id'] = $this->Crud->read_field('id', $id, 'user', 'lga_id');
                        $trade = $this->Crud->read_field('id', $id, 'user', 'trade');
                        $trade_type = $this->Crud->read_field('id', $trade, 'trade', 'medium');
                        $duration = $this->Crud->read_field('id', $id, 'user', 'duration');
                        $tax_data['amount'] = $this->Crud->trade_duration($trade_type, $duration);
                        $tax_data['balance'] = $this->Crud->trade_duration($trade_type, $duration);	
                        $tax_data['reg_date'] = date(fdate);
                        $tax_data['payment_method'] = 'bank';
                        $tax_data['remark'] = 'Tax Payment';
                        $tax_data['payment_type'] = 'tax';
                        $days = "day"; $durs = '365';
                        if($duration == 'weekly')$days = "week";$durs = '52';
                        if($duration == 'monthly')$days = "month";$durs = '12';

                        if($role == 'personal' || $role == 'business'){
                            for ($i = 0; $i < $durs; $i++) {
                                $tax_data['payment_date'] = date('Y-m-d', strtotime(date(fdate).'+'.$i.' '.$days));
                                $ins = $this->Crud->create('transaction', $tax_data);
                            }
                        }
                    } 
                    
                    
                    $postData['payment_method'] = 'bank';
                    $postData['ref'] = $h->ref;
                    $postData['remark'] = 'Tax Payment';
                    $postData['amount'] = $h->amount;

                    //Perform operation on the ttransaction and pay tax
                    echo $this->Crud->api('post', 'payments/pay_tax/'.$id, $postData);

                }
            }
        }
    }

    public function role(){
       $user = $this->Crud->read_single('role_id', 0, 'user');
       if(!empty($user)){
        foreach($user as $u){
            $this->Crud->update('id', $u->id, 'user', array('role_id'=>4));
        }
       }
    }

    public function send_sms(){
        $date = '2024-01-06 12:00:21';
        $user = $this->Crud->date_range($date, 'reg_date', '2024-10-10', 'reg_date', 'user');
        if(!empty($user)){
            foreach($user as $u){
                $phone = $u->phone;

                $fullname = $u->fullname;
                $acc_no = $this->Crud->read_field('user_id', $u->id, 'virtual_account', 'virual_account');
                
                //Send Notification
                $first_msg = 'Dear '.ucwords($fullname).', you have successfully registered as a Tax Payer with Delta State Government. Your Tax ID is '.$acc_no.'. Kindly make your allocated tax payment to Account No: '.$acc_no.' (Providus Bank). Congratulations.';
                $api_key = $this->Crud->read_field('name', 'termil_api', 'setting', 'value'); // pick from DB
                
                if($phone) {
                    $phone = '234'.substr($phone,1);
                    $datass['to'] = $phone;
                    $datass['from'] = 'N-Alert';
                    $datass['sms'] = $first_msg;
                    $datass['api_key'] = $api_key;
                    $datass['type'] = 'plain';
                    $datass['channel'] = 'dnd';
                    $this->Crud->termii('post', 'sms/send', $datass);
                }
					
            }
        }
    }
}
