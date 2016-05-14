<?php

namespace Loamok\Sf2securityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('Sf2securityBundle:Default:index.html.twig');
    }
}
