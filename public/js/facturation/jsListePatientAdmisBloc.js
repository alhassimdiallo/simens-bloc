    var nb="_TOTAL_";
    var asInitVals = new Array();
    var base_url = window.location.toString();
	var tabUrl = base_url.split("public");
	//BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
    function confirmation(id_admission){
	  $( "#confirmation" ).dialog({
	    resizable: false,
	    height:170,
	    width:435,
	    autoOpen: false,
	    modal: true,
	    buttons: {
	        "Oui": function() {
	            $( this ).dialog( "close" );
	            
	            var chemin = tabUrl[0]+'public/facturation/supprimer-admission-bloc';
	            $.ajax({
	                type: 'POST',
	                url: chemin ,
	                data:{'id_admission':id_admission},
	                success: function(data) {
	                	     var result = jQuery.parseJSON(data);
	                	     if(result == 1){
	                	    	 alert('impossible de supprimer le patient est deja consulter'); return false;
	                	     } else {
		                	     $("#"+id_admission).parent().parent().parent().fadeOut(function(){ 
		                	    	 vart=tabUrl[0]+'public/facturation/liste-patients-admis-bloc';
		                	    	 $(location).attr("href",vart);
		                	     });
	                	     }
	                	     
	                },
	                error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
	                dataType: "html"
	            });
	    	     
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
    var precision_diagnostic = "";
	var intervention_prevue = "";
	var vpa = "";
	var salle = "";
	var operateur = "";
	
    var diagnostic2 = "";
    var precision_diagnostic2 = "";
	var intervention_prevue2 = "";
	var vpa2 = "";
	var salle2 = "";
	var operateur2 = "";
	
	function valeursChamps(){
	    diagnostic2 = $('#diagnostic').val();
	    precision_diagnostic2 = $('#precision_diagnostic').val();
		intervention_prevue2 = $('#intervention_prevue').val();
		vpa2 = $('#vpa').val();
		salle2 = $('#salle').val();
		$('#operateur').attr('disabled', false);
		operateur2 = $('#operateur').val();
	}
    
	var verifPO = 0;
    function affichervue(idPatient, idAdmission, verifPop){ 

    	verifPO = verifPop;
        var chemin = tabUrl[0]+'public/facturation/vue-patient-admis-bloc';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data: $(this).serialize(),  
            data:{'idPatient':idPatient, 'idAdmission':idAdmission, 'verifPop':verifPop},
            success: function(data) {
       	    
            	     $("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 20px;'><iS style='font-size: 25px;'>&curren;</iS> INFORMATIONS SUR L'ADMISSION </div>");
            	     var result = jQuery.parseJSON(data);  
        	    	 $("#vue_patient").html(result);
            	     $("#contenu").fadeOut(function(){
            	    	 $("#informationAdmissionBloc").fadeIn("fast"); 
            	    	 
            	    	 $(".boutonTerminer button").click(function(){
            	    		 valeursChamps(); 
            	    		 
            	    		 if(
            	    				 diagnostic != diagnostic2 || precision_diagnostic != precision_diagnostic2 || intervention_prevue != intervention_prevue2 || 
            	    				 vpa != vpa2 || salle != salle2 || operateur != operateur2 
            	    		 ){
            	    			 return true;
            	    			 
            	    		 }
            	    		 
            	    		 $("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 20px;'><iS style='font-size: 25px;'>&curren;</iS> LISTE DES PATIENTS ADMIS </div>");
            	    		 $("#informationAdmissionBloc").fadeOut(function(){$("#contenu").fadeIn("fast"); });
            	    		 return false;
            	    	 });
            	     
            	     }); 
            	     
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
	    //return false;
    }
    
    /**********************************************************************************/
    function initialisation(){
    	
    	$(".boutonAnnuler").html('<button type="submit" id="annuler" style=" font-family: police2; font-size: 17px; font-weight: bold;"> Annuler </button>');
    	$(".boutonTerminer").html('<button type="submit" id="terminer" style=" font-family: police2; font-size: 17px; font-weight: bold;"> Terminer </button>');

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

    					"sAjaxSource": tabUrl[0]+"public/facturation/liste-patient-admis-bloc-ajax",
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
    	
    	
    	$('#afficherAujourdhui').css({'font-weight':'bold', 'font-size': '17px' });
    	oTable.fnFilter( $('#effectuer_ input').val() , 6 );
    	
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
    	$('#diagnostic').attr('readonly', true);
    	$('#precision_diagnostic').attr('readonly', true);
    	$('#intervention_prevue').attr('readonly', true);
    	$('#vpa').attr('readonly', true);
    	$('#salle').attr('readonly', true);
    	$('#operateur').attr('disabled', true);
    	$('#service').attr('disabled', true);
    	
    	diagnostic = $('#diagnostic').val();
    	precision_diagnostic = $('#precision_diagnostic').val();
    	intervention_prevue = $('#intervention_prevue').val();
    	vpa = $('#vpa').val();
    	salle = $('#salle').val();
    	operateur = $('#operateur').val();
    }
    
    function desactiverChamps(){
    	$('#diagnostic').attr('readonly', true);
    	$('#precision_diagnostic').attr('readonly', true);
    	$('#intervention_prevue').attr('readonly', true);
    	$('#vpa').attr('readonly', true);
    	$('#salle').attr('readonly', true);
    	if(verifPO == 0){ $('#operateur').attr('disabled', true); }
    }

    function activerChamps(){
    	$('#diagnostic').attr('readonly', false);
    	$('#precision_diagnostic').attr('readonly', false);
    	$('#intervention_prevue').attr('readonly', false);
    	$('#vpa').attr('readonly', false);
    	$('#salle').attr('readonly', false);
    	if(verifPO == 0){ $('#operateur').attr('disabled', false); }
    }
    
    var i = 0;
    function modifierDonnees(){
    	if(i == 0){
        	activerChamps(); i = 1;
    	}else{
    		desactiverChamps(); i = 0;
    	}
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
