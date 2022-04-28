$(document).ready(function () {
  $('.language__btn').click(function () {
    $(this).toggleClass('active');
    $(this).next().slideToggle();
  });
  $('.btn-leftMenu').click(function () {
    $(this).toggleClass('active');
    $('.main-menu').toggleClass('active');
  });
  $('.header__right .search__btnMob').click(function () {
    $(this).toggleClass('active');
    $(this).parent().toggleClass('open');
  });
  $('body').on('click', function(e) {
    if($('.language__btn').hasClass('active')){
      if (!$(e.target).closest(".language").length) {
        $('.language__btn').toggleClass('active');
        $('.language__btn').next().slideToggle();
      }
      e.stopPropagation();
    }
  });
  $('#public-content__slider .slider__big').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    asNavFor: '#public-content__slider .slider__small'
  });
  $('#public-content__slider .slider__small').slick({
    slidesToShow: 6,
    slidesToScroll: 1,
    asNavFor: '#public-content__slider .slider__big',
    dots: false,
    focusOnSelect: true,
    arrows: false,
      responsive: [
          {
              breakpoint: 600,
              settings: {
                  slidesToShow: 5,
                  slidesToScroll: 1
              }
          }
      ]
  });
    $('.img-popup').click(function () {
        $('#popups-image').toggleClass('open');
        $('#popups-image').find('img').attr('src',$(this).attr('src'));
    });
    $('.popups-wrapper__bgClose').click(function () {
        $('#popups-image').toggleClass('open');
    });

});
