jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Reload branch list
	jq(document).on("sunitlist.reload", function(ev, branchID) {
		jq("#unitsListContainer").trigger("reload");
	});
});