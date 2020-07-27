<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Species;
use App\Entity\User;
use App\Service\EntityNormalizer;
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
        $contact = $request->get('contact');
        $user = $this->getUser();
        $animal->setName($name);
        $animal->setSpecies($species);
        $animal->setDescription($description);
        $animal->setCategory($category);
        $animal->setOwner($user);
        $animal->setContact($contact);

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
    public function getAnimalsByCategorySpeciesNameDescription(Request $request, EntityNormalizer $entityNormalizer): JsonResponse {

        $category = $request->get('category');
        $species = $request->get('species');
        $name = $request->get('name');
        $description = $request->get('description');
        $province = $request->get('province');
        $city = $request->get('city');
        $animals = $this->getDoctrine()
            ->getRepository(Animal::class)
            ->filter($category, $species, $name, $description, $province, $city);

        $animalsNormalized = $entityNormalizer->normalize($animals, ['id', 'name', 'description', 'imageFileName']);

        return new JsonResponse(['animals' => $animalsNormalized]);
    }

    /**
     * @Route("/three-random-animals", name="threeRandomAnimals", methods={"GET"})
     */
    public function getThreeRandomAnimals(): JsonResponse {

        $animals = $this->getDoctrine()
            ->getRepository(Animal::class)
            ->findThreeRandomAnimals();

        return new JsonResponse(['animals' => $animals]);
    }

    /**
     * @Route("/animal/{id}", name="animal", methods={"GET"})
     */
    public function getAnimal(int $id, EntityNormalizer $entityNormalizer): JsonResponse {

        $animal = $this->getDoctrine()
            ->getRepository(Animal::class)
            ->find($id);

        $animalNormalized = $entityNormalizer->normalize($animal, ['id', 'name', 'description', 'imageFileName', 'owner', 'contact']);

        return new JsonResponse(['animal' => $animalNormalized]);
    }

    /**
     * @Route("/owner/{id}", name="owner", methods={"GET"})
     */
    public function getAnimalOwner(int $id, EntityNormalizer $entityNormalizer): JsonResponse {

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $userNormalized = $entityNormalizer->normalize($user, ['id', 'name']);

        return new JsonResponse(['owner' => $userNormalized]);
    }

    /**
     * @Route("/delete-animal/{id}", name="deleteAnimal", methods={"DELETE"})
     */
    public function deleteAnimal(int $id): JsonResponse {

        $animal = $this->getDoctrine()
            ->getRepository(Animal::class)
            ->find($id);

        $category = $animal->getCategory();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($animal);
        $entityManager->flush();

        return new JsonResponse(['deleted animal' => $id, 'category' => $category]);
    }
}
