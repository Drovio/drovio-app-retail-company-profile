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
use \RTL\Profile\company;
use \UI\Apps\APPContent;

// Create Application Content
$appContent = new APPContent();
$actionFactory = $appContent->getActionFactory();

// Build the application view content
$appContent->build("", "companyInfoContainer", TRUE);
$viewContainer = HTML::select(".companyInfo .viewContainer")->item(0);

// Get company info
$allCompanyInfo = company::info();
$companyInfo = $allCompanyInfo['company'];

// Set company info rows
$infoRow = getCompanyInfoRow("profile", $companyInfo['name']);
DOM::append($viewContainer, $infoRow);

$infoRow = getCompanyInfoRow("cinfo", $companyInfo['description']);
DOM::append($viewContainer, $infoRow);


// Add action to edit button
$editButton = HTML::select(".companyInfo .edit")->item(0);
$actionFactory->setAction($editButton, $viewName = "overview/editCompanyInfo", $holder = ".companyInfoContainer .editFormContainer", $attr = array(), $loading = TRUE);

// Return output
return $appContent->getReport();

function getCompanyInfoRow($type, $value)
{
	$infoRow = DOM::create("div", "", "", "infoRow");
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