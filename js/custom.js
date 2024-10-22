

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