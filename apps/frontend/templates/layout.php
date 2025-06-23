<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="es">
  <head>
    <?php include_http_metas()?>
    <?php include_metas()?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php include_title()?>
    <link rel='stylesheet' id='wp-block-library-css'  href='/plugins/wp-includes/css/dist/block-library/style.min.css?ver=5.5.1' type='text/css' media='all' />
    <link rel='stylesheet' id='wc-block-vendors-style-css'  href='/plugins/wp-content/plugins/woocommerce/packages/woocommerce-blocks/build/vendors-style.css?ver=3.1.0' type='text/css' media='all' />
    <link rel='stylesheet' id='wc-block-style-css'  href='/plugins/wp-content/plugins/woocommerce/packages/woocommerce-blocks/build/style.css?ver=3.1.0' type='text/css' media='all' />
    <link rel='stylesheet' id='rs-plugin-settings-css'  href='/plugins/wp-content/plugins/revslider/public/assets/css/rs6.css?ver=6.2.22' type='text/css' media='all' />
    <link rel='stylesheet' id='js_composer_front-css'  href='/plugins/wp-content/plugins/js_composer/assets/css/js_composer.min.css?ver=6.3.0' type='text/css' media='all' />
    <link rel='stylesheet' id='bootstrap-css'  href='/plugins/wp-content/themes/woodmart/css/bootstrap.min.css?ver=5.2.0' type='text/css' media='all' />
    <link rel='stylesheet' id='woodmart-style-css'  href='/plugins/wp-content/themes/woodmart/style.min.css?ver=5.2.0' type='text/css' media='all' />
    <link rel='stylesheet' id='xts-style-theme_settings_default-css'  href='/plugins/wp-content/uploads/2020/09/xts-theme_settings_default-1599413616.css?ver=5.2.0' type='text/css' media='all' />
    <script type='text/javascript' src='/plugins/wp-includes/js/jquery/jquery.js?ver=1.12.4-wp' id='jquery-core-js'></script>
    <script type='text/javascript' src='/plugins/wp-content/plugins/revslider/public/assets/js/rbtools.min.js?ver=6.2.22' id='tp-tools-js'></script>
    <script type='text/javascript' src='/plugins/wp-content/plugins/revslider/public/assets/js/rs6.min.js?ver=6.2.22' id='revmin-js'></script>
    <script type='text/javascript' src='/plugins/wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js?ver=2.70' id='jquery-blockui-js'></script>
    <script type='text/javascript' src='/plugins/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart.min.js?ver=4.4.1' id='wc-add-to-cart-js'></script>
    <script type='text/javascript' src='/plugins/wp-content/plugins/js_composer/assets/js/vendors/woocommerce-add-to-cart.js?ver=6.3.0' id='vc_woocommerce-add-to-cart-js-js'></script>
    <script type='text/javascript' src='/plugins/wp-content/themes/woodmart/js/device.min.js?ver=5.2.0' id='woodmart-device-js'></script>
		<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <link rel="shortcut icon" href="/images/favicon2.png" />
    <script type="text/javascript">function setREVStartSize(e){
			window.RSIW = window.RSIW===undefined ? window.innerWidth : window.RSIW;
			window.RSIH = window.RSIH===undefined ? window.innerHeight : window.RSIH;
			try {
				var pw = document.getElementById(e.c).parentNode.offsetWidth,
					newh;
				pw = pw===0 || isNaN(pw) ? window.RSIW : pw;
				e.tabw = e.tabw===undefined ? 0 : parseInt(e.tabw);
				e.thumbw = e.thumbw===undefined ? 0 : parseInt(e.thumbw);
				e.tabh = e.tabh===undefined ? 0 : parseInt(e.tabh);
				e.thumbh = e.thumbh===undefined ? 0 : parseInt(e.thumbh);
				e.tabhide = e.tabhide===undefined ? 0 : parseInt(e.tabhide);
				e.thumbhide = e.thumbhide===undefined ? 0 : parseInt(e.thumbhide);
				e.mh = e.mh===undefined || e.mh=="" || e.mh==="auto" ? 0 : parseInt(e.mh,0);
				if(e.layout==="fullscreen" || e.l==="fullscreen")
					newh = Math.max(e.mh,window.RSIH);
				else{
					e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
					for (var i in e.rl) if (e.gw[i]===undefined || e.gw[i]===0) e.gw[i] = e.gw[i-1];
					e.gh = e.el===undefined || e.el==="" || (Array.isArray(e.el) && e.el.length==0)? e.gh : e.el;
					e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
					for (var i in e.rl) if (e.gh[i]===undefined || e.gh[i]===0) e.gh[i] = e.gh[i-1];

					var nl = new Array(e.rl.length),
						ix = 0,
						sl;
					e.tabw = e.tabhide>=pw ? 0 : e.tabw;
					e.thumbw = e.thumbhide>=pw ? 0 : e.thumbw;
					e.tabh = e.tabhide>=pw ? 0 : e.tabh;
					e.thumbh = e.thumbhide>=pw ? 0 : e.thumbh;
					for (var i in e.rl) nl[i] = e.rl[i]<window.RSIW ? 0 : e.rl[i];
					sl = nl[0];
					for (var i in nl) if (sl>nl[i] && nl[i]>0) { sl = nl[i]; ix=i;}
					var m = pw>(e.gw[ix]+e.tabw+e.thumbw) ? 1 : (pw-(e.tabw+e.thumbw)) / (e.gw[ix]);
					newh =  (e.gh[ix] * m) + (e.tabh + e.thumbh);
				}
				if(window.rs_init_css===undefined) window.rs_init_css = document.head.appendChild(document.createElement("style"));
				document.getElementById(e.c).height = newh+"px";
				window.rs_init_css.innerHTML += "#"+e.c+"_wrapper { height: "+newh+"px }";
			} catch(e){
				console.log("Failure at Presize of Slider:" + e)
			}
		//});
		};
    </script>
    <style data-type="woodmart_shortcodes-custom-css">
      #wd-5f550f8254496 .woodmart-title-container{line-height:30px;font-size:20px;}
      #wd-5f5522d8a78ef .woodmart-title-container{line-height:30px;font-size:20px;}
    </style>
    <style type="text/css" data-type="vc_shortcodes-custom-css">
      .vc_custom_1533826872352{margin-top: -40px !important;padding-top: 0px !important;}
      .vc_custom_1533819106143{margin-bottom: 6vh !important;padding-top: 4vh !important;background-color: #f7f7f7 !important;}
      .vc_custom_1533813593149{margin-bottom: 4vh !important;}
      .vc_custom_1534487651375{margin-right: 0px !important;margin-bottom: 5vh !important;margin-left: 0px !important;background-color: #f7f7f7 !important;}
      .vc_custom_1599415063182{margin-bottom: 7vh !important;padding-top: 4vh !important;padding-bottom: 9vh !important;background-color: #f7f7f7 !important;}
      .vc_custom_1534490106488{padding-top: 0px !important;}
      .vc_custom_1533739411437{padding-top: 0px !important;}
      .vc_custom_1534493033597{margin-bottom: 25px !important;}
      .vc_custom_1533813532486{padding-top: 0px !important;}
      .vc_custom_1533826982227{padding-top: 20px !important;}
      .vc_custom_1533804479805{padding-top: 0px !important;padding-right: 0px !important;padding-left: 0px !important;}
      .vc_custom_1533808544328{padding-top: 20px !important;}
      .vc_custom_1599410092372{margin-bottom: 0px !important;}
      .vc_custom_1534490939640{padding-top: 0px !important;}
      .vc_custom_1599415010187{margin-bottom: 25px !important;}
			.cmbiar{
				background-color: #f4a51c;
				color: #fff !important;
			}
    </style>
    <noscript>
      <style> .wpb_animate_when_almost_visible { opacity: 1; }</style>
    </noscript>
    <style data-type="wd-style-header_374016">
      @media (min-width: 1025px) {
        .whb-top-bar-inner {
          height: 41px;
        }

        .whb-general-header-inner {
          height: 105px;
        }

        .whb-header-bottom-inner {
          height: 50px;
        }

        .whb-sticked .whb-top-bar-inner {
          height: 41px;
        }

        .whb-sticked .whb-general-header-inner {
          height: 60px;
        }

        .whb-sticked .whb-header-bottom-inner {
          height: 50px;
        }

        /* HEIGHT OF HEADER CLONE */
        .whb-clone .whb-general-header-inner {
          height: 60px;
        }

        /* HEADER OVERCONTENT */
        .woodmart-header-overcontent .title-size-small {
          padding-top: 218px;
        }

        .woodmart-header-overcontent .title-size-default {
          padding-top: 258px;
        }

        .woodmart-header-overcontent .title-size-large {
          padding-top: 298px;
        }

        /* HEADER OVERCONTENT WHEN SHOP PAGE TITLE TURN OFF  */
        .woodmart-header-overcontent .without-title.title-size-small {
          padding-top: 198px;
        }

        .woodmart-header-overcontent .without-title.title-size-default {
          padding-top: 233px;
        }

        .woodmart-header-overcontent .without-title.title-size-large {
          padding-top: 258px;
        }

        /* HEADER OVERCONTENT ON SINGLE PRODUCT */
        .single-product .whb-overcontent:not(.whb-custom-header) {
          padding-top: 198px;
        }

        /* HEIGHT OF LOGO IN TOP BAR */
        .whb-top-bar .woodmart-logo img {
          max-height: 41px;
        }

        .whb-sticked .whb-top-bar .woodmart-logo img {
          max-height: 41px;
        }

        /* HEIGHT OF LOGO IN GENERAL HEADER */
        .whb-general-header .woodmart-logo img {
          max-height: 105px;
        }

        .whb-sticked .whb-general-header .woodmart-logo img {
          max-height: 60px;
        }

        /* HEIGHT OF LOGO IN BOTTOM HEADER */
        .whb-header-bottom .woodmart-logo img {
          max-height: 50px;
        }

        .whb-sticked .whb-header-bottom .woodmart-logo img {
          max-height: 50px;
        }

        /* HEIGHT OF LOGO IN HEADER CLONE */
        .whb-clone .whb-general-header .woodmart-logo img {
          max-height: 60px;
        }

        /* HEIGHT OF HEADER BUILDER ELEMENTS */
        /* HEIGHT ELEMENTS IN TOP BAR */
        .whb-top-bar .wd-tools-element > a,
        .whb-top-bar .main-nav .item-level-0 > a,
        .whb-top-bar .whb-secondary-menu .item-level-0 > a,
        .whb-top-bar .categories-menu-opener,
        .whb-top-bar .menu-opener,
        .whb-top-bar .whb-divider-stretch:before,
        .whb-top-bar form.woocommerce-currency-switcher-form .dd-selected,
        .whb-top-bar .whb-text-element .wcml-dropdown a.wcml-cs-item-toggle {
          height: 41px;
        }

        .whb-sticked .whb-top-bar .wd-tools-element > a,
        .whb-sticked .whb-top-bar .main-nav .item-level-0 > a,
        .whb-sticked .whb-top-bar .whb-secondary-menu .item-level-0 > a,
        .whb-sticked .whb-top-bar .categories-menu-opener,
        .whb-sticked .whb-top-bar .menu-opener,
        .whb-sticked .whb-top-bar .whb-divider-stretch:before,
        .whb-sticked .whb-top-bar form.woocommerce-currency-switcher-form .dd-selected,
        .whb-sticked .whb-top-bar .whb-text-element .wcml-dropdown a.wcml-cs-item-toggle {
          height: 41px;
        }

        /* HEIGHT ELEMENTS IN GENERAL HEADER */
        .whb-general-header .whb-divider-stretch:before,
        .whb-general-header .navigation-style-bordered .item-level-0 > a {
          height: 105px;
        }

        .whb-sticked:not(.whb-clone) .whb-general-header .whb-divider-stretch:before,
        .whb-sticked:not(.whb-clone) .whb-general-header .navigation-style-bordered .item-level-0 > a {
          height: 60px;
        }

        .whb-sticked:not(.whb-clone) .whb-general-header .woodmart-search-dropdown,
        .whb-sticked:not(.whb-clone) .whb-general-header .dropdown-cart,
        .whb-sticked:not(.whb-clone) .whb-general-header .woodmart-navigation:not(.vertical-navigation):not(.navigation-style-bordered) .sub-menu-dropdown {
          margin-top: 10px;
        }

        .whb-sticked:not(.whb-clone) .whb-general-header .woodmart-search-dropdown:after,
        .whb-sticked:not(.whb-clone) .whb-general-header .dropdown-cart:after,
        .whb-sticked:not(.whb-clone) .whb-general-header .woodmart-navigation:not(.vertical-navigation):not(.navigation-style-bordered) .sub-menu-dropdown:after {
          height: 10px;
        }

        /* HEIGHT ELEMENTS IN BOTTOM HEADER */
        .whb-header-bottom .wd-tools-element > a,
        .whb-header-bottom .main-nav .item-level-0 > a,
        .whb-header-bottom .whb-secondary-menu .item-level-0 > a,
        .whb-header-bottom .categories-menu-opener,
        .whb-header-bottom .menu-opener,
        .whb-header-bottom .whb-divider-stretch:before,
        .whb-header-bottom form.woocommerce-currency-switcher-form .dd-selected,
        .whb-header-bottom .whb-text-element .wcml-dropdown a.wcml-cs-item-toggle {
          height: 50px;
        }

        .whb-header-bottom.whb-border-fullwidth .menu-opener {
          height: 51px;
          margin-top: -0px;
          margin-bottom: -1px;
        }

        .whb-header-bottom.whb-border-boxed .menu-opener {
          height: 50px;
          margin-top: -0px;
          margin-bottom: -1px;
        }

        .whb-sticked .whb-header-bottom .wd-tools-element > a,
        .whb-sticked .whb-header-bottom .main-nav .item-level-0 > a,
        .whb-sticked .whb-header-bottom .whb-secondary-menu .item-level-0 > a,
        .whb-sticked .whb-header-bottom .categories-menu-opener,
        .whb-sticked .whb-header-bottom .whb-divider-stretch:before,
        .whb-sticked .whb-header-bottom form.woocommerce-currency-switcher-form .dd-selected,
        .whb-sticked .whb-header-bottom .whb-text-element .wcml-dropdown a.wcml-cs-item-toggle {
          height: 50px;
        }

        .whb-sticked .whb-header-bottom.whb-border-fullwidth .menu-opener {
          height: 51px;
        }

        .whb-sticked .whb-header-bottom.whb-border-boxed .menu-opener {
          height: 50px;
        }

        .whb-sticky-shadow.whb-sticked .whb-header-bottom .menu-opener {
          height: 50px;
          margin-bottom:0;
        }

        /* HEIGHT ELEMENTS IN HEADER CLONE */
        .whb-clone .wd-tools-element > a,
        .whb-clone .main-nav .item-level-0 > a,
        .whb-clone .whb-secondary-menu .item-level-0 > a,
        .whb-clone .categories-menu-opener,
        .whb-clone .menu-opener,
        .whb-clone .whb-divider-stretch:before,
        .whb-clone .navigation-style-bordered .item-level-0 > a,
        .whb-clone form.woocommerce-currency-switcher-form .dd-selected,
        .whb-clone .whb-text-element .wcml-dropdown a.wcml-cs-item-toggle {
          height: 60px;
        }
      }

      @media (max-width: 1024px) {
        .whb-top-bar-inner {
          height: 0px;
        }

        .whb-general-header-inner {
          height: 60px;
        }

        .whb-header-bottom-inner {
          height: 0px;
        }

        /* HEIGHT OF HEADER CLONE */
        .whb-clone .whb-general-header-inner {
          height: 60px;
        }

        /* HEADER OVERCONTENT */
        .woodmart-header-overcontent .page-title {
          padding-top: 77px;
        }

        /* HEADER OVERCONTENT WHEN SHOP PAGE TITLE TURN OFF  */
        .woodmart-header-overcontent .without-title.title-shop {
          padding-top: 62px;
        }

        /* HEADER OVERCONTENT ON SINGLE PRODUCT */
        .single-product .whb-overcontent:not(.whb-custom-header) {
          padding-top: 62px;
        }

        /* HEIGHT OF LOGO IN TOP BAR */
        .whb-top-bar .woodmart-logo img {
          max-height: 0px;
        }

        /* HEIGHT OF LOGO IN GENERAL HEADER */
        .whb-general-header .woodmart-logo img {
          max-height: 60px;
        }

        /* HEIGHT OF LOGO IN BOTTOM HEADER */
        .whb-header-bottom .woodmart-logo img {
          max-height: 0px;
        }

        /* HEIGHT OF LOGO IN HEADER CLONE */
        .whb-clone .whb-general-header .woodmart-logo img {
          max-height: 60px;
        }

        /* HEIGHT OF HEADER BULDER ELEMENTS */
        /* HEIGHT ELEMENTS IN TOP BAR */
        .whb-top-bar .wd-tools-element > a,
        .whb-top-bar .main-nav .item-level-0 > a,
        .whb-top-bar .whb-secondary-menu .item-level-0 > a,
        .whb-top-bar .categories-menu-opener,
        .whb-top-bar .whb-divider-stretch:before,
        .whb-top-bar form.woocommerce-currency-switcher-form .dd-selected,
        .whb-top-bar .whb-text-element .wcml-dropdown a.wcml-cs-item-toggle {
          height: 0px;
        }

        /* HEIGHT ELEMENTS IN GENERAL HEADER */
        .whb-general-header .wd-tools-element > a,
        .whb-general-header .main-nav .item-level-0 > a,
        .whb-general-header .whb-secondary-menu .item-level-0 > a,
        .whb-general-header .categories-menu-opener,
        .whb-general-header .whb-divider-stretch:before,
        .whb-general-header form.woocommerce-currency-switcher-form .dd-selected,
        .whb-general-header .whb-text-element .wcml-dropdown a.wcml-cs-item-toggle {
          height: 60px;
        }

        /* HEIGHT ELEMENTS IN BOTTOM HEADER */
        .whb-header-bottom .wd-tools-element > a,
        .whb-header-bottom .main-nav .item-level-0 > a,
        .whb-header-bottom .whb-secondary-menu .item-level-0 > a,
        .whb-header-bottom .categories-menu-opener,
        .whb-header-bottom .whb-divider-stretch:before,
        .whb-header-bottom form.woocommerce-currency-switcher-form .dd-selected,
        .whb-header-bottom .whb-text-element .wcml-dropdown a.wcml-cs-item-toggle {
          height: 0px;
        }

        /* HEIGHT ELEMENTS IN HEADER CLONE */
        .whb-clone .wd-tools-element > a,
        .whb-clone .main-nav .item-level-0 > a,
        .whb-clone .whb-secondary-menu .item-level-0 > a,
        .whb-clone .categories-menu-opener,
        .whb-clone .menu-opener,
        .whb-clone .whb-divider-stretch:before,
        .whb-clone form.woocommerce-currency-switcher-form .dd-selected,
        .whb-clone .whb-text-element .wcml-dropdown a.wcml-cs-item-toggle {
          height: 60px;
        }
      }

      .whb-top-bar {
        background-color: rgba(9, 33, 67, 1);border-color: rgba(58, 77, 105, 1);border-bottom-width: 1px;border-bottom-style: solid;
      }

      .whb-general-header {
        background-color: rgba(9, 33, 67, 1);border-bottom-width: 0px;border-bottom-style: solid;
      }
      .whb-wjlcubfdmlq3d7jvmt23 .menu-opener { background-color: rgba(255, 255, 255, 1); }.whb-wjlcubfdmlq3d7jvmt23 .menu-opener { border-color: rgba(129, 129, 129, 0.2);border-bottom-width: 1px;border-bottom-style: solid;border-top-width: 1px;border-top-style: solid;border-left-width: 1px;border-left-style: solid;border-right-width: 1px;border-right-style: solid; }.whb-wjlcubfdmlq3d7jvmt23.wd-more-cat:not(.wd-show-cat) .item-level-0:nth-child(n+15):not(:last-child) {
                  display: none;
              }.wd-more-cat .item-level-0:nth-child(n+15) {
                  animation: wd-fadeIn .3s ease both;
              }
              .wd-show-cat .wd-more-cat-btn {
                  display: none;
              }
      .whb-header-bottom {
        border-color: rgba(129, 129, 129, 0.2);border-bottom-width: 1px;border-bottom-style: solid;
      }
    </style>
  </head>
  <body class="home page-template-default page page-id-1724 theme-woodmart woocommerce-no-js wrapper-full-width form-style-rounded form-border-width-2 categories-accordion-on woodmart-ajax-shop-on offcanvas-sidebar-mobile offcanvas-sidebar-tablet notifications-sticky btns-default-rounded btns-default-dark btns-default-hover-dark btns-shop-rounded btns-shop-light btns-shop-hover-light btns-accent-rounded btns-accent-light btns-accent-hover-light wpb-js-composer js-comp-ver-6.3.0 vc_responsive">
    <div class="website-wrapper">
      <header class="whb-header whb-sticky-shadow whb-scroll-slide whb-sticky-clone">
        <div class="whb-main-header">
          <div class="whb-row whb-top-bar whb-not-sticky-row whb-with-bg whb-border-fullwidth whb-color-light whb-flex-flex-middle whb-hidden-mobile">
            <div class="container">
              <div class="whb-flex-row whb-top-bar-inner">
                <div class="whb-column whb-col-left whb-visible-lg">
									<?php
										$results = Doctrine_Query::create()
										->select('b.*')
										->from('Banners b')
										->where('b.posicion = ?', 'top_left')
										->orderBy('RAND()')
										->limit(1)
										->execute();
									?>
									<?php foreach($results as $result) { ?>
										<div class="whb-text-element reset-mb-10 ">
											<a href="<?php echo $result->getEnlace(); ?>"><?php echo $result->getDescripcion(); ?></a>
										</div>
									<?php } ?>
                </div>
                <div class="whb-column whb-col-center whb-visible-lg whb-empty-column"></div>
                <div class="whb-column whb-col-right whb-visible-lg">
									<div class="woodmart-social-icons text-center icons-design-default icons-size- color-scheme-light social-share social-form-circle">
										bbbbbbbbb
										<?php
											$socials = Doctrine_Query::create()
											->select('b.*')
											->from('Banners b')
											->where('b.posicion = ?', 'top_right')
											->orderBy('orden')
											->execute();
										?>
										<?php foreach($socials as $social) { ?>
											<a rel="nofollow" href="<?php echo $social->getEnlace()?>" target="_blank" class=" woodmart-social-icon <?php echo $social->getDescripcion()?>">
												<i></i>
												<span class="woodmart-social-icon-name"><?php echo $social->getNombre()?></span>
											</a>
										<?php } ?>
                  </div>
                </div>
                <div class="whb-column whb-col-mobile whb-hidden-lg whb-empty-column"></div>
              </div>
            </div>
          </div>
          <div class="whb-row whb-general-header whb-sticky-row whb-with-bg whb-without-border whb-color-light whb-flex-flex-middle">
            <div class="container">
              <div class="whb-flex-row whb-general-header-inner">
                <div class="whb-column whb-col-left whb-visible-lg">
                  <div class="site-logo">
                    <div class="woodmart-logo-wrap switch-logo-enable">
                      <a href="<?php echo url_for('@homepage') ?>" class="woodmart-logo woodmart-main-logo" rel="home">
                        <img src="/plugins/wp-content/uploads/2020/09/droguesi2s.png" alt="Droguesi" style="max-width: 245px;" />
                      </a>
                      <a href="<?php echo url_for('@homepage') ?>" class="woodmart-logo woodmart-sticky-logo" rel="home">
                        <img src="/plugins/wp-content/uploads/2020/09/droguesi2s.png" alt="Droguesi" style="max-width: 245px;" />
                      </a>
                    </div>
                  </div>
                </div>
                <div class="whb-column whb-col-center whb-visible-lg">
                  <div class="whb-space-element " style="width:10px;"></div>
                  <div class="woodmart-search-form">
										<form action="<?php echo url_for("producto");?>/index" method="get" id="busque" class="searchform  search-style-with-bg woodmart-ajax-search"/>
											<input type="text" class="s" placeholder="Buscar productos" value="" name="busqueda" id="busqueda">
                      <button type="submit" class="searchsubmit">Buscar</button>
										</form>										

                    <div class="search-results-wrapper">
                      <div class="woodmart-scroll">
                        <div class="woodmart-search-results woodmart-scroll-content"></div>
                      </div>
                      <div class="woodmart-search-loader wd-fill"></div>
                    </div>
                  </div>
                  <div class="whb-space-element " style="width:10px;"></div>
                </div>
                <div class="whb-column whb-col-right whb-visible-lg">
									<div class="whb-space-element " style="width:15px;"></div>
										<?php if($sf_user->isAuthenticated()) { ?>
											<div class="woodmart-header-links woodmart-navigation menu-simple-dropdown wd-tools-element item-event-hover my-account-with-text login-side-opener">
												<a href="#" title="Mi cuenta">
													<span class="wd-tools-icon"></span>
													<span class="wd-tools-text">Mi cuenta</span>
												</a>
											</div>
										<?php } else { ?>
											<div class="woodmart-header-links woodmart-navigation menu-simple-dropdown wd-tools-element item-event-hover my-account-with-text login-side-opener">
												<a href="#" title="Mi cuenta">
													<span class="wd-tools-icon"></span>
													<span class="wd-tools-text">Iniciar Sesión</span>
												</a>
											</div>
										<?php } ?>
                  <div class="woodmart-shopping-cart wd-tools-element woodmart-cart-design-2 woodmart-cart-alt cart-widget-opener">
                    <a href="#" title="Carrito" id="btn_cart">
                      <span class="woodmart-cart-icon wd-tools-icon">
                        <span class="woodmart-cart-number woodmart-cart-number2">0</span>
                      </span>
                      <span class="woodmart-cart-totals wd-tools-text">
                        <span class="subtotal-divider">/</span>
                        <span class="woodmart-cart-subtotal">
                          <span class="woocommerce-Price-amount amount">
                            <bdi class="woodmart-cart-tot2">$0.00</bdi>
                          </span>
                        </span>
                      </span>
                    </a>
                  </div>
                </div>
                <div class="whb-column whb-mobile-left whb-hidden-lg">
                  <div class="woodmart-burger-icon wd-tools-element mobile-nav-icon whb-mobile-nav-icon wd-style-text">
                    <a href="#">
                      <span class="woodmart-burger wd-tools-icon"></span>
                      <span class="woodmart-burger-label wd-tools-text">Menu</span>
                    </a>
                  </div>
                </div>
                <div class="whb-column whb-mobile-center whb-hidden-lg">
                  <div class="site-logo">
                    <div class="woodmart-logo-wrap">
                      <a href="#" class="woodmart-logo woodmart-main-logo" rel="home">
                        <img src="/plugins/wp-content/themes/woodmart/images/wood-logo-dark.svg" alt="Droguesi" style="max-width: 179px;" />
                      </a>
                    </div>
                  </div>
                </div>
                <div class="whb-column whb-mobile-right whb-hidden-lg">
									<div class="woodmart-shopping-cart wd-tools-element woodmart-cart-design-5 woodmart-cart-alt cart-widget-opener">
										<a href="#" title="Shopping cart">
											<span class="woodmart-cart-icon wd-tools-icon">
												<span class="woodmart-cart-number woodmart-cart-number2">0</span>
											<span class="woodmart-cart-totals wd-tools-text">
												<span class="subtotal-divider">/</span>
												<span class="woodmart-cart-subtotal">
													<span class="woocommerce-Price-amount amount">
														<bdi class="woodmart-cart-tot2">0.00</bdi>
													</span>
												</span>
											</span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="whb-row whb-header-bottom whb-not-sticky-row whb-without-bg whb-border-fullwidth whb-color-dark whb-flex-flex-middle whb-hidden-mobile">
						<div class="container">
							<div class="whb-flex-row whb-header-bottom-inner">
								<div class="whb-column whb-col-left whb-visible-lg">
									<div class="header-categories-nav show-on-hover wd-more-cat whb-wjlcubfdmlq3d7jvmt23" role="navigation">
										<div class="header-categories-nav-wrap">
											<span class="menu-opener color-scheme-dark has-bg">
												<span class="woodmart-burger"></span>
												<span class="menu-open-label">Categorias</span>
												<span class="arrow-opener"></span>
											</span>
											<div class="categories-menu-dropdown vertical-navigation woodmart-navigation">
												<div class="menu-categorias-container">
													<ul id="menu-categorias" class="menu wd-cat-nav">
														<li class="menu-item menu-item-type-custom menu-item-object-custom item-level-0 menu-item-design-default menu-simple-dropdown item-event-hover">
															<a href="<?php echo url_for("@oferta"); ?>" class="woodmart-nav-link"><span class="nav-link-text">OFERTAS</span></a>
														</li>
													<?php
														$results = Doctrine_Query::create()
														->select('pc.*')
														->from('ProdCategoria pc')
														->where('pc.codigo_full NOT LIKE "%-%"')
														->orderBy('pc.Nombre ASC')
														->execute();
													?>
													<?php foreach ($results as $result):?>
														<li id="menu-item-9328" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-9328 item-level-0 menu-item-design-default menu-simple-dropdown item-event-hover">
															<a href="<?php echo url_for('producto/index?catname='.$result->getNombre()); ?>" class="woodmart-nav-link"><span class="nav-link-text"><?php echo $result->getNombre(); ?></span></a>
															<div class="sub-menu-dropdown color-scheme-dark">
																<div class="container">
																	<ul class="sub-menu color-scheme-dark">
																	<?php
																		$results2 = Doctrine_Query::create()
																		->select('pc.*')
																		->from('ProdCategoria pc')
																		->where('pc.codigo_full LIKE "'.$result->getCodigo().'-%"')
																		->orderBy('pc.Nombre ASC')
																		->execute();
																	?>
																	<?php foreach ($results2 as $result2):?>
																		<li class="menu-item menu-item-type-custom menu-item-object-custom item-level-1">
																			<?php list($pre,$name)=explode("/", $result2->getNombre()); ?>
																			<a href="<?php echo url_for('producto/index?catname='.$name); ?>" class="woodmart-nav-link">
																				<span class="nav-link-text"><?php echo $name ?></span>
																			</a>
																		</li>
																	<?php endforeach; ?>
																	</ul>
																</div>
															</div>
														</li>
													<?php endforeach; ?>
														<li class="menu-item item-level-0 wd-more-cat-btn">
															<a href="#" class="woodmart-nav-link"></a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="whb-column whb-col-center whb-visible-lg whb-empty-column"></div>
								<div class="whb-column whb-col-right whb-visible-lg">
									<div class="whb-text-element reset-mb-10 ">
										<ul class="inline-list inline-list-with-border main-nav-style">
											<li>
												<a class="color-primary" href="<?php echo url_for("@inicio")."/faq"; ?>" rel="noopener">PREGUNTAS FRECUENTES</a>
											</li>
											<li>
												<a class="color-primary" href="<?php echo url_for("@contactenos"); ?>" rel="noopener">CONTACTANOS</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="whb-column whb-col-mobile whb-hidden-lg whb-empty-column"></div>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div class="main-page-wrapper">
					<?php echo $sf_content ?>
			</div>

			<div class="woodmart-prefooter" style="padding-bottom: 0px">
				<div class="container">
					<div data-vc-full-width="true" data-vc-full-width-init="true" class="vc_row wpb_row vc_row-fluid vc_custom_1540559540760 vc_row-has-fill vc_row-o-content-top vc_row-flex" style="position: relative; left: -341.5px; box-sizing: border-box; width: 1905px; padding-left: 341.5px; padding-right: 341.5px;">
						<div class="wpb_column vc_column_container vc_col-sm-6 vc_col-lg-3 vc_col-md-6 vc_col-xs-12 text-center">
							<div class="vc_column-inner vc_custom_1533821559545">
								<div class="wpb_wrapper">
									<div class="info-box-wrapper ">
										<div id="wd-5f43d07123ab6" class=" woodmart-info-box text-left box-icon-align-left box-style- color-scheme-light woodmart-bg-none box-title-small vc_custom_1534746579141">
											<div class="box-icon-wrapper box-with-icon box-icon-simple">
												<div class="info-box-icon">
													<i class="fas fa-sign-in-alt" style="font-size: 3rem; color: #acd303"></i>
												</div>
											</div>
											<div class="info-box-content">
												<h4 class="info-box-title woodmart-font-weight- box-title-style-default">Inicia Sesión.</h4>
												<div class="info-box-inner reset-mb-10">
														<p>Con tus datos.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="wpb_column vc_column_container vc_col-sm-6 vc_col-lg-3 vc_col-md-6 vc_col-xs-12 text-center">
							<div class="vc_column-inner vc_custom_1533821564252">
								<div class="wpb_wrapper">
									<div class="info-box-wrapper ">
										<div id="wd-5f43d07124309" class=" woodmart-info-box text-left box-icon-align-left box-style- color-scheme-light woodmart-bg-none box-title-small vc_custom_1534746584202">
											<div class="box-icon-wrapper box-with-icon box-icon-simple">
												<div class="info-box-icon">
													<div class="info-svg-wrapper info-icon" style="width: 50px;height: 50px;">
														<i class="fas fa-tags" style="font-size: 3rem; color: #acd303"></i>
													</div>
												</div>
											</div>
											<div class="info-box-content">
												<h4 class="info-box-title woodmart-font-weight- box-title-style-default">Identifica los productos.</h4>
												<div class="info-box-inner reset-mb-10">
														<p>Selecciona la cantidad.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="wpb_column vc_column_container vc_col-sm-6 vc_col-lg-3 vc_col-md-6 vc_col-xs-12 text-center">
							<div class="vc_column-inner vc_custom_1533821570339">
								<div class="wpb_wrapper">
									<div class="info-box-wrapper ">
										<div id="wd-5f43d07124c90" class=" woodmart-info-box text-left box-icon-align-left box-style- color-scheme-light woodmart-bg-none box-title-small vc_custom_1534746589359">
											<div class="box-icon-wrapper box-with-icon box-icon-simple">
												<div class="info-box-icon">
													<div class="info-svg-wrapper info-icon" style="width: 50px;height: 50px;">
														<i class="fas fa-cart-arrow-down" style="font-size: 3rem; color: #acd303"></i>
													</div>
												</div>
											</div>
											<div class="info-box-content">
												<h4 class="info-box-title woodmart-font-weight- box-title-style-default">Añade los productos.</h4>
												<div class="info-box-inner reset-mb-10">
													<p>Al carrito de compras.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="wpb_column vc_column_container vc_col-sm-6 vc_col-lg-3 vc_col-md-6 vc_col-xs-12 text-center">
							<div class="vc_column-inner vc_custom_1533821575175">
								<div class="wpb_wrapper">
									<div class="info-box-wrapper ">
										<div id="wd-5f43d071255d3" class=" woodmart-info-box text-left box-icon-align-left box-style- color-scheme-light woodmart-bg-none box-title-small vc_custom_1534425971123">
												<div class="box-icon-wrapper box-with-icon box-icon-simple">
													<div class="info-box-icon">
														<div class="info-svg-wrapper info-icon" style="width: 55px;height: 55px;">
															<i class="fas fa-file-invoice-dollar" style="font-size: 3rem; color: #acd303"></i>
														</div>
													</div>
												</div>
												<div class="info-box-content">
													<h4 class="info-box-title woodmart-font-weight- box-title-style-default">Procesa la orden de compra.</h4>
													<div class="info-box-inner reset-mb-10">
														<p>Te contactaremos a la brevedad.</p>
													</div>
												</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="vc_row-full-width vc_clearfix"></div>
					<style data-type="vc_shortcodes-custom-css">.vc_custom_1540559540760{border-bottom-width:1px!important;padding-top:30px!important;background-color:#311373eb!important;border-bottom-color:rgba(255,255,255,.1)!important;border-bottom-style:solid!important}.vc_custom_1540560021175{border-bottom-width:1px!important;padding-top:4vh!important;background-color:#092143!important;border-bottom-color:rgba(255,255,255,.1)!important;border-bottom-style:solid!important}.vc_custom_1534492919042{margin-bottom:-40px!important;padding-top:30px!important;background-color:#092143!important}.vc_custom_1533821559545{margin-bottom:30px!important;padding-top:0px!important}.vc_custom_1533821564252{margin-bottom:30px!important;padding-top:0px!important}.vc_custom_1533821570339{margin-bottom:30px!important;padding-top:0px!important}.vc_custom_1533821575175{margin-bottom:30px!important;padding-top:0px!important}.vc_custom_1534746579141{margin-bottom:0px!important;border-right-width:1px!important;border-right-color:rgba(255,255,255,.1)!important;border-right-style:solid!important}.vc_custom_1534746584202{margin-bottom:0px!important;border-right-width:1px!important;border-right-color:rgba(255,255,255,.1)!important;border-right-style:solid!important}.vc_custom_1534746589359{margin-bottom:0px!important;border-right-width:1px!important;border-right-color:rgba(255,255,255,.1)!important;border-right-style:solid!important}.vc_custom_1534425971123{margin-bottom:0px!important}.vc_custom_1534431258774{margin-bottom:4vh!important;padding-top:0px!important}.vc_custom_1534431265256{margin-bottom:4vh!important;padding-top:0px!important}.vc_custom_1534431270210{margin-bottom:4vh!important;padding-top:0px!important}.vc_custom_1534431274761{margin-bottom:4vh!important;padding-top:0px!important}.vc_custom_1534431567733{margin-bottom:4vh!important;padding-top:0px!important}.vc_custom_1534759088536{margin-bottom:15px!important}.vc_custom_1533717079868{margin-bottom:10px!important}.vc_custom_1533717043002{margin-bottom:15px!important}.vc_custom_1534429271599{margin-bottom:0px!important}.vc_custom_1533821739563{margin-bottom:30px!important;padding-top:0px!important}.vc_custom_1533821744603{margin-bottom:30px!important;padding-top:0px!important}.vc_custom_1533821749683{margin-bottom:30px!important;padding-top:0px!important}.vc_custom_1533718008083{margin-bottom:15px!important}.vc_custom_1533718014428{margin-bottom:15px!important}.vc_custom_1533717726660{margin-bottom:10px!important}</style>
				</div>
			</div>
			<footer class="footer-container color-scheme-light">
				<div class="container main-footer">
					<aside class="footer-sidebar widget-area row" role="complementary" style="padding-top: 20px">
						<div class="footer-column footer-column-1 col-12" style="margin-bottom: 20px">
							<div class="vc_row wpb_row vc_row-fluid vc_custom_1533821733353">
								<div class="wpb_column vc_column_container vc_col-sm-6 vc_col-lg-4 vc_col-md-4 vc_col-xs-6">
									<div class="vc_column-inner vc_custom_1533821739563">
										<div class="wpb_wrapper">
											<div id="wd-5f554393bee63"
												class="woodmart-text-block-wrapper color-scheme-light woodmart-title-size-custom woodmart-title-width-100 text-left vc_custom_1533718008083">
											</div>
											<div id="gallery_392" class="woodmart-images-gallery view-grid">
												<div class="gallery-images row woodmart-spacing-0">
													<div class="woodmart-gallery-item col-12">
														<?php
															$results = Doctrine_Query::create()
															->select('b.*')
															->from('Banners b')
															->where('b.posicion = ?', 'tipos_pago')
															->orderBy('orden')
															->limit(8)
															->execute();
														?>
														<?php foreach($results as $result) { ?>
															<img height="24" src="/uploads/banners/<?php echo $result->getUrlImagen(); ?>" class="woodmart-gallery-image image-1 attachment-full" 
														alt="">
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="wpb_column vc_column_container vc_col-sm-6 vc_col-lg-4 vc_col-md-4 vc_col-xs-6">
								</div>
								<div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-4 vc_col-md-4 vc_col-xs-12">
									<div class="vc_column-inner vc_custom_1533821749683">
										<div class="wpb_wrapper">
											<div id="wd-5f554393bf835" class="woodmart-text-block-wrapper color-scheme-light woodmart-title-size-custom woodmart-title-width-100 text-left vc_custom_1533717726660">
											</div>
											<div class="woodmart-social-icons text-left icons-design-colored icons-size-small color-scheme-dark social-share social-form-circle" style="float: right;">
												<?php foreach($socials as $social) { ?>
													<a rel="nofollow" href="<?php echo $social->getEnlace()?>" target="_blank" class="woodmart-social-icon <?php echo $social->getDescripcion()?>">
														<i></i>
														<span class="woodmart-social-icon-name"><?php echo $social->getNombre()?></span>
													</a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<style data-type="vc_shortcodes-custom-css">
								.vc_custom_1540563044667 {
									border-bottom-width: 1px !important;
									border-bottom-color: rgba(255, 255, 255, 0.1) !important;
									border-bottom-style: solid !important;
								}

								.vc_custom_1533821733353 {
									margin-top: 0px !important;
									margin-bottom: -30px !important;
								}

								.vc_custom_1533794029170 {
									margin-bottom: 4vh !important;
									padding-top: 0px !important;
								}

								.vc_custom_1533794022782 {
									margin-bottom: 4vh !important;
									padding-top: 0px !important;
								}

								.vc_custom_1533794012803 {
									margin-bottom: 4vh !important;
									padding-top: 0px !important;
								}

								.vc_custom_1533794007634 {
									margin-bottom: 4vh !important;
									padding-top: 0px !important;
								}

								.vc_custom_1540563035074 {
									margin-bottom: 4vh !important;
									padding-top: 0px !important;
								}

								.vc_custom_1534759080899 {
									margin-bottom: 15px !important;
								}

								.vc_custom_1533717079868 {
									margin-bottom: 10px !important;
								}

								.vc_custom_1533717043002 {
									margin-bottom: 15px !important;
								}

								.vc_custom_1534746249242 {
									margin-bottom: 0px !important;
								}

								.vc_custom_1533821739563 {
									margin-bottom: 0px !important;
									padding-top: 0px !important;
								}

								.vc_custom_1533821744603 {
									margin-bottom: 30px !important;
									padding-top: 0px !important;
								}

								.vc_custom_1533821749683 {
									margin-bottom: 0px !important;
									padding-top: 0px !important;
								}

								.vc_custom_1533718008083 {
									margin-bottom: 15px !important;
								}

								.vc_custom_1540563103898 {
									margin-bottom: 0px !important;
								}

								.vc_custom_1533718014428 {
									margin-bottom: 15px !important;
								}

								.vc_custom_1540563107738 {
									margin-bottom: 0px !important;
								}

								.vc_custom_1533717726660 {
									margin-bottom: 10px !important;
								}
							</style>
						</div>
					</aside><!-- .footer-sidebar -->
				</div>
				<div class="copyrights-wrapper copyrights-centered">
					<div class="container">
						<div class="min-footer">
							<div class="col-left reset-mb-10">
								<small><a href="http://drogueria.com"><strong>DROGUESI</strong></a> <i class="fa fa-copyright"></i>
									<?php echo date("Y"); ?> CREADO POR <a href="mailto:juan9acosta@gmail.com"><strong>Juan Acosta</strong></a></small> </div>
						</div>
					</div>
				</div>
			</footer>
		</div>
		
		<div class="cart-widget-side" id="cart-widget-side">
			<div class="widget-heading">
				<h3 class="widget-title">Carrito</h3>
				<a href="#" class="close-side-widget wd-cross-button wd-with-text-left">cerrar</a>
			</div>
			<div class="widget woocommerce widget_shopping_cart">
				<div class="widget_shopping_cart_content" id="shopping_cart_content">
				</div>
			</div>
		</div>
		<script>
			function update_cart() {
				jQuery(function($) {
					$('#shopping_cart_content').load('<?php echo url_for('carrito/listado') ?>');
				});
			}
			function eliminar_item(id) {
				jQuery(function($) {
					$("#car_item_"+id).remove();
					$.get("<?php echo url_for('carrito/eliminarItem') ?>?id="+id, function(contador) {
						console.log(contador);
						update_cart();
					});
				});
			}
			jQuery(function($) {
				$('#shopping_cart_content').load('<?php echo url_for('carrito/listado') ?>');
				$("#btn_cart").on("click", function () { 
					update_cart(); 
				});
			});
		</script>

		<script>
			(function () {
				function maybePrefixUrlField() {
					if (this.value.trim() !== '' && this.value.indexOf('http') !== 0) {
						this.value = "http://" + this.value;
					}
				}
			var urlFields = document.querySelectorAll('.mc4wp-form input[type="url"]');
				if (urlFields) {
					for (var j = 0; j < urlFields.length; j++) {
						urlFields[j].addEventListener('blur', maybePrefixUrlField);
					}
				}
			})();
		</script>
		<script type="text/javascript">
			var c = document.body.className;
			c = c.replace(/woocommerce-no-js/, 'woocommerce-js');
			document.body.className = c;
		</script>
		<style id='woodmart-inline-css-inline-css' type='text/css'>
			#wd-5f55439394a4a .woodmart-title-container {
				font-size: 20px;
				line-height: 30px;
			}

			.tabs-wd-5f5543939dde6.tabs-design-simple .tabs-name {
				border-color: #f4a51c;
			}

			.tabs-wd-5f5543939dde6.tabs-design-default .products-tabs-title .tab-label:after,
			.tabs-wd-5f5543939dde6.tabs-design-alt .products-tabs-title .tab-label:after {
				background-color: #f4a51c;
			}

			.tabs-wd-5f5543939dde6.tabs-design-simple .products-tabs-title li.active-tab-title,
			.tabs-wd-5f5543939dde6.tabs-design-simple .owl-nav>div:hover,
			.tabs-wd-5f5543939dde6.tabs-design-simple .wrap-loading-arrow>div:not(.disabled):hover {
				color: #f4a51c;
			}

			.tabs-wd-5f552157546ce.tabs-design-simple .tabs-name {
				border-color: #83b735;
			}

			.tabs-wd-5f552157546ce.tabs-design-default .products-tabs-title .tab-label:after,
			.tabs-wd-5f552157546ce.tabs-design-alt .products-tabs-title .tab-label:after {
				background-color: #83b735;
			}
			.tabs-wd-5f552157546ce.tabs-design-simple .products-tabs-title li.active-tab-title,
			.tabs-wd-5f552157546ce.tabs-design-simple .owl-nav>div:hover,
			.tabs-wd-5f552157546ce.tabs-design-simple .wrap-loading-arrow>div:not(.disabled):hover {
				color: #83b735;
			}

			.tabs-wd-5f554306eb5ed.tabs-design-simple .tabs-name {
				border-color: #83b735;
			}

			.tabs-wd-5f554306eb5ed.tabs-design-default .products-tabs-title .tab-label:after,
			.tabs-wd-5f554306eb5ed.tabs-design-alt .products-tabs-title .tab-label:after {
				background-color: #83b735;
			}

			.tabs-wd-5f554306eb5ed.tabs-design-simple .products-tabs-title li.active-tab-title,
			.tabs-wd-5f554306eb5ed.tabs-design-simple .owl-nav>div:hover,
			.tabs-wd-5f554306eb5ed.tabs-design-simple .wrap-loading-arrow>div:not(.disabled):hover {
				color: #83b735;
			}

			#wd-5f554393bd961 .woodmart-text-block {
				font-size: 16px;
				line-height: 26px;
			}

			#wd-5f554393be2f2 .woodmart-text-block {
				font-size: 16px;
				line-height: 26px;
			}

			#wd-5f554393be312 .woodmart-text-block {
				font-size: 16px;
				line-height: 26px;
				color: #7c899c;
			}

			#wd-5f554393bee63 .woodmart-text-block {
				font-size: 16px;
				line-height: 26px;
			}

			#wd-5f554393bf4fe .woodmart-text-block {
				font-size: 16px;
				line-height: 26px;
			}

			#wd-5f554393bf835 .woodmart-text-block {
				font-size: 16px;
				line-height: 26px;
			}
		</style>
		<script type='text/javascript' id='woocommerce-js-extra'>
			var woocommerce_params = { "ajax_url": "\/wp-admin\/admin-ajax.php", "wc_ajax_url": "\/?wc-ajax=%%endpoint%%" };
		</script>
		<script type='text/javascript' src='/plugins/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.min.js?ver=4.4.1' id='woocommerce-js'></script>
		<script type='text/javascript' id='wc-cart-fragments-js-extra'>
			var wc_cart_fragments_params = { "ajax_url": "\/wp-admin\/admin-ajax.php", "wc_ajax_url": "\/?wc-ajax=%%endpoint%%", "cart_hash_key": "wc_cart_hash_8b445b4206b0c4ba56fab090fbfa237c", "fragment_name": "wc_fragments_8b445b4206b0c4ba56fab090fbfa237c", "request_timeout": "5000" };
		</script>
		<script type='text/javascript' src='/plugins/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min.js?ver=4.4.1' id='wc-cart-fragments-js'></script>
		<script type='text/javascript' src='/plugins/wp-content/plugins/js_composer/assets/js/dist/js_composer_front.min.js?ver=6.3.0' id='wpb_composer_front_js-js'></script>
		<script type='text/javascript' src='/plugins/wp-includes/js/imagesloaded.min.js?ver=4.1.4' id='imagesloaded-js'></script>
		<script type='text/javascript' src='/plugins/wp-content/themes/woodmart/js/owl.carousel.min.js?ver=5.2.0' id='woodmart-owl-carousel-js'></script>
		<script type='text/javascript' src='/plugins/wp-content/themes/woodmart/js/jquery.tooltips.min.js?ver=5.2.0' id='woodmart-tooltips-js'></script>
		<script type='text/javascript' src='/plugins/wp-content/themes/woodmart/js/jquery.magnific-popup.min.js?ver=5.2.0' id='woodmart-magnific-popup-js'></script>
		<script type='text/javascript' src='/plugins/wp-content/themes/woodmart/js/waypoints.min.js?ver=5.2.0' id='woodmart-waypoints-js'></script>
		<script type='text/javascript' src='/plugins/wp-content/themes/woodmart/js/jquery.nanoscroller.min.js?ver=5.2.0' id='woodmart-nanoscroller-js'></script>
		<script type='text/javascript' id='woodmart-theme-js-extra'>
			var woodmart_settings = { "variation_gallery_storage_method": "new", "elementor_no_gap": "enabled", "adding_to_cart": "Processing", "added_to_cart": "Product was successfully added to your cart.", "continue_shopping": "Continue shopping", "view_cart": "View Cart", "go_to_checkout": "Checkout", "loading": "Loading...", "countdown_days": "days", "countdown_hours": "hr", "countdown_mins": "min", "countdown_sec": "sc", "cart_url": "http:\/\/localhost:8090\/index.php\/cart\/", "ajaxurl": "http:\/\/localhost:8090\/wp-admin\/admin-ajax.php", "add_to_cart_action": "widget", "added_popup": "no", "categories_toggle": "yes", "enable_popup": "no", "popup_delay": "2000", "popup_event": "time", "popup_scroll": "1000", "popup_pages": "0", "promo_popup_hide_mobile": "yes", "product_images_captions": "no", "ajax_add_to_cart": "1", "all_results": "View all results", "product_gallery": { "images_slider": true, "thumbs_slider": { "enabled": true, "position": "bottom", "items": { "desktop": 4, "tablet_landscape": 3, "tablet": 4, "mobile": 3, "vertical_items": 3 } } }, "zoom_enable": "yes", "ajax_scroll": "yes", "ajax_scroll_class": ".main-page-wrapper", "ajax_scroll_offset": "100", "infinit_scroll_offset": "300", "product_slider_auto_height": "no", "price_filter_action": "click", "product_slider_autoplay": "", "close": "Close (Esc)", "share_fb": "Share on Facebook", "pin_it": "Pin it", "tweet": "Tweet", "download_image": "Download image", "cookies_version": "1", "header_banner_version": "1", "promo_version": "1", "header_banner_close_btn": "1", "header_banner_enabled": "", "whb_header_clone": "\n    <div class=\"whb-sticky-header whb-clone whb-main-header <%wrapperClasses%>\">\n        <div class=\"<%cloneClass%>\">\n            <div class=\"container\">\n                <div class=\"whb-flex-row whb-general-header-inner\">\n                    <div class=\"whb-column whb-col-left whb-visible-lg\">\n                        <%.site-logo%>\n                    <\/div>\n                    <div class=\"whb-column whb-col-center whb-visible-lg\">\n                        <%.main-nav%>\n                    <\/div>\n                    <div class=\"whb-column whb-col-right whb-visible-lg\">\n                        <%.woodmart-header-links%>\n                        <%.search-button:not(.mobile-search-icon)%>\n\t\t\t\t\t\t<%.woodmart-wishlist-info-widget%>\n                        <%.woodmart-compare-info-widget%>\n                        <%.woodmart-shopping-cart%>\n                        <%.full-screen-burger-icon%>\n                    <\/div>\n                    <%.whb-mobile-left%>\n                    <%.whb-mobile-center%>\n                    <%.whb-mobile-right%>\n                <\/div>\n            <\/div>\n        <\/div>\n    <\/div>\n", "pjax_timeout": "5000", "split_nav_fix": "", "shop_filters_close": "no", "woo_installed": "1", "base_hover_mobile_click": "no", "centered_gallery_start": "1", "quickview_in_popup_fix": "", "disable_nanoscroller": "enable", "one_page_menu_offset": "150", "hover_width_small": "1", "is_multisite": "", "current_blog_id": "1", "swatches_scroll_top_desktop": "", "swatches_scroll_top_mobile": "", "lazy_loading_offset": "0", "add_to_cart_action_timeout": "no", "add_to_cart_action_timeout_number": "3", "single_product_variations_price": "no", "google_map_style_text": "Custom style", "quick_shop": "yes", "sticky_product_details_offset": "150", "preloader_delay": "300", "comment_images_upload_size_text": "Some files are too large. Allowed file size is 1 MB.", "comment_images_count_text": "You can upload up to 3 images to your review.", "comment_images_upload_mimes_text": "You are allowed to upload images only in png, jpeg formats.", "comment_images_added_count_text": "Added %s image(s)", "comment_images_upload_size": "1048576", "comment_images_count": "3", "comment_images_upload_mimes": { "jpg|jpeg|jpe": "image\/jpeg", "png": "image\/png" }, "home_url": "http:\/\/localhost:8090\/", "shop_url": "http:\/\/localhost:8090\/index.php\/shop\/", "age_verify": "no", "age_verify_expires": "30", "cart_redirect_after_add": "no", "swatches_labels_name": "no", "product_categories_placeholder": "Select a category", "product_categories_no_results": "No matches found", "cart_hash_key": "wc_cart_hash_8b445b4206b0c4ba56fab090fbfa237c", "fragment_name": "wc_fragments_8b445b4206b0c4ba56fab090fbfa237c" };
		</script>
		<script type='text/javascript' src='/plugins/wp-content/themes/woodmart/js/functions.min.js?ver=5.2.0' id='woodmart-theme-js'></script>
		<script type='text/javascript' src='/plugins/wp-includes/js/underscore.min.js?ver=1.8.3' id='underscore-js'></script>
		<script type='text/javascript' id='wp-util-js-extra'>
			var _wpUtilSettings = { "ajax": { "url": "\/wp-admin\/admin-ajax.php" } };
		</script>
		<script type='text/javascript' src='/plugins/wp-includes/js/wp-util.min.js?ver=5.5.1' id='wp-util-js'></script>
		<script type='text/javascript' id='wc-add-to-cart-variation-js-extra'>
			var wc_add_to_cart_variation_params = { "wc_ajax_url": "\/?wc-ajax=%%endpoint%%", "i18n_no_matching_variations_text": "Sorry, no products matched your selection. Please choose a different combination.", "i18n_make_a_selection_text": "Please select some product options before adding this product to your cart.", "i18n_unavailable_text": "Sorry, this product is unavailable. Please choose a different combination." };
		</script>
		<script type='text/javascript' src='/plugins/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart-variation.min.js?ver=4.4.1' id='wc-add-to-cart-variation-js'></script>
		<script type='text/javascript' src='/plugins/wp-includes/js/wp-embed.min.js?ver=5.5.1' id='wp-embed-js'></script>
		<script type='text/javascript' src='/plugins/wp-content/themes/woodmart/js/jquery.autocomplete.min.js?ver=5.2.0' id='woodmart-autocomplete-js'></script>
		<script type='text/javascript' src='/plugins/wp-content/themes/woodmart/js/countdown.min.js?ver=5.2.0' id='woodmart-countdown-js'></script>
		<script type='text/javascript' src='/plugins/wp-content/plugins/mailchimp-for-wp/assets/js/forms.min.js?ver=4.8.1' id='mc4wp-forms-api-js'></script>
		<script type='text/javascript' src='/plugins/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min.js?ver=2.1.4' id='js-cookie-js'></script>
		<style>
			.vertical-menu {
				width: 100%;
    		padding: 1rem 0rem 1rem 1rem;
			}

			.vertical-menu a {
				background-color: #eee; /* Grey background color */
				color: black; /* Black text color */
				display: block; /* Make the links appear below each other */
				padding: 12px; /* Add some padding */
				text-decoration: none; /* Remove underline from links */
				text-transform: uppercase;
			}

			.vertical-menu a:hover {
				background-color: #06ac88; /* Dark grey background on mouse-over */
				color: #fff !important;
			}

			.vertical-menu a.active {
				background-color: #06ac88; /* Add a green color to the "active/current" link */
				color: white;
			}
			.button {
				padding: 12px 20px;
				font-size: 13px;
				line-height: 18px;
				color: #3E3E3E;
				position: relative;
				display: inline-flex;
				align-items: center;
				justify-content: center;
				outline: 0;
				border-width: 0;
				border-style: solid;
				border-color: transparent;
				border-radius: 0;
				box-shadow: none;
				vertical-align: middle;
				text-align: center;
				text-decoration: none;
				text-transform: uppercase;
				text-shadow: none;
				letter-spacing: .3px;
				font-weight: 600;
				cursor: pointer;
				transition: color .25s ease,background-color .25s ease,border-color .25s ease,box-shadow .25s ease,opacity .25s ease;
			}
			.ver_detalles {
				padding: 6px 20px;
				color: #fff;
				border-radius: 2px;
				background-color: #00ae89 !important;
				color: #fff;
			}
			.ver_detalles:hover {
				background-color: #0a9073 !important;
				color: #fff;
			}
			.card-primary {
				background-color: #fff;
				margin-bottom: 1rem;
			}
			.card-header {
				background-color: #41257e;
			}
			.card-title {
				color: #fff; padding: .75rem 1.25rem;
			}
			.card-body {
				padding: 0.8rem
			}
			.badge {
				display: inline-block;
				padding: .65em .8em;
				font-size: 95%;
				font-weight: 700;
				line-height: 1;
				text-align: center;
				white-space: nowrap;
				vertical-align: baseline;
				border-radius: .25rem;
				transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
				color: #fff;
			}
			.alert-info, .bg-info, .label-info {
				background-color: #17a2b8!important;
			}
			.alert-warning, .bg-warning, .label-warning {
				background-color: #ffc107!important;
			}
			.alert-success, .bg-success, .label-success {
				background-color: #28a745!important;
			}
			.alert-danger, .alert-error, .bg-danger, .label-danger {
				background-color: #dc3545!important;
			}
		</style>
		<div class="login-form-side">
			<?php if(!$sf_user->isAuthenticated()) { ?>
				<div class="widget-heading">
					<h3 class="widget-title">Iniciar Sesión</h3>
					<a href="#" class="close-side-widget wd-cross-button wd-with-text-left">cerrar</a>
				</div>
				<?php include_component('sfGuardAuth', 'signin'); ?>
			<?php } else { ?>
				<div class="widget-heading" style="border-bottom: none !important">
					<h3 class="widget-title"><?php echo $sf_user->getGuardUser()->getUsername(); ?></h3>
					<a href="#" class="close-side-widget wd-cross-button wd-with-text-left">cerrar</a>
					<?php
						$clientes = Doctrine_Query::create()
							->select('c.*')
							->from('Cliente c')
							->where('c.vendedor_01 =?', $sf_user->getGuardUser()->getId())
							->Orwhere('c.vendedor_02 =?', $sf_user->getGuardUser()->getId())
							->AndWhere('c.empresa_id =?', 11)
							->execute();
						$choices_cl = array();
						foreach ($clientes as $cliente) {
							$choices_cl[$cliente->getId()]=$cliente["full_name"];
						}
					?>
					<?php if(!empty($choices_cl)): ?>
						<table style="position: absolute; left: 1rem; top: 3.2rem; height: 60px">
							<tr>
								<td style="padding: 0px !important; width: 63%">
									<select class="form-control" style="border-radius: 0px" id="choices_cl">
										<?php $i=0; foreach($choices_cl as $index=>$data): ?>
											<?php
												if($i==0 && empty($sf_user->getGuardUser()->getClienteId())) {
													$user_update=Doctrine::getTable('SfGuardUser')->findOneBy('id',$sf_user->getGuardUser()->getId());
													$user_update->cliente_id=$index;
													$user_update->save();
												}
												$i++;
											?>
											<?php if($index==$sf_user->getGuardUser()->getClienteId()) { ?>
												<option value="<?php echo $index; ?>" selected><?php echo $data; ?></option>
											<?php } else {?>
												<option value="<?php echo $index; ?>"><?php echo $data; ?></option>
											<?php } ?>
										<?php endforeach; ?>
									</select>
								</td>
								<td style="padding: 0px !important">
									<span class="input-group-btn">
										<a href="#" class="button checkout wc-forward cmbiar" onclick="cambiar()">Cambiar</a>
									</span>
								</td>
							</tr>
						</table>
					<?php else: ?>
						<table style="position: absolute; left: 1rem; top: 3.2rem; height: 60px">
							<tr>
								<td style="padding: 0px !important; width: 63%">
									<select class="form-control" style="border-radius: 0px" id="choices_cl">
										<option value="<?php echo $sf_user->getGuardUser()->getClienteId(); ?>" selected><?php echo $sf_user->getGuardUser()->getCliente(); ?></option>
									</select>
								</td>
								<td style="padding: 0px !important">
									<span class="input-group-btn">
										<a href="#" class="button checkout wc-forward cmbiar" onclick="cambiar()">Cambiar</a>
									</span>
								</td>
							</tr>
						</table>
					<?php endif; ?>
					<script>
						function cambiar() {
							jQuery(function($) {
								var id = $('#choices_cl').val();
								if(id > 0) {
									var r = $.ajax({
										type: 'GET',
										url: '<?php echo url_for('inicio'); ?>/cambiar?userid=<?php echo $sf_user->getGuardUser()->getId(); ?>&id='+id,
										async: false
									}).responseText;
									if(r=="success") {
										window.location.replace("<?php echo url_for('orden_compra'); ?>");
									}
								}
							})
						};
					</script>
				</div>
				<div class="widget woocommerce widget_shopping_cart" style="margin-top: 30px">
					<div class="widget_shopping_cart_content" style="opacity: 1;">
						<div class="shopping-cart-widget-body woodmart-scroll">
							<div class="woodmart-scroll-content" style="max-height: none;">
								<div class="vertical-menu">
									<a id="menu_home" href="<?php echo url_for ('@inicio') ?>">Inicio</a>
									<a id="menu_ordenc" href="<?php echo url_for ('@orden_compra') ?>">Ordenes de Compra</a>
									<a id="menu_fact" href="<?php echo url_for ('@factura') ?>">Facturas</a>
									<a id="menu_notae" href="<?php echo url_for ('@nota_entrega') ?>">Notas de entrega</a>
									<a id="menu_cuentasc" href="<?php echo url_for ('@cuentas_cobrar') ?>">Cuentas por pagar</a>
									<a id="menu_rpago" href="<?php echo url_for ('@recibo_pago') ?>">Recibos de pago</a>
								</div>
							</div>
						</div>
						<div class="shopping-cart-widget-footer" style="border-top: 1px solid #e6e6e6;padding-top: 1rem;">
							<p class="woocommerce-mini-cart__buttons buttons" style="padding-right: 15px; padding-left: 15px;">
								<a href="<?php echo url_for ('@sf_guard_signout') ?>" class="button checkout wc-forward">Cerrar Sesión</a>
							</p>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<a href="#" class="scrollToTop">Ir Arriba</a>
		<script>
			window.onload = function() {
				jQuery(function($) {
					var path = $(location).attr('pathname').split("/");
					var module = path[2];

					switch(module) {
						case 'orden_compra':
							ModuleActive('menu_ordenc');
							break;
						case 'factura':
							ModuleActive('menu_fact');
							break;
						case 'nota_entrega':
							ModuleActive('menu_notae');
							break;
						case 'cuentas_cobrar':
							ModuleActive('menu_cuentasc');
							break;
						case 'recibo_pago':
							ModuleActive('menu_rpago');
							break;
						default:
							ModuleActive('menu_home');
							break;
					}
				});
			}
			function ModuleActive(activar) {
				jQuery(function($) {
					$('#'+activar).addClass('active');
				});
    	}
		</script>
	</body>
</html>