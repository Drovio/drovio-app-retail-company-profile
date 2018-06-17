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
use \RTL\Profile\stUnit;
use \RTL\Profile\company;
use \UI\Apps\APPContent;

// Create Application Content
$appContent = new APPContent();
$actionFactory = $appContent->getActionFactory();

// Get unit id
$stUnitID = engine::getVar("suid");

// Build the application view content
$containerID = "stUnitInfo".$stUnitID;
$appContent->build($containerID, "stUnitInfoContainer", TRUE);
$viewContainer = HTML::select(".stUnitInfo .viewContainer")->item(0);

// Get storage unit
$storage = new stUnit($stUnitID);
$stUnitInfo = $storage->info();

// Set storage unit header
$attr = array();
$attr['suid'] = $stUnitID;
$btitle = $appContent->getLiteral("company.sunits.details", "hd_sunitHeader", $attr, FALSE);
$bname = HTML::select(".stUnitInfo .hd.suname")->item(0);
HTML::innerHTML($bname, $btitle);

// Set storage unit info rows
$infoRow = getUnitInfoRow("profile", $stUnitInfo['title'], "stitle");
DOM::append($viewContainer, $infoRow);

if (!empty($stUnitInfo['description']))
{
	$infoRow = getUnitInfoRow("suinfo", $stUnitInfo['description']);
	DOM::append($viewContainer, $infoRow);
}

// Add action to edit button
$editButton = HTML::select(".stUnitInfo .edit")->item(0);
$attr = array();
$attr['suid'] = $stUnitID;
$actionFactory->setAction($editButton, $viewName = "storage/editUnitInfo", $holder = "#".$containerID.".stUnitInfoContainer .editFormContainer", $attr, $loading = TRUE);

// Return output
return $appContent->getReport();

function getUnitInfoRow($type, $value, $class = "")
{
	$infoRow = DOM::create("div", "", "", "infoRow");
	HTML::addClass($infoRow, $class);
	HTML::addClass($infoRow, $type);
	
	// Create ico
	$ico = DOM::create("div", "", "", "ico");
	DOM::append($infoRow, $ico);
	
	$value = DOM::create("div", $value, "", "ivalue");
	DOM::append($infoRow, $value);
	
	return $infoRow;
}
//#section_end#
?>