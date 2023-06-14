<?php

namespace App\Controller;

use App\Entity\Transfer;
use App\Form\TransferFormType;
use App\Repository\PlayerRepository;
use App\Repository\TransferRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/player', name: 'player_')]
class PlayerController extends AbstractController
{

    public function __construct(private PlayerRepository $playerRepository,private TransferRepository $transferRepository)
    {
    }


    #[Route('/{id}', name: 'details')]
    public function index(Request $request ,int $id ,PaginatorInterface $paginator): Response
    {
        $player = $this->playerRepository->find($id);
        $transfers = $this->transferRepository->findBy(['player' =>$id]);
        
        if (!$player) {
            throw $this->createNotFoundException('player not found.');
        }

        $pagination = $paginator->paginate(
            $transfers,
            $request->query->getInt('page', 1),
            3,
        );
        return $this->render('player/index.html.twig', [
            'player' => $player,
            'pagination'=>$pagination
        ]);
    }
}
