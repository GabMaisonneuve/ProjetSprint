<?php
namespace App\Providers;

class Auth
{
    public static function requireAuth($requiredRoleId = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si l'utilisateur n'est pas connecté
        if (!isset($_SESSION['user'])) {
            // header('Location: /login');
            // exit;
            return View::render('login', [
                'errors' => ['You must be logged in to access this page.'],
                'title' => 'Login'
            ]);
        }

        // Si un rôle spécifique est requis
        if ($requiredRoleId !== null && $_SESSION['user']['role_id'] < $requiredRoleId) {
    echo "Access denied.";
    exit;
}

    }

    public static function guestOnly()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user'])) {
            // header('Location: /');
            // exit;
            return View::render('home', [
                'message' => 'You are already logged in.',
                'session' => $_SESSION['user']
            ]);
        }
    }
}
