<?php

// function httpGet($url)
// {
//     $ch = curl_init();  
 
//     curl_setopt($ch,CURLOPT_URL,$url);
//     curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
// //  curl_setopt($ch,CURLOPT_HEADER, false); 
 
//     $output=curl_exec($ch);
 
//     curl_close($ch);
//     return $output;
// }
 
// $mobile = $_REQUEST['mobile'];
// $otp = $_REQUEST['otp'];

// if($_REQUEST['code'] == "38ho3f3ws"){
// echo httpGet("https://2factor.in/API/V1/e68df82f-7610-11ec-b710-0200cd936042/SMS/+91$mobile/$otp");
// } else {
  
//   echo '<h3>404 page not found</h3>';
  
// }



    include "con.php";  






function sendMessageThroughfast2sms($to_number, $otp, $country_code)
{
// $otp = $code;
    $fields = array(
        "sender_id" => "FSTSMS",
        "message" => "Your verification code is $otp",
        "language" => "english",
        "route" => "p",
        "numbers" => $to_number,
        "flash" => "1"
    );
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($fields),
        CURLOPT_HTTPHEADER => array(
            "authorization: bwBar7KOMNAzg3RLdkUeDGx8XPnhY6129iElJc50SZoFTumjvqf5om7VMKwhlBrYRsZOI2E1FUpC3vLc",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    ob_start();
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
    ob_end_clean();
}

$mobile = $_REQUEST['mobile'];
// $otp = $_REQUEST['otp'];
 //$otp = rand(1000,9999);
// `
  // var_dump($mobile);


// $check2 = mysqli_query($con, "select * from users where mobile='$mobile'");
// $row = mysqli_fetch_assoc($check2);
// $otp = $row['otp'];


$check = mysqli_query($con, "select * from users where mobile='$mobile'");
   // var_dump($check); // Debug output

if (mysqli_num_rows($check) > 0) {

    $cs = mysqli_fetch_array($check);
    $otp = $cs['otp'];
   // var_dump($otp); // Debug output
} else {
    // echo "not found"; // Debug output
    $otp = rand(1000,9999);
}


//$otp='123456';

if ($_REQUEST['code'] == "38ho3f3ws") {
     $data['success'] = "0";
    $data['msg'] = "Otp send successfully";
    sendMessageThroughfast2sms($mobile, $otp, "+91"); // Pass mobile number and OTP here
   
} else {
    //echo '<h3>404 page not found</h3>';
    $data['success'] = "1";
    $data['msg'] = "Otp send failed";
}
echo json_encode($data);

?>
