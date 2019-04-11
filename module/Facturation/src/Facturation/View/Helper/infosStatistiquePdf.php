<?php
namespace Facturation\View\Helper;

use Consultation\View\Helpers\fpdf181\fpdf;

class infosStatistiquePdf extends fpdf
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
	protected $nomService;
	protected $infosComp;
	protected $periodeIntervention;
	
	public function setTabInformations($tabInformations)
	{
		$this->tabInformations = $tabInformations;
	}
	
	public function getTabInformations()
	{
		return $this->tabInformations;
	}
	
	public function getNomService()
	{
		return $this->nomService;
	}
	
	public function setNomService($nomService)
	{
		$this->nomService = $nomService;
	}
	
	public function getPeriodeIntervention()
	{
		return $this->periodeIntervention;
	}
	
	public function setPeriodeIntervention($periodeIntervention)
	{
		$this->periodeIntervention = $periodeIntervention;
	}

	public function getInfosComp()
	{
		return $this->infosComp;
	}
	
	public function setInfosComp($infosComp)
	{
		$this->infosComp = $infosComp;
	}
	
	function EnTetePage()
	{
		$this->SetFont('Times','',10.3);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,4,"République du Sénégal");
		$this->SetFont('Times','',8.5);
		$this->Cell(0,4,"Saint-Louis, le ".$this->getInfosComp()['dateImpression'],0,0,'R');
		$this->SetFont('Times','',10.3);
		$this->Ln(5.4);
		$this->Cell(100,4,"Ministère de la santé et de l'action sociale");
		
		$this->AddFont('timesbi','','timesbi.php');
		$this->Ln(5.4);
		$this->Cell(100,4,"C.H.R de Saint-louis");
		$this->Ln(5.4);
		$this->SetFont('timesbi','',10.3);
		$this->Cell(14,4,"Service : ",0,0,'L');
		$this->SetFont('Times','',10.3);
		$this->Cell(86,4,$this->getNomService(),0,0,'L');
		
		$this->Ln(8);
		$this->SetFont('Times','',14.3);
		$this->SetTextColor(0,128,0);
		$this->Cell(0,5,"RAPPORT STATISTIQUES",0,1,'C');
		$this->SetFillColor(0,128,0);
		$this->Cell(0,0.3,"",0,1,'C',true);
	
		// EMPLACEMENT DU LOGO
		// EMPLACEMENT DU LOGO
		$baseUrl = $_SERVER['SCRIPT_FILENAME'];
		$tabURI  = explode('public', $baseUrl);
		$this->Image($tabURI[0].'public/images_icons/hrsl.png', 162, 19, 35, 15);
		
	}
	
	function CorpsDocument()
	{
		if($this->getPeriodeIntervention()){
			$dateConvert = new DateHelper();
			$date_debut = $dateConvert->convertDate($this->getPeriodeIntervention()[0]);
			$date_fin   = $dateConvert->convertDate($this->getPeriodeIntervention()[1]);
			
			$this->Ln(4);
			$this->SetFillColor(220,220,220);
			$this->SetDrawColor(205,193,197);
			$this->SetTextColor(0,0,0);
			$this->AddFont('zap','','zapfdingbats.php');
			$this->SetFont('zap','',13);
			
			$this->SetFillColor(255,255,255);
			$this->Cell(55,7,'','',0,'L',1);
			
			$this->SetFillColor(220,220,220);
			$this->SetLineWidth(1);
			$this->Cell(5,8,'B','BLT',0,'L',1);
			
			$this->AddFont('timesb','','timesb.php');
			$this->AddFont('timesi','','timesi.php');
			$this->AddFont('times','','times.php');
			
			$this->SetFont('times','',12.5);
			$this->Cell(70,8,"Période du ".$date_debut." au ".$date_fin,'BRT',0,'L',1);
			
			$this->SetFillColor(255,255,255);
			$this->Cell(53,7,'','L',0,'L',1);
			
			$this->Ln(7);
			$this->SetLineWidth(0);
		}

		$tabInformations = $this->getTabInformations(); 
		
		if($tabInformations){
			
			
			$toutService = array();
			$diffService = array();
			
			$toutDiagnosticService = array();
			$diffLibelleDiagnostic = array();
			
			$j=-1;
			for($i=0 ; $i < count($tabInformations) ; $i++){
					
				$service = $tabInformations[$i]['nom_service'];
				$toutService[] = $service;
				if(!in_array($service, $diffService)){
					$diffService[] = $service;
					$diffLibelleDiagnostic[$service] = array();
					$j++;
				}
					
				if($diffService[$j] == $service){
					$libelleDiagnostic = $tabInformations[$i]['libelle'];
					$toutDiagnosticService[$service][] = $libelleDiagnostic;
					if(!in_array($libelleDiagnostic, $diffLibelleDiagnostic[$service])){
						$diffLibelleDiagnostic[$service][] = $libelleDiagnostic;
					}
				}
					
			}
			
			$toutServiceNbVal = array_count_values($toutService);
			$totatlDesInterventions = 0;
			
			for($i=0 ; $i<count($diffService) ; $i++){
					
				$totatlDesInterventions +=$toutServiceNbVal[$diffService[$i]];
					
				$prem = 1;
				$indice = 1;
					
				$toutDiagnosticNbVal = array_count_values($toutDiagnosticService[$diffService[$i]]);
				$tabDiffLibelleDiagnostic = $diffLibelleDiagnostic[$diffService[$i]];
					
				for($j=0 ; $j<count($tabDiffLibelleDiagnostic) ; $j++){
			
					if($prem == 1){
						
						$this->Ln(5.4);
						$this->SetFillColor(220,220,220);
						$this->SetDrawColor(205,193,197);
						$this->SetTextColor(0,0,0);
						$this->AddFont('zap','','zapfdingbats.php');
						$this->SetFont('zap','',13);
						$this->Cell(5,7,'b','BT',0,'L',1);
							
						$this->AddFont('timesb','','timesb.php');
						$this->AddFont('timesi','','timesi.php');
						$this->AddFont('times','','times.php');
							
						$this->SetFont('times','',12.5);
						$this->Cell(178,7,iconv ('UTF-8' , 'windows-1252', $diffService[$i])." (nombre = ".$toutServiceNbVal[$diffService[$i]].")",'BT',0,'L',1);
							
						$this->Ln(8);
						$this->SetFillColor(249,249,249);
						$this->SetDrawColor(220,220,220);
							
						$prem++;
							
					}
					
					
					$this->SetFont('timesi','',11.3);
					$this->Cell(10,7,$indice++.'.','BT',0,'C');
					$this->SetFont('times','',11.3);
					$this->Cell(142,7,iconv ('UTF-8' , 'windows-1252', $tabDiffLibelleDiagnostic[$j]) ,'BT',0,'L',1);
					$this->SetFont('times','',13.3);
					$this->Cell(31,7,$toutDiagnosticNbVal[$tabDiffLibelleDiagnostic[$j]].' ','BT',0,'R',1);
					$this->Ln(7);
				}
					
			}
			
			$this->Ln(6);
			$this->SetDrawColor(205,193,197);
			$this->SetFillColor(220,220,220);
			$this->SetFont('timesi','',11.3);
			$this->Cell(135,7,'','',0,'C');
			$this->SetFont('times','',11.3);
			$this->Cell(17,7,'TOTAL','BT',0,'L',1);
			$this->SetFont('times','',13.3);
			$this->Cell(31,7,$totatlDesInterventions.' ','BT',0,'R',1);
			
		}else{
			echo  "<div align='center' style='font-size: 30px; font-family: times new roman;'> Aucune information à afficher </div>"; exit();
		}
		
		
	}
	
	//IMPRESSION DES INFOS STATISTIQUES
	//IMPRESSION DES INFOS STATISTIQUES
	function ImpressionInfosStatistiques()
	{
		$this->AddPage();
		$this->EnTetePage();
		$this->CorpsDocument();
	}

}

?>
