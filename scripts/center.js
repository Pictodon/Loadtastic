$(document).ready(function() {
	jQuery.fn.center = function () {
	    this.css('position', 'absolute');
	    this.css('top', $(window).height() / 2 - $(this).outerHeight() / 2);
	    this.css("left", $(window).width() / 2 - $(this).outerWidth() / 2);
	    return this;
	}

	$('#container').center();
});