<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *
 * Captcha pages or ids
 */
$config['captcha_page_contact'] = 'contact';
$config['captcha_page_activation_form'] = 'activation_form';
$config['captcha_page_forget_password'] = 'forget_pass';
$config['captcha_page_reset_password'] = 'reset_pass';
$config['captcha_page_signup'] = 'signup';
$config['statuss'] = array(
    'Année Scolaire En cours' => 'Année Scolaire En cours',
    'Admis' => 'Admis',
    'Racheté' => 'Racheté',
    'Rattrapage' => 'Rattrapage',
    'Exclut' => 'Exclut',
    'Doublant' => 'Doublant'
);
$config['group'] = array();
foreach (range('A', 'Z') as $i)
    $config['group'][$i] = $i;
//$config['group'] = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

$config['header_nav_1'] = array(
    "Enseignants" => array(
        "title" => "Enseignants",
         "titleA" => "Teachers",
        "url" => "connexion/enseignants"
    ),
    "Étudiants" => array(
        "title" => "Étudiants",
        "titleA" => "Students",
        "url" => "connexion/etudiants"
    ),
    "Parents" => array(
        "title" => "Parents",
        "titleA" => "Parents",
        "url" => "connexion/parents", //site_url('orders/validate_order'),
    ),
    "International" => array(
        "title" => "International",
        "titleA" => "Foreigns",
        "url" => "pages/page/international"
    ),
//    "Lauréats" => array(
//        "title" => "Lauréats",
//        "url" => "pages/page/laureats.html"
//    ),
//    "Visiteurs" => array(
//        "title" => "Visiteurs",
//        "url" => "pages/page/visiteurs.html"
//    ),
    "Associations" => array(
        "title" => "Associations",
        "titleA" => "Associations",
        "url" => "associations/index.html",
		"sub" => array(
            "Association Etudiants" => array(
                "title" => "Association Etudiants",
                "titleA" => "Association Etudiants",
                "url" => "associations/etudiant.html"
            ),
			"Association Professionnelle" => array(
                "title" => "Association Professionnelle",
                "titleA" => "Association Professionnelle",
                "url" => "associations/enseignant.html"
            ),
		)	
    ),
    "Administration" => array(
        "title" => "Administration",
        "titleA" => "Administration",
        "url" => "connexion/admin"
    )
);
$config['header_nav_2'] = array(
    "Présentation" => array(
        "title" => "Présentation",
        "titleA" => "PrésentationA",
        "url" => "pages/page/iav-presentation.html"
    ),
    "Écoles_de_formation " => array(
        "title" => "Écoles de formation",
        "titleA" => "Training Schools",
        "url" => "", //site_url('orders/validate_order'),
        "sub" => array(
            "APESA" => array(
                "title" => "APESA",
                "titleA" => "APESA",
                "url" => "pages/page/apesa"
            ),
            "Filières" => array(
                "title" => "Filières",
                "titleA" => "channels",
                "url" => "filieres"
            ),
            "Masters" => array(
                "title" => "Masters",
                "titleA" => "Masters",
                "url" => "pages/page/masters"
            ),
            "École_Doctorale" => array(
                "title" => "École Doctorale",
                "titleA" => "Doctoral School",
                "url" => "pages/page/ecole-doc"
            ),
            "CEDOC" => array(
                "title" => "CEDOC",
                "titleA" => "CEDOC",
                "url" => "pages/page/cedoc"
            ),
            "Formation_continue" => array(
                "title" => "Formation continue",
                "titleA" => "continuing education",
                "url" => "pages/page/formation-continue"
            )
        )
    ),
    "Corps_professoral" => array(
        "title" => "Corps professoral",
          "titleA" => "Corps professoral",
        "url" => "profile.html"
    ),
    "Recherche" => array(
        "title" => "Recherche & Coopération",
        "titleA" => "Recherche & Coopération",
        "url" => "pages/page/les-recherches"
    ),
   
    "Clinique_véto" => array(
        "title" => "Clinique véto",
        "titleA" => "vet clinic",
        "url" => "pages/page/clinique-veto"
    ),
    "Laboratoires_de_service " => array(
        "title" => "Laboratoires de service",
        "titleA" => "Laboratory service",
        "url" => "",
        "sub" => array(
            "Labo_sol" => array(
                "title" => "Labo sol",
                "titleA" => "Labo sol",
                "url" => "pages/page/labo-sol"
            ),
            "Labo_IAA" => array(
                "title" => "Labo IAA",
                "titleA" => "Labo IAA",
                "url" => "pages/page/labo-iaa"
            ),
            "Hall_Technologie" => array(
                "title" => "Hall Technologie",
                "titleA" => "Hall Technologie",
                "url" => "pages/page/hall-tech"
            ),
            "CEFEMA" => array(
                "title" => "CEFEMA",
                "titleA" => "CEFEMA",
                "url" => "pages/page/labo-cefema"
            )
        )
    )
);


//nouveau modification
$config['header_nav_lg'] = array(
"FR" => array(
        "title" => "FR",
        "url" => "pages/page/iav-presentation.html"
    ),
    "EN" => array(
        "title" => "EN",
        "url" => "pages/page/iav-presentation.html"
    ),
);
$config['header_nav_3'] = array(


    "Actualités" => array(
        "title" => "Actualités",
        "titleA" => "NEWS",
        "url" => "news"
    ),
    
//    "Revues" => array(
//        "title" => "Revues",
//        "url" => "pages/page/revus"
//    ),
    "Ressources_et_Publications" => array(
        "title" => "Ressources et Publications ",
         "titleA" => "Resources and Publications",
        "url" => "",
        "sub" => array(
            "Centre_Documentation_Agricole" => array(
                "title" => "Centre Documentation Agricole",
                "titleA" => "Agricultural Documentation Centre",
                "url" => "pages/page/cda"
            )/*,
            "Publication" => array(
                "title" => "Publications",
                "titleA" => "Publications",
                "url" => "pages/page/publication"
            )*/,
            "Revues" => array(
                "title" => "Revues",
                "titleA" => "reviews",
                "url" => "pages/page/revus"
            )
        )
    ),
    "Communication" => array(
        "title" => "Communications",
        "titleA" => "Communications",
        "url" => "",
        "sub" => array(
            "Presentation" => array(
                "title" => "Présentation",
                "titleA" => "Présentation",
                "url" => "pages/page/communication-presentation"
            ),
            "Media" => array(
                 "title" => "Photothèque et Vidéothèque",
                 "titleA" => "Photo and Video Library",
                 "url" => "pages/page/medias"
            ),
            "MediaSociaux" => array(
                "title" => "Média sociaux",
                "titleA" => "Social media",
                "url" => "pages/page/medias-sociaux"
            ),
			
            "Blog" => array(
                "title" => "BLOG",
                "titleA" => "BLOG",
                "url" => "blog/"
            )
			
        )
    ),
     "Contact" => array(
        "title" => "Contact",
        "titleA" => "Contact",
        "url" => "contact"
    )
);

$config['header_nav_4'] = array(

//    "Revues" => array(
//        "title" => "Revues",
//        "url" => "pages/page/revus"
//    ),
    "Gouvernance" => array(
        "title" => "Gouvernance",
         "titleA" => "Gouvernance",
        "url" => "",
        "sub" => array(
           
            "Organisation" => array(
                "title" => "Organisation",
                "titleA" => "Organisation",
                "url" => "pages/page/Organisation"
            ),
             "Procédures" => array(
                "title" => "Procédures",
                "titleA" => "Procédures",
                "url" => "pages/page/procedures"
            )
           
        )
    ),
    "Espace Etudiant" => array(
        "title" => "Espace Etudiant",
         "titleA" => "Espace Etudiant",
        "url" => "",
        "sub" => array(
           
            "Réglements IAV" => array(
                "title" => "Réglements IAV",
                "titleA" => "Réglements IAV",
                "url" => "pages/page/Reglementsiav"
            ),
             "Résultats Académiques" => array(
                "title" => "Résultats Académiques",
                "titleA" => "Résultats Académiques",
                "url" => "pages/page/ResultatsAcademiques"
            ),
            "Offre Bourse" => array(
                "title" => "Offre Bourse",
                "titleA" => "Offre Bourse",
                "url" => "pages/page/OffreBourse"
            ),
              "Offre emploi" => array(
                "title" => "Offre emploi",
                "titleA" => "Offre emploi",
                "url" => "pages/page/OffreEmploi"
            ),
            "Services en ligne" => array(
                "title" => "Services en ligne",
                "titleA" => "Services en ligne",
                "url" => "pages/page/ServicesEnLigne"
            ),
            
            
           
        )
    ),
    
    "CDA" => array(
        "title" => "CDA",
         "titleA" => "CDA",
        "url" => "",
        "sub" => array(
           
            "Revues en ligne" => array(
                "title" => "Revues en ligne",
                "titleA" => "Revues en ligne",
                "url" => "pages/page/RevuesEnLigne",
                
            )
               
        )
    )
);

