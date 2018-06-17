jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Edit action
	jq(document).on("click", ".editBranchInfo .close_ico", function() {
		// Trigger to cancel edit
		var branchID = jq(this).closest(".editBranchInfoContainer").data("bid");
		jq(document).trigger("branchinfo.cancel_edit", branchID);
	});
});