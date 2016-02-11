<?php
declare(strict_types=1);

namespace JdhmApi\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use JdhmApi\Entity\Client;

/**
* @Extra\Route("/clients", name="homepage")
*/
class ClientController extends FOSRestController
{
    /**
    * This method will return all the clients
    *
    * @ApiDoc(
    *  section="Clients",
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
    * @Rest\View()
    */
    public function getAllClientsAction()
    {
        $clients = $this->get('doctrine')
                        ->getRepository('JdhmApi\Entity\Client')
                        ->findAll();

        $data = [
            'data' => $clients
        ];

        return $data;
    }

    /**
    * This method will return one client
    *
    * @ApiDoc(
    *  section="Clients",
    *  resource=true,
    *  description="This method will return one client",
    *  statusCodes={
    *      200="Returned when successful",
    *      403="Returned when the user is not authorized",
    *      404={
    *        "Returned when the posts are not found"
    *      }
    * }
    * )
    * @Extra\Route("/{id}")
    * @Extra\Method({"GET"})
    * @ParamConverter("client", class="JdhmApi\Entity\Client")
    * @Rest\View()
    */
    public function getClientAction(Client $client)
    {
        $data = [
            'data' => $client
        ];

        return $data;
    }

    /**
    * This method will update a client
    *
    * @ApiDoc(
    *  section="Clients",
    *  resource=true,
    *  description="This method will update a client",
    *  statusCodes={
    *      200="Returned when successful",
    *      403="Returned when the user is not authorized",
    *      404={
    *        "Returned when the posts are not found"
    *      }
    * }
    * )
    * @Extra\Route("/{id}")
    * @Extra\Method({"PUT"})
    * @ParamConverter("client", class="JdhmApi\Entity\Client")
    * @Rest\View()
    */
    public function updateClientAction(Client $client, Request $request)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $content = json_decode($request->getContent(), true);

        if (!$content) {
            throw new HttpException("No json data in body", 405);
        }

        $client->setFirstName($content['firstName']);
        $client->setLastName($content['lastName']);
        $client->setEmail($content['email']);

        $em->persist($client);
        $em->flush();

        $data = [
            'data' => $client
        ];

        return $data;
    }

    /**
    * This method will create a client
    *
    * @ApiDoc(
    *  section="Clients",
    *  resource=true,
    *  description="This method will Create a client",
    *  statusCodes={
    *      200="Returned when successful",
    *      403="Returned when the user is not authorized",
    *      404={
    *        "Returned when the posts are not found"
    *      }
    * }
    * )
    * @Extra\Route("/")
    * @Extra\Method({"POST"})
    * @Rest\View()
    */
    public function createClientAction(Request $request)
    {
        $em = $this->get('doctrine')->getEntityManager();

        /*
        $client = new Client();
        $client->setFirstName($request->get('firstName'));
        $client->setLastName($request->get('lastName'));
        $client->setEmail($request->get('email'));

        $em->persist($client);
        $em->flush();
        */

        $data = [
            'request' => $request->request
        ];

        return $data;
    }

    /**
    * This method will delete a client
    *
    * @ApiDoc(
    *  section="Clients",
    *  resource=true,
    *  description="This method will delete the client",
    *  statusCodes={
    *      200="Returned when successful",
    *      403="Returned when the user is not authorized",
    *      404={
    *        "Returned when the posts are not found"
    *      }
    * }
    * )
    * @Extra\Route("/{id}")
    * @Extra\Method({"DELETE"})
    * @ParamConverter("client", class="JdhmApi\Entity\Client")
    * @Rest\View()
    */
    public function deleteClientAction(Client $client)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $em->remove($client);
        $em->flush();

        $data = [
            'id_client' => $idClient
        ];

        return $data;
    }
}
