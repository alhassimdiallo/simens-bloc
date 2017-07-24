<?php
namespace Consultation\View\Helpers;

use ZendPdf;
use ZendPdf\Page;
use ZendPdf\Font;
use Consultation\Model\Consultation;
use Facturation\View\Helper\DateHelper; 


class DemandeExamenPdf
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
	protected $_NotesDemande;
	protected $_DonneesDemandeMorph;
	protected $_notesDemandeMorph;
	
	protected $_policeContenu;
	protected $_newPolice;
	protected $_courier;
	protected $_service;	
	
	public function __construct()
	{
		$this->_page = new Page(650,700);
		
 		$this->_yPosition = 610;
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
 		$this->_courier = Font::fontWithName(ZendPdf\Font::FONT_COURIER);
 		$this->_newTime = Font::fontWithName(ZendPdf\Font::FONT_TIMES_ROMAN);
 		$this->_newTimeGras = Font::fontWithName(ZendPdf\Font::FONT_TIMES_BOLD);
 		$this->_policeContenu = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_COURIER);
 		$this->_newPolice = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES);
	}
	
	public function getPage(){
		return $this->_page;
	}
	
	public function addNoteBio(){
		$this->_page->saveGS();
		
		$this->setEnTete();
		$this->getNoteBio();
		$this->getPiedPage();
		
		$this->_page->restoreGS();
	}
	
	public function setEnTete(){
		$baseUrl = $_SERVER['SCRIPT_FILENAME'];
		$tabURI  = explode('public', $baseUrl);
		
		$imageHeader = ZendPdf\Image::imageWithPath($tabURI[0].'public/img/polycliniquelogo.png');
		$this->_page->drawImage($imageHeader, 505, //-x
				$this->_pageHeight - 130, //-y
				600, //+x
				650); //+y
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('République du Sénégal',
				$this->_leftMargin,
				$this->_pageHeight - 50);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Ministère de la santé et de l\'action sociale',
				$this->_leftMargin,
				$this->_pageHeight - 65);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Polyclinique de l\'UGB de Saint-Louis',
				$this->_leftMargin,
				$this->_pageHeight - 80);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Service: '.iconv ('UTF-8' ,'ISO-8859-1' ,$this->_Service),
				$this->_leftMargin,
				$this->_pageHeight - 95);
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES_ROMAN);
		$this->_page->setFont($font, 8);
		$today = new \DateTime ();
		$dateNow = $today->format ( 'd/m/Y' );
		$this->_page->drawText('Saint-Louis le, ' . $dateNow, 510,
				$this->_pageHeight - 50);
		
		$this->_yPosition -= 35;
		$this->_page->setFont($this->_newTime, 15);
		$this->_page->setFillColor(new ZendPdf\Color\Html('green'));
		$this->_page->drawText('Demande d\'examen Bio & Morpho',
				$this->_leftMargin+155,
				$this->_yPosition);
		$this->_yPosition -= 5;
		$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
		//$this->_page->setLineWidth(1);
		$this->_page->drawLine($this->_leftMargin,
				$this->_yPosition,
				$this->_pageWidth -
				$this->_leftMargin,
				$this->_yPosition);
		$this->_yPosition -= 15;
	}
	
	public function setService($service){
		$this->_Service = $service;
	}
	
	public function setDonneesPatientBio($donneesPatient){
		$this->_DonneesPatient = $donneesPatient;
	}
	
	public function setDonneesMedecinBio($donneesMedecin){
		$this->_DonneesMedecin = $donneesMedecin;
	}
	
	public function setDonneesDemandeBio($donneesDemande){
		$this->_DonneesDemande = $donneesDemande;
	}
	
	public function setNotesDemandeBio($notesDemande){
		$this->_NotesDemande = $notesDemande;
	}

	public function setDonneesDemandeMorph($donneesDemandeMorph){
		$this->_DonneesDemandeMorph = $donneesDemandeMorph;
	}
	
	public function setNotesDemandeMorph($notesDemandeMorph){
		$this->_notesDemandeMorph = $notesDemandeMorph;
	}
	
	public function setIdConsBio($id_cons){
		$this->_id_cons = $id_cons;
	}
	
	public function getNewItalique(){
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_HELVETICA_OBLIQUE);
		$this->_page->setFont($font, 12);
	}
	
	public function getNewTime(){
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES_ROMAN);
		$this->_page->setFont($font, 12);
	}
	
	protected function scinderText($Text){
		$tab = array();
		$tab[1] = substr($Text, 0, 50);
		$tab[2] = substr($Text, 50, 65);
		$tab[3] = substr($Text, 115, 65);
		$tab[4] = substr($Text, 180, 65);
		$tab[5] = substr($Text, 245, 65);
		$tab[6] = substr($Text, 310, 65);
		$tab[7] = substr($Text, 375, 65);
		return $tab;
	}
	
	protected function nbAnnees($debut, $fin) {
		//60 secondes X 60 minutes X 24 heures dans une journee
		$nbSecondes = 60*60*24*365;
	
		$debut_ts = strtotime($debut);
		$fin_ts = strtotime($fin);
		$diff = $fin_ts - $debut_ts;
		return (int)($diff / $nbSecondes);
	}
	
	protected function listeDesExamensBioMorpho(){
		$ExamensBioMorpho = array(
			
				'1' => 'Groupe sanguin',
				'2' => 'HÃ©mogramme sanguin',
				'3' => 'Bilan hÃ©matique',
				'4' => 'Bilan rÃ©nal',
				'5' => 'Bilan hÃ©mostase',
				'6' => 'Bilan inflammatoire',
				'8' => 'Radiologie',
				'9' => 'Echographie',
				'10' => 'IRM',
				'11' => 'Scanner',
				'12' => 'Fibroscopie',
		);
		return $ExamensBioMorpho;
	}
	
	
	protected  function getNoteBio(){
		$Control = new DateHelper();
		$noteLineHeight = 30;
		$this->_page->setFillColor(new ZendPdf\Color\Html('black')); //Pour le text
		
		//$this->_page->setLineColor(new ZendPdf\Color\Html('#999999')); //Pour les ligne
		//$this->_page->setLineWidth(0.2);
		//$this->_page->setLineDashingPattern(array(1, 2));

			
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
			$this->_page->setFont($this->_newTimeGras, 9);
			$this->_page->drawText('DATE DE NAISSANCE :',
					$this->_leftMargin+135,
					$this->_yPosition);
			$this->_page->setFont($this->_newTime, 11);
			$this->_page->drawText($Control->convertDate($this->_DonneesPatient['DATE_NAISSANCE'])."  (".$this->nbAnnees($this->_DonneesPatient['DATE_NAISSANCE'],$date_actu)." ans)",
					$this->_leftMargin+240,
					$this->_yPosition);
			
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
			
			
			
			//$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
			//$this->_page->setLineWidth(1);
			//$this->_page->setLineDashingPattern(array(0, 0));
			$this->_page->drawLine($this->_leftMargin,
					$this->_yPosition-10,
					$this->_pageWidth -
					$this->_leftMargin,
					$this->_yPosition-10);
			
		$this->_yPosition -= $noteLineHeight+10;//aller a la ligne suivante
		
		$examensBio = count($this->_DonneesDemande);
		$examensMorpho = count($this->_DonneesDemandeMorph);
		$i = 1;
		$n = 1;
		//PREPARATION DU TEXT Diagnostic
		while($this->_yPosition > 70) {
			if($this->_DonneesDemande && $i == 1){
				$this->_page->setFont($this->_courier, 15);
				$this->_page->drawText(iconv ('UTF-8' ,'ISO-8859-1' ,'Examens Biologiques:'),
				$this->_leftMargin,
				$this->_yPosition);
				
				$this->_page->setlineColor(new ZendPdf\Color\Html('gray'));
				//$this->_page->setLineWidth(0.7);
				$this->_page->drawLine(
						$this->_leftMargin,
						$this->_yPosition-5,
						$this->_pageWidth - $this->_leftMargin - 370,
						$this->_yPosition-5
				);
				
				$this->_yPosition -= $noteLineHeight;
			} 
			
			if($i <= $examensBio){
				
				if($this->_DonneesDemande[$i]){

					$this->_page->setFont($this->_newTimeGras, 12);
					$this->_page->drawText($i.') '.iconv ('UTF-8' ,'ISO-8859-1' ,$this->listeDesExamensBioMorpho()[$this->_DonneesDemande[$i]].':'),
					$this->_leftMargin,
					$this->_yPosition);
					$this->_page->setFont($this->_policeContenu, 12);
					$this->_page->drawText(iconv ('UTF-8' ,'ISO-8859-1' ,$this->_NotesDemande[$i]),
					$this->_leftMargin+138,
					$this->_yPosition);
				
				}
				
			}
			
			if($this->_DonneesDemandeMorph && $i == count($this->_DonneesDemande)+1){
			
				$this->_page->setFont($this->_courier, 15);
				$this->_page->drawText(iconv ('UTF-8' ,'ISO-8859-1' ,'Examens Morphologiques:'),
				$this->_leftMargin,
				$this->_yPosition);
				
				$this->_page->setlineColor(new ZendPdf\Color\Html('gray'));
				//$this->_page->setLineWidth(0.7);
				//$this->_page->setLineDashingPattern(array(0, 0));
				$this->_page->drawLine(
						$this->_leftMargin,
						$this->_yPosition-5,
						$this->_pageWidth - $this->_leftMargin - 345,
						$this->_yPosition-5
				);
				
				$this->_yPosition -= $noteLineHeight;
			
			}
			
 			if( $i > $examensBio && $i <= ($examensBio+$examensMorpho) ){

 				if($this->_DonneesDemandeMorph[$i]){
			
					$this->_page->setFont($this->_newTimeGras, 12);
					$this->_page->drawText($n++.') '.iconv ('UTF-8' ,'ISO-8859-1' ,$this->listeDesExamensBioMorpho()[$this->_DonneesDemandeMorph[$i]].':'),
							$this->_leftMargin,
							$this->_yPosition);
					$this->_page->setFont($this->_policeContenu, 12);
					$this->_page->drawText(iconv ('UTF-8' ,'ISO-8859-1' ,$this->_notesDemandeMorph[$i]),
							$this->_leftMargin+138,
							$this->_yPosition);
			
				}
			
 			}
			
			$i++;
			
				$this->_page->setlineColor(new ZendPdf\Color\Html('white'));
				$this->_page->setLineWidth(0);
				//$this->_page->setLineDashingPattern(array(1, 1));
				$this->_page->drawLine(
						$this->_leftMargin,
						$this->_yPosition-5,
						$this->_pageWidth -
						$this->_leftMargin,
						$this->_yPosition-5
				);
			$this->_yPosition -= $noteLineHeight;
		}
		
		$this->_page->setFont($this->_policeContenu, 14);
		$this->_page->drawText($this->_DonneesMedecin['prenomMedecin'].' '.$this->_DonneesMedecin['nomMedecin'] ,
				$this->_leftMargin+370,
				$this->_yPosition+90);
	} 
	
	
	public function getPiedPage(){
		$this->_yPosition -= -30;
		$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
		$this->_page->setLineWidth(2);
		//$this->_page->setLineDashingPattern(array(0, 0));		
		$this->_page->drawLine($this->_leftMargin,
						$this->_yPosition,
						$this->_pageWidth -
						$this->_leftMargin,
						$this->_yPosition);
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Téléphone: 33 726 25 36   BP: 25 000',
				$this->_leftMargin,
				$this->_pageWidth - ( $this->_yPosition + 503));
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Consultation numéro: ',
				$this->_leftMargin + 370,
				$this->_pageWidth - ( $this->_yPosition + 503));
		$this->_page->setFont($this->_newTimeGras, 11);
		$this->_page->drawText($this->_id_cons,
				$this->_leftMargin + 465,
				$this->_pageWidth - ( $this->_yPosition + 503));
	}
	
	
}