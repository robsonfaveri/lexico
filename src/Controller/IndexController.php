<?php


namespace App\Controller;


use App\Entity\Token;
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
        $erroLexical = null;
        if ($request->request->get('mensagem')) {
            $message = $request->request->get('mensagem');
            try {
                $analizerService = new AnalizerService($message);
                while (($token = $analizerService->nextToken()) != null) {
                    $listTokens->add($token);
                }
            } catch (LexicalError $erro) {
                $erroLexical = $erro;
            }
            $sintaticService = new SintaticService($listTokens->toArray());


            $sintaticService->analize();
        }
        return $this->render('home/index.html.twig', [
            'listTokens' => $listTokens,
            'error' => $erroLexical,
            'mensagem' => $request->request->get('mensagem')
        ]);
    }
}
