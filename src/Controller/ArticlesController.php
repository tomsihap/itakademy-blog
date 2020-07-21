<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles_index", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ArticleRepository $articleRepository) : Response
    {
        return $this->render('articles/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/articles/{id}", name="articles_show", methods={"GET"}, priority=0)
     * @param Article $article
     * @return Response
     */
    public function show(Article $article) : Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/articles/{id}/delete", name="articles_delete", methods={"DELETE"})
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function delete(Request $request, Article $article) : Response {

        $token = $request->request->get('token');

        if ($this->isCsrfTokenValid('delete_article', $token)) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($article);
            $manager->flush();
        }

        return $this->redirectToRoute("articles_index");
    }

    /**
     * @Route("/articles/create", name="articles_create", methods={"GET"}, priority=1)
     */
    public function create() : Response {

        return $this->render('articles/form.html.twig');
    }

    /**
     * @Route("/articles", name="articles_new", methods={"POST"})
     */
    public function new(Request $request) : Response {

        if ($this->isCsrfTokenValid("form_article", $request->request->get('token'))) {

            $article = new Article();
            $article->setTitle($request->request->get('title'));
            $article->setContent($request->request->get('content'));

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute("articles_show", [ "id" => $article->getId() ]);
        }

        return $this->redirectToRoute("articles_index");

    }

    /**
     * @Route("/articles/{id}/edit", name="articles_edit", methods={"GET"})
     * @param Article $article
     * @return Response
     */
    public function edit(Article $article) : Response {

        return $this->render('articles/form.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/articles/{id}", name="articles_update", methods={"PUT", "PATCH"})
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function update(Request $request, Article $article) : Response {

        if ($this->isCsrfTokenValid("form_article", $request->request->get('token'))) {

            $article->setTitle($request->request->get('title'));
            $article->setContent($request->request->get('content'));

            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            return $this->redirectToRoute("articles_show", [ "id" => $article->getId() ]);
        }

        return $this->redirectToRoute("articles_index");

    }
}
