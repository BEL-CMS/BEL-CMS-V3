"use strict";
document.addEventListener("DOMContentLoaded", function () {

  $(function ($) {

    // preloader
    $(".preloader").delay(300).animate({
      "opacity": "0"
    }, 500, function () {
      $(".preloader").css("display", "none");
    });

    // Sticky Header
    var fixed_top = $(".header-section");
    $(window).on("scroll", function () {
      if ($(window).scrollTop() > 50) {
        fixed_top.addClass("animated fadeInDown header-fixed");
      }
      else {
        fixed_top.removeClass("animated fadeInDown header-fixed");
      }
    });

    // Scroll Top
    var ScrollTop = $(".scrollToTop");
    $(window).on('scroll', function () {
      if ($(this).scrollTop() < 600) {
        ScrollTop.removeClass("active");
      } else {
        ScrollTop.addClass("active");
      }
    });
    $('.scrollToTop').on('click', function () {
      $('html, body').animate({
        scrollTop: 0
      }, 600);
      return false;
    });

    // Header Dropdown Menu
    const mobileSize = window.matchMedia("(max-width: 1199px)");
    function handleMediaScreen(e) {
      if (e.matches) {
        $(".navbar-nav .sub").addClass("dropdown-menu");
        $(".navbar-nav .dropdown").removeClass("show-dropdown");
        $(".navbar-nav .sub").removeClass("sub-menu");

        $(".navbar-nav .dropdown-menu").parent("li").on('click', function (e) {
          if (e.target.className !== "dropdown-item") {
            $(this).find(">.dropdown-menu").toggle(300);
            e.stopPropagation();
          }
        });
      } else {
        $(".navbar-nav .dropdown-menu").parent("li").off("click");
        $("sub-dropdown").off("click");

        $(".navbar-nav .dropdown-menu").show();
        $(".navbar-nav .dropdown").addClass("show-dropdown");
        $(".navbar-nav .sub").addClass("sub-menu");
        $(".navbar-nav .sub").removeClass("dropdown-menu");
      }
    }
    handleMediaScreen(mobileSize);
    mobileSize.addEventListener("change", handleMediaScreen);

    // Custom Tabs
    $(".tablinks button").each(function () {
      var targetTab = $(this).closest(".singletab");
      targetTab.find(".tablinks button").each(function () {
        var navBtn = targetTab.find(".tablinks button");
        navBtn.on('click', function () {
          navBtn.removeClass('active');
          $(this).addClass('active');
          var indexNum = $(this).closest("li").index();
          var tabcontent = targetTab.find(".tabcontents .tabitem");
          $(tabcontent).removeClass('active');
          $(tabcontent).eq(indexNum).addClass('active');
        });
      });
    });

    // Box Style 
    const targetBtn = document.querySelectorAll('.box-style')
    if (targetBtn) {
      targetBtn.forEach((element) => {
        element.addEventListener('mousemove', (e) => {
          const x = e.offsetX + 'px';
          const y = e.offsetY + 'px';
          element.style.setProperty('--x', x);
          element.style.setProperty('--y', y);
        })
      })
    }

    // Btn Movement
    $(".box-style").each(function () {
      var btn_wrapper = $(this).closest(".btn-movement");
      btn_wrapper.find(".box-style").each(function () {
        $(btn_wrapper).on('mousemove', function (event) {
          var mouseX = event.pageX;
          var mouseY = event.pageY;
          var divX = $(btn_wrapper).offset().left + $(btn_wrapper).width() / 2;
          var divY = $(btn_wrapper).offset().top + $(btn_wrapper).height() / 2;
          var distanceX = mouseX - divX;
          var distanceY = mouseY - divY;
          $(btn_wrapper).css({
            transform: 'translate(' + distanceX / 5 + 'px, ' + distanceY / 5 + 'px)',
            transition: 'all 0.8s'
          });
        });
      });
    });

    // Mouse Follower
    const follower = document.querySelector(".mouse-follower .cursor-outline");
    const dot = document.querySelector(".mouse-follower .cursor-dot");
    if (follower, dot) {
      window.addEventListener("mousemove", (e) => {
        follower.animate(
          [
            {
              opacity: 1,
              left: `${e.clientX}px`,
              top: `${e.clientY}px`,
              easing: "ease-in-out"
            }
          ],
          {
            duration: 3000,
            fill: "forwards"
          }
        );
        dot.animate(
          [
            {
              opacity: 1,
              left: `${e.clientX}px`,
              top: `${e.clientY}px`,
              easing: "ease-in-out"
            }
          ],
          {
            duration: 1500,
            fill: "forwards"
          }
        );
      });
    }

    // Mouse Follower Hide Function
    $("a, button").on('mouseenter mouseleave', function () {
      $('.mouse-follower').toggleClass('hide-cursor');
    });
    $(window).on('resize', function () {
      if ($(window).width() < 1199) {
        $('.mouse-follower').addClass('hide-cursor');
      } else {
        $('.mouse-follower').removeClass('hide-cursor');
      }
    });
    if ($(window).width() < 1199) {
      $('.mouse-follower').addClass('hide-cursor');
    } else {
      $('.mouse-follower').removeClass('hide-cursor');
    }

    // Circle Text
    const text = document.querySelector(".text p");
    if (text) {
      text.innerHTML = text.innerText.split('').map(
        (char, i) =>
          `<span style="transform:rotate(${i * 10}deg)">${char}</span>`
      ).join('');
    }

    // counter Item Active Class
    var counterItem = $('.counter-section .single-box');
    $(counterItem).on('mouseenter mouseleave', function () {
      $(counterItem).removeClass('active-area');
      $(this).addClass('active-area');
    });

    // Sidebar Menu Active
    var sidebarBtn = $('.sidebar-wrapper .sidebar-close');
    var changeBtn = $('.sidebar-wrapper .sidebar-close i');
    var sidebarWrapper = $('.sidebar-wrapper');
    $(sidebarBtn).on('click', function () {
      $('.sidebar-wrapper').toggleClass('sidebar-active');
      if (sidebarWrapper.hasClass("sidebar-active")) {
        changeBtn.html("close");
      } else {
        changeBtn.html("menu_open");
      }
    });

    // Sidebar menu mobile active
    $('.mobile-menu').on('click', function () {
      $('.sidebar-wrapper').toggleClass('active-mobile sidebar-active');
      $('.mobile-menu i').toggleClass('menu-active');
      if ($('.mobile-menu i').hasClass("menu-active")) {
        $('.mobile-menu i').html("close");
      } else {
        $('.mobile-menu i').html("menu_open");
      }
    });

    // Header Active
    $('.single-item .cmn-head').on('click', function () {
      $(this).parents('.single-item').toggleClass('active');
      $(this).parents('.single-item').siblings().removeClass('active');
    });

    // Cart Item Remove
    $('.nav-items-wrapper .single-box .end-area').on('click', function () {
      $(this).parents('.single-box').slideToggle();
    });

    // comments-area
    $('.comments-area .reply-btn').on('click', function () {
      $(this).siblings('.comment-form').slideToggle();
    });

    // Social Item Remove
    $('.social-hide-btn').on('click', function () {
      $(this).parents(".single-box").toggleClass('active');
      if ($('.single-box').hasClass("active")) {
        $('.active .social-hide-btn i').html("remove");
      } else {
        $('.social-hide-btn i').html("add");
      }
    });

    // Password Show Hide
    $('.show-hide-pass').on('click', function () {
      var passwordInput = $($(this).siblings(".pass-box input"));
      var icon = $(this);
      if (passwordInput.attr("type") == "password") {
        passwordInput.attr("type", "text");
        icon.html("visibility");
      } else {
        passwordInput.attr("type", "password");
        icon.html("visibility_off");
      }
    });

    // Dropdown Active Remove
    $("section, .close-btn").on('click', function () {
      $('.single-item').removeClass('active');
    });

    // Navbar Active Class 
    var curUrl = $(location).attr('href');
    var terSegments = curUrl.split("/");
    var desired_segment = terSegments[terSegments.length - 1];
    var checkLink = $('.navbar-nav a[href="' + desired_segment + '"]');
    var targetClass = checkLink.addClass('active');
    targetClass.parents(".sub-dropdown").find("button").first().addClass('active');
    targetClass.parents(".show-dropdown").find("button").first().addClass('active');

    var checkLink = $('.sidebar-content .navbar-nav a[href="' + desired_segment + '"]');
    var targetClass = checkLink.addClass('active');
    targetClass.parents(".sub-dropdown").find("button").first().addClass('active');
    targetClass.parents(".show-dropdown").find("button").first().addClass('active');

    // Input Increase
    var minVal = 1, maxVal = 20;
    $(".increaseQty").on('click', function () {
      var $parentElm = $(this).parents(".qtySelector");
      $(this).addClass("clicked");
      setTimeout(function () {
        $(".clicked").removeClass("clicked");
      }, 100);
      var value = $parentElm.find(".qtyValue").val();
      if (value < maxVal) {
        value++;
      }
      $parentElm.find(".qtyValue").val(value);
    });
    $(".decreaseQty").on('click', function () {
      var $parentElm = $(this).parents(".qtySelector");
      $(this).addClass("clicked");
      setTimeout(function () {
        $(".clicked").removeClass("clicked");
      }, 100);
      var value = $parentElm.find(".qtyValue").val();
      if (value > 1) {
        value--;
      }
      $parentElm.find(".qtyValue").val(value);
    });

  });

});