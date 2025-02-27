<?php 
use Illuminate\Support\Facades\Crypt;
$encrypted = Crypt::encrypt("Accept"."~~".$users['datas']['data-empid']);
$url_accept = '/holidayempstatus/'.$encrypted;


$encrypted1 = Crypt::encrypt("Reject"."~~".$users['datas']['data-empid']);
$url_reject = '/holidayempstatus/'.$encrypted1;

?>

<h3>Dear Manager,</h3>

<?php 
//echo '<pre>';
//print_r($users['datas']);
?>

<p>Employee Name: {{ $users['datas']['data-username'] }}  </p>
<p>Employee ID :  {{ $users['datas']['data-emp_id'] }}</p>
<p>Employee department:  {{ $users['datas']['data-department'] }}</p>
@if ($users['datas']['data-empworktype']!== '')
<p>Employee workplace :  {{ ucfirst($users['datas']['data-empworktype']) }}</p>
@endif
<p>{{ $users['datas']['data-log-content'] }} date time :<span style='color:red;font-weight:bold;'>{{ $users['datas']['data-logged_in'] }}
</span></p>

@if ($users['datas']['data-earlyexits']!= '')
<p style='font-color:red;font-weight:bold;color:red;'>Early Exit before 8 hrs : <?php echo $users['datas']['data-earlyexits'];   ?> </p>

@endif

@if ($users['datas']['data-holiday']!== '' && $users['datas']['data-log-content']!== 'Logged Out')
<p style='font-color:red;font-weight:bold;color:red;'>Holiday : {{ ucfirst($users['datas']['data-holiday']) }}</p>
<p>Accept or Reject ? <a href="{{ URL::to($url_accept) }}">Accept</a>&nbsp;&nbsp;<a href="{{ URL::to($url_reject) }}">Reject</a></p>
@endif
<p style='font-weight:bold;'>Regards,</p>
<p style='font-weight:bold;'>Compuscript Admin Team</p>


