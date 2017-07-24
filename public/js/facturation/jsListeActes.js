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
        oTable = $('#patientActesImpayes').dataTable
	( {
		"sPaginationType": "full_numbers",
		"aLengthMenu": [5,7,10,15],
		"aaSorting": [], //On ne trie pas la liste automatiquement
		"oLanguage": {
			"sInfo": "_START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
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

		"sAjaxSource": ""+tabUrl[0]+"public/facturation/liste-actes-impayes-ajax", 

		"fnDrawCallback": function() 
		{
			//markLine();
			clickRowHandler();
		}
						
	} );

	$("#patientActesImpayes thead input").keyup( function () {
		/* Filter on the column (the index) of this element */
		oTable.fnFilter( this.value, $("#patientActesImpayes thead input").index(this) );
	} );

	/*
	* Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
	* the footer
	*/
	$("#patientActesImpayes thead input").each( function (i) {
		asInitVals[i] = this.value;
	} );

	$("#patientActesImpayes thead input").focus( function () {
		if ( this.className == "search_init" )
		{
			this.className = "";
			this.value = "";
		}
	} );

	$("#patientActesImpayes thead input").blur( function (i) {
		if ( this.value == "" )
		{
			this.className = "search_init";
			this.value = asInitVals[$("#patientActesImpayes thead input").index(this)];
		}
	} );

}

function clickRowHandler() 
{
	var id;
	var idDemande;
	$('#patientActesImpayes tbody tr').contextmenu({
		target: '#context-menu',
		onItem: function (context, e) {
			
			if($(e.target).text() == 'Visualiser' || $(e.target).is('#visualiserCTX')){
				visualiser(id);
			} else 
				if($(e.target).text() == 'Suivant' || $(e.target).is('#suivantCTX')){
					paiement(id, idDemande, 1);
				}
			
		}
	
	}).bind('mousedown', function (e) {
			var aData = oTable.fnGetData( this );
		    id = aData[0];
		    idDemande = aData[6];
	});
	
	$("#patientActesImpayes tbody tr").bind('dblclick', function (event) {
		var aData = oTable.fnGetData( this );
		var id = aData[0];
		visualiser(id);
	});
	
}



var  oTable2
function initialisation2(){
	setTimeout(function(){ 
		$('#contenu2').toggle(false); 
		$('#paiement_des_actes').toggle(false);
		
		$('#precedent').click(function(){
			
			if($('#temoinActe').val() == 1){
				$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 35px;'><iS style='font-size: 25px;'>&curren;</iS> LISTE DES ACTES <span>IMPAYES</span> PAR PATIENT </div>");	
			} else if($('#temoinActe').val() == 2){
				$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 35px;'><iS style='font-size: 25px;'>&curren;</iS> LISTE DES ACTES <span>PAYES</span> PAR PATIENT </div>");	
			}
		    
			$('#LesDeuxListes').animate({
		        height : 'toggle'
		     },1000);
		     $('#paiement_des_actes').animate({
		        height : 'toggle'
		     },1000);
		     setTimeout(function(){ $('#styleTableActe').html("<style> #listeDataTable{ margin-left:0px; } </style> " ); });
		     //IL FAUT LE RECREER POUR L'ENLEVER DU DOM A CHAQUE FOIS QU'ON CLIQUE SUR PRECEDENT
		     $("#terminerpaiement").replaceWith("<button id='terminerpaiement' style='height:35px;'>Terminer</button>");
		     
		     return false;
		});
		
	});
    
	var asInitVals2 = new Array();
        oTable2 = $('#patientActesPayes').dataTable
	( {
		"sPaginationType": "full_numbers",
		"aLengthMenu": [5,7,10,15],
		"aaSorting": [], //On ne trie pas la liste automatiquement
		"oLanguage": {
			"sInfo": "_START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
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

		"sAjaxSource": ""+tabUrl[0]+"public/facturation/liste-actes-payes-ajax", 

		"fnDrawCallback": function() 
		{
			clickRowHandler2();
		}
						
	} );

	$("#patientActesPayes thead input").keyup( function () {
		/* Filter on the column (the index) of this element */
		oTable2.fnFilter( this.value, $("#patientActesPayes thead input").index(this) );
	} );

	/*
	* Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
	* the footer
	*/
	$("#patientActesPayes thead input").each( function (i) {
		asInitVals2[i] = this.value;
	} );

	$("#patientActesPayes thead input").focus( function () {
		if ( this.className == "search_init" )
		{
			this.className = "";
			this.value = "";
		}
	} );

	$("#patientActesPayes thead input").blur( function (i) {
		if ( this.value == "" )
		{
			this.className = "search_init";
			this.value = asInitVals2[$("#patientActesPayes thead input").index(this)];
		}
	} );

}


function clickRowHandler2() 
{
	var id;
	var idDemande;
	$('#patientActesPayes tbody tr').contextmenu({
		target: '#context-menu',
		onItem: function (context, e) {
			
			if($(e.target).text() == 'Visualiser' || $(e.target).is('#visualiserCTX')){
				visualiser(id);
			} else 
				if($(e.target).text() == 'Suivant' || $(e.target).is('#suivantCTX')){
					paiement(id, idDemande, 2);
				}
			
		}
	
	}).bind('mousedown', function (e) {
			var aData = oTable2.fnGetData( this );
		    id = aData[0];
		    idDemande = aData[6];
	});
	
	$("#patientActesPayes tbody tr").bind('dblclick', function (event) {
		var aData = oTable2.fnGetData( this );
		var id = aData[0];
		visualiser(id);
	});
	
}


//type: le type d'affichage payé ou impayé
function paiement(id,idDemande,type){ 
	
	$('#temoinActe').val(type);
	
	$("#terminerpaiement").replaceWith("<button id='terminerpaiement' style='height:35px;'>Terminer</button>");
    if(type == 1){
    	$("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 35px;'><iS style='font-size: 25px;'>&curren;</iS> PAIEMENT DES ACTES DU PATIENT </div>");	
    } else if(type == 2) {
    	$("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 35px;'><iS style='font-size: 25px;'>&curren;</iS> ACTES D&Eacute;J&Agrave; PAY&Eacute;S DU PATIENT </div>");	
    }


    $.ajax({
        type: 'POST',
        url: tabUrl[0]+'public/facturation/liste-actes-impayes' ,
        data:{'id':id, 'idDemande':idDemande, 'type':type},
        success: function(data) {    
        	    var result = jQuery.parseJSON(data); 
        	     $("#info_patient_acte").html(result);
        	     //PASSER A SUIVANT
        	     $('#paiement_des_actes').animate({
        	         height : 'toggle'
        	      },1000);
        	     $('#LesDeuxListes').animate({
        	         height : 'toggle'
        	     },1000);
        	     setTimeout(function(){ $('#styleTableActe').html("<style> #listeDataTable{ margin-left:-10px; }  div .dataTables_paginate { margin-right: 0px; } </style> " ); },500);
        },
        error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
        dataType: "html"
    });
    
    $("#id_patient").val(id);
  
}


function listeDesActes() {
	
	$('#listeDesActesImpayesVue').dataTable ( {
		"sPaginationType": "full_numbers",
		"aLengthMenu": [3,5],
		"iDisplayLength": 3,
		"aaSorting": [], //On ne trie pas la liste automatiquement
		"oLanguage": {
			"sInfo": "_START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
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
	
	} );
}

function popupFermer() {
	$(null).w2overlay(null);
}

function reglement(id,idPatient){
	$('#regler_'+id).w2overlay({ html: "" +
		"" +
		"<div style='border-bottom:1px solid green; height: 30px; background: #f9f9f9; width: 200px; text-align:center; padding-top: 10px; font-size: 13px; color: green; font-weight: bold;'>Confirmer le r&egrave;glement</div>" +
		"<div style='height: 50px; width: 200px; padding-top:10px; text-align:center;'>" +
		"<button class='btn' style='cursor:pointer;' onclick='popupFermer(); return false;'>Annuler</button>" +
		"<button class='btn' style='cursor:pointer;' onclick='reglerFacture("+id+","+idPatient+"); return false;'>R&eacute;gler</button>" +
		"</div>" +
		"" 
	});
}

function reglerFacture(idDemande, idPatient) {
	$(null).w2overlay(null);
	
	$.ajax({
        type: 'POST',
        url: tabUrl[0]+'public/facturation/acte-paye' ,
        data:{'idDemande':idDemande, 'idPatient':idPatient},
        success: function(data) {    
        	    var result = jQuery.parseJSON(data);  
        	    $("#info_patient_acte").html(result);
        },
        error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
        dataType: "html"
    });
	
}


function imprimerFactureActe(idDemande){
	var vart = '../facturation/impression-facture-acte';
	var FormulaireImprimerFactureActe = document.getElementById("FormulaireImprimerFactureActe");
	FormulaireImprimerFactureActe.setAttribute("action", vart);
	FormulaireImprimerFactureActe.setAttribute("method", "POST");
	FormulaireImprimerFactureActe.setAttribute("target", "_blank");
	
	// Ajout dynamique de champs dans le formulaire
	var champ = document.createElement("input");
	champ.setAttribute("type", "hidden");
	champ.setAttribute("name", 'idDemande');
	champ.setAttribute("value", idDemande);
	FormulaireImprimerFactureActe.appendChild(champ);
	
	$("#ImprimerFactureActe").trigger('click');
}

