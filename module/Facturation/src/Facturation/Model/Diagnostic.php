<?php
namespace Facturation\Model;

class Diagnostic {
	public $id;
	public $libelle;
	public $date_enregistrement;
	
	public $id_service;
	public $nom_service;

	public function exchangeArray($data) {
		$this->id = (! empty ( $data ['id'] )) ? $data ['id'] : null;
		$this->libelle = (! empty ( $data ['libelle'] )) ? $data ['libelle'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
	
		$this->nom_service = (! empty ( $data ['NOM'] )) ? $data ['NOM'] : null;
		$this->id_service = (! empty ( $data ['ID_SERVICE'] )) ? $data ['ID_SERVICE'] : null;
	}
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
}