<h3>Dear {{ $users['datas']['data-username'] }}</h3>

<p>Employee  Name : {{ $users['datas']['data-username'] }}</p>
<p>Employee Id :  {{ $users['datas']['data-empid'] }}</p>
<p>Date  : <?php echo date('Y M d'); ?> </p>
<p>Employee workplace :  {{ ucfirst($users['datas']['data-empworktype']) }}</p>
<p>Description : {{ $users['datas']['data-emailtext'] }}</p>

<p>Thanks</p>
<p>Compuscript Admin Team</p>







