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
		
			$data['title'] = translate_phrase('Administrators').' - '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
	}

	//Customer
	public function dept($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'accounts/dept';

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
       
		
		$table = 'dept';
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
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}

					if($this->request->getMethod() == 'post'){
						$del_id = $this->request->getVar('d_dept_id');
						///// store activities
						$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
						$code = $this->Crud->read_field('id', $del_id, 'dept', 'name');
						$action = $by.' deleted Department ('.$code.') Record';

						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							
							$this->Crud->activity('user', $del_id, $action);
							echo $this->Crud->msg('success', 'Department Deleted');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', 'Please try later');
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
								$data['e_name'] = $e->name;
								$data['e_roles'] = json_decode($e->roles);
							}
						}
					}
				} 

				if($this->request->getMethod() == 'post'){
					$dept_id = $this->request->getVar('dept_id');
					$name = $this->request->getVar('name');
					$roles = $this->request->getVar('roles');

					$ins_data['name'] = $name;
					$ins_data['roles'] = json_encode($roles);
					// print_r($roles);
					// die;
					// do create or update
					if($dept_id) {
						$upd_rec = $this->Crud->updates('id', $dept_id, $table, $ins_data);
						if($upd_rec > 0) {
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
							$code = $this->Crud->read_field('id', $dept_id, 'dept', 'name');
							$action = $by.' updated Department ('.$code.') Record';
							$this->Crud->activity('user', $dept_id, $action);

							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
								$code = $this->Crud->read_field('id', $ins_rec, 'dept', 'name');
								$action = $by.' created Department ('.$code.') Record';
								$this->Crud->activity('user', $ins_rec, $action);

								echo $this->Crud->msg('success', 'Record Created');
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', 'Please try later');	
							}	
						}
					}

					die;	
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
			
			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Name').'</span></div>
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Role(s)').'</span></div>
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
				
				$all_rec = $this->Crud->filter_dept('', '', '', $log_id, $search);
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }

				$query = $this->Crud->filter_dept($limit, $offset, '', $log_id, $search);
				$data['count'] = $counts;
				

				if(!empty($query)) {
					foreach ($query as $q) {
						$id = $q->id;
						$name = $q->name;
						$roles = $q->roles;
						$rolesa = json_decode($roles);
						$rols = '';
						if(!empty($rolesa)){
							foreach($rolesa as $r => $val){
								$rols .= $val.', ';
							}
						}
						// add manage buttons
						if ($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<li><a href="javascript:;" class="text-primary pop" pageTitle="Edit ' . $name . '" pageName="' . site_url($mod . '/manage/edit/' . $id) . '"><em class="icon ni ni-edit-alt"></em><span>'.translate_phrase('Edit').'</span></a></li>
								<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete ' . $name . '" pageName="' . site_url($mod . '/manage/delete/' . $id) . '"><em class="icon ni ni-trash-alt"></em><span>'.translate_phrase('Delete').'</span></a></li>
								
								
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-info">
										<span class="tb-lead">' . ucwords($name) . ' </span>
									</div>
								</div>
								<div class="nk-tb-col tb-col">
									<span class="text-dark"><b>' . ucwords(rtrim($rols, ', ')) . '</b></span>
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
						<i class="ni ni-building" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Department Returned').'
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
			
			$data['title'] = translate_phrase('Departments').' - '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }

	//Customer
	public function cell($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'accounts/cell';

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
       
		
		$table = 'cells';
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
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}

					if($this->request->getMethod() == 'post'){
						$del_id = $this->request->getVar('d_cell_id');
						///// store activities
						$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
						$code = $this->Crud->read_field('id', $del_id, 'cell', 'name');
						$action = $by.' deleted Cell ('.$code.') Record';

						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							
							$this->Crud->activity('user', $del_id, $action);
							echo $this->Crud->msg('success', 'Cell Deleted');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', 'Please try later');
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
								$data['e_location'] = $e->location;
								$data['e_name'] = $e->name;
								$data['e_roles'] = json_decode($e->roles);
								$data['e_time'] = json_decode($e->time);
							}
						}
					}
				} 

				if($this->request->getMethod() == 'post'){
					$cell_id = $this->request->getVar('cell_id');
					$name = $this->request->getVar('name');
					$roles = $this->request->getVar('roles');
					$location = $this->request->getVar('location');
					$times = $this->request->getVar('times');
					$days = $this->request->getVar('days');
					
					$time = [];
					for($i=0;$i < count($days);$i++ ){
						$day = $days[$i];
						// echo $day;
						$time[$day] = $times[$i];
					}
					// print_r($time);
					// print_r($days);
					// die;
					$ins_data['name'] = $name;
					$ins_data['roles'] = json_encode($roles);
					$ins_data['location'] = $location;
					$ins_data['time'] = json_encode($time);
					
					// do create or update
					if($cell_id) {
						$upd_rec = $this->Crud->updates('id', $cell_id, $table, $ins_data);
						if($upd_rec > 0) {
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
							$code = $this->Crud->read_field('id', $cell_id, 'dept', 'name');
							$action = $by.' updated Department ('.$code.') Record';
							$this->Crud->activity('user', $cell_id, $action);

							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
								$code = $this->Crud->read_field('id', $ins_rec, 'dept', 'name');
								$action = $by.' created Department ('.$code.') Record';
								$this->Crud->activity('user', $ins_rec, $action);

								echo $this->Crud->msg('success', 'Record Created');
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', 'Please try later');	
							}	
						}
					}

					die;	
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
			
			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text text-dark">'.translate_phrase('Name').'</span></div>
					<div class="nk-tb-col nk-tb-col-md"><span class="sub-text text-dark">'.translate_phrase('Location').'</span></div>
					<div class="nk-tb-col"><span class="sub-text text-dark">'.translate_phrase('Role(s)').'</span></div>
					<div class="nk-tb-col nk-tb-col-md"><span class="sub-text text-dark">'.('Day/Time').'</span></div>
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
				
				$all_rec = $this->Crud->filter_cell('', '', $search);
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }

				$query = $this->Crud->filter_cell($limit, $offset, $search);
				$data['count'] = $counts;
				

				if(!empty($query)) {
					foreach ($query as $q) {
						$id = $q->id;
						$name = $q->name;
						$location = $q->location;
						$time = $q->time;
						$roles = $q->roles;
						$rolesa = json_decode($roles);
						$rols = '';
						if(!empty($rolesa)){
							foreach($rolesa as $r => $val){
								$rols .= $val.', ';
							}
						}

						$times = '<span class="text-danger">No Meeting Time</span>';
						if(!empty($time)){
							$times = '<a href="javascript:;" class="text-primary pop" pageTitle="View Time " pageName="' . site_url($mod . '/manage/view/' . $id) . '"><em class="icon ni ni-eye"></em> <span>'.translate_phrase('View Meeting Time').'</span></a>';
						}
						// add manage buttons
						if ($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<li><a href="javascript:;" class="text-primary pop" pageTitle="Edit ' . $name . '" pageName="' . site_url($mod . '/manage/edit/' . $id) . '"><em class="icon ni ni-edit-alt"></em><span>'.translate_phrase('Edit').'</span></a></li>
								<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete ' . $name . '" pageName="' . site_url($mod . '/manage/delete/' . $id) . '"><em class="icon ni ni-trash-alt"></em><span>'.translate_phrase('Delete').'</span></a></li>
								
								
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-info">
										<span class="tb-lead">' . ucwords($name) . ' </span>
									</div>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="text-dark">' . ucwords($location) . '</span>
								</div>
								<div class="nk-tb-col tb-col">
									<span class="text-dark"><b>' . ucwords(rtrim($rols, ', ')) . '</b></span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="text-dark">' . ($times) . '</span>
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
						<i class="ni ni-tranx" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Cell Returned').'
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
			
			$data['title'] = translate_phrase('Cells').' - '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }

	//Customer
	public function membership($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'accounts/membership';

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
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}

					if($this->request->getMethod() == 'post'){
						$del_id = $this->request->getVar('d_cell_id');
						///// store activities
						$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
						$code = $this->Crud->read_field('id', $del_id, 'cell', 'name');
						$action = $by.' deleted Cell ('.$code.') Record';

						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							
							$this->Crud->activity('user', $del_id, $action);
							echo $this->Crud->msg('success', 'Cell Deleted');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', 'Please try later');
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
								$data['e_location'] = $e->location;
								$data['e_name'] = $e->name;
								$data['e_roles'] = json_decode($e->roles);
								$data['e_time'] = json_decode($e->time);
							}
						}
					}
				} 

				if($this->request->getMethod() == 'post'){
					$cell_id = $this->request->getVar('cell_id');
					$name = $this->request->getVar('name');
					$roles = $this->request->getVar('roles');
					$location = $this->request->getVar('location');
					$times = $this->request->getVar('times');
					$days = $this->request->getVar('days');
					
					$time = [];
					for($i=0;$i < count($days);$i++ ){
						$day = $days[$i];
						// echo $day;
						$time[$day] = $times[$i];
					}
					// print_r($time);
					// print_r($days);
					// die;
					$ins_data['name'] = $name;
					$ins_data['roles'] = json_encode($roles);
					$ins_data['location'] = $location;
					$ins_data['time'] = json_encode($time);
					
					// do create or update
					if($cell_id) {
						$upd_rec = $this->Crud->updates('id', $cell_id, $table, $ins_data);
						if($upd_rec > 0) {
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
							$code = $this->Crud->read_field('id', $cell_id, 'dept', 'name');
							$action = $by.' updated Department ('.$code.') Record';
							$this->Crud->activity('user', $cell_id, $action);

							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
								$code = $this->Crud->read_field('id', $ins_rec, 'dept', 'name');
								$action = $by.' created Department ('.$code.') Record';
								$this->Crud->activity('user', $ins_rec, $action);

								echo $this->Crud->msg('success', 'Record Created');
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', 'Please try later');	
							}	
						}
					}

					die;	
				}
			}
		}

		// manage record
		if($param1 == 'manages') {
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}

					if($this->request->getMethod() == 'post'){
						$del_id = $this->request->getVar('d_cell_id');
						///// store activities
						$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
						$code = $this->Crud->read_field('id', $del_id, 'cell', 'name');
						$action = $by.' deleted Cell ('.$code.') Record';

						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							
							$this->Crud->activity('user', $del_id, $action);
							echo $this->Crud->msg('success', 'Cell Deleted');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', 'Please try later');
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
								$data['e_firstname'] = $e->firstname;
								$data['e_surname'] = $e->surname;
								$data['e_gender'] = $e->gender;
								$data['e_othername'] = $e->othername;
								$data['e_email'] = $e->email;
								$data['e_title'] = $e->title;
								$data['e_phone'] = $e->phone;
								$data['e_address'] = $e->address;
								$data['e_gender'] = $e->gender;
								$data['e_chat_handle'] = $e->chat_handle;
								$data['e_dob'] = $e->dob;
								$data['e_family_status'] = $e->family_status;
								$data['e_family_position'] = $e->family_position;
								$data['e_cell_id'] = $e->cell_id;
								$data['e_cell_role'] = $e->cell_role;
								$data['e_dept_id'] = $e->dept_id;
								$data['e_dept_role'] = $e->dept_role;
								$data['e_parent_id'] = $e->parent_id;
								
							}
						}
					}
				} 

				if($this->request->getMethod() == 'post'){
					$membership_id = $this->request->getVar('membership_id');
					$firstname = $this->request->getVar('firstname');
					$lastname = $this->request->getVar('lastname');
					$othername = $this->request->getVar('othername');
					$gender = $this->request->getVar('gender');
					$email = $this->request->getVar('email');
					$phone = $this->request->getVar('phone');
					$dob = $this->request->getVar('dob');
					$chat_handle = $this->request->getVar('chat_handle');
					$address = $this->request->getVar('address');
					$family_status = $this->request->getVar('family_status');
					$family_position = $this->request->getVar('family_position');
					$parent_id = $this->request->getVar('parent_id');
					$dept_id = $this->request->getVar('dept_id');
					$dept_role_id = $this->request->getVar('dept_role_id');
					$cell_id = $this->request->getVar('cell_id');
					$cell_role_id = $this->request->getVar('cell_role_id');
					$title = $this->request->getVar('title');
					$password = $this->request->getVar('password');
					
					
					$ins_data['title'] = $title;
					$ins_data['firstname'] = $firstname;
					$ins_data['othername'] = $othername;
					$ins_data['surname'] = $lastname;
					$ins_data['email'] = $email;
					$ins_data['phone'] = $phone;
					$ins_data['gender'] = $gender;
					$ins_data['address'] = $address;
					$ins_data['chat_handle'] = $chat_handle;
					$ins_data['dob'] = $dob;
					$ins_data['family_status'] = $family_status;
					$ins_data['family_position'] = $family_position;
					$ins_data['parent_id'] = $parent_id;
					$ins_data['dept_id'] = $dept_id;
					$ins_data['dept_role'] = $dept_role_id;
					$ins_data['cell_id'] = $cell_id;
					$ins_data['cell_role'] = $cell_role_id;
					if($password) { $ins_data['password'] = md5($password); }
					
					// do create or update
					if($membership_id) {
						$upd_rec = $this->Crud->updates('id', $membership_id, $table, $ins_data);
						if($upd_rec > 0) {
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
							$code = $this->Crud->read_field('id', $membership_id, 'user', 'firstname');
							$action = $by.' updated Membership ('.$code.') Record';
							$this->Crud->activity('user', $membership_id, $action);

							echo $this->Crud->msg('success', 'Membership Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check('firstname', $firstname, $table) > 0) {
							echo $this->Crud->msg('warning', 'Membership Already Exist');
						} else {
							$role_id = $this->Crud->read_field('name', 'Member', 'access_role', 'id');
							$ins_data['role_id'] = $role_id;
							$ins_data['activate'] = 1;
							$ins_data['reg_date'] = date(fdate);
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
								$code = $this->Crud->read_field('id', $ins_rec, 'dept', 'name');
								$action = $by.' created Membership ('.$code.') Record';
								$this->Crud->activity('user', $ins_rec, $action);

								echo $this->Crud->msg('success', 'Membership Created');
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', 'Please try later');	
							}	
						}
					}

					die;	
				}
			}
		}

		if($param1 == 'get_dept_role'){
			if(!empty($param2)){
				
				$li = '';
				$dept = $this->Crud->read_field('id', $param2, 'dept', 'name');
				$dept_role = $this->Crud->read_field('id', $param2, 'dept', 'roles');
				if($dept != 'member'){
					$li = '<option value="">Select Deparment Role</option>';
					if(!empty($dept_role)){
						foreach(json_decode($dept_role) as $r => $val){
							$li .= '<option value="'.$val.'">'.ucwords($val).'</option>';
						}
					}
				}
				$resp['list'] = $li;
				$resp['script'] = '<script>$("#dept_resp").show(500);</script>';

				echo json_encode($resp);
				die;
			}
		}

		if($param1 == 'get_cell_role'){
			if(!empty($param2)){
				
				$li = '';
				$dept = $this->Crud->read_field('id', $param2, 'cells', 'name');
				$dept_role = $this->Crud->read_field('id', $param2, 'cells', 'roles');
				$li = '<option value="">Select Cell Role</option>';
				if(!empty($dept_role)){
					foreach(json_decode($dept_role) as $r => $val){
						$li .= '<option value="'.$val.'">'.ucwords($val).'</option>';
					}
				}
			
				$resp['list'] = $li;
				$resp['script'] = '<script>$("#cell_resp").show(500);</script>';

				echo json_encode($resp);
				die;
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
			
			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text text-dark">'.translate_phrase('Full Name').'</span></div>
					<div class="nk-tb-col nk-tb-col-md"><span class="sub-text text-dark">'.translate_phrase('Kingschat Handle').'</span></div>
					<div class="nk-tb-col"><span class="sub-text text-dark">'.translate_phrase('Contact').'</span></div>
					<div class="nk-tb-col nk-tb-col-md"><span class="sub-text text-dark">'.('Title').'</span></div>
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
				
				$all_rec = $this->Crud->filter_membership('', '', $log_id, $search);
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$query = $this->Crud->filter_membership($limit, $offset, $log_id, $search);
				$data['count'] = $counts;
				

				if(!empty($query)) {
					foreach ($query as $q) {
						$id = $q->id;
						$firstname = $q->firstname;
						$othername = $q->othername;
						$surname = $q->surname;
						$phone = $q->phone;
						$email = $q->email;
						$chat_handle = $q->chat_handle;
						$title = $q->title;
						$activate = $q->activate;
						
						$name = $surname.' '.$firstname.' '.$othername;

						if(empty($phone))$phone = '-';
						if(empty($email))$email = '-';
						
						// add manage buttons
						if ($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<li><a href="javascript:;" class="text-info" pageTitle="Edit ' . $name . '" pageName="' . site_url($mod . '/manages/edit/' . $id) . '"><em class="icon ni ni-edit-alt"></em><span>'.translate_phrase('Edit').'</span></a></li>
								<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete ' . $name . '" pageName="' . site_url($mod . '/manage/delete/' . $id) . '"><em class="icon ni ni-trash-alt"></em><span>'.translate_phrase('Delete').'</span></a></li>
								
								
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-info">
										<span class="tb-lead"><b>' . ucwords($name) . '</b> </span>
									</div>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="text-dark">' . ucwords($chat_handle) . '</span>
								</div>
								<div class="nk-tb-col tb-col">
									<span class="text-dark"><b>Email-> </b>' . ($email) .' <br><b>Phone-> </b>'.$phone.'</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="text-dark">' . ($title) . '</span>
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
						<i class="ni ni-tranx" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Cell Returned').'
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
		}elseif($param1 == 'manages'){
			
			$data['page_active'] = $mod;
			$data['title'] = translate_phrase('New Membership').' - '.app_name;
			if($param2 == 'edit')$data['title'] = translate_phrase('Edit Membership').' - '.app_name;
			return view($mod.'_edit', $data);
		} else { // view for main page
			
			$data['title'] = translate_phrase('Membership').' - '.app_name;
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


}