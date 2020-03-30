<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method

$route['exercice'] = "Ctr_exercice";
$route['exercice/(:any)'] = "Ctr_exercice/$1";
$route['exercice/(:any)/(:any)'] = "Ctr_exercice/exercice/$1/$2";

$route['entite'] = "Ctr_entite";
$route['entite/(:any)'] = "Ctr_entite/entite/$1";

$route['dotation'] = "Ctr_dotation";
$route['dotation/carburant/(:any)'] = "Ctr_dotation/carburant/$1";
$route['dotation/carburant/(:any)/(:any)'] = "Ctr_dotation/carburant/$1/$2";

$route['dotation/open/(:any)'] = "Ctr_dotation/carburantOpen/$1";
$route['dotation/open/(:any)/(:any)'] = "Ctr_dotation/carburantOpen/$1/$2";

$route['dotation/transport/(:any)'] = "Ctr_dotation/transport/$1";
// new route transport
$route['dotation/transport/(:any)/(:any)'] = "Ctr_dotation/transport/$1/$2";
// new route Requisition
$route['dotation/requisition/(:any)'] = "Ctr_dotation/requisition/$1";
$route['dotation/requisition/(:any)/(:any)'] = "Ctr_dotation/requisition/$1/$2";
//end new route requisition


$route['dotation/(:any)'] = "Ctr_dotation/$1";
$route['dotation/(:any)/(:any)'] = "Ctr_dotation/$1/$2";
$route['ordre_mission'] = "Ctr_ordre_mission";
/*$route['ordre_mission/add'] = "Ctr_ordre_mission/mission/add";*/

/* samir**/

// $route['encourret'] = 'Ctr_home/encours';
// $route['verifvaliation'] = 'Ctr_home/verifierValidation';
// $route['insertvaliation'] = 'Ctr_home/insertValidation';
// $route['validationretraite'] = 'Ctr_home/retraiteValidation';
// $route['validerret'] = 'Ctr_home/valider';

/** samir*/
/**** mahfoud ***/

$route['contact'] = "Ctr_contact";


//***********budget***************
//******* connexion ************
$route['login'] = "Ctr_connexion";
$route['connexion/(:any)'] = "Ctr_connexion/$1";
$route['connexion/(:any)/(:any)'] = "Ctr_connexion/$1/$2";
$route['deconnect'] = 'Ctr_connexion/deconnect';

$route['state'] = 'Ctr_state';
$route['state/(:any)'] = 'Ctr_state/$1';
$route['state/(:any)/(:any)'] = 'Ctr_state/$1/$2';

$route['accueil'] = 'Ctr_home/index';
$route['accueil/(:any)'] = 'Ctr_home/$1';
$route['accueil/(:any)/(:any)'] = 'Ctr_home/$1/$2';
$route['accueil/(:any)/(:any)/(:any)'] = 'Ctr_home/$1/$2/$3';


$route['prolongation'] = "Ctr_prolongation";
$route['prolongation/(:any)']= "Ctr_prolongation/prolongation/$1";
$route['prolongation/(:any)/(:any)']= "Ctr_prolongation/prolongation/$1/$2";

/**** prestataire ***/

$route['prestataire/ajax/(:any)']                   = "Ctr_prestataire/$1";
$route['prestataire/etab/(:any)/(:any)']            = "Ctr_prestataire/prestataire/$1/$2";

$route['prestataire'] = "Ctr_prestataire";
$route['prestataire/(:any)'] = "Ctr_prestataire/prestataire/$1";


$route['prestataire/domaineActivite/(:any)']        = "Ctr_prestataire/Domaine_Acticite/$1";
$route['prestataire/domaineActivite/(:any)/(:any)'] = "Ctr_prestataire/Domaine_Acticite/$1/$2";

/**** prestataire ***/


/**** phase ***/
$route['phase/(:any)']= "Ctr_phase/phase/$1";
$route['phase/(:any)/(:any)']= "Ctr_phase/phase/$1/$2";
/** phase ***/

/**** bon de commande ***/
$route['bncom/(:any)/(:any)']= "Ctr_commande/commande/$1/$2";
/** bon de commande ***/



/**** marché ***/
$route['marcheTr/etab/(:any)/(:any)']= "Ctr_marche_travaux/marche/$1/$2";
$route['marcheTr/etab/(:any)']= "Ctr_marche_travaux/marche/$1";
$route['marcheTr/ajax/(:any)']= "Ctr_marche_travaux/$1";

$route['marcheFr/etab/(:any)/(:any)']= "Ctr_marche_fourniture/marche/$1/$2";
$route['marcheFr/etab/(:any)']= "Ctr_marche_fourniture/marche/$1";
$route['marcheFr/ajax/(:any)']= "Ctr_marche_fourniture/$1";
/** marché ***/


/**** statistique ***/

/** statistique ***/


/**** exercice ***/
$route['exercice']= "Ctr_exercice";
/**  exercice ***/

$route['default_controller'] = "Ctr_home";
$route['404_override'] = 'Ctr_home/error';
$route['translate_uri_dashes'] = TRUE;
