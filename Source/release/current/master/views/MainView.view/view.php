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
importer::import("UI", "Forms");

// Import APP Packages
//#section_end#
//#section#[view]
use \UI\Apps\APPContent;
use \RTL\Profile\company;

// Create Application Content
$appContent = new APPContent($appID);
$actionFactory = $appContent->getActionFactory();

// Build the application view content
$appContent->build("", "companyProfileApplicationContainer", TRUE);

// Set menu item navigation
$navitems = array();
$navitems["overview"] = "overview/companyOverview";
$navitems["branches"] = "branches/branchesOverview";
$navitems["sunits"] = "storage/storageUnitsOverview";
foreach ($navitems as $navitem => $viewName)
{
	// Get menu item
	$menuItem = HTML::select(".companyProfileApplication .navbar .menu .menu_item.".$navitem)->item(0);
	
	// Set static navigation
	$appContent->setStaticNav($menuItem, $ref = "", $targetcontainer = "", $targetgroup = "", $navgroup = "rnavgroup", $display = "none");
	
	// Load view
	$actionFactory->setAction($menuItem, $viewName, ".companyProfileApplication .mainContainer .app-mainContent", array(), $loading = TRUE);
}

// Register team to company (if not already)
company::register();

$allCompanyInfo = company::info();
$teamInfo = $allCompanyInfo['team'];

// Set sidebar logo (if exists)
if (!empty($teamInfo['profile_image_url']))
{
	$clogo = HTML::select(".companyProfileApplication .clogo")->item(0);
	$img = DOM::create("img");
	DOM::attr($img, "src", $teamInfo['profile_image_url']);
	DOM::append($clogo, $img);
}


// Load company overview
$mHolder = HTML::select(".companyProfileApplication .mainContainer .app-mainContent")->item(0);
$mViewContent = $appContent->loadView("overview/companyOverview");
DOM::append($mHolder, $mViewContent);

// Return output
return $appContent->getReport();
//#section_end#
?>