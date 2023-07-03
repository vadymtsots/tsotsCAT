<?php

namespace App\Forms\Projects;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\Languages;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'document',
                FileType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'sourceLanguage',
                ChoiceType::class,
                [
                    'choices' => array_flip(Languages::getNames()),
                    'required' => true,
                    'label' => 'Source Language',
                ]
            )
            ->add(
                'targetLanguage',
                ChoiceType::class,
                [
                    'choices' => array_flip(Languages::getNames()),
                    'required' => true,
                    'label' => 'Target Language',
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Save Project',
                ]
            );
    }

}
