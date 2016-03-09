<?php

// ---------------------------------------------------
//  Tout ce bout de code juste pour savoir sur quelle page on est !
// ---------------------------------------------------
$base_path = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
$request_uri = str_replace($base_path, "", $_SERVER['REQUEST_URI']);
$pos = strpos($request_uri, "?");
if($pos !== false)
     $request_uri = substr($request_uri, 0, $pos);
$request_uri = trim($request_uri, "/");
$uri_params = empty($request_uri) ? array() : explode('/', $request_uri);
$page = (count($uri_params) > 0) ? $uri_params[0] : "home";

?>

<!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
<!-- Contenu HTML de la page -->
<!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
<!DOCTYPE html>
<html>
<head>
    
    <title>Chronomodel</title>
    
    <meta charset="UTF-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="Chronological Modelling of Archaeological Data using Bayesian Statistics. The ChronoModel Application is intended to provide tools for constructing chronologies in archaeology in combining Events, Phases and temporal constraints.">
    <meta name="keywords" content="chronomodel, archaeology, chronology, stratigraphy, dating, mcmc, bayesian, 14C, TL/OSL, archaeomagnetism, calibration">
    <meta name="author" content="CNRS, Philippe Lanos, Anne Philippe, Helori Lanos, Philippe Dufresne">
    
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="white" />
    
    <!-- apple-touch-icon-precomposed : apple n'ajoute pas d'effet supplémentaire sur l'icon -->
    <link rel="apple-touch-icon" href="mobile/touch-icon-60-60.png" /> <!-- iPhone -->
    <link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png"> <!-- iPad -->
    <link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png"> <!-- iPhone Retina -->
    <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png"> <!-- iPad Retina -->
    <link rel="apple-touch-startup-image" href="mobile/startup.png">
    
    <link rel="shortcut icon" href="favicon.png" type="image/png">

    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="SourceSansPro/stylesheet.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" media="screen">

</head>

<body>

    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <!-- Menu principal -->
    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <nav id="header" class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a id="logo" class="navbar-brand" href="/">
                    <img src="images/logo.png" alt="Chronomodel Logo"/>
                    <span>ChronoModel</span>
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="nav-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li <?php echo (($page == 'home') ? 'class="active"' : ''); ?>><a href="home"><span>Home</span></a></li>
                    <li <?php echo (($page == 'features') ? 'class="active"' : ''); ?>><a href="features"><span>Features</span></a></li>
                    <li <?php echo (($page == 'downloads') ? 'class="active"' : ''); ?>><a href="downloads"><span>Downloads</span></a></li>
                    <li <?php echo (($page == 'documentation') ? 'class="active"' : ''); ?>><a href="documentation"><span>Documentation</span></a></li>
                    <li <?php echo (($page == 'faq') ? 'class="active"' : ''); ?>><a href="faq"><span>FAQ</span></a></li>
                    <li <?php echo (($page == 'event') ? 'class="active"' : ''); ?>><a href="event"><span>Events</span></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <!-- Contenu de la page -->
    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <div id="main-wrapper">
        
        <?php require_once(__DIR__.'/partials/'.$page.'.php') ; ?>

    </div>
    
    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <!-- Pied de page -->
    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <div id="footer1">
        <div class="container-fluid">
            <a href="http://www.agence-nationale-recherche.fr/" target="_blank">
                <img src="images/logos/anr2.jpg" alt="ANR">
            </a>
            <a href="http://www.cnrs.fr/" target="_blank">
                <img src="images/logos/cnrs.jpg" alt="CNRS">
            </a>
            <a href="http://www.lebesgue.fr" target="_blank">
                <img src="images/logos/CHL.png" alt="CHL">
                    </a>
            <a href="http://www.u-bordeaux-montaigne.fr/fr/index.html" target="_blank">
                <img src="images/logos/bordeaux.png" alt="Bordeaux">
            </a>
            <a href="http://www.math.sciences.univ-nantes.fr/" target="_blank">
                <img src="images/logos/nantes.png" alt="Nantes">
            </a>
            <a href="https://www.univ-rennes1.fr/" target="_blank">
                <img src="images/logos/rennes1.png" alt="Rennes1" height="60">
            </a>
           
        </div>
    </div>
    <div id="footer2">
        <div class="container">
            Copyright &copy; CNRS 2015
        </div>
    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <!-- Dépendances javascript -->
    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <!-- Code pour ouvrir les dialogues de téléchargement -->
    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <script>
    $(function(){
        $(".download-btn").click(function(e){
            e.preventDefault();
            var version = $(this).attr("version");
            var os = $(this).attr("os");
            
            $("#version").attr("value", version);
            $("#os").attr("value", os);

            $("#dialog").modal("show");
        });

        $(".release-notes .title").click(function(){
            var elt = $(this).closest(".release-notes");
            elt.toggleClass("opened");
        });
    });
    </script>

</body>
