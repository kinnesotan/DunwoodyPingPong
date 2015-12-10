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
    $mail->AddAddress('mattkinne@gmail.com', 'MATT!');
 
    $mail->Subject  =  'I actually made something that works!!!!!!!';
    $mail->IsHTML(true);
    $mail->Body    = 'Hi there ,
                        <br />
                        THIS ACTUALLY WORKED
                        <br />
                        Only spent like four hours total on this.';
  
     if($mail->Send())
     {
        echo "Message was Successfully Sent ";
     }
     else
     {
        echo "Mail Error - >".$mail->ErrorInfo;
     }
  
?>
    