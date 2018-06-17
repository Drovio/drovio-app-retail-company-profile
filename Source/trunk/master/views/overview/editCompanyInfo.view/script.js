jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Edit action
	jq(document).on("click", ".editCompanyInfo .close_ico", function() {
		// Trigger to cancel edit
		jq(document).trigger("companyinfo.cancel_edit");
	});
});