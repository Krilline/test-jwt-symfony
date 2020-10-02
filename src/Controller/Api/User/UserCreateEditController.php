<?php


namespace App\Controller\Api\User;


use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCreateEditController
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function __invoke(User $data)
    {
        if($data->getPlainPassword()){
            $data->setPassword(
                $this->encoder->encodePassword(
                    $data,
                    $data->getPlainPassword())
            );

            $data->eraseCredentials();
        }

        return $data;
    }
}