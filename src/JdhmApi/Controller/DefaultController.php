<?php

namespace JdhmApi\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use FOS\RestBundle\Controller\Annotations as Rest;

class DefaultController extends FOSRestController
{
    /**
     * @Extra\Route("/", name="homepage")
     * @Extra\Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $date = new \DateTime();
        $data = [
            'status' => 'Ok',
            'date'  => $date->format("Y-m-d H:i:s"),
            'message' => "API in developpement :)"
        ];

        return $this->view()
                    ->setStatusCode(200)
                    ->setData($data);
    }
}
