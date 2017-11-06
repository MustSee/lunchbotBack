<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
      // Call to repository
      $em = $this->get('doctrine')->getManager();
      $linkToRepo = $em->getRepository('AppBundle:LieuAlimentation');

      $everything = $linkToRepo->findAll();
        return $this->render('default/index.html.twig', [
          'everything'=>$everything
        ]);
    }


    /**
     * @Route("/all_places_to_eat",
     * name="all_places_to_eat",
     * options = { "expose" = true },
     * )
     * @Method("GET")
     */
    public function getAllPlacesToEatAction()
    {
      // Call to repository
      $em = $this->get('doctrine')->getManager();
      $linkToRepo = $em->getRepository('AppBundle:LieuAlimentation');

      $allPlaces = $linkToRepo->findAllPlacesToEat();

      return new JsonResponse([
          'allPlaces' => $allPlaces
      ]);
    }

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


//    /**
//     * @Route("/all_places_to_eat/{name}",
//     *     name="one_place_to_eat",
//     *     options={"expose" = true},
//     * )
//     * @Method("GET")
//     */
//    public function getOnePlaceToEatAction(Request $request)
//    {
//        // Call to repo
//        $em = $this->get('doctrine')->getManager();
//        $linkToRepo = $em->getRepository('AppBundle:LieuAlimentation');
//
//        // Param for research
//        $name = $request->get('name');
//        $onePlace = $linkToRepo->findOnePlace($name);
//
//        return new JsonResponse([
//            'onePlace' => $onePlace
//        ]);
//    }


    /**
     * @Route("/api/autocomplete/{query}",
     *     name="autocomplete",
     *     options={"expose" = true}
     * )
     * @Method("GET")
     */
    public function autocompleteAction(Request $request)
    {
        // link to repo
        $em = $this->get('doctrine')->getManager();
        $linkToRepo = $em->getRepository('AppBundle:LieuAlimentation');

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
        // TODO : check data integrity
        $em = $this->get('doctrine')->getManager();

        // Obtaining associative array with the option true
        $placeJson = json_decode($request->getContent(), true);

        $place = new Place();

        $place->setName($placeJson["name"]);
        $place->setAdress($placeJson['adress']);
        $place->setCity($placeJson['city']);
        $place->setCoordsLatitude($placeJson['lat']);
        $place->setCoordsLongitude($placeJson['lng']);


        $em->persist($place);
        $em->flush();

        return new Response("Added one place", 201);
    }


    /**
     * @Route("/like_a_place",
     * name="like_a_place",
     * options = { "expose" = true },
     * )
     * @Method("POST")
     */
    public function likeAPlaceAction()
    {
        // TO DO
            // Créer la table like en lien avec l'autre
            // A chaque clique, incrémenter (comme dans TinyUrl)
            // Limiter le nombre de clicks
    }

    /**
     * @ROUTE("/test/{mars}",
     *     name="testAxios")
     * @Method("POST")
     */
    public function testAxios(Request $request)
    {
        var_dump($request);
    }

}
