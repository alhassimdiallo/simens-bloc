<?php
namespace Consultation\View\Helpers;

use ZendPdf;
use ZendPdf\Page;
use ZendPdf\Font;
use Consultation\Model\Consultation;
use Facturation\View\Helper\DateHelper; 


class ProtocoleOperatoirePdf
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
	
	public function setEnTete(){
		$baseUrl = $_SERVER['SCRIPT_FILENAME'];
		$tabURI  = explode('public', $baseUrl);
		
		$imageHeader = ZendPdf\Image::imageWithPath($tabURI[0].'public/img/polycliniquelogo.png');
		$this->_page->drawImage($imageHeader, 445, //-x
				$this->_pageHeight - 130, //-y
				528, //+x
				787); //+y
		
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
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Service: '.iconv ('UTF-8' ,'ISO-8859-1' ,$this->_Service),
				$this->_leftMargin,
				$this->_pageHeight - 95);
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES_ROMAN);
		$this->_page->setFont($font, 8);
		$today = new \DateTime ();
		$dateNow = $today->format ( 'd/m/Y' );
		$this->_page->drawText('Saint-Louis le, ' . $dateNow,
				450,
				$this->_pageHeight - 50);
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
	
	public function setIdConsTC($id_cons){
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
		$tab[1] = substr($Text, 0, 95);
		$tab[2] = substr($Text, 95, 110);
		$tab[3] = substr($Text, 205, 110);
		return $tab;
	}
	
	protected function scinderTextO($Text){
		$tab = array();
		$tab[1] = substr($Text, 0, 90);
		$tab[2] = substr($Text, 90, 110);
		$tab[3] = substr($Text, 200, 110);
		return $tab;
	}
	
	protected function scinderTextPO($Text){
		$tab = array();
		$tab[1] = substr($Text, 0, 80);
		$tab[2] = substr($Text, 80, 110);
		$tab[3] = substr($Text, 190, 110);
		$tab[4] = substr($Text, 300, 110);
		$tab[5] = substr($Text, 410, 110);
		$tab[6] = substr($Text, 520, 110);
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
	
	protected  function getNoteTC(){
		$Control = new DateHelper();
		
		$this->_yPosition -= 35;
		$this->_page->setFont($this->_newTime, 15);
		$this->_page->setFillColor(new ZendPdf\Color\Html('green'));
		$this->_page->drawText('PROTOCOLE OPERATOIRE',
				$this->_leftMargin+160,
				$this->_yPosition);
		$this->_yPosition -= 5;
		$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
		$this->_page->drawLine($this->_leftMargin,
				$this->_yPosition,
				$this->_pageWidth -
				$this->_leftMargin,
				$this->_yPosition);
		$noteLineHeight = 30;
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
					$this->_yPosition-10,
					$this->_pageWidth -
					$this->_leftMargin,
					$this->_yPosition-10);
			
		$this->_yPosition -= $noteLineHeight+10;//aller a la ligne suivante
		
		//PREPARATION DU TEXT Diagnostic
		$tab = $this->scinderText( $this->_DonneesDemande['diagnostic'] );
		//PREPARATION DU TEXT Observation
		$tab2 = $this->scinderTextO($this->_DonneesDemande['observation']);
		//PREPARATION DU TEXT Protocole operatoire
		$tab3 = $this->scinderTextPO($this->_DonneesDemande['note_compte_rendu_operatoire']);
		
		
		for($i = 1 ; $i < 18 ; $i++){
			
			$this->_page->setlineColor(new ZendPdf\Color\Html('#efefef'));
			$this->_page->setLineWidth(0.5);
			$this->_page->drawLine($this->_leftMargin,
					$this->_yPosition,
					$this->_pageWidth -
					$this->_leftMargin,
					$this->_yPosition);
			
			if($i == 1){
				$this->_page->setFont($this->_newTimeGras, 13);
				$this->_page->drawText('Diagnostic :   ',
						$this->_leftMargin,
						$this->_yPosition);
				$this->_page->setFont($this->_policeContenu, 12);
				$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $tab[1] ),
						$this->_leftMargin+80,
						$this->_yPosition);
			}
			else 
				if($i == 2){
					$this->_page->setFont($this->_policeContenu, 12);
					$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $tab[2] ),
							$this->_leftMargin,
							$this->_yPosition);
				}
				else 
					if($i == 3){
						$this->_page->setFont($this->_newTimeGras, 13);
						$this->_page->drawText('Intervention réalisée :   ',
								$this->_leftMargin,
								$this->_yPosition);
						$this->_page->setFont($this->_policeContenu, 12);
						$this->_page->drawText($this->_DonneesDemande['intervention_prevue'],
								$this->_leftMargin+125,
								$this->_yPosition);
					}
					else 
						if($i == 4){
							$this->_page->setFont($this->_newTimeGras, 13);
							$this->_page->drawText('Type d\'anesthésie :   ',
									$this->_leftMargin,
									$this->_yPosition);
							$this->_page->setFont($this->_policeContenu, 13);
							$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $this->_DonneesDemande['resultatTypeIntervention'] ),
									$this->_leftMargin+120,
									$this->_yPosition);
						}
						else 
							if($i == 5){
								$this->_page->setFont($this->_newTimeGras, 13);
								$this->_page->drawText('VPA N° :  ',
										$this->_leftMargin,
										$this->_yPosition);
								$this->_page->setFont($this->_policeContenu, 13);
								$this->_page->drawText($this->_DonneesDemande['resultatNumeroVPA'],
										$this->_leftMargin+60,
										$this->_yPosition);
							}
							else 
								if($i == 6){
									$this->_page->setFont($this->_newTimeGras, 13);
									$this->_page->drawText('Observation :  ',
											$this->_leftMargin,
											$this->_yPosition);
									$this->_page->setFont($this->_policeContenu, 12);
									$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $tab2[1] ),
											$this->_leftMargin+90,
											$this->_yPosition);
								}
								else 
									if($i == 7){
										$this->_page->setFont($this->_policeContenu, 12);
										$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $tab2[2] ),
												$this->_leftMargin,
												$this->_yPosition);
									}
									else 
											if($i == 8){
												$this->_page->setFont($this->_newTimeGras, 13);
												$this->_page->drawText('Protocole opératoire :  ',
														$this->_leftMargin,
														$this->_yPosition);
												$this->_page->setFont($this->_policeContenu, 12);
												$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $tab3[1] ),
														$this->_leftMargin+125,
														$this->_yPosition);
											}
											else 
												if($i == 9){
													$this->_page->setFont($this->_policeContenu, 12);
													$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $tab3[2] ),
															$this->_leftMargin+0,
															$this->_yPosition);
												}
												else
												if($i == 10){
													$this->_page->setFont($this->_policeContenu, 12);
													$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $tab3[3] ),
															$this->_leftMargin+0,
															$this->_yPosition);
												}
												else
												if($i == 11){
													$this->_page->setFont($this->_policeContenu, 12);
													$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $tab3[4] ),
															$this->_leftMargin+0,
															$this->_yPosition);
												}
												else
												if($i == 12){
													$this->_page->setFont($this->_policeContenu, 12);
													$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $tab3[5] ),
															$this->_leftMargin+0,
															$this->_yPosition);
												}
												else
												if($i == 13){
													$this->_page->setFont($this->_policeContenu, 12);
													$this->_page->drawText(iconv ( 'UTF-8', 'ISO-8859-1', $tab3[6] ),
															$this->_leftMargin+0,
															$this->_yPosition);
												}
			
			$this->_yPosition -= $noteLineHeight;
		}
				
		
			
		
		$this->_page->setFont($this->_policeContenu, 14);
		$this->_page->drawText($this->_DonneesMedecin['prenomMedecin'] .' '. $this->_DonneesMedecin['nomMedecin'],
				$this->_leftMargin+300,
				$this->_yPosition+90);
	} 
	
	public function getPiedPage(){
		$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
		$this->_page->setLineWidth(1.5);
		$this->_page->drawLine($this->_leftMargin,
				120,
				$this->_pageWidth -
				$this->_leftMargin,
				120);
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Téléphone: 33 961 00 21',
				$this->_leftMargin,
				$this->_pageWidth - ( 100 + 390));
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('SIMENS+: ',
				$this->_leftMargin + 355,
				$this->_pageWidth - ( 100 + 390));
		$this->_page->setFont($this->_newTimeGras, 11);
		$this->_page->drawText('www.simens.sn',
				$this->_leftMargin + 405,
				$this->_pageWidth - ( 100 + 390));
	}
	
}