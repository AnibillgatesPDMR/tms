<h3>Dear Manager</h3>
<p>Employee Name: {{ $users['datas']['data-username'] }}</p>
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
<p>{{ $users['datas']['data-username'] }}</p>







