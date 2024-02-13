/**
Demo script to handle the theme demo
**/
var Demo = function () {

    // Handle Theme Settings
    var handleTheme = function () {

        var panel = $('.theme-panel');

        if ($('.page-head > .container-fluid').size() === 1) {
            $('.theme-setting-layout', panel).val("fluid");
        } else {
            $('.theme-setting-layout', panel).val("boxed");
        }

        if ($('.top-menu li.dropdown.dropdown-dark').size() > 0) {
            $('.theme-setting-top-menu-style', panel).val("dark");
        } else {
            $('.theme-setting-top-menu-style', panel).val("light");
        }

        if ($('body').hasClass("page-header-top-fixed")) {
            $('.theme-setting-top-menu-mode', panel).val("fixed");
        } else {
            $('.theme-setting-top-menu-mode', panel).val("not-fixed");
        }

        if ($('.hor-menu.hor-menu-light').size() > 0) {
            $('.theme-setting-mega-menu-style', panel).val("light");
        } else {
            $('.theme-setting-mega-menu-style', panel).val("dark");
        }

        if ($('body').hasClass("page-header-menu-fixed")) {
            $('.theme-setting-mega-menu-mode', panel).val("fixed");
        } else {
            $('.theme-setting-mega-menu-mode', panel).val("not-fixed");
        }

        //handle theme layout
        var resetLayout = function () {
            $("body").
            removeClass("page-header-top-fixed").
            removeClass("page-header-menu-fixed");

            $('.page-header-top > .container-fluid').removeClass("container-fluid").addClass('container');
            $('.page-header-menu > .container-fluid').removeClass("container-fluid").addClass('container');
            $('.page-head > .container-fluid').removeClass("container-fluid").addClass('container');
            $('.page-content > .container-fluid').removeClass("container-fluid").addClass('container');
            $('.page-prefooter > .container-fluid').removeClass("container-fluid").addClass('container');
            $('.page-footer > .container-fluid').removeClass("container-fluid").addClass('container');              
        };

        var setLayout = function () {

            var layoutMode = $('.theme-setting-layout', panel).val();
            var headerTopMenuStyle = $('.theme-setting-top-menu-style', panel).val();
            var headerTopMenuMode = $('.theme-setting-top-menu-mode', panel).val();
            var headerMegaMenuStyle = $('.theme-setting-mega-menu-style', panel).val();
            var headerMegaMenuMode = $('.theme-setting-mega-menu-mode', panel).val();
            
            resetLayout(); // reset layout to default state

            if (layoutMode === "fluid") {
                $('.page-header-top > .container').removeClass("container").addClass('container-fluid');
                $('.page-header-menu > .container').removeClass("container").addClass('container-fluid');
                $('.page-head > .container').removeClass("container").addClass('container-fluid');
                $('.page-content > .container').removeClass("container").addClass('container-fluid');
                $('.page-prefooter > .container').removeClass("container").addClass('container-fluid');
                $('.page-footer > .container').removeClass("container").addClass('container-fluid');

                //Metronic.runResizeHandlers();
            }

            if (headerTopMenuStyle === 'dark') {
                $(".top-menu > .navbar-nav > li.dropdown").addClass("dropdown-dark");
            } else {
                $(".top-menu > .navbar-nav > li.dropdown").removeClass("dropdown-dark");
            }

            if (headerTopMenuMode === 'fixed') {
                $("body").addClass("page-header-top-fixed");
            } else {
                $("body").removeClass("page-header-top-fixed");
            }

            if (headerMegaMenuStyle === 'light') {
                $(".hor-menu").addClass("hor-menu-light");
            } else {
                $(".hor-menu").removeClass("hor-menu-light");
            }

            if (headerMegaMenuMode === 'fixed') {
                $("body").addClass("page-header-menu-fixed");
            } else {
                $("body").removeClass("page-header-menu-fixed");
            }          
        };

        // handle theme colors
        var setColor = function (color) {
            var color_ = (Metronic.isRTL() ? color + '-rtl' : color);
            $('#style_color').attr("href", Layout.getLayoutCssPath() + 'themes/' + color_ + ".css");
            $('.page-logo img').attr("src", Layout.getLayoutImgPath() + 'logo-' + color + '.png');
        };

        $('.theme-colors > li', panel).click(function () {
            var color = $(this).attr("data-theme");
            setColor(color);
            $('.theme-colors > li', panel).removeClass("active");
            $(this).addClass("active");
        });

        $('.theme-setting-top-menu-mode', panel).change(function(){
            var headerTopMenuMode = $('.theme-setting-top-menu-mode', panel).val();
            var headerMegaMenuMode = $('.theme-setting-mega-menu-mode', panel).val();            

            if (headerMegaMenuMode === "fixed") {
                alert("The top menu and mega menu can not be fixed at the same time.");
                $('.theme-setting-mega-menu-mode', panel).val("not-fixed");   
                headerTopMenuMode = 'not-fixed';
            }                
        });

        $('.theme-setting-mega-menu-mode', panel).change(function(){
            var headerTopMenuMode = $('.theme-setting-top-menu-mode', panel).val();
            var headerMegaMenuMode = $('.theme-setting-mega-menu-mode', panel).val();            

            if (headerTopMenuMode === "fixed") {
                alert("The top menu and mega menu can not be fixed at the same time.");
                $('.theme-setting-top-menu-mode', panel).val("not-fixed");   
                headerTopMenuMode = 'not-fixed';
            }                
        });

        $('.theme-setting', panel).change(setLayout);

        $('.theme-setting-layout', panel).change(function(){
            Index.redrawCharts();  // reload the chart on layout width change
        });
    };

    // handle theme style
    var setThemeStyle = function(style) {
        var file = (style === 'rounded' ? 'components-rounded' : 'components');
        file = (Metronic.isRTL() ? file + '-rtl' : file);

        $('#style_components').attr("href", Metronic.getGlobalCssPath() + file + ".css");

        if ($.cookie) {
            $.cookie('layout-style-option', style);
        }


    };

    return {

        //main function to initiate the theme
        init: function() {
            // handles style customer tool
            handleTheme(); 

            // handle layout style change
            $('.theme-panel .theme-setting-style').change(function() {
                 setThemeStyle($(this).val());
            });

            // set layout style from cookie
            if ($.cookie && $.cookie('layout-style-option') === 'rounded') {
                setThemeStyle($.cookie('layout-style-option'));  
                $('.theme-panel .theme-setting-style').val($.cookie('layout-style-option'));
            }            
        }
    };

}();


/**
Core script to handle the entire theme and core functions
**/
var Layout = function () {

    var layoutImgPath = 'admin/layout3/img/';

    var layoutCssPath = 'admin/layout3/css/';

    //* BEGIN:CORE HANDLERS *//
    // this function handles responsive layout on screen size resize or mobile device rotate.

    // Handles header
    var handleHeader = function () {        
        // handle search box expand/collapse        
        $('.page-header').on('click', '.search-form', function (e) {
            $(this).addClass("open");
            $(this).find('.form-control').focus();

            $('.page-header .search-form .form-control').on('blur', function (e) {
                $(this).closest('.search-form').removeClass("open");
                $(this).unbind("blur");
            });
        });

        // handle hor menu search form on enter press
        $('.page-header').on('keypress', '.hor-menu .search-form .form-control', function (e) {
            if (e.which == 13) {
                $(this).closest('.search-form').submit();
                return false;
            }
        });

        // handle header search button click
        $('.page-header').on('mousedown', '.search-form.open .submit', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('.search-form').submit();
        });
    };

    // Handles main menu
    var handleMainMenu = function () {

        // handle menu toggler icon click
        $(".page-header .menu-toggler").on("click", function(event) {
            if (Metronic.getViewPort().width < 992) {
                var menu = $(".page-header .page-header-menu");
                if (menu.hasClass("page-header-menu-opened")) {
                    menu.slideUp(300);
                    menu.removeClass("page-header-menu-opened");
                } else {
                    menu.slideDown(300);
                    menu.addClass("page-header-menu-opened");
                }

                if ($('body').hasClass('page-header-top-fixed')) {
                    Metronic.scrollTop();
                }
            }
        });

        // handle sub dropdown menu click for mobile devices only
        $(".dropdown-submenu > a").on("click", function(e) {
            if (Metronic.getViewPort().width < 992) {
                if ($(this).next().hasClass('dropdown-menu')) {
                    e.stopPropagation();

                    if ($(this).parent().hasClass("open")) {
                        $(this).parent().removeClass("open");
                        $(this).next().hide();
                    } else {
                        $(this).parent().addClass("open");
                        $(this).next().show();
                    }
                }
            }
        });

        // handle hover dropdown menu for desktop devices only
        if (Metronic.getViewPort().width >= 992) {
            $('[data-hover="megamenu-dropdown"]').not('.hover-initialized').each(function() {   
                $(this).dropdownHover(); 
                $(this).addClass('hover-initialized'); 
            });
        }
        
        $(document).on('click', '.mega-menu-dropdown .dropdown-menu', function (e) {
            e.stopPropagation();
        });

        // handle fixed mega menu(minimized) 
        $(window).scroll(function() {                
            var offset = 75;
            if ($('body').hasClass('page-header-menu-fixed')) {
                if ($(window).scrollTop() > offset){
                    $(".page-header-menu").addClass("fixed");
                } else {
                    $(".page-header-menu").removeClass("fixed");  
                }
            }

            if ($('body').hasClass('page-header-top-fixed')) {
                if ($(window).scrollTop() > offset){
                    $(".page-header-top").addClass("fixed");
                } else {
                    $(".page-header-top").removeClass("fixed");  
                }
            }
        });
    };

    // Handle sidebar menu links
    var handleMainMenuActiveLink = function(mode, el) {
        var url = location.hash.toLowerCase();    

        var menu = $('.hor-menu');

        if (mode === 'click' || mode === 'set') {
            el = $(el);
        } else if (mode === 'match') {
            menu.find("li > a").each(function() {
                var path = $(this).attr("href").toLowerCase();       
                // url match condition         
                if (path.length > 1 && url.substr(1, path.length - 1) == path.substr(1)) {
                    el = $(this);
                    return; 
                }
            });
        }

        if (!el || el.size() == 0) {
            return;
        }

        if (el.attr('href').toLowerCase() === 'javascript:;' || el.attr('href').toLowerCase() === '#') {
            return;
        }        

        // disable active states
        menu.find('li.active').removeClass('active');
        menu.find('li > a > .selected').remove();
        menu.find('li.open').removeClass('open');

        el.parents('li').each(function () {
            $(this).addClass('active');

            if ($(this).parent('ul.navbar-nav').size() === 1) {
                $(this).find('> a').append('<span class="selected"></span>');
            }
        });
    };

    // Handles main menu on window resize
    var handleMainMenuOnResize = function() {
        // handle hover dropdown menu for desktop devices only
        var width = Metronic.getViewPort().width;
        var menu = $(".page-header-menu");
            
        if (width >= 992 && menu.data('breakpoint') !== 'desktop') { 
            menu.data('breakpoint', 'desktop');
            $('.hor-menu [data-hover="megamenu-dropdown"]').not('.hover-initialized').each(function() {   
                $(this).dropdownHover(); 
                $(this).addClass('hover-initialized'); 
            });
            $('.hor-menu .navbar-nav li.open').removeClass('open');
            $(".page-header-menu").css("display", "block").removeClass('page-header-menu-opened');
        } else if (width < 992 && menu.data('breakpoint') !== 'mobile') {
            menu.data('breakpoint', 'mobile');
            // disable hover bootstrap dropdowns plugin
            $('.hor-menu [data-hover="megamenu-dropdown"].hover-initialized').each(function() {   
                $(this).unbind('hover');
                $(this).parent().unbind('hover').find('.dropdown-submenu').each(function() {
                    $(this).unbind('hover');
                });
                $(this).removeClass('hover-initialized');    
            });
        }
    };

    var handleContentHeight = function() {
        var height;

        if ($('body').height() < Metronic.getViewPort().height) {            
            height = Metronic.getViewPort().height -
                $('.page-header').outerHeight() - 
                ($('.page-container').outerHeight() - $('.page-content').outerHeight()) -
                $('.page-prefooter').outerHeight() - 
                $('.page-footer').outerHeight();

            $('.page-content').css('min-height', height);
        }
    };

    // Handles the go to top button at the footer
    var handleGoTop = function () {
        var offset = 100;
        var duration = 500;

        if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {  // ios supported
            $(window).bind("touchend touchcancel touchleave", function(e){
               if ($(this).scrollTop() > offset) {
                    $('.scroll-to-top').fadeIn(duration);
                } else {
                    $('.scroll-to-top').fadeOut(duration);
                }
            });
        } else {  // general 
            $(window).scroll(function() {
                if ($(this).scrollTop() > offset) {
                    $('.scroll-to-top').fadeIn(duration);
                } else {
                    $('.scroll-to-top').fadeOut(duration);
                }
            });
        }
        
        $('.scroll-to-top').click(function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, duration);
            return false;
        });
    };

    //* END:CORE HANDLERS *//

    return {
        
        // Main init methods to initialize the layout
        // IMPORTANT!!!: Do not modify the core handlers call order.

        initHeader: function() {
            handleHeader(); // handles horizontal menu    
            handleMainMenu(); // handles menu toggle for mobile
            Metronic.addResizeHandler(handleMainMenuOnResize); // handle main menu on window resize

            if (Metronic.isAngularJsApp()) {      
                handleMainMenuActiveLink('match'); // init sidebar active links 
            }
        },

        initContent: function() {
            handleContentHeight(); // handles content height 
        },

        initFooter: function() {
            handleGoTop(); //handles scroll to top functionality in the footer
        },

        init: function () {            
            this.initHeader();
            this.initContent();
            this.initFooter();
        },

        setMainMenuActiveLink: function(mode, el) {
            handleMainMenuActiveLink(mode, el);
        },

        closeMainMenu: function() {
            $('.hor-menu').find('li.open').removeClass('open');

            if (Metronic.getViewPort().width < 992 && $('.page-header-menu').is(":visible")) { // close the menu on mobile view while laoding a page 
                $('.page-header .menu-toggler').click();
            }
        },

        getLayoutImgPath: function() {
            return Metronic.getAssetsPath() + layoutImgPath;
        },

        getLayoutCssPath: function() {
            return Metronic.getAssetsPath() + layoutCssPath;
        }
    };

}();