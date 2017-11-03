<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place_to_eat;
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
     * @Route("/all_added_spots",
     *     name="all_added_spots"
     * )
     * @Method("GET")
     */
    public function getAllAddedPlacesToEatAction()
    {
        // Call to Repository
        $em = $this->get('doctrine')->getManager();
        $linkToRepo = $em->getRepository('AppBundle:Place_to_eat');

        $allPlacesAdded = $linkToRepo->findAllAddedPlacesToEat();

        return new JsonResponse([
            'allPlacesAdded' => $allPlacesAdded
        ]);
    }


    /**
     * @Route("/all_places_to_eat/{name}",
     *     name="one_place_to_eat",
     *     options={"expose" = true},
     * )
     * @Method("GET")
     */
    public function getOnePlaceToEatAction(Request $request)
    {
        // Call to repo
        $em = $this->get('doctrine')->getManager();
        $linkToRepo = $em->getRepository('AppBundle:LieuAlimentation');

        // Param for research
        $name = $request->get('name');
        $onePlace = $linkToRepo->findOnePlace($name);

        return new JsonResponse([
            'onePlace' => $onePlace
        ]);
    }


    /**
     * @Route("/autocomplete/{find}",
     *     name="autoComplete",
     *     options={"expose" = true}
     * )
     * @Method("GET")
     */
    public function autoCompleteAction(Request $request)
    {
        // link to repo
        $em = $this->get('doctrine')->getManager();
        $linkToRepo = $em->getRepository('AppBundle:LieuAlimentation');

        // Parameter for research
        $chars = $request->get('find');
        $places = $linkToRepo->findAllByChars($chars);

        return new JsonResponse([
            'places' => $places
        ]);


        // Link to repo ou repos...
            // Renvoyer un résultat selon la valeur de l'input
    }


    /**
     * @Route("/add_new_place_to_eat",
     * name="add_new_place_to_eat",
     * options = { "expose" = true },
     * )
     */
    public function postNewPlaceToEatAction(Request $request)
    {

        // Il faut qu'à un moment je vérifie l'intégrité des données
        $em = $this->get('doctrine')->getManager();

        var_dump(json_decode($request->getContent())); die();

        $datas = $request->get("new_spot");
        // J'ai un tableau de données avec l'option true
        $datas = json_decode($datas, true);

        $name = $datas["name"];
        $adress = $datas["adress"];
        $town = $datas["town"];
        $picture = base64_decode($datas["picture"]);
        echo $picture;
        $lat = $datas["lat"];
        $lng = $datas["lng"];


        $spot = new Place_to_eat();

        $spot->setName($name);
        $spot->setAdress($adress);
        $spot->setTown($town);
        $spot->setPicturePath($picture);
        $spot->setCoordsLatitude($lat);
        $spot->setCoordsLongitude($lng);

        $em->persist($spot);
        $em->flush();

        return new Response("Added one spot", 201);

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
