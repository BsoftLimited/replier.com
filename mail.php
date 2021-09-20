<?php
	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	
	//get post data
	$data = json_decode(file_get_contents("php://input"));
	
	if(!empty($data->name) && !empty($data->email) && !empty($data->subject) && !empty($data->message)){
		$mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.defoody.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'noreply@defoody.com';                 // SMTP username
        $mail->Password = 'defoodyapp_@';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        
        $mail->setFrom('noreply@cityofhouston.com', 'City of Houston');
        $mail->addAddress($data->email);     // Add a recipient
        $mail->addReplyTo('support@cityofhouston.com', 'For more support');
        
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $data->subject;
        $mail->Body    = "<h4> Dear ".$data->name."</h4> <p style='color:#3456ff;'>".$data->message."</p>";
        $mail->AltBody = "<h4>".$data->name."</h4> <p style='color:#3456ff;'>".$data->message."</p>";
        
        if(!$mail->send()) {
        	http_response_code(501);
            echo json_encode(array("message" => 'Mailer Error: ' . $mail->ErrorInfo));
        } else {
        	http_response_code(200);
            echo json_encode(array("message" => 'message sent'));
        }
	}else{
		http_response_code(501);
        echo json_encode(array("message" => 'bad server request'));
	}
?>