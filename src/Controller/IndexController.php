<?php


namespace App\Controller;


use App\Entity\Token;
use App\Service\AnalizerService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET","POST"})
     */
    public function index(Request $request) {
        $listTokens =  new ArrayCollection();
        if($request->request->get('mensagem')){
            $message = $request->request->get('mensagem');

            $analizerService = new AnalizerService($message);

            while(($token = $analizerService->nextToken()) != null){
                $listTokens->add($token);
            }
        }
        return $this->render('home/index.html.twig',['listTokens' => $listTokens]);
    }


}