
<?php 

use App\Role;
?>





        <table style="border: 1px solid #000;" cellspacing="10">
            <thead class="tablehead">
            
            <tr>
                <th>S.No</th>
                
                <th>Emp Id</th>
                <th>Employee Name</th>
                <th>Date</th>
                <th>In Time (HHH:MM)</th>
                <th>Out Time (HHH:MM) </th>                
                <th>Actual Time</th>
                <th>Total Working Time <br />(Actual Time - Lunch Break((30 min))</th>
              
                
            </tr>
          
          </thead>
           
          <tbody>

                <?php 

                $sum_hours =0;
                $diff_in_hrs1 =0;
                $row_color ='';
               if(!empty($users['reports'])) { 
                
                $i=1; 

                foreach($users['reports'] as $list) { 
                $row_color = (empty($list->loged_out_at))?"#edbb99":"";

                
                $row_color = Role::get_firstlogintimebyid($list->loged_in_at,$list->user_id);
                foreach($row_color as $key =>$value) {
                        
                     $last_time = $value->loged_out_at;
                    

                }
                $row_change = (empty($last_time))?"#edbb99":"";

                    
                ?>
                
                <tr style='background-color:<?php echo $row_change; ?>'>
                <td><?php echo $i; ?></td>
                <td><?php echo $list->user_id; ?></td>
                <td>
                <?php
                 $user_Details = Role::get_Usersid($list->user_id);
                 echo $user_Details->name;

                  ?></td>
                <td><?php echo date('Y-m-d',strtotime($list->loged_in_at)); ?></td>
                <td><?php 
                
                echo date('H:m A',strtotime($list->loged_in_at));
                ?></td>
                <td><?php 
                $last_time='';
                $last_Logout = Role::get_firstlogintimebyid($list->loged_in_at,$list->user_id);
                foreach($last_Logout as $key =>$value) {
                        
                     $last_time = $value->loged_out_at;
                    

                }
               echo (!empty($last_time))?date('H:m A',strtotime($last_time)):"";
              // echo '<pre>'; print_r($last_Logout);
                
                 ?></td>
                <td>
                <?php 
                if(!empty($last_time)) {
                    $date1 = $list->loged_in_at;
                    $date2 = $last_time;
                    $diff = strtotime($date2) - strtotime($date1);
                    $diff_in_hrs = $diff/3600;
                  //  echo number_format($diff_in_hrs,2);

                   
                   
                    echo number_format($diff_in_hrs,2);
                } else {
                    echo "0 hrs";
                }
                
                
                ?></td>
                <td style='color:green;'>
                <?php 
                if(!empty($last_time)) {
                    $date1 = $list->loged_in_at;
                    $date2 = $last_time;
                    $diff = strtotime($date2) - strtotime($date1);
                    $diff_in_hrs = $diff/3600;
                  //  echo number_format($diff_in_hrs,2);

                   $diff_in_hrs1 = $diff_in_hrs-0.30;
                   
                   if($diff_in_hrs1 > 0) {
                    $sum_hours = $sum_hours + $diff_in_hrs1;
                    echo number_format($diff_in_hrs1,2);
                   }
                   else {
                       echo "0 hrs";
                   }
                   


                } else {
                    echo "0 hrs";
                }
                
                
                ?>
                
                </td>
                  
                </tr>

                <?php $i++; }

                    }  else {
                      echo "<span style='color:red;font-weight:bold;'>No Records Found</span>";
                    }
                    // empty check if End
                
                ?>
               <tr>
               <td colspan="8"><span style='float:right;color:green;font-weight:bold;'>Total Hours : <?php echo number_format($sum_hours,2); ?></span></td>
               </tr>
            
           </tbody>
        </table>