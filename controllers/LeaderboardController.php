<?php

namespace app\controllers;

use app\core\Controller;

class LeaderboardController extends Controller
{
    public function displayLeaderboard()
    {
        return $this->render(
            view: 'leaderboard',
            allowedRoles: ['Student']
        );
    }
}