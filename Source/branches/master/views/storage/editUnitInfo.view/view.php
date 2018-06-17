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
use \RTL\Profile\stUnit;
use \UI\Apps\APPContent;
use \UI\Forms\templates\simpleForm;
use \UI\Forms\formReport\formNotification;

// Create Application Content
$appContent = new APPContent();
$actionFactory = $appContent->getActionFactory();

// Get unit id to edit
$stUnitID = engine::getVar("suid");
$storage = new stUnit($stUnitID);
if (engine::isPost())
{
	// Create notification
	$succFormNtf = new formNotification();
	$succFormNtf->build($type = formNotification::SUCCESS, $header = TRUE, $timeout = FALSE, $disposable = FALSE);
	
	if ($_POST['sudelete'])
	{
		// Remove storage unit
		$storage->remove();
		
		// Reload storage unit list
		$succFormNtf->addReportAction($type = "sunitlist.reload", $value = "");
	}
	else
	{
		// Update storage unit information
		$storage->update($_POST['stitle'], $_POST['sdesc']);
		
		// Reload storage unit info
		$succFormNtf->addReportAction($type = "sunitinfo.reload", $value = $stUnitID);
	}
	
	// Notification Message
	$errorMessage = $succFormNtf->getMessage("success", "success.save_success");
	$succFormNtf->append($errorMessage);
	return $succFormNtf->getReport();
}

// Build the application view content
$appContainer = $appContent->build("", "editUnitInfoContainer", TRUE)->get();
$formContainer = HTML::select(".editUnitInfo .formContainer")->item(0);

// Set storage unit sid
DOM::data($appContainer, "suid", $stUnitID);

// Build form
$form = new simpleForm();
$editForm = $form->build()->engageApp("storage/editUnitInfo")->get();
DOM::append($formContainer, $editForm);

// Branch id
$input = $form->getInput($type = "hidden", $name = "suid", $value = $stUnitID, $class = "", $autofocus = FALSE, $required = FALSE);
$form->append($input);

// Get storage unit info
$stUnitInfo = $storage->info();

// Basic Info
$attr = array();
$attr['suid'] = $branchID;
$btitle = $appContent->getLiteral("company.sunits.details.edit", "hd_basicInfo", $attr, FALSE);
$group = getEditGroup($btitle, FALSE);
$form->append($group);

$title = $appContent->getLiteral("company.sunits.details.edit", "lbl_unitTitle");
$ph = $appContent->getLiteral("company.sunits.details.edit", "lbl_unitTitle", array(), FALSE);
$fRow = getSimpleFormRow($form, $title, $stUnitInfo['title'], $ph, $name = "stitle", $inputType = "text", $required = TRUE);
DOM::append($group, $fRow);

$title = $appContent->getLiteral("company.sunits.details.edit", "lbl_unitDesc");
$ph = $appContent->getLiteral("company.sunits.details.edit", "lbl_unitDesc", array(), FALSE);
$fRow = getSimpleFormRow($form, $title, $stUnitInfo['description'], $ph, $name = "sdesc", $inputType = "text");
DOM::append($group, $fRow);

$title = $appContent->getLiteral("company.sunits.details.edit", "lbl_deleteUnit");
$fRow = getSimpleFormRow($form, $title, $value = "", $ph = "", $name = "sudelete", $inputType = "checkbox");
DOM::append($group, $fRow);

// Set action to switch to edit info
$appContent->addReportAction($type = "sunitinfo.edit", $value = $stUnitID);

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
//#section_end#
?>