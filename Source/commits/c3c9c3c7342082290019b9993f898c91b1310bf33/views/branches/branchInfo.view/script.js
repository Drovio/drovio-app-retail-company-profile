jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Edit action
	jq(document).on("branchinfo.edit", function(ev, branchID) {
		var containerID = "branchInfo" + branchID;
		jq("#" + containerID + ".branchInfoContainer .branchInfo").addClass("edit");
	});
	
	// Cancel edit action
	jq(document).on("branchinfo.cancel_edit", function(ev, branchID) {
		var containerID = "branchInfo" + branchID;
		// Remove class
		jq("#" + containerID + ".branchInfoContainer .branchInfo").removeClass("edit");
		
		// Clear edit form container contents
		jq("#" + containerID + " .editFormContainer").html("");
	});
});