<h3>Dear {{ $users['datas']['data-manager-name'] }},</h3>

<p>
{{ $users['datas']['data-username'] }} has requested {{ $users['datas']['data-leavetype'] }} from {{ $users['datas']['data-from_date'] }} to {{ $users['datas']['data-to_date'] }}. 
 Total leave is {{ $users['datas']['data-no_ofdays'] }} days.
</p>
@if ($users['datas']['data-leavetype'] == "Paid sick leave")
<p>To view the medical certificate Please click here <a target='_blank' href="{{ asset('leave_images')}}/{{ $users['datas']['data-leave-image'] }}">Download</a></p>
@endif
<p>  Please approve or reject this request in the TMS as soon as possible. <a href="{{ asset('leave_approve_via_email') }}/{{ $users['datas']['data-leaveid']  }}" target='_blank'>Accept</a>&nbsp;&nbsp;<a href="{{ asset('leave_reject_via_email') }}/{{ $users['datas']['data-leaveid']  }}" target='_blank'>Reject</a></p>


<p>Regards,</p>
<p>TMS </p>






<!-- <p>Employee Name: {{ $users['datas']['data-username'] }}</p>
<p>Employee ID: {{ $users['datas']['data-empid'] }}</p>
<p>Employee Department:{{ $users['datas']['data-department'] }}</p>
<p>Type of leave : {{ $users['datas']['data-leavetype'] }}</p>
<p>Reason for leave :  {{ $users['datas']['data-leavereason'] }}</p>
<p>From :{{ $users['datas']['data-from_date'] }}  &nbsp;&nbsp;&nbsp;&nbsp; To : {{ $users['datas']['data-to_date'] }}</p>
<p>No Of Days : {{ $users['datas']['data-no_ofdays'] }}</p>
<p style='color:purple;'>Leave Status : {{ $users['datas']['data-leavestatus'] }}</p>
<p style='color:red;display:none;'>Note : This Employee is on leave today </p>

<p>Are you Accept or Reject this request?  <a href="{{ asset('leave_approve_via_email') }}/{{ $users['datas']['data-leaveid']  }}" target='_blank'>Accept</a>&nbsp;&nbsp;<a href="{{ asset('leave_reject_via_email') }}/{{ $users['datas']['data-leaveid']  }}" target='_blank'>Reject</a></p>

<p>Thanks</p>
<p>{{ $users['datas']['data-username'] }}</p> -->







