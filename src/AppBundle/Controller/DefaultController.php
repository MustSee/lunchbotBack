<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/api/places")
     * @Method("GET")
     */
    public function getPlacesAction()
    {
        // Call to Repository
        $em = $this->get('doctrine')->getManager();
        $linkToRepo = $em->getRepository('AppBundle:Place');

        $places = $linkToRepo->findPlaces();

        return new JsonResponse([
            'places' => $places
        ]);
    }


    /**
     * @Route("/api/places/{name}")
     * @Method("GET")
     */
    public function getOnePlaceToEatAction(Request $request)
    {
        // Call to repo
        $em = $this->get('doctrine')->getManager();
        $linkToRepo = $em->getRepository('AppBundle:Place');

        // Param for research
        $name = $request->get('name');
        $onePlace = $linkToRepo->findPlace($name);

        return new JsonResponse([
            'onePlace' => $onePlace
        ]);
    }

    /**
     * @Route("/api/autocomplete/{query}")
     * @Method("GET")
     */
    public function autocompleteAction(Request $request)
    {
        // link to repo
        $em = $this->get('doctrine')->getManager();
        $linkToRepo = $em->getRepository('AppBundle:Place');

        // Parameter for research
        $chars = $request->get('query');
        $places = $linkToRepo->findAllByChars($chars);

        return new JsonResponse([
            'places' => $places
        ]);
    }

    /**
     * @Route("/api/places")
     * @Method({"POST", "OPTIONS"})
     */
    public function postPlacesAction(Request $request)
    {
    /*
     * Chrome is preflighting the request to look for CORS headers.
     * If the request is acceptable, it will then send the real request.
     * If you're doing this cross-domain, you will simply have to deal with it.
     */
        if($request->getMethod() === "POST") {
            $em = $this->get('doctrine')->getManager();

            // Obtaining associative array with the option true
            $placeJson = json_decode($request->getContent(), true);


            $place = new Place();

            $place->setName($placeJson["name"]);
            $place->setAdress($placeJson['adress']);
            $place->setCoordsLatitude($placeJson['lat']);
            $place->setCoordsLongitude($placeJson['lng']);


            $em->persist($place);
            $em->flush();

            return new Response('add one place', 201);

        } elseif ($request->getMethod() === "OPTIONS") {
            return new Response('Cross-site request preflight, option method used', 200);
        }

    }

    /**
     * @Route("/api/addALikeOnPlace/{name}")
     * @Method("GET")
     */
    public function addALikeOnPlace(Request $request)
    {
            $place = $request->get('name');

            $em = $this->get('doctrine')->getManager();
            $linkToRepo = $em->getRepository('AppBundle:Place');
            $linkToRepo->incrementCounter($place);

            $likeCount = $linkToRepo->retrieveLike($place);

            return new JSONResponse([
                'likeCount' => $likeCount
            ]);
    }

    /**
     * @Route("/api/likeCounter/{name}")
     * @Method("GET")
     */
    public function likeCounterAction (Request $request)
    {
        $place = $request->get("name");

        $em = $this->get('doctrine')->getManager();
        $linkToRepo = $em->getRepository('AppBundle:Place');
        $likeCount = $linkToRepo->retrieveLike($place);

        return new JsonResponse([
            'likeCount' => $likeCount
        ]);
    }

    /**
     * @Route("/api/test")
     * @Method({"POST", "OPTIONS"})
     */
    public function testAction (Request $request)
    {

        if($request->getMethod() === 'POST') {

            $em = $this->get('doctrine')->getManager();


            $pictureJson = json_decode($request->getContent(), true);
            $picture = $pictureJson["pic64"];
            $name = $pictureJson["path"];

            //$decodePicture = base64_decode($picture);
            var_dump($picture); die();

            $product = new Product();
            $product->setImage($name);
            $product->setUpdatedAt(new \DateTime());
            $product->setImageFile($decodePicture);


            $em->persist($product);
            $em->flush();

            return new JsonResponse([
                'test' => 'testpassed'
            ]);

        } elseif ($request->getMethod() === "OPTIONS") {
            return new Response('Cross-site request preflight, option method used', 200);
        }

//        $pictureJson = json_decode($request->getContent(), true);
//
//        //var_dump($pictureJson);
//
//        $raqqa = $pictureJson["path"];
//        //var_dump($raqqa); die();
//
//        $pic64 = base64_decode($pictureJson["pic64"]);
//
//        $response = new Response;
//
//        $response->setContent(
//            json_encode(['pic64' => 'ok'])
//        );
//        $response->headers->set('Content-Type', 'application/json');



    }
}
