/* 	jquery joliSelect - jQuery plugin
 *	written by Gaëlle Vaudaine	
 *
 *	Copyright (c) 2013 Gaëlle Vaudaine (http://tarabusk.net)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 * INSTRUCTIONS : http://memo-web.fr/categorie-jquery-224.php
 *
 *
 */
 /*
 TODO list
 - Rajouter des événements sur le select
 - Garder les attributs id et name du select d'origine
 - Améliorer le rendu de la surimpression de l'élément sélectionné dans la liste
 - Rendre paramétrable l'animation d'ouverture de la liste
 - Rendre paramétrable le nombre d'items affichés sans scroll plutôt que la hauteur max sans scroll
 .*
 /*
 *	 example for $("#combo").joliSelect();
 *	
 * 	<div class="combo">
       <form method="GET" action="page.html">
         <select id="combo">
          <option value="" selected></option>
          <option value=""></option>
          <option value=""></option>
          ....
         </select>
       </form>
	</div>
 */

(function($)
{ 
    
    $.fn.joliSelect=function(options,obj)
    {     
	    switch (options) {
		  case 'selected':
				var $obj;
				$(this).each(function() {
					$obj=$(this);
					if (!$obj.hasClass('joliSelect')) {
					//	$.fn.joliSelect.debug('Seul les éléments joliSelect sont accepté pour la méthode disable : '+this);
					} else {
						//if ($obj.children('.mOptions').children('.mCurrent').size()!=0) $obj.children('.mOptions').children('.mCurrent').removeClass('mCurrent').children('.mRadio')[0].checked=false;
						//$obj.children('.mSelected').html($obj.children('.mOptions').children('.mOption').eq(obj).html()).children('.mRadio').remove();
						//$obj.children('.mOptions').children('.mOption').eq(obj).addClass('mCurrent').children('.mRadio')[0].checked=true;
					}
				});
			break;
			default:
			
	    // if ($.browser.msie && (parseInt($.browser.version) < 7))  exit;
            //On définit nos paramètres par défaut
        var defauts=
            {      
		'bkdColor'      :'#e7e9ba',  // BackgroundColor of the joliSelect		
		'bkdColorSelect':'#e7d2a0',  // BackgroundColor of the selected item 
        'arrowColor'    : '#e7d2a0', // Color of the arrow		
		'fontColor'     : '#555555', //
		'width'         : '0',       //width of the element if not determined, we take the width of the SELECT element
		'defaultWidth'  : '200',     // If no width found 
		'defaultHeight' : '',
		'maxHeight'     : '300',     // Max height of the list
		'tailleFleche'  : '6',
		'defaultText'   : 'Choose',  // Text if no selected item
		'separateur'    : '**',
		'autocomplete'  : true,
		'fontfamilyselect':false,    // Add a font-family to any of each item
		'onChooseItem'       : null
            };  
            
        var parametres    = $.extend(defauts, options);	

         
		
         return this.each(function()
        {     
            var element         = $(this);	
			element.hide();
            var id_old          = element.attr('id');				
            if (element.attr('name')!= 'undefined'){
			  var name_old          =id_old;	
			}else{
			  var name_old          =element.attr('name');	
			}				
            var totalItems      = element.find('option').length;
            var availableTags   = '[';           
			var joli_val        = new Array ();
			var joli_txt        = new Array ();			
			var largeur_element = element.css('width');
			
			var html = '';  				
			html += '<ul id="combo_'+id_old+'">';			
           
		    joli_txt[id_old] = parametres.defaultText;
			joli_val[id_old] = -1;
					
            element.find('option').each(function(i) //Puis on parcourt chaque item !
            {	
			  var tabTxt = $(this).html().split(parametres.separateur);		            		  
			  var txtItem = tabTxt[0];
			  if (tabTxt.length > 1)
			    var txtShow = tabTxt[1];
			  else
			    var txtShow = tabTxt[0];
			  if ($(this).attr('class')=="undefined"){
                var LClass=$(this).attr('class');}
              else{
  			     var LClass="";}
				 
			  if ($(this).attr('style')!="undefined"){
                var LStyle=$(this).attr('style');}
              else{
  			     var LStyle="";}
			// Tricky here, because if no option is selected, the browser will preselect the first item
			  if ($(this).is(":selected")&& ($(this).attr("selected")=='selected')){			  		
			    joli_txt[id_old]  = txtShow;				
				if ($(this).val()!='')
			      joli_val[id_old]    = $(this).val();
				else
				  joli_val[id_old]    = txtShow;
				LClass  = LClass+' item_sel';
				if (parametres.fontfamilyselect){ 
				  LFontFamily = $(this).attr('value');
				}else{LFontFamily = '';}
			  }
			  
			  html += '<li style="'+LStyle+'" class="'+LClass+'">'+txtItem;
			  html += '<input type="hidden" class="hidden_'+id_old+'" value="'+$(this).val()+'" />';
			  html += '<input type="hidden" class="txtS_'+id_old+'" value="'+txtShow+'" />';
			  html += ' </li>';	
			  
			  availableTags +='{id : "'+$(this).val()+'", label :"'+txtItem+'", labelS :"'+txtShow+'"}';	
			  if (i+1<totalItems) availableTags+=',';
            });		
			html += '</ul>';
						
			//--> construction du nouvel objet
			
			/*var labelAss=element.prev("label");
			if (labelAss.attr('for')==element.attr('id')){
			  labelAss.attr('for', 'joliSelect'+id_old);
			}*/
			
			var objet_conteneur = $('<div class="joliSelect" id="joliSelect_'+id_old+'"></div>');
			objet_conteneur.insertAfter (element);
			objet_conteneur.css("margin", element.css("margin") );
			
			element.remove();
			
			var objet_joli_txt=$( "<input type='text' autocomplete='off'  class='joli_txt' name='joli_txt_"+id_old+"' id='joli_txt_"+id_old+"' />" );
			objet_conteneur.append (objet_joli_txt);		
			
			var obj_combo_fleche = $( "<b id='combo_fleche_"+id_old+"' class='combo_fleche'> </b>" );
            obj_combo_fleche.insertAfter (objet_joli_txt);
			
			var objet_joli_val=$( "<input type='hidden' name='"+name_old+"' id='"+id_old+"' />" );
			objet_joli_val.insertAfter (obj_combo_fleche);
			
			var objet_combo=$( html );
			objet_combo.insertAfter (objet_joli_val);
				
			
			availableTags+=']';
			availableTags=eval(availableTags);					
          		
			objet_joli_txt.val(joli_txt[id_old]);
			objet_joli_txt.attr('title',joli_txt[id_old]);
			objet_joli_val.val(joli_val[id_old]);       
			
			if (parametres.width > 0){			 
			  var largeur_combo = parametres.width;
			}else if (largeur_element > 0){
			  var largeur_combo = Math.max (10,parseInt(largeur_element));
			}else{
              var largeur_combo = parametres.defaultWidth;
            }			
			
			largeur_combo = parseInt(largeur_combo)-parseInt(2*parametres.tailleFleche);
			//Affectation des styles 
			objet_joli_txt.css(
                    {
                        'width': largeur_combo+'px',	                      		
						'background': parametres.bkdColor,
                        'border': '1px solid '+parametres.bkdColorSelect,
                        'color':parametres.fontColor,
                        'height':parametres.defaultHeight,
						'font-family':LFontFamily						
                    });
					
			//if (parametres.defaultHeight!=""){loverflowY='scroll';}else{loverflowY='';}
			objet_combo.css({                   
					    'width': parseInt(objet_joli_txt.css('width')) + + parseInt(objet_joli_txt.css('paddingRight'))+'px',
					/*	'left':objet_joli_txt.position().left,*/
						'padding':'2px',
                        'background': parametres.bkdColor,
                        'border': '1px solid '+parametres.bkdColorSelect,
						'maxHeight': parametres.maxHeight+'px',
						'display':'none',
						'color': parametres.fontColor,
						//'overflowY':loverflowY,				  
				        'position':'absolute',
						'listStyle':'none',
				        'zIndex':'2', 
						'marginTop':'2px'
                    });
			
			$("#combo_"+id_old+" li").css(
                    {					    
						'padding':'2px',
                        'display': 'block',
                        'cursor': 'pointer',						
						'color':parametres.fontColor
                    });		
			
			var fleche_left=-2*parseInt(parametres.tailleFleche)-parseInt(2);		
			obj_combo_fleche.css(
                    {					    
						'borderRight': parametres.tailleFleche+'px solid transparent',
						'borderTop': parseInt(parametres.tailleFleche)+parseInt(2) +'px solid '+parametres.arrowColor,
						'borderLeft': parametres.tailleFleche+'px solid transparent',                       
					//	'margin': parseInt(objet_joli_txt.css('height')) - parametres.tailleFleche-parseInt(8)+'px 0px 0px '+ fleche_left+'px'
                    });
			
				
			function closeCombo(){				   
			  objet_combo.hide('fast');
			  objet_joli_txt.val(joli_txt[id_old]);			 
			  if (objet_joli_val.val() != joli_val[id_old]){			  
				  		  
				  objet_joli_txt.val(joli_txt[id_old]);
				  objet_joli_txt.attr('title',joli_txt[id_old]);
				  if (parametres.fontfamilyselect){ 
				    objet_joli_txt.css({'font-family':joli_val[id_old]});	
                   }   
				  objet_joli_val.val(joli_val[id_old]);
				  
                    
				  if (parametres.onChooseItem){
					parametres.onChooseItem($(this));
					
				  }	
				  $("#combo_"+id_old+" li").removeClass("item_sel");          		  
				  $('input[type=hidden][class=hidden_'+id_old+'][value='+joli_val[id_old]+']').parent('li').addClass("item_sel");
              }			  
              //e.stopPropagation(); 	//Viré car pose problème avec l'autocomplétion, ne valide pas le choix. Pb à résoudre !		  
			}
			
			// Affectation des événements sur les objets 		
			$('html').click(function(e){    

			  if(e.target.id == objet_joli_txt.attr('id') || e.target.id == objet_combo.attr('id') ||e.target.id == obj_combo_fleche.attr('id')) {
			  } else {			    
			    closeCombo(e);		
			  }
			});
			
			if(parametres.autocomplete){
				objet_joli_txt.autocomplete({ 
				  source: availableTags,
				  minLength: 1,
				  select: function(event, ui)
							{		                        					
							 joli_txt[id_old] = ui.item.labelS;	
							 joli_val[id_old]   = ui.item.id;	
							 return false;                        						 
							},
				  
				  close: function(event, ui)
							{							 					 
							} 				   
				});
			}
			//id_old_format= id_old.replace(/[[]/g,'\\\\[');		
			//id_old_format= id_old_format.replace(/]/g,'\\\\]');
			$("#combo_"+id_old+" li").hover(
			  function () {
				$(this).css({'background': parametres.bkdColorSelect});
			  },
			  function () {
				$(this).css({'background': parametres.bkdColor});
			  }
			);
			
			$("#combo_"+id_old+" li").click(function() {			                
			    joli_txt[id_old] = $(this).children('input[type=hidden][class=txtS_'+id_old+']').val();			 
				joli_val[id_old]   = $(this).children('input').val();               				
                $("#select_combo").toggle('fast');   							
            });
			
			objet_joli_txt.click(function() {	
                objet_combo.show('fast');
				objet_joli_txt.val('');
            });
		    obj_combo_fleche.click(function() {	
                objet_combo.show('fast');
				objet_joli_txt.val('');
            });
			
			objet_combo.click(function(e) {			
                closeCombo(e);
            });
			
            objet_joli_txt.keyup(function(e) { 
			  var letter = String.fromCharCode(e.keyCode);			                
            });			

            $(document).bind('click', function(e) {
                var $clicked = $(e.target);
                if (! $clicked.parents().hasClass("dropdown"))
                    $(".dropdown dd ul").hide();
            });
        });    
     } // switch		
	 
	 
    };
})(jQuery);