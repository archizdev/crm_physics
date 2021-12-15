<?php
class Holiday extends CI_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'location_model', 'User_model', 'Holiday_Model'
		));
	}
	public function index()
	{
		if (user_role('531') == true) {}
		if ($_POST) {
			$data = $_POST;
			foreach ($_POST['city'] as $city) {
				$data['city'] = $city;
				$data['comp_id'] = $this->session->userdata('companey_id');
				$this->Holiday_Model->add_holiday($data);
			}
		}
		$data['title'] = "Add Holiday";
		$data['user_list'] = $this->User_model->companey_users();
		$data['festivals']  = $this->Holiday_Model->getFestival();
		$data['state'] = $this->location_model->estate_list();
		$data['holiday_table'] = $this->Holiday_Model->holiday_table();
		$data['content'] = $this->load->view('add-holiday', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	public function add_festival()
	{
		if (user_role('530') == true) {}
		$this->load->model('User_model');
		$this->load->model('Holiday_Model');
		if ($_POST) {
			//check festivsl already exist or not
			$data = ['festival_name' => $this->input->post('festival_name'), 'comp_id' => $this->session->userdata('companey_id')];
			$getFestivals = $this->Holiday_Model->getFestival($data);
			if ($getFestivals->num_rows() == 0) {
				$data = ['festival_name' => $this->input->post('festival_name'), 'comp_id' => $this->session->userdata('companey_id')];
				$this->Holiday_Model->add_festival($data);
				$this->session->set_flashdata('SUCCESSMSG', 'Festival Added.');
				redirect(base_url('Holiday/add-festival'));
			} else {
				$this->session->set_flashdata('SUCCESSMSG', 'Festival alredy Exist.');
				redirect(base_url('Holiday/add-festival'));
			}
		}
		$data['title'] = "Add Festival";
		$data['user_list'] = $this->User_model->companey_users();
		$data['festivals']  = $this->Holiday_Model->getFestival();
		$data['content'] = $this->load->view('add-festival', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	public function edit_festival($fest_id)
	{
		if (user_role('530') == true) {}
		$this->load->model('User_model');
		$this->load->model('Holiday_Model');
		if ($_POST) {
			$data = ['festival_name' => $this->input->post('festival_name'), 'comp_id' => $this->session->userdata('companey_id')];
			$getFestivals = $this->Holiday_Model->getFestivalNotID($data, $fest_id);
			if ($getFestivals->num_rows() == 0) {
				$this->Holiday_Model->update_festival($data, array('id' => $fest_id));
				redirect(base_url('Holiday/edit-festival/' . $fest_id));
			} else {
				$this->session->set_flashdata('SUCCESSMSG', 'Festival alredy Exist.');
				redirect(base_url('Holiday/edit-festival/' . $fest_id));
			}
		}
		$data['title'] = "Edit Festival";
		$data['user_list'] = $this->User_model->companey_users();
		$data['festival']  = $this->Holiday_Model->getFestival(array('id' => $fest_id))->row();
		$data['content'] = $this->load->view('edit-festival', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	public function edit_holiday($holi_id)
	{
		if (user_role('531') == true) {}
		$this->load->model('User_model');
		$this->load->model('Holiday_Model');
		if ($_POST) { 	//print_r($_POST); exit();
			$this->Holiday_Model->update_holiday($_POST, array('id' => $holi_id));
			redirect(base_url('Holiday/edit-holiday/' . $holi_id));
		}
		$data['title'] = "Edit Holiday";
		$data['user_list'] = $this->User_model->companey_users();
		$data['festivals']  = $this->Holiday_Model->getFestival();
		$data['holiday']  = $h = $this->Holiday_Model->holiday_table(array('holi.id' => $holi_id))[0];
		$data['state'] = $this->location_model->estate_list();
		$data['city'] = $this->location_model->all_city_bystate($h['state']);
		// print_r($h);
		//print_r($data['city']); exit();
		$data['content'] = $this->load->view('edit-holiday', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function delete_festival($id)
	{
		if (user_role('530') == true) {}
		$this->Holiday_Model->delete_festival($id);
		redirect(base_url('holiday/add-festival'));
	}
	public function delete_holiday($id)
	{
		if (user_role('531') == true) {}
		$this->Holiday_Model->delete_holiday($id);
		redirect(base_url('holiday/index'));
	}
}
