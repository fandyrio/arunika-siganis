<?php
    namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Hash;

    class userService{
        public function generateUser($nama, $nip){
            $user=new User();
            $user->name=$nama;
            $user->nip=$nip;
            $user->password=Hash::make('123');
            $user->role=1;
            return $user->save();
        }
    }



?>