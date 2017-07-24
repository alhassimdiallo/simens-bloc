var base_url = window.location.toString();
var tabUrl = base_url.split("public");
var genreMaman = 0;
$(function() {
	//GESTION DES ACCORDEONS
	//GESTION DES ACCORDEONS
	//GESTION DES ACCORDEONS
	//$( "#accordionss" ).accordion(); //sous accordeon
    //$( "#accordions" ).accordion();
    
/********************************************************************************************/
/********************************************************************************************/ 
    //BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
    function confirmation(){
	  $( "#confirmation" ).dialog({
	    resizable: false,
	    height:170,
	    width:485,
	    autoOpen: false,
	    modal: true,
	    buttons: {
	        "Oui": function() {
	            $( this ).dialog( "close" );

	             $('#photo').children().remove(); 
	             $('<input type="file" />').appendTo($('#photo')); 
	             $("#div_supprimer_photo").children().remove();
	             Recupererimage();          	       
	    	     return false;
	    	     
	        },
	        "Annuler": function() {
                $( this ).dialog( "close" );
            }
	   }
	  });
    }
    //FONCTION QUI RECUPERE LA PHOTO ET LA PLACE SUR L'EMPLACEMENT SOUHAITE
    function Recupererimage(){
    	$('#photo input[type="file"]').change(function() {
    	  
    	   var file = $(this);
 		   var reader = new FileReader;
 		   
	       reader.onload = function(event) {
	    		var img = new Image();
                 
        		img.onload = function() {
				   var width  = 105;
				   var height = 105;
				
				   var canvas = $('<canvas></canvas>').attr({ width: width, height: height });
				   file.replaceWith(canvas);
				   var context = canvas[0].getContext('2d');
	        	    	context.drawImage(img, 0, 0, width, height);
			    };
			    document.getElementById('fichier_tmp').value = img.src = event.target.result;
			   
    	};
    	 $("#modifier_photo").remove(); //POUR LA MODIFICATION
    	reader.readAsDataURL(file[0].files[0]);
    	//Crï¿½ation de l'onglet de suppression de la photo
    	$("#div_supprimer_photo").children().remove();
    	$('<input alt="supprimer_photo" title="Supprimer la photo" name="supprimer_photo" id="supprimer_photo">').appendTo($("#div_supprimer_photo"));
      
    	//SUPPRESSION DU PHOTO
        //SUPPRESSION DU PHOTO
          $("#supprimer_photo").click(function(e){
        	 e.preventDefault();
        	 confirmation();
             $("#confirmation").dialog('open');
          });
      });
    	     
    }
    //AJOUTER LA PHOTO DU PATIENT
    //AJOUTER LA PHOTO DU PATIENT
    Recupererimage();
    
    //AJOUT LA PHOTO DU PATIENT EN CLIQUANT SUR L'ICONE AJOUTER
    //AJOUT LA PHOTO DU PATIENT EN CLIQUANT SUR L'ICONE AJOUTER
    $("#ajouter_photo").click(function(e){
    	e.preventDefault();
    });
    
    //VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
    //VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
    //VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
    
            var      nom = $("#NOM");
            var   prenom = $("#PRENOM");
            var     sexe = $("#SEXE");
            var date_naissance = $("#DATE_NAISSANCE");
            var lieu_naissance = $("#LIEU_NAISSANCE");
            var nationalite_origine = $("#NATIONALITE_ORIGINE");
            var nationalite_actuelle = $("#NATIONALITE_ACTUELLE");
            var     adresse = $("#ADRESSE");
            var   telephone = $("#TELEPHONE");
            var       email = $("#EMAIL");
            var  profession = $("#PROFESSION");
            var  age_ = $("#AGE");
    	
    //$( "button" ).button(); // APPLICATION DU STYLE POUR LES BOUTONS
    var mdclick = 0;
  	$( "#modifer_donnees" ).click(function(){
  		
    		if(mdclick == 1){
               nom.attr( 'readonly', false );    
            prenom.attr( 'readonly', false );  
              sexe.attr( 'readonly', false );
    date_naissance.attr( 'readonly', false );
    lieu_naissance.attr( 'readonly', false );
    nationalite_origine.attr( 'readonly', false );
    nationalite_actuelle.attr( 'readonly', false );
        adresse.attr( 'readonly', false );
      telephone.attr( 'readonly', false );
          email.attr( 'readonly', false );
     profession.attr( 'readonly', false );
     age_.attr( 'readonly', false );
     
    			mdclick = 0;
    		} else { 
	            nom.attr( 'readonly', true );    
	         prenom.attr( 'readonly', true );  
	           sexe.attr( 'readonly', true );
     date_naissance.attr( 'readonly', true );
     lieu_naissance.attr( 'readonly', true );
     nationalite_origine.attr( 'readonly', true );
     nationalite_actuelle.attr( 'readonly', true );
          adresse.attr( 'readonly', true );
        telephone.attr( 'readonly', true );
            email.attr( 'readonly', true );
       profession.attr( 'readonly', true );
       age_.attr( 'readonly', true );
       
    			mdclick = 1;
    		}
          
  	});
  	
  	//MENU GAUCHE
  	//MENU GAUCHE
  	
  	$("#vider").click(function(){
  		$('#LIEU_NAISSANCE').val('');
  		$('#EMAIL').val('');
  		$('#NOM').val('');
  		$('#TELEPHONE').val('');
  		//$('#NATIONALITE_ORIGINE').val('');
  		$('#PRENOM').val('');
  		//$('#NATIONALITE_ACTUELLE').val('');
  		$('#DATE_NAISSANCE').val('');
  		$('#ADRESSE').val('');
  		if(genreMaman != 1) {	$('#SEXE').val(''); }
  		$('#PROFESSION').val('');
  		return false;
  	});
  	
  	
 
  		$('#vider_champ').hover(function(){
  			
  			 $(this).css('background','url("'+tabUrl[0]+'public/images_icons/annuler2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("'+tabUrl[0]+'public/images_icons/annuler1.png") no-repeat right top');
  	    });

  		$('#div_supprimer_photo').hover(function(){
  			
  			 $(this).css('background','url("'+tabUrl[0]+'public/images_icons/mod2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("'+tabUrl[0]+'public/images_icons/mod.png") no-repeat right top');
  	    });

  		$('#div_ajouter_photo').hover(function(){
  			
  			 $(this).css('background','url("'+tabUrl[0]+'public/images_icons/ajouterphoto2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("'+tabUrl[0]+'public/images_icons/ajouterphoto.png") no-repeat right top');
  	    });

  		$('#div_modifier_donnees').hover(function(){
  			
  			 $(this).css('background','url("'+tabUrl[0]+'public/images_icons/modifier2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("'+tabUrl[0]+'public/images_icons/modifier.png") no-repeat right top');
  	   });
  
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  		
  		$('#DATE_NAISSANCE').datepicker(
    			$.datepicker.regional['fr'] = {
    					closeText: 'Fermer',
    					changeYear: true,
    					yearRange: 'c-80:c',
    					prevText: '&#x3c;PrÃ©c',
    					nextText: 'Suiv&#x3e;',
    					currentText: 'Courant',
    					monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
    					'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
    					monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Juin',
    					'Jul','Aout','Sep','Oct','Nov','Dec'],
    					dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
    					dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
    					dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
    					weekHeader: 'Sm',
    					dateFormat: 'dd/mm/yy',
    					firstDay: 1,
    					isRTL: false,
    					showMonthAfterYear: false,
    					yearRange: '1900:2050',
    					showAnim : 'bounce',
    					changeMonth: true,
    					changeYear: true,
    					yearSuffix: '',
    					maxDate: 0
    			}
    	);
  		

  		function lesMois(n)
  		{
  			switch(n) {
  			  case 1: return "January";
  			  case 2: return "February";
  			  case 3: return "March";
  			  case 4: return "April";
  			  case 5: return "May";
  			  case 6: return "June";
  			  case 7: return "July";
  			  case 8: return "August";
  			  case 9: return "September";
  			  case 10: return "October";
  			  case 11: return "November";
  			  case 12: return "December";
  			}
  		}
  		
  		function age(birthday)
  		{
  			birthday = new Date(birthday);
  			return parseInt( new Number((new Date().getTime() - birthday.getTime()) / 31536000000));
  		}

  		$('#DATE_NAISSANCE').change(function(){

  			var date = $('#DATE_NAISSANCE').val(); 
  			var mois = parseInt(date[3]+''+date[4]);
  			var moisEnLettre = lesMois(mois);
  		    var birthday = date[0]+date[1]+' '+moisEnLettre+' '+date[6]+date[7]+date[8]+date[9];
  		    var Age = age(birthday);
 
  		    if( date && !isNaN(Age)){
  		    	$('#AGE').val(Age).attr('readonly', true).css('background','#efefef');
  		    }else{
  		    	$('#AGE, #DATE_NAISSANCE').val('').attr('readonly', false).css('background','#ffffff');
  		    }

  		});
  		
  		function miseAJourAge(date){
  			var mois = parseInt(date[3]+''+date[4]);
  			var moisEnLettre = lesMois(mois);
  		    var birthday = date[0]+date[1]+' '+moisEnLettre+' '+date[6]+date[7]+date[8]+date[9];
  		    var Age = age(birthday);
  		}
  		
});



//GESTION DES ALERTES DES PATIENTS DEJA EXISTANTS
//GESTION DES ALERTES DES PATIENTS DEJA EXISTANTS
//GESTION DES ALERTES DES PATIENTS DEJA EXISTANTS
function nbOccurrenceElement(myarray, element){
	
	var indices = [];
	var idx = myarray.indexOf(element);
	
	while (idx != -1) {
	  indices.push(idx);
	  idx = myarray.indexOf(element, idx + 1);
	}

	return indices.length;
}


function alertPatientExistant(myarray, myarrayId, myarrayAge, myarrayTelephone){
	
	$(function(){ 
	  
		var sexeSaisi = "";
		var nomSaisi = "";
		var prenomSaisi = "";
	  
		$('#SEXE').change(function(){
			sexeSaisi = $(this).val();
			
			var valeurSaisie = (sexeSaisi+''+nomSaisi+''+prenomSaisi).toLowerCase().replace(/ /g,"");
			var valeurRecherche = $.inArray(valeurSaisie, myarray);
			
			if( valeurRecherche > -1 ){ 
				
				var nbOccEl = nbOccurrenceElement(myarray, valeurSaisie);
				
				//Affichage des données
				$('.alertPrenom').html(prenomSaisi);
				$('.alertNom').html(nomSaisi);
				$('.alertAge').html(myarrayAge[valeurSaisie]);
				if(myarrayId[valeurSaisie]){
					$('.alertVisualiserLien').html("<a href='"+tabUrl[0]+"public/facturation/info-patient/id_patient/"+myarrayId[valeurSaisie]+"'>  <img style='width: 25px; height: 16px; cursor: pointer;' src='../images_icons/voir2.png' /> </a>");
					$('.alertModifierLien').html("<a href='"+tabUrl[0]+"public/facturation/modifier/id_patient/"+myarrayId[valeurSaisie]+"'>  <img style='width: 24px; height: 25px; cursor: pointer;' src='../images_icons/2.png' /> </a>");					
				}
				if(myarrayTelephone[valeurSaisie]){ $('.alertTel').html(myarrayTelephone[valeurSaisie]); }else{ $('.alertTel').html('n&eacute;ant'); }
				
				//Afficher le nombre d'éléments s'il y en a plus d'un
				if(nbOccEl > 1){
					$('.alertNbPatient').html("<a href='"+tabUrl[0]+"public/facturation/liste-patient' style='color: red;' > "+nbOccEl+" </a>");					
				}
				
				$('#clickOuvrirPopup').trigger('click');
				//setTimeout(function(){ $('#volet').trigger('dblclick'); }, 30000);
			}else{
				$('#volet').trigger('dblclick');
			}

		});

	
		$('#NOM').change(function(){
			nomSaisi = $(this).val();
		  
			var valeurSaisie = (sexeSaisi+''+nomSaisi+''+prenomSaisi).toLowerCase().replace(/ /g,"");
			var valeurRecherche = $.inArray(valeurSaisie, myarray);
			
			if( valeurRecherche > -1 ){ 
				
				var nbOccEl = nbOccurrenceElement(myarray, valeurSaisie);
				
				//Affichage des données
				$('.alertPrenom').html(prenomSaisi);
				$('.alertNom').html(nomSaisi);
				$('.alertAge').html(myarrayAge[valeurSaisie]);
				if(myarrayId[valeurSaisie]){
					$('.alertVisualiserLien').html("<a href='"+tabUrl[0]+"public/facturation/info-patient/id_patient/"+myarrayId[valeurSaisie]+"'>  <img style='width: 25px; height: 16px; cursor: pointer;' src='../images_icons/voir2.png' /> </a>");
					$('.alertModifierLien').html("<a href='"+tabUrl[0]+"public/facturation/modifier/id_patient/"+myarrayId[valeurSaisie]+"'>  <img style='width: 24px; height: 25px; cursor: pointer;' src='../images_icons/2.png' /> </a>");					
				}
				if(myarrayTelephone[valeurSaisie]){ $('.alertTel').html(myarrayTelephone[valeurSaisie]); }else{ $('.alertTel').html('n&eacute;ant'); }
				
				//Afficher le nombre d'éléments s'il y en a plus d'un
				if(nbOccEl > 1){
					$('.alertNbPatient').html("<a href='"+tabUrl[0]+"public/facturation/liste-patient' style='color: red;'> "+nbOccEl+" </a>");					
				}
				
				$('#clickOuvrirPopup').trigger('click');
				//setTimeout(function(){ $('#volet').trigger('dblclick'); }, 30000);
			}else{
				$('#volet').trigger('dblclick');
			}
	  
		});
		
	  
		$('#PRENOM').change(function(){
			prenomSaisi = $(this).val();

			var valeurSaisie = (sexeSaisi+''+nomSaisi+''+prenomSaisi).toLowerCase().replace(/ /g,"");
			var valeurRecherche = $.inArray(valeurSaisie, myarray);
			
			if( valeurRecherche > -1 ){ 
				
				var nbOccEl = nbOccurrenceElement(myarray, valeurSaisie);
				
				//Affichage des données
				$('.alertPrenom').html(prenomSaisi);
				$('.alertNom').html(nomSaisi);
				$('.alertAge').html(myarrayAge[valeurSaisie]);
				if(myarrayId[valeurSaisie]){
					$('.alertVisualiserLien').html("<a href='"+tabUrl[0]+"public/facturation/info-patient/id_patient/"+myarrayId[valeurSaisie]+"'>  <img style='width: 25px; height: 16px; cursor: pointer;' src='../images_icons/voir2.png' /> </a>");
					$('.alertModifierLien').html("<a href='"+tabUrl[0]+"public/facturation/modifier/id_patient/"+myarrayId[valeurSaisie]+"'>  <img style='width: 24px; height: 25px; cursor: pointer;' src='../images_icons/2.png' /> </a>");					
				}
				if(myarrayTelephone[valeurSaisie]){ $('.alertTel').html(myarrayTelephone[valeurSaisie]); }else{ $('.alertTel').html('n&eacute;ant'); }
				
				//Afficher le nombre d'éléments s'il y en a plus d'un
				if(nbOccEl > 1){
					$('.alertNbPatient').html("<a href='"+tabUrl[0]+"public/facturation/liste-patient' style='color: red;'> "+nbOccEl+" </a>");					
				}
				
				$('#clickOuvrirPopup').trigger('click');
				//setTimeout(function(){ $('#volet').trigger('dblclick'); }, 30000);
			}else{
				$('#volet').trigger('dblclick');
			}
	  
		});
		
  
		
	});

}


