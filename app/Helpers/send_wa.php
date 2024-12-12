<?php
    use Carbon\Carbon;

    if(! function_exists('sendWaHelp')){
        function sendWaHelp($data){
            $dev_telp = '081324414747';
            $waUrl = 'https://webservice.mahkamahagung.go.id/';
            // $this->token = 'c97f462b-b1aa-4417-b0a0-ab146c8c954e';
            $token = 'e25ca442-c4dd-4e7b-bdbb-ccd95c90f7d7';
            
        $body = "";
        if ($data['nama'] != null && $data['nama'] != "") {
            $body .= "Kepada Yth:" . PHP_EOL . "*" . $data['nama'] . "*" . PHP_EOL . PHP_EOL;
        }
        
        $body .= $data['pesan'];
        // $body .= PHP_EOL . PHP_EOL . "Silahkan login ke " . $this->baseUrl . " untuk info lebih lanjut." . PHP_EOL . "Terima Kasih.";

        $headers    = array(
            'User-Agent: SIGANIS Badilum',
            // 'token: d4b32588-ec99-4262-b6f9-4888bd13b628',
            'token: ' . $token,
            'names: siganis',
            'Content-Type: application/json'
        );
        $telepon=$data['no_wa'];
        $postfield  = json_encode(array(
            "variable"  => "_Ini adalah pesan otomatis Aplikasi Sistem Pembinaan Tenaga Teknis (SIGANIS)_",
            "variable2" =>  preg_replace("/\n/m", '\n', "$body"),
            "phone"     =>  "$telepon",
        ));

        $curl = curl_init();

        curl_setopt_array($curl, array(
            // CURLOPT_URL                 => 'https://webservice.mahkamahagung.go.id/wa_gateway/send_wa',
            CURLOPT_URL                 => $waUrl . 'wa_gateway/send_wa',
            CURLOPT_RETURNTRANSFER      => true,
            CURLOPT_ENCODING            => '',
            CURLOPT_MAXREDIRS           => 10,
            CURLOPT_TIMEOUT             => 0,
            CURLOPT_FOLLOWLOCATION      => true,
            CURLOPT_HTTP_VERSION        => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER      => false,
            CURLOPT_SSL_VERIFYHOST      => false,
            CURLOPT_CUSTOMREQUEST       => 'POST',
            CURLOPT_POSTFIELDS          => $postfield,
            CURLOPT_HTTPHEADER          => $headers,
        ));

        $response = curl_exec($curl);

        $info = curl_getinfo($curl);
        curl_close($curl);

        if ($info['http_code'] != 200) {
            $this->error_message = "HTTP Error API WA. (HTTP " . $info['http_code'] . ")";
            $this->error_message .= "\nPostdata:\n" . $postfield;
            $this->error_message .= "\nResponse:\n" . $response;
            return false;
        }
        $response = json_decode($response);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error_message = "Komunikasi Bermasalah dengan Server API WA";
            return false;
        }
        if ($response->status != 'ok') {
            $this->error_message = $response->response;
            return false;
        }
        
        return $response->status;
        }
    }

?>