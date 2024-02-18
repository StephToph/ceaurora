<?php

namespace App\Controllers;

class Accounts extends BaseController {

	/////// ADMINISTRATORS
	public function administrator($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'accounts/administrator';

        $log_id = $this->session->get('td_id');
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, $mod, 'create');
        $role_r = $this->Crud->module($role_id, $mod, 'read');
        $role_u = $this->Crud->module($role_id, $mod, 'update');
        $role_d = $this->Crud->module($role_id, $mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }
        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;
       
        $data['current_language'] = $this->session->get('current_language');
		$table = 'user';
		$form_link = site_url($mod);
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
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}
					
					if($_POST){
						$del_id = $this->request->getPost('d_user_id');
						$code = $this->Crud->read_field('id', $del_id, 'user', 'fullname');
						if($this->Crud->delete('id', $del_id, $table) > 0) {
							echo $this->Crud->msg('success', translate_phrase('Record Deleted'));

							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$action = $by.' deleted Administrator ('.$code.')';
							$this->Crud->activity('user', $del_id, $action);

							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', translate_phrase('Please try later'));
						}
						exit;	
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
								$data['e_fullname'] = $e->fullname;
								$data['e_phone'] = $e->phone;
								$data['e_state_id'] = $e->state_id;
								$data['e_lga_id'] = $e->lga_id;
								$data['e_email'] = $e->email;
								$data['e_role_id'] = $e->role_id;
							}
						}
					}
				} 
				
				if($this->request->getMethod() == 'post'){
					$user_id = $this->request->getPost('user_id');
					$fullname = $this->request->getPost('name');
					$phone = $this->request->getPost('phone');
					$email = $this->request->getPost('email');
					$state_id = $this->request->getPost('state_id');
					$lga_id = $this->request->getPost('lga_id');
					$urole_id = $this->request->getPost('role_id');
					$password = $this->request->getPost('password');

					$ins_data['fullname'] = $fullname;
					$ins_data['email'] = $email;
					$ins_data['phone'] = $phone;
					$ins_data['country_id'] = 161;
					$ins_data['state_id'] = 316;
					$ins_data['lga_id'] = $lga_id;
					$ins_data['role_id'] = $urole_id;
					if($password) { $ins_data['password'] = md5($password); }
					
					// do create or update
					if($user_id) {
						$upd_rec = $this->Crud->updates('id', $user_id, $table, $ins_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', translate_phrase('Record Updated'));

							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$code = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
							$action = $by.' updated Administrator ('.$code.') Record';
							$this->Crud->activity('user', $user_id, $action);

							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', translate_phrase('No Changes'));	
						}
					} else {
						if($this->Crud->check('email', $email, $table) > 0 || $this->Crud->check('phone', $phone, $table) > 0) {
							echo $this->Crud->msg('warning', translate_phrase('Email and/or Phone Already Exist'));
						} else {
							$ins_data['activate'] = 1;
							$ins_data['is_staff'] = 1;
							$ins_data['reg_date'] = date(fdate);

							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', translate_phrase('Record Created'));

								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
								$code = $this->Crud->read_field('id', $ins_rec, 'user', 'fullname');
								$action = $by.' created Administrator ('.$code.')';
								$this->Crud->activity('user', $user_id, $action);

								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', translate_phrase('Please try later'));	
							}	
						}
					}
					exit;	
				}
			}
		}
		
		// record listing
		if($param1 == 'list') {
			// DataTable parameters
			$table = 'user';
			$column_order = array('fullname', 'email', 'phone', 'address', 'reg_date');
			$column_search = array('fullname', 'email', 'phone', 'address', 'reg_date');
			$order = array('id' => 'desc');
			$where = array('is_staff'=>1);
			
			// load data into table
			$list = $this->Crud->datatable_load($table, $column_order, $column_search, $order, $where);
			$data = array();
			// $no = $_POST['start'];
			$count = 1;
			foreach ($list as $item) {
				$id = $item->id;
				$fullname = $item->fullname;
				$email = $item->email;
				$phone = $item->phone;
				$address = $item->address;
				$state = $this->Crud->read_field('id', $item->state_id, 'state', 'name');
				$lga = $this->Crud->read_field('id', $item->lga_id, 'city', 'name');
				$img = $this->Crud->image($item->img_id, 'big');
				$srole = $this->Crud->read_field('id', $item->role_id, 'access_role', 'name');
				$reg_date = date('M d, Y h:i A', strtotime($item->reg_date));

				$img = '<div class="text-center"><div class="user-avatar"><img alt="" src="'.site_url($img).'" /></div></div>';
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						<a href="javascript:;" class="text-primary pop" pageTitle="Manage '.$fullname.'" pageName="'.site_url('accounts/administrator/manage/edit/'.$id).'">
							<i class="icon ni ni-edit"></i>
						</a>&nbsp;
						<a href="javascript:;" class="text-danger pop" pageTitle="Delete '.$fullname.'" pageName="'.site_url('accounts/administrator/manage/delete/'.$id).'">
							<i class="icon ni ni-trash"></i>
						</a>
					</div>
				';

				// if($log_id == $id) { $all_btn = ''; }
				
				$row = array();
				$row[] = $reg_date;
				$row[] = $img;
				$row[] = $fullname.'<div class="small text-primary"><b>'.$srole.'</b></div>';
				$row[] = $email;
				$row[] = $phone;
				$row[] = $state;
				$row[] = $lga;
				$row[] = $all_btn;

				$data[] = $row;
				$count += 1;
			}

			$output = array(
				"draw" => intval($_POST['draw']),
				"recordsTotal" => $this->Crud->datatable_count($table, $where),
				"recordsFiltered" => $this->Crud->datatable_filtered($table, $column_order, $column_search, $order, $where),
				"data" => $data,
			);
			
			//output to json format
			echo json_encode($output);
			exit;
		}

		// record listing
		if($param1 == 'load') {
			$limit = $param2;
			$offset = $param3;

			$rec_limit = 25;
			$item = '';
            if(empty($limit)) {$limit = $rec_limit;}
			if(empty($offset)) {$offset = 0;}
			
			if(!empty($this->request->getVar('start_date'))){$start_date = $this->request->getVar('start_date');}else{$start_date = '';}
			if(!empty($this->request->getVar('end_date'))){$end_date = $this->request->getVar('end_date');}else{$end_date = '';}

			if(!empty($this->request->getPost('state_id'))) { $state_id = $this->request->getPost('state_id'); } else { $state_id = ''; }
			if(!empty($this->request->getPost('status'))) { $status = $this->request->getPost('status'); } else { $status = ''; }
			$search = $this->request->getPost('search');

			if(empty($ref_status))$ref_status = 0;
			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Accounts').'</span></div>
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Contact').'</span></div>
					<div class="nk-tb-col tb-col-mb"><span class="sub-text">'.translate_phrase('Address').'</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Date Joined').'</span></div>
					<div class="nk-tb-col nk-tb-col-tools">
						<ul class="nk-tb-actions gx-1 my-n1">
							
						</ul>
					</div>
				</div><!-- .nk-tb-item -->
		
				
			';
			$a = 1;

            //echo $status;
			$log_id = $this->session->get('td_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				$role_id = $this->Crud->read_field('name', 'Administrator', 'access_role', 'id');

				$all_rec = $this->Crud->filter_admins('', '', $log_id, $status, $search, $start_date, $end_date);
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }

				$query = $this->Crud->filter_admins($limit, $offset, $log_id, $status, $search, $start_date, $end_date);
				$data['count'] = $counts;
				

				if(!empty($query)) {
					foreach ($query as $q) {
						$id = $q->id;
						$fullname = $q->fullname;
						$email = $q->email;
						$phone = $q->phone;
						$address = $q->address;
						$city = $this->Crud->read_field('id', $q->lga_id, 'city', 'name');
						$country = $this->Crud->read_field('id', $q->country_id, 'country', 'name');
						$img = $this->Crud->image($q->img_id, 'big');
						$activate = $q->activate;
						$u_role = $this->Crud->read_field('id', $q->role_id, 'access_role', 'name');
						$reg_date = date('M d, Y h:ia', strtotime($q->reg_date));

						$referral = '';
						
						$approved = '';
						if ($activate == 1) {
							$a_color = 'success';
							$approve_text = 'Account Activated';
							$approved = '<span class="text-primary"><i class="ri-check-circle-line"></i></span> ';
						} else {
							$a_color = 'danger';
							$approve_text = 'Account Deactivated';
							$approved = '<span class="text-danger"><i class="ri-check-circle-line"></i></span> ';
						}

						// add manage buttons
						if ($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<li><a href="' . site_url($mod . '/view/' . $id) . '" class="text-success" pageTitle="View ' . $fullname . '" pageName=""><em class="icon ni ni-eye"></em><span>'.translate_phrase('View Details').'</span></a></li>
								<li><a href="javascript:;" class="text-primary pop" pageTitle="Edit ' . $fullname . '" pageName="' . site_url($mod . '/manage/edit/' . $id) . '"><em class="icon ni ni-edit-alt"></em><span>'.translate_phrase('Edit').'</span></a></li>
								<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete ' . $fullname . '" pageName="' . site_url($mod . '/manage/delete/' . $id) . '"><em class="icon ni ni-trash-alt"></em><span>'.translate_phrase('Delete').'</span></a></li>
								
								
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-card">
										<div class="user-avatar ">
											<img alt="" src="' . site_url($img) . '" height="40px"/>
										</div>
										<div class="user-info">
											<span class="tb-lead">' . ucwords($fullname) . ' <span class="dot dot-' . $a_color . ' ms-1"></span></span>
											<span>' . $email . '</span><br>
											<span>' . $u_role . '</span>
										</div>
									</div>
								</div>
								<div class="nk-tb-col tb-col">
									<span class="text-dark"><b>' . $phone . '</b></span><br>
									'.$referral.'
								</div>
								<div class="nk-tb-col tb-col-mb">
									<span>' . ucwords($address) . '</span><br>
									<span class="text-info">' . $city. '</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="tb-amount">' . $reg_date . ' </span>
								</div>
								<div class="nk-tb-col nk-tb-col-tools">
									<ul class="nk-tb-actions gx-1">
										<li>
											<div class="drodown">
												<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
												<div class="dropdown-menu dropdown-menu-end">
													<ul class="link-list-opt no-bdr">
														' . $all_btn . '
													</ul>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div><!-- .nk-tb-item -->
						';
						$a++;
					}
				}
				
			}
			
			if(empty($item)) {
				$resp['item'] = $items.'
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="ni ni-users" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Administrator Account Returned').'
					</div>
				';
			} else {
				$resp['item'] = $items . $item;
				if($offset >= 25){
					$resp['item'] = $item;
				}
				
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

		if($param1 == 'manage') { // view for form data posting
			return view($mod.'_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'accounts/administrator/list'; // ajax table
			$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '1,6'; // sort disable columns (1,3,5)
		
			$data['title'] = translate_phrase('Administrators').' | '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
	}

	//Customer
	public function personal($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'accounts/personal';

        $log_id = $this->session->get('td_id');
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, $mod, 'create');
        $role_r = $this->Crud->module($role_id, $mod, 'read');
        $role_u = $this->Crud->module($role_id, $mod, 'update');
        $role_d = $this->Crud->module($role_id, $mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }
        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;
       
		if($this->Crud->check2('id', $log_id, 'setup', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
		if($this->Crud->check2('id', $log_id, 'trade', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
		$table = 'user';
		$form_link = site_url($mod);
		if($param1){$form_link .= '/'.$param1;}
		if($param2){$form_link .= '/'.$param2.'/';}
		if($param3){$form_link .= $param3;}
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		$data['form_link'] = $form_link;
        $data['current_language'] = $this->session->get('current_language');
		
		// manage record
		if($param1 == 'manage') {
			$role_ids =  $this->Crud->read_field('name', 'Personal', 'access_role', 'id');
						
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
                        $del_id =  $this->request->getVar('d_customer_id');
                        $role_id =  $this->Crud->read_field('name', 'Personal', 'access_role', 'id');
						$datas['role_id'] = $role_id;
                        $datas['log_id'] = $log_id;
                        
						// print_r($datas);
						// //$role_id . ' ' . $log_id;
						// die;
						
                        $del = $this->Crud->api('delete', 'users/delete/'.$del_id, $datas);

						$del = json_decode($del);
                        if($del->status == true){	
                        
							echo $this->Crud->msg($del->code, translate_phrase($del->msg));
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
								$data['e_fullname'] = $e->fullname;
								$data['e_email'] = $e->email;
								$data['e_phone'] = $e->phone;
								$data['e_country_id'] = $e->country_id;
								$data['e_state_id'] = $e->state_id;
								$data['e_role_id'] = $e->role_id;
								$data['e_trade'] = $e->trade;
								$data['e_address'] = $e->address;
								$data['e_activate'] = $e->activate;
								$data['e_img'] = $e->img_id;
								
							}
						}
					}
				}
				
				if($this->request->getMethod() == 'post'){
					$user_i =  $this->request->getVar('user_id');
					$fullname = $this->request->getPost('name');
					$phone = $this->request->getPost('phone');
					$email = $this->request->getPost('email');
					$password =  $this->request->getVar('password');
					$role =  $this->request->getVar('role');
					$ban =  $this->request->getVar('ban');
					$trade =  $this->request->getVar('trade');

					$data['trade'] = $trade;
					$data['role'] = $role;
					$data['password'] = $password;
					$data['fullname'] = $fullname;
					$data['email'] = $email;
					$data['phone'] = $phone;
					$data['ban'] = $ban;
                    $data['log_id'] = $log_id;
					$data['role_id'] = $role_ids;

					
					// do create or update
					if($user_i) {
						$trade_id = $this->Crud->read_field('id', $user_i, 'user', 'trade');
                        $update = $this->Crud->api('post', 'users/update/' . $user_i, $data);
                        $update = json_decode($update);
						//print_r($update);
						if($update->status == true){

							if($trade != $trade_id){
								if($this->Crud->check2('id', $user_i, 'duration', '', 'user') > 0){
									$this->Crud->updates('id', $user_i, 'user', array('setup'=> 0));
								} else {
									$trans = $this->Crud->read2('user_id', $user_i, 'status', 'pending', 'transaction');
									$duration = $this->Crud->read_field('id', $user_i, 'user', 'duration');
									$trades = $this->Crud->read_field('id', $trade, 'trade', 'medium');

									$amount = $this->Crud->trade_duration($trades, $duration);
									if(!empty($trans)){
										foreach($trans as $t){
											if($t->amount != $t->balance){
												$paid = (float)$t->amount - (float)$t->balance;
												$tran_data['balance'] = (float)$amount - (float)$paid;
											}else {
												$tran_data['balance'] = $amount;
											}
											$tran_data['amount'] = $amount;

											$this->Crud->updates('id', $t->id, 'transaction', $tran_data);
										}
									} else {
										$this->Crud->updates('id', $user_i, 'user', array('setup'=> 0));
									}
								}
							}
							
							echo $this->Crud->msg('success', translate_phrase($update->msg));
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg($update->code, translate_phrase($update->msg));	
						}
                        die;
					} else{
                        $add = $this->Crud->api('post', 'users/post', $data);
                        $add = json_decode($add);
						if($add->status == true){
							echo $this->Crud->msg('success', translate_phrase($add->msg));
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg($add->code, translate_phrase($add->msg));	
						}
                        die;
                    }
						
				}
			}
		}

        // record listing
		if($param1 == 'load') {
			$limit = $param2;
			$offset = $param3;

			$rec_limit = 25;
			$item = '';
            if(empty($limit)) {$limit = $rec_limit;}
			if(empty($offset)) {$offset = 0;}
			
			if(!empty($this->request->getVar('start_date'))){$start_date = $this->request->getVar('start_date');}else{$start_date = '';}
			if(!empty($this->request->getVar('end_date'))){$end_date = $this->request->getVar('end_date');}else{$end_date = '';}

			if(!empty($this->request->getPost('state_id'))) { $state_id = $this->request->getPost('state_id'); } else { $state_id = ''; }
			if(!empty($this->request->getPost('status'))) { $status = $this->request->getPost('status'); } else { $status = ''; }
			if(!empty($this->request->getPost('ref_status'))) { $ref_status = $this->request->getPost('ref_status'); } else { $ref_status = ''; }
			$search = $this->request->getPost('search');

			if(empty($ref_status))$ref_status = 0;
			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Accounts').'</span></div>
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Tax ID').'</span></div>
					<div class="nk-tb-col tb-col-mb"><span class="sub-text">'.translate_phrase('Territory').'</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Trade Line').'</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Status').'</span></div>
					<div class="nk-tb-col nk-tb-col-tools">
						<ul class="nk-tb-actions gx-1 my-n1">
							
						</ul>
					</div>
				</div><!-- .nk-tb-item -->
		
				
			';
			$a = 1;

            //echo $status;
			$log_id = $this->session->get('td_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				$role_id = $this->Crud->read_field('name', 'Personal', 'access_role', 'id');

				$all_rec = $this->Crud->filter_users('', '', '', $log_id, $role_id, $state_id, $status, $search, '', '', $start_date, $end_date);
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }

				$query = $this->Crud->filter_users($limit, $offset, '', $log_id, $role_id, $state_id, $status, $search, '', '', $start_date, $end_date);
				$data['count'] = $counts;
				

				if(!empty($query)) {
					foreach ($query as $q) {
						$id = $q->id;
						$fullname = $q->fullname;
						$email = $q->email;
						$phone = $q->phone;
						$territory = strtoupper(str_replace('_', ' ', $this->Crud->read_field('id', $q->territory, 'territory', 'name')));
						$tax_id = $this->Crud->read_field('user_id', $q->id, 'virtual_account', 'acc_no');
						$address = $q->address;
						$city = $this->Crud->read_field('id', $q->lga_id, 'city', 'name');
						$trade = $this->Crud->read_field('id', $q->trade, 'trade', 'name');
						$img = $this->Crud->image($q->img_id, 'big');
						$activate = $q->activate;
						$u_role = $this->Crud->read_field('id', $q->role_id, 'access_role', 'name');
						$reg_date = date('M d, Y h:ia', strtotime($q->reg_date));

						$status = '<span class="text-danger">Owing</span>';
						
						$next_pay = $this->Crud->read_field2('user_id', $id, 'payment_type', 'tax', 'transaction', 'payment_date');
						if(date(fdate) > $next_pay){
							$status = '<span class="text-success">Paid</span>';

						}

						if(empty($tax_id)){
							$tax_id = '
							<div id="virtual_resp_"'.$id.'>
								<button class="btn btn-info  m-2" onclick="virtual_create('.$id.');" type="button">Generate Virtual Account/Tax ID</button>
							</div>
							';
						}
						$approved = '';
						if ($activate == 1) {
							$a_color = 'success';
							$approve_text = 'Account Activated';
							$approved = '<span class="text-primary"><i class="ri-check-circle-line"></i></span> ';
						} else {
							$a_color = 'danger';
							$approve_text = 'Account Deactivated';
							$approved = '<span class="text-danger"><i class="ri-check-circle-line"></i></span> ';
						}

						// add manage buttons
						if ($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<li><a href="' . site_url($mod . '/view/' . $id) . '" class="text-success" pageTitle="View ' . $fullname . '" pageName=""><em class="icon ni ni-eye"></em><span>'.translate_phrase('View Details').'</span></a></li>
								<li><a href="javascript:;" class="text-primary pop" pageTitle="Edit ' . $fullname . '" pageName="' . site_url($mod . '/manage/edit/' . $id) . '"><em class="icon ni ni-edit-alt"></em><span>'.translate_phrase('Edit').'</span></a></li>
								<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete ' . $fullname . '" pageName="' . site_url($mod . '/manage/delete/' . $id) . '"><em class="icon ni ni-trash-alt"></em><span>'.translate_phrase('Delete').'</span></a></li>
								
								
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-card">
										<div class="user-avatar ">
											<img alt="" src="' . site_url($img) . '" height="40px"/>
										</div>
										<div class="user-info">
											<span class="tb-lead">' . ucwords($fullname) . ' <span class="dot dot-' . $a_color . ' ms-1"></span></span>
											<span>' . $email . '</span><br>
											<span>' . $u_role . '</span>
										</div>
									</div>
								</div>
								<div class="nk-tb-col tb-col">
									<span class="text-dark"><b>' . $tax_id . '</b></span>
								</div>
								<div class="nk-tb-col tb-col-mb">
									'.$address.'<br>
									<span>' . ucwords($city) . ', '.$territory.'</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="tb-amount">' . $trade . ' </span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="tb-amount">' . $status . ' </span>
								</div>
								<div class="nk-tb-col nk-tb-col-tools">
									<ul class="nk-tb-actions gx-1">
										<li>
											<div class="drodown">
												<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
												<div class="dropdown-menu dropdown-menu-end">
													<ul class="link-list-opt no-bdr">
														' . $all_btn . '
													</ul>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div><!-- .nk-tb-item -->
						';
						$a++;
					}
				}
				
			}
			
			if(empty($item)) {
				$resp['item'] = $items.'
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="ni ni-users" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Personal Account Returned').'
					</div>
				';
			} else {
				$resp['item'] = $items . $item;
				if($offset >= 25){
					$resp['item'] = $item;
				}
				
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

		if($param1 == 'view'){
			if($param2) {
				$user_id = $param2;
				$data['id'] = $user_id;
				$last_log = date('F, d Y h:ia',strtotime($this->Crud->read_field('id', $user_id, 'user', 'last_log')));
				if(empty($this->Crud->read_field('id', $user_id, 'user', 'last_log'))){
					$last_log = 'Not Logged In';
				}
				$data['last_log'] = $last_log;
				$data['fullname'] = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
				$role_id = $this->Crud->read_field('id', $user_id, 'user', 'role_id');
				$data['role'] = $this->Crud->read_field('id', $role_id, 'access_role', 'name');
				$data['v_phone'] = $this->Crud->read_field('id', $user_id, 'user', 'phone');
				$data['reg_date'] = date('F, d Y h:ia',strtotime($this->Crud->read_field('id', $user_id, 'user', 'reg_date')));
				$data['v_email'] = $this->Crud->read_field('id', $user_id, 'user', 'email');
				$data['tax_id'] = $this->Crud->read_field('user_id', $user_id, 'virtual_account', 'acc_no');
				$data['bank'] = $this->Crud->read_field('user_id', $user_id, 'account', 'bank').' '.$this->Crud->read_field('user_id', $user_id, 'account', 'account').' '.$this->Crud->read_field('user_id', $user_id, 'account', 'name');
						
				$v_img_id = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				if(!empty($v_img_id)){
					if(!file_exists($v_img_id)){
						$v_img_id = 'assets/images/avatar.png';
					}
					$img = '<img src="'.site_url($v_img_id).'">';
				} else {
					$img = $this->Crud->image_name($this->Crud->read_field('id', $user_id, 'user', 'fullname'));
				}
				$data['v_img'] = $img;

				$v_status = $this->Crud->read_field('id', $user_id, 'user', 'activate');
				if(!empty($v_status)) { $v_status = '<span class="text-success">VERIFIED</span>'; } else { $v_status = '<span class="text-danger">UNVERIFIED</span>'; }
				$data['v_status'] = $v_status;

				$data['v_address'] = $this->Crud->read_field('id', $user_id, 'user', 'address');

				$v_state_id = $this->Crud->read_field('id', $user_id, 'user', 'state_id');
				$data['v_state'] = $this->Crud->read_field('id', $v_state_id, 'state', 'name');
				$v_trade_id = $this->Crud->read_field('id', $user_id, 'user', 'trade');
				$data['v_trade'] = $this->Crud->read_field('id', $v_trade_id, 'trade', 'name');

				$v_country_id = $this->Crud->read_field('id', $user_id, 'user', 'country_id');
				$data['v_country'] = $this->Crud->read_field('id', $v_country_id, 'country', 'name');
				$v_city_id = $this->Crud->read_field('id', $user_id, 'user', 'lga_id');
				$data['v_city'] = $this->Crud->read_field('id', $v_city_id, 'city', 'name');
				$data['v_territory'] = $this->Crud->read_field('id', $this->Crud->read_field('id', $user_id, 'user', 'territory'), 'territory', 'name');
				$data['v_duration'] = $this->Crud->read_field('id', $user_id, 'user', 'duration');
				$data['v_master_id'] = $this->Crud->read_field('id', $user_id, 'user', 'master_id');
				
				$data['email'] = $this->Crud->read_field('id', $user_id, 'user', 'email');
				$data['tax_id'] = $this->Crud->read_field('user_id', $user_id, 'virtual_account', 'acc_no');
				$data['fullname'] = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
				$data['sms'] = $this->Crud->read_field('id', $user_id, 'user', 'receive_message');
				$data['address'] = $this->Crud->read_field('id', $user_id, 'user', 'address');
				$data['territory'] = str_replace('_', ' ',$this->Crud->read_field('id', $user_id, 'user', 'territory'));
				$utilitys = $this->Crud->read_field('id', $user_id, 'user', 'utility');
				$id_cards = $this->Crud->read_field('id', $user_id, 'user', 'id_card');
				$trade_id = $this->Crud->read_field('id', $user_id, 'user', 'trade');
				$data['trade'] = $this->Crud->read_field('id', $user_id, 'trade', 'name');
				$passports = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				$data['phone'] = $this->Crud->read_field('id', $user_id, 'user', 'phone');
				$data['duration'] = $this->Crud->read_field('id', $user_id, 'user', 'duration');
				$data['lga_id'] = $this->Crud->read_field('id', $user_id, 'user', 'lga_id');
				$data['state_id'] = $this->Crud->read_field('id', $user_id, 'user', 'state_id');
				$data['country_id'] = $this->Crud->read_field('id', $user_id, 'user', 'country_id');
				$qrcodes = $this->Crud->read_field('id', $user_id, 'user', 'qrcode');
				$img_id = $this->Crud->read_field('id', $user_id, 'user', 'img_id');


				$qrcode = '--';
				// echo $qrcodes;
				if(!empty($qrcodes) && file_exists($qrcodes)){
					$qrcode = '<img height="150" src="'.site_url($qrcodes).'"> ';
				}

				$utility = 'No Utility Document Uploaded';
				if(!empty($utilitys) && file_exists($utilitys)){
					$utility = '<img height="150" src="'.site_url($utilitys).'"> ';
				}

				$id_card = 'No Valid ID Card Document Uploaded';
				if(!empty($id_cards) && file_exists($id_cards)){
					$id_card = '<img height="150" src="'.site_url($id_cards).'"> ';
				}
				
				$passport = 'No Passport Uploaded';
				if(!empty($passports) && file_exists($passports)){
					$passport = '<img height="150" src="'.site_url($passports).'"> ';
				}

				$data['utility'] = $utility;
				$data['id_card'] = $id_card;
				$data['passport'] = $passport;
				$data['qrcode'] = $qrcode;
				

				$data['img_id'] = $passports;
				// $data['img'] = $this->Crud->image($img_id, 'big');
        
				$data['v_id_card'] = $this->Crud->read_field('id', $user_id, 'user', 'id_card');
				
				$data['v_passport'] = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				
				$data['v_utility'] = $this->Crud->read_field('id', $user_id, 'user', 'utility');
				$data['v_qrcode'] = $this->Crud->read_field('id', $user_id, 'user', 'qrcode');
				$data['v_business_name'] = $this->Crud->read_field('id', $user_id, 'user', 'business_name');
				$data['v_business_address'] = $this->Crud->read_field('id', $user_id, 'user', 'business_address');
			}
			$data['title'] = translate_phrase('Account View').' | '.app_name;
			$data['page_active'] = $mod;
			return view($mod.'_view', $data);
		}
		if($param1 == 'manage') { // view for form data posting
			return view($mod.'_form', $data);
		} else { // view for main page
			
			$data['title'] = translate_phrase('Personal Account').' | '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }

	//Vendor
	public function business($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'accounts/business';

        $log_id = $this->session->get('td_id');
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, $mod, 'create');
        $role_r = $this->Crud->module($role_id, $mod, 'read');
        $role_u = $this->Crud->module($role_id, $mod, 'update');
        $role_d = $this->Crud->module($role_id, $mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }
        $data['log_id'] = $log_id;
        $data['current_language'] = $this->session->get('current_language');
        $data['role'] = $role;
        $data['role_c'] = $role_c;
		if($this->Crud->check2('id', $log_id, 'setup', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
		if($this->Crud->check2('id', $log_id, 'trade', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
       
		$table = 'user';
		$form_link = site_url($mod);
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
                        $role_id =  $this->Crud->read_field('name', 'Business', 'access_role', 'id');
						$datas['role_id'] = $role_id;
                        $datas['log_id'] = $log_id;
                        
						// print_r($datas);
						// //$role_id . ' ' . $log_id;
						// die;
						
                        $del = $this->Crud->api('delete', 'users/delete/'.$del_id, $datas);

						$del = json_decode($del);
                        if($del->status == true){	
                        
							echo $this->Crud->msg($del->code, translate_phrase($del->msg));
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
								$data['e_trade'] = $e->trade;
							}
						}
						
					}
				}
				
				if($this->request->getMethod() == 'post'){
					$user_i = $this->request->getPost('user_id');
					$role = $this->request->getPost('role');
					$password = $this->request->getPost('password');
					$trade = $this->request->getPost('trade');
					
					$role_ids =  $this->Crud->read_field('name', 'Business', 'access_role', 'id');
			
					if($this->request->getPost('ban')) { $set_activate = 1; } else { $set_activate = 0; }
					
					$data['password'] = md5($password);
					$data['activate'] = $set_activate;
					$data['trade'] = $trade;
					$data['role'] = $role;
					$data['role_id'] = $role_ids;
					
					
					// do create or update
					if($user_i) {
						$trade_id = $this->Crud->read_field('id', $user_i, 'user', 'trade');
                        $update = $this->Crud->api('post', 'users/update/' . $user_i, $data);
                        $update = json_decode($update);
						
						if($update->status == true){
							if($trade != $trade_id){
								if($this->Crud->check2('id', $user_i, 'duration', '', 'user') > 0){
									$this->Crud->updates('id', $user_i, 'user', array('setup'=> 0));
								} else {
									$trans = $this->Crud->read2('user_id', $user_i, 'status', 'pending', 'transaction');
									$duration = $this->Crud->read_field('id', $user_i, 'user', 'duration');
									$trades = $this->Crud->read_field('id', $trade, 'trade', 'medium');

									$amount = $this->Crud->trade_duration($trades, $duration);
									if(!empty($trans)){
										foreach($trans as $t){
											if($t->amount != $t->balance){
												$paid = (float)$t->amount - (float)$t->balance;
												$tran_data['balance'] = (float)$amount - (float)$paid;
											}else {
												$tran_data['balance'] = $amount;
											}
											$tran_data['amount'] = $amount;

											$this->Crud->updates('id', $t->id, 'transaction', $tran_data);
										}
									} else {
										$this->Crud->updates('id', $user_i, 'user', array('setup'=> 0));
									}
								}
							}
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


        // record listing
		if($param1 == 'load') {
			$limit = $param2;
			$offset = $param3;

			$rec_limit = 25;
			$item = '';
            if(empty($limit)) {$limit = $rec_limit;}
			if(empty($offset)) {$offset = 0;}
			
			if(!empty($this->request->getPost('state_id'))) { $state_id = $this->request->getPost('state_id'); } else { $state_id = ''; }
			if(!empty($this->request->getPost('status'))) { $status = $this->request->getPost('status'); } else { $status = ''; }
			if(!empty($this->request->getPost('ref_status'))) { $ref_status = $this->request->getPost('ref_status'); } else { $ref_status = ''; }
			if(!empty($this->request->getPost('verify'))) { $verify = $this->request->getPost('verify'); } else { $verify = ''; }
			$search = $this->request->getPost('search');
			if(!empty($this->request->getVar('start_date'))){$start_date = $this->request->getVar('start_date');}else{$start_date = '';}
			if(!empty($this->request->getVar('end_date'))){$end_date = $this->request->getVar('end_date');}else{$end_date = '';}


			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Accounts').'</span></div>
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Tax ID').'</span></div>
					<div class="nk-tb-col tb-col-mb"><span class="sub-text">'.translate_phrase('Territory').'</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Trade Line').'</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Status').'</span></div>
					<div class="nk-tb-col nk-tb-col-tools">
						<ul class="nk-tb-actions gx-1 my-n1">
							
						</ul>
					</div>
				</div><!-- .nk-tb-item -->
		
				
			';
			$a = 1;

            //echo $status;
			$log_id = $this->session->get('td_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				$role_id = $this->Crud->read_field('name', 'Business', 'access_role', 'id');


				$all_rec = $this->Crud->filter_users('', '', '', $log_id, $role_id, $state_id, $status, $search, '', '', $start_date, $end_date);
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }

				$query = $this->Crud->filter_users($limit, $offset, '', $log_id, $role_id, $state_id, $status, $search, '', '', $start_date, $end_date);
				$data['count'] = $counts;

				if(!empty($query)) {
					foreach ($query as $q) {
						$id = $q->id;
						$fullname = $q->fullname;
						$email = $q->email;
						$phone = $q->phone;
						$territory = strtoupper(str_replace('_', ' ', $this->Crud->read_field('id', $q->territory, 'territory', 'name')));
						$tax_id = $this->Crud->read_field('user_id', $q->id, 'virtual_account', 'acc_no');
						$address = $q->address;
						$city = $this->Crud->read_field('id', $q->lga_id, 'city', 'name');
						$trade = $this->Crud->read_field('id', $q->trade, 'trade', 'name');
						$img = $this->Crud->image($q->img_id, 'big');
						$activate = $q->activate;
						$u_role = $this->Crud->read_field('id', $q->role_id, 'access_role', 'name');
						$reg_date = date('M d, Y h:ia', strtotime($q->reg_date));

						$status = '<span class="text-danger">Owing</span>';

						$referral = '';
						$next_pay = $this->Crud->read_fields2('user_id', $id, 'payment_type', 'tax', 'transaction', 'payment_date');
						if(date(fdate) <= $next_pay){
							$status = '<span class="text-success">Paid</span>';

						}
						$approved = '';
						if ($activate == 1) {
							$a_color = 'success';
							$approve_text = 'Account Activated';
							$approved = '<span class="text-primary"><i class="ri-check-circle-line"></i></span> ';
						} else {
							$a_color = 'danger';
							$approve_text = 'Account Deactivated';
							$approved = '<span class="text-danger"><i class="ri-check-circle-line"></i></span> ';
						}

						// add manage buttons
						if ($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<li><a href="' . site_url($mod . '/view/' . $id) . '" class="text-success" pageTitle="View ' . $fullname . '" pageName=""><em class="icon ni ni-eye"></em><span>'.translate_phrase('View Details').'</span></a></li>
								<li><a href="javascript:;" class="text-primary pop" pageTitle="Edit ' . $fullname . '" pageName="' . site_url($mod . '/manage/edit/' . $id) . '"><em class="icon ni ni-edit-alt"></em><span>'.translate_phrase('Edit').'</span></a></li>
								<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete ' . $fullname . '" pageName="' . site_url($mod . '/manage/delete/' . $id) . '"><em class="icon ni ni-trash-alt"></em><span>'.translate_phrase('Delete').'</span></a></li>
								
								
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-card">
										<div class="user-avatar ">
											<img alt="" src="' . site_url($img) . '" height="40px"/>
										</div>
										<div class="user-info">
											<span class="tb-lead">' . ucwords($fullname) . ' <span class="dot dot-' . $a_color . ' ms-1"></span></span>
											<span>' . $email . '</span><br>
											<span>' . $u_role . '</span>
										</div>
									</div>
								</div>
								<div class="nk-tb-col tb-col">
									<span class="text-dark"><b>' . $tax_id . '</b></span>
								</div>
								<div class="nk-tb-col tb-col-mb">
								'.$address.'<br>
									<span>' . ucwords($city) . ', '.$territory.'</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="tb-amount">' . $trade . ' </span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="tb-amount">' . $status . ' </span>
								</div>
								<div class="nk-tb-col nk-tb-col-tools">
									<ul class="nk-tb-actions gx-1">
										<li>
											<div class="drodown">
												<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
												<div class="dropdown-menu dropdown-menu-end">
													<ul class="link-list-opt no-bdr">
														' . $all_btn . '
													</ul>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div><!-- .nk-tb-item -->
						';
						$a++;
					}
				}
				
				
			}
			
			if(empty($item)) {
				$resp['item'] = $items.'
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="ni ni-users" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Business Account Returned').'
					</div>
				';
			} else {
				$resp['item'] = $items . $item;
				if($offset >= 25){
					$resp['item'] = $item;
				}
				
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

		if($param1 == 'view'){
			if($param2) {
				$user_id = $param2;
				$data['id'] = $user_id;
				$last_log = date('F, d Y h:ia',strtotime($this->Crud->read_field('id', $user_id, 'user', 'last_log')));
				if(empty($this->Crud->read_field('id', $user_id, 'user', 'last_log'))){
					$last_log = 'Not Logged In';
				}
				$data['last_log'] = $last_log;
				$data['fullname'] = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
				$role_id = $this->Crud->read_field('id', $user_id, 'user', 'role_id');
				$data['role'] = $this->Crud->read_field('id', $role_id, 'access_role', 'name');
				$data['v_phone'] = $this->Crud->read_field('id', $user_id, 'user', 'phone');
				$data['reg_date'] = date('F, d Y h:ia',strtotime($this->Crud->read_field('id', $user_id, 'user', 'reg_date')));
				$data['v_email'] = $this->Crud->read_field('id', $user_id, 'user', 'email');
				$data['tax_id'] = $this->Crud->read_field('user_id', $user_id, 'virtual_account', 'acc_no');
				$data['bank'] = $this->Crud->read_field('user_id', $user_id, 'account', 'bank').' '.$this->Crud->read_field('user_id', $user_id, 'account', 'account').' '.$this->Crud->read_field('user_id', $user_id, 'account', 'name');

				
				$data['email'] = $this->Crud->read_field('id', $user_id, 'user', 'email');
				$data['tax_id'] = $this->Crud->read_field('user_id', $user_id, 'virtual_account', 'acc_no');
				$data['fullname'] = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
				$data['sms'] = $this->Crud->read_field('id', $user_id, 'user', 'receive_message');
				$data['address'] = $this->Crud->read_field('id', $user_id, 'user', 'address');
				$data['territory'] = str_replace('_', ' ',$this->Crud->read_field('id', $user_id, 'user', 'territory'));
				$utilitys = $this->Crud->read_field('id', $user_id, 'user', 'utility');
				$id_cards = $this->Crud->read_field('id', $user_id, 'user', 'id_card');
				$trade_id = $this->Crud->read_field('id', $user_id, 'user', 'trade');
				$data['trade'] = $this->Crud->read_field('id', $user_id, 'trade', 'name');
				$passports = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				$data['phone'] = $this->Crud->read_field('id', $user_id, 'user', 'phone');
				$data['duration'] = $this->Crud->read_field('id', $user_id, 'user', 'duration');
				$data['lga_id'] = $this->Crud->read_field('id', $user_id, 'user', 'lga_id');
				$data['state_id'] = $this->Crud->read_field('id', $user_id, 'user', 'state_id');
				$data['country_id'] = $this->Crud->read_field('id', $user_id, 'user', 'country_id');
				$qrcodes = $this->Crud->read_field('id', $user_id, 'user', 'qrcode');
				$img_id = $this->Crud->read_field('id', $user_id, 'user', 'img_id');


				$qrcode = '--';
				// echo $qrcodes;
				if(!empty($qrcodes) && file_exists($qrcodes)){
					$qrcode = '<img height="150" src="'.site_url($qrcodes).'"> ';
				}

				$utility = 'No Utility Document Uploaded';
				if(!empty($utilitys) && file_exists($utilitys)){
					$utility = '<img height="150" src="'.site_url($utilitys).'"> ';
				}

				$id_card = 'No Valid ID Card Document Uploaded';
				if(!empty($id_cards) && file_exists($id_cards)){
					$id_card = '<img height="150" src="'.site_url($id_cards).'"> ';
				}
				
				$passport = 'No Passport Uploaded';
				if(!empty($passports) && file_exists($passports)){
					$passport = '<img height="150" src="'.site_url($passports).'"> ';
				}

				$data['utility'] = $utility;
				$data['id_card'] = $id_card;
				$data['passport'] = $passport;
				$data['qrcode'] = $qrcode;
				

				$data['img_id'] = $passports;
				// $data['img'] = $this->Crud->image($img_id, 'big');
        
				$v_img_id = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				if(!empty($v_img_id)){
					if(!file_exists($v_img_id)){
						$v_img_id = 'assets/images/avatar.png';
					}
					$img = '<img src="'.site_url($v_img_id).'">';
				} else {
					$img = $this->Crud->image_name($this->Crud->read_field('id', $user_id, 'user', 'fullname'));
				}
				$data['v_img'] = $img;

				$v_status = $this->Crud->read_field('id', $user_id, 'user', 'activate');
				if(!empty($v_status)) { $v_status = '<span class="text-success">VERIFIED</span>'; } else { $v_status = '<span class="text-danger">UNVERIFIED</span>'; }
				$data['v_status'] = $v_status;

				$data['v_address'] = $this->Crud->read_field('id', $user_id, 'user', 'address');

				$v_state_id = $this->Crud->read_field('id', $user_id, 'user', 'state_id');
				$data['v_state'] = $this->Crud->read_field('id', $v_state_id, 'state', 'name');
				$v_trade_id = $this->Crud->read_field('id', $user_id, 'user', 'trade');
				$data['v_trade'] = $this->Crud->read_field('id', $v_trade_id, 'trade', 'name');

				$v_country_id = $this->Crud->read_field('id', $user_id, 'user', 'country_id');
				$data['v_country'] = $this->Crud->read_field('id', $v_country_id, 'country', 'name');
				$v_city_id = $this->Crud->read_field('id', $user_id, 'user', 'lga_id');
				$data['v_city'] = $this->Crud->read_field('id', $v_city_id, 'city', 'name');
				$data['v_territory'] = $this->Crud->read_field('id', $this->Crud->read_field('id', $user_id, 'user', 'territory'), 'territory', 'name');
				$data['v_duration'] = $this->Crud->read_field('id', $user_id, 'user', 'duration');
				$data['v_master_id'] = $this->Crud->read_field('id', $user_id, 'user', 'master_id');
				
				
				$data['v_id_card'] = $this->Crud->read_field('id', $user_id, 'user', 'id_card');
				
				$data['v_passport'] = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				
				$data['v_utility'] = $this->Crud->read_field('id', $user_id, 'user', 'utility');
				$data['v_qrcode'] = $this->Crud->read_field('id', $user_id, 'user', 'qrcode');
				$data['v_business_name'] = $this->Crud->read_field('id', $user_id, 'user', 'business_name');
				$data['v_business_address'] = $this->Crud->read_field('id', $user_id, 'user', 'business_address');
			}
			$data['title'] = translate_phrase('Account View').' | '.app_name;
			$data['page_active'] = $mod;
			return view($mod.'_view', $data);
		}
		if($param1 == 'manage') { // view for form data posting
			return view($mod.'_form', $data);
		} else { // view for main page
			
			$data['title'] = translate_phrase('Business Account').' | '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }

	public function master($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'accounts/master';

        $log_id = $this->session->get('td_id');
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, $mod, 'create');
        $role_r = $this->Crud->module($role_id, $mod, 'read');
        $role_u = $this->Crud->module($role_id, $mod, 'update');
        $role_d = $this->Crud->module($role_id, $mod, 'delete');
		if($this->Crud->check2('id', $log_id, 'setup', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
		if($this->Crud->check2('id', $log_id, 'trade', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }
        $data['log_id'] = $log_id;
        $data['current_language'] = $this->session->get('current_language');
        $data['role'] = $role;
        $data['role_c'] = $role_c;
       
		$table = 'user';
		$form_link = site_url($mod);
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
                        $del_id =  $this->request->getVar('d_master_id');
                        $role_id =  $this->Crud->read_field('name', 'Tax Master', 'access_role', 'id');
						$datas['role_id'] = $role_id;
                        $datas['log_id'] = $log_id;
                        
						// print_r($datas);
						// //$role_id . ' ' . $log_id;
						// die;
						
                        $del = $this->Crud->api('delete', 'users/delete/'.$del_id, $datas);

						$del = json_decode($del);
                        if($del->status == true){	
                        
							echo $this->Crud->msg($del->code, translate_phrase($del->msg));
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
								$data['e_fullname'] = $e->fullname;
								$data['e_phone'] = $e->phone;
								$data['e_state_id'] = $e->state_id;
								$data['e_lga_id'] = $e->lga_id;
								$data['e_email'] = $e->email;
								$data['e_activate'] = $e->activate;
								$data['e_territory'] = $e->territory;
								$data['e_passport'] = $e->passport;
								$data['e_id_card'] = $e->id_card;
								$data['e_utility'] = $e->utility;
								$data['e_bank_code'] = $this->Crud->read_field('user_id', $e->id, 'account', 'code');
								$data['e_account_name'] = $this->Crud->read_field('user_id', $e->id, 'account', 'name');
								$data['e_account'] = $this->Crud->read_field('user_id', $e->id, 'account', 'account');
							}
						}
						
					}
				}
				
				if($this->request->getMethod() == 'post'){
					$master_id = $this->request->getPost('master_id');
					$fullname = $this->request->getPost('name');
					$phone = $this->request->getPost('phone');
					$email = $this->request->getPost('email');
					$state_id = $this->request->getPost('state_id');
					$lga_id = $this->request->getPost('lga_id');
					$territory = $this->request->getPost('territory');
					$passport = $this->request->getPost('passport');
					$id_card = $this->request->getPost('id_card');
					$utility = $this->request->getPost('utility');
					$account_name = $this->request->getPost('account_name');
					$bank = $this->request->getPost('bank');
					$account = $this->request->getPost('account');
					$password = $this->request->getPost('password');
					

					$ins_data['fullname'] = $fullname;
					$ins_data['email'] = $email;
					$ins_data['phone'] = $phone;
					$ins_data['territory'] = json_encode($territory);
					$ins_data['country_id'] = 161;
					$ins_data['state_id'] = 316;
					$ins_data['lga_id'] = $lga_id;
					$ins_data['role_id'] = $this->Crud->read_field('name', 'Tax Master', 'access_role', 'id');

					if($password) { $ins_data['password'] = md5($password); }
					// $lga_territ

					// if($this->Crud->check2('id', $lga_id, 'territory', $territory, 'city') == 0){
					// 	echo $this->Crud->msg('warning', 'LGA selected is not under the Territory Selected');
					// 	die;
					// }
					//// Passport upload
					if(file_exists($this->request->getFile('passports'))) {
						$path = 'assets/images/users/tax_master/';
						$file = $this->request->getFile('passports');
						$getImg = $this->Crud->img_upload($path, $file);
						
						$passport = $getImg->path;
					}

					//// ID Card upload
					if(file_exists($this->request->getFile('id_cards'))) {
						$path = 'assets/images/users/tax_master/';
						$file = $this->request->getFile('id_cards');
						$getImg = $this->Crud->img_upload($path, $file);
						
						$id_card = $getImg->path;
					}

					//// Utility upload
					if(file_exists($this->request->getFile('utilitys'))) {
						$path = 'assets/images/users/tax_master/';
						$file = $this->request->getFile('utilitys');
						$getImg = $this->Crud->img_upload($path, $file);
						
						$utility = $getImg->path;
					}

					// if(empty($passport) || empty($id_card) || empty($utility)){
					// 	echo $this->Crud->msg('danger', 'All Documents are Required to be Uploaded');
					// 	die;
					// }

					
					$ins_data['passport'] = $passport;
					$ins_data['utility'] = $utility;
					$ins_data['id_card'] = $id_card;
		
					// do create or update
					if($master_id) {
						$upd_rec = $this->Crud->updates('id', $master_id, $table, $ins_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', translate_phrase('Record Updated'));

							$b_data['code'] = $bank;
							$b_data['account'] = $account;
							$b_data['name'] = $account_name;
							$b_data['bank'] = $this->Crud->read_field('code' , $bank, 'bank', 'name');
							if($this->Crud->check('user_id', $master_id, 'account') > 0){
								$this->Crud->updates('user_id', $master_id, 'account', $b_data);
							} else {
								
								$b_data['user_id'] = $master_id;
								$this->Crud->create('account', $b_data);
							}
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$code = $this->Crud->read_field('id', $master_id, 'user', 'fullname');
							$action = $by.' updated Tax Master ('.$code.') Record';
							$this->Crud->activity('user', $master_id, $action);

							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', translate_phrase('No Changes'));	
						}
					} else {
						if($this->Crud->check('email', $email, $table) > 0 || $this->Crud->check('phone', $phone, $table) > 0) {
							echo $this->Crud->msg('warning', translate_phrase('Email and/or Phone Already Exist'));
						} else {
							$ins_data['activate'] = 1;
							$ins_data['reg_date'] = date(fdate);

							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', translate_phrase('Record Created'));

								$b_data['code'] = $bank;
								$b_data['account'] = $account;
								$b_data['name'] = $account_name;
								$b_data['bank'] = $this->Crud->read_field('code' , $bank, 'bank', 'name');
								if($this->Crud->check('user_id', $ins_rec, 'account') > 0){
									$this->Crud->updates('user_id', $ins_rec, 'account', $b_data);
								} else {
									
									$b_data['user_id'] = $ins_rec;
									$this->Crud->create('account', $b_data);
								}

								$user_id = $ins_rec;
								if(!empty($user_id)){
									$link = site_url('auth/profile_view/') .$user_id;
									$qr = $this->qrcode($link);
									$path = $qr['file'];
									$this->Crud->updates('id', $user_id, 'user', array('qrcode'=>$path));
								}
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
								$code = $this->Crud->read_field('id', $ins_rec, 'user', 'fullname');
								$action = $by.' created Tax Master ('.$code.')';
								$this->Crud->activity('user', $ins_rec, $action);

								$body = '
									Dear '.$fullname.', <br><br>
										A Tax Master Account Has been Created with This Email;<br>
										Below are the login Credentials:<br><br>

										Email: '.$email.'<br>
										Phone: '.$phone.'<br>
										Password: '.$password.'
										
								';
								$sms_body = '
									Dear '.$fullname.', A Tax Master Account Has been Created with This Email. Your login Credentials are; 
										Email: {'.$email.'}, Phone: {'.$phone.'}, Password: {'.$password.'}
										
								';

								$api_key = $this->Crud->read_field('name', 'termil_api', 'setting', 'value'); // pick from DB
							
								if($phone) {
									$phone = '234'.substr($phone,1);
									$datass['to'] = $phone;
									$datass['from'] = 'TIDREM';
									$datass['sms'] = $sms_body;
									$datass['api_key'] = $api_key;
									$datass['type'] = 'plain';
									$datass['channel'] = 'generic';
									$this->Crud->termii('post', 'sms/send', $datass);
								}
						
								// send email
								if($email) {
									$data['email_address'] = $email;
									$this->Crud->send_email($email, 'Tax Master Account', $body);
								}
								$this->Crud->notify('0', $ins_rec, $body, 'authentication', $user_id);


								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', translate_phrase('Please try later'));	
							}	
						}
					}
					exit;	
				}
			}
		}


        // record listing
		if($param1 == 'load') {
			$limit = $param2;
			$offset = $param3;

			$rec_limit = 25;
			$item = '';
            if(empty($limit)) {$limit = $rec_limit;}
			if(empty($offset)) {$offset = 0;}
			
			$search = $this->request->getPost('search');
			if(!empty($this->request->getVar('territory'))){$territory = $this->request->getVar('territory');}else{$territory = '';}


			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Account').'</span></div>
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Contact').'</span></div>
					<div class="nk-tb-col tb-col-mb"><span class="sub-text">'.translate_phrase('Address').'</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Territory').'</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Tax Payer').'</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Field Operative').'</span></div>
					<div class="nk-tb-col nk-tb-col-tools">
						<ul class="nk-tb-actions gx-1 my-n1">
							
						</ul>
					</div>
				</div><!-- .nk-tb-item -->
		
				
			';
			$a = 1;

            //echo $status;
			$log_id = $this->session->get('td_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				$role_id = $this->Crud->read_field('name', 'Tax Master', 'access_role', 'id');


				$all_rec = $this->Crud->filter_users('', '', $territory, $log_id, $role_id, '0', 'all', $search,);
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }

				$query = $this->Crud->filter_users($limit, $offset, $territory, $log_id, $role_id, '0', 'all', $search,);
				$data['count'] = $counts;

				if(!empty($query)) {
					foreach ($query as $q) {
						$id = $q->id;
						$fullname = $q->fullname;
						$username = $q->business_name;
						$email = $q->email;
						$phone = $q->phone;
						$territory = json_decode($q->territory);
						$ters = '';
						if(!empty($territory) && is_array($territory)){
							foreach($territory as $ter => $val){
								$ters .= $this->Crud->read_field('id', $val, 'territory', 'name').', ';
						
							}
						}
						$referral_id = 0;
						$address = $q->address;
						$city = $this->Crud->read_field('id', $q->lga_id, 'city', 'name');
						$state = $this->Crud->read_field('id', $q->state_id, 'state', 'name');
						$country = $this->Crud->read_field('id', $q->country_id, 'country', 'name');
						$img = $q->passport;
						if(!file_exists($img)){
							$img = 'assets/images/avatar.png';
						}
						$activate = $q->activate;
						$u_role = $this->Crud->read_field('id', $q->role_id, 'access_role', 'name');
						$reg_date = date('M d, Y h:ia', strtotime($q->reg_date));

						$market = '';
						$referral = '';
						if($referral_id > 0){
							$ref = $this->Crud->read_Field('id', $referral_id, 'user', 'fullname');
							$referral = '<span class="text-primary">Referred by: '.$ref.'</span> ';
						}
						$act = '';
						if ($activate == 1) {
							$a_color = 'success';
						} else {
							$a_color = 'danger';
						}

						$metric = $this->Crud->check('master_id', $id, 'user').' Field Operative';
						$p_metric = $this->Crud->check('referral', $id, 'user');

						// if ($approve == 1) {
						// 	$act = '<span class="text-success"><i class="ri-check-circle-line"></i> Verified</span> ';
						// } else {
						// 	$act = '<span class="text-danger"><i class="ri-check-circle-line"></i> Unverified</span> ';
						// }

						// add manage buttons
						if ($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<li><a href="' . site_url($mod . '/view/' . $id) . '" class="text-success" pageTitle="View ' . $fullname . '" pageName=""><em class="icon ni ni-eye"></em><span>'.translate_phrase('View Details').'</span></a></li>
								<li><a href="javascript:;" class="text-primary pop" pageTitle="Edit ' . $fullname . '" pageName="' . site_url($mod . '/manage/edit/' . $id) . '"><em class="icon ni ni-edit-alt"></em><span>'.translate_phrase('Edit').'</span></a></li>
								<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete ' . $fullname . '" pageName="' . site_url($mod . '/manage/delete/' . $id) . '"><em class="icon ni ni-trash-alt"></em><span>'.translate_phrase('Delete').'</span></a></li>
								
								
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-card">
										<div class="user-avatar ">
											<img alt="" src="' . site_url($img) . '" height="45px" style="max-width:100%"/>
										</div>
										<div class="user-info">
											<span class="tb-lead">' . ucwords($fullname) . ' <span class="dot dot-' . $a_color . ' ms-1"></span></span>
											<span>' . $email . '</span><br>
											<span>' . $u_role . '</span>
										</div>
									</div>
								</div>
								<div class="nk-tb-col tb-col">
									<span class="text-dark"><b>' . $phone . '</b></span>
								</div>
								<div class="nk-tb-col tb-col-mb">
									<span>' . ucwords($address) . '</span><br>
									<span class="text-info">'.$city . '</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span>' . ucwords(rtrim($ters, ',')) . '</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="text-info">'.$p_metric.'</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="tb-amount">' . $metric . ' </span>
								</div>
								<div class="nk-tb-col nk-tb-col-tools">
									<ul class="nk-tb-actions gx-1">
										<li>
											<div class="drodown">
												<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
												<div class="dropdown-menu dropdown-menu-end">
													<ul class="link-list-opt no-bdr">
														' . $all_btn . '
													</ul>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div><!-- .nk-tb-item -->
						';
						$a++;
					}
				}
				
				
			}
			
			if(empty($item)) {
				$resp['item'] = $items.'
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="ni ni-users" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Tax Master Returned').'
					</div>
				';
			} else {
				$resp['item'] = $items . $item;
				if($offset >= 25){
					$resp['item'] = $item;
				}
				
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

		if($param1 == 'view'){
			if($param2) {
				$user_id = $param2;
				$data['id'] = $user_id;
				$last_log = date('F, d Y h:ia',strtotime($this->Crud->read_field('id', $user_id, 'user', 'last_log')));
				if(empty($this->Crud->read_field('id', $user_id, 'user', 'last_log'))){
					$last_log = 'Not Logged In';
				}
				$data['last_log'] = $last_log;
				$data['fullname'] = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
				$role_id = $this->Crud->read_field('id', $user_id, 'user', 'role_id');
				$data['role'] = $this->Crud->read_field('id', $role_id, 'access_role', 'name');
				$data['v_phone'] = $this->Crud->read_field('id', $user_id, 'user', 'phone');
				$data['reg_date'] = date('F, d Y h:ia',strtotime($this->Crud->read_field('id', $user_id, 'user', 'reg_date')));
				$data['v_email'] = $this->Crud->read_field('id', $user_id, 'user', 'email');
				$data['tax_id'] = $this->Crud->read_field('user_id', $user_id, 'virtual_account', 'acc_no');
				$data['bank'] = $this->Crud->read_field('user_id', $user_id, 'account', 'bank').' '.$this->Crud->read_field('user_id', $user_id, 'account', 'account').' '.$this->Crud->read_field('user_id', $user_id, 'account', 'name');
						
				$v_img_id = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				if(!empty($v_img_id)){
					if(!file_exists($v_img_id)){
						$v_img_id = 'assets/images/avatar.png';
					}
					$img = '<img src="'.site_url($v_img_id).'">';
				} else {
					$img = $this->Crud->image_name($this->Crud->read_field('id', $user_id, 'user', 'fullname'));
				}
				$data['v_img'] = $img;
				
				$data['email'] = $this->Crud->read_field('id', $user_id, 'user', 'email');
				$data['tax_id'] = $this->Crud->read_field('user_id', $user_id, 'virtual_account', 'acc_no');
				$data['fullname'] = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
				$data['sms'] = $this->Crud->read_field('id', $user_id, 'user', 'receive_message');
				$data['address'] = $this->Crud->read_field('id', $user_id, 'user', 'address');
				$data['territory'] = str_replace('_', ' ',$this->Crud->read_field('id', $user_id, 'user', 'territory'));
				$utilitys = $this->Crud->read_field('id', $user_id, 'user', 'utility');
				$id_cards = $this->Crud->read_field('id', $user_id, 'user', 'id_card');
				$trade_id = $this->Crud->read_field('id', $user_id, 'user', 'trade');
				$data['trade'] = $this->Crud->read_field('id', $user_id, 'trade', 'name');
				$passports = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				$data['phone'] = $this->Crud->read_field('id', $user_id, 'user', 'phone');
				$data['duration'] = $this->Crud->read_field('id', $user_id, 'user', 'duration');
				$data['lga_id'] = $this->Crud->read_field('id', $user_id, 'user', 'lga_id');
				$data['state_id'] = $this->Crud->read_field('id', $user_id, 'user', 'state_id');
				$data['country_id'] = $this->Crud->read_field('id', $user_id, 'user', 'country_id');
				$qrcodes = $this->Crud->read_field('id', $user_id, 'user', 'qrcode');
				$img_id = $this->Crud->read_field('id', $user_id, 'user', 'img_id');


				$qrcode = '--';
				// echo $qrcodes;
				if(!empty($qrcodes) && file_exists($qrcodes)){
					$qrcode = '<img height="150" src="'.site_url($qrcodes).'"> ';
				}

				$utility = 'No Utility Document Uploaded';
				if(!empty($utilitys) && file_exists($utilitys)){
					$utility = '<img height="150" src="'.site_url($utilitys).'"> ';
				}

				$id_card = 'No Valid ID Card Document Uploaded';
				if(!empty($id_cards) && file_exists($id_cards)){
					$id_card = '<img height="150" src="'.site_url($id_cards).'"> ';
				}
				
				$passport = 'No Passport Uploaded';
				if(!empty($passports) && file_exists($passports)){
					$passport = '<img height="150" src="'.site_url($passports).'"> ';
				}

				$data['utility'] = $utility;
				$data['id_card'] = $id_card;
				$data['passport'] = $passport;
				$data['qrcode'] = $qrcode;
				

				$data['img_id'] = $passports;
				// $data['img'] = $this->Crud->image($img_id, 'big');
        
				$v_status = $this->Crud->read_field('id', $user_id, 'user', 'activate');
				if(!empty($v_status)) { $v_status = '<span class="text-success">VERIFIED</span>'; } else { $v_status = '<span class="text-danger">UNVERIFIED</span>'; }
				$data['v_status'] = $v_status;

				$data['v_address'] = $this->Crud->read_field('id', $user_id, 'user', 'address');

				$v_state_id = $this->Crud->read_field('id', $user_id, 'user', 'state_id');
				$data['v_state'] = $this->Crud->read_field('id', $v_state_id, 'state', 'name');
				$v_trade_id = $this->Crud->read_field('id', $user_id, 'user', 'trade');
				$data['v_trade'] = $this->Crud->read_field('id', $v_trade_id, 'trade', 'name');

				$v_country_id = $this->Crud->read_field('id', $user_id, 'user', 'country_id');
				$data['v_country'] = $this->Crud->read_field('id', $v_country_id, 'country', 'name');
				$v_city_id = $this->Crud->read_field('id', $user_id, 'user', 'lga_id');
				$data['v_city'] = $this->Crud->read_field('id', $v_city_id, 'city', 'name');
				$data['v_territory'] = $this->Crud->read_field('id', $this->Crud->read_field('id', $user_id, 'user', 'territory'), 'territory', 'name');
				$data['v_duration'] = $this->Crud->read_field('id', $user_id, 'user', 'duration');
				$data['v_master_id'] = $this->Crud->read_field('id', $user_id, 'user', 'master_id');
				
				
				$data['v_id_card'] = $this->Crud->read_field('id', $user_id, 'user', 'id_card');
				
				$data['v_passport'] = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				
				$data['v_utility'] = $this->Crud->read_field('id', $user_id, 'user', 'utility');
				$data['v_qrcode'] = $this->Crud->read_field('id', $user_id, 'user', 'qrcode');
				$data['v_business_name'] = $this->Crud->read_field('id', $user_id, 'user', 'business_name');
				$data['v_business_address'] = $this->Crud->read_field('id', $user_id, 'user', 'business_address');
			}
			$data['title'] = translate_phrase('Account View').' | '.app_name;
			$data['page_active'] = $mod;
			return view($mod.'_view', $data);
		}
		if($param1 == 'manage') { // view for form data posting
			return view($mod.'_form', $data);
		} else { // view for main page
			
			$data['title'] = translate_phrase('Tax Masters').' | '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }
	
	
	public function field($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'accounts/field';

        $log_id = $this->session->get('td_id');
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, $mod, 'create');
        $role_r = $this->Crud->module($role_id, $mod, 'read');
        $role_u = $this->Crud->module($role_id, $mod, 'update');
        $role_d = $this->Crud->module($role_id, $mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }
        $data['log_id'] = $log_id;
        $data['current_language'] = $this->session->get('current_language');
        $data['role'] = $role;
        $data['role_c'] = $role_c;
       
		$table = 'user';
		if($this->Crud->check2('id', $log_id, 'setup', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
		if($this->Crud->check2('id', $log_id, 'trade', 0, 'user')> 0)return redirect()->to(site_url('auth/security'));
		$form_link = site_url($mod);
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
                        $del_id =  $this->request->getVar('d_field_id');
                        $role_id =  $this->Crud->read_field('name', 'Field Operative', 'access_role', 'id');
						$datas['role_id'] = $role_id;
                        $datas['log_id'] = $log_id;
                        
						// print_r($datas);
						// //$role_id . ' ' . $log_id;
						// die;
						
                        $del = $this->Crud->api('delete', 'users/delete/'.$del_id, $datas);

						$del = json_decode($del);
                        if($del->status == true){	
                        
							echo $this->Crud->msg($del->code, translate_phrase($del->msg));
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
								$data['e_fullname'] = $e->fullname;
								$data['e_phone'] = $e->phone;
								$data['e_state_id'] = $e->state_id;
								$data['e_lga_id'] = $e->lga_id;
								$data['e_email'] = $e->email;
								$data['e_activate'] = $e->activate;
								$data['e_territory'] = $e->territory;
								$data['e_master_id'] = $e->master_id;
								$data['e_trade'] = $e->trade;
								$data['e_passport'] = $e->passport;
								$data['e_id_card'] = $e->id_card;
								$data['e_utility'] = $e->utility;
								$data['e_bank_code'] = $this->Crud->read_field('user_id', $e->id, 'account', 'code');
								$data['e_account_name'] = $this->Crud->read_field('user_id', $e->id, 'account', 'name');
								$data['e_account'] = $this->Crud->read_field('user_id', $e->id, 'account', 'account');
							}
						}
						
					}
				}
				
				if($this->request->getMethod() == 'post'){
					$field_id = $this->request->getPost('field_id');
					$fullname = $this->request->getPost('name');
					$phone = $this->request->getPost('phone');
					$email = $this->request->getPost('email');
					$state_id = $this->request->getPost('state_id');
					$lga_id = $this->request->getPost('lga_id');
					$master_id = $this->request->getPost('master_id');
					$territory = $this->request->getPost('territory');
					$passport = $this->request->getPost('passport');
					$id_card = $this->request->getPost('id_card');
					$utility = $this->request->getPost('utility');
					$account_name = $this->request->getPost('account_name');
					$bank = $this->request->getPost('bank');
					$account = $this->request->getPost('account');
					$password = $this->request->getPost('password');

					$ins_data['fullname'] = $fullname;
					$ins_data['email'] = $email;
					$ins_data['master_id'] = $master_id;
					$ins_data['phone'] = $phone;
					$ins_data['territory'] = $territory;
					$ins_data['country_id'] = 161;
					$ins_data['state_id'] = 316;
					$ins_data['lga_id'] = $lga_id;
					$ins_data['role_id'] = $this->Crud->read_field('name', 'Field Operative', 'access_role', 'id');

					if($password) { $ins_data['password'] = md5($password); }
					// if($this->Crud->check2('id', $lga_id, 'territory', $territory, 'city') == 0){
					// 	echo $this->Crud->msg('warning', 'LGA selected is not under the Territory Selected');
					// 	die;
					// }
					
					//// Passport upload
					if(file_exists($this->request->getFile('passports'))) {
						$path = 'assets/images/users/tax_master/';
						$file = $this->request->getFile('passports');
						$getImg = $this->Crud->img_upload($path, $file);
						
						$passport = $getImg->path;
					}

					//// ID Card upload
					if(file_exists($this->request->getFile('id_cards'))) {
						$path = 'assets/images/users/tax_master/';
						$file = $this->request->getFile('id_cards');
						$getImg = $this->Crud->img_upload($path, $file);
						
						$id_card = $getImg->path;
					}

					//// Utility upload
					if(file_exists($this->request->getFile('utilitys'))) {
						$path = 'assets/images/users/tax_master/';
						$file = $this->request->getFile('utilitys');
						$getImg = $this->Crud->img_upload($path, $file);
						
						$utility = $getImg->path;
					}

					// if(empty($passport) || empty($id_card) || empty($utility)){
					// 	echo $this->Crud->msg('danger', 'All Documents are Required to be Uploaded');
					// 	die;
					// }

					
					$ins_data['passport'] = $passport;
					$ins_data['utility'] = $utility;
					$ins_data['id_card'] = $id_card;
		
					// do create or update
					if($field_id) {
						$upd_rec = $this->Crud->updates('id', $field_id, $table, $ins_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', translate_phrase('Record Updated'));

							$b_data['code'] = $bank;
							$b_data['account'] = $account;
							$b_data['name'] = $account_name;
							$b_data['bank'] = $this->Crud->read_field('code' , $bank, 'bank', 'name');
							if($this->Crud->check('user_id', $master_id, 'account') > 0){
								$this->Crud->updates('user_id', $master_id, 'account', $b_data);
							} else {
								
								$b_data['user_id'] = $master_id;
								$this->Crud->create('account', $b_data);
							}
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$code = $this->Crud->read_field('id', $field_id, 'user', 'fullname');
							$action = $by.' updated Field Operative ('.$code.') Record';
							$this->Crud->activity('user', $field_id, $action);

							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', translate_phrase('No Changes'));	
						}
					} else {
						if($this->Crud->check('email', $email, $table) > 0 || $this->Crud->check('phone', $phone, $table) > 0) {
							echo $this->Crud->msg('warning', translate_phrase('Email and/or Phone Already Exist'));
						} else {
							$ins_data['activate'] = 1;
							$ins_data['reg_date'] = date(fdate);

							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', translate_phrase('Record Created'));

								$b_data['code'] = $bank;
								$b_data['account'] = $account;
								$b_data['name'] = $account_name;
								$b_data['bank'] = $this->Crud->read_field('code' , $bank, 'bank', 'name');
								if($this->Crud->check('user_id', $ins_rec, 'account') > 0){
									$this->Crud->updates('user_id', $ins_rec, 'account', $b_data);
								} else {
									
									$b_data['user_id'] = $ins_rec;
									$this->Crud->create('account', $b_data);
								}

								$user_id = $ins_rec;
								if(!empty($user_id)){
									$link = site_url('auth/profile_view/') .$user_id;
									$qr = $this->qrcode($link);
									$path = $qr['file'];
									$this->Crud->updates('id', $user_id, 'user', array('qrcode'=>$path));
								}
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
								$code = $this->Crud->read_field('id', $ins_rec, 'user', 'fullname');
								$action = $by.' created Field Operative ('.$code.')';
								$this->Crud->activity('user', $ins_rec, $action);

								$body = '
									Dear '.$fullname.', <br><br>
										A Field Operative Account Has been Created with This Email;<br>
										Below are the login Credentials:<br><br>

										Email:'.$email.'<br>
										Phone:'.$phone.'<br>
										Password:'.$password.'<br>
										
								';
								$sms_body = '
									Dear '.$fullname.', A Field Operative Account Has been Created with This Email/Phone Number. Your login Credentials are; 
										Email: {'.$email.'}, Phone: {'.$phone.'}, Password: {'.$password.'}
										
								';
								$api_key = $this->Crud->read_field('name', 'termil_api', 'setting', 'value'); // pick from DB
							
								if($phone) {
									$phone = '234'.substr($phone,1);
									$datass['to'] = $phone;
									$datass['from'] = 'TIDREM';
									$datass['sms'] = $sms_body;
									$datass['api_key'] = $api_key;
									$datass['type'] = 'plain';
									$datass['channel'] = 'generic';
									$this->Crud->termii('post', 'sms/send', $datass);
								}
						
								// send email
								if($email) {
									$data['email_address'] = $email;
									$this->Crud->send_email($email, 'Field Operative Account', $body);
								}
								$this->Crud->notify('0', $ins_rec, $body, 'authentication', $user_id);


								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', translate_phrase('Please try later'));	
							}	
						}
					}
					exit;	
				}
			}
		}


        // record listing
		if($param1 == 'load') {
			$limit = $param2;
			$offset = $param3;

			$rec_limit = 25;
			$item = '';
            if(empty($limit)) {$limit = $rec_limit;}
			if(empty($offset)) {$offset = 0;}
			
			$search = $this->request->getPost('search');
			if(!empty($this->request->getVar('territory'))){$territory = $this->request->getVar('territory');}else{$territory = '';}


			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Account').'</span></div>
					<div class="nk-tb-col  tb-col-md"><span class="sub-text">'.translate_phrase('Contact').'</span></div>
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Address').'</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Tax Payers').'</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Territory').'</span></div>
					<div class="nk-tb-col nk-tb-col-tools">
						<ul class="nk-tb-actions gx-1 my-n1">
							
						</ul>
					</div>
				</div><!-- .nk-tb-item -->
		
				
			';
			$a = 1;

            //echo $status;
			$log_id = $this->session->get('td_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				$role_id = $this->Crud->read_field('name', 'Field Operative', 'access_role', 'id');


				$all_rec = $this->Crud->filter_field('', '', $territory, $log_id, $role_id, '0', 'all', $search,);
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }

				$query = $this->Crud->filter_field($limit, $offset, $territory, $log_id, $role_id, '0', 'all', $search,);
				$data['count'] = $counts;

				
				if(!empty($query)) {
					foreach ($query as $q) {
						$id = $q->id;
						$fullname = $q->fullname;
						$username = $q->business_name;
						$email = $q->email;
						$phone = $q->phone;
						$territory = $this->Crud->read_field('id', $q->territory, 'territory', 'name');
						$master = $this->Crud->read_field('id', $q->master_id, 'user', 'fullname');
						$referral_id = 0;
						$address = $q->address;
						$city = $this->Crud->read_field('id', $q->lga_id, 'city', 'name');
						$state = $this->Crud->read_field('id', $q->state_id, 'state', 'name');
						$country = $this->Crud->read_field('id', $q->country_id, 'country', 'name');
						$img = $q->passport;
						if(!file_exists($img)){
							$img = 'assets/images/avatar.png';
						}
						$activate = $q->activate;
						$u_role = $this->Crud->read_field('id', $q->role_id, 'access_role', 'name');
						$reg_date = date('M d, Y h:ia', strtotime($q->reg_date));

						if(empty($master)){
							$master = 'Not Assigned';
						}
						$market = '';
						$referral = '';
						if($referral_id > 0){
							$ref = $this->Crud->read_Field('id', $referral_id, 'user', 'fullname');
							$referral = '<span class="text-primary">Referred by: '.$ref.'</span> ';
						}
						$act = '';
						if ($activate == 1) {
							$a_color = 'success';
						} else {
							$a_color = 'danger';
						}

						$metric = $this->Crud->check('referral', $id, 'user');

						// if ($approve == 1) {
						// 	$act = '<span class="text-success"><i class="ri-check-circle-line"></i> Verified</span> ';
						// } else {
						// 	$act = '<span class="text-danger"><i class="ri-check-circle-line"></i> Unverified</span> ';
						// }

						// add manage buttons
						if ($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<li><a href="' . site_url($mod . '/view/' . $id) . '" class="text-success" pageTitle="View ' . $fullname . '" pageName=""><em class="icon ni ni-eye"></em><span>'.translate_phrase('View Details').'</span></a></li>
								<li><a href="javascript:;" class="text-primary pop" pageTitle="Edit ' . $fullname . '" pageName="' . site_url($mod . '/manage/edit/' . $id) . '"><em class="icon ni ni-edit-alt"></em><span>'.translate_phrase('Edit').'</span></a></li>
								<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete ' . $fullname . '" pageName="' . site_url($mod . '/manage/delete/' . $id) . '"><em class="icon ni ni-trash-alt"></em><span>'.translate_phrase('Delete').'</span></a></li>
								
								
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-card">
										<div class="user-avatar ">
											<img alt="" src="' . site_url($img) . '" width="50px" height="40px"/>
										</div>
										<div class="user-info">'.$reg_date.'
											<span class="tb-lead">' . ucwords($fullname) . ' <span class="dot dot-' . $a_color . ' ms-1"></span></span>
											<span>' . $email . '</span><br>
											<span>' . $u_role . '</span>
										</div>
									</div>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="text-dark"><b>' . $phone . '</b></span>
								</div>
								<div class="nk-tb-col">
									<span>' . ucwords($address) . '</span><br>
									<span class="text-info">'.$city . '</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="text-info">'.$metric.'</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span>' . ucwords(str_replace('_', ' ', $territory)) . '</span><br><span class="text-danger">Tax Master: '.$master.'</span>
								</div>
								<div class="nk-tb-col nk-tb-col-tools">
									<ul class="nk-tb-actions gx-1">
										<li>
											<div class="drodown">
												<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
												<div class="dropdown-menu dropdown-menu-end">
													<ul class="link-list-opt no-bdr">
														' . $all_btn . '
													</ul>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div><!-- .nk-tb-item -->
						';
						$a++;
					}
				}
				
				
			}
			
			if(empty($item)) {
				$resp['item'] = $items.'
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="ni ni-users" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Field Operative Returned').'
					</div>
				';
			} else {
				$resp['item'] = $items . $item;
				if($offset >= 25){
					$resp['item'] = $item;
				}
				
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

		if($param1 == 'view'){
			if($param2) {
				$user_id = $param2;
				$data['id'] = $user_id;
				$last_log = date('F, d Y h:ia',strtotime($this->Crud->read_field('id', $user_id, 'user', 'last_log')));
				if(empty($this->Crud->read_field('id', $user_id, 'user', 'last_log'))){
					$last_log = 'Not Logged In';
				}
				$data['last_log'] = $last_log;
				$data['fullname'] = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
				$role_id = $this->Crud->read_field('id', $user_id, 'user', 'role_id');
				$data['role'] = $this->Crud->read_field('id', $role_id, 'access_role', 'name');
				$data['v_phone'] = $this->Crud->read_field('id', $user_id, 'user', 'phone');
				$data['reg_date'] = date('F, d Y h:ia',strtotime($this->Crud->read_field('id', $user_id, 'user', 'reg_date')));
				$data['v_email'] = $this->Crud->read_field('id', $user_id, 'user', 'email');
				$data['tax_id'] = $this->Crud->read_field('user_id', $user_id, 'virtual_account', 'acc_no');
				$data['bank'] = $this->Crud->read_field('user_id', $user_id, 'account', 'bank').' '.$this->Crud->read_field('user_id', $user_id, 'account', 'account').' '.$this->Crud->read_field('user_id', $user_id, 'account', 'name');
						
				$v_img_id = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				if(!empty($v_img_id)){
					if(!file_exists($v_img_id)){
						$v_img_id = 'assets/images/avatar.png';
					}
					$img = '<img src="'.site_url($v_img_id).'">';
				} else {
					$img = $this->Crud->image_name($this->Crud->read_field('id', $user_id, 'user', 'fullname'));
				}
				$data['v_img'] = $img;

				$v_status = $this->Crud->read_field('id', $user_id, 'user', 'activate');
				if(!empty($v_status)) { $v_status = '<span class="text-success">VERIFIED</span>'; } else { $v_status = '<span class="text-danger">UNVERIFIED</span>'; }
				$data['v_status'] = $v_status;

				$data['v_address'] = $this->Crud->read_field('id', $user_id, 'user', 'address');

				$v_state_id = $this->Crud->read_field('id', $user_id, 'user', 'state_id');
				$data['v_state'] = $this->Crud->read_field('id', $v_state_id, 'state', 'name');
				$v_trade_id = $this->Crud->read_field('id', $user_id, 'user', 'trade');
				$data['v_trade'] = $this->Crud->read_field('id', $v_trade_id, 'trade', 'name');

				$v_country_id = $this->Crud->read_field('id', $user_id, 'user', 'country_id');
				$data['v_country'] = $this->Crud->read_field('id', $v_country_id, 'country', 'name');
				$v_city_id = $this->Crud->read_field('id', $user_id, 'user', 'lga_id');
				$data['v_city'] = $this->Crud->read_field('id', $v_city_id, 'city', 'name');
				$data['v_territory'] = $this->Crud->read_field('id', $this->Crud->read_field('id', $user_id, 'user', 'territory'), 'territory', 'name');
				$data['v_duration'] = $this->Crud->read_field('id', $user_id, 'user', 'duration');
				$data['v_master_id'] = $this->Crud->read_field('id', $user_id, 'user', 'master_id');
				$master_id = $this->Crud->read_field('id', $user_id, 'user', 'master_id');
				$data['v_master'] = $this->Crud->read_field('id', $master_id, 'user', 'fullname');
				
				$data['email'] = $this->Crud->read_field('id', $user_id, 'user', 'email');
				$data['tax_id'] = $this->Crud->read_field('user_id', $user_id, 'virtual_account', 'acc_no');
				$data['fullname'] = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
				$data['sms'] = $this->Crud->read_field('id', $user_id, 'user', 'receive_message');
				$data['address'] = $this->Crud->read_field('id', $user_id, 'user', 'address');
				$data['territory'] = str_replace('_', ' ',$this->Crud->read_field('id', $user_id, 'user', 'territory'));
				$utilitys = $this->Crud->read_field('id', $user_id, 'user', 'utility');
				$id_cards = $this->Crud->read_field('id', $user_id, 'user', 'id_card');
				$trade_id = $this->Crud->read_field('id', $user_id, 'user', 'trade');
				$data['trade'] = $this->Crud->read_field('id', $user_id, 'trade', 'name');
				$passports = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				$data['phone'] = $this->Crud->read_field('id', $user_id, 'user', 'phone');
				$data['duration'] = $this->Crud->read_field('id', $user_id, 'user', 'duration');
				$data['lga_id'] = $this->Crud->read_field('id', $user_id, 'user', 'lga_id');
				$data['state_id'] = $this->Crud->read_field('id', $user_id, 'user', 'state_id');
				$data['country_id'] = $this->Crud->read_field('id', $user_id, 'user', 'country_id');
				$qrcodes = $this->Crud->read_field('id', $user_id, 'user', 'qrcode');
				$img_id = $this->Crud->read_field('id', $user_id, 'user', 'img_id');


				$qrcode = '--';
				// echo $qrcodes;
				if(!empty($qrcodes) && file_exists($qrcodes)){
					$qrcode = '<img height="150" src="'.site_url($qrcodes).'"> ';
				}

				$utility = 'No Utility Document Uploaded';
				if(!empty($utilitys) && file_exists($utilitys)){
					$utility = '<img height="150" src="'.site_url($utilitys).'"> ';
				}

				$id_card = 'No Valid ID Card Document Uploaded';
				if(!empty($id_cards) && file_exists($id_cards)){
					$id_card = '<img height="150" src="'.site_url($id_cards).'"> ';
				}
				
				$passport = 'No Passport Uploaded';
				if(!empty($passports) && file_exists($passports)){
					$passport = '<img height="150" src="'.site_url($passports).'"> ';
				}

				$data['utility'] = $utility;
				$data['id_card'] = $id_card;
				$data['passport'] = $passport;
				$data['qrcode'] = $qrcode;
				

				$data['img_id'] = $passports;
				// $data['img'] = $this->Crud->image($img_id, 'big');
        
				
				$data['v_id_card'] = $this->Crud->read_field('id', $user_id, 'user', 'id_card');
				
				$data['v_passport'] = $this->Crud->read_field('id', $user_id, 'user', 'passport');
				
				$data['v_utility'] = $this->Crud->read_field('id', $user_id, 'user', 'utility');
				$data['v_qrcode'] = $this->Crud->read_field('id', $user_id, 'user', 'qrcode');
				$data['v_business_name'] = $this->Crud->read_field('id', $user_id, 'user', 'business_name');
				$data['v_business_address'] = $this->Crud->read_field('id', $user_id, 'user', 'business_address');
			}
			$data['title'] = translate_phrase('Account View').' | '.app_name;
			$data['page_active'] = $mod;
			return view($mod.'_view', $data);
		}

		if($param1 == 'manage') { // view for form data posting
			return view($mod.'_form', $data);
		} else { // view for main page
			
			$data['title'] = translate_phrase('Field Operative').' | '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }
	
	public function customer_details($param1='', $param2='', $param3='', $param4='') {
        // record listing
		$log_id = $this->session->get('td_id');
       
		if($param1 == 'activity' && $param2 == 'load') {
			$limit = $param3;
			$offset = $param4;
			$rec_limit = 25;
			$item = '';
            if($limit == '') {$limit = $rec_limit;}
			if($offset == '') {$offset = 0;}
			
			$search = $this->request->getVar('search');
			$user_id = $this->request->getVar('u_id');
			if(!empty($this->request->getPost('start_date'))) { $start_date = $this->request->getPost('start_date'); } else { $start_date = ''; }
			if(!empty($this->request->getPost('end_date'))) { $end_date = $this->request->getPost('end_date'); } else { $end_date = ''; }
			
			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				$query = $this->Crud->filter_activity($limit, $offset, $user_id, $search, $start_date, $end_date);
				$all_rec = $this->Crud->filter_activity('', '', $user_id, $search, $start_date, $end_date);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				
				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$type = $q->item;
						$type_id = $q->item_id;
						$action = $q->action;
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

						$timespan = $this->Crud->timespan(strtotime($q->reg_date));

						$icon = 'article';
						if($type == 'rhapsody') $icon = 'template';
						if($type == 'branch') $icon = 'reports-alt';
						if($type == 'business') $icon = 'briefcase';
						if($type == 'ecommerce') $icon = 'bag';
						if($type == 'user') $icon = 'users';
						if($type == 'pump') $icon = 'cc-secure';
						if($type == 'authentication') $icon = 'article';
						if($type == 'enrolment') $icon = 'property-add';
						if($type == 'scholarship') $icon = 'award';

						$item .= '
							<tr class="nk-tb-item">
								<td class="nk-tb-col">
									<a href="#" class="project-title">
										<div class=""><em class="icon ni ni-'.$icon.' text-muted" style="font-size:30px;"></em></div>
										<div class="project-info">
											<h6 class="title">'.$action.' <small>on '.$reg_date.'</small></h6>
										</div>
									</a>
								</td>
								<td class="nk-tb-col tb-col-lg">
									<span>'.$timespan.'</span>
								</td>
							</tr><!-- .nk-tb-item -->       
						';
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
			
		}

		if($param1 == 'notification' && $param2 == 'load') {
			$limit = $param3;
			$offset = $param4;
			$rec_limit = 25;
			$item = '';
            if($limit == '') {$limit = $rec_limit;}
			if($offset == '') {$offset = 0;}
			
			$search = $this->request->getVar('search');
			$user_id = $this->request->getVar('u_id');
			if(!empty($this->request->getPost('start_date'))) { $start_date = $this->request->getPost('start_date'); } else { $start_date = ''; }
			if(!empty($this->request->getPost('end_date'))) { $end_date = $this->request->getPost('end_date'); } else { $end_date = ''; }
			
			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				$query = $this->Crud->read_single('to_id', $user_id, 'notify', $limit, $offset);
				$all_rec = $this->Crud->read_single('to_id', $user_id, 'notify', '', '');
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				
				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$content = $q->content;
						$from_id = $q->from_id;
						$item_id = $q->item_id;
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));
						$from = 'Admin';
						if($from_id != 0){
							$from = $this->Crud->read_field('id', $from_id, 'user', 'fullname');
						}
						$item .= '
							<tr class="nk-tb-item">
								<td class="nk-tb-col">
									<div class="project-info">
										<p class="title text-dark">'.translate_phrase(ucwords($content)).' </p>
									</div>
								</td>
								<td class="nk-tb-col tb-col-lg">
									<div class="project-info">
										<h6 class="title"><small>From '.ucwords($from).'</small></h6>
									</div>
								</td>
								<td class="nk-tb-col tb-col">
									<span>'.ucwords($reg_date).'</span>
								</td>
							</tr><!-- .nk-tb-item -->       
						';
					}
				}
			}

			if(empty($item)) {
				$resp['item'] = '
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<em class="icon ni ni-notify" style="font-size:150px;"></em><br/><br/>'.translate_phrase('No Notification Returned').'
					</div>
				';
			} else {
				$resp['item'] = $item;
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
			
		}

		if($param1 == 'order' && $param2 == 'load') {
			$limit = $param3;
			$offset = $param4;
			$rec_limit = 25;
			$item = '';
            if($limit == '') {$limit = $rec_limit;}
			if($offset == '') {$offset = 0;}

			$user_id = $this->request->getVar('u_id');
			if(!empty($this->request->getVar('type'))) { $type = $this->request->getVar('type'); } else { $type = ''; }
			if(!empty($this->request->getVar('start_date'))) { $start_date = $this->request->getVar('start_date'); } else { $start_date = ''; }
			if(!empty($this->request->getVar('end_date'))) { $end_date = $this->request->getVar('end_date'); } else { $end_date = ''; }
			$search = $this->request->getVar('search');

			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				$query = $this->Crud->filter_transaction($limit, $offset, $user_id, $type, $search, $start_date, $end_date);
				$all_rec = $this->Crud->filter_transaction('', '', $user_id, $type, $search, $start_date, $end_date);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$curr = '&#8358;';
				$items = '	
					<div class="nk-tb-item nk-tb-head">
						<div class="nk-tb-col"><span>'.translate_phrase('Transaction Code').'</span></div>
						<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Account').'</span></div>
						<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Payment Type').'</span></div>
						<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Amount').'</span></div>
						<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Status').'</span></div>
						<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Date').'</span></div>
					</div><!-- .nk-tb-item -->
						';

				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$user_id = $q->user_id;
						$payment_type = $q->payment_type;
						$payment_method = $q->payment_method;
						$code = $q->code;
						$merchant_id = $q->merchant_id;
						$status = $q->status;
						$amount = number_format((float)$q->amount, 2);
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));


						// user 
						$user = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
						$user_role_id = $this->Crud->read_field('id', $user_id, 'user', 'role_id');
						$user_role = strtoupper($this->Crud->read_field('id', $user_role_id, 'access_role', 'name'));
						$user_image_id = $this->Crud->read_field('id', $user_id, 'user', 'img_id');
						$user_image = $this->Crud->image($user_image_id, 'big');

						// merchant 
						$merchant = $this->Crud->read_field('id', $merchant_id, 'user', 'fullname');
						$merchant_role_id = $this->Crud->read_field('id', $merchant_id, 'user', 'role_id');
						$merchant_role = strtoupper($this->Crud->read_field('id', $merchant_role_id, 'access_role', 'name'));
						$merchant_image_id = $this->Crud->read_field('id', $merchant_id, 'user', 'img_id');
						$merchant_image = $this->Crud->image($merchant_image_id, 'big');

						$mer = '';
						if(!empty($merchant_id)){
							$mer = '<span class="text-danger">'.$merchant.'</span>';
						}
						$act = $mer.'<br><span class="text-primary">&rarr;'.$user.'</span>';


						if($payment_type == 'transact'){
							$payment_type = 'Transaction Code';

							$act = '<span class="text-info">'.$user.'</span>';
						} 

						if($payment_type == 'sms'){
							$payment_type = 'SMS Charge';

							$act = '<span class="text-info">'.$user.'</span>';
						} 

						
						// currency
						$curr = '&#8358;';

						// color
						$color = 'success';
						if($payment_type == 'debit') { $color = 'danger'; }

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<small class="text-muted d-md-none d-sm-block">'.strtoupper($reg_date).'</small><br>
									<span class="fw-bold text-success pop">
										<a href="javascript:;" class="text-success pop" pageTitle="View" pageName="'.site_url('wallets/transaction/view/'.$id).'" pageSize="modal-lg">
											<i class="ni ni-edit"></i> <span class="m-l-3 m-r-10"><b>'.$code.'</b></span>
										</a></span><br>
									<span class="fw-bold text-secondary d-md-none d-sm-block">'.strtoupper($payment_type).'</span>
								</div>
								<div class="nk-tb-col">
									<div class="user-card">
										<div class="user-info">
											'.$act.'
										</div>
									</div>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="fw-bold text-secondary">'.strtoupper($payment_type).'</span>
								</div>
								<div class="nk-tb-col">
									<span>'.$curr.$amount.'</span><br>
									<span class="badge badge-dot text-success d-md-none d-sm-block">Success</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="badge badge-dot text-success">Success</span><br>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span>'.$reg_date.'</span>
								</div>
							</div>
							
						';
					}
				}
			}
			if(empty($item)) {
				$resp['item'] = $items.'
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="icon ni ni-tranx" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Transaction Returned').'
					</div>
				';
			} else {
				$resp['item'] = $items.$item;
				if($offset >= 25){
					$resp['item'] = $item;
				
				}
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
			
		}

		if($param1 == 'wallet' && $param2 == 'load') {
			$limit = $param3;
			$offset = $param4;
			$rec_limit = 25;
			$item = '';
            if($limit == '') {$limit = $rec_limit;}
			if($offset == '') {$offset = 0;}

			$user_id = $this->request->getVar('u_id');
			
			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				$query = $this->Crud->filter_wallet($limit, $offset, $user_id);
				$all_rec = $this->Crud->filter_wallet('', '', $user_id);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$curr = '&#8358;';
				$items = '	
					<div class="nk-tb-item nk-tb-head">
						<div class="nk-tb-col"><span>'.translate_phrase('Wallet Type').'</span></div>
						<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Amount').'</span></div>
						<div class="nk-tb-col tb-col-md"><span class="sub-text">'.translate_phrase('Date').'</span></div>
					</div><!-- .nk-tb-item -->
						';

				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$user_id = $q->user_id;
						$type = $q->type;
						$itema = $q->item;
						$amount = number_format((float)$q->amount, 2);
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

						
						// currency
						$curr = '&#8358;';

						// color
						$color = 'success';
						if($type == 'debit') { $color = 'danger'; }

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<span class="fw-bold text-'.$color.'">'.strtoupper($type).'</span><br>
									<span class="fw-bold text-dark">'.strtoupper($itema).'</span>
									<small class="text-muted d-md-none d-sm-block">'.strtoupper($reg_date).'</small><br>
									<span class="fw-bold text-'.$color.' d-md-none d-sm-block">'.strtoupper($type).'</span>
								</div>
								<div class="nk-tb-col">
									<span>'.$curr.$amount.'</span><br>
									<span class="fw-bold text-dark d-md-none d-sm-block">'.strtoupper($itema).'</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span>'.$reg_date.'</span>
								</div>
							</div>
							
						';
					}
				}
			}
			if(empty($item)) {
				$resp['item'] = $items.'
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="icon ni ni-tranx" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Transaction Returned').'
					</div>
				';
			} else {
				$resp['item'] = $items.$item;
				if($offset >= 25){
					$resp['item'] = $item;
				
				}
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
			
		}
    }

	public function get_state($country){
		if(empty($country)){
			echo '<label for="activate">'.translate_phrase('State').'</label>
			<input type="text" class="form-control" name="state" id="state" readonly placeholder="Select Country First">';
		} else {
			$state = $this->Crud->read_single_order('country_id', $country, 'state', 'name', 'asc');
			echo '<label for="activate">'.translate_phrase('State').'</label>
				<select class="form-select js-select2" data-search="on" id="state" name="state" onchange="lgaa();">
					<option value="">'.translate_phrase('Select').'</option>
			';
			foreach($state as $qr) {
				$hid = '';
				$sel = '';
				echo '<option value="'.$qr->id.'" '.$sel.'>'.$qr->name.'</option>';
			}
			echo '</select>
			<script> $(".js-select2").select2();</script>';
		}
	}

	public function get_lga($state){
		if(empty($state)){
			echo '<label for="activate">'.translate_phrase('Local Goverment Area').'</label>
			<input type="text" class="form-control" name="lga" id="lga" readonly placeholder="'.translate_phrase('Select State First').'">';
		} else {
			$state = $this->Crud->read_single_order('state_id', $state, 'city', 'name', 'asc');
			echo '<label for="activate">'.translate_phrase('Local Goverment Area').'</label>
				<select class="form-select js-select2" data-search="on" id="lga" name="lga" onchange="branc();">
					<option value="">'.translate_phrase('Select').'</option>
			';
			foreach($state as $qr) {
				$hid = '';
				$sel = '';
				echo '<option value="'.$qr->id.'" '.$sel.'>'.$qr->name.'</option>';
			}
			echo '</select>
			<script> $(".js-select2").select2();</script>';
		}
	}

	public function get_territory($state){
		$lga = '';
		if(empty($state)){
			$lga .= '<option value="">Select LGA First</option>';
		} else {
			$state = $this->Crud->read_single_order('lga_id', $state, 'territory', 'name', 'asc');
			$lga .= '<option value="">'.translate_phrase('Select').'</option>';
			foreach($state as $qr) {
				$hid = '';
				$sel = '';
				$lga .= '<option value="'.$qr->id.'" '.$sel.'>'.$qr->name.'</option>';
			}
			
		}
		echo $lga;
	}


	//Get task master
	public function validate_field($territory){
		// echo $territory;
		$manager = $this->request->getVar('man');
		if(empty($territory)){
			echo '<option value=" ">'.translate_phrase('Select Territory First').'</option>';
		} else {
			$role_id = $this->Crud->read_field('name', 'Tax Master', 'access_role', 'id');

			$territorys = $this->Crud->read_single_order('role_id', $role_id, 'user', 'fullname', 'asc');
			echo '<option value=" ">'.translate_phrase('Select').'</option>';
			foreach($territorys as $qr) {
				$ter = json_decode($qr->territory);
				if(!empty($ter) && is_array($ter)){
					if(!in_array($territory, $ter))continue;
				}

				$sel = '';
				if(!empty($manager)){
					if($manager == $qr->id){
						$sel = 'selected';
					}
				}
				$hid = '';
				
				echo '<option value="'.$qr->id.'" '.$sel.'>'.$qr->fullname.'</option>';
			}
			
		}
	}

	public function qrcode($data=''){
       
        /* Data */
        $hex_data   = bin2hex($data);
        $save_name  = $hex_data . '.png';

        /* QR Code File Directory Initialize */
        $dir = 'assets/images/qr/profile/';
        if (! file_exists($dir)) {
            mkdir($dir, 0775, true);
        }

        /* QR Configuration  */
        $config['cacheable']    = true;
        $config['imagedir']     = $dir;
        $config['quality']      = true;
        $config['size']         = '1024';
        $config['black']        = [255, 255, 255];
        $config['white']        = [255, 255, 255];
        $this->ciqrcode->initialize($config);

        /* QR Data  */
        $params['data']     = $data;
        $params['level']    = 'L';
        $params['size']     = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $save_name;

        $this->ciqrcode->generate($params);

        /* Return Data */
        return [
            'content' => $data,
            'file'    => $dir . $save_name,
        ];
    }

	  //Beneficiary List
	public function check_otp($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'check_otp';

        $log_id = $this->session->get('td_id');
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, 'accounts/'.$mod, 'create');
        $role_r = $this->Crud->module($role_id, 'accounts/'.$mod, 'read');
        $role_u = $this->Crud->module($role_id, 'accounts/'.$mod, 'update');
        $role_d = $this->Crud->module($role_id, 'accounts/'.$mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }
        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;
       
		$table = 'user';
		$form_link = site_url('accounts/'.$mod);
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
                if($this->Crud->check('phone', $param2, 'user') > 0){
					$otp = $this->Crud->read_field('phone', $param2, 'user', 'otp');
					if(empty($otp)){
						echo $this->Crud->msg('danger', 'No OTP Exist for this Phone Number');
					} else{
						echo $this->Crud->msg('success', 'The OTP is <b>'.$otp.'</b>');
					}
				} else{
					echo $this->Crud->msg('danger', 'Phone Number Does not Exist');
				}
            } else {
                echo $this->Crud->msg('danger', 'Phone Number cannot be Empty');
               
            } 
            
            die;
        }

        
        $data['current_language'] = $this->session->get('current_language');
		if($param1 == 'manage') { // view for form data posting
			return view($mod.'_form', $data);
		} else { // view for main page
			
			$data['title'] = translate_phrase('OTP Check').' | '.app_name;
			$data['page_active'] = 'dashboard/otp_check';
			return view($mod, $data);
		}
    }

	  //Beneficiary List
	public function virtual_assign($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'virtual_assign';

        $log_id = $this->session->get('td_id');
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, 'accounts/'.$mod, 'create');
        $role_r = $this->Crud->module($role_id, 'accounts/'.$mod, 'read');
        $role_u = $this->Crud->module($role_id, 'accounts/'.$mod, 'update');
        $role_d = $this->Crud->module($role_id, 'accounts/'.$mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }
        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;
       
		$table = 'user';
		$form_link = site_url('accounts/'.$mod);
		if($param1){$form_link .= '/'.$param1;}
		if($param2){$form_link .= '/'.$param2.'/';}
		if($param3){$form_link .= $param3;}
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		$data['form_link'] = rtrim($form_link, '/');
		
		// manage record
		if($param1 == 'manage') {
						
			// prepare for delete
			if($param2 == 'assign') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
                    //echo var_dump($edit);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}
					
					if($this->request->getMethod() == 'post'){
                        $virtual_id =  $this->request->getVar('virtual_id');
                        $user_id =  $this->request->getVar('user_id');
                        
                        $del = $this->Crud->updates('id', $virtual_id, 'virtual_account', array('user_id'=>$user_id));

                        if($del > 0){	
							echo $this->Crud->msg('success', translate_phrase('Virtual Account Assigned'));
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', translate_phrase('Please try later'));
						}
						die;	
					}
				}
			
			} elseif($param2 == 'generate'){
				if($this->request->getMethod() == 'post'){
					$tax_no = $this->request->getPost('tax_no');

					if(!empty($tax_no)) {
						$p_data['account_name']= 'Zend Tax Account';
						$p_data['bvn']= "";
						$id = 0;$e_id = 0;
						$user_id = 0;
						for($i =1; $i <= $tax_no; $i++){	
							$virtual = $this->Crud->providus('post', 'PiPCreateReservedAccountNumber', $p_data);
							$virtuals =json_decode($virtual);
							if(empty($virtuals)){
								$resp = $e_id.' Error';
								$e_id++;
							} else{
								if($virtuals->requestSuccessful == true){
									$v_data['acc_no'] = $virtuals->account_number;
									$v_data['user_id'] = $user_id;
									$v_data['response'] = $virtual;
									$v_data['reg_date'] = date(fdate);
									$this->Crud->create('virtual_account',  $v_data);

									///// store activities
									$id++;
									$resp = $id.' Virtual Account/Tax ID Generated Successfully';
									$this->Crud->activity('profile', $user_id, 'Tax ID Generated');

								} else {
									$resp = $e_id.' Error';
									$e_id++;
								}
							}
						}

						echo $this->Crud->msg('info', $resp);
						echo '<script>location.reload(false);</script>';
					}
					
					die;	
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
                if($this->Crud->check('phone', $param2, 'user') > 0){
					$otp = $this->Crud->read_field('phone', $param2, 'user', 'otp');
					if(empty($otp)){
						echo $this->Crud->msg('danger', 'No OTP Exist for this Phone Number');
					} else{
						echo $this->Crud->msg('success', 'The OTP is <b>'.$otp.'</b>');
					}
				} else{
					echo $this->Crud->msg('danger', 'Phone Number Does not Exist');
				}
            } else {
                echo $this->Crud->msg('danger', 'Phone Number cannot be Empty');
               
            } 
            
            die;
        }

		// record listing
		if($param1 == 'load') {
			$limit = $param2;
			$offset = $param3;

			$rec_limit = 25;
			$item = '';
            if(empty($limit)) {$limit = $rec_limit;}
			if(empty($offset)) {$offset = 0;}
			
			$search = $this->request->getPost('search');
			if(!empty($this->request->getVar('territory'))){$territory = $this->request->getVar('territory');}else{$territory = '';}


			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="text-dark sub-text"><b>'.translate_phrase('Unassigned Virtual Account').'</b></span></div>
					<div class="nk-tb-col nk-tb-col-tools">
						<ul class="nk-tb-actions gx-1 my-n1">
							
						</ul>
					</div>
				</div><!-- .nk-tb-item -->
		
				
			';
			$a = 1;

            //echo $status;
			$log_id = $this->session->get('td_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				
				$all_rec = $this->Crud->read_single('user_id', 0, 'virtual_account', '', '');
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }

				$query = $this->Crud->read_single('user_id', 0, 'virtual_account', $limit, $offset);
				$data['count'] = $counts;

				
				if(!empty($query)) {
					foreach ($query as $q) {
						$id = $q->id;
						$acc_no = $q->acc_no;
						$reg_date = date('M d, Y h:ia', strtotime($q->reg_date));


						// add manage buttons
						if ($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<a href="javascript:;" class="text-primary pop" pageTitle="Assign Virtual Account" pageName="' . site_url('accounts/'.$mod . '/manage/assign/' . $id) . '"><em class="icon ni ni-check-circle"></em><span>'.translate_phrase('Assign Virtual Account').'</span></a>
								
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-card">
										<div class="user-info">
											<span class="tb-lead">' . ucwords($acc_no) . '</span>
										</div>
									</div>
								</div>
								<div class="nk-tb-col nk-tb-col-tools">
									' . $all_btn . '
								</div>
							</div><!-- .nk-tb-item -->
						';
						$a++;
					}
				}
				
				
			}
			
			if(empty($item)) {
				$resp['item'] = $items.'
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="ni ni-cc-secure" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Virtual Account Returned').'
					</div>
				';
			} else {
				$resp['item'] = $items . $item;
				if($offset >= 25){
					$resp['item'] = $item;
				}
				
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
        
        $data['current_language'] = $this->session->get('current_language');
		if($param1 == 'manage') { // view for form data posting
			return view('accounts/'.$mod.'_form', $data);
		} else { // view for main page
			
			$data['title'] = translate_phrase('Virtual Assign').' | '.app_name;
			$data['page_active'] = 'accounts/virtual_assign';
			return view('accounts/'.$mod, $data);
		}
    }

}