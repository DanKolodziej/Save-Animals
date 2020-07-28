<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Service\AnimalFetcher;
use App\Service\AnimalInserter;
use App\Service\EntityNormalizer;
use App\Service\ImageUploader;
use App\Service\SpeciesFetcher;
use App\Service\UserFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnimalController extends AbstractController {

    /**
     * @Route("/add-animal", name="addAnimal", methods={"POST"})
     */
    public function addAnimal(
        Request $request,
        AnimalInserter $animalInserter,
        SpeciesFetcher $speciesFetcher,
        ValidatorInterface $validator,
        ImageUploader $imageUploader): JsonResponse {

        $animal = new Animal();
        $name = $request->get('name');
        $speciesName = $request->get('species');
        $species = $speciesFetcher->getSpeciesByNameSingular($speciesName);
        $description = $request->get('description');
        $category = $request->get('category');
        $contact = $request->get('contact');
        $user = $this->getUser();
        $image = $request->files->get('image');

        $animalInserter->setProperties($animal, [
            'name' => $name,
            'species' => $species,
            'description' => $description,
            'category' => $category,
            'contact' => $contact,
            'user' => $user,
            'image' => $image
        ]);

        $errors = $validator->validate($animal);
        if(count($errors) > 0) {

            $messages = [];
            foreach($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse($messages, 400);
        }

        $animalInserter->insert($animal);

        return new JsonResponse(['added animal id' => $animal->getId()]);
    }

    /**
     * @Route("/animals-by-user-category", name="animalsByUserCategory", methods={"GET"})
     */
    public function getAnimalsByUserCategory(
        Request $request,
        AnimalFetcher $animalFetcher,
        UserFetcher $userFetcher,
        EntityNormalizer $entityNormalizer): JsonResponse {

        $userId = $request->get('user-id');
        $category = $request->get('category');

        $user = $userFetcher->getUser($userId);
        $animals = $animalFetcher->getAnimalsByUserAndCategory($user, $category);
        $animalsNormalized = $entityNormalizer->normalize($animals, ['id', 'name', 'description', 'imageFileName']);

        return new JsonResponse(['animals' => $animalsNormalized]);
    }

    /**
     * @Route("/animals-by-category-species-name-description",
     *     name="animalsByCategorySpeciesNameDescription", methods={"GET"})
     */
    public function getAnimalsByCategorySpeciesNameDescription(
        Request $request,
        AnimalFetcher $animalFetcher,
        EntityNormalizer $entityNormalizer): JsonResponse {

        $category = $request->get('category');
        $species = $request->get('species');
        $name = $request->get('name');
        $description = $request->get('description');
        $province = $request->get('province');
        $city = $request->get('city');

        $animals = $animalFetcher->filterAnimals($category, $species, $name, $description, $province, $city);
        $animalsNormalized = $entityNormalizer->normalize($animals, ['id', 'name', 'description', 'imageFileName']);

        return new JsonResponse(['animals' => $animalsNormalized]);
    }

    /**
     * @Route("/three-random-animals", name="threeRandomAnimals", methods={"GET"})
     */
    public function getThreeRandomAnimals(AnimalFetcher $animalFetcher): JsonResponse {

        $animals = $animalFetcher->getRandomAnimals(3);

        return new JsonResponse(['animals' => $animals]);
    }

    /**
     * @Route("/animal/{id}", name="animal", methods={"GET"})
     */
    public function getAnimal(
        int $id,
        AnimalFetcher $animalFetcher,
        EntityNormalizer $entityNormalizer): JsonResponse {

        $animal = $animalFetcher->getAnimal($id);
        $animalNormalized = $entityNormalizer->normalize($animal, ['id', 'name', 'description', 'imageFileName', 'owner', 'contact']);

        return new JsonResponse(['animal' => $animalNormalized]);
    }

    /**
     * @Route("/owner/{id}", name="owner", methods={"GET"})
     */
    public function getAnimalOwner(
        int $id,
        UserFetcher $userFetcher,
        EntityNormalizer $entityNormalizer): JsonResponse {

        $user = $userFetcher->getUser($id);
        $userNormalized = $entityNormalizer->normalize($user, ['id', 'name']);

        return new JsonResponse(['owner' => $userNormalized]);
    }

    /**
     * @Route("/delete-animal/{id}", name="deleteAnimal", methods={"DELETE"})
     */
    public function deleteAnimal(int $id, AnimalFetcher $animalFetcher): JsonResponse {

        $animal = $animalFetcher->getAnimal($id);
        $category = $animal->getCategory();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($animal);
        $entityManager->flush();

        return new JsonResponse(['deleted animal' => $id, 'category' => $category]);
    }
}
