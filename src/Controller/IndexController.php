<?php


namespace App\Controller;


use App\Entity\Token;
use App\Exception\SintaticError;
use App\Service\AnalizerService;
use App\Service\SintaticService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\LexicalError;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET","POST"})
     */
    public function index(Request $request)
    {
        set_time_limit(0);
        $listTokens =  new ArrayCollection();
        $erroLexico = null;
        $erroSintatico = null;
        if ($request->request->get('mensagem')) {
            $message = $request->request->get('mensagem');
            try {
                $analizerService = new AnalizerService($message);
                while (($token = $analizerService->nextToken()) != null) {
                    $listTokens->add($token);
                }
            } catch (LexicalError $e) {
                $erroLexico = $e;
            }

            try {
                $sintaticService = new SintaticService($listTokens->toArray());
                $sintaticService->analize();
            } catch (SintaticError $e){
                $erroSintatico = $e;
            }


        }
        return $this->render('home/index.html.twig', [
            'listTokens' => $listTokens,
            'errorLexico' => $erroLexico,
            'errorSintatico' => $erroSintatico,
            'mensagem' => $request->request->get('mensagem')
        ]);
    }
}
