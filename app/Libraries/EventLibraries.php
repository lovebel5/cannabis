<?php


namespace App\Libraries;

use App\Repositories\EventRepositories;
use App\Repositories\ProfileRepositories;


class EventLibraries
{

    public $EventRepositories;
    public $ProfileRepositories;

    public function __construct(EventRepositories $EventRepositories, ProfileRepositories $ProfileRepositories){
        $this->EventRepositories = $EventRepositories;
        $this->ProfileRepositories = $ProfileRepositories;


    }
}
