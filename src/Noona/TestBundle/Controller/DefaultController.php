<?php

namespace Noona\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $this->get('noona_app.excelparser');
        echo 'page de test';die;
    }
}
