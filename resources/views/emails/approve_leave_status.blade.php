
<p>Dear {{ $users['datas']['data-username'] }}, </p>

<p>Your request for {{ $users['datas']['data-leave_type'] }} from {{ $users['datas']['data-from_date'] }} to {{ $users['datas']['data-to_date'] }} is <?php echo strtolower($users['datas']['data-leavestatus']); ?>. Your TMS leave record has been updated accordingly.</p> 

<p>Regards,</p>
<p>{{ $users['datas']['data-manager-name'] }}</p>










<!-- <h3>Dear {{ $users['datas']['data-username'] }}</h3>
<p>Your leave has been {{ $users['datas']['data-leavestatus'] }}</p>





<p>Thanks,</p>
<p>Compuscript</p> -->