<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 06/12/2018
 * Time: 09:57
 */

namespace App\Membre;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreLoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[
                'label'=> false,
                'attr' => ['placeholder' =>"Email"]
            ])

            ->add('password', PasswordType::class,[
                'label'=>false,
                'attr' =>['placeholder' =>"Mot de passe"]
            ])
            ->add('submit',SubmitType::class,[
                'label'=> 'connexion'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver ->setDefaults([
            'data_class'=>null
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_login';
    }

}