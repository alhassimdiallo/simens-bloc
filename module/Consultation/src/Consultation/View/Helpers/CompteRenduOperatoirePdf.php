<?php
namespace Consultation\View\Helpers;

use ZendPdf;
use ZendPdf\Page;
use ZendPdf\Font;
use Consultation\Model\Consultation;
use Facturation\View\Helper\DateHelper; 


class CompteRenduOperatoirePdf
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
	protected $_DonneesDemande;
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
	protected $_infoNomPrenomOperateur;
	
	
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
		
		$this->setEnTete();
		$this->getNoteTC();
		$this->getPiedPage();
		
		$this->_page->restoreGS();
	}
	
	public function baseUrl(){
		$baseUrl = $_SERVER['SCRIPT_FILENAME'];
		$tabURI  = explode('public', $baseUrl);
		return $tabURI[0];
	}
	
	public function setEnTete(){
		$baseUrl = $_SERVER['SCRIPT_FILENAME'];
		$tabURI  = explode('public', $baseUrl);
		
		$imageHeader = ZendPdf\Image::imageWithPath($tabURI[0].'public/images_icons/hrsl.png');
		$this->_page->drawImage($imageHeader, 50, //-x
				$this->_pageHeight - 190, //-y
				155, //+x
				702); //+y
		
		$this->_page->setFont($this->_newTimeGras, 10);
		$this->_page->drawText('Salle:',
				$this->_leftMargin + 300,
				$this->_pageHeight - 65);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText($this->_infoAdmission['salle'],
				$this->_leftMargin + 330,
				$this->_pageHeight - 65);
		
		$this->_page->setFont($this->_newTimeGras, 10);
		$this->_page->drawText('Opérateur:',
				$this->_leftMargin + 300,
				$this->_pageHeight - 80);
		$this->_page->setFont($this->_newTime, 10);
// 		$this->_page->drawText($this->_DonneesMedecin['prenomMedecin'].' '.$this->_DonneesMedecin['nomMedecin'],
// 				$this->_leftMargin + 350,
// 				$this->_pageHeight - 80);
		$this->_page->drawText($this->_infoNomPrenomOperateur,
				$this->_leftMargin + 350,
				$this->_pageHeight - 80);

		
		$this->_page->setFont($this->_newTimeGras, 10);
		$this->_page->drawText('Anesthésiste:',
				$this->_leftMargin + 300,
				$this->_pageHeight - 95);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText(iconv ('UTF-8' ,'ISO-8859-1' , $this->_DonneesDemande['anesthesiste'] ),
				$this->_leftMargin + 360,
				$this->_pageHeight - 95);
		
		$CHL = "Non";
		if($this->_DonneesDemande['check_list_securite'] == 1){
		    $CHL = "Oui";
		}
		
		$this->_page->setFont($this->_newTimeGras, 10);
		$this->_page->drawText('Chech list de sécurité:',
		    $this->_leftMargin + 300,
		    $this->_pageHeight - 110);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText(iconv ('UTF-8' ,'ISO-8859-1' , $CHL ),
		    $this->_leftMargin + 395,
		    $this->_pageHeight - 110);
		
		
		
		
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('République du Sénégal',
				$this->_leftMargin,
				$this->_pageHeight - 50);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Ministère de la santé et de l\'action sociale',
				$this->_leftMargin,
				$this->_pageHeight - 65);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('C.H.R de Saint-Louis',
				$this->_leftMargin,
				$this->_pageHeight - 80);
		
		$this->_page->setFont($this->_newTimeGras, 10);
		$this->_page->drawText('Service: ',
				$this->_leftMargin,
				$this->_pageHeight - 95);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText(iconv ('UTF-8' ,'ISO-8859-1' ,$this->_Service),
				$this->_leftMargin + 40,
				$this->_pageHeight - 95);
		
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES_ROMAN);
		$this->_page->setFont($font, 8);
		$this->_page->drawText('Saint-Louis, le ' . $this->_DonneesDemande['dateIntervention'],
				450,
				$this->_pageHeight - 50);
	}
	
	public function setDonneesOperateur($infoNomPrenomOperateur){
		$this->_infoNomPrenomOperateur = $infoNomPrenomOperateur;
	}
	
	public function setDonneesPatientTC($donneesPatient){
		$this->_DonneesPatient = $donneesPatient;
	}
	
	public function setDonneesMedecinTC($donneesMedecin){
		$this->_DonneesMedecin = $donneesMedecin;
	}
	
	public function setDonneesDemandeTC($donneesDemande){
		$this->_DonneesDemande = $donneesDemande;
	}

	public function setService($service){
		$this->_Service = $service;
	}
	
	public function setInfoAdmission($infoAdmission){
		$this->_infoAdmission = $infoAdmission;
	}
	
	public function getNewItalique(){
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_HELVETICA_OBLIQUE);
		$this->_page->setFont($font, 12);
	}
	
	public function getNewTime(){
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES_ROMAN);
		$this->_page->setFont($font, 12);
	}
	
	protected function nbAnnees($debut, $fin) {
		//60 secondes X 60 minutes X 24 heures dans une journee
		$nbSecondes = 60*60*24*365;
	
		$debut_ts = strtotime($debut);
		$fin_ts = strtotime($fin);
		$diff = $fin_ts - $debut_ts;
		return (int)($diff / $nbSecondes);
	}
	
	protected function gestionDuTexte($Texte){
	    $tableau = array();
	    return $tableau;
	}
	
	protected function setNbLigne($nbligne) {
	    $this->_nbligne = $nbligne;
	}
	
	public function getNbLigne(){
	    return $this->_nbligne; 
	}
	
	protected function setEntrerPO($entrerPO) {
	    $this->_entrerPO = $entrerPO;
	}
	
	public function getEntrerPO(){
	    return $this->_entrerPO;
	}
	
	protected function setEntrerCOM($entrerCOM) {
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
		$Control = new DateHelper();
		
		$this->_yPosition -= 35;
		$this->_page->setFont($this->_newTime, 15);
		$this->_page->setFillColor(new ZendPdf\Color\Html('green'));
		$this->_page->drawText('COMPTE RENDU OPERATOIRE',
				$this->_leftMargin+140,
				$this->_yPosition);
		$this->_yPosition -= 5;
		$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
		$this->_page->drawLine($this->_leftMargin,
				$this->_yPosition,
				$this->_pageWidth -
				$this->_leftMargin,
				$this->_yPosition);
		$noteLineHeight = 22;
		$this->_yPosition -= 15;
		
		$this->_page->setFillColor(new ZendPdf\Color\Html('black')); 
		
		$this->_page->setLineColor(new ZendPdf\Color\Html('#999999')); 
		
		$today = new \DateTime();
		$date_actu = $today->format('Y-m-d');

			//-----------------------------------------------
			$this->_page->setFont($this->_newTimeGras, 9);
			$this->_page->drawText('PRENOM & NOM :',
					$this->_leftMargin+155,
					$this->_yPosition);
			$this->_page->setFont($this->_newTime, 11);
			$this->_page->drawText($this->_DonneesPatient['PRENOM'].' '.$this->_DonneesPatient['NOM'],
					$this->_leftMargin+240,
					$this->_yPosition);
			//-----------------------------------------------
			$this->_yPosition -= 15;// allez a ligne suivante
			//----- -----------------------------------------
			$this->_page->setFont($this->_newTimeGras, 9);
			$this->_page->drawText('SEXE :',
					$this->_leftMargin+205,
					$this->_yPosition);
			$this->_page->setFont($this->_newTime, 11);
			$this->_page->drawText(iconv ('UTF-8' ,'ISO-8859-1' ,$this->_DonneesPatient['SEXE']),
					$this->_leftMargin+240,
					$this->_yPosition);
			
 			//-----------------------------------------------
			$this->_yPosition -= 15;// allez a ligne suivante
			//----- -----------------------------------------
			$date_naissance = $this->_DonneesPatient['DATE_NAISSANCE'];
			if($date_naissance){ $date_naissance = $Control->convertDate($date_naissance); } else {$date_naissance = null; }
				
 			if($date_naissance){
				$this->_page->setFont($this->_newTimeGras, 9);
				$this->_page->drawText('DATE DE NAISSANCE :',
						$this->_leftMargin+135,
						$this->_yPosition);
				$this->_page->setFont($this->_newTime, 10);
			
				$this->_page->drawText($date_naissance."  (".$this->_DonneesPatient['AGE']." ans)",
						$this->_leftMargin+240,
						$this->_yPosition);
			}else {
				$this->_page->setFont($this->_newTimeGras, 9);
				$this->_page->drawText('AGE :',
						$this->_leftMargin+209,
						$this->_yPosition);
				$this->_page->setFont($this->_newTime, 10);
			
				$this->_page->drawText($this->_DonneesPatient['AGE']." ans",
						$this->_leftMargin+240,
						$this->_yPosition);
			}
			
			
			//-----------------------------------------------
			$this->_yPosition -= 15;// allez a ligne suivante
			//----- -----------------------------------------
			$this->_page->setFont($this->_newTimeGras, 9);
			$this->_page->drawText('ADRESSE :',
					$this->_leftMargin+187,
					$this->_yPosition);
			$this->_page->setFont($this->_newTime, 11);
			$this->_page->drawText(iconv ('UTF-8' ,'ISO-8859-1' ,$this->_DonneesPatient['ADRESSE']),
					$this->_leftMargin+240,
					$this->_yPosition);
			
			
			$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
			$this->_page->setLineWidth(1);
			$this->_page->drawLine($this->_leftMargin,
					$this->_yPosition-5,
					$this->_pageWidth -
					$this->_leftMargin,
					$this->_yPosition-5);
			
		$this->_yPosition -= $noteLineHeight+10; //aller a la ligne suivante
		
		
		
		//-------- Les aides opérateurs --------
		//-------- Les aides opérateurs --------

		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Aides opérateurs :   ',
				$this->_leftMargin,
				$this->_yPosition+16);
		$this->_page->setFont($this->_policeContenu, 10);
		$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->_DonneesDemande['aides_operateurs'] ),
				$this->_leftMargin+80,
				$this->_yPosition+16);
		$this->_page->setlineColor(new ZendPdf\Color\Html('black'));
		$this->_page->setLineWidth(0.5);
		$this->_page->drawLine($this->_leftMargin,
				$this->_yPosition+14,
				$this->_pageWidth -
				$this->_leftMargin - 423,
				$this->_yPosition+14);
		
		$this->_yPosition -= 10; //aller a la ligne suivante
		
		//======================================
		//======================================

		
		$protocole_operatoire  = $this->_DonneesDemande['protocole_operatoire'];
		$soins_post_operatoire = $this->_DonneesDemande['soins_post_operatoire'];
		$complications         = $this->_DonneesDemande['complications'];
		
		
		$TableauPO  = explode( "\n" , $protocole_operatoire);
		$TableauSPO = explode( "\n" , $soins_post_operatoire);
		$TableauCOM = explode( "\n" , $complications );
		
		
 		for($i = 1 ; $i < 6 ; $i++){
			
			$this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
			$this->_page->setLineWidth(0.5);
			$this->_page->drawLine($this->_leftMargin,
					$this->_yPosition,
					$this->_pageWidth -
					$this->_leftMargin,
					$this->_yPosition);
			
			if($i == 1){
				$this->_page->setFont($this->_newTimeGras, 14);
				$this->_page->drawText('Diagnostic :   ',
						$this->_leftMargin,
						$this->_yPosition);
				$this->_page->setFont($this->_policeContenu, 12);
				$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->_infoAdmission['diagnostic'] ),
						$this->_leftMargin+80,
						$this->_yPosition);
			}
			else 
				if($i == 2){
					$this->_page->setFont($this->_newTimeGras, 14);
					$this->_page->drawText('Indication :   ',
							$this->_leftMargin,
							$this->_yPosition);
					$this->_page->setFont($this->_policeContenu, 12);
					$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->_DonneesDemande['indication'] ),
							$this->_leftMargin+80,
							$this->_yPosition);
				}
				else 
					if($i == 3){
						$this->_page->setFont($this->_newTimeGras, 14);
						$this->_page->drawText('Intervention prévue :   ',
								$this->_leftMargin,
								$this->_yPosition);
						$this->_page->setFont($this->_policeContenu, 12);
						$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->_infoAdmission['intervention_prevue']),
								$this->_leftMargin+125,
								$this->_yPosition);
					}
					else 
						if($i == 4){
							$this->_page->setFont($this->_newTimeGras, 14);
							$this->_page->drawText('Type d\'anesthésie :   ',
									$this->_leftMargin,
									$this->_yPosition);
							$this->_page->setFont($this->_policeContenu, 13);
							$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->_DonneesDemande['type_anesthesie'] ),
									$this->_leftMargin+120,
									$this->_yPosition);
						}
						else 
							if($i == 5){
								$this->_page->setFont($this->_newTimeGras, 14);
								$this->_page->drawText('N° VPA :  ',
										$this->_leftMargin,
										$this->_yPosition);
								$this->_page->setFont($this->_policeContenu, 13);
								$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->_infoAdmission['vpa']),
										$this->_leftMargin+60,
										$this->_yPosition);
								$noteLineHeight +=15;
							}
							
			$this->_yPosition -= $noteLineHeight;
							
 		}
 		
 		$noteLineHeight -=15;
 		$nbLigne = 0;
 		//Gestion du protocole opératoire
 		//Gestion du protocole opératoire
 		
 		//Préparation du texte pour le protocole opératoire
 		//Préparation du texte pour le protocole opératoire
 		$TextProtocoleOperatoire = array();
 		
 		for($i = 0 ; $i < count($TableauPO) ; $i++){
 		
 		    if( strlen($TableauPO[$i]) > 108 ){
 		        $textDecouper = wordwrap($TableauPO[$i], 108, "\n", false); // On découpe le texte
 		        $textDecouperTab = explode( "\n" ,$textDecouper); // On le place dans un tableau
 		
 		        for($j = 0 ; $j < count($textDecouperTab) ; $j++){
 		            $TextProtocoleOperatoire[] = $textDecouperTab[$j];
 		        }
 		
 		    }else{
 		        $TextProtocoleOperatoire[] = $TableauPO[$i];
 		    }
 		     
 		}
 		$this->setTextPO($TextProtocoleOperatoire);
 		
 		$maxLigne = 18;
 		//Fin préparation du texte du protocole opératoire
 		//Fin préparation du texte du protocole opératoire
 		
 		$this->_page->setFont($this->_newTimeGras, 14);
 		$this->_page->drawText('Protocole opératoire :  ',
 		    $this->_leftMargin,
 		    $this->_yPosition);
 		
 		$this->_yPosition -= $noteLineHeight;
 		
 		$actuLigne = $nbLigne;
 		for($i = 0 ; $i < ($maxLigne-$actuLigne) && $i < count($TextProtocoleOperatoire); $i++){
 		    $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
 		    $this->_page->setLineWidth(0.5);
 		    $this->_page->drawLine($this->_leftMargin,
 		        $this->_yPosition,
 		        $this->_pageWidth -
 		        $this->_leftMargin,
 		        $this->_yPosition);
 		    	
 		    $this->_page->setFont($this->_policeContenu, 12);
 		    $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $TextProtocoleOperatoire[$i] ),
 		        $this->_leftMargin,
 		        $this->_yPosition);
 		
 		    $this->_yPosition -= $noteLineHeight;
 		    $nbLigne++;
 		}
 		$this->setEntrerPO($i); 
 		$this->setNbLigne($nbLigne);
 		
 		//Fin de la gestion du protocole opératoire
 		//Fin de la gestion du protocole opératoire
 		
 		
 		
 		//Gestion des complications
 		//Gestion des complications
 		
 		//Préparation du texte des complications
 		//Préparation du texte des complications
 		$TextComplication = array();
 		
 		for($i = 0 ; $i < count($TableauCOM) ; $i++){
 		
 		    if( strlen($TableauCOM[$i]) > 108 ){
 		        $textDecouper = wordwrap($TableauCOM[$i], 108, "\n", false); // On découpe le texte
 		        $textDecouperTab = explode( "\n" ,$textDecouper); // On le place dans un tableau
 		
 		        for($j = 0 ; $j < count($textDecouperTab) ; $j++){
 		            $TextComplication[] = $textDecouperTab[$j];
 		        }
 		
 		    }else{
 		        $TextComplication[] = $TableauCOM[$i];
 		    }
 		     
 		}
 		$this->setTextCOM($TextComplication);
 		//Fin préparation du texte des complications
 		//Fin préparation du texte des complications

 		$maxLigne -= 2;
 		if($complications != ""){
 		    if($nbLigne < $maxLigne){
 		        
 		        $this->_yPosition -= $noteLineHeight;
 		        $this->_page->setFont($this->_newTimeGras, 14);
 		        $this->_page->drawText('Complications :  ',
 		            $this->_leftMargin,
 		            $this->_yPosition);
 		        
 		        $this->_yPosition -= $noteLineHeight;
 		        
 		        $actuLigne = $nbLigne;
 		        for($i = 0 ; $i < ($maxLigne-$actuLigne) && $i < count($TextComplication); $i++){
 		            $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
 		            $this->_page->setLineWidth(0.5);
 		            $this->_page->drawLine($this->_leftMargin,
 		                $this->_yPosition,
 		                $this->_pageWidth -
 		                $this->_leftMargin,
 		                $this->_yPosition);
 		             
 		            $this->_page->setFont($this->_policeContenu, 12);
 		            $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $TextComplication[$i] ),
 		                $this->_leftMargin,
 		                $this->_yPosition);
 		            
 		            $this->_yPosition -= $noteLineHeight;
 		            $nbLigne++;
 		        }
 		        
 		        $this->setEntrerCOM($i);
 		    }
 		    
 		    $maxLigne -= 2; //En sortant, on reduit le maxLigne de deux lignes
 		}
 		
 		$this->setNbLigne($nbLigne);
 			
 		//Fin de la gestion des complications
 		//Fin de la gestion des complications
 		
 		
 		
 		//Gestion des soins post opératoire
 		//Gestion des soins post opératoire

 		//Préparation du texte des soins post opératoire
 		//Préparation du texte des soins post opératoire
 		$TextSoinsPostOp = array();
 		for($i = 0 ; $i < count($TableauSPO) ; $i++){
 		     
 		    if( strlen($TableauSPO[$i]) > 108 ){
 		        $textDecouper = wordwrap($TableauSPO[$i], 108, "\n", false); // On découpe le texte
 		        $textDecouperTab = explode( "\n" ,$textDecouper); // On le place dans un tableau
 		         
 		        for($j = 0 ; $j < count($textDecouperTab) ; $j++){
 		            $TextSoinsPostOp[] = $textDecouperTab[$j];
 		        }
 		         
 		    }else{
 		        $TextSoinsPostOp[] = $TableauSPO[$i];
 		    }
 		
 		}
 		$this->setTextSPO($TextSoinsPostOp);
 		
 		//Fin préparation du texte des soins post opératoire
 		//Fin préparation du texte des soins post opératoire
 		
 		if($nbLigne < $maxLigne){

 		    $this->_yPosition -= $noteLineHeight;
 		    $this->_page->setFont($this->_newTimeGras, 14);
 		    $this->_page->drawText('Soins post opératoire : ',
 		        $this->_leftMargin,
 		        $this->_yPosition);
 		     
 		    $this->_yPosition -= $noteLineHeight;
 		     
 		    $actuLigne = $nbLigne;
 		    for($i = 0 ; $i < ($maxLigne-$actuLigne) && $i < count($TextSoinsPostOp); $i++){
 		        $this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
 		        $this->_page->setLineWidth(0.5);
 		        $this->_page->drawLine($this->_leftMargin,
 		            $this->_yPosition,
 		            $this->_pageWidth -
 		            $this->_leftMargin,
 		            $this->_yPosition);
 		
 		        $this->_page->setFont($this->_policeContenu, 12);
 		        $this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $TextSoinsPostOp[$i] ),
 		            $this->_leftMargin,
 		            $this->_yPosition);
 		         
 		        $this->_yPosition -= $noteLineHeight;
 		        $nbLigne++;
 		    }
 		     
 		    $this->setEntrerSPO($i);
 		}
 		//Fin Gestion des soins post opératoire
 		//Fin Gestion des soins post opératoire
 		 	
 		$this->setNbLigne($nbLigne);
	}
	
	public function getPiedPage(){
		$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
		$this->_page->setLineWidth(1.5);
		$this->_page->drawLine($this->_leftMargin,
				70,
				$this->_pageWidth -
				$this->_leftMargin,
				70);
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Téléphone: 33 961 00 21',
				$this->_leftMargin,
				$this->_pageWidth - ( 100 + 440));
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('SIMENS+: ',
				$this->_leftMargin + 355,
				$this->_pageWidth - ( 100 + 440));
		$this->_page->setFont($this->_newTimeGras, 11);
		$this->_page->drawText('www.simens.sn',
				$this->_leftMargin + 405,
				$this->_pageWidth - ( 100 + 440));
	}
	
}