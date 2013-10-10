/*! Copyright (c) 2012 Mieszko Domagała (http://miecho.pl)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version: 1.0.0
 * 
 * Requires: 1.8.1+
 */
 
(function($){
	$.fn.extend({
		clickOut: function(onClickOut) {
			return this.each(function() {
				var $object = $(this);
				$(document).click(function(e) {
					if ($(e.target).parents($object).length!=0 && !$(e.target).is($object)) {
						if (onClickOut) onClickOut($(this));
					}
				});
			});
        }
    });
})(jQuery);