// Traduccion
$.getJSON("js/lang.json", function(json){
  //Lenguaje por defecto de la página sessionStorage.setItem("lang", "idioma")"
  if(!localStorage.getItem("lang")){
    localStorage.setItem("lang", "en");
  }
  var lang = localStorage.getItem("lang");
  var doc = json;
  $('.lang').each(function(index, element){
    $(this).text(doc[lang][$(this).attr('key')]);
  });//Each

  $('.translate').click(function(){
    localStorage.setItem("lang", $(this).attr('id')) ;
    var lang = $(this).attr('id');
    var doc = json;
      $('.lang').each(function(index, element){
        $(this).text(doc[lang][$(this).attr('key')]);
      }); //Each
  }); //Funcion click
});//Get json AJAX



// Traduccion
$.getJSON("js/lang.json", function(json){
  //Lenguaje por defecto de la página sessionStorage.setItem("lang", "idioma")"
  if(!localStorage.getItem("lang")){
    localStorage.setItem("lang", "en");
  }
  var lang = localStorage.getItem("lang");
  var doc = json;
  $('.lang').each(function(index, element){
    $(this).text(doc[lang][$(this).attr('key')]);
  });//Each

  $('.translate').click(function(){
    localStorage.setItem("lang", $(this).attr('id')) ;
    var lang = $(this).attr('id');
    var doc = json;
      $('.lang').each(function(index, element){
        $(this).text(doc[lang][$(this).attr('key')]);
      }); //Each
  }); //Funcion click
});//Get json AJAX

// Galería paisajes: carga progresiva con botón "Ver más"
(function() {
  var $wrapper = $('#portfolioLoadMoreWrapper');
  var $btn = $('#portfolioLoadMoreBtn');
  var $btnLess = $('#portfolioShowLessBtn');
  var $counter = $('#portfolioCounterLabel');

  if (!$wrapper.length || !$btn.length) {
    return;
  }

  var initialVisible = parseInt($wrapper.data('initial-visible'), 10) || 8;
  var loadStep = parseInt($wrapper.data('load-step'), 10) || 4;
  var $items = $wrapper.find('.js-load-more-item');
  var visibleCount = initialVisible;

  function refreshIsotopeLayout() {
    if (typeof $.fn.isotope === 'function') {
      $wrapper.isotope('layout');
    }
  }

  function updateButtonVisibility() {
    $counter.text('Mostrando ' + visibleCount + ' de ' + $items.length + ' fotos');

    if (visibleCount >= $items.length) {
      $btn.addClass('d-none').removeClass('d-inline-flex');
    } else {
      $btn.removeClass('d-none').addClass('d-inline-flex');
    }

    if (visibleCount > initialVisible) {
      $btnLess.removeClass('d-none').addClass('d-inline-flex');
    } else {
      $btnLess.addClass('d-none').removeClass('d-inline-flex');
    }
  }

  $items.removeClass('d-none');
  $items.slice(initialVisible).addClass('d-none');

  if ($items.length <= initialVisible) {
    visibleCount = $items.length;
  }

  refreshIsotopeLayout();
  updateButtonVisibility();

  $btn.on('click', function() {
    var previousVisible = visibleCount;
    var nextVisible = Math.min(visibleCount + loadStep, $items.length);
    $items.slice(previousVisible, nextVisible).removeClass('d-none');
    visibleCount = nextVisible;

    updateButtonVisibility();
    refreshIsotopeLayout();

    var $firstNewItem = $items.eq(previousVisible);
    $('html, body').animate({
      scrollTop: $firstNewItem.offset().top - 140
    }, 350);
  });

  $btnLess.on('click', function() {
    if (visibleCount <= initialVisible) {
      return;
    }

    var newVisibleCount = Math.max(initialVisible, visibleCount - loadStep);
    $items.slice(newVisibleCount, visibleCount).addClass('d-none');
    visibleCount = newVisibleCount;
    updateButtonVisibility();
    refreshIsotopeLayout();

    var $targetItem = $items.eq(Math.max(visibleCount - 1, 0));
    $('html, body').animate({
      scrollTop: $targetItem.offset().top - 140
    }, 350);
  });
})();

//Envio de formulario
var btn2 = document.getElementById('enviarFormulario');
var emailjs;

document.getElementById('form')
 .addEventListener('submit', function(event){
   event.preventDefault();

   btn2.value = 'Enviando...';

   const serviceID = 'default_service';
   const templateID = 'template_rznvtvq';

   emailjs.sendForm(serviceID, templateID, this)
    .then(() => {
      btn2.value = 'Enviar ';
      alert('Enviado!');
    }, (err) => {
      btn2.value = 'Enviar';
      alert(JSON.stringify(err));
    });
});