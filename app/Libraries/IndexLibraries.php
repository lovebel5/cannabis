<?php


namespace App\Libraries;


class IndexLibraries
{
    public function checkInputNull($data){
        if(!isset($data['expert'],$data['coworker'])){
            return true;
        } else {
            return false;
        };

    }

}
