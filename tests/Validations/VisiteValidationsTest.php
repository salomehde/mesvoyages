<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Validations;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Visite;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Description of VisiteValidationsTest
 *
 * @author houde
 */
class VisiteValidationsTest extends KernelTestCase {
    
    public function getVisite(): Visite {
        return (new Visite())
                ->setVille("New York")
                ->setPays("USA");
    }
    
    /**
    public function testValidNoteVisite(){
        $visite = $this->getVisite()->setNote(10);
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount(0, $error);
    } */
    
    public function testValidNoteVisite(){
        //$visite = $this->getVisite()->setNote(10);
        //$this->assertErrors($visite, 0);
        $this->assertErrors($this->getVisite()->setNote(10), 0, "10 devrait réussir");
        $this->assertErrors($this->getVisite()->setNote(0), 0, "0 devrait réussir");
        $this->assertErrors($this->getVisite()->setNote(20), 0, "20 devrait réussir");
    }
    
    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message=""){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    
    public function testNonValidNoteVisite(){
        //$visite = $this->getVisite()->setNote(21);
        //$this->assertErrors($visite, 1);
        $this->assertErrors($this->getVisite()->setNote(21), 1, "21 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(45), 1, "45 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(-1), 1, "-1 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(-5), 1, "-5 devrait échouer");
    }
    
    public function testValidDatecreationVisite(){
        $aujourdhui = new \DateTime();
        $this->assertErrors($this->getVisite()->setDatecreation($aujourdhui), 0, "aujourd'hui devrait réussir");
        $plustot = (new \DateTime())->sub(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustot), 0, "plus tôt devrait réussir");
    }
    
    public function testNonValidDatecreationVisite(){
        $demain = (new \DateTime())->add(new \DateInterval("P1D"));
        $this->assertErrors($this->getVisite()->setDatecreation($demain), 1, "demain devrait échouer");
        $plustard = (new \DateTime())->add(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustard), 1, "plus tard devrait échouer");
    }
    
    public function testNonValidTempmaxVisite(){
        $visite = $this->getVisite()
                ->setTempmin(20)
                ->setTempmax(18);
        $this->assertErrors($visite, 1, "min=20, max=18 devrait échouer");
        $this->assertErrors($this->getVisite()->setTempmin(12)->setTempmax(12), 1, "min=12, max=12 devrait échouer");
    }
    
    public function testValidTempmaxVisit(){
        $this->assertErrors($this->getVisite()->setTempmin(14)->setTempmax(15), 1, "min=14, max=15 devrait réussir");
        $this->assertErrors($this->getVisite()->setTempmin(6)->setTempmax(24), 1, "min=6, max=24 devrait réussir");
    }
    
}
