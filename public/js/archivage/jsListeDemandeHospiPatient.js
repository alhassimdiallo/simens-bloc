    var base_url = window.location.toString();
    var tabUrl = base_url.split("public");
    
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    $(function(){
    	initialisation();
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
    
    var  oTable;
    function initialisation(){
            oTable = $('#patient').dataTable
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

    					"sAjaxSource": ""+tabUrl[0]+"public/archivage/liste-demande-hospi-ajax", 
    					
    					"fnDrawCallback": function() 
    					{
    						//markLine();
    						clickRowHandler();
    					}
    					
    	}); 
        
        var asInitVals = new Array();
    
   	//le filtre du select
   	$('#filter_statut').change(function() 
   	{					
   		oTable.fnFilter( this.value );
   	});

   	//le filtre du select du type personnel
	$('#type_personnel').change(function() 
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

    $("#annuler").click(function(){
    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> LISTE DES PATIENTS </div>");
	    $("#hospitaliser").fadeOut(function(){$("#contenu").fadeIn("fast"); $("#division").val(""); $("#salle,#lit").html("");});
	    return false;
	});
  
    }
    
    

    function clickRowHandler() 
    {
    	var id;
    	$('#patient tbody tr').contextmenu({
    		target: '#context-menu',
    		onItem: function (context, e) {
    			
    			if($(e.target).text() == 'Détails' || $(e.target).is('#detailsCTX')){
    				affichervue(id);
    			} else 
    				if($(e.target).text() == 'Hospitaliser' || $(e.target).is('#hospitaliserCTX')){
    					hospitaliser(id);
    				}
    			
    		}
    	
    	}).bind('mousedown', function (e) {
    			var aData = oTable.fnGetData( this );
    		    id = aData[7];
    	});
    	
    	
    	
    	$("#patient tbody tr").bind('dblclick', function (event) {
    		var aData = oTable.fnGetData( this );
    		var id = aData[7];
    		affichervue(id);
    	});
    	
    }

    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    function affichervue(id_personne){
    	var id_cons = $("#"+id_personne).val();
    	var chemin = tabUrl[0]+'public/archivage/info-patient';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data:{'id_personne':id_personne, 'id_cons':id_cons},
            success: function(data) {
           	         
            	$("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> INFORMATIONS </div>");
            	var result = jQuery.parseJSON(data);
            	$("#contenu").fadeOut(function(){$("#vue_patient").html(result).fadeIn("fast"); }); 
            	     
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
     }
    
    function listepatient(){
	    $("#terminerVisualisationHosp").click(function(){
	    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> LISTE DES PATIENTS </div>");
  	    	$("#vue_patient").fadeOut(function(){$("#contenu").fadeIn("fast"); });
  	    });
    }
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    function hospitaliser(id_personne){
    	
    	var chemin = tabUrl[0]+'public/archivage/info-patient-hospi';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data:{'id_personne':id_personne},
            success: function(data) {
           	         
            	$("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> HOSPITALISER </div>");
            	var result = jQuery.parseJSON(data);
            	$("#vue_patient_hospi").html(result);
            	$("#division,#salle,#lit").val("");
            	$("#code_demande").val($("#"+id_personne+"dh").val());
            	$("#contenu").fadeOut(function(){$("#hospitaliser").fadeIn("fast"); }); 
            	     
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
        
    }
 
    /*************************************************************************************************************************/
    /*************************************************************************************************************************/
    /*************************************************************************************************************************/
    function getsalle(id_batiment){
      var chemin = tabUrl[0]+'public/archivage/salles';
      $.ajax({
        type: 'POST',
        url: chemin ,
        data:'id_batiment='+id_batiment,
        success: function(data) {
        	     var result = jQuery.parseJSON(data);  
        	     $("#salle").html(result); 
        },
        error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
        dataType: "html"
      });
    }
    
    function getlit(id_salle){ 
    	var chemin = tabUrl[0]+'public/archivage/lits';
    	$.ajax({
            type: 'POST',
            url: chemin ,
            data:'id_salle='+id_salle,
            success: function(data) {
            	     var result = jQuery.parseJSON(data);  
            	     $("#lit").html(result); 
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
    }

    /** CETTE PARTIE CONCERNE LA VUE DES DETAILS SUR LES INFOS DEMANDE D'HOSPITALISATION ET INFOS HOSPITALISATION **/
    /** CETTE PARTIE CONCERNE LA VUE DES DETAILS SUR LES INFOS DEMANDE D'HOSPITALISATION ET INFOS HOSPITALISATION**/
    /** CETTE PARTIE CONCERNE LA VUE DES DETAILS SUR LES INFOS DEMANDE D'HOSPITALISATION ET INFOS HOSPITALISATION**/
    /** CETTE PARTIE CONCERNE LA VUE DES DETAILS SUR LES INFOS DEMANDE D'HOSPITALISATION ET INFOS HOSPITALISATION**/
    
    /**INFO HOSPITALISATION**/
    function depliantPlus21() {
    	$('#titre_info_hospitalisation21').click(function(){
    		$("#titre_info_hospitalisation21").replaceWith(
    			"<span id='titre_info_hospitalisation21' style='margin-left:-5px; cursor:pointer;'>" +
    			"<img src='"+tabUrl[0]+"public/img/light/plus.png' /> Infos sur l'hospitalisation "+
    		    "</span>");
    		animationPliantDepliant21();
    		$('#info_hospitalisation21').animate({
    			height : 'toggle'
    		},1000);
    		return false;
    	});
    }
    
    function animationPliantDepliant21() {
    	$('#titre_info_hospitalisation21').click(function(){
    		$("#titre_info_hospitalisation21").replaceWith(
    			"<span id='titre_info_hospitalisation21' style='margin-left:-5px; cursor:pointer;'>" +
    			"<img src='"+tabUrl[0]+"public/img/light/minus.png' /> Infos sur l'hospitalisation"+
    		    "</span>");
    		depliantPlus21();
    		$('#info_hospitalisation21').animate({
    			height : 'toggle'
    		},1000);
    		return false;
    	});
    }
    
    /**INFO DEMANDE**/
    function depliantPlus41() {
    	$('#titre_info_demande41').click(function(){
    		$("#titre_info_demande41").replaceWith(
    			"<span id='titre_info_demande41' style='margin-left:-5px; cursor:pointer;'>" +
    			"<img src='"+tabUrl[0]+"public/img/light/plus.png' /> D&eacute;tails des infos sur la demande "+
    		    "</span>");
    		animationPliantDepliant41();
    		$('#info_demande41').animate({
    			height : 'toggle'
    		},1000);
    		return false;
    	});
    }
    
    function animationPliantDepliant41() {
    	$('#titre_info_demande41').click(function(){
    		$("#titre_info_demande41").replaceWith(
    			"<span id='titre_info_demande41' style='margin-left:-5px; cursor:pointer;'>" +
    			"<img src='"+tabUrl[0]+"public/img/light/minus.png' /> D&eacute;tails des infos sur la demande "+
    		    "</span>");
    		depliantPlus41();
    		$('#info_demande41').animate({
    			height : 'toggle'
    		},1000);
    		return false;
    	});
    }
    
    function initAnimationVue() {
    	$('#info_hospitalisation21').toggle(false);
    	$('#info_demande41').toggle(false);
    }