<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;


class ProductController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}


    /**
     * @Route("/products", name="app_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductRepository $productRepository): Response
    {
    
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->doctrine;
            $manager  = $doctrine->getManager();
            
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('info', "le produit a été ajouteé avec succès");
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER); 
        }

        
        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="app_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->doctrine;
            $manager  = $doctrine->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('info', "le produit a été modifier avec succès");
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER); 
        }


        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    


    

     /**
     * @Route("/archive-product/{id}", name="supprimer_produit")
     */
    public function deleteProduct(Product $product){
        
        $doctrine = $this->doctrine;
        $manager  = $doctrine->getManager();
        $manager -> remove($product);
        $manager->flush();
        $this->addFlash("success", "la suppression se faite avec succées");
        return $this->redirectToRoute('app_product_index');
    }
}
