<h3>Dear Manager</h3>
<p>Employee Name: </p>
<p>Employee ID: </p>
<p>Employee Department:</p>
<p>Type of leave : {{ $users['datas']['data-leavetype'] }}</p>
<p>Reason for leave :  {{ $users['datas']['data-leavereason'] }}</p>
<p>From :{{ $users['datas']['data-from_date'] }}  &nbsp;&nbsp;&nbsp;&nbsp; To : {{ $users['datas']['data-to_date'] }}</p>
<p>No Of Days : {{ $users['datas']['data-no_ofdays'] }}</p>
<p style='color:red;'>Note : This Employee is on leave today </p>

<p>Thanks</p>
<p>{{ $users['datas']['data-username'] }}</p>

<p>Accept or Reject?  <a href="javascrip:void(0);">Accept</a>&nbsp;&nbsp;<a href="javascript:void(0);">Reject</a></p>





