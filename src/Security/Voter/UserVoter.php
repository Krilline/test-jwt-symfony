<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class UserVoter extends Voter
{

    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['USER_CREATE', 'USER_READ', 'USER_EDIT', 'USER_DELETE'])
            && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        switch ($attribute) {
            case 'USER_CREATE':
                if( $this->security->isGranted("IS_AUTHENTICATED_ANONYMOUSLY") ||
                    $this->security->isGranted("IS_AUTHENTICATED_FULLY") &&
                    $this->security->isGranted("ROLE_ADMIN")
                ) {
                    return true;
                }
                break;
            case 'USER_READ':
                if( $this->security->isGranted("IS_AUTHENTICATED_FULLY") &&
                    $this->security->isGranted("ROLE_USER")
                ) {
                    return true;
                }
                break;
            case 'USER_DELETE':
            case 'USER_EDIT':
                if( $this->security->isGranted("IS_AUTHENTICATED_FULLY") &&
                    $this->security->isGranted("ROLE_USER") &&
                    $user === $subject
                ) {
                    return true;
                }
                break;
        }

        return false;
    }
}
