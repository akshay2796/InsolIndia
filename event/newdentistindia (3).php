<?php 
session_start();
///Index Page Mailer
if (isset($_SERVER['HTTP_CLIENT_IP']))
{
    $visiterIp = $_SERVER['HTTP_CLIENT_IP'];
} else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $visiterIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
    $visiterIp = $_SERVER['HTTP_X_FORWARDED'];
} else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
    $visiterIp = $_SERVER['HTTP_FORWARDED_FOR'];
} else if(isset($_SERVER['HTTP_FORWARDED'])) {
    $visiterIp = $_SERVER['HTTP_FORWARDED'];
} else if(isset($_SERVER['REMOTE_ADDR'])) {
    $visiterIp = $_SERVER['REMOTE_ADDR'];
}

 $visiterIp;


$blackIps = array('178.137.83.166','146.185.223.194','122.177.39.250','146.185.223.194','207.154.231.208','193.201.224.201','185.36.102.114','85.248.227.163','103.47.168.44','197.231.221.211','197.231.221.211','163.172.223.200','51.15.136.98','212.16.104.33','176.126.252.11','23.129.64.103', '85.248.227.165', '104.236.141.156', '195.22.126.25', '193.15.16.4', '185.38.14.215', '216.17.101.79', '199.249.223.40', '87.118.116.90', '171.25.193.25', '207.154.231.208', '193.201.224.201', '185.36.102.114', '85.248.227.163', '197.231.221.211', '197.231.221.211', '163.172.223.200', '51.15.136.98', '212.16.104.33', '176.126.252.11', '23.129.64.103','192.36.27.4','64.31.37.154','216.239.90.19','192.42.116.13','87.69.134.199','144.217.161.119','82.148.223.103','87.69.134.199','144.217.161.119','149.56.223.241','163.172.154.52','45.79.144.222','13.82.234.232','88.99.33.103','109.86.71.21','51.15.81.222','37.214.223.44','18.248.2.85','89.31.57.5','163.172.185.20','185.38.14.171','193.90.12.119','173.212.233.139','87.118.122.50','162.247.72.201','51.15.82.2','192.42.116.13','93.170.187.240','185.72.244.24','199.87.154.255','89.31.57.5','51.15.34.228','216.218.222.12','193.90.12.119','46.161.9.6','171.25.193.20','204.85.191.31','51.15.86.162','46.161.9.60','171.25.193.20','122.161.154.221','87.118.122.50','162.247.72.201','51.15.82.2','171.25.193.78','173.249.21.80','54.36.222.37','204.11.50.131','46.161.9.60','185.38.14.171','95.189.213.52','192.160.102.165','216.239.90.19','198.23.143.20','51.15.53.83','171.25.193.20','185.220.101.44','192.160.102.164','95.128.43.164','23.250.107.85','46.161.9.59','5.254.97.107','185.162.249.232','46.165.230.5','192.227.252.117','5.2.67.45','27.6.206.19','87.118.115.176','89.234.157.254','62.210.105.116','51.255.202.66','88.135.1.206','5.9.158.75','51.15.78.21','178.159.37.17','95.128.43.164','91.219.239.114','193.90.12.118','95.211.118.194','163.172.154.52','51.15.81.222','93.115.95.205','216.218.222.12','91.227.180.228','93.115.95.205','176.123.26.6','163.172.147.32','23.129.64.104','54.39.56.54','178.121.213.211','88.99.33.103','89.33.16.215','192.42.116.16','88.99.33.103','94.130.97.8','176.10.107.180','163.172.67.180','185.220.101.44','185.220.101.44','51.15.63.43','51.15.53.83','185.72.244.24','212.47.227.114','193.90.12.118','94.142.242.84','163.172.67.180','51.15.63.43','185.29.8.136','37.220.35.115','23.92.28.23','46.101.127.145','93.158.216.52','94.130.183.184','93.115.95.205','51.15.78.21','88.135.1.206','106.222.20.219','178.32.147.150','88.99.33.103','37.220.35.202','94.130.183.184','62.210.37.82','93.85.76.114','87.118.116.12','176.226.151.70','193.90.12.117','163.172.132.199','171.25.193.20','86.107.42.247','37.187.180.18','37.115.191.70','37.115.191.70','178.209.42.84','207.244.70.35','27.124.124.126','213.183.59.192','173.254.216.66','31.171.155.131','93.115.95.205','192.36.27.4','51.15.86.162','18.248.2.85','212.21.66.6','5.9.158.75','192.36.27.4','171.25.193.20','176.10.104.243','162.213.3.221','176.10.104.243','172.104.252.154','212.21.66.6','176.10.107.180','46.119.125.241','176.10.104.243','88.99.33.103','166.70.207.2','24.45.246.53','92.63.103.241','92.63.103.241','84.53.65.151','198.96.155.3','163.172.132.199','204.85.191.31','51.15.64.212','64.113.32.29','79.124.59.194','144.217.245.23','94.230.208.147','192.36.27.4','23.92.28.23','178.20.55.16','93.115.95.205','37.233.102.65','162.247.72.200','79.137.68.85','192.42.116.16','85.248.227.164','212.47.227.114','87.118.92.43','162.247.72.7','79.124.59.194','192.36.27.4','87.118.116.12','71.19.144.106','51.15.63.43','178.175.131.194','95.211.210.161','178.32.147.150','107.181.174.66','192.36.27.4','89.31.57.5','185.87.185.45','149.202.238.204','46.165.230.5','80.82.70.116','94.130.183.184','23.129.64.102','195.201.16.199','196.54.55.14','149.56.223.241','103.73.92.98','95.130.12.251','185.100.85.147','193.90.12.116','195.123.212.75','212.47.229.60','84.53.65.151','94.230.208.147','185.220.100.252','185.220.101.44','80.67.172.162','80.67.172.162','37.187.180.18','79.137.68.85','193.171.202.150','122.177.110.109','51.15.82.2','94.230.208.147','51.15.82.2','185.220.100.252','185.220.101.44','80.67.172.162','80.67.172.162','37.187.180.18','79.137.68.85','193.171.202.150','122.177.110.109','51.15.82.2','144.217.245.23','94.230.208.147','23.92.28.23','46.20.35.114','51.15.86.162','141.255.162.34','173.254.216.66','93.158.216.52','37.44.95.180','77.247.181.165','89.31.57.5','185.220.100.253','212.21.66.6','87.118.122.50','46.101.127.145','54.36.222.37','85.248.227.164','54.36.222.37','195.201.16.199','199.249.223.44','37.233.102.65','94.142.242.84','193.90.12.117','192.42.116.16','192.42.116.13','107.172.5.175','23.129.64.101','51.15.86.162','62.210.252.126','51.15.53.83','193.90.12.117','204.17.56.42','162.247.72.199','89.31.57.5','31.185.104.21','195.123.212.34','163.172.132.199','185.220.100.252','37.233.102.65','94.142.242.84','88.99.33.103','79.124.59.194','193.90.12.115','149.202.238.204','163.172.171.163','37.233.103.114','185.217.95.199','89.31.57.5','171.25.193.235','51.15.53.83','94.230.208.147','5.9.158.75','88.99.33.103','84.53.65.151','89.31.57.5','188.191.237.20','204.17.56.42','51.255.202.66','185.220.100.254','37.220.35.202','192.42.116.16','92.63.103.241','66.70.217.179','88.99.33.103','195.228.45.176','94.130.183.184','192.36.27.4','37.220.35.202','51.15.63.43','162.213.3.221','108.59.2.227','171.25.193.235','51.15.34.228','185.220.100.253','94.230.208.147','185.107.81.83','23.129.64.102','171.25.193.77','141.255.162.36','146.185.177.103','91.109.190.9','141.101.20.0','185.217.93.22','185.152.65.187','89.187.143.31','77.247.181.163','51.15.57.167','79.110.17.2','51.15.75.121','104.200.231.141','107.175.209.183','185.100.85.61','51.15.65.25','62.210.53.229','185.107.47.215','94.230.208.148','195.22.126.21','195.176.3.23','109.126.197.6','185.117.215.9','79.126.63.228'); //add the ip for blocking
if(in_array($visiterIp, $blackIps)) {
  die();
  echo '<script>window.location="https://google.co.in";</script>';
}

if(isset($_POST['foosubmit']) && empty($_POST['website'])){
	if($_POST['enq_captcha']==$_SESSION['enq_captcha']){
        $Name 		= $_POST['name'];
        $Email 		= $_POST['email'];
        $phone 	= $_POST['phone'];
        $Message 	= $_POST['form_message'];
      //  $Message 	= $_POST['msg'];
      $message.="
            
            <html>
                <head>
                <title>HTML email</title>
                </head>
                <body>
                <p>This email contains HTML Tags!</p>
                <table border="1">
                <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Name</th>
                <th>Email</th>
                </tr>
                <tr>
                <td>$Name </td>
                <td>$Email</td>
                </tr>
                </table>
                </body>
                </html>
                ";

      
      
      
       /* $message.="Name: $Name \r\n<br>";
        $message.="E-mail: $Email \r\n<br>";
        $message.="Message: $phone\r\n<br>";
        $message.="Message: $Message\r\n<br>";
        $message.="Ip: $visiterIp\r\n<br>";*/
        $mailto = "dev@sabsoftzone.com";
	    //$mailto="dentistindelhi@gmail.com,drshivani@dentistindelhi.co.in,dentistindelhi@sabsoftzone.com,santoshbeats@gmail.com"; 
           
        $pcount=0;
        $gcount=0;
        $subject = "testEnquiry Form <Newdelhidentistindia.com>";

    //    $from="info@newdelhidentistindia.com";
           $from="dev@sabsoftzone.com";
        while (list($key,$val)=each($_POST))
            {
            $pstr = $pstr."$key : $val \n ";
            ++$pcount;
    
            }
        while (list($key,$val)=each($_GET))
            {
            $gstr = $gstr."$key : $val \n ";
            ++$gcount;
    
            }
        if ($pcount > $gcount)
            {
			$message_body=$message;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .='From: '.$from."\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'Reply-to: '.$Email . "\r\n";
			$headers .= "CC: \r\n";
			$headers .= 'mailed-by: www..com' . "\r\n";
			mail($mailto,$subject,$message_body,$headers,$body);
			$res = "Mail has been sent";
            }
            else
            {
    			$message_body=$message;
    			$headers  = 'MIME-Version: 1.0' . "\r\n";
    			$headers .='From: '.$from."\r\n";
    			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    			$headers .= 'Reply-to: '.$Email . "\r\n";
    			$headers .= "CC: \r\n";
    			$headers .= 'mailed-by: ' . "\r\n";
    			mail($mailto,$subject,$message_body,$headers);
    			$res = "Mail has been sent";
            }  
	}   else{
            	$arr = explode('?',$_SERVER['HTTP_REFERER']);
            	if($_POST['error1']){$err = "";}else{$err = "?error1=1";}
                    ?>
                    <script>
                    setTimeout(function() {
                     window.location.href = "<?php echo $arr[0].$err;?>";
                    },0);
                    </script>	
            	<?php die;
        		
        	}
}   

       if(isset($_POST['submit']) && empty($_POST['website'])){
    	if($_POST['enq_captcha']==$_SESSION['enq_captcha']){
        $Name 		= $_POST['fname'];
        $Email 		= $_POST['femail'];
        $phone 	= $_POST['fphone'];
        $Message 	= $_POST['fmessage'];
      //  $Message 	= $_POST['msg'];
        $message.="Name: $Name \r\n<br>";
        $message.="E-mail: $Email \r\n<br>";
        $message.="Message: $phone\r\n<br>";
        $message.="Message: $Message\r\n<br>";
        $message.="Ip: $visiterIp\r\n<br>";
        $mailto = "dev@sabsoftzone.com";
	    //$mailto="dentistindelhi@gmail.com,drshivani@dentistindelhi.co.in,dentistindelhi@sabsoftzone.com,santoshbeats@gmail.com"; 
           
        $pcount=0;
        $gcount=0;
        $subject = "Enquiry Form footer <Newdelhidentistindia.com>";

    //    $from="info@newdelhidentistindia.com";
           $from="dev@sabsoftzone.com";
        while (list($key,$val)=each($_POST))
            {
            $pstr = $pstr."$key : $val \n ";
            ++$pcount;
    
            }
        while (list($key,$val)=each($_GET))
            {
            $gstr = $gstr."$key : $val \n ";
            ++$gcount;
    
            }
        if ($pcount > $gcount)
            {
			$message_body=$message;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .='From: '.$from."\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'Reply-to: '.$Email . "\r\n";
			$headers .= "CC: \r\n";
			$headers .= 'mailed-by: www..com' . "\r\n";
			mail($mailto,$subject,$message_body,$headers);
			$res = "Mail has been sent";
            }
            else
            {
    			$message_body=$message;
    			$headers  = 'MIME-Version: 1.0' . "\r\n";
    			$headers .='From: '.$from."\r\n";
    			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    			$headers .= 'Reply-to: '.$Email . "\r\n";
    			$headers .= "CC: \r\n";
    			$headers .= 'mailed-by: ' . "\r\n";
    			mail($mailto,$subject,$message_body,$headers);
    			$res = "Mail has been sent";
            }  
	}   else{
            	$arr = explode('?',$_SERVER['HTTP_REFERER']);
            	if($_POST['error1']){$err = "";}else{$err = "?error1=1";}
                    ?>
                    <script>
                    setTimeout(function() {
                     window.location.href = "<?php echo $arr[0].$err;?>";
                    },0);
                    </script>	
            	<?php die;
        		
        	}
}


if(isset($_POST['sent']) && empty($_POST['con_website'])){
	if($_POST['con_captcha']==$_SESSION['con_captcha']){
        $name 	= $_POST['firstname'];
    	$email	= $_POST['email_check'];
    	$phone 	= $_POST['country_phone'];
    	$dob 	= $_POST['form_date']; 
    	$Dob 	= date('d M Y', strtotime($dob));
    	$date 	= $_POST['date']; 
    	$adate 	= $_POST['arriv_month']; 
    	$count 	= $_POST['country'];
    	$state 	= $_POST['state'];
    	$zip 	= $_POST['zip_code1'];
    	$ddate 	= $_POST['dep_month'];
    	$nature 	= $_POST['nature[]'];
    	$date 	= date('d M Y', strtotime($date));
    	$hr 	= $_POST['hr'];
    	$min 	= $_POST['min'];
    	$msg 	= $_POST['sms'];
    	$time 	= $hr.':'.$min;
    	$nature = $_POST['nature[]'];
      //  $subject = "Internatiola Appoiment<newdelhidentistindia.com>";
       // $from="dev@sabsoftzone.com";
         	$from=$Email;
    		$subject ='Make an Appointment Form <http://orbiterr.com>';
    		$message.="Name: $name \r\n<br>";
    		$message.="E-mail: $email \r\n<br>";
    		$message.="Phone: $phone\r\n<br>";
    		$message.="DOB: $Dob \r\n<br>";
    		$message.="Date: $date \r\n<br>";
    		$message.="Arrive date: $adate \r\n<br>";
    		$message.="Contry: $count \r\n<br>";
    		$message.="State: $state \r\n<br>";
    		$message.="zip: $zip \r\n<br>";
    		$message.="Date: $ddate \r\n<br>";
    		$message.="Time: $hr\r\n<br>";
    		$message.="Min: $min\r\n<br>";
    		$message.="Message: $msg\r\n<br>";
    		$message.="Nature: $nature\r\n<br>";
    		$message.=" $k\r\n<br>";
    		$message.="Ip : $visiterIp\r\n<br>";
            $mailto = "dev@sabsoftzone.com";
           // $mailto="dentistindelhi@gmail.com,drshivani@dentistindelhi.co.in,dentistindelhi@sabsoftzone.com,santoshbeats@gmail.com"; 
            $pcount=0;
            $gcount=0;
            $subject = "International Appoiment Make an Appointment Form <newdelhidentistindia.com>";
            $from="info@newdelhidentistindia.com";
        while (list($key,$val)=each($_POST))
            {
            $pstr = $pstr."$key : $val \n ";
            ++$pcount;
            }
        while (list($key,$val)=each($_GET))
            {
            $gstr = $gstr."$key : $val \n ";
            ++$gcount;
            }
        if ($pcount > $gcount)
        {
			$message_body=$message;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .='From: '.$from."\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'Reply-to: '.$Email . "\r\n";
			$headers .= "CC: \r\n";
			$headers .= 'mailed-by: www.newdelhidentistindia.com' . "\r\n";
			mail($mailto,$subject,$message_body,$headers);
        }
        else
        {
			$message_body=$message;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .='From: '.$from."\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'Reply-to: '.$Email . "\r\n";
			$headers .= "CC: dev@sabsoftzone.com\r\n";
			$headers .= 'mailed-by: orbiterr.com' . "\r\n";
			mail($mailto,$subject,$message_body,$headers);
        }   
	}else{
		
        	$arr = explode('?',$_SERVER['HTTP_REFERER']);
        	if($_POST['error']){$err = "";}else{$err = "?error=1";}
            ?>
        	<script>
        	setTimeout(function() {
        	  window.location.href = "<?php echo $arr[0].$err;?>";
        	},0);
        	</script>	
        	<?php die;
        }		
}
// This is contact us form function
    if(isset($_POST['c_submit']) && empty($_POST['con_website'])){
	if($_POST['con_captcha']==$_SESSION['con_captcha']){
        $name 	= $_POST['name'];
    	$email	= $_POST['email'];
    	$subject 	= $_POST['subject'];
    //	$dob 	= $_POST['form_date']; 
    //	$Dob 	= date('d M Y', strtotime($dob));
    	//$date 	= $_POST['date']; 
    	$phone 	= $_POST['phone']; 
    	$msg 	= $_POST['message'];
    
      //  $subject = "Internatiola Appoiment<newdelhidentistindia.com>";
        $from="dev@sabsoftzone.com";
         	$from=$Email;
    		$subject ='Contactus form <http://orbiterr.com>';
    		$message.="Name: $name \r\n<br>";
    		$message.="E-mail: $email \r\n<br>";
    		$message.="Phone: $phone\r\n<br>";
    		$message.="Message:$msg \r\n<br>";
    		//$message.="Nature: $nature\r\n<br>";
    		
    		$message.="Ip : $visiterIp\r\n<br>";
            $mailto = "dev@sabsoftzone.com";
           // $mailto="dentistindelhi@gmail.com,drshivani@dentistindelhi.co.in,dentistindelhi@sabsoftzone.com,santoshbeats@gmail.com"; 
            $pcount=0;
            $gcount=0;
            $subject = "International Appoiment Make an Appointment Form <newdelhidentistindia.com>";
            $from="info@newdelhidentistindia.com";
        while (list($key,$val)=each($_POST))
            {
            $pstr = $pstr."$key : $val \n ";
            ++$pcount;
            }
        while (list($key,$val)=each($_GET))
            {
            $gstr = $gstr."$key : $val \n ";
            ++$gcount;
            }
        if ($pcount > $gcount)
        {
			$message_body=$message;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .='From: '.$from."\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'Reply-to: '.$Email . "\r\n";
			$headers .= "CC: \r\n";
			$headers .= 'mailed-by: www.newdelhidentistindia.com' . "\r\n";
			mail($mailto,$subject,$message_body,$headers);
        }
        else
        {
			$message_body=$message;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .='From: '.$from."\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'Reply-to: '.$Email . "\r\n";
			$headers .= "CC: dev@sabsoftzone.com\r\n";
			$headers .= 'mailed-by: orbiterr.com' . "\r\n";
			mail($mailto,$subject,$message_body,$headers);
        }   
	}else{
		
        	$arr = explode('?',$_SERVER['HTTP_REFERER']);
        	if($_POST['error']){$err = "";}else{$err = "?error=1";}
            ?>
        	<script>
        	setTimeout(function() {
        	  window.location.href = "<?php echo $arr[0].$err;?>";
        	},0);
        	</script>	
        	<?php die;
        }		
}
  
if(isset($_POST['btn']) && empty($_POST['app_website'])){
if($_POST['app_captcha']==$_SESSION['app_captcha']){
	$Name 	= $_POST['form_name'];
	$Email	= $_POST['form_email'];
	$Phone 	= $_POST['phone'];
	$Dob 	= $_POST['dob'];
	$city 	= $_POST['city'];
	$street = $_POST['Street'];
	$state 	= $_POST['form_state'];
	$Dob 	= date('d M Y', strtotime($Dob));
	$date 	= $_POST['date']; 
	$date 	= date('d M Y', strtotime($date));
	$zip 	= $_POST['zip'];
	$sms 	= $_POST['sms'];
	$city 	= $_POST['chk'];
	$hr 	= $_POST['hr'];
	$min 	= $_POST['min'];
//	$msg 	= $_POST['sms'];
	$time 	= $hr.':'.$min;
	$nature = $_POST['nature'];
    foreach($nature as $key){ 
    $k.= $key.'<br>';
}

		$from=$Email;
		$subject ='Make an Appointment Form <newdelhidentistindia.com>';
		$message.="Name: $Name \r\n<br>";
		$message.="E-mail: $Email \r\n<br>";
		$message.="Phone: $Phone\r\n<br>";
		$message.="DOB: $Dob \r\n<br>";
		$message.="city: $city \r\n<br>";
		$message.="Street: $street \r\n<br>";
		$message.="zip: $zip \r\n<br>";
		$message.="Help: $sms \r\n<br>";
		$message.="Date: $date \r\n<br>";
		$message.="Time: $time\r\n<br>";
		$message.="Message: $msg\r\n<br>";
		$message.=" $k\r\n<br>";
		$message.="Ip : $visiterIp\r\n<br>";
        $mailto = "dev@sabsoftzone.com";
       // $mailto="dentistindelhi@gmail.com,drshivani@dentistindelhi.co.in,dentistindelhi@sabsoftzone.com,santoshbeats@gmail.com"; 
        $pcount=0;
        $gcount=0;
        $subject = "DomeMake an Appointment Form <newdelhidentistindia.com>";
        $from="info@newdelhidentistindia.com";
        while (list($key,$val)=each($_POST))
            {
            $pstr = $pstr."$key : $val \n ";
            ++$pcount;
    
            }
        while (list($key,$val)=each($_GET))
            {
            $gstr = $gstr."$key : $val \n ";
    		++$gcount;
            }
        if ($pcount > $gcount)
        {
			$message_body=$message;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .='From: '.$from."\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'Reply-to: '.$Email . "\r\n";
			$headers .= "CC: ian.com\r\n";
			$headers .= 'mailed-by: www.newdelhidentistindia.com' . "\r\n";
			mail($mailto,$subject,$message_body,$headers);
        }
        else
        {
			$message_body=$message;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .='From: '.$from."\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'Reply-to: '.$Email . "\r\n";
			$headers .= "CC: ian.alam@minddigital.com\r\n";
			$headers .= 'mailed-by: www.newdelhidentistindia.com' . "\r\n";
			mail($mailto,$subject,$message_body,$headers);
        }   
	}else{ 
    	$arr = explode('?',$_SERVER['HTTP_REFERER']);
    	if($_POST['error2']){$err = "";}else{$err = "?error2=1";}
         ?>
    	<script>
    	setTimeout(function() {
    	  window.location.href = "<?php echo $arr[0].$err;?>";
    	},0);
    	</script>	
    	<?php die; }
}
?>
<script>
setTimeout(function() {
  window.location.href = "http://orbiterr.com/nath_demo/18_sept_2018/thnk.php";
},0);
</script>