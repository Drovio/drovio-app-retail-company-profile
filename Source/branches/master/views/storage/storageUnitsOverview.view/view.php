<?php
//#section#[header]
// Use Important Headers
use \API\Platform\importer;
use \API\Platform\engine;
use \Exception;

// Check Platform Existance
if (!defined('_RB_PLATFORM_')) throw new Exception("Platform is not defined!");

// Import DOM, HTML
importer::import("UI", "Html", "DOM");
importer::import("UI", "Html", "HTML");

use \UI\Html\DOM;
use \UI\Html\HTML;

// Import application for initialization
importer::import("AEL", "Platform", "application");
use \AEL\Platform\application;

// Increase application's view loading depth
application::incLoadingDepth();

// Set Application ID
$appID = 46;

// Init Application and Application literal
application::init(46);
// Secure Importer
importer::secure(TRUE);

// Import SDK Packages
importer::import("UI", "Apps");

// Import APP Packages
//#section_end#
//#section#[view]
use \UI\Apps\APPContent;

// Create Application Content
$appContent = new APPContent();
$actionFactory = $appContent->getActionFactory();

// Build the application view content
$appContent->build("", "stUnitsOverviewContainer", TRUE);
$unitsListContainer = HTML::select(".stUnitsOverview .unitsListContainer")->item(0);

// Load branch list
$viewContainer = $appContent->getAppViewContainer($viewName = "storage/unitsList", $attr = array(), $startup = TRUE, $containerID = "unitsListContainer", $loading = FALSE, $preload = TRUE);
DOM::append($unitsListContainer, $viewContainer);

// Add branch dialog
$addBranchButton = HTML::select(".stUnitsOverview .bbutton.add_stunit")->item(0);
$actionFactory->setAction($addBranchButton, "storage/addStUnitDialog");

// Return output
return $appContent->getReport();
//#section_end#
?>