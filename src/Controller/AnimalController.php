<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Species;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnimalController extends AbstractController {

    /**
     * @Route("/add-animal", name="addAnimal", methods={"POST"})
     */
    public function addAnimal(Request $request, ValidatorInterface $validator, SluggerInterface $slugger): JsonResponse {

        $animal = new Animal();
        $name = $request->get('name');
        $speciesName = $request->get('species');
        $species = $this->getDoctrine()
            ->getRepository(Species::class)
            ->findOneByName($speciesName);
        $description = $request->get('description');
        $category = $request->get('category');
        $user = $this->getUser();
        $animal->setName($name);
        $animal->setSpecies($species);
        $animal->setDescription($description);
        $animal->setCategory($category);
        $animal->setOwner($user);

        $errors = $validator->validate($animal);

        if (count($errors) > 0) {

            $messages = [];
            foreach ($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse($messages, 400);
        }

        $image = $request->files->get('image');
        if ($image) {
            $originalImageFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $safeImageFileName = $slugger->slug($originalImageFileName);
            $newImageFileName = $safeImageFileName.'-'.uniqid().'.'.$image->guessExtension();

            try {
                $image->move(
                    $this->getParameter('images_directory'),
                    $newImageFileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $animal->setImageFileName($newImageFileName);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($animal);
        $entityManager->flush();

        return new JsonResponse(['added animal id' => $animal->getId()]);
    }
}
