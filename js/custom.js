/*
  Version: 1.0
  Author: Jilani Ahmed
  Website: https://wpninjadevs.com/
*/

;(function($) {
 
	"use strict";

	$(document).ready(function(){

		/**
		 * Top Offer countdown timer
		 */
		let topDeal = $('#likhun-countdown').attr('offerDate');

		if( topDeal ){
			// Set the date we're counting down to
			let EidcountDownDate = new Date(topDeal).getTime();

			// Update the count down every 1 second
			let x = setInterval(function() {

				// Get today's date and time
				let nowDate = new Date().getTime();

				// Find the remainDate between nowDate and the count down date
				let remainDate = EidcountDownDate - nowDate;

				// Time calculations for days, hours, minutes and seconds
				let days = Math.floor(remainDate / (1000 * 60 * 60 * 24));
				let hours = Math.floor((remainDate % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				let minutes = Math.floor((remainDate % (1000 * 60 * 60)) / (1000 * 60));
				let seconds = Math.floor((remainDate % (1000 * 60)) / 1000);

				// Display the result in the element with id="likhun-countdown"
				if( document.getElementById("likhun-countdown") ){

					document.getElementById("likhun-countdown").innerHTML = days + "<span class='day'>d</span> " + hours + "<span class='hour'>h</span> "
					+ minutes + "<span class='min'>m</span>" + seconds + "<span class='sec'>s</span>";

				}
				// If the count down is finished, write some text
				if (remainDate < 0) {
					clearInterval(x);
					document.getElementById("likhun-countdown").innerHTML = ""; // EXPIRED
				}		

			}, 1000);
		} // End countdown timer

		/**
		 * Set se for alert messages
		 */			
		 if( $.cookie ){
			$('.likhun-alert').on( 'click', function( e ){
				// Do not perform default action when button is clicked
				e.preventDefault();	
				/* If you just want the cookie for a session don't provide an expires ( expires: 1,  )
				Set the path as root, so the cookie will be valid across the whole site */
				$.cookie('likhun-alert', 'closed', { path: '/' });	
			});
		
			// Check if alert has been closed
			if( $.cookie('likhun-alert') === 'closed' ){	
				$('.alert').hide();	
			}
		}

		/**
		 * Scroll to top button
		 */
		var scrolltotop={
			//startline: Integer. Number of pixels from top of doc scrollbar is scrolled before showing control
			//scrollto: Keyword (Integer, or "Scroll_to_Element_ID"). How far to scroll document up when control is clicked on (0=top).
			setting: {startline:100, scrollto: 0, scrollduration:1000, fadeduration:[500, 100]},
			controlHTML: '<i class="bi bi-arrow-up backtotop backtotop"></i>', //HTML for control, which is auto wrapped in DIV w/ ID="topcontrol"
			controlattrs: {offsetx:0, offsety:105}, //offset of control relative to right/ bottom of window corner
			anchorkeyword: '#top', //Enter href value of HTML anchors on the page that should also act as "Scroll Up" links

			state: {isvisible:false, shouldvisible:false},

			scrollup:function(){
				if (!this.cssfixedsupport) //if control is positioned using JavaScript
					this.$control.css({opacity:0}) //hide control immediately after clicking it
				var dest=isNaN(this.setting.scrollto)? this.setting.scrollto : parseInt(this.setting.scrollto)
				if (typeof dest=="string" && jQuery('#'+dest).length==1) //check element set by string exists
					dest=jQuery('#'+dest).offset().top
				else
					dest=0
				this.$body.animate({scrollTop: dest}, this.setting.scrollduration);
			},

			keepfixed:function(){
				var $window=jQuery(window)
				var controlx=$window.scrollLeft() + $window.width() - this.$control.width() - this.controlattrs.offsetx
				var controly=$window.scrollTop() + $window.height() - this.$control.height() - this.controlattrs.offsety
				this.$control.css({left:controlx+'px', top:controly+'px'})
			},

			togglecontrol:function(){
				var scrolltop=jQuery(window).scrollTop()
				if (!this.cssfixedsupport)
					this.keepfixed()
				this.state.shouldvisible=(scrolltop>=this.setting.startline)? true : false
				if (this.state.shouldvisible && !this.state.isvisible){
					this.$control.stop().animate({opacity:1}, this.setting.fadeduration[0])
					this.state.isvisible=true
				}
				else if (this.state.shouldvisible==false && this.state.isvisible){
					this.$control.stop().animate({opacity:0}, this.setting.fadeduration[1])
					this.state.isvisible=false
				}
			},
			
			init:function(){
				$(document).ready(function(){
					var mainobj=scrolltotop
					var iebrws=document.all
					mainobj.cssfixedsupport=!iebrws || iebrws && document.compatMode=="CSS1Compat" && window.XMLHttpRequest //not IE or IE7+ browsers in standards mode
					mainobj.$body=(window.opera)? (document.compatMode=="CSS1Compat"? $('html') : $('body')) : $('html,body')
					mainobj.$control=$('<div id="topcontrol">'+mainobj.controlHTML+'</div>')
						.css({position:mainobj.cssfixedsupport? 'fixed' : 'absolute', bottom:mainobj.controlattrs.offsety, right:mainobj.controlattrs.offsetx, opacity:0, cursor:'pointer'})
						.attr({title:''})
						.click(function(){mainobj.scrollup(); return false})
						.appendTo('body')
					if (document.all && !window.XMLHttpRequest && mainobj.$control.text()!='') //loose check for IE6 and below, plus whether control contains any text
						mainobj.$control.css({width:mainobj.$control.width()}) //IE6- seems to require an explicit width on a DIV containing text
					mainobj.togglecontrol()
					$('a[href="' + mainobj.anchorkeyword +'"]').click(function(){
						mainobj.scrollup()
						return false
					})
					$(window).bind('scroll resize', function(e){
						mainobj.togglecontrol()
					})
				})
			}
		};

		// Initialization bottom to top
		scrolltotop.init();

		// Initialization Masonry Posts
		$('.masonry-style').masonry();

		/**
		 * Light & Dark Mode jQuery Toggle Using localStorage
		 */

		// Check for saved 'switchMode' in localStorage
		let switchMode = localStorage.getItem('switchMode'); 

		// Get selector
		const switchModeToggle = $(' .mode-switcher ');

		// Dark mode function
		const enableDarkMode = function() {
			// Add the class to the body
			$( 'body' ).addClass('likhun-dark');
			// Update switchMode in localStorage
			localStorage.setItem('switchMode', 'enabled');
		}

		// Light mdoe function
		const disableDarkMode = function() {
			// Remove the class from the body
			$( 'body' ).removeClass('likhun-dark');
			// Update switchMode in localStorage value
			localStorage.setItem('switchMode', null);
		}
		
		// If the user already visited and enabled switchMode
		if (switchMode === 'enabled') {
			enableDarkMode();
			// Dark icon enabled
			$( '.mode-icon-change' ).addClass( 'bi-moon' );
			$( '.mode-icon-change' ).removeClass( 'bi-brightness-high' );
		} else {
			// Light icon enabled
			$( '.mode-icon-change' ).addClass( 'bi-brightness-high' );
			$( '.mode-icon-change' ).removeClass( 'bi-moon' );
		}

		// When someone clicks the button
		switchModeToggle.on('click', function() {
			// Change switch icon
			$( '.mode-icon-change' ).toggleClass( 'bi-brightness-high' );
			$( '.mode-icon-change' ).toggleClass( 'bi-moon' );

			// get their switchMode setting
			switchMode = localStorage.getItem('switchMode'); 
			
			// if it not current enabled, enable it
			if (switchMode !== 'enabled') {
				enableDarkMode();				
			// if it has been enabled, turn it off  
			} else {  
				disableDarkMode();				
			}
		});	

	}); // End load document
	
})(jQuery);
