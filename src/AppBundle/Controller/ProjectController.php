<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\ApiResponse;

class ProjectController extends Controller
{
    public function listAction(Request $request)
    {

        $token = $request->request->get('token', 0);

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->findByAccessToken($token);
        if(!$user)
            return new ApiResponse(1104);

        $page = $request->request->getInt('page', 1);
        $limit = $request->request->getInt('limit', 20);

        $args = [
            'page' => $page,
            'limit' => $limit
        ];
        $projects = $em->getRepository('AppBundle:Project')->getBy($args);

        $data = [];
        foreach ($projects as $p)
            $data[] = $p->parse();

        $total = $em->getRepository('AppBundle:Project')->countBy($args);

        return new ApiResponse(1000, ['total' => $total, 'projects' => $data]);
    }

    public function addAction(Request $request)
    {
        $token = $request->query->get('token', 0);

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->findByAccessToken($token);
        if(!$user)
            return new ApiResponse(1104);

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($project);
            $em->flush();

            $data[] = $project->parse();

            return new ApiResponse(1000, ['project' => $data]);
        }

        $errors = $this->get('orn.form')->getErrors($form);

        return new ApiResponse(1001, null, $errors);

    }
}
