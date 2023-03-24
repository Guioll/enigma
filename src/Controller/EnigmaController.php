<?php

namespace App\Controller;

use App\Entity\Rotor;
use App\Form\MsgType;
use App\Repository\RotorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnigmaController extends AbstractController
{
    private string $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private Rotor $reflecteur;

    public function __construct(
        RotorRepository $rotorRepository
    )
    {
        $this->reflecteur = $rotorRepository->find(1);
    }

    #[Route('/traiter', name: 'traiter')]
    public function traiter(
        Request $request,
    ): Response
    {
        $msgForm = $this->createForm(MsgType::class);
        $msgForm->handleRequest($request);

        if($msgForm->isSubmitted()){
            $data = $msgForm->getData();
            $msg = $data['Message'];
            $rotor1 = $data['rotor1'];
            $rotor2 = $data['rotor2'];
            $rotor3 = $data['rotor3'];
            $resultat = $this->traitement($msg, $rotor1, $rotor2, $rotor3);
            return $this->render('enigma/resultat.html.twig',
                compact('resultat'),
            );
        }

        return $this->render('enigma/traiter.html.twig',
            compact('msgForm'),
        );
    }

    private function traitement(string $msg, Rotor $r1, Rotor $r2, Rotor $r3): string
    {
        $msg = strtoupper($msg);
        $tmp = $msg;
        $resArray = str_split($tmp);
        $res = "";
        $offset1 = 0;
        $offset2 = 0;
        $offset3 = 0;

        foreach ($resArray as $singleChar){
            if(preg_match('/[a-zA-Z]/',$singleChar)) {

                $offset1++;

                $tmpChar = $this->transformation($singleChar, $this->alphabet, $r1->getPermutationsList(), $offset1);

                if (($offset1 % $r2->getEncoche()) === 0) {
                    $offset2++;
                }

                $tmpChar = $this->transformation($tmpChar, $this->alphabet, $r2->getPermutationsList(), $offset2);

                if (($offset2 % $r3->getEncoche()) === 0) {
                    $offset3++;
                }

                $tmpChar = $this->transformation($tmpChar, $this->alphabet, $r3->getPermutationsList(), $offset3);


                $tmpChar = $this->transformation($tmpChar, $this->alphabet, $this->reflecteur->getPermutationsList(), 0);

                $tmpChar = $this->transformation($tmpChar, $r3->getPermutationsList(), $this->alphabet, -$offset3);

                $tmpChar = $this->transformation($tmpChar, $r2->getPermutationsList(), $this->alphabet, -$offset2);

                $tmpChar = $this->transformation($tmpChar, $r1->getPermutationsList(), $this->alphabet, -$offset1);

                $res .= $tmpChar;
            }
        }

        return $res;
    }

    private function transformation(string $char, string $alphOrigine, string $aplhDest, int $offset): string
    {
        $index = (strpos($alphOrigine, $char) + $offset)%26;
        return $aplhDest[$index];

    }
}
