<?php defined('BASEPATH') or exit('No direct script access allowed');
class Doctor_model extends CI_Model
{
	private $table = "user";
	public function create($data = [])
	{
		return $this->db->insert($this->table, $data);
	}
	public function read()
	{
		return $this->db->select("user.*")
			->from("user")
			//->where('user.user_role',2)
			->order_by('user.user_id', 'desc')
			->get()
			->result();
	}
	//fetch company user list
	public function geCompanyUsers($companyId)
	{
		return $this->db->select('companey_id,pk_i_admin_id,s_display_name,last_name,dt_create_date,picture,s_user_email,last_log,start_billing_date,valid_upto_date,b_status')
			->where(array('companey_id' => $companyId))
			->order_by('tbl_admin.pk_i_admin_id', 'desc')
			->get('tbl_admin')->result();
	}
	
	public function checkCompany_userbyId($companyId,$user_id)
	{
		return $this->db->where(array('user_id' => $companyId))->count_all_results('user');
	}
	//check company exist or not 
	public function geCompanybyId($companyId)
	{
		return $this->db->where(array('user_id' => $companyId))->count_all_results('user');
	}
	//update data
	public function updateUser($companyId,$user_id,$data)
	{
		$update= $this->db->where(array('companey_id' => $companyId,'pk_i_admin_id'=>$user_id))->update('tbl_admin',$data);
		return $update;
	}
	public function read_by_id($user_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->group_start()
			->where('user_role', 1)
			->or_where('user_role', 2)
			->group_end()
			->where('user_id', $user_id)
			->get()
			->row();
	}

	public function amc_list($id, $enquiry_id)
	{
		// echo $enquiry_id;
		return $this->db->select("tbl_amc.*,tbl_product_country.*")
			->from("tbl_amc")
			->join('tbl_product_country', 'tbl_amc.product_name=tbl_product_country.id', 'left')
			->where('tbl_amc.comp_id', $id)
			->where('tbl_amc.enq_id', $enquiry_id)
			->order_by('tbl_amc.id', 'desc')
			->get()
			->result_array();
	}

	public function add_amc($arr)
	{

		return $this->db->insert('tbl_amc', $arr);
	}

	public function product_list($id)
	{

		$this->db->select('*');
		$this->db->from('tbl_product_country');
		$this->db->where('comp_id', $id);

		return $this->db->get()->result_array();
	}



	public function update($data = [])
	{
		return $this->db->where('user_id', $data['user_id'])
			->update($this->table, $data);
	}



	public function delete($user_id = null)

	{

		$this->db->where('user_id', $user_id)

			->group_start()

			->where('user_role', 2)

			->group_end()

			->delete($this->table);



		if ($this->db->affected_rows()) {

			return true;
		} else {

			return false;
		}
	}





	public function doctor_list()

	{

		$result = $this->db->select("*")

			->from($this->table)

			->where('user_role', 2)

			->where('status', 1)

			->get()

			->result();



		$list[''] = display('select_doctor');

		if (!empty($result)) {

			foreach ($result as $value) {

				$list[$value->user_id] = $value->firstname . ' ' . $value->lastname;
			}

			return $list;
		} else {

			return false;
		}
	}
}
