<?php


namespace App\Controller\Api\Article;


use App\Entity\Article;
use Symfony\Component\Security\Core\Security;

class ArticleCreateController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(Article $data)
    {
        $user = $this->security->getUser();
        $data->setAuthor($user);
        return $data;
    }
}