<?php
class Microbilt_API_businesssearchsvc_model extends CI_Model {
    private $apiserviceid=2;
    private $behalf_of;

    public function __construct(){
        error_reporting(0);
       require_once APPPATH.'third_party/Microbilt/LNBusinessSearchSvc.php';
       $this->load->model('ion_auth_model');
       $this->load->model('Customeruser_model');
       
       if (!$this->ion_auth->logged_in()){
           $this->behalf_of->user = 0;
           $this->behalf_of->company = 'Not Logged In';
        }else {
           $user = $this->ion_auth->user()->row();
           $this->behalf_of->user = $user->id;
           $this->behalf_of->company = $user->company;
           $this->behalf_of->customer = '1';
           $stuff = $this->Customeruser_model->get_customer_for_user($user->id);
           if($stuff != null){
           $this->behalf_of->customer= $stuff[0]->custID;
           }
                    
        }
    }


    public function baseSearch($orgInfo, $addrInfo, $forwho=null){
    
      


        $this->load->model('credential_model');
        $credential = json_decode($this->credential_model->getCredentialByType('microbilt'));

        $MyRq = new LNBusinessSearchRq_Type();
        $MyRq->MsgRqHdr = new MsgRqHdr_Type();
        $MyRq->MsgRqHdr->MemberId = $credential->identity;
        $MyRq->MsgRqHdr->MemberPwd = $credential->password;
        $MyRq->OrgInfo = $orgInfo;
        $MyRq->OrgInfo->ContactInfo = new ContactInfo_Type();
        $MyRq->OrgInfo->ContactInfo->PostAddr = $addrInfo;

        $thisRequest = new GetReport();
        $thisRequest->inquiry = $MyRq;
        $thisClient = new LNBusinessSearchSvc();

        $response = $thisClient->GetReport($thisRequest);

        $this->load->model('apiusage_model');
        $this->apiusage_model->apiservice_key=$this->apiserviceid;
        if($forwho){
          $this->apiusage_model->idstructure=json_encode($forwho);
        } else {
            $this->apiusage_model->idstructure=json_encode($this->behalf_of);
        }
        $this->apiusage_model->query = serialize($MyRq->OrgInfo);
        $this->apiusage_model->insert();



        return $response;





    }

        
        
        
}