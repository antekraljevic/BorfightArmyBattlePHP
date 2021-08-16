<?php

namespace App\Controller;

use App\Factory\MainFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    /**
     * @Route("/armybattle", name="app_lucky_number") 
     */
    public function index(Request $request): Response
    {
        $armyOne = $request->query->get('armyOne');
        $armyTwo = $request->query->get('armyTwo');
        if(!$this->validateParameters($armyOne ?? null, $armyTwo ?? null)){
            throw new BadRequestHttpException('Invalid parameters, please fix and try again.');
        }

        $armies = $this->getFactory()->createArmies($armyOne, $armyTwo);

        $log = array();
        $log[] = 'Battle begins! ArmyOne has ' . $armyOne . ' soldiers. ArmyTwo has ' . $armyTwo . ' soldiers.';
        $log[] = '-----------------------------------';

        $log = $this->getFactory()->getRepository()->engageBattle($armies, $log);

        $response = new Response(json_encode(array('result' => $log)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    private function validateParameters(?int $armyOne, ?int $armyTwo): bool
    {
        if(!$armyOne || !$armyTwo){
            return false;
        }
        if($armyOne < 1 || $armyTwo < 1){
            return false;
        }
        return true;
    }

    private function getFactory()
    {
        return new MainFactory();
    }
}