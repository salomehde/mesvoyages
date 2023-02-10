<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VisiteRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Visite;

/**
 * Description of AdminVoyagesController
 *
 * @author houde
 */
class AdminVoyagesController extends AbstractController {
    
    /**
    * 
    * @var VisiteRepository
    */
    private $repository;

    /**
    * @param VisiteRepository $repository
    */
    public function __construct(VisiteRepository $repository){
        $this->repository = $repository;
    }
    
    /**
     * @Route("/admin", name="admin.voyages")
     * @return Response
     */
    public function index(): Response{
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render("admin/admin.voyages.html.twig", [ 'visites' => $visites ]);
    }
    
    /**
     * @Route("/admin/suppr/{id}", name="admin.voyage.suppr")
     * @param Visite $visite
     * @return Response
     */
    public function suppr(Visite $visite): Response{
        $this->repository->remove($visite, true);   //appel de la méthode remove sur l'objet repository avec en paramètre l'objet à supprimer ($visite)
        return $this->redirectToRoute('admin.voyages');  //redirige vers une route (ici, la même page)
    }
    
}
