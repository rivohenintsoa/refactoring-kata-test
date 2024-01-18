<?php

namespace App\Services;

use App\Models\Site;
use App\Models\User;

/**
 * Class ApplicationContextService
 * @package App\Services
 */
class ApplicationContextService
{
    /**
     * @var Site The current site.
     */
    private $currentSite;

    /**
     * @var User The current user.
     */
    private $currentUser;

    /**
     * ApplicationContextService constructor.
     */
    public function __construct()
    {
        $this->currentSite = new Site();
        $this->currentUser = new User();
    }

    /**
     * Get the current site.
     *
     * @return Site The current site.
     */
    public function getCurrentSite()
    {
        return $this->currentSite;
    }

    /**
     * Get the current user.
     *
     * @return User The current user.
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }
}
