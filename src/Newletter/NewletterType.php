<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 07/12/2018
 * Time: 12:08
 */

namespace App\Newletter;


use App\Entity\Newsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'label' => false,
                'attr'=> [
                    'placeholder'=> 'saisissez votre email'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Je m\'inscris !'

            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class',Newsletter::class);
    }


}