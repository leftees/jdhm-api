<?php
declare(strict_types=1);

namespace JdhmApi\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use JdhmApi\Entity\Client;

/**
* @Extra\Route("/client", name="homepage")
*/
class ClientController extends FOSRestController
{
    /**
    * This method will return the data for the home page
    *
    * @ApiDoc(
    *  section="Home Page",
    *  resource=true,
    *  description="This method will return all the posts",
    *  statusCodes={
    *      200="Returned when successful",
    *      403="Returned when the user is not authorized",
    *      404={
    *        "Returned when the posts are not found"
    *      }
    * }
    * )
    * @Extra\Route("/")
    * @Extra\Method({"GET"})
    */
    public function clientsAction(Request $request)
    {

        $clients = $this->get('doctrine')
                        ->getRepository('JdhmApi\Entity\Client')
                        ->findAll();

        $data = [
            'data' => $clients
        ];

        return $this->view()
                    ->setStatusCode(200)
                    ->setData($data)
                    ->setHeader('Allow', 'GET, DELETE, OPTIONS, PUT, POST')
                    ->setHeader('Access-Control-Allow-Credentials', 'true')
                    ->setHeader('Access-Control-Allow-Headers', 'x-requested-with')
                    //@todo for dev purpose only. The fix it to proper domain
                    ->setHeader('Access-Control-Allow-Origin', '*')
                    ->setHeader('Access-Control-Allow-Methods', 'GET, DELETE, OPTIONS, PUT, POST');
    }

    /**
    * This method will save a client
    *
    * @ApiDoc(
    *  section="Clients",
    *  resource=true,
    *  description="This method will Save the client",
    *  statusCodes={
    *      200="Returned when successful",
    *      403="Returned when the user is not authorized",
    *      404={
    *        "Returned when the posts are not found"
    *      }
    * }
    * )
    * @Extra\Route("/update")
    * @Extra\Method({"POST"})
    */
    public function clientAction(Request $request)
    {

        $idClient = $request->request->get('id');
/*
        $client = $this->get('doctrine')
                        ->getRepository('JdhmApi\Entity\Client')
                        ->find($idClient);


        $client->setFirstName($request->get('firstName'));
        $client->setLastName($request->get('lastName'));
        $client->setEmail($request->get('email'));

        $this->get('doctrine')->getEntityManager()->persist($client);
        $this->get('doctrine')->getEntityManager()->flush();
        */

        $data = [
            'id_client' => $idClient
        ];

        return $this->view()
                    ->setStatusCode(200)
                    ->setData($request)
                    ->setHeader('Allow', 'GET, DELETE, OPTIONS, PUT, POST')
                    ->setHeader('Access-Control-Allow-Credentials', 'true')
                    ->setHeader('Access-Control-Allow-Headers', 'x-requested-with')
                    //@todo for dev purpose only. The fix it to proper domain
                    ->setHeader('Access-Control-Allow-Origin', '*')
                    ->setHeader('Access-Control-Allow-Methods', 'GET, DELETE, OPTIONS, PUT, POST');
    }
}
