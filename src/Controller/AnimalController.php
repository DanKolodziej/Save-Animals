<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Species;
use App\Entity\User;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnimalController extends AbstractController {

    /**
     * @Route("/add-animal", name="addAnimal", methods={"POST"})
     */
    public function addAnimal(Request $request, ValidatorInterface $validator, ImageUploader $imageUploader): JsonResponse {

        $animal = new Animal();
        $name = $request->get('name');
        $speciesName = $request->get('species');
        $species = $this->getDoctrine()
            ->getRepository(Species::class)
            ->findOneByNameSingular($speciesName);
        $description = $request->get('description');
        $category = $request->get('category');
        $user = $this->getUser();
        $animal->setName($name);
        $animal->setSpecies($species);
        $animal->setDescription($description);
        $animal->setCategory($category);
        $animal->setOwner($user);

        $errors = $validator->validate($animal);

        if(count($errors) > 0) {

            $messages = [];
            foreach($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse($messages, 400);
        }

        $image = $request->files->get('image');
        if($image) {
            $newImageFileName = $imageUploader->upload($image);
            $animal->setImageFileName($newImageFileName);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($animal);
        $entityManager->flush();

        return new JsonResponse(['added animal id' => $animal->getId()]);
    }

    /**
     * @Route("/animals-by-user-category", name="animalsByUserCategory", methods={"GET"})
     */
    public function getAnimalsByUserCategory(Request $request): JsonResponse {

        $userId = $request->get('user-id');
        $category = $request->get('category');
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($userId);
        $animals = $this->getDoctrine()
            ->getRepository(Animal::class)
            ->findBy(['owner' => $user, 'category' => $category]);

        $serializer = new Serializer([new ObjectNormalizer()]);

        $data = $serializer->normalize($animals, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'imageFileName']]);

        return new JsonResponse(['animals' => $data]);
    }

    /**
     * @Route("/animals-by-category-species-name-description",
     *     name="animalsByCategorySpeciesNameDescription", methods={"GET"})
     */
    public function getAnimalsByCategorySpeciesNameDescription(Request $request): JsonResponse {

        $category = $request->get('category');
        $species = $request->get('species');
        $name = $request->get('name');
        $description = $request->get('description');
        $animals = $this->getDoctrine()
            ->getRepository(Animal::class)
            ->findByCategorySpeciesNameDescription($category, $species, $name, $description);

        $serializer = new Serializer([new ObjectNormalizer()]);

        $data = $serializer->normalize($animals, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'imageFileName']]);

        return new JsonResponse(['animals' => $data]);
    }

    /**
     * @Route("/animal/{id}", name="animal", methods={"GET"})
     */
    public function getAnimal(int $id): JsonResponse {

        $animal = $this->getDoctrine()
            ->getRepository(Animal::class)
            ->find($id);

        $serializer = new Serializer([new ObjectNormalizer()]);

        $data = $serializer->normalize($animal, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'imageFileName', 'owner']]);

        return new JsonResponse(['animal' => $data]);
    }

    /**
     * @Route("/owner/{id}", name="owner", methods={"GET"})
     */
    public function getAnimalOwner(int $id): JsonResponse {

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $serializer = new Serializer([new ObjectNormalizer()]);

        $data = $serializer->normalize($user, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'name']]);

        return new JsonResponse(['owner' => $data]);
    }
}
