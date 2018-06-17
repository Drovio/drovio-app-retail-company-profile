jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Edit action
	jq(document).on("click", ".editUnitInfo .close_ico", function() {
		// Trigger to cancel edit
		var stUnitID = jq(this).closest(".editBranchInfoContainer").data("suid");
		jq(document).trigger("sunitinfo.cancel_edit", stUnitID);
	});
});