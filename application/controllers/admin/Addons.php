<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addons extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		is_login();
	}

	public function index()
	{
		$data = array();
		$data['page_title'] = "Add Ons";
        $data['page'] = "Settings";
        $data['settings']=$this->admin_m->single_select('settings');
        $data['addonsList']= $this->admin_m->select('addons_list');
		$data['main_content'] = $this->load->view('backend/addons/addons_list', $data, TRUE);
		$this->load->view('backend/index',$data);
		
	}


	public function uninstall($id)
	{
		$data = [
			'active_code' => '',
			'active_key' => '',
			'purchase_date' => '',
			'status' => 0,
			'is_install' => 0,
		];
		$this->admin_m->update($data,$id,'addons_list');
		$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
		redirect($_SERVER['HTTP_REFERER']);
	}


	public function install_addons(){
		is_test();
		$id = $this->input->post('id');
		$this->form_validation->set_rules('purchase_code', 'Purchase Code', 'trim|xss_clean|required');
		$this->form_validation->set_rules('script_purchase_code', 'Script Purchase Code', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	
			$purchase_code = $this->input->post('purchase_code',TRUE);
			$script_purchase_code = $this->input->post('script_purchase_code',TRUE);
			$a_code = genCode();

				$data = array(
					'active_code' => $a_code,
					'purchase_code' =>$purchase_code,
					'slug' =>'qpos',
					'script_purchase_code' =>$script_purchase_code,
					'item_id' =>1,
					'script_name' =>'QPos',
					'site_url' => SITE_URL,
					'active_key' => genKey($code, $purchase_code, $script_purchase_code),
					'license_name' => 'LN'.$a_code,
					'license_code' => 'L'.$a_code,
					'purchase_date' => d_time(),
					'activated_date' => add_date('1','month'),
					'is_install' => 1,
					'is_active' => 1,
					'status' => 1,
					'active_date' =>d_time(),
					'created_at' =>d_time(),
				); 


				$check = $this->admin_m->check_using_purchase_code($check_valid->purchase_code);
				$this->load->model('system_model');
				$move = $this->system_model->get_controller_files('qpos');
				$move1 = $this->system_model->get_model_files('qpos');
				if($move==1 && $move1==1):
					if(!$check != 1){
						$insert = $this->admin_m->update($data,$check->id,'addons_list');
					}else{
						$insert = $this->admin_m->insert($data,'addons_list');
					}
				else:
					$this->session->set_flashdata('error', $move);
					redirect(base_url('admin/addons'));
				endif;

				if($insert){
					$this->load->model('Updated_queries');
					$this->Updated_queries->add_permissions('qpos');
					$this->Updated_queries->add_features('qpos');
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/addons'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/addons'));
				}	
		}
	}



	protected function verify_purchase($purchase_code,$script_purchase_code){
		// check_valid_purchases
		$form_data = array(
			'purchase_code'  => $purchase_code,
			'script_purchase_code'  => $script_purchase_code,
			'site_url'  => SITE_URL,
			'is_addons'  => 1,
			'author'  => 'codetrick',
		);

		$form_data = json_encode($form_data);
		$ch = curl_init(URL."install-addons");  
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data);                   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($ch, CURLOPT_POST,1);                                    
		$result = curl_exec($ch);
		curl_close($ch);
		return $result = json_decode($result);
	}

}
