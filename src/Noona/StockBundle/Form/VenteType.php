<?php

namespace Noona\StockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Noona\StockBundle\Form\VenteProduitType;
use Symfony\Component\Validator\Constraints\Date;

class VenteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateVente', 'date' , array(
                'data' => new \Datetime(),
                'format' => 'dd-MM-yyyy'
            ))
            ->add('coutsDivers','text',array(
                'data'=>0
            ))
            ->add('venteProduits','collection',array(
                'type'=>new VenteProduitType(),
                'allow_add'=>true,
                'allow_delete'=>true,
                'label' => false
          ));

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Noona\StockBundle\Entity\Vente'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'noona_stockbundle_vente';
    }
}
