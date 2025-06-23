<?php
require '/home/apps/intranet/lib/PHPMailer/PHPMailerAutoload.php';

// Connection variables
$dbhost	= "localhost";	   // localhost or IP
$dbuser	= "apps";		  // database username
$dbpass	= "Besser35**";		     // database password
$dbname	= "ired";    // database name


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT id, asunto, tipo, telfs, mails, sms_body, mail_body FROM msg_mass WHERE procesado=0";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $tipo = $row["tipo"];
    if($tipo==0) {
      send_sms($row["id"], $row["telfs"], $row["sms_body"]);
    } else if ($tipo==1){
      send_mail($row["id"], $row["mails"], $row["mail_body"], $row["asunto"]);
    } else {
      send_sms($row["id"], $row["telfs"], $row["sms_body"]);
      send_mail($row["id"], $row["mails"], $row["mail_body"], $row["asunto"]);
    }
  }
}

function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function send_mail($id, $mails, $mail_txt, $mail_asunto) {
  $aux_mail=str_replace(";;;","",$mails);
  $mails_array = explode (";", $aux_mail);
  $i=0; $j=0;
  foreach ($mails_array as $val) {
    if($i==10) {
      break;
    }

    if(strlen($val)>5) {
      $j++;
      $mail = new PHPMailer;
      //$mail->SMTPDebug = 3;
      $mail->isSMTP();                                            // Send using SMTP
      $mail->Host       = '192.168.69.7';                    // Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = 'noreply@bessersolutions.com';                     // SMTP username
      $mail->Password   = 'Besser35';                               // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port       = 587;                                    // TCP port to connect to
      //Recipients
      $mail->setFrom('noreply@bessersolutions.com', 'Besser Solutions');
      $mail->addAddress($val);               // Name is optional
      $mail->addReplyTo('soporte@bessersolutions.com', 'Soporte Besser Solutions C.A');
      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $mail_asunto;
      $mail->Body    = $mail_txt;
      $mail->SMTPOptions = array(
          'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
          )
      );
      if(!$mail->send()) {
        echo 'Message could not be sent. Mailer Error:  ' . $mail->ErrorInfo;
      } else {
          echo 'Message has been sent '.$val."<br/>";
      }
    }
    $aux_mail=str_replace($val,"",$aux_mail);
    $i++;
  }
  if($j==0) {
    $conn2 = mysqli_connect("localhost", "apps", "Besser35**", "ired");
    $query_2 = "UPDATE msg_mass SET procesado = 1 WHERE id='".$id."'";
    mysqli_query($conn2, $query_2);
    mysqli_close($conn2);
  } else {
    $conn2 = mysqli_connect("localhost", "apps", "Besser35**", "ired");
    $query_2 = "UPDATE msg_mass SET mails = '$aux_mail' WHERE id='".$id."'";
    mysqli_query($conn2, $query_2);
    mysqli_close($conn2);
  }
}

function send_sms($id, $telfs, $sms_txt) {
  $aux_telf=str_replace(";;;","",$telfs);
  $telfs_array = explode (";", $aux_telf);
  $sms=str_replace(" ","+",$sms_txt);
  $i=0; $j=0;
  foreach ($telfs_array as $val) {
    if($i==10) {
      break;
    }
    if(strlen($val)>5) {
      $j++;
      echo "http://192.168.93.85:8090/SendSMS?username=admin&password=admin&phone=$val&message=$sms";
      $returned_content = get_data("http://192.168.93.85:8090/SendSMS?username=admin&password=admin&phone=$val&message=$sms");
      sleep(5);
    }
    $aux_telf=str_replace($val,"",$aux_telf);
    $i++;
  }
  if($j==0) {
    $conn2 = mysqli_connect("localhost", "apps", "Besser35**", "ired");
    $query_2 = "UPDATE msg_mass SET procesado = 1 WHERE id='".$id."'";
    mysqli_query($conn2, $query_2);
    mysqli_close($conn2);
  } else {
    $conn2 = mysqli_connect("localhost", "apps", "Besser35**", "ired");
    $query_2 = "UPDATE msg_mass SET telfs = '$aux_telf' WHERE id='".$id."'";
    mysqli_query($conn2, $query_2);
    mysqli_close($conn2);
  }
}
?>
