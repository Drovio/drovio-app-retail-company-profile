jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Reload branch list
	jq(document).on("branchlist.reload", function(ev, branchID) {
		jq("#branchListContainer").trigger("reload");
	});
});