<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends AbstractType
{
    private function getConfiguration($label, $placeholder, $options = []){
        return(array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
            ], $options));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Titre', "Tapez un super titre pour votre annonce"))
            ->add('slug', TextType::class, $this->getConfiguration('Chaine URL', "Adresse web (Automatique)", ['required' => false]))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix par nuit", "Indiquez le prix que vous voulez pour une nuit"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Donnez une description globale de l'annonce"))
            ->add('content', TextareaType::class, $this->getConfiguration("Description", "Tapez une description qui donne..."))
            ->add('coverImage', UrlType::class, $this->getConfiguration("Url de l'image", "Donnez l'adresse de votre image"))
            ->add('rooms', IntegerType::class, $this->getConfiguration('Chambre', "Donnez le numéro de la chambre"))
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            )
            ->add('save', SubmitType::class,[
                'label' => "Créer une nouvelle annonce",
                'attr' => [
                    'class' => "btn btn-primary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
