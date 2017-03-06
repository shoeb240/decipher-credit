<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_ajax extends CI_Controller {
	
	
    public function __construct()
    {
            parent::__construct();		
            $this->load->model('ion_auth_model');
            if (!$this->ion_auth->logged_in()){
                    redirect('auth/login');
            }
            $this->load->library(array('ion_auth','form_validation'));
            $this->load->model('customeruser_model');
    }
	
	
    public function SaveUser()
    {
        $result = false;
        
        if (!empty($_POST) && $this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            $data = array();
            $user_id = $_POST['user_id'];
            $user = $this->ion_auth->user($user_id)->row();
            
            // update the password if it was posted
            if ($this->input->post('password'))
            {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            //if (1 || $this->form_validation->run() === TRUE)
            {
                if ($this->input->post('first_name'))
                {
                    $data['first_name'] = $this->input->post('first_name');
                }
                if ($this->input->post('last_name'))
                {
                    $data['last_name'] = $this->input->post('last_name');
                }
                if ($this->input->post('company'))
                {
                    $data['company'] = $this->input->post('company');
                }
                if ($this->input->post('phone'))
                {
                    $data['phone'] = $this->input->post('phone');
                }
                if ($this->input->post('password'))
                {
                    $data['password'] = $this->input->post('password');
                }

                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin())
                {
                    //Update the groups user belongs to
                    $groupData = $this->input->post('groups');

                    if (isset($groupData) && !empty($groupData)) {

                        $this->ion_auth->remove_from_group('', $user_id);

                        foreach ($groupData as $grp) {
                                $this->ion_auth->add_to_group($grp, $user_id);
                        }
                    }
                }

                // check to see if we are updating the user
                if(!empty($data) && $this->ion_auth->update($user->id, $data))
                {
                   $result = true;
                }
            }
            
        }
        
        echo json_encode(array('response' => $result));
    }
    
    public function ActivateInactivateUser()
    {
        $result = false;
        
        if (!empty($_POST) && $this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            $data = array();
            $user_id = $_POST['user_id'];
            $user = $this->ion_auth->user($user_id)->row();

            $data['active'] = $this->input->post('active');

            // check to see if we are updating the user
            if($this->ion_auth->update($user->id, $data))
            {
               $result = true;
            }
            
        }
        
        echo json_encode(array('response' => $result));
    }
    
    public function SaveGroupUsers()
    {
        $result = false;

        if (!empty($_POST) && $this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            $user_id = $_POST['user_id'];
            
            $groupIdArr = explode(',', $_POST['group_id_list']);
            foreach($groupIdArr as $groupId) {   
                if ($groupId) {
                    $groupData[] = $groupId;
                }
            }

            if (!empty($groupData)) {
                $this->ion_auth->remove_from_group('', $user_id);
                foreach ($groupData as $grp) {
                    $this->ion_auth->add_to_group($grp, $user_id);
                }
                $result = true;
            }
        } 

        echo json_encode(array('response' => $result));
    }
		
}
	