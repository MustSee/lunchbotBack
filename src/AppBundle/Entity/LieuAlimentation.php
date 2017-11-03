<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LieuAlimentation
 *
 * @ORM\Table(name="LIEU_ALIMENTATION")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LieuAlimentationRepository")
 */
class LieuAlimentation
{
    /**
     * @var string
     *
     * @ORM\Column(name="DENOMINATION", type="string", length=255, nullable=false)
     */
    private $denomination;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ADRESSE", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="CODE_POSTAL", type="string", length=5, nullable=true)
     */
    private $codePostal = '92100';

    /**
     * @var string
     *
     * @ORM\Column(name="VILLE", type="string", length=100, nullable=true)
     */
    private $ville = 'Boulogne-Billancourt';

    /**
     * @var string
     *
     * @ORM\Column(name="POSITION_LONGITUDE", type="decimal", precision=20, scale=16, nullable=true)
     */
    private $positionLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="POSITION_LATITUDE", type="decimal", precision=20, scale=16, nullable=true)
     */
    private $positionLatitude;

    /**
     * @var string
     *
     * @ORM\Column(name="SITE_INTERNET", type="string", length=255, nullable=true)
     */
    private $siteInternet;

    /**
     * @var string
     *
     * @ORM\Column(name="TELEPHONE", type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="PHOTO", type="blob", length=65535, nullable=true)
     */
    private $photo;

    /**
     * @var array
     *
     * @ORM\Column(name="CATEGORIE", type="simple_array", nullable=false)
     */
    private $categorie;

    /**
     * @var array
     *
     * @ORM\Column(name="AMBIANCE", type="simple_array", nullable=false)
     */
    private $ambiance;

    /**
     * @var array
     *
     * @ORM\Column(name="TYPE_PAIEMENT", type="simple_array", nullable=false)
     */
    private $typePaiement;

    /**
     * @var integer
     *
     * @ORM\Column(name="PAIEMENT_CB_MONTANT_MIN", type="integer", nullable=false)
     */
    private $paiementCbMontantMin;

    /**
     * @var array
     *
     * @ORM\Column(name="SERVICE", type="simple_array", nullable=true)
     */
    private $service;

    /**
     * @var array
     *
     * @ORM\Column(name="TYPE_PREPARATION", type="simple_array", nullable=true)
     */
    private $typePreparation;

    /**
     * @var array
     *
     * @ORM\Column(name="TYPE_CUISINE", type="simple_array", nullable=false)
     */
    private $typeCuisine;

    /**
     * @var array
     *
     * @ORM\Column(name="TYPE_PLAT", type="simple_array", nullable=false)
     */
    private $typePlat;

    /**
     * @var string
     *
     * @ORM\Column(name="SPECIALITE", type="text", length=65535, nullable=true)
     */
    private $specialite;

    /**
     * @var string
     *
     * @ORM\Column(name="PROMOTION", type="text", length=65535, nullable=true)
     */
    private $promotion;

    /**
     * @var array
     *
     * @ORM\Column(name="JOUR_OUVERTURE", type="simple_array", nullable=false)
     */
    private $jourOuverture;

    /**
     * @var integer
     *
     * @ORM\Column(name="HEURE_OUVERTURE", type="integer", nullable=false)
     */
    private $heureOuverture;

    /**
     * @var boolean
     *
     * @ORM\Column(name="HEURE_FERMETURE", type="boolean", nullable=false)
     */
    private $heureFermeture;

    /**
     * @var boolean
     *
     * @ORM\Column(name="NOTATION", type="boolean", nullable=true)
     */
    private $notation;

    /**
     * @var string
     *
     * @ORM\Column(name="BUDGET", type="string", nullable=true)
     */
    private $budget;

    /**
     * @var boolean
     *
     * @ORM\Column(name="QUALITE", type="boolean", nullable=true)
     */
    private $qualite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="QUANTITE", type="boolean", nullable=true)
     */
    private $quantite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="RAPIDITE_SERVICE", type="boolean", nullable=true)
     */
    private $rapiditeService;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set denomination
     *
     * @param string $denomination
     *
     * @return LieuAlimentation
     */
    public function setDenomination($denomination)
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * Get denomination
     *
     * @return string
     */
    public function getDenomination()
    {
        return $this->denomination;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return LieuAlimentation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return LieuAlimentation
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return LieuAlimentation
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return LieuAlimentation
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set positionLongitude
     *
     * @param string $positionLongitude
     *
     * @return LieuAlimentation
     */
    public function setPositionLongitude($positionLongitude)
    {
        $this->positionLongitude = $positionLongitude;

        return $this;
    }

    /**
     * Get positionLongitude
     *
     * @return string
     */
    public function getPositionLongitude()
    {
        return $this->positionLongitude;
    }

    /**
     * Set positionLatitude
     *
     * @param string $positionLatitude
     *
     * @return LieuAlimentation
     */
    public function setPositionLatitude($positionLatitude)
    {
        $this->positionLatitude = $positionLatitude;

        return $this;
    }

    /**
     * Get positionLatitude
     *
     * @return string
     */
    public function getPositionLatitude()
    {
        return $this->positionLatitude;
    }

    /**
     * Set siteInternet
     *
     * @param string $siteInternet
     *
     * @return LieuAlimentation
     */
    public function setSiteInternet($siteInternet)
    {
        $this->siteInternet = $siteInternet;

        return $this;
    }

    /**
     * Get siteInternet
     *
     * @return string
     */
    public function getSiteInternet()
    {
        return $this->siteInternet;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return LieuAlimentation
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return LieuAlimentation
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set categorie
     *
     * @param array $categorie
     *
     * @return LieuAlimentation
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return array
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set ambiance
     *
     * @param array $ambiance
     *
     * @return LieuAlimentation
     */
    public function setAmbiance($ambiance)
    {
        $this->ambiance = $ambiance;

        return $this;
    }

    /**
     * Get ambiance
     *
     * @return array
     */
    public function getAmbiance()
    {
        return $this->ambiance;
    }

    /**
     * Set typePaiement
     *
     * @param array $typePaiement
     *
     * @return LieuAlimentation
     */
    public function setTypePaiement($typePaiement)
    {
        $this->typePaiement = $typePaiement;

        return $this;
    }

    /**
     * Get typePaiement
     *
     * @return array
     */
    public function getTypePaiement()
    {
        return $this->typePaiement;
    }

    /**
     * Set paiementCbMontantMin
     *
     * @param integer $paiementCbMontantMin
     *
     * @return LieuAlimentation
     */
    public function setPaiementCbMontantMin($paiementCbMontantMin)
    {
        $this->paiementCbMontantMin = $paiementCbMontantMin;

        return $this;
    }

    /**
     * Get paiementCbMontantMin
     *
     * @return integer
     */
    public function getPaiementCbMontantMin()
    {
        return $this->paiementCbMontantMin;
    }

    /**
     * Set service
     *
     * @param array $service
     *
     * @return LieuAlimentation
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return array
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set typePreparation
     *
     * @param array $typePreparation
     *
     * @return LieuAlimentation
     */
    public function setTypePreparation($typePreparation)
    {
        $this->typePreparation = $typePreparation;

        return $this;
    }

    /**
     * Get typePreparation
     *
     * @return array
     */
    public function getTypePreparation()
    {
        return $this->typePreparation;
    }

    /**
     * Set typeCuisine
     *
     * @param array $typeCuisine
     *
     * @return LieuAlimentation
     */
    public function setTypeCuisine($typeCuisine)
    {
        $this->typeCuisine = $typeCuisine;

        return $this;
    }

    /**
     * Get typeCuisine
     *
     * @return array
     */
    public function getTypeCuisine()
    {
        return $this->typeCuisine;
    }

    /**
     * Set typePlat
     *
     * @param array $typePlat
     *
     * @return LieuAlimentation
     */
    public function setTypePlat($typePlat)
    {
        $this->typePlat = $typePlat;

        return $this;
    }

    /**
     * Get typePlat
     *
     * @return array
     */
    public function getTypePlat()
    {
        return $this->typePlat;
    }

    /**
     * Set specialite
     *
     * @param string $specialite
     *
     * @return LieuAlimentation
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get specialite
     *
     * @return string
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * Set promotion
     *
     * @param string $promotion
     *
     * @return LieuAlimentation
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return string
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * Set jourOuverture
     *
     * @param array $jourOuverture
     *
     * @return LieuAlimentation
     */
    public function setJourOuverture($jourOuverture)
    {
        $this->jourOuverture = $jourOuverture;

        return $this;
    }

    /**
     * Get jourOuverture
     *
     * @return array
     */
    public function getJourOuverture()
    {
        return $this->jourOuverture;
    }

    /**
     * Set heureOuverture
     *
     * @param integer $heureOuverture
     *
     * @return LieuAlimentation
     */
    public function setHeureOuverture($heureOuverture)
    {
        $this->heureOuverture = $heureOuverture;

        return $this;
    }

    /**
     * Get heureOuverture
     *
     * @return integer
     */
    public function getHeureOuverture()
    {
        return $this->heureOuverture;
    }

    /**
     * Set heureFermeture
     *
     * @param boolean $heureFermeture
     *
     * @return LieuAlimentation
     */
    public function setHeureFermeture($heureFermeture)
    {
        $this->heureFermeture = $heureFermeture;

        return $this;
    }

    /**
     * Get heureFermeture
     *
     * @return boolean
     */
    public function getHeureFermeture()
    {
        return $this->heureFermeture;
    }

    /**
     * Set notation
     *
     * @param boolean $notation
     *
     * @return LieuAlimentation
     */
    public function setNotation($notation)
    {
        $this->notation = $notation;

        return $this;
    }

    /**
     * Get notation
     *
     * @return boolean
     */
    public function getNotation()
    {
        return $this->notation;
    }

    /**
     * Set budget
     *
     * @param string $budget
     *
     * @return LieuAlimentation
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return string
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set qualite
     *
     * @param boolean $qualite
     *
     * @return LieuAlimentation
     */
    public function setQualite($qualite)
    {
        $this->qualite = $qualite;

        return $this;
    }

    /**
     * Get qualite
     *
     * @return boolean
     */
    public function getQualite()
    {
        return $this->qualite;
    }

    /**
     * Set quantite
     *
     * @param boolean $quantite
     *
     * @return LieuAlimentation
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return boolean
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set rapiditeService
     *
     * @param boolean $rapiditeService
     *
     * @return LieuAlimentation
     */
    public function setRapiditeService($rapiditeService)
    {
        $this->rapiditeService = $rapiditeService;

        return $this;
    }

    /**
     * Get rapiditeService
     *
     * @return boolean
     */
    public function getRapiditeService()
    {
        return $this->rapiditeService;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
