<?php


namespace App\Controller;

use App\Entity\Token;
use App\Exception\SintaticError;
use App\Service\AnalizerService;
use App\Service\SintaticService;
use App\Service\TabelaSimbolos;
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
            } catch (SintaticError $e) {
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

    /**
     * @Route("/table", name="table", methods={"GET","POST"})
     */
    public function table(Request $request)
    {
        $tableSimbolo = new TabelaSimbolos(3001);
        echo "Adicionado 10 Simbolos";
        //Adiciona simbolos
        $tableSimbolo->adiciona('var1', 'var', 0, 'geral1', 'geral2');
        $tableSimbolo->adiciona('var2', 'procedure', 0, 'geral1', 'geral2');
        $tableSimbolo->adiciona('a', 'var', 0, 'geral1', 'geral2');
        $tableSimbolo->adiciona('a', 'var', 1, 'geral1', 'geral2');
        $tableSimbolo->adiciona('b', 'var', 0, 'geral1', 'geral2');
        $tableSimbolo->adiciona('c', 'var', 0, 'geral1', 'geral2');
        $tableSimbolo->adiciona('d', 'procedure', 0, 'geral1', 'geral2');
        $tableSimbolo->adiciona('ind1', 'var', 0, 'geral1', 'geral2');
        $tableSimbolo->adiciona('ind2', 'parameter', 0, 'geral1', 'geral2');
        $tableSimbolo->adiciona('ind3', 'var', 0, 'geral1', 'geral2');
        $tableSimbolo->adiciona('teste', 'var', 0, 'geral1', 'geral2');

        //Mostra tabela atual
        $tableSimbolo->showList();

        echo "<br>Editado 5 Simbolos";
        //Edita simbolos
        $tableSimbolo->editar('teste', 'categoria', 'const');
        $tableSimbolo->editar('b', 'nivel', '2');
        $tableSimbolo->editar('d', 'nivel', '1');
        $tableSimbolo->editar('ind2', 'categoria', 'const');
        //Mostra tabela atual
        $tableSimbolo->showList();

        echo "<br>Removido 3 Simbolos";

        //Remove simbolos
        $tableSimbolo->remove('ind1');
        $tableSimbolo->remove('d');
        $tableSimbolo->remove('c');
        //Mostra tabela atual
        $tableSimbolo->showList();

        //Busca simbolo inexistente
        //$tableSimbolo->search('var');

        dump($tableSimbolo->search('var1'));
        dump($tableSimbolo->search('a'));
        dump($tableSimbolo->search('ind2'));

        die;
    }
}
