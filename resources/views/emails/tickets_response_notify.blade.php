<!-- <h3>Hello {{ $users['datas']['data-username'] }},</h3>
<p>Thanks for contacting the Helpdesk Support team!</p>
<p>With reference to your request regarding <?php  echo $users['datas']['data-typesofresponse']; ?> </p>

<p>Developer Comment : {{ $users['datas']['data-responsecomment'] }}</p>

<p>Please revert if you need any further clarification</p>
<p>If you are satisfied with the solution provided by us, please do provide your valuable feedback in the satisfaction survey email which will be sent to you in 24 hours</p>

<p>Regards</p>
<p>Helpdesk support team</p> -->




<p>Dear {{ $users['datas']['data-username'] }}, </p>

<p>Your TMS ticket {{ $users['datas']['data-ticketid'] }}, dated {{ $users['datas']['data-ticketdate'] }}, is now resolved. </p>

<p>Please check to ensure all is in order. </p>

<p>Should you need any further action on this issue, please contact us by reply to this email.</p>  

<p>Regards,</p>
<p>TMS Helpdesk team</p>








