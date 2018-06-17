jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Reload branch info
	jq(document).on("sunitinfo.reload", function(ev, stUnitID) {
		var containerID = "stunit_" + stUnitID + "_infoContainer";
		jq("#" + containerID ).trigger("reload");
	});
	
	// Search for branches
	jq(document).on("keyup", ".stUnitsOverview .searchContainer .searchInput", function() {
		var search = jq(this).val();
		if (search == "")
			return jq(".unitsList .csection.unit_info").show();
			
		// Create the regular expression
		var regEx = new RegExp(jq.map(search.trim().split(' '), function(v) {
			return '(?=.*?' + v + ')';
		}).join(''), 'i');
		
		// Select all project boxes, hide and filter by the regex then show
		jq(".unitsList .csection.unit_info").hide().find(".stitle .ivalue").filter(function() {
			return regEx.exec(jq(this).text());
		}).each(function() {
			jq(this).closest(".unit_info").show();
		});
	});
});