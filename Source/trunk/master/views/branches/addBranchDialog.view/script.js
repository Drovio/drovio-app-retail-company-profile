jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Close dialog
	jq(document).on("click", ".addNewBranchDialog .close_button", function(ev) {
		jq(this).trigger("dispose");
	});
	
	// Dispose dialog
	jq(document).on("branch.dialog.dispose", function() {
		jq(".addNewBranchDialog").trigger("dispose");
	});
});