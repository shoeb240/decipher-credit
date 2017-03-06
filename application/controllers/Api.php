<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Base {
    public $behalf_of;

     public function __construct()
        {
                error_reporting(0);
                parent::__construct();
                if($this->myacl !== 1){
                    redirect('auth/login');
                }
                $this->load->helper('url_helper');

                $this->load->view('templates/head');
                }

        public function mform(){
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('lname', 'lname', 'required');
                $this->form_validation->set_rules('fname', 'fname', 'required');
                if ($this->form_validation->run() === FALSE){
                    $this->load->view('apianalysis/searchform');
                }else{
                   $this->load->model('Microbilt_API_peoplesearchsvc_model');
                   $ptype=new PersonInfo_Type();
                   $pname = new PersonName_Type();
                   $pname->FirstName = $this->input->post('fname');
                   $pname->LastName = $this->input->post('lname');
                   $pcontact=new ContactInfo_Type();
                   $pcontact->EmailAddr = $this->input->post('email');
                   $paddr = new PostAddr_Type();
                   $paddr->PostalCode = $this->input->post('zip');
                   $paddr->StateProv = $this->input->post('state');
                   $paddr->City = $this->input->post('city');
                   $paddr->StreetName = $this->input->post('street');
                   $paddr->StreetNum = $this->input->post('streetnum');

                   $pIDinfo = new TINInfo_Type();
                   $pIDinfo->TINType = "SSN";
                   $pIDinfo->TaxId = $this->input->post('ssn');
                   $data['apiresults'] = $this->Microbilt_API_peoplesearchsvc_model->baseSearch($ptype, $pname, $pcontact, $paddr, $pIDinfo);


//                   $data['apiresults'] = $this->Microbilt_API_model->peopleSearch();
                   $this->load->view('apianalysis/microbilt' , $data);
                }
        }

        public function busconfirm(){
                $pwho = null;
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->load->model('Microbilt_API_businesssearchsvc_model');
                $this->form_validation->set_rules('cname', 'cname', 'required');

                if ($this->form_validation->run() === FALSE){
                    $this->load->view('apianalysis/businesssearchform');

                } else {
                    $orgInfo = new OrgInfo_Type();
                    $orgInfo->Name = $this->input->post('cname');
                    $postAddr = new PostAddr_Type();
                    $postAddr->StateProv = $this->input->post('state');
                    $postAddr->PostalCode = $this->input->post('zip');

                      $this->load->model('ion_auth_model');
                      if ($this->ion_auth->logged_in()){
                          $user = $this->ion_auth->user()->row();
                        $this->behalf_of->user = $user->id;
                        $this->behalf_of->company = $user->company;
                        $this->behalf_of->customer = "1";
                        $pwho = $this->behalf_of;
                      }
                     log_message("DEBUG", "SAVING PWHO from Controller");
                     log_message("DEBUG", json_encode($this->behalf_of));
                     $pwho=null;
                     $data['apiresults'] = $this->Microbilt_API_businesssearchsvc_model->baseSearch($orgInfo, $postAddr, $pwho);

                    $this->load->view('apianalysis/microbilt' , $data);

                }


        }



        public function criminal(){
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->load->model('Microbilt_API_criminalsearchsvc_model');
                $this->form_validation->set_rules('lname', 'lname', 'required');
                $this->form_validation->set_rules('fname', 'fname', 'required');

                if ($this->form_validation->run() === FALSE){
                    $this->load->view('apianalysis/criminalsearch');

                } else {
                    $pname = new PersonName_Type();
                   $pname->FirstName = $this->input->post('fname');
                   $pname->LastName = $this->input->post('lname');
                   $pIDinfo = new TINInfo_Type();
                   $pIDinfo->TINType = "SSN";
                   $pIDinfo->TaxId = $this->input->post('ssn');
                     $data['apiresults'] = $this->Microbilt_API_criminalsearchsvc_model->baseSearch($pname, $pIDinfo);
                    $this->load->view('apianalysis/microbilt' , $data);

                }


        }


	public function index()
	{
 //               error_reporting(0);
                $this->load->model('Microbilt_API_model');
                $data['apiresults'] = $this->Microbilt_API_model->peopleSearch();
                $this->load->view('apianalysis/microbilt' , $data);

	}


	public function csc()
    {
        $this->load->helper('form');

        $result = false;

        $company = $this->input->post('company', '');
        $state = $this->input->post('state', '');

        if ($company) {
            $this->load->model('credential_model');

            //$credentials = json_decode($this->credential_model->getCredentialByType('csc'), true);
            $credentials = ['identity' => '1', 'password' => 'D0730154-2F54-4873-8D9E-1E957DAC80C9'];

            if ($credentials) {
                $this->load->model('CSC_API_model');

                $result = $this->CSC_API_model->search(
                    $credentials, [
                        'company' => $company,
                        'state' => $state
                    ]
                );
            }
        }

        $this->load->view(
            'apianalysis/csc',
            [
                'result' => $result,
                'company' => $company,
                'state' => $state
            ]
        );
    }

}
