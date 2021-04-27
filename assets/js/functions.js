var _____WB$wombat$assign$function_____ = function (name) {
	return (
		(self._wb_wombat &&
			self._wb_wombat.local_init &&
			self._wb_wombat.local_init(name)) ||
		self[name]
	);
};
if (!self.__WB_pmw) {
	self.__WB_pmw = function (obj) {
		this.__WB_source = obj;
		return this;
	};
}
{
	let window = _____WB$wombat$assign$function_____("window");
	let self = _____WB$wombat$assign$function_____("self");
	let document = _____WB$wombat$assign$function_____("document");
	let location = _____WB$wombat$assign$function_____("location");
	let top = _____WB$wombat$assign$function_____("top");
	let parent = _____WB$wombat$assign$function_____("parent");
	let frames = _____WB$wombat$assign$function_____("frames");
	let opener = _____WB$wombat$assign$function_____("opener");

	!(function (e, s, i, a) {
		var o = e(s);
		e(i).ready(function () {
			e(".slider-brands").length &&
				(function () {
					e("body").append('<div class="tooltip-container" />');
					var s = e(".tooltip-container");
					e(".slider-brands .tooltip").each(function () {
						var i = e(this),
							a = i.clone(),
							o = i.closest(".slider__slide").find("img");
						s.append(a),
							o
								.on("mouseenter", function () {
									a.addClass("is-visible").css({
										left: o.offset().left,
										top: o.offset().top,
									});
								})
								.on("mouseleave click", function () {
									a.removeClass("is-visible");
								});
					});
				})(),
				e(".btn-search").on("click", function (s) {
					s.preventDefault(), e(".search--fixed").slideToggle();
				}),
				e(".btn-burger").on("click", function (s) {
					s.preventDefault(),
						e(this).toggleClass("active"),
						e(".header").toggleClass("active");
				}),
				o
					.on("load", function () {
						e(".slider-main").length &&
							e(".slider-main .slider__slides")
								.addClass("owl-carousel")
								.owlCarousel({
									items: 1,
									loop: !0,
									autoplay: !0,
									autoplayTimeout: 1e4,
									smartSpeed: 500,
									responsive: {
										0: {
											nav: !1,
											navText: [
												'<i class="ico-chevron-double-prev"></i>',
												'<i class="ico-chevron-double"></i>',
											],
										},
										767: { nav: !1 },
									},
								}),
							e(".slider-main-nav .next").click(function () {
								e(".slider-main .slider__slides").trigger(
									"next.owl.carousel"
								);
							}),
							e(".slider-main-nav .prev").click(function () {
								e(".slider-main .slider__slides").trigger(
									"prev.owl.carousel"
								);
							}),
							e(".intro__arrows li").each(function (s) {
								var i = e(this).data("top");
								o.width() < 1450 &&
									(i = e(this).data("top-desktop")),
									e(this)
										.delay(500 * s)
										.animate({ top: i + "px" }, 500);
							}),
							e(".slider-brands").length &&
								e(".slider-brands").each(function () {
									var s = e(this),
										i = s.find(".slider__slides"),
										a = (s.data("slides"), s.data("speed"));
									console.log(a),
										i.addClass("owl-carousel").owlCarousel({
											loop: !0,
											autoplay: !1,
											touchDrag: !1,
											autoplayHoverPause: !0,
											mouseDrag: !1,
											smartSpeed: 1200,
											dots: !1,
											onInitialized: function (s) {
												var i = e(s.target);
												setTimeout(function () {
													i.trigger(
														"next.owl.carousel",
														[5e3]
													);
												}, 100);
											},
											onTranslated: function (s) {
												e(
													s.target
												).trigger("next.owl.carousel", [
													5e3,
												]);
											},
											onResized: function (s) {
												e(
													s.target
												).trigger("next.owl.carousel", [
													5e3,
												]);
											},
											responsive: {
												0: { items: 3 },
												768: { items: 5 },
											},
										});
								}),
							e(".slider-brands-primary").length &&
								e(".slider-brands-primary").each(function () {
									var s = e(this),
										i = s.find(".slider__slides"),
										a = s.data("slides"),
										o = s.data("speed");
									console.log(o),
										i.addClass("owl-carousel").owlCarousel({
											responsive: {
												0: {
													items: s.data(
														"slides-mobile"
													)
														? s.data(
																"slides-mobile"
														  )
														: a,
												},
												768: {
													items: s.data(
														"slides-tablet"
													)
														? s.data(
																"slides-tablet"
														  )
														: a,
												},
												1024: { items: a },
											},
											margin: 32,
											nav: !0,
											loop: !0,
											autoplay: !0,
											nav: !0,
											navText: [
												'<i class="ico-chevron-double-prev"></i>',
												'<i class="ico-chevron-double"></i>',
											],
										});
								});
					})
					.on("scroll load", function () {
						e(".header .header__bar fixed").toggleClass(
							"fixed",
							o.scrollTop() > 0
						),
							o.scrollTop() > 0 &&
								e(".header").find(".search--fixed").slideUp(),
							e(".btn-help").toggleClass(
								"fixed",
								o.scrollTop() > 0
							);
					});
		});
	})(jQuery, window, document);
}
