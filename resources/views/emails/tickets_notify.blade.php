<!-- <h3>Dear Teresa,</h3>

<p>Ticket Number : {{ $users['datas']['data-ticketid'] }}</p>
<p>Remarks : {{ $users['datas']['data-remarks'] }}</p>



<p>Thanks</p>
<p>{{ $users['datas']['data-username'] }}</p> -->



<p>Dear TMS Helpdesk team, </p>

<p>{{ $users['datas']['data-username'] }} raised a {{ $users['datas']['data-typeof'] }} ticket on <?php echo date('d-m-Y'); ?>. </p>
<p>The ticket reference is {{ $users['datas']['data-ticketid'] }}. </p>

<p>Problem description:</p>
<p>{{ $users['datas']['data-remarks'] }}</p>

<p>Number of attachments: 1 files.</p>

<p>Please review and resolve this issue as soon as possible. If the issue is not resolved after two days, please email the user with an update on progress and the expected completion date, if possible. </p>

<p>Please use the ticket reference ID above in communications about this issue. </p>

<p>Regards,</p>
<p>TMS</p>






