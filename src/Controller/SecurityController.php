<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * Login the user and redirect to backend.
     *
     * @return RedirectResponse|Response
     */
    public function loginAction()
    {
        // redirect to backend if logged in
        if (array_key_exists('user', $_SESSION)) {
            return new RedirectResponse($this->getUrl('index'));
        }

        // check login and redirect if successful
        if (
            $_POST
            && array_key_exists('user', $_POST)
            && array_key_exists('pass', $_POST)
            && $_POST['user'] == 'crea'
            && $_POST['pass'] == 'creapw2015'
        ) {
            $_SESSION['user'] = true;
            return new RedirectResponse($this->getUrl('index'));
        }

        return $this->render();
    }

    /**
     * Logout the current user and redirect to frontend.
     *
     * @return RedirectResponse
     */
    public function logoutAction()
    {
        // destroy session
        session_destroy();

        // redirect to frontend
        return new RedirectResponse('/');
    }
}