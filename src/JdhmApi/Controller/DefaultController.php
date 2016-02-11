<?php
declare(strict_types=1);

namespace JdhmApi\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends FOSRestController
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
    * @Extra\Route("/", name="homepage")
    * @Extra\Method({"GET"})
    */
    public function indexAction(Request $request)
    {
        $date = new \DateTime();
        $data = [
            'status' => 'Ok',
            'date'  => $date->format("Y-m-d H:i:s"),
            'content-type' => $request->getContentType(),
            'message' => "API in developpement :)",
            'documentation' => 'http://phb.li/api/doc',
            'client' => [
                'ip' => $request->getClientIp(),
                'user' => $request->getUser(),
                'host' => $request->getHttpHost(),
                'is_secure' => $request->isSecure()

            ]
        ];

        return $this->view()
                    ->setStatusCode(200)
                    ->setData($data);
    }

    /**
    * Strict type function
    */
    private function helloStrict(int $age, string $name): string
    {
      return sprintf("My name is %s and I'm %d years old", $name, $age);
    }

}
