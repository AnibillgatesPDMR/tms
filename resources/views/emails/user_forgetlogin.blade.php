<h3>Dear {{ $users['datas']['data-manager-name'] }}</h3>
<p>I forgot to log in at the system during the below-mentioned time. </p>
<p>Employee  Name : {{ $users['datas']['data-username'] }}</p>
<p>Employee Id :  {{ $users['datas']['data-empid'] }}</p>
<p>Date  :{{ $users['datas']['data-forgetdate'] }}  </p>
<p>From: {{ $users['datas']['data-from_time'] }}&nbsp;&nbsp;&nbsp;&nbsp; To: {{ $users['datas']['data-to_time'] }}
<p>Reason : {{ $users['datas']['data-forgetreason'] }}</p>

<p>  Please accept/reject this request in the TMS as soon as possible. <a href="{{ asset('forgetlogin_accept_via_email') }}/{{ $users['datas']['data-forget_id']  }}" target='_blank'>Accept</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="{{ asset('forgetlogin_reject_via_email') }}/{{ $users['datas']['data-forget_id']  }}" target='_blank'>Reject</a></p>

<p>Thanks</p>
<p>{{ $users['datas']['data-username'] }}</p>







