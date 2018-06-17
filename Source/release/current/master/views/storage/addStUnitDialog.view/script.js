jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Close dialog
	jq(document).on("click", ".addNewStUnitDialog .close_button", function(ev) {
		jq(this).trigger("dispose");
	});
	
	// Dispose dialog
	jq(document).on("sunits.dialog.dispose", function() {
		jq(".addNewStUnitDialog").trigger("dispose");
	});
});