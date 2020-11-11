<?php
ini_set('SMTP', "mail.marzek.at");
ini_set('smtp_port', "25");

$uploadedFile = array();
$postData = $statusMsg = '';
$msgClass = 'errordiv';
if(isset($_POST['submit'])){
    // Get the submitted form data
    $postData = $_POST;
    $senderEmail = $_POST['senderEmail'];
    $receiverEmail = $_POST['receiverEmail'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $uploadedFile = $_POST['attachment'];

    ini_set('sendmail_from', $senderEmail);

    // Check whether submitted data is not empty
    if(!empty($receiverEmail) && !empty($senderEmail) && !empty($subject) && !empty($message)){
        
        // Validate receiverEmail
        if(filter_var($receiverEmail, FILTER_VALIDATE_EMAIL) === false && filter($senderEmail, FILTER_VALIDATE_EMAIL) === false){
            $statusMsg = 'Please enter your valid email.';
        }else{
            $uploadStatus = 1;

            if($uploadStatus == 1){
                
                // Recipient
                $toEmail = $senderEmail;

                // Sender
                $from = $senderEmail;
                $fromName = '';
                
                // Subject
                $emailSubject = $subject;
                
                // Message 
                $htmlContent = '<p>'.$message.'</p>';

                // Header for sender info
                $headers = "From: $fromName"." <".$from.">";

                        // Boundary 
                        $semi_rand = md5(time()); 
                        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
                        
                        // Headers for attachment 
                        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
                        
                        // Multipart boundary 
                        $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
                        
                        for($i = 0; $i < count($uploadedFile); $i++){
                            if(is_file($uploadedFile[$i])){
                                $message .= "--{$mime_boundary}\n";
                                $fp =    @fopen($uploadedFile[$i],"rb");
                                $data =  @fread($fp,filesize($uploadedFile[$i]));
                                @fclose($fp);
                                $data = chunk_split(base64_encode($data));
                                $message .= "Content-Type: application/octet-stream; name=\"".basename($uploadedFile[$i])."\"\n" . 
                                "Content-Description: ".basename($uploadedFile[$i])."\n" .
                                "Content-Disposition: attachment;\n" . " filename=\"".basename($uploadedFile[$i])."\"; size=".filesize($uploadedFile[$i]).";\n" . 
                                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                            }

                            // Delete attachment file from the server
                            @unlink($uploadedFile[$i]);
                        }
                
                        $message .= "--{$mime_boundary}--";
                        $returnpath = "-f" . $receiverEmail;

                $mail = mail($toEmail, $emailSubject, $message, $headers, $returnpath);

                ?><div id="sendMessage"></div><?php
                
                if($mail){
                    ?>
                    <script language="javascript" type="text/javascript">
                    var x = document.getElementById('sendMessage');
                    x.innerHTML = "E-Mail wurde gesendet";
                    x.style.backgroundColor = "lightgreen";
                    x.style.visibility = "visible";
                    setTimeout(function(){
                        x.style.visibility = "hidden"; 
                        window.location.href = 'searching.php';
                    }, 2500);
                   </script>
                   <?php
                }else{
                    ?>
                    <script language="javascript" type="text/javascript">
                    var x = document.getElementById('sendMessage');
                    x.innerHTML = "E-Mail senden wurde fehlgeschlagen, versuchen Sie es erneut";
                    x.style.backgroundColor = "red";
                    x.style.visibility = "visible";
                    setTimeout(function(){
                        x.style.visibility = "hidden"; 
                    }, 2500);
                   </script>
                   <?php
                    $statusMsg = 'Your contact request submission failed, please try again.';
                }
            }
        }
    }else{
        $statusMsg = 'Please fill all the fields.';
    }
}
?>