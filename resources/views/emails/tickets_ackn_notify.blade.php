<!-- <h3>Hello {{ $users['datas']['data-username'] }},</h3>


<p>Thanks for contacting the Helpdesk Support team!</p>


<p>
We acknowledge the ticket you have raised regarding  {{ $users['datas']['data-typeof'] }} dated <?php echo date('m-d-Y'); ?>. Our team is working to resolve this immediately; however in case of any complexity, it may take up to two working days to provide a solution.
</p>


<p>While you wait for our Support team to resolve your ticket, we request you to take a look at the “FAQ and Self-help videos” here:  <a href="#">Click here</a>. These resources have been created just for you so that you can get help anytime. Check it out!</p>

<p>Regards</p>
<p>Helpdesk support team</p> -->


<p>Dear {{ $users['datas']['data-username'] }},</p>

<p>Thank you for contacting the TMS Helpdesk. </p>

<p>We have received your TMS {{ $users['datas']['data-typeof'] }} ticket, dated <?php echo date('d-m-Y'); ?>. </p>
<p>Your ticket reference is {{ $users['datas']['data-ticketid'] }}. </p>

<p>We will work to resolve this issue as soon as possible and will keep you informed of progress. </p>
<p>You will receive an email when the issue is resolved. </p>

<p>In the meantime, please use the ticket reference number above if you contact us regarding this issue. </p>

<p>Regards,</p>
<p>TMS Helpdesk team</p>





