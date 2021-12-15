<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

/**
 * 
 */
class LoginHook extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();

	}

	public function verifyLogin()
	{
		if(empty($this->session->company_id))
		{
			
		}
	}
}