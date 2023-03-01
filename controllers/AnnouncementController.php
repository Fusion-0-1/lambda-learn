<?php

namespace app\controllers;

use app\core\Controller;
use app\model\SiteAnnouncement;



class AnnouncementController extends Controller
{
    public function displaySiteAnnouncements()
    {
        $announcements = ['announcements'=>SiteAnnouncement::getSiteAnnouncements()];
        return $this->render(
            view: 'announcement',
            params: $announcements
        );
    }

}