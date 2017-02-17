// ======================================================================================== //
// =============================== DECLARATION DES VARIABLES ============================== //
// ======================================================================================== //

var fermer = 1; // 1 = menu mobile fermé ----- 0 = menu mobile ouvert

// ======================================================================================== //
// ===================== Fonction qui gère l'affichage du menu mobile ===================== //
// ======================================================================================== //
$(document).ready(function () {
      $( ".show-menu" ).click(function() {
  		$( "#content-menu" ).slideToggle( "slow", function() {
  		});
  		if (fermer == 1)
  		{
  			fermer = 0;
  		}
  		else
  		{
  			fermer = 1;
  		};
	});
});

// ======================================================================================== //
// ====== Fonction qui gère l'affichage du menu en fonction de la taille de l'écran ======= //
// ======================================================================================== //
$(document).ready(function () {
    $(window).resize(function() {
    	var w;
    	
		if (window.innerWidth) 
		{
			w = window.innerWidth;
		}
		else if (document.documentElement && document.documentElement.clientWidth) 
		{
			w = document.documentElement.clientWidth;
		}
		else if (document.body) 
		{
			w = document.body.clientWidth;
		}

		if (w >= 768) 
		{
			// SI la largeur est supérieur à 1050 px (non mobile) ALORS on affiche toujours le menu
			$( "#content-menu" ).show(0);
		}
		else if (w < 768 && fermer == 1)
		{
			// SI la largeur est inférieur à 1050 px (mobile) ET que le Menu est fermé ALORS on laisse le menu fermé jusqu'au clic du bouton .show-menu
			$( "#content-menu" ).hide(0);
		}
		else if (w < 768 && fermer == 0)
		{
			// SI la largeur est inférieur à 1050 px (mobile) ET que le Menu est ouvert ALORS on laisse le menu ouvert jusqu'au clic du bouton .show-menu
			$( "#content-menu" ).show(0);
		};
	});
});


// ======================================================================================== //
// ========= Fonction qui gère le scroll lorsque l'on clique sur un lien du menu ========== //
// ======================================================================================== //
$(document).ready(function() {
		$('.ancre').on('click', function() { // Au clic sur un élément
			var page = $(this).attr('href'); // Page cible
			var speed = 1000; // Durée de l'animation (en ms)
			$('html, body').animate( { scrollTop: $(page).offset().top }, speed ); // Go
			return false;
		});
});


// ======================================================================================== //
// ======================= Fonction qui gère le sous menu du compte ======================= //
// ======================================================================================== //
function sous_menu(numero) {
	var tableau = document.querySelectorAll("main > article");
	for (var i = 1; i <= tableau.length; i++) {
		if (i != numero) {
			document.getElementById("sous_menu-" + i).style.display = 'none';
		}
		else {
			document.getElementById("sous_menu-" + numero).style.display = 'block';
		}
	}
}

// ======================================================================================== //
// =========================== Fonction qui géolocalise le post =========================== //
// ======================================================================================== //

var latitude = document.getElementById("latitude");
var longitude = document.getElementById("longitude");
var addresspostale = document.getElementById("address");


function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(showPosition);
    } else { 
        latitude.innerHTML = "Geolocalisation non supportée par le navigateur";
        longitude.innerHTML = "Geolocalisation non supportée par le navigateur";
    }
}
    
function showPosition(position) {
	var latlng = "55.397563, 10.39870099999996";
	var url = "http://maps.googleapis.com/maps/api/geocode/json?latlng="+ position.coords.latitude+ ", " +position.coords.longitude + "&sensor=false";
		$.getJSON(url, function (data) {
        	var adress = data.results[0].formatted_address;
        	addresspostale.value = adress;
		});
    latitude.value = position.coords.latitude; 
    longitude.value = position.coords.longitude;

}
