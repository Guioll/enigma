<?php

namespace App\Form;

use App\Entity\Rotor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MsgType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Message', TextType::class)
            ->add('rotor1', EntityType::class,
                [
                    'class' => Rotor::class,
                    'choice_label' => 'id',
                ])
            ->add('rotor2', EntityType::class,
                [
                    'class' => Rotor::class,
                    'choice_label' => 'id',
                ])
            ->add('rotor3', EntityType::class,
                [
                    'class' => Rotor::class,
                    'choice_label' => 'id',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
