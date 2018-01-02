    var base_url = window.location.toString();
	var tabUrl = base_url.split("public");
//BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
function confirmation(id){
  $( "#confirmation" ).dialog({
    resizable: false,
    height:375,
    width:485,
    autoOpen: false,
    modal: true,
    buttons: {
        "Terminer": function() {
            $( this ).dialog( "close" );             	     
            return false;
        }
   }
  });
}

function visualiser(id){
	 confirmation(id);
	 var cle = id;
     var chemin = tabUrl[0]+'public/facturation/declarer-deces';
     $.ajax({
         type: 'POST',
         url: chemin ,
         data: $(this).serialize(),  
         data:'id='+cle,
         success: function(data) {    
         	    var result = jQuery.parseJSON(data);   
         	     $("#info").html(result);
         	     
         	     $("#confirmation").dialog('open'); //Appel du POPUP
         	       
         },
         error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
         dataType: "html"
     });
}
$(function(){
setTimeout(function() {
	infoBulle();
}, 1000);
});
function infoBulle(){
	/***
	 * INFO BULLE FE LA LISTE
	 */
	 var tooltips = $( 'table tbody tr td infoBulleVue' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	     tooltips.tooltip( 'close' );
	  $('table tbody tr td infoBulleVue').mouseenter(function(){
	    var tooltips = $( 'table tbody tr td infoBulleVue' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	    tooltips.tooltip( 'open' );
	  });
}
var  oTable
function initialisation(){
	
    
	var asInitVals = new Array();
        oTable = $('#patient').dataTable
	( {
		"sPaginationType": "full_numbers",
		"aLengthMenu": [5,7,10,15],
		"aaSorting": [], //On ne trie pas la liste automatiquement
		"oLanguage": {
			"sInfo": "_START_ &agrave; _END_ sur _TOTAL_ patients",
			"sInfoEmpty": "0 &eacute;l&eacute;ment &agrave; afficher",
			"sInfoFiltered": "",
			"sUrl": "",
			"oPaginate": {
				"sFirst":    "|<",
				"sPrevious": "<",
				"sNext":     ">",
				"sLast":     ">|"
				}
		   },

		"sAjaxSource": ""+tabUrl[0]+"public/facturation/liste-admission-ajax", 

		"fnDrawCallback": function() 
		{
			//markLine();
			clickRowHandler();
		}
						
	} );

	$("thead input").keyup( function () {
		/* Filter on the column (the index) of this element */
		oTable.fnFilter( this.value, $("thead input").index(this) );
	} );

	/*
	* Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
	* the footer
	*/
	$("thead input").each( function (i) {
		asInitVals[i] = this.value;
	} );

	$("thead input").focus( function () {
		if ( this.className == "search_init" )
		{
			this.className = "";
			this.value = "";
		}
	} );

	$("thead input").blur( function (i) {
		if ( this.value == "" )
		{
			this.className = "search_init";
			this.value = asInitVals[$("thead input").index(this)];
		}
	} );

}

function clickRowHandler() 
{
	var id;
	$('#patient tbody tr').contextmenu({
		target: '#context-menu',
		onItem: function (context, e) {
			
			if($(e.target).text() == 'Visualiser' || $(e.target).is('#visualiserCTX')){
				visualiser(id);
			} else 
				if($(e.target).text() == 'Suivant' || $(e.target).is('#suivantCTX')){
					declarer(id);
				}
			
		}
	
	}).bind('mousedown', function (e) {
			var aData = oTable.fnGetData( this );
		    id = aData[0];
	});
	
	
	
	$("#patient tbody tr").bind('dblclick', function (event) {
		var aData = oTable.fnGetData( this );
		var id = aData[0];
		visualiser(id);
	});
	
}


function animation(){
//ANIMATION
//ANIMATION
//ANIMATION

$('#declarer_deces').toggle(false);

$('#precedent').click(function(){
	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 35px;'><iS style='font-size: 25px;'>&curren;</iS> RECHERCHER LE PATIENT </div>");	
    
	$('#contenu').animate({
        height : 'toggle'
     },1000);
     $('#declarer_deces').animate({
        height : 'toggle'
     },1000);
	 
     //IL FAUT LE RECREER POUR L'ENLEVER DU DOM A CHAQUE FOIS QU'ON CLIQUE SUR PRECEDENT
     $("#termineradmission").replaceWith("<button id='termineradmission' style='height:35px;'>Terminer</button>");
     
     return false;
});

}

function declarer(id){
	
	$("#termineradmission").replaceWith("<button id='termineradmission' style='height:35px;'>Terminer</button>");
    $("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 35px;'><iS style='font-size: 25px;'>&curren;</iS> ADMISSION </div>");	

    //Rï¿½cupï¿½ration des donnï¿½es du patient
    var cle = id;
    var chemin = tabUrl[0]+'public/facturation/admission-bloc';
    $.ajax({
        type: 'POST',
        url: chemin ,
        data: $(this).serialize(),  
        data:'id='+cle,
        success: function(data) {    
        	    var result = jQuery.parseJSON(data);  
        	     $("#info_patient").html(result);
        	     //PASSER A SUIVANT
        	     $('#declarer_deces').animate({
        	         height : 'toggle'
        	      },1000);
        	     $('#contenu').animate({
        	         height : 'toggle'
        	     },1000);
        },
        error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
        dataType: "html"
    });
    //Fin Rï¿½cupï¿½ration des donnï¿½es de la maman
    
    //Annuler l'enregistrement d'une naissance
    $("#annuler").click(function(){
    	$("#annuler").css({"border-color":"#ccc"});
    	
	    vart = tabUrl[0]+'public/facturation/admission-bloc';
	    $(location).attr("href",vart);
        return false;
    });
    
    $("#id_patient").val(id);
  
}



function getservice(id_medecin){
	var chemin = tabUrl[0]+'public/facturation/get-service';
    $.ajax({
        type: 'POST',
        url: chemin ,
        data:'id_medecin='+id_medecin,
        success: function(data) {    
        	var result = jQuery.parseJSON(data);  
        	
        	$('#service').attr('disabled','false');
        	$('#service').val(result).attr('disabled','false');
        	
        }
    });
}


var montant;
function getmontant(id){
    var cle = id;
    var chemin = tabUrl[0]+'public/facturation/montant';
    $.ajax({
        type: 'POST',
        url: chemin ,
        data:'id='+cle,
        success: function(data) {    
        	var result = parseInt(jQuery.parseJSON(data));  
        	montant = result;
        	$("#montant").val(result);
        	
        	var taux = $("#taux").val();
        	if(taux){
        		$("#montant_avec_majoration").val(result+(result*taux)/100);
        	} else {
        		$("#montant_avec_majoration").val(result);
        	}

        },
        
        error:function(e){ console.log(e); alert("Une erreur interne est survenue!"); },
        dataType: "html"
    });
}

function getTarif(taux){
	var service = $('#service').val();
	var montantMajore;
	
	if(service && montant && taux){
		montantMajore = montant + (montant*taux)/100;
		$('#montant_avec_majoration').val(montantMajore);
	} else if(service && !taux){
		$('#montant_avec_majoration').val(montant);
	}
	
}

var temoin = 0;
function scriptFactMajor(){
	$('.organisme').toggle(false);
	$('.taux').toggle(false);

	var boutons = $('input[name=type_facturation]');
	$(boutons[0]).trigger('click');
	
	$(boutons).click(function(){
		if(boutons[0].checked){
			$('#service').attr('disabled', false).css('background', '#ffffff');
			$('.organisme').toggle(false);
			$('.taux').toggle(false);
			
			if(temoin == 1){
				$('#montant_avec_majoration').val("");
				$('#service').val("");
				temoin = 0;
			}
			$('#taux').val("");

			$('#organisme').attr('required', false);
		} else 
			if(boutons[1].checked){
				$('#service').attr('disabled', false).css('background', '#ffffff');
				$('.organisme').toggle(true);
				$('.taux').toggle(true);

				if(temoin == 0){
					$('#montant_avec_majoration').val("");
					$('#service').val("");
					temoin = 1;
				}
				
				$('#organisme').attr('required', true);
			}
	});
	
	

	//Pour l'impression de la facture
	//Pour l'impression de la facture
	$('.termineradmission').click(function(){

		var donnees = new Array();
		donnees['id_patient'] = $('#id_patient').val();
		donnees['numero'] = $('#numero').val();
		donnees['service'] = $('#service').val();
		donnees['montant_avec_majoration'] = $('#montant_avec_majoration').val();
		donnees['montant'] = $('#montant').val();
		
		if( temoin == 0 ){
			
			donnees['type_facturation'] = 1;
			var vart = tabUrl[0]+'public/facturation/impression-pdf';
		    
			var formulaireImprimerFacture = document.getElementById("FormulaireImprimerFacture");
			formulaireImprimerFacture.setAttribute("action", vart);
			formulaireImprimerFacture.setAttribute("method", "POST");
			formulaireImprimerFacture.setAttribute("target", "_blank");
			
			for( donnee in donnees ){
				// Ajout dynamique de champs dans le formulaire
				var champ = document.createElement("input");
				champ.setAttribute("type", "hidden");
				champ.setAttribute("name", donnee);
				champ.setAttribute("value", donnees[donnee]);
				formulaireImprimerFacture.appendChild(champ);
			}

			if( donnees['service'] ){
				// Envoi de la requête
				$("#ImprimerFacture").trigger('click');
				setTimeout(function(){
					document.getElementById("formulairePrincipal").submit();
				});
				return false;
			} else if( !donnees['service'] ){
				return true;
			}
		 
		} else if( temoin == 1 ){
			
			donnees['type_facturation'] = 2;
			donnees['organisme'] = $('#organisme').val();
			donnees['taux'] = $('#taux').val();
			var vart = tabUrl[0]+'public/facturation/impression-pdf';
		    
			var formulaireImprimerFacture = document.getElementById("FormulaireImprimerFacture");
			formulaireImprimerFacture.setAttribute("action", vart);
			formulaireImprimerFacture.setAttribute("method", "POST");
			formulaireImprimerFacture.setAttribute("target", "_blank");
			
			for( donnee in donnees ){
				// Ajout dynamique de champs dans le formulaire
				var champ = document.createElement("input");
				champ.setAttribute("type", "hidden");
				champ.setAttribute("name", donnee);
				champ.setAttribute("value", donnees[donnee]);
				formulaireImprimerFacture.appendChild(champ);
			}

			if( donnees['service'] && donnees['organisme']){
				// Envoi de la requête
				$("#ImprimerFacture").trigger('click');
				setTimeout(function(){
					document.getElementById("formulairePrincipal").submit();
				});
				return false;
			} else if( !donnees['service'] || !donnees['organisme']){
				return true;
			}
			
		}
		
	});
}

































var listeSelectDiagnostic = "";
function appelScriptAutoCompletionDiagnostic(){
    $.ajax({
        type: 'POST',
        url: tabUrl[0]+'public/facturation/get-liste-diagnostic-bloc',
        data:null,
        success: function(data) {    
        	var result = jQuery.parseJSON(data);   
        	listeSelectDiagnostic = result;
        	ajouterUnDiagnostic();
        }
    });
    
    listeDesDiagnosticsBloc();
}

function ajouterUnDiagnostic(){
	var nbLigne = $('.ligneInfosDiagnostic').length;
	 
	var ligne ="" +
	"<tr class='ligneInfosDiagnostic rowDiagnostic_"+(nbLigne+1)+"' style='width: 100%;'>"+ 
        "<td style='width: 100%; height: 30px;'>"+
          "<div class='liste_diagnostic_select' style='width: 50%; float: left;'>"+ 
             "<label>Diagnostic "+(nbLigne+1)+"</label><select style='width: 98%;' name='diagnostic_"+(nbLigne+1)+"' required>"+listeSelectDiagnostic+"</select>"+
          "</div>"+
          "<div style='width: 50%; float: left;'>"+
             "<label>Pr&eacute;cision du diagnostic "+(nbLigne+1)+"</label><input type='text' name='precision_diagnostic_"+(nbLigne+1)+"'  style='width: 90%;'>"+
          "</div>"+
        "</td>"+
    "</tr>";
	
	$('.contenu-form-diagnostic .rowDiagnostic_'+nbLigne).after(ligne);
	
	if((nbLigne+1) > 1){ 
		$('.iconeAnnulerDiag').toggle(true);
	}else if((nbLigne+1) == 1){
		$('.iconeAnnulerDiag').toggle(false);
	}
	
	$('#nb_diagnostic').val(nbLigne+1);
}

function enleverUnDiagnostic(){
	var nbLigne = $('.ligneInfosDiagnostic').length;
	if(nbLigne > 1){
		$('.rowDiagnostic_'+nbLigne).remove();
		if(nbLigne == 2){ $('.iconeAnnulerDiag').toggle(false); }
	}
	
	$('#nb_diagnostic').val(nbLigne-1);
}


















function listeDesDiagnosticsBloc(){
    $.ajax({
        type: 'POST',
        url: tabUrl[0]+'public/facturation/get-liste-diagnostic-bloc-popup',
        data:null,
        success: function(data) {    
        	var result = jQuery.parseJSON(data);   
        	$('.listeDesDiagnosticsExistants table').html(result);
        }
    });
}

function ajouterAdmissionDiagnostic(){
	$('.iconeAnnulerChampDiag').toggle(false);
	$('.ligneInfosChampDiagnostic').remove();
    ajouterUnChampAjoutDiagnostic();
    
	$( "#ajouterDesDiagnostics" ).dialog({
		resizable: false,
	    height:480,
	    width:750,
	    autoOpen: false,
	    modal: true,
	    buttons: {
	        "Fermer": function() {
              $( this ).dialog( "close" );
	        }
	    }
	});
  
	$("#ajouterDesDiagnostics").dialog('open');
	
}

function ajouterUnChampAjoutDiagnostic(){
	var nbLigne = $('.ligneInfosChampDiagnostic').length;
	 
	var ligne ="" +
	"<tr class='ligneInfosChampDiagnostic rowAjoutDiagnostic_"+(nbLigne+1)+"' style='width: 100%;'>"+ 
        "<td>"+
             "<input type='text' name='diagnostic_ajouter_"+(nbLigne+1)+"' id='diagnostic_ajouter_"+(nbLigne+1)+"'>"+
        "</td>"+
    "</tr>";
	
	$('.tableAjoutDiagnostic .rowAjoutDiagnostic_'+nbLigne).after(ligne);
	
	if((nbLigne+1) > 1){ 
		$('.iconeAnnulerChampDiag').toggle(true);
	}else if((nbLigne+1) == 1){
		$('.iconeAnnulerChampDiag').toggle(false);
	}
}

function enleverUnChampAjoutDiagnostic(){
	var nbLigne = $('.ligneInfosChampDiagnostic').length;
	if(nbLigne > 1){
		$('.rowAjoutDiagnostic_'+nbLigne).remove();
		if(nbLigne == 2){ $('.iconeAnnulerChampDiag').toggle(false); }
	}
}

function raffraichirListeDesDiagnostics(){
    $.ajax({
        type: 'POST',
        url: tabUrl[0]+'public/facturation/get-liste-diagnostic-bloc',
        data:null,
        success: function(data) {    
        	listeSelectDiagnostic = jQuery.parseJSON(data);   
        	$('.liste_diagnostic_select select').html(listeSelectDiagnostic);
        }
    });
}

function enregistrerNouveauxDiagnostics(){
	var nbLigne = $('.ligneInfosChampDiagnostic').length;
	
	var tabListeDiagnostic = new Array();
	var indiceTab = 0;
	for(var ind=1 ; ind<=nbLigne ; ind++){
		var diagAajouter = $('#diagnostic_ajouter_'+ind).val();
		if(diagAajouter){
			tabListeDiagnostic[indiceTab++] = $('#diagnostic_ajouter_'+ind).val();
		}
	}
	
	if(tabListeDiagnostic.length != 0){
		var reponse = confirm("Confirmer l'enregistrement des nouveaux diagnostic");
		if (reponse == true) {
			$('.ligneInfosChampDiagnostic input').attr('readonly', true);
			$('.buttonTableAjoutDiagnostic button').attr('disabled', true);
			$.ajax({
		        type: 'POST',
		        url: tabUrl[0]+'public/facturation/add-liste-diagnostic-bloc-popup',
		        data:{'tabListeDiagnostic':tabListeDiagnostic},
		        success: function(data) {    
		        	$('.listeDesDiagnosticsExistants table').html('<tr> <td style="margin-top: 35px; border: 1px solid #ffffff; text-align: center;"> Chargement </td> </tr>  <tr> <td align="center" style="border: 1px solid #ffffff; text-align: center;"> <img style="margin-top: 13px; width: 50px; height: 50px;" src="../images/loading/Chargement_1.gif" /> </td> </tr>');
		        	listeDesDiagnosticsBloc();
		        	$('.ligneInfosChampDiagnostic').remove();
		    		ajouterUnChampAjoutDiagnostic();
		    		$('.buttonTableAjoutDiagnostic button').attr('disabled', false);
		    		raffraichirListeDesDiagnostics();
		        }
		    });
		}
	}
	
}

function modifierDiagnosticBloc(id){
	var libelleDiagnostic = $('.libelleLTPE2_'+id+' span').html();
	$('#infosConfirmationModification').html("<tr><td>"+libelleDiagnostic+"</td></tr>");
	
	$( "#modifierDiagnosticBloc" ).dialog({
		resizable: false,
	    height:300,
	    width:450,
	    autoOpen: false,
	    modal: true,
	    buttons: {
	    	"Annuler": function() {
	    		$( this ).dialog( "close" );
		    },
	        "Modifier": function() {
	        	
	        	var libelleDiagnosticBloc = $('#affichageMessageInfosRemplaceModification input').val();
	        	if(libelleDiagnosticBloc){
		        	var reponse = confirm("Confirmer la modification du diagnostic");
					if (reponse == false) { return false; }
					else{
				      	$('.libelleLTPE2_'+id+' span').html(libelleDiagnostic+ " <img style='margin-left: 5px; width: 18px; height: 18px;' src='../images/loading/Chargement_1.gif' />");
			        	$( this ).dialog( "close" );

			        	$.ajax({
			        		type : 'POST',
			        		url : tabUrl[0] + 'public/facturation/update-liste-diagnostic-bloc-popup',
			        		data : {'id' : id, 'libelle' : libelleDiagnosticBloc },
			        		success : function(data) {
			        			var result = jQuery.parseJSON(data);
			        			$('.libelleLTPE2_'+id+' span').html(result);
			        			$('#affichageMessageInfosRemplaceModification input').val('');
			        			raffraichirListeDesDiagnostics();
			        		}
			        	});
			        	
					}
	        	}
	        	
	        }
	    }
	});

	$("#modifierDiagnosticBloc").dialog('open');
	 
}

function supprimerDiagnosticBloc(id){
	var reponse = confirm("Confirmer la suppression du diagnostic");
	if (reponse == false) { return false; }
	else{
		$.ajax({
			type : 'POST',
			url : tabUrl[0] + 'public/facturation/supprimer-un-diagnostic-bloc-popup',
			data : {'id' : id},
			success : function(data) {
				$('.libelleLTPE2_'+id).parent().fadeOut();
				var result = jQuery.parseJSON(data);
				listeDesDiagnosticsBloc();
				raffraichirListeDesDiagnostics();
			}
		});
	}
}
