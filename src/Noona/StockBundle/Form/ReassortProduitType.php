<?php

namespace Noona\StockBundle\Form;

use Noona\StockBundle\Entity\ProduitRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReassortProduitType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit', 'entity',
                array('class'=>'NoonaStockBundle:Produit',
                    'property' =>  'reference',
                    'label' => false,
                    'query_builder' => function(ProduitRepository $er) {
                            return $er->createQueryBuilder('p')
                                ->where('p.isActif = 1');
                        }))
            ->add('quantite','text')
            ->add('coutTotal','text');

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Noona\StockBundle\Entity\ReassortProduit'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'noona_stockbundle_reassortProduit';
    }
}
