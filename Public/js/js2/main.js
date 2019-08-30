$(document).ready(function() {
	$('.owl_banner').owlCarousel({
		loop: true,
		margin: 0,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	})
	$('.owl_a').owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	})
	$('.owl_d').owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 2
			},
			600: {
				items: 3
			},
			1000: {
				items: 4
			}
		}
	})
	$('.sj_ly_owl').owlCarousel({
		loop: false,
		margin: 0,
		nav: false,
		autoplay: false,
		items: 1,
	})
	$('.owl_e').owlCarousel({
		loop: true,
		margin: 7,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 3
			},
			1000: {
				items: 5
			}
		}
	})
	$('.owl_fc').owlCarousel({
		loop: true,
		margin: 14,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 3
			},
			1000: {
				items: 5
			}
		}
	})
	$('.owl_honor').owlCarousel({
		loop: true,
		margin: 5,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 2
			},
			600: {
				items: 3
			},
			1000: {
				items: 5
			}
		}
	})
	$('.owl_case').owlCarousel({
		loop: true,
		margin: 12,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 3
			},
			600: {
				items: 4
			},
			1000: {
				items: 6
			}
		}
	})
	$('.owl_zhanshi').owlCarousel({
		loop: true,
		margin: 12,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 2
			},
			600: {
				items: 3
			},
			1000: {
				items: 4
			}
		}
	})
	$('.about_product_owl').owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			}
		}
	})
	$('.owl_azgy').owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 3
			},
			1000: {
				items: 5
			}
		}
	})
	$('.shenbian_case_owl').owlCarousel({
		loop: true,
		margin: 26,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			}
		}
	})
	$('.owl_xianchang').owlCarousel({
		loop: true,
		margin: 26,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 4
			}
		}
	})
	$('.con_xq_lb').owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		autoplay: true,
		navText: ['', ''],
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 4
			}
		}
	})
})
$(document).ready(function() {
	jQuery.jqtab = function(tabtit, tab_conbox, shijian) {
		$(tab_conbox).find("li").hide();
		$(tabtit).find("li:first").addClass("thistab").show();
		$(tab_conbox).find("li:first").show();

		$(tabtit).find("li").bind(shijian, function() {
			$(this).addClass("thistab").siblings("li").removeClass("thistab");
			var activeindex = $(tabtit).find("li").index(this);
			$(tab_conbox).children().eq(activeindex).show().siblings().hide();
			return false;
		});
	};
	$.jqtab("#tabs", "#tab_conbox", "mouseenter");
	$.jqtab("#tabs1", "#tab_conbox1", "mouseenter");
	$.jqtab("#tabs2", "#tab_conbox2", "mouseenter");
	$.jqtab("#tabs3", "#tab_conbox3", "mouseenter");
	$.jqtab("#tabs4", "#tab_conbox4", "mouseenter");
	$.jqtab("#tabs5", "#tab_conbox5", "mouseenter");
});
$(function() {
	$('.slick_banner').slick({
		dots: true,
		autoplay: true,
		arrows: false,
	});
});
$(function() {
	$('.slick_kehu').slick({
		dots: true,
		autoplay: true,
		vertical: true,
		touchMove: false,
		swipe: false,
	});
});
$(function() {
	$('.owl_news_lb').slick({
		dots: true,
		autoplay: true,
		fade: true,
	});
});

$(function() {
	$('.slick_zoujin').slick({
		dots: false,
		autoplay: true,
		slidesToShow: 5,
		touchMove: false,
	});
});
$(function() {
	$('.slick_zizhi').slick({
		dots: true,
		autoplay: true,
		slidesToShow: 4,
	});
});
$(function() {
	$('.slick_a').slick({
		dots: true,
		autoplay: true,
		slidesToShow: 1,
	});
});
$(function() {
	$('.slick_kehu_1').slick({
		dots: true,
		autoplay: true,
		slidesToShow: 5,
	});
});
$(document).ready(function() {
	$('.slick_pro').slick({
		centerMode: true,
		centerPadding: '0px',
		slidesToShow: 5,
		swipe: false,
		responsive: [{
			breakpoint: 768,
			settings: {
				arrows: false,
				centerMode: true,
				centerPadding: '40px',
				slidesToShow: 3
			}
		}, {
			breakpoint: 480,
			settings: {
				arrows: false,
				centerMode: true,
				centerPadding: '40px',
				slidesToShow: 1
			}
		}]
	});
});
$(document).ready(function() {
	$(".bigimgpro").slick({
		asNavFor: ".smallimgpro",
		arrows: false,
		touchMove:false,
		swipe:false,
		autoplay:false,
		fade: true,
	});

	$('.smallimgpro').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '.bigimgpro',
		focusOnSelect: true,
		touchMove:false,
		swipe:false,
		autoplay:false,
	});
});