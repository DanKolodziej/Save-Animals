<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EntityNormalizer;
use App\Service\UserInserter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController {

    /**
     * @Route("/register", name="app_register", methods={"POST"})
     */
    public function register(
        Request $request,
        UserInserter $userInserter,
        UserPasswordEncoderInterface $passwordEncoder,
        ValidatorInterface $validator,
        MailerInterface $mailer): JsonResponse {

        $user = new User();
        $email = $request->get('email');
        $role = $request->get('role');
        $password = $request->get('password');
        $passwordRepeat = $request->get('password-repeat');
        $name = $request->get('name');
        $province = $request->get('province');
        $city = $request->get('city');
        $termsAccepted = $request->get('terms-accepted');
        $confirmationToken = bin2hex(random_bytes(16));
        $dateTime = new \DateTime();
        $dateTime->format('H:i:s \O\n Y-m-d');

        $userInserter->setProperties($user, [
            'email' => $email,
            'role' => $role,
            'password' => $password,
            'name' => $name,
            'province' => $province,
            'city' => $city,
            'termsAccepted' => $termsAccepted,
            'confirmationToken' => $confirmationToken,
            'createDate' => $dateTime
        ]);

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

        $userInserter->insert($user);

        $email = (new Email())
            ->from('pomoc.zwierzakom.kontakt@gmail.com')
            ->to($user->getEmail())
            ->subject('Rejestracja - pomoc zwierzakom')
            ->text('Link do weryfikacji konta: '
                . $this->generateUrl('verifyUser',
                    ['token' => $user->getConfirmationToken()],
                    UrlGeneratorInterface::ABSOLUTE_URL));
        $mailer->send($email);

        return new JsonResponse(['added user id' => $user->getId()]);
    }

    /**
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function login(EntityNormalizer $entityNormalizer): JsonResponse {
        $user = $this->getUser();
        if($user->getIsVerified()) {
            $user = $entityNormalizer->normalize($this->getUser(), ['id', 'email', 'name', 'roles']);
            return new JsonResponse($user);
        } else {
            $this->get('security.token_storage')->setToken(null);
            return new JsonResponse(['error' => 'Konto nie jest zweryfikowane'], 401);
        }
    }

    /**
     * @Route("/weryfikacja/{token}", name="verifyUser")
     */
    public function verifyUser($token):JsonResponse {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByConfirmationToken($token);

        if($user) {
            $user->setIsVerified(true);
            $user->setConfirmationToken(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return new JsonResponse(['Pomyślnie zweryfikowano użytkownika:' => $user->getId()]);
        }
        return new JsonResponse(['error' => 'no user with specified token'], 401);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout() {
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

        return $this->redirectToRoute('index');
    }
}
