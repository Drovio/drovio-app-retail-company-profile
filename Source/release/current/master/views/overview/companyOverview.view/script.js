jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Reload contact info
	jq(document).on("companyinfo.reload", function() {
		jq("#companyInfoViewContainer").trigger("reload");
	});
});