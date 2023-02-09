<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VisiteRepository;

/**
 * Description of VoyagesController
 *
 * @author grand
 */
class VoyagesController extends AbstractController {
    
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
     * @Route("/voyages", name="voyages")
     * @return Response
     */
    public function index(): Response{
        $visites = $this->repository->findAll();
        return $this->render("pages/voyages.html.twig", [ 'visites' => $visites ]);
    }


}