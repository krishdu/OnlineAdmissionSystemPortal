<?php
if(isset($_GET['email'])){
$email = $_GET['email'];
$sql_mobile_no_fetch = "SELECT mobile FROM user WHERE email = '$email' ";	
 $mobilenoQuery = mysqli_query($conn,$sql_mobile_no_fetch);
 if(mysqli_num_rows($mobilenoQuery) > 0){
 $row =mysqli_fetch_array($mobilenoQuery);
 $mob_no = $row['mobile']; 
 $result  = $admin->sendSMSMail($email, "1", $mob_no);
  if($result ==1){
    ?>
    }else{?>
   }
 }else{?>
 } 
}else{?>
}
?>