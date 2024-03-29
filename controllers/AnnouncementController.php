<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\model\SiteAnnouncement;
use app\model\CourseAnnouncement;

class AnnouncementController extends Controller
{
    /**
     * @description Display site announcements
     * @return array|false|string|string[]
     */
    public function displaySiteAnnouncements()
    {
        $announcements = ['announcements'=>SiteAnnouncement::getSiteAnnouncements()];
        return $this->render(
            view: 'announcement',
            params: $announcements
        );
    }

    /**
     * @description Display course announcements
     * @param Request $request
     * @return array|false|string|string[]
     */
    public function displayCourseAnnouncements(Request $request)
    {
        $body = $request->getBody();
        $params['course_code'] = $body['course_code'];
        $params['announcements'] = CourseAnnouncement::getCourseAnnouncements($params['course_code']);
        return $this->render(
            view: 'course/course_announcement',
            params: $params
        );
    }

    /**
     * @description Create site announcements
     * @param Request $request
     * @return void
     */
    public function createSiteAnnouncements(Request $request)
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
        $site_announcement->SiteAnnouncementInsert();
        header("Location: /site_announcement");
    }

    /**
     * @description Create course announcements
     * @param Request $request
     * @return void
     */
    public function createCourseAnnouncements(Request $request)
    {
        $body = $request->getBody();
        $profile = unserialize($_SESSION['user']);
        $course_announcement = CourseAnnouncement::createNewAnn(
            heading: $body['heading'],
            content: $body['content'],
            lecRegNo: $profile->getRegNo(),
            courseCode: $body['course_code']
        );
        $course_announcement->CourseAnnouncementInsert();
        header("Location: /course_announcement?course_code=".$body['course_code']);
    }

    /**
     * @description Update site announcements
     * @param Request $request
     * @return void
     */
    public function updateSiteAnnouncements(Request $request)
    {
        $body = $request->getBody();
        SiteAnnouncement::updateAnnouncements($body['announcement_id'],$body['heading'],$body['content']);
        header("Location: /site_announcement?announcement_id=".$body['announcement_id']);
    }

    /**
     * @description Update course announcements
     * @param Request $request
     * @return void
     */
    public function updateCourseAnnouncements(Request $request)
    {
        $body = $request->getBody();
        CourseAnnouncement::CourseAnnouncementsUpdate($body['announcement_id'],$body['heading'],$body['content']);
        header("Location: /course_announcement?course_code=".$body['course_code']);
    }

    /**
     * @description Delete site announcements
     * @param Request $request
     * @return void
     */
    public function deleteSiteAnnouncements(Request $request)
    {
        $body = $request->getBody();
        SiteAnnouncement::deleteSiteAnnouncement($body['announcement_id_delete']);
        header("Location: /site_announcement");
    }

    /**
     * @description Delete course announcements
     * @param Request $request
     * @return void
     */
    public function deleteCourseAnnouncements(Request $request)
    {
        $body = $request->getBody();
        CourseAnnouncement::deleteCourseAnnouncement($body['announcement_id_delete'],$body['course_code_delete']);
        header("Location: /course_announcement?course_code=".$body['course_code_delete']);
    }
}