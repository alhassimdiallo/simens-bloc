    var nb="_TOTAL_";
    var asInitVals = new Array();
    var base_url = window.location.toString();
	var tabUrl = base_url.split("public");
	//BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
    function confirmation(id){
	  $( "#confirmation" ).dialog({
	    resizable: false,
	    height:170,
	    width:435,
	    autoOpen: false,
	    modal: true,
	    buttons: {
	        "Oui": function() {
	            $( this ).dialog( "close" );
	            
//	            var cle = id;
//	            var chemin = tabUrl[0]+'public/facturation/supprimer-admission-bloc';
//	            $.ajax({
//	                type: 'POST',
//	                url: chemin ,
//	                data:{'id':cle, 'idPatient':idPatient, 'idService':idService},
//	                success: function(data) {
//	                	     var result = jQuery.parseJSON(data);  
//	                	     if(result == 1){
//	                	    	 alert('impossible de supprimer le patient est deja consulter'); return false;
//	                	     } else {
//		                	     $("#"+cle).fadeOut(function(){$("#"+cle).empty();}); 
		                	     
		                	     $("#"+id).parent().parent().parent().fadeOut(function(){ 
		                	    	 vart=tabUrl[0]+'public/facturation/liste-patients-admis-bloc';
		                	    	 $(location).attr("href",vart);
		                	     });
//	                	     }
//	                	     
//	                },
//	                error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
//	                dataType: "html"
//	            });
	    	     //return false;
	    	     
	        },
	        "Annuler": function() {
                $( this ).dialog( "close" );
            }
	   }
	  });
    }
    
    function envoyer(id){
   	   confirmation(id);
       $("#confirmation").dialog('open');
   	}
    
    /**********************************************************************************/
    
    
    var diagnostic = "";
	var intervention_prevue = "";
	var vpa = "";
	var salle = "";
	var operateur = "";
	var service = "";
	
    var diagnostic2 = "";
	var intervention_prevue2 = "";
	var vpa2 = "";
	var salle2 = "";
	var operateur2 = "";
	var service2 = "";
	
	function valeursChamps(){
	    diagnostic2 = $('#diagnostic').val();
		intervention_prevue2 = $('#intervention_prevue').val();
		vpa2 = $('#vpa').val();
		salle2 = $('#salle').val();
		operateur2 = $('#operateur').val();
		$('#service').attr('disabled', false).css({'background' : '#ffffff'});
		service2 = $('#service').val();
	}
    
	var entreAnnulation = 0;
    function affichervue(idPatient, idAdmission){
    	
    	$("#pika2").html('<table> <tr> <td style="margin-top: 20px;"> Chargement </td> </tr>  <tr> <td align="center"> <img style="margin-top: 20px; width: 50px; height: 50px;" src="../images/loading/Chargement_1.gif" /> </td> </tr> </table>');
    	$("#AjoutImage").toggle(false);
    	$("#AfficherLecteur").html('<table style="width: 100%;"> <tr style="width: 100%;"> <td style="margin-top: 20px;" align="center"> Chargement </td> </tr>  <tr> <td align="center"> <img style="margin-top: 20px; width: 50px; height: 50px;" src="../images/loading/Chargement_1.gif" /> </td> </tr> </table>');
    	
    	var chemin = tabUrl[0]+'public/consultation/vue-patient-admis-bloc';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data: $(this).serialize(),  
            data:{'idPatient':idPatient, 'idAdmission':idAdmission},
            success: function(data) {
            	$("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 20px;'><iS style='font-size: 25px;'>&curren;</iS> COMPTE RENDU OP&Eacute;RATOIRE </div>");
            	var result = jQuery.parseJSON(data);
            	$("#vue_patient").html(result);
            	$("#contenu").fadeOut(function(){
            		$("#informationAdmissionBloc").fadeIn(function(){
            			getimagesExamensMorphologiques(idAdmission); //Appel des images
            			AppelLecteurMp3(idAdmission); //Appel des audios
            		}); 
            	    
            		$(".boutonEnregistrer button").click(function(){
            			$('#enregistrerProtocoleOperatoire').trigger('click');
            			
            			if( $("#anesthesiste").val()=="" || $("#indication").val()=="" || $("#type_anesthesie").val()=="" || $("#protocole_operatoire").val()=="" || $("#soins_post_operatoire").val()==""){
            				$("#CompteRenduTabs a").trigger('click');
            				$('#enregistrerProtocoleOperatoire').trigger('click');
            			}
            		});
            	    	 
            		if(entreAnnulation == 0){
                		$(".boutonAnnuler button").click(function(){
                			$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 20px;'><iS style='font-size: 25px;'>&curren;</iS> LISTE DES PATIENTS </div>");
                			$("#informationAdmissionBloc").fadeOut(function(){ $("#contenu").fadeIn("fast"); });
                			supprimerImagesAnnulation();
                			return false;
                		});
                		entreAnnulation = 1;
            		}
            	}); 
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
        
    }
    
    //Supprimer les images a l'annulation si le protocole n'existe pas encore
    function supprimerImagesAnnulation(){
    	
    	var id_admission = $("#id_admission").val();
    	
    	var chemin = tabUrl[0]+'public/consultation/supprimer-images-sans-protocole';
    	$.ajax({
            type: 'POST',
            url: chemin ,
            data: {'id_admission':id_admission },
            success: function(data) { 
            	return false; 
            }
        });
    }
    
    /**********************************************************************************/
    function initialisation(){
    	$( "#tabs" ).tabs();
    	
    	$( "#accordions" ).accordion();
    	$(".boutonAnnuler").html('<button type="submit" id="annuler" style=" font-family: police2; font-size: 17px; font-weight: bold;"> Annuler </button>');
    	$(".boutonEnregistrer").html('<button type="submit" id="enregistrer" style=" font-family: police2; font-size: 17px; font-weight: bold;"> Enregistrer </button>');

    	var oTable;
    	$("#informationAdmissionBloc").toggle(false);
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

    					"sAjaxSource": tabUrl[0]+"public/consultation/liste-patient-admis-bloc-ajax",
    					"fnDrawCallback": function() 
    					{
    						//markLine();
    						//clickRowHandler();
    					}

    	} );

    	//le filtre du select
    	$('#filter_statut').change(function() 
    	{					
    		oTable.fnFilter( this.value );
    	});

    	$('#liste_service').change(function()
    	{					
    		oTable.fnFilter( this.value );
    	});

    	$("tfoot input").keyup( function () {
    		/* Filter on the column (the index) of this element */
    		oTable.fnFilter( this.value, $("tfoot input").index(this) );
    	} );

    	/*
    	 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
    	 * the footer
    	 */
    	$("tfoot input").each( function (i) {
    		asInitVals[i] = this.value;
    	} );

    	$("tfoot input").focus( function () {
    		if ( this.className == "search_init" )
    		{
    			this.className = "";
    			this.value = "";
    		}
    	} );

    	$("tfoot input").blur( function (i) {
    		if ( this.value == "" )
    		{
    			this.className = "search_init";
    			this.value = asInitVals[$("tfoot input").index(this)];
    		}
    	} );
    	
    	
    	$('#afficherTous').css({'font-weight':'bold', 'font-size': '17px' });
    	oTable.fnFilter( '' , 6 );
    	
    	$('#afficherAujourdhui').click(function(i){
    		oTable.fnFilter( $('#effectuer_ input').val() , 6 );
    		$('#afficherAujourdhui').css({'font-weight':'bold', 'font-size': '17px' });
    		$('#afficherTous').css({'font-weight':'normal', 'font-size': '15px' });
    	});

    	$('#afficherTous').click(function(){
    		oTable.fnFilter( '' , 6 );
    		$('#afficherAujourdhui').css({'font-weight':'normal', 'font-size': '15px'});
    		$('#afficherTous').css({'font-weight':'bold', 'font-size': '17px' });
    	});
    }
    
    
    function desactiverChampsInit(){
    	$('#diagnostic').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#intervention_prevue').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#vpa').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#salle').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#operateur').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#service').attr('disabled', true).css({'background' : '#f8f8f8'});
    	
    	diagnostic = $('#diagnostic').val();
    	intervention_prevue = $('#intervention_prevue').val();
    	vpa = $('#vpa').val();
    	salle = $('#salle').val();
    	operateur = $('#operateur').val();
    	service = $('#service').val();
    }
    
    function desactiverChamps(){
    	$('#diagnostic').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#intervention_prevue').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#vpa').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#salle').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#operateur').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#service').attr('disabled', true).css({'background' : '#f8f8f8'});
    }

    function activerChamps(){
    	$('#diagnostic').attr('readonly', false).css({'background' : '#ffffff'});
    	$('#intervention_prevue').attr('readonly', false).css({'background' : '#ffffff'});
    	$('#vpa').attr('readonly', false).css({'background' : '#ffffff'});
    	$('#salle').attr('readonly', false).css({'background' : '#ffffff'});
    	$('#operateur').attr('readonly', false).css({'background' : '#ffffff'});
    	$('#service').attr('disabled', false).css({'background' : '#ffffff'});
    }
    
    var i = 0;
    function modifierDonnees(){
    	if(i == 0){
        	activerChamps(); i = 1;
    	}else{
    		desactiverChamps(); i = 0;
    	}
    }
    
    
    
    
    
    function imprimerCRO(){
    	
    	var id_patient = $('#id_patient').val();
    	var id_admission = $('#id_admission').val();
    	
    	var anesthesiste = $('#anesthesiste').val();
    	var indication = $('#indication').val();
    	var type_anesthesie = $('#type_anesthesie').val();
    	var protocole_operatoire = $('#protocole_operatoire').val();
    	var soins_post_operatoire = $('#soins_post_operatoire').val();
    	
    	var check_list_securite = $('#check_list_securite').val();
    	var note_audio_cro = $('#note_audio_cro').val();
    	var aides_operateurs = $('#aides_operateurs').val();
    	var complications = $('#complications').val();
    	var calendrierDateIntervention = $('#calendrierDateIntervention').val();
    	var infoNomPrenomOperateur = $('#infoNomPrenomOperateur').val();
    	
    	
    	var vart =  tabUrl[0]+'public/consultation/imprimer-protocole-operatoire';
		var FormulaireImprimerProtocoleOperatoire = document.getElementById("FormulaireImprimerProtocoleOperatoire");
		FormulaireImprimerProtocoleOperatoire.setAttribute("action", vart);
		FormulaireImprimerProtocoleOperatoire.setAttribute("method", "POST");
		FormulaireImprimerProtocoleOperatoire.setAttribute("target", "_blank");
		
		// Ajout dynamique de champs dans le formulaire
		var champ = document.createElement("input");
		champ.setAttribute("type", "hidden");
		champ.setAttribute("name", 'id_patient');
		champ.setAttribute("value", id_patient);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ);
		
		var champ1 = document.createElement("input");
		champ1.setAttribute("type", "hidden");
		champ1.setAttribute("name", 'id_admission');
		champ1.setAttribute("value", id_admission);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ1);
		
		
		
		var champ2 = document.createElement("input");
		champ2.setAttribute("type", "hidden");
		champ2.setAttribute("name", 'anesthesiste');
		champ2.setAttribute("value", anesthesiste);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ2);
		
		var champ3 = document.createElement("input");
		champ3.setAttribute("type", "hidden");
		champ3.setAttribute("name", 'indication');
		champ3.setAttribute("value", indication);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ3);
		
		var champ4 = document.createElement("input");
		champ4.setAttribute("type", "hidden");
		champ4.setAttribute("name", 'type_anesthesie');
		champ4.setAttribute("value", type_anesthesie);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ4);
		
		var champ5 = document.createElement("input");
		champ5.setAttribute("type", "hidden");
		champ5.setAttribute("name", 'protocole_operatoire');
		champ5.setAttribute("value", protocole_operatoire);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ5);
		
		var champ6 = document.createElement("input");
		champ6.setAttribute("type", "hidden");
		champ6.setAttribute("name", 'soins_post_operatoire');
		champ6.setAttribute("value", soins_post_operatoire);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ6);
		
		var champ7 = document.createElement("input");
		champ7.setAttribute("type", "hidden");
		champ7.setAttribute("name", 'check_list_securite');
		champ7.setAttribute("value", check_list_securite);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ7);
		
		var champ8 = document.createElement("input");
		champ8.setAttribute("type", "hidden");
		champ8.setAttribute("name", 'note_audio_cro');
		champ8.setAttribute("value", note_audio_cro);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ8);
		
		var champ9 = document.createElement("input");
		champ9.setAttribute("type", "hidden");
		champ9.setAttribute("name", 'aides_operateurs');
		champ9.setAttribute("value", aides_operateurs);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ9);
		
		var champ10 = document.createElement("input");
		champ10.setAttribute("type", "hidden");
		champ10.setAttribute("name", 'complications');
		champ10.setAttribute("value", complications);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ10);
		
		var champ11 = document.createElement("input");
		champ11.setAttribute("type", "hidden");
		champ11.setAttribute("name", 'calendrierDateIntervention');
		champ11.setAttribute("value", calendrierDateIntervention);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ11);
		
		var champ12 = document.createElement("input");
		champ12.setAttribute("type", "hidden");
		champ12.setAttribute("name", 'infoNomPrenomOperateur');
		champ12.setAttribute("value", infoNomPrenomOperateur);
		FormulaireImprimerProtocoleOperatoire.appendChild(champ12);

		
		$("#ImprimerProtocoleOperatoire").trigger('click');
    	
    }
    
    
    $('#calendrierDateIntervention').datetimepicker(
			$.datepicker.regional['fr'] = {
					dateFormat: 'dd/mm/yy -', 
	    			timeText: 'H:M', 
	    			hourText: 'Heure', 
	    			minuteText: 'Minute', 
	    			currentText: 'Actuellement', 
	    			closeText: 'F',
					//closeText: 'Fermer',
					changeYear: true,
					yearRange: 'c-80:c',
					prevText: '&#x3c;Préc',
					nextText: 'Suiv&#x3e;',
					monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
					'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
					monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
					'Jul','Aout','Sep','Oct','Nov','Dec'],
					dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
					dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
					dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
					weekHeader: 'Sm',
					firstDay: 1,
					isRTL: false,
					showMonthAfterYear: false,
					yearRange: '1990:2050',
					changeMonth: true,
					changeYear: true,
					maxDate: 0,
					yearSuffix: ''}
	);
    
    

    function popupFermer() {
    	$(null).w2overlay(null);
    }

    function popupTerminer() {
    	$(null).w2overlay(null);
    }

    var infoNomPrenomOperateur = "";
    var infoNomPrenomProprioCompte = "";
    function entrerDonneesOperateur()
    {
    	
    	$('.entrerDonneesOperateur').w2overlay({ html: "" +
    		"" +
    		"<div style='width: 275px; height: 27px; border-bottom: 1px solid green;'> <div style='height: 25px; background: #f9f9f9; width: 90%; float: left; text-align:center; padding-top: 5px; font-size: 13px; color: green; font-weight: bold;'><img style='padding-right: 5px;' src='"+tabUrl[0]+"public/images_icons/surgeon_16.png' >Op&eacute;rateur </div> <div style='width: 10%; height: 25px; padding-top: 5px; float: left;'> <a id='idSuppNomOperateur' href='javascript:supprimerNomOperateur()'><img style='padding-right: 5px; float: right;' src='"+tabUrl[0]+"public/images_icons/gomme.png' title='modifier' ></a></div></div>" +
    		"<div style='height: 45px; width: 275px; padding-top:5px; text-align:center;'>" +
    		"<input id='nomOperateurSaisi' type='text' style='height: 90%; width: 95%; max-height: 77%; max-width: 95%; font-size: 16px; padding-left: 5px;' >" +
    		"</div>"+
    		"<script> if(infoNomPrenomOperateur == ''){ $('#nomOperateurSaisi, #infoNomPrenomOperateur').val(infoNomPrenomProprioCompte); }else{ $('#nomOperateurSaisi').val(infoNomPrenomOperateur); } </script>" +
    		"<script> if(!$('#nomOperateurSaisi').val()){ $('#idSuppNomOperateur').toggle(false); }</script>"+
    		"<script>$('#nomOperateurSaisi').keyup(function(){ if($('#nomOperateurSaisi').val().trim() != ''){ "+
    	    "$('#infoNomPrenomOperateur').val($('#nomOperateurSaisi').val().trim());"+
    	    "infoNomPrenomOperateur = $('#nomOperateurSaisi').val().trim(); "+
    	    "$('#idSuppNomOperateur').toggle(true); }else{ $('#idSuppNomOperateur').toggle(false); } });</script>"+
    	    "<script> $('#nomOperateurSaisi').attr('readonly', true); </script>"+
    	    "<script> $('#nomOperateurSaisi').keypress(function(event) { if (event.keyCode == 13) { $(null).w2overlay(null); return false; } });</script>"
    	});
    	
    }
    
    function supprimerNomOperateur()
    {
    	$('#idSuppNomOperateur').toggle(false);
    	$('#nomOperateurSaisi').val('');
    	$('#nomOperateurSaisi').attr('readonly', false);
    	infoNomPrenomOperateur = "";
    	$('#infoNomPrenomOperateur').val(infoNomPrenomProprioCompte);
    }
    
    