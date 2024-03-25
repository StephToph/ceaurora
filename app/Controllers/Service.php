<?php

namespace App\Controllers;

class Service extends BaseController {
	public function type($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'service/type';

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
       
		
		$table = 'service_type';
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
						$del_id = $this->request->getVar('d_type_id');
						///// store activities
						$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
						$code = $this->Crud->read_field('id', $del_id, 'service_type', 'name');
						$action = $by.' deleted Service Type ('.$code.')';

						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							
							$this->Crud->activity('user', $del_id, $action);
							echo $this->Crud->msg('success', 'Service Type Deleted');
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
							}
						}
					}
				} 

				if($this->request->getMethod() == 'post'){
					$type_id = $this->request->getVar('type_id');
					$name = $this->request->getVar('name');

					$ins_data['name'] = $name;
					
					// do create or update
					if($type_id) {
						$upd_rec = $this->Crud->updates('id', $type_id, $table, $ins_data);
						if($upd_rec > 0) {
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
							$code = $this->Crud->read_field('id', $type_id, 'service_type', 'name');
							$action = $by.' updated Service Type ('.$code.')';
							$this->Crud->activity('service', $type_id, $action);

							echo $this->Crud->msg('success', 'Service Type Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', 'Service Type Already Exist');
						} else {
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
								$code = $this->Crud->read_field('id', $ins_rec, 'service_type', 'name');
								$action = $by.' created Service Type ('.$code.')';
								$this->Crud->activity('service', $ins_rec, $action);

								echo $this->Crud->msg('success', 'Service Type Created');
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
					<div class="nk-tb-col"><span class="sub-text">'.translate_phrase('Type').'</span></div>
					<div class="nk-tb-col nk-tb-col-tools">
						
					</div>
				</div><!-- .nk-tb-item -->
		
				
			';
			$a = 1;

            //echo $status;
			$log_id = $this->session->get('td_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">'.translate_phrase('Session Timeout! - Please login again').'</div>';
			} else {
				
				$all_rec = $this->Crud->filter_service_type('', '', $search);
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }

				$query = $this->Crud->filter_service_type($limit, $offset, $search);
				$data['count'] = $counts;
				

				if(!empty($query)) {
					foreach ($query as $q) {
						$id = $q->id;
						$name = $q->name;
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
						<i class="ni ni-building" style="font-size:150px;"></i><br/><br/>'.translate_phrase('No Service Type Returned').'<br/>
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
			
			$data['title'] = translate_phrase('Service Type').' - '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }

	public function report($param1='', $param2='', $param3='', $param4='') {
		// check session login
		if($this->session->get('td_id') == ''){
			$request_uri = uri_string();
			$this->session->set('td_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'service/report';

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
       
		
		$table = 'service_report';
		$form_link = site_url($mod);
		if($param1){$form_link .= '/'.$param1;}
		if($param2){$form_link .= '/'.$param2.'/';}
		if($param3){$form_link .= '/'.$param3.'/';}
		if($param4){$form_link .= $param4;}
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		$data['param4'] = $param4;
		$data['form_link'] = rtrim($form_link, '/');
        $data['current_language'] = $this->session->get('current_language');
		
		if($param1 == 'edit') {
			$edata = [];
			if($param2) {
				// echo $param2;
				$edit = $this->Crud->read_single('id', $param2, $table);
				if(!empty($edit)) {
					foreach($edit as $e) {
						$edata['e_id'] = $e->id;
						$edata['e_cell_id'] = $e->cell_id;
						$edata['e_type'] = $e->type;
						$edata['e_date'] = $e->date;
						$edata['e_attendance'] = $e->attendance;
						$edata['e_new_convert'] = $e->new_convert;
						$edata['e_first_timer'] = $e->first_timer;
						$edata['e_offering'] = $e->offering;
						$edata['e_note'] = $e->note;
						$edata['e_attendant'] = $e->attendant;
						$edata['e_timers'] = $e->timers;
						$edata['e_converts'] = $e->converts;
					}
				}
			}
			echo json_encode($edata);
			die;
		} 
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
						$action = $by.' deleted Cell Report';

						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							
							$this->Crud->activity('user', $del_id, $action);
							echo $this->Crud->msg('success', 'Report Deleted');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', 'Please try later');
						}
						exit;	
					}
				}
			
			} elseif($param2 == 'attendance'){
				
				$data['table_rec'] = 'service/report/list'; // ajax table
				$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
				$data['no_sort'] = '1'; // sort disable columns (1,3,5)
		
				if($param3) {
					$edit = $this->Crud->read2('type_id', $param3, 'type', 'cell', 'attendance');
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
							$data['d_attendant'] = $e->attendant;
						}
					}
					
				}
				//When Adding Save in Session
				if($this->request->getMethod() == 'post'){
					$guest = $this->request->getPost('guest');
					$total = $this->request->getPost('total');
					
					$mark = $this->session->get('service_attendance');

					
					// Decode the JSON string
					$data = json_decode($mark, true);

					// Change the values of "total" and "guest"
					$data['total'] = $total; // Change the value of "total"
					$data['guest'] = $guest; // Change the value of "guest"
					
					if(empty($data)){
						echo $this->Crud->msg('danger', 'Mark Service Attendance');
					
					} else{
						echo $this->Crud->msg('success', 'Service Attendance Submitted');
						// echo json_encode($mark);
						echo '<script> setTimeout(function() {
							var jsonData = ' . json_encode($data) . ';
							var jsonString = JSON.stringify(jsonData);
							$("#attendant").val(jsonString);
							$("#attendance").val('.$total.');
							$("#modal").modal("hide");
						}, 2000); </script>';
					}
					die;
				}

			} elseif($param2 == 'tithe'){
				
				$data['table_rec'] = 'service/report/tithe_list'; // ajax table
				$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
				$data['no_sort'] = '1'; // sort disable columns (1,3,5)
		
				if($param3) {
					$edit = $this->Crud->read2('type_id', $param3, 'type', 'cell', 'attendance');
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
							$data['d_attendant'] = $e->attendant;
						}
					}
					
				}
				//When Adding Save in Session
				if($this->request->getMethod() == 'post'){
					$guest = $this->request->getPost('guest');
					$total = $this->request->getPost('total');
					
					$mark = $this->session->get('service_attendance');

					
					// Decode the JSON string
					$data = json_decode($mark, true);

					// Change the values of "total" and "guest"
					$data['total'] = $total; // Change the value of "total"
					$data['guest'] = $guest; // Change the value of "guest"
					
					if(empty($data)){
						echo $this->Crud->msg('danger', 'Mark Service Attendance');
					
					} else{
						echo $this->Crud->msg('success', 'Service Attendance Submitted');
						// echo json_encode($mark);
						echo '<script> setTimeout(function() {
							var jsonData = ' . json_encode($data) . ';
							var jsonString = JSON.stringify(jsonData);
							$("#attendant").val(jsonString);
							$("#attendance").val('.$total.');
							$("#modal").modal("hide");
						}, 2000); </script>';
					}
					die;
				}

			} elseif($param2 == 'new_convert'){
				
					$edit = $this->Crud->read2('type_id', $param3, 'type', 'cell', 'attendance');
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
							$data['d_attendant'] = $e->attendant;
						}
					}
					//When Adding Save in Session
					if($this->request->getMethod() == 'post'){
						$first_name = $this->request->getPost('first_name');
						$surname = $this->request->getPost('surname');
						$email = $this->request->getPost('email');
						$phone = $this->request->getPost('phone');
						$dob = $this->request->getPost('dob');

						$converts = [];
						if(!empty($first_name) || !empty($surname)){
							for($i=0;$i<count($first_name);$i++){
								$converts['fullname'] = $first_name[$i].' '.$surname[$i];
								$converts['email'] = $email[$i];
								$converts['phone'] = $phone[$i];
								$converts['dob'] = $dob[$i];
								
								$convert[] = $converts;
							}
						}
						// echo json_encode($convert);
						if(empty($convert)){
							echo $this->Crud->msg('danger', 'Enter the New Convert Details');
							
						} else{
							$this->session->set('cell_convert', json_encode($convert));
							echo $this->Crud->msg('success', 'New Convert List Submitted');
							// echo json_encode($mark);
							
							echo '<script> setTimeout(function() {
								var jsonData = ' . json_encode($convert) . ';
								var jsonString = JSON.stringify(jsonData);
								$("#converts").val(jsonString);
								$("#modal").modal("hide");
							}, 2000); </script>';
						}
						die;
					}
				

			}elseif($param2 == 'first_timer'){
				
					
					//When Adding Save in Session
					if($this->request->getMethod() == 'post'){
						$first_name = $this->request->getPost('first_name');
						$surname = $this->request->getPost('surname');
						$email = $this->request->getPost('email');
						$phone = $this->request->getPost('phone');
						$dob = $this->request->getPost('dob');
						$invited_by = $this->request->getPost('invited_by');
						$channel = $this->request->getPost('channel');
						$member_id = $this->request->getPost('member_id');

						

						$converts = [];
						if(!empty($first_name) || !empty($surname)){
							for($i=0;$i<count($first_name);$i++){
								$invites = $member_id[$i];
								if($invited_by[$i] != 'Member'){
									$invites = $channel[$i];
								}
								$converts['fullname'] = $first_name[$i].' '.$surname[$i];
								$converts['email'] = $email[$i];
								$converts['phone'] = $phone[$i];
								$converts['dob'] = $dob[$i];
								$converts['invited_by'] = $invited_by[$i];
								$converts['channel'] = $invites;
								
								$convert[] = $converts;
							}
						}
						// echo json_encode($convert);
						// die;
						if(empty($convert)){
							echo $this->Crud->msg('danger', 'Enter the First Timer Details');
							
						} else{
							$this->session->set('cell_timers', json_encode($convert));
							echo $this->Crud->msg('success', 'First Timer List Submitted');
							// echo json_encode($mark);
							echo '<script> setTimeout(function() {
								var jsonData = ' . json_encode($convert) . ';
								var jsonString = JSON.stringify(jsonData);
								$("#converts").val(jsonString);
								$("#modal").modal("hide");
							}, 2000); </script>';
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
								$data['e_cell_id'] = $e->cell_id;
								$data['e_type'] = $e->type;
								$data['e_date'] = $e->date;
								$data['e_attendance'] = $e->attendance;
								$data['e_new_convert'] = $e->new_convert;
								$data['e_first_timer'] = $e->first_timer;
								$data['e_offering'] = $e->offering;
								$data['e_note'] = $e->note;
							}
						}
					}
				} 

				if($this->request->getMethod() == 'post'){
					$creport_id = $this->request->getVar('creport_id');
					$cell_id = $this->request->getVar('cell_id');
					$type = $this->request->getVar('type');
					$attendance = $this->request->getVar('attendance');
					$new_convert = $this->request->getVar('new_convert');
					$first_timer = $this->request->getVar('first_timer');
					$offering = $this->request->getVar('offering');
					$note = $this->request->getVar('note');
					$date = $this->request->getVar('dates');
					$attendant = $this->request->getVar('attendant');
					$converts = $this->request->getVar('converts');
					$timers = $this->request->getVar('timers');
					
					// echo $date;die;
					$dates = date('y-m-d', strtotime($date));

					
					$ins_data['cell_id'] = $cell_id;
					$ins_data['type'] = $type;
					$ins_data['date'] = $dates;
					$ins_data['attendance'] = $attendance;
					$ins_data['new_convert'] = $new_convert;
					$ins_data['first_timer'] = $first_timer;
					$ins_data['offering'] = $offering;
					$ins_data['note'] = $note;
					
					if(!empty($attendant)){$attend = $attendant;}else{$attend = $this->session->get('cell_attendance');}
					if(!empty($converts)){$conv = $converts;}else{$conv = $this->session->get('cell_convert');}
					if(!empty($timers)){$times = $timers;}else{$times = $this->session->get('cell_timers');}
					// do create or update
					if($creport_id) {
						
						$ins_data['attendant'] = $attend;
						$ins_data['converts'] = $conv;
						$ins_data['timers'] = $times;
								
						$upd_rec = $this->Crud->updates('id', $creport_id, $table, $ins_data);
						if($upd_rec > 0) {
							$at['attendant'] = $this->session->get('cell_attendance');
							$at_id = $this->Crud->read_field2('type_id', $creport_id, 'type', 'cell', 'attendance', 'id');
							$this->Crud->updates('id', $at_id, 'attendance', $at);
							$this->session->set('cell_attendance', '');
							$this->session->set('cell_convert', '');
							
							$this->session->set('cell_timers', '');
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
							$action = $by.' updated Cell Meeting Report';
							$this->Crud->activity('user', $cell_id, $action);

							echo $this->Crud->msg('success', 'Report Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						// echo $date;
						if($this->Crud->check('date', $dates, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_data['attendant'] = $this->session->get('cell_attendance');
							$ins_data['converts'] = $this->session->get('cell_convert');
							$ins_data['timers'] = $this->session->get('cell_timers');
							
							$ins_data['reg_date'] = date(fdate);
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								$at['type'] = 'cell';
								$at['type_id'] = $ins_rec;
								$at['attendant'] = $this->session->get('cell_attendance');
								$at['reg_date'] = date(fdate);
								$this->Crud->create('attendance', $at);
								$this->session->set('cell_attendance', '');
								$this->session->set('cell_convert', '');
								$this->session->set('cell_timers', '');
								
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
								$action = $by.' created a Cell Meeting Report for ('.$date.')';
								$this->Crud->activity('user', $ins_rec, $action);

								echo $this->Crud->msg('success', 'Report Created');
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
		
		//Get Role
		if($param1 == 'gets'){
			$total = $this->request->getPost('total');
			$member = $this->request->getPost('member');
			$guest = $this->request->getPost('guest');
			$male = $this->request->getPost('male');
			$female = $this->request->getPost('female');
			$children = $this->request->getPost('children');
			$vals = $this->request->getPost('vals');
			$applicants = $this->request->getPost('applicant');
			
			$applicant = json_decode($applicants);
			// print_r($applicant);
			$service = [];
			$service_total = [];
			if($vals){
				$total += 1;
				$member += 1;
				if($this->Crud->check2('id', $param2, 'gender', 'Male', 'user') > 0)$male += 1;
				if($this->Crud->check2('id', $param2, 'gender', 'Female', 'user') > 0)$female += 1;
				if($this->Crud->check2('id', $param2, 'family_position', 'Child', 'user') > 0)$children += 1;
				
				if(!empty($applicant)){
					$applicant[] = $param2;
				} else {
					$applicant[] = $param2;
				}
				
			} else {
				$total -= 1;
				$member -= 1;
				if($this->Crud->check2('id', $param2, 'gender', 'Male', 'user') > 0)$male -= 1;
				if($this->Crud->check2('id', $param2, 'gender', 'Female', 'user') > 0)$female -= 1;
				if($this->Crud->check2('id', $param2, 'family_position', 'Child', 'user') > 0)$children -= 1;
				
				$key = array_search($param2, $service);
				if ($key !== false) {
					unset($service[$key]);
				}

			}

			// print_r($applicant);
			$service_total['total'] = $total;
			$service_total['member'] = $member;
			$service_total['male'] = $male;
			$service_total['guest'] = $guest;
			$service_total['children'] = $children;
			$service_total['female'] = $female;
			$service_total['attendant'] = $applicant;
			

			$total = $guest + $member;
			$this->session->set('service_attendance', json_encode($service_total));
			// print_r($service_total);
			echo '
				<script>
					$("#total").val('.$total.');
					$("#member").val('.$member.');
					$("#guest").val('.$guest.');
					$("#male").val('.$male.');
					$("#female").val('.$female.');
					$("#children").val('.$children.');
					var jsonData = ' . json_encode($applicant) . ';
					var jsonString = JSON.stringify(jsonData);
					$("#applicant").val(jsonString);
					
				</script>
			';
			die;
		}
		// record listing
		if($param1 == 'list') {
			// DataTable parameters
			$table = 'user';
			$column_order = array('firstname', 'surname');
			$column_search = array('firstname', 'surname');
			$order = array('firstname' => 'asc');
			$member_id = $this->Crud->read_field('name', 'Member', 'access_role', 'id');
			$where = array('role_id' => $member_id);
			
			// load data into table
			$list = $this->Crud->datatable_load($table, $column_order, $column_search, $order, $where);
			$data = array();
			// $no = $_POST['start'];
			$count = 1;
			foreach ($list as $item) {
				$id = $item->id;
				$name = $item->firstname;
				$surname = $item->surname;
				$img = $this->Crud->image($item->img_id, 'big');
				// add manage buttons

				$attend = $this->session->get('service_attendance');
				// print_r($attend);
				$sel = '';
				if(!empty($attend)){
					$attends = json_decode($attend);
					$ats = (array)$attends;
					foreach($ats as $a => $val){
						if($a == 'attendant'){
							// $vall = json_decode($val);
							if(in_array($item->id, (array)$val)){
								$sel = 'checked';
							}
						}
					}
					
					
				}
				$all_btn = '
					<div class="text-center">
						<div class="custom-control custom-switch">    
							<input type="checkbox" name="mark[]" class="custom-control-input" id="customSwitch'.$item->id.'" '.$sel.' onclick="marks('.$item->id.')"  value="'.$item->id.'">    
							<label class="custom-control-label" for="customSwitch'.$item->id.'">Mark</label>
						</div>
						
					</div>
				';
				
				
				$row = array();
				$row[] = '<div class="user-card">
							<div class="user-avatar ">
								<img alt="" src="'.site_url($img).'" height="40px"/>
							</div>
							<div class="user-info">
								<span class="tb-lead">'.ucwords($item->firstname.' '.$item->surname).'</span>
							</div>
						</div>';
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
		
		if($param1 == 'tithe_list') {
			// DataTable parameters
			$table = 'user';
			$column_order = array('firstname', 'surname');
			$column_search = array('firstname', 'surname');
			$order = array('firstname' => 'asc');
			$member_id = $this->Crud->read_field('name', 'Member', 'access_role', 'id');
			$where = array('role_id' => $member_id);
			
			// load data into table
			$list = $this->Crud->datatable_load($table, $column_order, $column_search, $order, $where);
			$data = array();
			// $no = $_POST['start'];
			$count = 1;
			foreach ($list as $item) {
				$id = $item->id;
				$name = $item->firstname;
				$surname = $item->surname;
				$img = $this->Crud->image($item->img_id, 'big');
				// add manage buttons

				$attend = $this->session->get('service_attendance');
				// print_r($attend);
				$sel = '';
				// if(!empty($attend)){
				// 	$attends = json_decode($attend);
				// 	$ats = (array)$attends;
				// 	foreach($ats as $a => $val){
				// 		if($a == 'attendant'){
				// 			// $vall = json_decode($val);
				// 			if(in_array($item->id, (array)$val)){
				// 				$sel = 'checked';
				// 			}
				// 		}
				// 	}
					
					
				// }
				$all_btn = '
					<div class="text-center">
						<input type="text" class="form-control tithes" name="tithe[]" id="tithe_'.$item->id.'" oninput="add_tithe('.$item->id.')" value="0">
					</div>
				';
				
				
				$row = array();
				$row[] = '<div class="user-card">
							<div class="user-avatar ">
								<img alt="" src="'.site_url($img).'" height="40px"/>
							</div>
							<div class="user-info">
								<span class="tb-lead">'.ucwords($item->firstname.' '.$item->surname).'</span>
							</div>
						</div>';
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

			$rec_limit = 45;
			$item = '';
            if(empty($limit)) {$limit = $rec_limit;}
			if(empty($offset)) {$offset = 0;}
			
			$search = $this->request->getPost('search');
			
			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text text-dark">'.translate_phrase('Date').'</span></div>
					<div class="nk-tb-col"><span class="sub-text text-dark">'.translate_phrase('Meeting').'</span></div>
					<div class="nk-tb-col"><span class="sub-text text-dark">'.translate_phrase('Offering').'</span></div>
					<div class="nk-tb-col nk-tb-col-md"><span class="sub-text text-dark">'.translate_phrase('Attendance').'</span></div>
					<div class="nk-tb-col nk-tb-col-md"><span class="sub-text text-dark">'.('FT').'</span></div>
					<div class="nk-tb-col nk-tb-col-md"><span class="sub-text text-dark">'.('NC').'</span></div>
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
				
				$all_rec = $this->Crud->filter_service_report('', '', $search);
                // $all_rec = json_decode($all_rec);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }

				$query = $this->Crud->filter_service_report($limit, $offset, $search);
				$data['count'] = $counts;
				

				if(!empty($query)) {
					foreach ($query as $q) {
						$id = $q->id;
						$type = $q->type;
						$cell_id = $q->cell_id;
						$attendance = $q->attendance;
						$offering = $q->offering;
						$new_convert = $q->new_convert;
						$first_timer = $q->first_timer;
						$date = date('d M Y', strtotime($q->date));
						$reg_date = $q->reg_date;

						$types = '';
						if($type == 'wk1')$types = 'WK1 - Prayer and Planning';
						if($type == 'wk2')$types = 'Wk2 - Bible Study';
						if($type == 'wk3')$types = 'Wk3 - Bible Study';
						if($type == 'wk4')$types = 'Wk4 - Fellowship / Outreach';
						
						$cell='';
						if($role == 'developer' || $role == 'administrator'){
							$cell = '<span class="text-info"><em class="icon ni ni-curve-down-right"></em> <span>'.strtoupper($this->Crud->read_field('id', $cell_id, 'cells', 'name')).'</span></span>';
						}
						// add manage buttons
						if ($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<li><a href="javascript:;" class="text-primary" onclick="edit_report('.$id.')"><em class="icon ni ni-edit-alt"></em><span>'.translate_phrase('Edit').'</span></a></li>
								<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete" pageName="' . site_url($mod . '/manage/delete/' . $id) . '"><em class="icon ni ni-trash-alt"></em><span>'.translate_phrase('Delete').'</span></a></li>
								<li><a href="javascript:;" class="text-success pop" pageTitle="View Report" pageName="' . site_url($mod . '/manage/report/' . $id) . '" pageSize="modal-xl"><em class="icon ni ni-eye"></em><span>'.translate_phrase('View').'</span></a></li>
								
								
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-info">
										<span class="tb-lead">' . ucwords($date) . ' </span>
										'.$cell.'
									</div>
								</div>
								<div class="nk-tb-col">
									<span class="text-dark">' . ucwords($types) . '</span>
								</div>
								<div class="nk-tb-col">
									<span class="text-dark">$' . number_format($offering,2) . '</span>
								</div>
								<div class="nk-tb-col tb-col">
									<span class="text-dark"><span>' . ucwords($attendance) . '</b></span>
								</div>
								<div class="nk-tb-col tb-col">
									<span class="text-dark"><span>' . ucwords($first_timer) . '</b></span>
								</div>
								<div class="nk-tb-col tb-col">
									<span class="text-dark"><span>' . ucwords($new_convert) . '</b></span>
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
						<i class="ni ni-linux-server" style="font-size:100px;"></i><br/><br/>'.translate_phrase('No Report Returned').'
					</div>
				';
			} else {
				$resp['item'] = $items . $item;
				if($offset >= 45){
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
			$this->session->set('service_attendance', '');
			$data['title'] = translate_phrase('Service Report').' - '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
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