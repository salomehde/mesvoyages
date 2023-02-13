<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


/**
 * Description of VoyagesControllerTest
 *
 * @author houde
 */
class VoyagesControllerTest extends WebTestCase{
    
    public function testAccesPage(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK); //ou $this->assertResponseIsSuccessful(); ou autre
    }
    
    public function testContenuPage(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/voyages');
        $this->assertSelectorTextContains('h1', 'Mes voyages');
        $this->assertSelectorTextContains('th', 'Ville');
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Liège');
    }
    
    public function testLinkVille(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        //clic sur un lien (le nom d'une ville
        $client->clickLink('Poitiers');
        //récupération du résultat du clic
        $response = $client->getResponse();
        //dd($client->getRequest());
        //contrôle si le lien existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        //récupération de la route et contrôle qu'elle est correcte
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/voyages/voyage/103', $uri);
    }
    
    public function testFiltreVille(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        // simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Poitiers'
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        // vérifie si la ville correspond à la recherche
        $this->assertSelectorTextContains('h5', 'Poitiers');
    }
    
}
