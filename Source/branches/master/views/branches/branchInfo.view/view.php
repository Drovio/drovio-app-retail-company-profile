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
use \RTL\Profile\branch;
use \RTL\Profile\company;
use \UI\Apps\APPContent;

// Create Application Content
$appContent = new APPContent();
$actionFactory = $appContent->getActionFactory();

// Get branch id
$branchID = engine::getVar("bid");

// Build the application view content
$containerID = "branchInfo".$branchID;
$appContent->build($containerID, "branchInfoContainer", TRUE);
$viewContainer = HTML::select(".branchInfo .viewContainer")->item(0);

// Get branch
$branch = new branch($branchID);
$branchInfo = $branch->info();

// Set branch header
$attr = array();
$attr['bid'] = $branchID;
$btitle = $appContent->getLiteral("company.branch.details", "hd_branchHeader", $attr, FALSE);
$bname = HTML::select(".branchInfo .hd.bname")->item(0);
HTML::innerHTML($bname, $btitle);

// Set company info rows
$infoRow = getBranchInfoRow("profile", $branchInfo['title'], "btitle");
DOM::append($viewContainer, $infoRow);

if (!empty($branchInfo['address']))
{
	$infoRow = getBranchInfoRow("address", $branchInfo['address']);
	DOM::append($viewContainer, $infoRow);
}

// Add action to edit button
$editButton = HTML::select(".branchInfo .edit")->item(0);
$attr = array();
$attr['bid'] = $branchID;
$actionFactory->setAction($editButton, $viewName = "branches/editBranchInfo", $holder = "#".$containerID.".branchInfoContainer .editFormContainer", $attr, $loading = TRUE);

// Return output
return $appContent->getReport();

function getBranchInfoRow($type, $value, $class = "")
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