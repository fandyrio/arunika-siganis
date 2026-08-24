<?php
    use Carbon\Carbon;
    use App\Config;

    if(! function_exists('sendWaHelp')){
        function sendWaHelp($data){
            $body = "";
            $body .= "Kepada Yth:" . PHP_EOL . "*" . $data['nama'] . "*" . PHP_EOL . PHP_EOL;
            $body .= $data['pesan'];
            $data=[
                'token'=>config('services.WA_MA.token'),
                'nip'=>$data['nip'],
                'message'=>$body,
                'phoneNumber'=>$data['no_wa'],
                'name'=>$data['nama'],
                'serviceMode'=>config('services.WA_MA.serviceMode')
            ];
            

            $data_post=json_encode($data);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => config('services.WA_MA.CURLOPT_URL'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data_post,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer pBSpYVQFb3znpLfdaBdtkkJk-oPdObpt-RvGBNiF',
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response_dec=json_decode($response);
            return [
                'status'=>$response_dec->status,
                'msg'=>$response_dec->message
            ];
        }
    }

    function sendWAlama($data){
        
    }

?>