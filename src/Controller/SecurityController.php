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
        ValidatorInterface $validator): JsonResponse {

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

//        $email = (new Email())
//            ->from('pomoc.zwierzakom.kontakt@gmail.com')
//            ->to($user->getEmail())
//            ->subject('Rejestracja - pomoc zwierzakom')
//            ->text('Link do weryfikacji konta: '
//                . $this->generateUrl('verification',
//                    ['token' => $user->getConfirmationToken()],
//                    UrlGeneratorInterface::ABSOLUTE_URL));
//        $mailer->send($email);

        return new JsonResponse(['added user id' => $user->getId()]);
    }

    /**
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function login(EntityNormalizer $entityNormalizer): JsonResponse {
        $user = $this->getUser();
//        if($user->getIsVerified()) {
            $user = $entityNormalizer->normalize($this->getUser(), ['id', 'email', 'name', 'roles']);
            return new JsonResponse($user);
//        } else {
//            $this->get('security.token_storage')->setToken(null);
//            return new JsonResponse(['error' => 'Konto nie jest zweryfikowane'], 400);
//        }
    }

    /**
     * @Route("/verify-user/{token}", name="verifyUser")
     */
    public function verifyUser(string $token):JsonResponse {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByConfirmationToken($token);

        if($user) {
            $user->setIsVerified(true);
            $user->setConfirmationToken(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return new JsonResponse(['verified' => true]);
        }

        return new JsonResponse(['verified' => false], 400);
    }

    /**
     * @Route("/password-reset", name="passwordReset", methods={"POST"})
     */
    public function passwordReset(Request $request) {

        $email = $request->get('email');
        $resetPasswordToken = bin2hex(random_bytes(16));
        $dateTime = new \DateTime();
        $dateTime->format('H:i:s \O\n Y-m-d');
        $dateTime->modify('+ 1 hour');

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByEmail($email);
        if($user) {
            $user->setResetPasswordToken($resetPasswordToken);
            $user->setResetExpireDate($dateTime);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

//            $email = (new Email())
//                ->from('pomoc.zwierzakom.kontakt@gmail.com')
//                ->to($email)
//                ->subject('Rejestracja - pomoc zwierzakom')
//                ->text('Link do ustawienia nowego hasła (ważny tylko przez 1 godz.): '
//                    . $this->generateUrl('passwordResetForm',
//                        ['token' => $resetPasswordToken],
//                        UrlGeneratorInterface::ABSOLUTE_URL));
//            $mailer->send($email);

            return new JsonResponse(['sentLink' => true]);
        }

        return new JsonResponse(['sentLink' => false], 400);
    }

    /**
     * @Route("/password-change", name="passwordChange", methods={"POST"})
     */
    public function passwordChange(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        ValidatorInterface $validator):JsonResponse {

        $token = $request->get('token');
        $password = $request->get('password');
        $passwordRepeat = $request->get('password-repeat');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByResetPasswordToken($token);


        $dateTime = new \DateTime();
        $dateTime->format('H:i:s \O\n Y-m-d');

        if($user && $dateTime < $user->getResetExpireDate()) {
            $user->setResetPasswordToken(null);
            $user->setResetExpireDate(null);
            $user->setPassword('');
            if($password !== '') {
                $user->setPassword($passwordEncoder->encodePassword($user, $password));
            }
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
            $entityManager->flush();

            return new JsonResponse(['changed password' => true]);
        }

        $messages['password'] = ['Nie aktualny link'];

        return new JsonResponse($messages, 400);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout() {
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

        return $this->redirectToRoute('index');
    }
}
