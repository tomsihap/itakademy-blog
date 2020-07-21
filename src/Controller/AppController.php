<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
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

        $username = ucfirst($request->request->get('username'));
        $content = $request->request->get('content');

        return $this->render('app/confirmMessage.html.twig', [
            'username' => $username,
            'content'  => $content,
        ]);
    }

    /**
     * @Route("/testarticles", name="app_testarticles")
     */
    public function testArticle() : Response {

        $manager = $this->getDoctrine()->getManager();

        $article = new Article();
        $article->setTitle("Nouvel article 2");
        $article->setContent("foo bar baz");

        $manager->persist($article);
        $manager->flush();

        dump($article);

        $article->setTitle('Titre mis à jour');
        $manager->flush();

        dump($article);

        $manager->remove($article);
        $manager->flush();

        dd($article);

    }

    /**
     * @Route("/readarticles", name="app_readarticles")
     */
    public function readArticlesSansAutowiring() {

        $articleRepository = $this->getDoctrine()->getRepository(Article::class);

        $articles = $articleRepository->findAll();
        dd($articles);
    }

    /**
     * @Route("/readarticles2", name="app_readarticles")
     * @param ArticleRepository $articleRepository
     */
    public function readArticlesAvecAutowiring(ArticleRepository $articleRepository) {

        $articles = $articleRepository->findAll();
        dd($articles);
    }

    /**
     * @Route("/readOneArticle/{articleId}", name="app_read_one_article")
     * @param ArticleRepository $articleRepository
     * @param int $articleId
     */
    public function readOneArticle(ArticleRepository $articleRepository, int $articleId) {

        dd($articleRepository->find($articleId) );
    }
}