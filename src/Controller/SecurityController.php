<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SecurityController extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/register", name="app_register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        $user = new User();
        $email = $request->get('email');
        $role = $request->get('role');
        $password = $request->get('password');
        $name = $request->get('name');
        $city = $request->get('city');
        $address = $request->get('address');
        $postalCode = $request->get('postal-code');

        $user->setEmail($email);
        $user->setRoles([$role]);
        $user->setPassword($passwordEncoder->encodePassword(
            $user, $password
        ));
        $user->setName($name);
        $user->setCity($city);
        $user->setAddress($address);
        $user->setPostalCode($postalCode);
    }

    /**
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function login() {
        $serializer = new Serializer([new ObjectNormalizer()]);

        $data = null;
        if($this->getUser()) {
            $data = $serializer->normalize($this->getUser(), null, [AbstractNormalizer::ATTRIBUTES => ['id', 'email', 'name']]);
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout() {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
