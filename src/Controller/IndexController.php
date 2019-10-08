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
        $tableSimbolo = new TabelaSimbolos();
        echo "Adicionado 10 Simbolos";
        //Adiciona simbolos
        $tableSimbolo->adiciona('aux1', 'var', 0, 'geral1', 'geral2');
        $tableSimbolo->adiciona('aux2', 'procedure', 0, 'geral1', 'geral2');
        $tableSimbolo->adiciona('a', 'var', 1, 'geral1', 'geral2');
        $tableSimbolo->adiciona('a', 'var', 2, 'geral1', 'geral2');
        $tableSimbolo->adiciona('b', 'var', 1, 'geral1', 'geral2');
        $tableSimbolo->adiciona('c', 'var', 3, 'geral1', 'geral2');
        $tableSimbolo->adiciona('d', 'procedure', 3, 'geral1', 'geral2');
        $tableSimbolo->adiciona('ind1', 'var', 4, 'geral1', 'geral2');
        $tableSimbolo->adiciona('ind2', 'parameter', 4, 'geral1', 'geral2');
        $tableSimbolo->adiciona('ind3', 'var', 4, 'geral1', 'geral2');
        $tableSimbolo->adiciona('teste', 'var', 5, 'geral1', 'geral2');

        //Mostra tabela atual
        $tableSimbolo->showList();

        echo "<br>Editado 5 Simbolos";
        //Edita simbolos
        $tableSimbolo->editar('teste',5,  'geralA', 'geralA-alterado');
        $tableSimbolo->editar('b', 1,'geralB', 'geralB-alterado');
        $tableSimbolo->editar('d', 3,'geralA', 'geralA-alterado');
        $tableSimbolo->editar('ind2',4, 'geralB', 'geralB-alterado');
        $tableSimbolo->editar('aux1', 0,'geralA', 'geralA-alterado');
        //Mostra tabela atual
        $tableSimbolo->showList();

        echo "<br>Removido 3 Simbolos";

        //Remove simbolos
        $tableSimbolo->remove('ind1',4);
        $tableSimbolo->remove('d',3);
        $tableSimbolo->remove('c',3);
        //Mostra tabela atual
        $tableSimbolo->showList();


        echo "<br>Busca por Simbolo inexistente";
        //Busca simbolo inexistente
        print_r($tableSimbolo->searchNameAndNivel('c',3,true));

        echo "<br>Busca por 3 Simbolos existentes";

        dump($tableSimbolo->searchNameAndNivel('aux1',0));
        dump($tableSimbolo->search('a',1));
        dump($tableSimbolo->search('ind2',4));

        die;
    }
}
