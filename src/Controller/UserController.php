<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EntityNormalizer;
use App\Service\UserInserter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController {
    /**
     * @Route("/user", name="getUser")
     */
    public function user(EntityNormalizer $entityNormalizer): JsonResponse {
        $user = $this->getUser();
        $userNormalized = $entityNormalizer->normalize($user, ['id', 'email', 'name', 'roles', 'province', 'city']);
        return new JsonResponse($userNormalized);
    }

    /**
     * @Route("/update-user", name="updateUser")
     */
    public function updateUser(
        Request $request,
        UserInserter $userInserter,
        UserPasswordEncoderInterface $passwordEncoder,
        ValidatorInterface $validator
    ): JsonResponse {
        $user = $this->getUser();
        $email = $request->get('email');
        $role = $request->get('role');
        $password = $request->get('password');
        $passwordRepeat = $request->get('password-repeat');
        $name = $request->get('name');
        $province = $request->get('province');
        $city = $request->get('city');
        $termsAccepted = $request->get('terms-accepted');

        $userInserter->setProperties($user, [
            'email' => $email,
            'role' => $role,
            'password' => $password,
            'name' => $name,
            'province' => $province,
            'city' => $city,
            'termsAccepted' => $termsAccepted
        ]);

        $errors = $validator->validate($user);

        $messages = [];
        if($password === '') {
            $messages['password'] = ['Hasło jest wymagane'];
        }
        elseif($password !== $passwordRepeat && $password !== '') {
            $messages['repeatPassword'] = ['Hasła nie pasują'];
        }
        if(count($errors) > 0 || count($messages) > 0) {

            foreach($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse($messages, 400);
        }

        $userInserter->insert($user);

        return new JsonResponse(['edited user id' => $user->getId()]);
    }

    /**
     * @Route("/delete-user", name="deleteUser")
     */
    public function deleteUser() {
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        $this->get('security.token_storage')->setToken(null);
        return $this->redirectToRoute('app_logout');
    }
}
