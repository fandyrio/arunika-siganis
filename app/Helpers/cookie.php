<?php
    use Carbon\Carbon;
    use App\Unique_visitor;
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Facades\Crypt;

    if(!function_exists('checkUniqueVisitor')){
        function checkUniqueVisitor(){
            if(!Cookie::has('visitor_id')){
                $date=date('YmdHis');
                $text=strtotime($date);
                $enc=Crypt::encrypt($text);
                $minutes=60*24*30*12*10;
                Cookie::queue('visitor_id', $enc, $minutes);

                //get IP ADDRESS
                $ip_address="not_detect";
                if(!empty($_SERVER['HTTP_CLIENT_IP'])) {   
                    $ip_address=$_SERVER['HTTP_CLIENT_IP'];   
                }   
                //if user is from the proxy   
                elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   
                    $ip_address=$_SERVER['HTTP_X_FORWARDED_FOR'];   
                }   
                //if user is from the remote address   
                else{   
                    $ip_address=$_SERVER['REMOTE_ADDR'];   
                }

                $unique_visitor=new Unique_visitor;
                $unique_visitor->ip_address=$ip_address;
                $unique_visitor->cookie_id=$enc;
                $unique_visitor->device_info=null;
                $unique_visitor->last_access=date('Y-m-d H:i:s');
                $unique_visitor->save();

            }
        }
    }

?>