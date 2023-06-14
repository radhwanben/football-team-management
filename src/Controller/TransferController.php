<?php

namespace App\Controller;

use App\Entity\Transfer;
use App\Form\TransferFormType;
use App\Repository\TeamRepository;
use App\Repository\TransferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransferController extends AbstractController
{
    public function __construct(private TransferRepository $transferRepository,private TeamRepository $teamRepository)
    {
    }




    #[Route('/transfer/{id}', name: 'app_transfer')]
    public function transferFormSubmit(Request $request, EntityManagerInterface $entityManager ,$id)
    {
        $player = $this->transferRepository->findOneBy(['player' =>$id]);

        $form =$this->createForm(TransferFormType::class);
        
       
        if (!$player) {
            throw $this->createNotFoundException('player not found.');
        }
       
        //dd($player->getPlayer()->getTeam()->removePlayer($player->getPlayer()));
        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data=$form->getData();
            $transfer = new Transfer();
            $transfer->setAmount($data->getAmount());

            $data->getBuyingTeam()->setBalance($data->getBuyingTeam()->getBalance() - $data->getAmount());
            $data->getSellingTeam()->setBalance($data->getSellingTeam()->getBalance() + $data->getAmount());
            $player->getPlayer()->addTransfer($data);
            $transfer->setSellingTeam($player->getPlayer()->getTeam());
            $transfer->setBuyingTeam($data->getBuyingTeam());
            $transfer->setPlayer($data->getPlayer()->addTransfer($data));
           
            // Persist the transfer entity to the database
            $entityManager->persist($transfer);
            $entityManager->flush();

            $this->addFlash('success', 'Transfer successful!');
    
            return $this->redirectToRoute('player_details', ['id' => $id]);
            
        }

        return $this->render('transfer/index.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }
}