<?php
/**
 * Created by PhpStorm.
 * User: Laurentiu Tonea
 * Date: 2016.08.26
 * Time: 4:13 PM
 */
include_once('LNBusinessSearchSvc.php');

$MyRq = new LNBusinessSearchRq_Type();
$MyRq->MsgRqHdr = new MsgRqHdr_Type();
$MyRq->MsgRqHdr->MemberId = 'SDK0153151';
$MyRq->MsgRqHdr->MemberPwd = 'XXXXXXXXXX';
$MyRq->OrgInfo = new OrgInfo_Type();
$MyRq->OrgInfo->Name = "MICROSOFT";
$MyRq->OrgInfo->ContactInfo = new ContactInfo_Type();
$MyRq->OrgInfo->ContactInfo->PostAddr = new PostAddr_Type();
$MyRq->OrgInfo->ContactInfo->PostAddr->StateProv = "WA";


$thisRequest = new GetReport();
$thisRequest->inquiry = $MyRq;
$thisClient = new LNBusinessSearchSvc();
$response = $thisClient->GetReport($thisRequest);

print_r($response);
?>
