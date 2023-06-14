<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/teams', name: 'team_')]
class TeamController extends AbstractController
{
    public function __construct(private TeamRepository $teamRepository)
    {
    }

    #[Route('/', name: 'list', methods: ['GET'])]
    public function listTeams(Request $request, PaginatorInterface $paginator): Response
    {
        $teams = $this->teamRepository->findAll();

        $pagination = $paginator->paginate(
            $teams,
            $request->query->getInt('page', 1),
            5 ,
        );
        

        return $this->render('team/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/{id}', name: 'details', methods: ['GET'])]
    public function getTeamDetails(int $id): Response
    {
        $team = $this->teamRepository->find($id);

        if (!$team) {
            throw $this->createNotFoundException('Team not found.');
        }

        return $this->render('team/details.html.twig', [
            'team' => $team,
        ]);
    }
}
