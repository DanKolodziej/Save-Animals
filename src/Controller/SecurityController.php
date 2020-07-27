<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EntityNormalizer;
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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController {

    /**
     * @Route("/register", name="app_register", methods={"POST"})
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             ValidatorInterface $validator): JsonResponse {

        $user = new User();
        $email = $request->get('email');
        $role = $request->get('role');
        $password = $request->get('password');
        $passwordRepeat = $request->get('password-repeat');
        $name = $request->get('name');
        $province = $request->get('province');
        $city = $request->get('city');

        $user->setEmail($email);
        $user->setRoles([$role]);
        if($password !== '') {
            $user->setPassword($passwordEncoder->encodePassword(
                $user, $password
            ));
        }
        $user->setName($name);
        $user->setProvince($province);
        $user->setCity($city);

        $errors = $validator->validate($user);

        $messages = [];
        if($password !== $passwordRepeat && $password !== '') {
            $messages['repeatPassword'] = ['Hasła nie pasują'];
        }
        if(count($errors) > 0 || count($messages) > 0) {

            foreach($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse($messages, 400);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['added user id' => $user->getId()]);
    }

    /**
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function login(EntityNormalizer $entityNormalizer): JsonResponse {
        $user = $entityNormalizer->normalize($this->getUser(), ['id', 'email', 'name']);

        return new JsonResponse($user);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout() {
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

        return $this->redirectToRoute('index');
    }
}
