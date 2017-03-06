<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Laurentiu Tonea
 * Date: 8/8/12
 * Time: 4:53 PM
 * To change this template use File | Settings | File Templates.
 */

include_once('LNNationalComprehensiveCriminalReportSvc.php');

$MyRq = new LNNationalComprehensiveCriminalReportRq_Type();
$MyRq->MsgRqHdr = new MsgRqHdr_Type();
//$MyRq->MsgRqHdr->MemberId = 'SDK0114535';
$MyRq->MsgRqHdr->MemberId = 'SDK0153151';
//$MyRq->MsgRqHdr->MemberPwd = '1014030311';
$MyRq->MsgRqHdr->MemberPwd = '1615242418';



/*
$MyRq->PersonInfo->ContactInfo = new ContactInfo_Type();
$MyRq->PersonInfo->ContactInfo->PostAddr = new PostAddr_Type();
$MyRq->PersonInfo->ContactInfo->PostAddr->StateProv = "GA";
*/

$thisReport = new GetReport();
$thisReport->inquiry = $MyRq;

$client = new LNNationalComprehensiveCriminalReportSvc();

$response = $client->GetReport($thisReport);
print_r($response);

?>
