jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Reload branch info
	jq(document).on("branchinfo.reload", function(ev, branchID) {
		var containerID = "branch_b" + branchID + "_infoContainer";
		jq("#" + containerID ).trigger("reload");
	});
	
	// Search for branches
	jq(document).on("keyup", ".branchesOverview .searchContainer .searchInput", function() {
		var search = jq(this).val();
		if (search == "")
			return jq(".branchList .csection.branch_info").show();
			
		// Create the regular expression
		var regEx = new RegExp(jq.map(search.trim().split(' '), function(v) {
			return '(?=.*?' + v + ')';
		}).join(''), 'i');
		
		// Select all project boxes, hide and filter by the regex then show
		jq(".branchList .csection.branch_info").hide().find(".btitle .ivalue").filter(function() {
			return regEx.exec(jq(this).text());
		}).each(function() {
			jq(this).closest(".branch_info").show();
		});
	});
});