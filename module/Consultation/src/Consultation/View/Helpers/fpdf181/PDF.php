<?php
namespace Consultation\View\Helpers\fpdf181;

use Consultation\View\Helpers\fpdf181\fpdf;

class PDF extends fpdf
{

	function Footer()
	{
		// Positionnement à 1,5 cm du bas
		$this->SetY(-15);
		
		$this->SetFillColor(0,128,0);
		$this->Cell(0,0.3,"",0,1,'C',true);
		$this->SetTextColor(0,0,0);
		$this->SetFont('Times','',9.5);
		$this->Cell(81,5,'Téléphone: 33 961 00 21 ',0,0,'L',false);
		$this->SetTextColor(128);
		$this->SetFont('Times','I',9);
		$this->Cell(20,8,'Page '.$this->PageNo(),0,0,'C',false);
		$this->SetTextColor(0,0,0);
		$this->SetFont('Times','',9.5);
		$this->Cell(81,5,'SIMENS+: www.simens.sn',0,0,'R',false);
	}
	
	protected $B = 0;
	protected $I = 0;
	protected $U = 0;
	protected $HREF = '';
	
	function WriteHTML($html)
	{
		// Parseur HTML
		$html = str_replace("\n",' ',$html);
		$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				// Texte
				if($this->HREF)
					$this->PutLink($this->HREF,$e);
				else
					$this->Write(5,$e);
			}
			else
			{
				// Balise
				if($e[0]=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
					// Extraction des attributs
					$a2 = explode(' ',$e);
					$tag = strtoupper(array_shift($a2));
					$attr = array();
					foreach($a2 as $v)
					{
						if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
							$attr[strtoupper($a3[1])] = $a3[2];
					}
					$this->OpenTag($tag,$attr);
				}
			}
		}
	}
	
	function OpenTag($tag, $attr)
	{
		// Balise ouvrante
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF = $attr['HREF'];
		if($tag=='BR')
			$this->Ln(5);
	}
	
	function CloseTag($tag)
	{
		// Balise fermante
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF = '';
	}
	
	function SetStyle($tag, $enable)
	{
		// Modifie le style et sélectionne la police correspondante
		$this->$tag += ($enable ? 1 : -1);
		$style = '';
		foreach(array('B', 'I', 'U') as $s)
		{
			if($this->$s>0)
				$style .= $s;
		}
		$this->SetFont('',$style);
	}
	
	function PutLink($URL, $txt)
	{
		// Place un hyperlien
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(5,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
	}
	
	
	
	
	
	
	
	
	protected $tabInformations ;
	protected $InfosEnTete;
	protected $infosPatients;
	
	public function setTabInformations($tabInformations)
	{
		$this->tabInformations = $tabInformations;
	}
	
	public function getTabInformations()
	{
		return $this->tabInformations;
	}
	
	public function setInfosEnTete($InfosEnTete)
	{
		$this->InfosEnTete = $InfosEnTete;
	}
	
	public function getInfosEnTete()
	{
		return $this->InfosEnTete;
	}
	
	public function getInfosPatients()
	{
		return $this->infosPatients;
	}
	
	public function setInfosPatients($infosPatients)
	{
		$this->infosPatients = $infosPatients;
	}
	
	function EnTetePage()
	{
		$this->SetFont('Times','',10.3);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,4,"République du Sénégal");
		$this->SetFont('Times','',8.5);
		$this->Cell(0,4,"Saint-Louis, le ".$this->getInfosEnTete()['dateIntervention'],0,0,'R');
		$this->SetFont('Times','',10.3);
		$this->Ln(5.4);
		$this->Cell(100,4,"Ministère de la santé et de l'action sociale");
		
		$this->AddFont('timesbi','','timesbi.php');
		
		//***infos de la salle
		//***infos de la salle
		$this->SetFont('timesbi','',10.3);
		$this->Cell(11,4,"Salle :",0,0,'L');
		$this->SetFont('Times','',10.3);
		$this->Cell(42,4,$this->getInfosEnTete()['salle'],0,0,'L');
		
		
		$this->Ln(5.4);
		$this->Cell(100,4,"C.H.R de Saint-louis");
		
		//***Infos du médecin opératuer
		//***Infos du médecin opérateur
		$this->SetFont('timesbi','',10.3);
		$this->Cell(19,4,"Opérateur :",0,0,'L');
		$this->SetFont('Times','',10.3);
		$this->Cell(65,4, $this->getInfosEnTete()['infosNomPrenomOperateur'],0,0,'L');
		
		$this->Ln(5.4);
		$this->SetFont('timesbi','',10.3);
		$this->Cell(14,4,"Service : ",0,0,'L');
		$this->SetFont('Times','',10.3);
		$this->Cell(86,4,$this->getInfosEnTete()['service'],0,0,'L');
		
		//***Infos de l'anesthésiste
		//***Infos de l'anesthésiste
		$this->SetFont('timesbi','',10.3);
		$this->Cell(23,4,"Anesthésiste :",0,0,'L');
		$this->SetFont('Times','',10.3);
		$this->Cell(42,4,$this->getInfosEnTete()['anesthesiste'],0,0,'L');

		//***Infos sur le Chech list de sécurité
		//***Infos sur le Chech list de sécurité
		if($this->getInfosEnTete()['check_list_securite'] == 1){ $check_list_securite = 'Oui'; }else{ $check_list_securite = 'Non'; }
		$this->Ln(5.4);
		$this->Cell(100,4,"");
		$this->SetFont('timesbi','',10.3);
		$this->Cell(36,4,"Check list de sécurité :",0,0,'L');
		$this->SetFont('Times','',10.3);
		$this->Cell(42,4,$check_list_securite,0,0,'L');
		
		$this->Ln(5.4);
		$this->SetFont('Times','I',10);
		$this->Cell(52,5,"n°: ".$this->getInfosEnTete()['id_patient'],0,0,'L');
		
		$this->SetFont('Times','',14.3);
		$this->SetTextColor(0,128,0);
		$this->Cell(131,5,"COMPTE RENDU OPERATOIRE",0,0,'L');
		$this->Ln(5.5);
		$this->SetFillColor(0,128,0);
		$this->Cell(0,0.3,"",0,1,'C',true);
	
		// EMPLACEMENT DU LOGO
		// EMPLACEMENT DU LOGO
		$baseUrl = $_SERVER['SCRIPT_FILENAME'];
		$tabURI  = explode('public', $baseUrl);
		$this->Image($tabURI[0].'public/images_icons/hrsl.png', 15, 49, 35, 15);
	
		// EMPLACEMENT DES INFORMATIONS SUR LE PATIENT
		// EMPLACEMENT DES INFORMATIONS SUR LE PATIENT
		$infoPatients = $this->getInfosPatients();
		$this->SetFont('Times','B',8.5);
		$this->SetTextColor(0,0,0);
		$this->Ln(1);
		$this->Cell(90,4,"PRENOM ET NOM :",0,0,'R',false);
		$this->SetFont('Times','',11);
		if($infoPatients){ $this->Cell(92,4,iconv ('UTF-8' , 'windows-1252', $infoPatients['PRENOM']).' '.iconv ('UTF-8' , 'windows-1252', $infoPatients['NOM']),0,0,'L'); }
	
		$this->SetFont('Times','B',8.5);
		$this->SetTextColor(0,0,0);
		$this->Ln(5);
		$this->Cell(90,4,"SEXE :",0,0,'R',false);
		$this->SetFont('Times','',11);
		if($infoPatients){ $this->Cell(92,4,iconv ('UTF-8' , 'windows-1252', $infoPatients['SEXE']),0,0,'L'); }
	
		$this->SetFont('Times','B',8.5);
		$this->SetTextColor(0,0,0);
		$this->Ln(5);
		$this->Cell(90,4,"AGE :",0,0,'R',false);
		$this->SetFont('Times','',11);
		if($infoPatients){ $this->Cell(92,4,$infoPatients['AGE'].' ans',0,0,'L'); }
	
		$this->SetFont('Times','B',8.5);
		$this->SetTextColor(0,0,0);
		$this->Ln(5);
		$this->Cell(90,4,"TELEPHONE :",0,0,'R',false);
		$this->SetFont('Times','',11);
		if($infoPatients){ $this->Cell(72,4,$infoPatients['TELEPHONE'],0,0,'L'); }
		
		$this->Ln(5);
		$this->SetFillColor(0,128,0);
		$this->Cell(0,0.3,"",0,1,'C',true);
		
		$this->Ln(1);
		if($this->getInfosEnTete()['aides_operateurs']){
			$this->SetFillColor(249,249,249);
			$this->SetDrawColor(220,220,220);
			$this->AddFont('zap','','zapfdingbats.php');
			$this->AddFont('Timesb','','timesb.php');
			$this->SetFont('zap','',13);
			$this->Cell(5,6,"b","BT",0,'R',1);
			
			$this->SetFont('Timesb','',8.5);
			$this->Cell(33,6,"AIDES OPERATEURS :","BT",0,'R',1);
			$this->SetFont('Times','',10);
			$this->MultiCell(145,6,$this->getInfosEnTete()['aides_operateurs'],"BT",'L',1);
			$this->Ln(3);
		}
	}
	
	function CorpsDocument()
	{
		$this->AddFont('zap','','zapfdingbats.php');
		
		for($i = 0 ; $i < count($this->getTabInformations()) ; $i++){
			if($this->getTabInformations()[$i]['texte']){
				$this->Ln(2.5);
				if($this->getTabInformations()[$i]['type'] == 2){
					$this->SetFont('zap','',13);
					$this->Cell(4,5,"o",0,0,'L'); 
					
					$this->SetFont('Times','',12.3);
					$this->WriteHTML('<B><U>'.$this->getTabInformations()[$i]['titre'].' :</U></B>');
					$this->Ln(6);
					$this->MultiCell(0, 6.8, trim(preg_replace('#(\r?\n){2,}#', "\n", $this->getTabInformations()[$i]['texte'])));
				}else 
					if($this->getTabInformations()[$i]['type'] == 1){
						$this->SetFont('zap','',13);
						$this->Cell(4,5.5,"p",0,0,'L');
						
						$this->SetFont('Times','',12.3);
						$this->WriteHTML('<B><U>'.$this->getTabInformations()[$i]['titre'].' :</U></B>  ');
						$this->MultiCell(0, 5, trim($this->getTabInformations()[$i]['texte']));
					}
			}
		}
	}
	
	//IMPRESSION DES COMPTES RENDUS OPERATOIRE
	//IMPRESSION DES COMPTES RENDUS OPERATOIRE
	//IMPRESSION DES COMPTES RENDUS OPERATOIRE
	function ImpressionCompteRenduOperatoire()
	{
		$this->AddPage();
		$this->EnTetePage();
		$this->CorpsDocument();
	}
	
}

?>
