<h3>Dear Manager</h3>
<p>I forgot to log in at the system during the below-mentioned time. </p>
<p>Employee  Name : {{ $users['datas']['data-username'] }}</p>
<p>Employee Id :  {{ $users['datas']['data-empid'] }}</p>
<p>Date  :{{ $users['datas']['data-forgetdate'] }}  </p>
<p>From: {{ $users['datas']['data-from_time'] }}&nbsp;&nbsp;&nbsp;&nbsp; To: {{ $users['datas']['data-to_time'] }}
<p>Reason : {{ $users['datas']['data-forgetreason'] }}</p>
<p>Type : <span style='color:red;'>{{ $users['datas']['data-forgettype'] }}</span></p>
<p>Thanks</p>
<p>{{ $users['datas']['data-username'] }}</p>







