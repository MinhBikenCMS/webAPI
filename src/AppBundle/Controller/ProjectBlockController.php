<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProjectBlock;
use AppBundle\Form\ProjectBlockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\ApiResponse;

class ProjectBlockController extends Controller
{
    public function addAction(Request $request)
    {
        $token = $request->query->get('token', 0);

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->findByAccessToken($token);
        if(!$user)
            return new ApiResponse(1104);

        $projectBlock = new ProjectBlock();
        $form = $this->createForm(ProjectBlockType::class, $projectBlock);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($projectBlock);
            $em->flush();

            $data[] = $projectBlock->parse();

            return new ApiResponse(1000, ['block' => $data]);
        }

        $errors = $this->get('orn.form')->getErrors($form);

        return new ApiResponse(1001, null, $errors);
    }

}
