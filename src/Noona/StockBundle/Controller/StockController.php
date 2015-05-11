<?php

namespace Noona\StockBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Noona\StockBundle\Entity\Image;
use Noona\StockBundle\Entity\Produit;
use Noona\StockBundle\Entity\Reassort;
use Noona\StockBundle\Entity\ReassortProduit;
use Noona\StockBundle\Entity\Vente;
use Noona\StockBundle\Form\EditProduitType;
use Noona\StockBundle\Form\EditReassortType;
use Noona\StockBundle\Form\EditVenteType;
use Noona\StockBundle\Form\ModifierReassortType;
use Noona\StockBundle\Form\ProduitExcelType;
use Noona\StockBundle\Form\ProduitType;
use Noona\StockBundle\Form\ReassortProduitType;
use Noona\StockBundle\Form\ReassortType;
use Noona\StockBundle\Form\VenteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class StockController extends Controller
{
    public function indexAction($page)
    {

        $nbrParPage = 8;
        $em = $this->getDoctrine()->getManager();
        $produitRepository = $em->getRepository("NoonaStockBundle:Produit");
        $liste_produits = $produitRepository->getProduits($page,$nbrParPage);
        $benefice = $produitRepository->getRevenuGlobal()-$produitRepository->getCoutGlobal();

        $liste_autocomplete = '';
        $allProducts = $produitRepository->getReferenceProduits();
        foreach($allProducts  as $produit){
            $liste_autocomplete .= $produit['reference'];
            if (!($produit === end($allProducts ))){
                $liste_autocomplete .= '|';
            }
        }

        return $this->render('NoonaStockBundle:Stock:index.html.twig',array("liste_produits"=>$liste_produits,
                                                                            'benefice'=>$benefice,
                                                                            'nbrPages'=>ceil(count($liste_produits)/$nbrParPage),
                                                                            'liste_autocomplete'=>$liste_autocomplete));
    }

    public function ajouterProduitsAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('produits','collection',array('type'=>new ProduitType(),
                'allow_add'=>true,
                'allow_delete'=>true
            ))
            ->getForm();

        if($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                foreach($form->getData()['produits'] as $produit)
                {
                    $em->persist($produit);
                }

                $em->flush();

                return $this->redirect($this->generateUrl("noonastock_homepage"));
            }
        }


        return $this->render("NoonaStockBundle:Stock:ajouterProduits.html.twig",array('form'=>$form->createView()));
    }

    public function modifierProduitAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produitRepository = $em->getRepository("NoonaStockBundle:Produit");
        $produit = $produitRepository->find($id);

        if(!$produit)throw $this->createNotFoundException('Le produit n\'existe pas');

        $form = $this->createForm(new EditProduitType(), $produit);

        if($request->isMethod('POST'))
        {
            if ($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($produit);
                $em->flush();

                return $this->redirect($this->generateUrl("noonastock_homepage"));
            }
        }


        return $this->render("NoonaStockBundle:Stock:modifierProduit.html.twig",array('form'=>$form->createView()));

    }

    public function effacerProduitAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $produitReassortRepository = $em->getRepository("NoonaStockBundle:ReassortProduit");
        $produitRepository = $em->getRepository("NoonaStockBundle:Produit");

        $produit = $produitRepository->find($id);


        if(!$produit)throw $this->createNotFoundException('Le produit n\'existe pas');

        $produit->setIsActif(0);

        $em->persist($produit);
        $em->flush();

        $session = $this->get("session"); //$request->getSession();

        $session->getFlashBag()->add('produitDelete', 'Votre produit a été effacé');
        $session->set('produitDelete', 'Votre produit a été effacé');
        return $this->redirect($this->generateUrl('noonastock_homepage'));

    }

    public function ajouterReassortAction(Request $request)
    {
        $form = $this->createForm(new ReassortType());

        if($request->isMethod('POST')) {


            if ($form->handleRequest($request)->isValid()) {


                $em = $this->getDoctrine()->getManager();
                $reassort = new Reassort();
                $reassort->setDateReassort($form->getData()->getdateReassort())
                        ->setCoutsDivers($form->getData()->getcoutsDivers());


                $em->persist($reassort);
                $em->flush();

                $totalPrice = $reassort->getCoutsDivers();
                foreach(($form->getData()->getReassortProduits()) as $reassortProduit)
                {
                    $quantite_originale = $reassortProduit->getProduit()->getStock();
                    $quantite_nouvelle = $quantite_originale + $reassortProduit->getQuantite();
                    $reassortProduit->getProduit()->setStock($quantite_nouvelle);

                    $reassortProduit->setReassort($reassort);
                    $totalPrice += $reassortProduit->getCoutTotal();
                    $em->persist($reassortProduit);
                }
                $reassort->setTotalPrice($totalPrice);
                $em->persist($reassort);

                $em->flush();
                return $this->redirect($this->generateUrl("noonastock_voirReassorts"));
            }
        }

        return $this->render('NoonaStockBundle:Stock:ajouterReassort.html.twig',array('form'=>$form->createView()));
    }

    public function modifierReassortAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $reassortRepo = $em->getRepository('NoonaStockBundle:Reassort');
        $reassort = $reassortRepo->find($id);

        if(!$reassort)$this->createNotFoundException('Ce réassort n\'existe pas');

        $form = $this->createForm(new EditReassortType(),$reassort);

        if($request->isMethod('POST'))
        {

            if($form->handleRequest($request)->isValid())
            {
                $totalPrice = $reassort->getCoutsDivers();
                foreach($reassort->getReassortProduits() as $reassortProduit)
                {
                    $totalPrice += $reassortProduit->getCoutTotal();
                }
                $reassort->setTotalPrice($totalPrice);
                $em->persist($reassort);
                $em->flush();

                return $this->redirect($this->generateUrl('noonastock_voirReassorts'));
            }
        }

        return $this->render('NoonaStockBundle:Stock:modifierReassort.html.twig',
                             array('form'=>$form->createView()));
    }

    public function effacerReassortAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $reassortRepository = $em->getRepository('NoonaStockBundle:Reassort');

        $reassort = $reassortRepository->find($id);

        if(!$reassort)throw $this->createNotFoundException('Ce réassort n\'existe pas');

        foreach($reassort->getReassortProduits() as $reassortProduit)
        {
            $produit = $reassortProduit->getProduit();
            $stock = $produit->getStock();
            $nouveauStock = $stock - $reassortProduit->getQuantite();
            $produit->setStock($nouveauStock);
        }


        $em->remove($reassort);
        $em->flush();

        return $this->redirect($this->generateUrl('noonastock_voirReassorts'));
    }

    public function voirReassortAction($page)
    {
        $nbrParPage = 8;
        $em = $this->getDoctrine()->getManager();
        $liste_reassorts = $em->getRepository('NoonaStockBundle:Reassort')
                               ->findAllByDate($page,$nbrParPage);

        if(!count($liste_reassorts)>0){
            $this->createNotFoundException('Pas de réassort');
        }

        return $this->render("NoonaStockBundle:Stock:voirReassorts.html.twig",
                            array('liste_reassorts'=>$liste_reassorts,
                                   'nbrPages'=>ceil(count($liste_reassorts)/$nbrParPage)));
    }

    public function voirReassortInfoAction($id, Request $request)
    {
        if($request->isXmlHttpRequest()){
        $em = $this->getDoctrine()->getManager();
        $reassort = $em->getRepository('NoonaStockBundle:Reassort')
                        ->find($id);
        if(!$reassort)$this->createNotFoundException('pas de réassort');

        $reassortProduits = $em->getRepository('NoonaStockBundle:ReassortProduit')
                                ->getReassortProduitsWithReference($reassort);


        return $this->render('NoonaStockBundle:Stock:infoReassorts.html.twig',array('reassortProduits'=>$reassortProduits,'reassort_id'=>$id));

        }
        return $this->redirect($this->generateUrl('noonastock_homepage'));
    }

    public function voirProduitInfoAction($id, Request $request)
    {
        if($request->isXmlHttpRequest()){

            $em = $this->getDoctrine()->getManager();
            $produitRep = $em->getRepository('NoonaStockBundle:Produit');
            $produit = $produitRep->find($id);

            $achetes = $produitRep->getTotalIn($produit);
            $vendus = $produitRep->getTotalOut($produit);
            $benefices = ($produitRep->getRevenu($produit)-$produitRep->getCout($produit));

            echo json_encode(array('achetes'=>$achetes,
                                    'vendus'=>$vendus,
                                    'benefices'=>$benefices
                            ));die;
        }

        return $this->redirect($this->generateUrl('noonastock_homepage'));

    }


    public function voirVentesAction($page)
    {
        $nbrParPage = 8;
        $em = $this->getDoctrine()->getManager();
        $liste_ventes = $em->getRepository('NoonaStockBundle:Vente')
            ->findAllByDate($page,$nbrParPage);

        if(!count($liste_ventes)>0){
            $this->createNotFoundException('Pas de vente');
        }

        return $this->render("NoonaStockBundle:Stock:voirVentes.html.twig",
                            array('liste_ventes'=>$liste_ventes,
                                   'nbrPages'=>ceil(count($liste_ventes)/$nbrParPage)));
    }

    public function ajouterVenteAction(Request $request)
    {
        $form = $this->createForm(new VenteType());

        if($request->isMethod('POST')) {


            if ($form->handleRequest($request)->isValid()) {


                $em = $this->getDoctrine()->getManager();
                $vente = new Vente();
                $vente->setDateVente($form->getData()->getdateVente())
                    ->setCoutsDivers($form->getData()->getcoutsDivers());

                $em->persist($vente);
                $em->flush();

                $totalPrice = -($vente->getCoutsDivers());
                foreach(($form->getData()->getVenteProduits()) as $venteProduit)
                {
                    $stock_origine = $venteProduit->getProduit()->getStock();
                    $nouveau_stock = $stock_origine - $venteProduit->getQuantite();
                    $venteProduit->getProduit()->setStock($nouveau_stock);

                    $venteProduit->setVente($vente);
                    $totalPrice += $venteProduit->getCoutTotal();
                    $em->persist($venteProduit);
                }

                $vente->setTotalPrice($totalPrice);
                $em->persist($vente);
                $em->flush();
                return $this->redirect($this->generateUrl("noonastock_voirVentes"));
            }
        }

        return $this->render('NoonaStockBundle:Stock:ajouterVente.html.twig',array('form'=>$form->createView()));
    }


    public function effacerVenteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $venteRepository = $em->getRepository('NoonaStockBundle:Vente');

        $vente = $venteRepository->find($id);

        if(!$vente)throw $this->createNotFoundException('Cette vente n\'existe pas');

        foreach($vente->getVenteProduits() as $venteProduit)
        {
            $produit = $venteProduit->getProduit();
            $stock = $produit->getStock();
            $nouveauStock = $stock + $venteProduit->getQuantite();
            $produit->setStock($nouveauStock);
        }


        $em->remove($vente);
        $em->flush();

        return $this->redirect($this->generateUrl('noonastock_voirVentes'));
    }

    public function voirVenteInfoAction($id, Request $request)
    {

        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $vente = $em->getRepository('NoonaStockBundle:Vente')
                ->find($id);
            if(!$vente)$this->createNotFoundException('pas de vente');


            $venteProduits = $em->getRepository('NoonaStockBundle:VenteProduit')
                                ->getVenteProduitsWithReference($vente);


            return $this->render('NoonaStockBundle:Stock:infoVentes.html.twig',
                                array('venteProduits'=>$venteProduits,'vente_id'=>$id));

        }
        return $this->redirect($this->generateUrl('noonastock_homepage'));
    }

    public function modifierVenteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $venteRepo = $em->getRepository('NoonaStockBundle:Vente');
        $vente = $venteRepo->find($id);

        if(!$vente)$this->createNotFoundException('Ce réassort n\'existe pas');

        $form = $this->createForm(new EditVenteType(),$vente);

        if($request->isMethod('POST'))
        {

            if($form->handleRequest($request)->isValid())
            {
                $totalPrice = $vente->getCoutsDivers();
                foreach($vente->getVenteProduits() as $venteProduit)
                {
                    $totalPrice += $venteProduit->getCoutTotal();
                }
                $vente->setTotalPrice($totalPrice);
                $em->persist($vente);
                $em->flush();

                return $this->redirect($this->generateUrl('noonastock_voirVentes'));
            }
        }

        return $this->render('NoonaStockBundle:Stock:modifierVente.html.twig',
            array('form'=>$form->createView()));
    }

    public function produitXmlAction(Request $request)
    {
        $form = $this->createFormBuilder()
                     ->add('produitsExcel','collection',array(
                        'type'=>new ProduitExcelType(),
                        'allow_add'=> true,
                        'allow_delete'=>true,
                        'label'=>false
                     ))
                    ->getForm()
                    ;



        if($request->isMethod('POST')){

            if($form->handleRequest($request)->isValid()){

                $tableau = array();
                $i=0;
                foreach($form->getData()['produitsExcel'] as $key => $data){

                      $tableau[$i] = array(
                              'produit'=>$data->getProduit()->getReference(),
                              'quantite'=>$data->getQuantite(),
                              'vendus'=>'',
                              'revenu'=>'',
                              'revenu réel'=>''
                        );

                   $i++;
                  }

                $produitXml = $this->get('noona_app.excelparser');
                $produitXml->setData($tableau);
                //filename for download

                header('Content-Disposition: attachment; filename="' .  $produitXml->getFilename() . '"');
                header('Content-Type: application/vnd.ms-excel');

                echo $produitXml->arrayToExcel();
                die;

             }
        }


        return $this->render('NoonaStockBundle:Stock:exportExcel.html.twig',array('form'=>$form->createView()));

    }

    public function rechercheProduitAction(Request $request)
    {
        $chaine = $request->query->get('produit');

        if("" === $chaine){
            $flash = $this->get('session')->getFlashBag()->add('notice', 'Merci d\'entrer une valeur dans la recherche');
        }
        $em = $this->getDoctrine()->getManager();
        $produitRepository = $em->getRepository("NoonaStockBundle:Produit");
        $liste_produits = $produitRepository->searchProduit($chaine);

        $liste_autocomplete = '';
        $allProducts = $produitRepository->getReferenceProduits();
        foreach($allProducts  as $produit){
            $liste_autocomplete .= $produit['reference'];
            if (!($produit === end($allProducts ))){
                $liste_autocomplete .= '|';
            }
        }

        return $this->render('NoonaStockBundle:Stock:rechercheProduit.html.twig',array("liste_produits"=>$liste_produits,
                                                                              'liste_autocomplete'=>$liste_autocomplete ));
    }


}
