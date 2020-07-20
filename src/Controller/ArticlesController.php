<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController
{

    /**
     * Retourne la page de tous les articles
     * @return Response
     */
    public function tousLesArticles() {

        return new Response("Hello world !");
    }

    /**
     * @Route("/a-propos", methods={"GET"})
     */
    public function about() {
        return new Response("Ceci est la page 'à propos' du site.");
    }

}