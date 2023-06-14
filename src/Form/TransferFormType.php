<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Player;
use App\Entity\Transfer;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\TeamRepository;
use App\Repository\TransferRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TransferFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount',TextType::class,[
                'label' =>'amount',
            ])
            ->add('sellingTeam', EntityType::class, [
                'label' => 'Selling Team',
                'class' => Team::class,
                'choice_label' => 'name',
            ])
            ->add('buyingTeam', EntityType::class, [
                'label' => 'Buying Team',
                'class' => Team::class,
                'choice_label' => 'name',
            ])       
        ;
    }

   

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transfer::class,
        ]);
    }
}
