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
        $profile = unserialize($_SESSION['user']);
        if ($_SESSION['user-role'] == 'Coordinator') {
            $site_announcement = SiteAnnouncement::createNewAnn(
                heading: $body['heading'],
                content: $body['content'],
                cordRegNo: $profile->getRegNo()
            );
        } else if ($_SESSION['user-role'] == 'Admin') {
            $site_announcement = SiteAnnouncement::createNewAnn(
                heading: $body['heading'],
                content: $body['content'],
                adminRegNo: $profile->getRegNo()
            );
        }
        $site_announcement->insert();
        header("Location: /site_announcement");
    }
}