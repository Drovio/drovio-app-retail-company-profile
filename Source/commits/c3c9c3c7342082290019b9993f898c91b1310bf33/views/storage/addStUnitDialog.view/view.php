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
importer::import("UI", "Presentation");

// Import APP Packages
//#section_end#
//#section#[view]
use \UI\Apps\APPContent;
use \UI\Forms\templates\simpleForm;
use \UI\Forms\formReport\formNotification;
use \UI\Forms\formReport\formErrorNotification;
use \UI\Presentation\popups\popup;

use \RTL\Profile\stUnit;

$appContent = new APPContent();
$actionFactory = $appContent->getActionFactory();

if (engine::isPost())
{
	// Check if something is empty
	$has_error = FALSE;
	
	// Create form Notification
	$errFormNtf = new formErrorNotification();
	$formNtfElement = $errFormNtf->build()->get();
	
	// Check contact name
	if (empty($_POST['stitle']))
	{
		$has_error = TRUE;
		
		// Header
		$err_header = $appContent->getLiteral("company.sunits.create", "lbl_sunit_title");
		$err = $errFormNtf->addHeader($err_header);
		$errFormNtf->addDescription($err, $errFormNtf->getErrorMessage("err.required"));
	}
	
	// If error, show notification
	if ($has_error)
		return $errFormNtf->getReport();
	
	// Create new storage unit
	$storage = new stUnit();
	$status = $storage->create($_POST['stitle'], $_POST['sdesc']);
	
	// If there is an error in creating the library, show it
	if (!$status)
	{
		$err_header = $appContent->getLiteral("company.sunits.create", "lbl_create");
		$err = $errFormNtf->addHeader($err_header);
		$errFormNtf->addDescription($err, DOM::create("span", "Error creating storage unit..."));
		return $errFormNtf->getReport();
	}
	
	$succFormNtf = new formNotification();
	$succFormNtf->build($type = formNotification::SUCCESS, $header = TRUE, $timeout = FALSE, $disposable = FALSE);
	
	// Reload branch list
	$succFormNtf->addReportAction($type = "sunitslist.reload", $value = "");
	// Dispose dialog
	$succFormNtf->addReportAction($type = "sunits.dialog.dispose", $value = "");
	
	// Notification Message
	$errorMessage = $succFormNtf->getMessage("success", "success.save_success");
	$succFormNtf->append($errorMessage);
	return $succFormNtf->getReport();
}

// Build the application view content
$appContent->build("", "addNewStUnitDialog", TRUE);

$formContainer = HTML::select(".addNewStUnitDialog .formContainer")->item(0);
// Build form
$form = new simpleForm();
$imageForm = $form->build($action = "", $defaultButtons = FALSE)->engageApp("storage/addStUnitDialog")->get();
DOM::append($formContainer, $imageForm);

// Branch name
$ph = $appContent->getLiteral("company.sunits.create", "lbl_sunit_title", array(), FALSE);
$input = $form->getInput($type = "text", $name = "stitle", $value = "", $class = "bginp", $autofocus = TRUE, $required = TRUE);
DOM::attr($input, "placeholder", $ph);
$form->append($input);

$ph = $appContent->getLiteral("company.sunits.create", "lbl_sunit_desc", array(), FALSE);
$input = $form->getInput($type = "text", $name = "sdesc", $value = "", $class = "bginp", $autofocus = FALSE, $required = FALSE);
DOM::attr($input, "placeholder", $ph);
$form->append($input);

$title = $appContent->getLiteral("company.sunits.create", "lbl_create");
$create_btn = $form->getSubmitButton($title, $id = "btn_create", $name = "");
$form->append($create_btn);

// Create popup
$pp = new popup();
$pp->type($type = popup::TP_PERSISTENT, $toggle = FALSE);
$pp->background(TRUE);
$pp->build($appContent->get());

return $pp->getReport();
//#section_end#
?>