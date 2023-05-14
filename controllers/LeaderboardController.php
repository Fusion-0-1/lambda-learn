<?php

namespace app\controllers;

use app\core\Controller;

class LeaderboardController extends Controller
{
    /**
     * @description Display leaderboard
     * @return array|false|string|string[]
     */
    public function displayLeaderboard()
    {
        return $this->render(
            view: 'leaderboard',
            allowedRoles: ['Student']
        );
    }
}