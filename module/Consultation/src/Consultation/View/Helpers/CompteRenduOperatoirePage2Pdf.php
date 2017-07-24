<?php
namespace Consultation\View\Helpers;

use ZendPdf;
use ZendPdf\Page;
use ZendPdf\Font;
use Consultation\Model\Consultation;

class CompteRenduOperatoirePage2Pdf
{
	protected $_page;
	protected $_yPosition;
	protected $_leftMargin;
	protected $_pageWidth;
	protected $_pageHeight;
	protected $_normalFont;
	protected $_boldFont;
	protected $_newTime;
	protected $_newTimeGras;
	protected $_year;
	protected $_headTitle;
	protected $_introText;
	protected $_graphData;
	protected $_patient;
	protected $_id_cons;
	protected $_date;
	protected $_note;
	protected $_idPersonne;
	protected $_Medicaments;
	protected $_DonneesPatient;
	protected $_DonneesMedecin;
	protected $_Donnees;
	protected $_policeContenu;
	protected $_newPolice;
	protected $_Service;
	protected $_infoAdmission;
	protected $_nbligne;
	protected $_entrerPO;
	protected $_entrerCOM;
	protected $_entrerSPO;
	protected $_textPO;
	protected $_textCOM;
	protected $_textSPO;
	
	
	public function __construct()
	{
		$this->_page = new Page(Page::SIZE_A4);
		
 		$this->_yPosition = 750;
 		$this->_leftMargin = 50;
 		$this->_pageHeight = $this->_page->getHeight();
 		$this->_pageWidth = $this->_page->getWidth();
 		/**
 		 * Pas encore utilisé
 		 */
 		$this->_normalFont = Font::fontWithName( ZendPdf\Font::FONT_HELVETICA);
 		$this->_boldFont = Font::fontWithName( ZendPdf\Font::FONT_HELVETICA_BOLD);
 		/**
 		 ***************** 
 		 */
 		$this->_newTime = Font::fontWithName(ZendPdf\Font::FONT_TIMES_ROMAN);
 		$this->_newTimeGras = Font::fontWithName(ZendPdf\Font::FONT_TIMES_BOLD_ITALIC);
 		$this->_policeContenu = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES);
 		$this->_newPolice = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES);
	}
	
	public function getPage(){
		return $this->_page;
	}
	
	public function addNoteTC(){
		$this->_page->saveGS();
		
		$this->getNoteTC();
		$this->getPiedPage();
		
		$this->_page->restoreGS();
	}
	
	public function baseUrl(){
		$baseUrl = $_SERVER['SCRIPT_FILENAME'];
		$tabURI  = explode('public', $baseUrl);
		return $tabURI[0];
	}
	
	public function setDonneesMedecinTC($donneesMedecin){
		$this->_DonneesMedecin = $donneesMedecin;
	}
	
	public function setDonnees($donnees){
		$this->_Donnees = $donnees;
	}

	public function getNewItalique(){
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_HELVETICA_OBLIQUE);
		$this->_page->setFont($font, 12);
	}
	
	public function getNewTime(){
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES_ROMAN);
		$this->_page->setFont($font, 12);
	}
	
	public function setNbLigne($nbligne) {
	    $this->_nbligne = $nbligne;
	}
	
	public function getNbLigne(){
	    return $this->_nbligne;
	}
	
	public function setEntrerPO($entrerPO) {
	    $this->_entrerPO = $entrerPO;
	}
	
	public function getEntrerPO(){
	    return $this->_entrerPO;
	}
	
	public function setEntrerCOM($entrerCOM) {
	    $this->_entrerCOM = $entrerCOM;
	}
	
	public function getEntrerCOM(){
	    return $this->_entrerCOM;
	}
	
	public function setEntrerSPO($entrerSPO) {
	    $this->_entrerSPO = $entrerSPO;
	}
	
	public function getEntrerSPO(){
	    return $this->_entrerSPO;
	}
	
	public function setTextPO($textPO) {
	    $this->_textPO = $textPO;
	}
	
	public function getTextPO(){
	    return $this->_textPO;
	}
	
	public function setTextCOM($textCOM) {
	    $this->_textCOM = $textCOM;
	}
	
	public function getTextCOM(){
	    return $this->_textCOM;
	}
	
	public function setTextSPO($textSPO) {
	    $this->_textSPO = $textSPO;
	}
	
	public function getTextSPO(){
	    return $this->_textSPO;
	}
    	
	protected  function getNoteTC(){
		$noteLineHeight = 35;
		$noteLineHeight -=15;
		$this->_yPosition -= $noteLineHeight+10;
		

		//*****************************************
		//*****************************************
		//*****************************************
		if($this->_entrerCOM == null && $this->_entrerSPO == null){

		    if($this->_entrerPO >= 18 && count($this->getTextPO()) > 18){
		        
		        for($i = $this->_entrerPO ; $i < count($this->getTextPO()) ; $i++){
		            $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
		            $this->_page->setLineWidth(0.5);
		            $this->_page->drawLine($this->_leftMargin,
		                $this->_yPosition,
		                $this->_pageWidth -
		                $this->_leftMargin,
		                $this->_yPosition);
		             
		            $this->_page->setFont($this->_policeContenu, 12);
		            $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->getTextPO()[$i] ),
		                $this->_leftMargin,
		                $this->_yPosition);
		        
		            $this->_yPosition -= $noteLineHeight;
		        }
		        
		    }
		    
		    //GESTION DES COMPLICATIONS
		    //GESTION DES COMPLICATIONS
		    
		    if($this->getTextCOM()[0]){
		        $this->_yPosition -= $noteLineHeight;
		        $this->_page->setFont($this->_newTimeGras, 14);
		        $this->_page->drawText('Complication : ',
		            $this->_leftMargin,
		            $this->_yPosition);
		        
		        $this->_yPosition -= $noteLineHeight;
		        
		        for($i = 0 ; $i < count($this->getTextCOM()) ; $i++){
		            $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
		            $this->_page->setLineWidth(0.5);
		            $this->_page->drawLine($this->_leftMargin,
		                $this->_yPosition,
		                $this->_pageWidth -
		                $this->_leftMargin,
		                $this->_yPosition);
		             
		            $this->_page->setFont($this->_policeContenu, 12);
		            $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->getTextCOM()[$i] ),
		                $this->_leftMargin,
		                $this->_yPosition);
		        
		            $this->_yPosition -= $noteLineHeight;
		        }
		    }
		    
		    //FIN GESTION DES COMPLICATIONS
		    //FIN GESTION DES COMPLICATIONS
		    
		    
		    
		    //GESTION DES SOINS POST OPERATOIRE
		    //GESTION DES SOINS POST OPERATOIRE
		    
		    $this->_yPosition -= $noteLineHeight;
		    $this->_page->setFont($this->_newTimeGras, 14);
		    $this->_page->drawText('Soins post opératoire : ',
		        $this->_leftMargin,
		        $this->_yPosition);
		    
		    $this->_yPosition -= $noteLineHeight;
		    
		    for($i = 0 ; $i < count($this->getTextSPO()) ; $i++){
		        $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
		        $this->_page->setLineWidth(0.5);
		        $this->_page->drawLine($this->_leftMargin,
		            $this->_yPosition,
		            $this->_pageWidth -
		            $this->_leftMargin,
		            $this->_yPosition);
		         
		        $this->_page->setFont($this->_policeContenu, 12);
		        $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->getTextSPO()[$i] ),
		            $this->_leftMargin,
		            $this->_yPosition);
		    
		        $this->_yPosition -= $noteLineHeight;
		    }
		    
		    //FIN GESTION DES SOINS POST OPERATOIRE
		    //FIN GESTION DES SOINS POST OPERATOIRE
		    
		}	
		//*****************************************
		//*****************************************
		//*****************************************

		else 
		if($this->_entrerCOM == null && $this->_entrerSPO != null){
		    
		    if($this->_entrerSPO == 0){
		        $this->_yPosition -= $noteLineHeight;
		        $this->_page->setFont($this->_newTimeGras, 14);
		        $this->_page->drawText('Soins post opératoire : ',
		            $this->_leftMargin,
		            $this->_yPosition);
		        
		        $this->_yPosition -= $noteLineHeight;
		        
		        for($i = 0 ; $i < count($this->getTextSPO()) ; $i++){
		            $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
		            $this->_page->setLineWidth(0.5);
		            $this->_page->drawLine($this->_leftMargin,
		                $this->_yPosition,
		                $this->_pageWidth -
		                $this->_leftMargin,
		                $this->_yPosition);
		             
		            $this->_page->setFont($this->_policeContenu, 12);
		            $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->getTextSPO()[$i] ),
		                $this->_leftMargin,
		                $this->_yPosition);
		        
		            $this->_yPosition -= $noteLineHeight;
		        }
		    }
		    else {
		        for($i = $this->_entrerSPO ; $i < count($this->getTextSPO()) ; $i++){
		        
		            $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
		            $this->_page->setLineWidth(0.5);
		            $this->_page->drawLine($this->_leftMargin,
		                $this->_yPosition,
		                $this->_pageWidth -
		                $this->_leftMargin,
		                $this->_yPosition);
		        
		            $this->_page->setFont($this->_policeContenu, 12);
		            $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->getTextSPO()[$i] ),
		                $this->_leftMargin,
		                $this->_yPosition);
		             
		            $this->_yPosition -= $noteLineHeight;
		        
		        }
		    }

		}
		//*****************************************
		//*****************************************
		//*****************************************
		else 
		if($this->_entrerCOM != null && $this->_entrerSPO == null){

		    //COMPLETER LE TEXT SUR LES COMPLICATIONS
		    //COMPLETER LE TEXT SUR LES COMPLICATIONS
		    for($i = $this->_entrerCOM ; $i < count($this->getTextCOM()) ; $i++){
		        
		        $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
		        $this->_page->setLineWidth(0.5);
		        $this->_page->drawLine($this->_leftMargin,
		            $this->_yPosition,
		            $this->_pageWidth -
		            $this->_leftMargin,
		            $this->_yPosition);
		        
		        $this->_page->setFont($this->_policeContenu, 12);
		        $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->getTextCOM()[$i] ),
		            $this->_leftMargin,
		            $this->_yPosition);
		        	
		        $this->_yPosition -= $noteLineHeight;
		        
		    }
		    
		    //AJOUTER LES SOINS POST OPERATOIRE
		    //AJOUTER LES SOINS POST OPERATOIRE
		    
		    $this->_yPosition -= $noteLineHeight;
		    $this->_page->setFont($this->_newTimeGras, 14);
		    $this->_page->drawText('Soins post opératoire : ',
		        $this->_leftMargin,
		        $this->_yPosition);
		    
		    $this->_yPosition -= $noteLineHeight;
		    
		    for($i = 0 ; $i < count($this->getTextSPO()) ; $i++){
		        $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
		        $this->_page->setLineWidth(0.5);
		        $this->_page->drawLine($this->_leftMargin,
		            $this->_yPosition,
		            $this->_pageWidth -
		            $this->_leftMargin,
		            $this->_yPosition);
		        	
		        $this->_page->setFont($this->_policeContenu, 12);
		        $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->getTextSPO()[$i] ),
		            $this->_leftMargin,
		            $this->_yPosition);
		    
		        $this->_yPosition -= $noteLineHeight;
		    }
		    
		    //FIN AJOUTER LES SOINS POST OPERATOIRE
		    //FIN AJOUTER LES SOINS POST OPERATOIRE
		}
		//*****************************************
		//*****************************************
		//*****************************************
		else 
		if($this->_entrerCOM != null && $this->_entrerSPO != null){

		    //var_dump($this->_entrerSPO); exit();
		    
		    if($this->_entrerSPO == 0){
		        $this->_yPosition -= $noteLineHeight;
		        $this->_page->setFont($this->_newTimeGras, 14);
		        $this->_page->drawText('Soins post opératoire : ',
		            $this->_leftMargin,
		            $this->_yPosition);
		    
		        $this->_yPosition -= $noteLineHeight;
		    
		        for($i = 0 ; $i < count($this->getTextSPO()) ; $i++){
		            $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
		            $this->_page->setLineWidth(0.5);
		            $this->_page->drawLine($this->_leftMargin,
		                $this->_yPosition,
		                $this->_pageWidth -
		                $this->_leftMargin,
		                $this->_yPosition);
		             
		            $this->_page->setFont($this->_policeContenu, 12);
		            $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->getTextSPO()[$i] ),
		                $this->_leftMargin,
		                $this->_yPosition);
		    
		            $this->_yPosition -= $noteLineHeight;
		        }
		    }
		    else {
		        for($i = $this->_entrerSPO ; $i < count($this->getTextSPO()) ; $i++){
		    
		            $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
		            $this->_page->setLineWidth(0.5);
		            $this->_page->drawLine($this->_leftMargin,
		                $this->_yPosition,
		                $this->_pageWidth -
		                $this->_leftMargin,
		                $this->_yPosition);
		    
		            $this->_page->setFont($this->_policeContenu, 12);
		            $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->getTextSPO()[$i] ),
		                $this->_leftMargin,
		                $this->_yPosition);
		             
		            $this->_yPosition -= $noteLineHeight;
		    
		        }
		    }
		    
		    
		}
		
		//*****************************************
		//*****************************************
		//*****************************************
			
	} 
	
	public function getPiedPage(){
		$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
		$this->_page->setLineWidth(1.5);
		$this->_page->drawLine($this->_leftMargin,
				80,
				$this->_pageWidth -
				$this->_leftMargin,
				80);
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Téléphone: 33 961 00 21',
				$this->_leftMargin,
				$this->_pageWidth - ( 100 + 430));
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('SIMENS+: ',
				$this->_leftMargin + 355,
				$this->_pageWidth - ( 100 + 430));
		$this->_page->setFont($this->_newTimeGras, 11);
		$this->_page->drawText('www.simens.sn',
				$this->_leftMargin + 405,
				$this->_pageWidth - ( 100 + 430));
	}
	
}