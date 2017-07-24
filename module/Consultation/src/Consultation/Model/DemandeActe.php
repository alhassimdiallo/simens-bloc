<?php
namespace Consultation\Model;

class DemandeActe{

	public $idDemande;
	public $dateDemande;
	public $noteDemande;
	public $idCons;
	public $idActe;
	public $appliquer;
	public $responsable;
	
	public function exchangeArray($data) {
 			$this->idDemande = (! empty ( $data ['idDemande'] )) ? $data ['idDemande'] : null;
 			$this->dateDemande = (! empty ( $data ['dateDemande'] )) ? $data ['dateDemande'] : null;
 			$this->noteDemande = (! empty ( $data ['noteDemande'] )) ? $data ['noteDemande'] : null;
 			$this->idCons = (! empty ( $data ['idCons'] )) ? $data ['idCons'] : null;
 			$this->idActe = (! empty ( $data ['idActe'] )) ? $data ['idActe'] : null;
 			$this->appliquer = (! empty ( $data ['appliquer'] )) ? $data ['appliquer'] : null;
 			$this->responsable = (! empty ( $data ['responsable'] )) ? $data ['responsable'] : null;
	}
}