<?php

namespace App\Controller;

use App\Dto\GetMovieInstancesDto;
use App\Repository\MovieInstanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class GetMovieInstancesController extends AbstractController
{
    public function __invoke(Request $request, MovieInstanceRepository $movieInstanceRepository, SerializerInterface $serializer): JsonResponse
    {
        $movieId = $request->query->get('movie_id');
        $available = $request->query->get('available');

        if ($movieId === null) {
            return $this->json(['error' => 'movieId is required'], 400);
        }

        if ($movieId < 1) {
            return $this->json(['error' => 'movieId must be greater than 0'], 400);
        }

        if ($available !== null && $available !== 'true' && $available !== 'false') {
            return $this->json(['error' => 'available must be true or false'], 400);
        }

        if ($available === 'true') {
            $movieInstances = $movieInstanceRepository->findBy(['movie' => $movieId, 'buyer' => null]);
        } else {
            $movieInstances = $movieInstanceRepository->findBy(['movie' => $movieId]);
        }

        return $this->json($movieInstances);
    }
}