<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
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
    public function createAnnouncements(Request $request)
    {
        $body = $request->getBody();
//        ['heading' -> 'adsada', 'key' -> value]
        // $body['heading']
      $site_announcement = SiteAnnouncement::createNewAnn($body['heading','content']);
          $site_announcement.insert();
        return $this->render(
            view: 'announcement',
            params: $announcements
        );
    }


}