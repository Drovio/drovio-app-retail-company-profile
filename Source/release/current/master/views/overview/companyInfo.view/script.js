jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Edit action
	jq(document).on("companyinfo.edit", function() {
		jq(".companyInfoContainer .companyInfo").addClass("edit");
	});
	
	// Cancel edit action
	jq(document).on("companyinfo.cancel_edit", function() {
		// Remove class
		jq(".companyInfoContainer .companyInfo").removeClass("edit");
		
		// Clear edit form container contents
		jq(".editFormContainer").html("");
	});
});