<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class WelcomeController extends AbstractController
{
    /**
     * @Route("welcome/{home}", name="welcome")
     */
    public function index(Request $request, string $home=null): Response
    {
        $getName = $request->query->get('name'); // récupère la valeur de la variable name en mode GET
            return $this->render('welcome/index.html.twig', [
            'title' => 'Bienvenu ici', 
            'description' => 'Vous êtes chez vous', 
            'home' => $home,
            'varGet' => $getName,
        ]); // méthode de la class AbsractController
    }
}