jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Edit action
	jq(document).on("sunitinfo.edit", function(ev, stUnitID) {
		var containerID = "stUnitInfo" + stUnitID;
		jq("#" + containerID + ".stUnitInfoContainer .stUnitInfo").addClass("edit");
	});
	
	// Cancel edit action
	jq(document).on("sunitinfo.cancel_edit", function(ev, stUnitID) {
		var containerID = "stUnitInfo" + stUnitID;
		// Remove class
		jq("#" + containerID + ".stUnitInfoContainer .stUnitInfo").removeClass("edit");
		
		// Clear edit form container contents
		jq("#" + containerID + " .editFormContainer").html("");
	});
});