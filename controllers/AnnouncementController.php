<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\model\SiteAnnouncement;
use app\model\CourseAnnouncement;
use DateTime;


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

    public function createSiteAnnouncements(Request $request)
    {
        $body = $request->getBody();
        $profile = unserialize($_SESSION['user']);

        $errors = []; // Initialize an empty array to store validation errors

        // Validate heading
        if (empty($body['heading'])) {
            $errors['heading'] = 'Heading is required.';
        }

        // Validate content
        if (empty($body['content'])) {
            $errors['content'] = 'Content is required.';
        }

        // If there are validation errors, return the errors to the view
        if (!empty($errors)) {
            $params['errors'] = $errors;
            $params['announcements'] = SiteAnnouncement::getSiteAnnouncements();
            return $this->render(
                view: 'announcement',
                params: $params
            );
        }
        // Remove escape characters and line breaks
        $heading = addslashes(str_replace(array("\r", "\n"), '', $body['heading']));
        $content = addslashes(str_replace(array("\r", "\n"), '', $body['content']));

        if ($_SESSION['user-role'] == 'Coordinator') {
            $site_announcement = SiteAnnouncement::createNewAnn(
                heading: $heading,
                content: $content,
                cordRegNo: $profile->getRegNo()
            );
        } else if ($_SESSION['user-role'] == 'Admin') {
            $site_announcement = SiteAnnouncement::createNewAnn(
                heading: $heading,
                content: $content,
                adminRegNo: $profile->getRegNo()
            );
        }
        $params['create_announcement'] = $site_announcement->SiteAnnouncementInsert();
        $params['announcements'] = SiteAnnouncement::getSiteAnnouncements();
        return $this->render(
            view: 'announcement',
            params: $params
        );
    }


    public function createCourseAnnouncements(Request $request)
    {
        $body = $request->getBody();
        $profile = unserialize($_SESSION['user']);

        $errors = []; // Initialize an empty array to store validation errors

        // Validate heading
        if (empty($body['heading'])) {
            $errors['heading'] = 'Heading is required.';
        }

        // Validate content
        if (empty($body['content'])) {
            $errors['content'] = 'Content is required.';
        }

        // If there are validation errors, return the errors to the view
        if (!empty($errors)) {
            $params['errors'] = $errors;
            $params['course_code'] = $body['course_code'];
            $params['announcements'] = CourseAnnouncement::getCourseAnnouncements($body['course_code']);
            return $this->render(
                view: 'course/course_announcement',
                params: $params
            );
        }

        $course_announcement = CourseAnnouncement::createNewAnn(
            heading: $body['heading'],
            content: $body['content'],
            lecRegNo: $profile->getRegNo(),
            courseCode: $body['course_code']
        );
        $params['create_course_announcement']=$course_announcement->CourseAnnouncementInsert();
        $params['course_code'] = $body['course_code'];
        $params['announcements'] = CourseAnnouncement::getCourseAnnouncements($body['course_code']);
        return $this->render(
            view: 'course/course_announcement',
            params: $params
        );
    }

    public function updateSiteAnnouncements(Request $request)
    {
        $body = $request->getBody();

        $error = [];

        if (empty($body['heading'])) {
            $error['heading'] = 'Heading is required.';
        }

        // Validate content
        if (empty($body['content'])) {
            $error['content'] = 'Content is required.';
        }

        // If there are validation errors, return the errors to the view
        if (!empty($error)) {
            $params['errors'] = $error;
            $params['announcements'] = SiteAnnouncement::getSiteAnnouncements();
            return $this->render(
                view: 'announcement',
                params: $params
            );
        }

        // Check time difference
        $publishDate = new DateTime($body['edit_publish_date']);
        $currentDate = new DateTime();
        $timeDifference = $currentDate->diff($publishDate);

        $minutesDifference = ($timeDifference->days * 24 * 60) +
            ($timeDifference->h * 60) +
            $timeDifference->i;

        if ($minutesDifference > 30) {
            // Redirect back to the submit page
            $params['announcements'] = SiteAnnouncement::getSiteAnnouncements();
            return $this->render(
                view: 'announcement',
                params: $params
            );
        }

        $params['update_announcement'] = SiteAnnouncement::updateAnnouncements($body['announcement_id'],$body['heading'],$body['content']);
        $params['announcements'] = SiteAnnouncement::getSiteAnnouncements();
        return $this->render(
            view: 'announcement',
            params: $params
        );
    }

    public function updateCourseAnnouncements(Request $request)
    {
        $body = $request->getBody();

        $error = [];

        if (empty($body['heading'])) {
            $error['heading'] = 'Heading is required.';
        }

        // Validate content
        if (empty($body['content'])) {
            $error['content'] = 'Content is required.';
        }

        // If there are validation errors, return the errors to the view
        if (!empty($error)) {
            $params['errors'] = $error;
            $params['course_code'] = $body['course_code'];
            $params['announcements'] = CourseAnnouncement::getCourseAnnouncements($body['course_code']);
            return $this->render(
                view: 'course/course_announcement',
                params: $params
            );
        }

        // Check time difference
        $publishDate = new DateTime($body['edit_publish_date']);
        $currentDate = new DateTime();
        $timeDifference = $currentDate->diff($publishDate);

        $minutesDifference = ($timeDifference->days * 24 * 60) +
            ($timeDifference->h * 60) +
            $timeDifference->i;

        if ($minutesDifference > 30) {
            // Redirect back to the submit page
            $params['course_code'] = $body['course_code'];
            $params['announcements'] = CourseAnnouncement::getCourseAnnouncements($body['course_code']);
            return $this->render(
                view: 'course/course_announcement',
                params: $params
            );
        }
        $params['update_announcement'] = CourseAnnouncement::CourseAnnouncementsUpdate($body['announcement_id'],$body['heading'],$body['content']);
        $params['course_code'] = $body['course_code'];
        $params['announcements'] = CourseAnnouncement::getCourseAnnouncements($body['course_code']);
        return $this->render(
            view: 'course/course_announcement',
            params: $params
        );
    }
}