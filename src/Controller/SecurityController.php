<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Parser;

class SecurityController extends Controller
{
    /**
     * Login the user and redirect to backend.
     *
     * @return RedirectResponse|Response
     */
    public function loginAction()
    {
        // read users
        $yaml = new Parser();
        $users = $yaml->parse(file_get_contents(__DIR__ . '/../../config/users.yml'));

        // redirect to backend if logged in
        if (array_key_exists('user', $_SESSION)) {
            return new RedirectResponse($this->getUrl('index'));
        }

        // check login and redirect if successful
        if (
            $_POST
            && array_key_exists('user', $_POST)
            && array_key_exists('pass', $_POST)
            && array_key_exists($_POST['user'], $users)
            && md5($_POST['pass']) == $users[$_POST['user']]
        ) {
            $_SESSION['user'] = $_POST['user'];
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