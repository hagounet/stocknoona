<?php

namespace Noona\StockBundle\Form;

use Noona\StockBundle\Entity\ReassortProduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Date;

class EditVenteType extends AbstractType
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
            ->add('coutsDivers','text')
            ->add('venteProduits','collection',array(
                'type'=>new VenteProduitType(),
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
