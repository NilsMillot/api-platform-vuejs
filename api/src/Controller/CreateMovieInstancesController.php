<?php
namespace App\Controller;

use App\Dto\CreateMovieInstancesDto;
use App\Entity\Movie;
use App\Entity\MovieInstance;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsController]
class CreateMovieInstancesController extends AbstractController
{

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, MovieRepository $movieRepository, HttpClientInterface $httpClient)
    {
        $this->em = $em;
        $this->movieRepository = $movieRepository;
        $this->serializer = $serializer;
        $this->httpClient = $httpClient;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), CreateMovieInstancesDto::class, 'json');

        $tmdbMovieId = $dto->getTmdbMovieId();
        $quantityToCreate = $dto->getQuantity();

        $movieFromTmdb = $this->getMovieFromTmdb($tmdbMovieId);
        $movieFromDb = $this->movieRepository->findOneBy(['title' => $movieFromTmdb->getTitle()]);

        $movie = $movieFromDb ?? $movieFromTmdb;
        $movie->setQuantity($movie->getQuantity() + $quantityToCreate);

        for ($i = 0; $i < $quantityToCreate; $i++) {
            $movieInstance = new MovieInstance();
            $movieInstance->setMovie($movie);
            $this->em->persist($movieInstance);
        }

        $this->em->flush();

        return $this->json(['success' => 'Movie instances created'], 201);
    }

    private function getMovieFromTmdb(int $tmdbMovieId): ?Movie
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.themoviedb.org/3/movie/' . $tmdbMovieId . '?api_key=0e220568bac27a347c49f800f789f519'
        );

        $movieJson = $response->getContent();
        $movie = $this->serializer->deserialize($movieJson, Movie::class, 'json');
        return $movie;
    }
}
