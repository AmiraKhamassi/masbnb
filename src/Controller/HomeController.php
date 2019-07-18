<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController{
    /**
     * @Route("/", name="homepage")
     * 
     * @return void
     */
    public function home(){
        return $this->render('home.html.twig', [
            'age' => 12,
            'tableau' => [
                "Jean" => 13,
                "Pauline" => 15
            ]
        ]);  
    }

    /**
     * @Route("/hello/{prenom}", name="hello")
     *
     * @return void
     */
    public function hello($prenom = "Mamadou"){
        return new Response('Bonjour '. $prenom);
    }
}
?>