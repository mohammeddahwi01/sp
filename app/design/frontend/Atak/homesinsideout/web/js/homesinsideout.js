define([
		"jquery"
	],
	function($) {
		"use strict";
		
		// Fix Main menu custom links
		$('.navigation > ul > li').addClass('level0');
		
		var $blog_item = $('.navigation > ul > li.nav-3');
		$blog_item.insertAfter( $blog_item.next() );
		
		// adjust main menu drpodowns
		$('.level0.submenu').each(function() {
			var dd_count = $(this).find('.level1.submenu').length;
			if ( dd_count > 4 )
				dd_count = 4;
			if ( dd_count )
				$(this).addClass('columns columns-' + dd_count);
		});
		
		// top search form toggle
		$('#search_mini_form_toggle').click(function () {
			$(this).toggleClass('close');
			$('#search_mini_form').toggle();
		});
		
		
	}
);