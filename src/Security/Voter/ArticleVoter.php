<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['ARTICLE_CREATE', 'ARTICLE_EDIT', 'ARTICLE_READ', 'ARTICLE_DELETE'])
            && $subject instanceof Article;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'ARTICLE_READ':
            case 'ARTICLE_CREATE':
                if( $this->security->isGranted("ROLE_ADMIN") ||
                    $this->security->isGranted("ROLE_USER")
                ) {
                    return true;
                }
                break;
            case 'ARTICLE_DELETE':
                if( $this->security->isGranted("ROLE_ADMIN") ||
                    $this->security->isGranted("ROLE_USER") &&
                    $user === $subject->getAuthor()
                ) {
                    return true;
                }
                break;
            case 'ARTICLE_EDIT':
                if( $this->security->isGranted("ROLE_USER") &&
                    $user === $subject->getAuthor()
                ) {
                    return true;
                }
                break;
        }

        return false;
    }
}
