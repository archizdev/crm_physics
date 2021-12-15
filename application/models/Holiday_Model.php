<?php
class Holiday_Model extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function add_festival($data)
	{
		$this->db->insert('festivals',$data);
	}

	public function getFestival($where=0)
	{
		if($where)
			$this->db->where($where);
		return $this->db->get('festivals');
	}
  public function getFestivalNotID($data,$fest_id)
  {
	$get=$this->db->where_not_in('id',$fest_id)->where($data)->get('festivals');
	return $get;
  }
	public function add_holiday($data)
	{
		$this->db->insert('holidays',$data);
		$this->session->set_flashdata('SUCCESSMSG','Holiday Added.');
	}

	public function holiday_table($where=0)
	{
		 $this->db->select('holi.*,fes.festival_name,st.state as state_name,ct.city as city_name')
					->from('holidays as holi')
					->join('festivals as fes','fes.id=holi.festival','left')
					->join('state as st','st.id=holi.state','left')
					->join('city as ct','ct.id=holi.city','left');
		if($where)
			$this->db->where($where);

		return $this->db->get()->result_array();
	}

	public function update_festival($data,$where)
	{
		$this->db->where($where);
		$this->db->update('festivals',$data);
		$this->session->set_flashdata('SUCCESSMSG','Updated Successfully.');
	}

	public function update_holiday($data,$where)
	{
		$this->db->where($where);
		$this->db->update('holidays',$data);
		$this->session->set_flashdata('SUCCESSMSG','Updated Successfully.');
	}

	public function delete_festival($id)
	{
		$this->load->database();
		$this->db->where(array('id'=>$id));
		$this->db->delete('festivals');

		$this->db->where(array('festival'=>$id));
		$this->db->delete('holidays');

		$this->session->set_flashdata('SUCCESSMSG','Festival Deleted');
	}

	public function delete_holiday($id)
	{
		$this->load->database();
		$this->db->where(array('id'=>$id));
		$this->db->delete('holidays');

		$this->session->set_flashdata('SUCCESSMSG','Holiday Deleted');
	}

}