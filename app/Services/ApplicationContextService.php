<?php

namespace App\Services;

use App\Models\Site;
use App\Models\User;

class ApplicationContextService
{

    private $currentSite;
    private $currentUser;

    protected function __construct()
    {
        $this->currentSite = new Site();
        $this->currentUser = new User();
    }

    public function getCurrentSite()
    {
        return $this->currentSite;
    }

    public function getCurrentUser()
    {
        return $this->currentUser;
    }
}
