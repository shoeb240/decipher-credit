<?php

class test_api extends CI_Controller {

	function get_balancesheet()
	{
		$this->load->model('Quickbooks_api_model');
		$balancesheet = $this->Quickbooks_api_model->get_balancesheet('test_api/get_balancesheet');

		// print the entire balancesheet returned from intuit
		pr($balancesheet);
		exit;
	}

	function disconnect_quickbooks()
	{
		session_unset();
		echo 'Disconnected successfully';
		exit;
	}

}