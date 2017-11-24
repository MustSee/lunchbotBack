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

        if (isset($imagePathFromName[0]["picturePath"])) {
            $path = $imagePathFromName[0]["picturePath"];
            $target_dir = __DIR__ . "/../../../web/images/";
            $response = new BinaryFileResponse($target_dir . $path);
            return $response;
        } else {
            // S'il n'y a pas d'images
            return new Response('no image');
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
            $place = json_decode($place, true);
            $lat = $place["lat"];
            $lng = $place["lng"];
            $name = $place["name"];

            // On récupère le path pour pouvoir ensuite delete l'image
            $path = $linkToRepo->getPath($name, $lat, $lng);
            // Erase image from web/images
            if($path[0]["picturePath"] != NULL) {
                $target_dir = __DIR__ . "/../../../web/images/";
                $deleteImage = unlink($target_dir.$path[0]["picturePath"]);
            }

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
     * @Route("/api/updatePlace")
     * @Method({"POST", "OPTIONS"})
     */
    public function updatePlaceAction(Request $request)
    {
        if($request->getMethod() === "POST") {
            // To repo
            $em = $this->get('doctrine')->getManager();
            $linkToRepo = $em->getRepository('AppBundle:Place');

            $image = $_FILES;

            $place = $request->get('place');
            $place = json_decode($place, true);

            $imagePreview = $place["imagePreview"];
            $target_dir = __DIR__ . "/../../../web/images/";

            $id = $place["id"];
            // We retrieve the object found by ID
            // We retrieve the place
            $placeFromDb = $linkToRepo->findOneBy(array('id' => $id));
            $path = $placeFromDb->getPicturePath();

            // The goal is to set the picturePath before persisting in DB
            // We check if the path exists
            // If the path exists (the place has already an image)
            if ($path != NULL) {
                // -> we check if there is a file in the formula
                if(isset($image["file"])) {
                    // Erase old image from web repertory
                    unlink($target_dir.$path);

                    // Register new Image to web repertory
                    $target_file = $target_dir . basename($image["file"]["name"]);
                    move_uploaded_file($image["file"]["tmp_name"], $target_file);
                    // picture path à setter
                    $picturePath = $image["file"]["name"];
                }
                // -> if there is a Preview, it means the image is not changed
                elseif ($imagePreview) {
                    //$picturePath stays the same
                    $picturePath = $placeFromDb->getPicturePath();
                }
                // -> if there is no image, we set the path to NULL
                else {
                    unlink($target_dir.$path);
                    $picturePath = NULL;
                }
            }
            // If the path doesn't exists (the place has no image yet)
            else {
                if(isset($image["file"])) {
                    $target_file = $target_dir . basename($image["file"]["name"]);
                    move_uploaded_file($image["file"]["tmp_name"], $target_file);
                    // picture path à setter
                    $picturePath = $image["file"]["name"];
                } else {
                    $picturePath = NULL;
                }
            }

            // Preparing to enter in DB
            $id = $place["id"];
            $name = $place["name"];
            $adress = $place["adress"];
            $lat = $place["coordsLatitude"];
            $lng = $place["coordsLongitude"];
            // We already have retrieve the object in DB
            $placeFromDb->setName($name);
            $placeFromDb->setAdress($adress);
            $placeFromDb->setCoordsLatitude($lat);
            $placeFromDb->setCoordsLongitude($lng);
            $placeFromDb->setPicturePath($picturePath);
            $placeFromDb->setUpdatedAt(new \DateTime());
            $em->persist($placeFromDb);
            $em->flush();

            $res = $linkToRepo->findOneBy(['id' => $id]);

            return new JsonResponse([
                'response' => $res
            ]);

            return new Response ('Place updated successfully', 200);


//           /* $image = $_FILES;
//            // Check if the file exists...
//            // TODO : Replace the old one if exists...
//
//            // Si l'image existe
//            if ($image) {
//                // Current directory
//                $target_dir = __DIR__ . "/../../../web/images/";
//                // Current directory + filename
//                $target_file = $target_dir . basename($image["file"]["name"]);
//                $uploadOk = 1;
//                // file type = png
//                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
//
//                // Checking if it's an image
//                $check = getimagesize($_FILES["file"]["tmp_name"]);
//                if ($check !== false) {
//                    // File is an image
//                    $uploadOk = 1;
//                } else {
//                    $uploadOk = 0;
//                }
//
//                // TODO : Integrity checks
//                // https://www.w3schools.com/php/php_file_upload.asp
//
//                if ($uploadOk == 1) {
//                    // We move the file from the temporary directory to the target.
//                    if (move_uploaded_file($image["file"]["tmp_name"], $target_file)) {
//                        $picturePath = $image["file"]["name"];
//                    } else {
//                        $picturePath = null;
//                    }
//                }
//            } else {
//                $picturePath = null;
//            }*/

            // Il faut que je fasse la modification par l'id



//            // On récupère le path pour pouvoir ensuite delete l'image
//            $path = $linkToRepo->getPath($name, $lat, $lng);
//            // Erase image from web/images
//            if($path[0]["picturePath"] != NULL) {
//                $target_dir = __DIR__ . "/../../../web/images/";
//                $deleteImage = unlink($target_dir.$path[0]["picturePath"]);
//            }

            // We retrieve the object found by ID
//            $place = $linkToRepo->findOneBy(array('id' => $id));
//            // We reset the object
//            $place->setName($name);
//            $place->setAdress($adress);
//            $place->setCoordsLatitude($lat);
//            $place->setCoordsLongitude($lng);
//            $place->setPicturePath($picturePath);
//            $place->setUpdatedAt(new \DateTime());
//            $em->persist($place);
//            $em->flush();

//            // On retourne l'objet updaté
//            $res = $linkToRepo->findOneBy(['id' => $id]);
//
//            //$res = $linkToRepo->updatePlace($id, $name, $adress, $lat, $lng, $picturePath, $datetime);
//
//            // I need the response to set isActive state !! Check out what is in the response !!!
//            return new JsonResponse([
//               'response' => $res
//            ]);

        } else if($request->getMethod() === "OPTIONS") {
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
