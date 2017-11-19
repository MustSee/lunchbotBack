<?php

namespace AppBundle\Controller;

use AppBundle\Entity\image;
use AppBundle\Entity\Place;
use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
        if ($request->getMethod() === "POST") {
            $em = $this->get('doctrine')->getManager();

            // Obtaining associative array with the option true
            $place = $request->get('place');
            $placeJson = json_decode($place, true);

            $place = new Place();

            $place->setName($placeJson["name"]);
            $place->setAdress($placeJson['adress']);
            $place->setCoordsLatitude($placeJson['coordsLatitude']);
            $place->setCoordsLongitude($placeJson['coordsLongitude']);

            // Obtaining image
            $image = $_FILES;

            // Si l'image existe
            if ($image) {
                // Current directory
                $target_dir = __DIR__ . "/../../../web/images/";
                // Current directory + filename
                $target_file = $target_dir . basename($image["file"]["name"]);
                $uploadOk = 1;
                // file type = png
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

                // Checking if it's an image
                $check = getimagesize($_FILES["file"]["tmp_name"]);
                if ($check !== false) {
                    // File is an image
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }

                // Integrity checks
                // https://www.w3schools.com/php/php_file_upload.asp

                if ($uploadOk == 1) {
                    // We move the file from the temporary directory to the target.
                    if (move_uploaded_file($image["file"]["tmp_name"], $target_file)) {
                        $place->setPicturePath($image["file"]["name"]);
                    }
                }
            }

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
    public function likeCounterAction(Request $request)
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
     * @Route("/api/loadActiveImage/{name}")
     * @Method("GET")
     */
    public function loadImageActivePlaceAction(Request $request)
    {
        $em = $this->get('doctrine')->getManager();
        $linkToRepo = $em->getRepository('AppBundle:Place');

        // Find image path from name
        $name = $request->get('name');
        $imagePathFromName = $linkToRepo->retrieveImagePathFromName($name);

        if ($imagePathFromName[0]["picturePath"] === NULL) {
            // S'il n'y a pas d'images
            return new Response('no image');
        } else {
            $path = $imagePathFromName[0]["picturePath"];
            $target_dir = __DIR__ . "/../../../web/";
            $response = new BinaryFileResponse($target_dir . $path);
            return $response;
        }

    }

    /**
     * @Route("/api/deletePlace/")
     * @Method({"POST", "OPTIONS"})
     */
    public function deletePlaceAction(Request $request)
    {
        if($request->getMethod() === 'POST') {

            $em = $this->get('doctrine')->getManager();
            $linkToRepo = $em->getRepository('AppBundle:Place');

            $place = $request->getContent();
            var_dump($place); die();
            $place = json_decode($place, true);
            $lat = $place["lat"];
            $lng = $place["lng"];
            $name = $place["name"];

            // if deleted, returns 1, if not returns 0
            $res = $linkToRepo->deletePlace($name, $lat, $lng);

            return new JSONResponse ([
                'response' => $res
            ]);

        } else if ($request->getMethod() === 'OPTIONS') {
            return new Response ('Cross-site request preflight, option method used', 200);
        }
    }

    /**
     * @Route("/api/test")
     * @Method({"POST", "OPTIONS"})
     */
    public function testAction(Request $request)
    {

        if ($request->getMethod() === 'POST') {

            $em = $this->get('doctrine')->getManager();

            $image = $_FILES;

            $name = $request->get('name');

            // If image is empty

            // Current directory
            $target_dir = __DIR__ . "/../../../web/images/";
            // Current directory + filename
            $target_file = $target_dir . basename($image["file"]["name"]);
            $uploadOk = true;
            // file type = png
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);


            // Checking if it an image
            $check = getimagesize($_FILES["file"]["tmp_name"]);
            var_dump($check); die();
            if ($check !== false) {
                // File is an image
                $uploadOk = true;
            } else {
                $uploadOk = false;
            }

            // Integrity checks
            // https://www.w3schools.com/php/php_file_upload.asp


            if ($uploadOk == 1) {
                // We move the file from the temporary directory to the target.
                if (move_uploaded_file($image["file"]["tmp_name"], $target_file)) {

                    $pathImage = new image();
                    $pathImage->setPath($image["file"]["name"]);
                    $em->persist($pathImage);
                    $em->flush();

                    return new Response("The file " . basename($image["file"]["name"]) . " has been uploaded.");
                } else {
                    return new  Response("Sorry, there was an error uploading your file.");
                }
            }
        } elseif ($request->getMethod() === "OPTIONS") {
            return new Response('Cross-site request preflight, option method used', 200);
        }
    }
}
