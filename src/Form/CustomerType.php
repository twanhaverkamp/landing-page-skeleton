<?php

namespace App\Form;

use App\Model\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Twan Haverkamp <twan@mailcampaigns.nl>
 */
class CustomerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'label' => 'customer.gender',
                'choices' => [
                    Customer::GENDER_MALE,
                    Customer::GENDER_FEMALE
                ],
                'choice_label' => function ($choices, $key, $value) {
                    return 'customer.gender.' . $value;
                },
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('firstName', TextType::class, [
                'label' => 'customer.first_name',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'customer.last_name',
            ])
            ->add('emailAddress', EmailType::class, [
                'label' => 'customer.email_address',
            ])
            ->add('dateOfBirth', BirthdayType::class, [
                'label' => 'customer.date_of_birth',
                'input' => 'string',
                'input_format' => Customer::DATE_OF_BIRTH_FORMAT,
                'format' => 'ddMMyyyy',
                'placeholder' => [
                    'year' => 'customer.date_of_birth.select_year',
                    'month' => 'customer.date_of_birth.select_month',
                    'day' => 'customer.date_of_birth.select_day',
                ],
                'years' => range(
                    date('Y') - Customer::MIN_AGE,
                    date('Y') - Customer::MAX_AGE,
                ),
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
