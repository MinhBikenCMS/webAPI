<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\ApiResponse;

class UserController extends Controller
{
    public function loginAction(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsernameOrEmail($username);

        if (!$user)
            return new ApiResponse(1100);

        if ($user->isEnabled() == false)
            return new ApiResponse(1101);

        $encoder = $this->get('security.password_encoder');

        if ($encoder->isPasswordValid($user, $password)) {
            $token = bin2hex(random_bytes(20));

            $em = $this->getDoctrine()->getManager();
            $user->setAccessToken($token);
            $em->persist($user);
            $em->flush();

            return new ApiResponse(1000, [
                'token' => $token
            ]);
        }

        return new ApiResponse(1103);
    }
}
