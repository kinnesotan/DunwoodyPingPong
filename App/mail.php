<?php 

 require_once('PHPMailerAutoload.php');
 
    $mail = new PHPMailer();
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = "fortestingpurposes28@gmail.com";
    $mail->Password = "chocolatedog";
    $mail->SMTPSecure = "ssl";  
    $mail->Host = "smtp.gmail.com";
    $mail->Port = "465";
 
    $mail->setFrom('fortestingpurposes28@gmail.com', 'Andrew Kinniburgh');
    $mail->AddAddress('andrewkinniburgh@gmail.com', 'hey');
 
    $mail->Subject  =  'I actually made something that works AND IF VERY HACKABLE HAHAHAHAHA!!!!!!!';
    $mail->IsHTML(true);
    $mail->Body    = 'Hi there';
  
     if($mail->Send())
     {
        echo "Message was Successfully Sent ";
     }
     else
     {
        echo "Mail Error - >".$mail->ErrorInfo;
     }
  
?>
    