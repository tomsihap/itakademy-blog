<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController {

    /**
     * @Route("/", name="app_index", methods={"GET"})
     */
    public function index() : Response {

        $pageTitle = "Mon super site";

        $movies = [
            [
                "title" => "Inception",
                "length" => 135,
            ],
            [
                "title" => "Rocky",
                "length" => 126,
            ]
        ];

        return $this->render('app/index.html.twig', [
            'title' => $pageTitle,
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/messagerie", name="app_messagerie_get", methods={"GET"})
     */
    public function messageForm(Request $request) {

        return $this->render('app/form.html.twig');
    }

    /**
     * @Route("/traitementMessagerie", name="app_messagerie_post", methods={"POST"})
     */
    public function messagePost(Request $request) {

        return $this->render('app/confirmMessage.html.twig', [
            'username' => $request->request->get('username'),
            'content'  => $request->request->get('content'),
        ]);
    }
}