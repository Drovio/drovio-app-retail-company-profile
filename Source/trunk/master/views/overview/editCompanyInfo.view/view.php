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
use \RTL\Profile\company;
use \UI\Apps\APPContent;
use \UI\Forms\templates\simpleForm;
use \UI\Forms\formReport\formNotification;

// Create Application Content
$appContent = new APPContent($appID);
$actionFactory = $appContent->getActionFactory();

if (engine::isPost())
{
	// Update company information
	company::update($_POST['cname'], $_POST['cdesc']);
	
	$succFormNtf = new formNotification();
	$succFormNtf->build($type = formNotification::SUCCESS, $header = TRUE, $timeout = FALSE, $disposable = FALSE);
	
	// Add action to reload info
	$succFormNtf->addReportAction($type = "companyinfo.reload", $value = "");
	
	// Notification Message
	$errorMessage = $succFormNtf->getMessage("success", "success.save_success");
	$succFormNtf->append($errorMessage);
	return $succFormNtf->getReport();
}

// Build the application view content
$appContent->build("", "editCompanyInfoContainer", TRUE);
$formContainer = HTML::select(".editCompanyInfo .formContainer")->item(0);

// Build form
$form = new simpleForm();
$editForm = $form->build()->engageApp("overview/editCompanyInfo")->get();
DOM::append($formContainer, $editForm);


// Get company info
$allCompanyInfo = company::info();
$companyInfo = $allCompanyInfo['company'];

// Basic Info
$title = $appContent->getLiteral("company.info.details.edit", "hd_basicInfo");
$group = getEditGroup($title, FALSE);
$form->append($group);

$title = $appContent->getLiteral("company.info.details.edit", "lbl_companyName");
$ph = $appContent->getLiteral("company.info.details.edit", "lbl_companyName", array(), FALSE);
$fRow = getSimpleFormRow($form, $title, $companyInfo['name'], $ph, $name = "cname", $inputType = "text", $required = TRUE);
DOM::append($group, $fRow);

$title = $appContent->getLiteral("company.info.details.edit", "lbl_companyDesc");
$ph = $appContent->getLiteral("company.info.details.edit", "lbl_companyDesc", array(), FALSE);
$fRow = getTextareaFormRow($form, $title, $companyInfo['description'], $ph, $name = "cdesc");
DOM::append($group, $fRow);

// Set action to switch to edit info
$appContent->addReportAction($type = "companyinfo.edit", $value = "");

// Return output
return $appContent->getReport();

function getEditGroup($title, $newButton = TRUE)
{
	$group = DOM::create("div", "", "", "editGroup");
	
	// Add new button
	if ($newButton)
	{
		$create_new = DOM::create("div", "", "", "ico create_new");
		DOM::append($group, $create_new);
	}
	
	// Header
	$hd = DOM::create("h3", $title, "", "ghd");
	DOM::append($group, $hd);
	
	return $group;
}

function getSimpleFormRow($form, $labelTitle, $valueValue, $ph, $name, $inputType = "text", $required = FALSE)
{
	// Create a new row
	$fRow = DOM::create("div", "", "", "frow");
	
	$input = $form->getInput($type = $inputType, $name, $value = $valueValue, $class = "finput", $autofocus = FALSE, $required);
	DOM::attr($input, "placeholder", $ph);
	if (($inputType == "radio" || $inputType == "checkbox") && $valueValue == 1)
		DOM::attr($input, "checked", "checked");
	$inputID = DOM::attr($input, "id");
	$label = $form->getLabel($labelTitle, $for = $inputID, $class = "flabel");
	
	// Append to frow
	DOM::append($fRow, $label);
	DOM::append($fRow, $input);
	
	return $fRow;
}

function getTextareaFormRow($form, $labelTitle, $valueValue, $ph, $name, $required = FALSE)
{
	// Create a new row
	$fRow = DOM::create("div", "", "", "frow");
	
	$input = $form->getTextarea($name, $value = $valueValue, $class = "finput", $autofocus = FALSE, $required);
	DOM::attr($input, "placeholder", $ph);
	if (($inputType == "radio" || $inputType == "checkbox") && $valueValue == 1)
		DOM::attr($input, "checked", "checked");
	$inputID = DOM::attr($input, "id");
	$label = $form->getLabel($labelTitle, $for = $inputID, $class = "flabel");
	
	// Append to frow
	DOM::append($fRow, $label);
	DOM::append($fRow, $input);
	
	return $fRow;
}
//#section_end#
?>