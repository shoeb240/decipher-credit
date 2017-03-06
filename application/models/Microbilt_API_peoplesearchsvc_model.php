<?php
class Microbilt_API_peoplesearchsvc_model extends CI_Model {
    private $apiserviceid=3;
    private $behalf_of;
    public function __construct(){
         error_reporting(0);  // soap warning
        
        require_once APPPATH.'third_party/Microbilt/MBPeopleSearchSvc.php';
        $this->load->model('ion_auth_model');
        if (!$this->ion_auth->logged_in()){
           $this->behalf_of->user = 0;
           $this->behalf_of->company = 'Not Logged In';
        }else {
           $user = $this->ion_auth->user()->row();
           $this->behalf_of->user = $user->id;
           $this->behalf_of->company = $user->company;
                    
        }

            

    }
        

    public function baseSearch($ptype, $pname, $pcontact, $paddr, $pIDinfo, $forwho=null){
       
        $this->load->model('credential_model');
        $credential = json_decode($this->credential_model->getCredentialByType('microbilt'));

        $MyRq = new MBPeopleSearchRq_Type();
        $MyRq->MsgRqHdr = new MsgRqHdr_Type();
        $MyRq->MsgRqHdr->MemberId = $credential->identity;
        $MyRq->MsgRqHdr->MemberPwd = $credential->password;
        $MyRq->PersonInfo = $ptype;
        $MyRq->PersonInfo->PersonName = $pname;
        $MyRq->PersonInfo->ContactInfo = $pcontact;
        $MyRq->PersonInfo->ContactInfo->PostAddr = $paddr;
        $MyRq->PersonInfo->TINInfo = $pIDinfo;
        $thisReport = new GetReport();
        $thisReport->inquiry = $MyRq;

        $client = new MBPeopleSearchSvc();
        $response = $client->GetReport($thisReport);
        
        $this->load->model('apiusage_model');
        $this->apiusage_model->apiservice_key=$this->apiserviceid;
        if($forwho){
          $this->apiusage_model->idstructure=$forwho;
        } else {
          $this->apiusage_model->idstructure=json_encode($this->behalf_of);
        }
        $this->apiusage_model->query = serialize($MyRq->PersonInfo);
        $this->apiusage_model->insert();
        
        
        
        
        
        
        return $response;
    }

        
        
        
}