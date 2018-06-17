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
importer::import("RTL", "Profile");
importer::import("UI", "Apps");

// Import APP Packages
//#section_end#
//#section#[view]
use \UI\Apps\APPContent;
use \RTL\Profile\company;

// Create Application Content
$appContent = new APPContent();
$actionFactory = $appContent->getActionFactory();

// Build the application view content
$appContent->build("", "companyOverviewContainer");

// Contact finances section
$mainContent = HTML::select(".companyOverview .mainContent")->item(0);
$section = DOM::create("div", "", "", "csection company_info");
$appContent->append($section);

// Load customer finances
$viewContainer = $appContent->getAppViewContainer($viewName = "overview/companyInfo", $attr = array(), $startup = FALSE, $containerID = "companyInfoViewContainer", $loading = FALSE, $preload = TRUE);
DOM::append($section, $viewContainer);

// Return output
return $appContent->getReport();
//#section_end#
?>