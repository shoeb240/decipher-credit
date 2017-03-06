<?php
include_once('MBPeopleSearchSvc.php');

$MyRq = new MBPeopleSearchRq_Type();
$MyRq->MsgRqHdr = new MsgRqHdr_Type();
$MyRq->MsgRqHdr->MemberId = 'SDKXXXXXXX';
$MyRq->MsgRqHdr->MemberPwd = 'XXXXXXXXXX';

$MyRq->PersonInfo = new PersonInfo_Type();

$MyRq->PersonInfo->TINInfo = new TINInfo_Type();
$MyRq->PersonInfo->TINInfo->TINType = "SSN";
$MyRq->PersonInfo->TINInfo->TaxId = "XXXXXXXXX";

//$MyRq->PersonInfo->PersonName = new PersonName_Type();
//$MyRq->PersonInfo->PersonName->LastName = "Gilmore";
//$MyRq->PersonInfo->PersonName->FirstName = "David";

//$MyRq->PersonInfo->ContactInfo = new ContactInfo_Type();
//$MyRq->PersonInfo->ContactInfo->PostAddr = new PostAddr_Type();
//$MyRq->PersonInfo->ContactInfo->PostAddr->StreetNum = "3132";
//$MyRq->PersonInfo->ContactInfo->PostAddr->StreetName = "old Street";
//$MyRq->PersonInfo->ContactInfo->PostAddr->City = "Old City";
//$MyRq->PersonInfo->ContactInfo->PostAddr->StateProv = "PA";
//$MyRq->PersonInfo->ContactInfo->PostAddr->PostalCode = "12345";

$thisReport = new GetReport();
$thisReport->inquiry = $MyRq;

$client = new MBPeopleSearchSvc();

$response = $client->GetReport($thisReport);
print_r($response);

?>
