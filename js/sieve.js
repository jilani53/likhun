/*
  Title: Sieve Content
  Author: Jilani Ahmed
  Website: https://wpninjadevs.com/
*/

;(function($) {
 
	$('#container-async').on('click', 'a[data-filter], .pagination a', function(e) {
		
		if(e.preventDefault) { 
			e.preventDefault(); 
		}
	
		$this = $(this);
	
		if ($this.data('filter')) {
			/**
			 * Click on tag cloud
			 */
			$this.closest('ul').find('.active').removeClass('active');
			$this.parent('li').addClass('active');
			$page = $this.data('page');
		} else {
			/**
			 * Click on pagination
			 */
			$page = parseInt($this.attr('href').replace(/\D/g,''));
			$this = $('.nav-filter .active a');

			// Scroll to top of section
			var targetEle = $('.likhun-ajax-filter');;
  
			$('html, body').stop().animate({
				'scrollTop': targetEle.offset().top
			}, 500, 'swing', function () {
				window.location.targetEle = targetEle;
			});
		}	
	
		$params = {
			'page' : $page,
			'tax'  : $this.data('filter'),
			'term' : $this.data('term'),
			'qty'  : $this.closest('#container-async').data('paged')
		};	
	
		// Run query
		get_posts($params);

	});

	/**
	 * Call get_posts function
	 */
	function get_posts($params) {

		$container = $('#container-async');
		$content   = $container.find('.product-container');
		$status    = $container.find('.status');
	
		$status.text('Loading ...');
	
		$.ajax({
			
			url: filterObj.ajax_url,
			data: {
				action: 'do_filter_products',
				nonce: filterObj.nonce,
				params: $params
			},

			type: 'post',
			dataType: 'json',
			success: function(data, textStatus, XMLHttpRequest) {			

				if (data.status === 200) {					
					$content.html(data.content).each(function(){
						$('.masonry-style').masonry('reloadItems');
					});
					
					// Initialize the masonry when ajax click
					$('.masonry-style').masonry({
						itemSelector: '.col-md-6',
						percentPosition: true
					});

				} else if (data.status === 201) {
					$content.html(data.message);	
				} else {
					$status.html(data.message);
				}
				
			},

			error: function(MLHttpRequest, textStatus, errorThrown) {
				$status.html(textStatus);
			},

			complete: function(data, textStatus) {
	
				msg = textStatus;	
				if (textStatus === 'success') {
					msg = data.responseJSON.found;
				}	
				$status.text('Total Items: ' + msg);

			}
		});
	}

	// Active All onload
	$('a[data-term="all-terms"]').trigger('click');

})(jQuery);
