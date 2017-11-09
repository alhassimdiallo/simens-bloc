<?php
namespace Facturation\Model;

class Diagnostic {
	public $id;
	public $libelle;
	public $date_enregistrement;

	public function exchangeArray($data) {
		$this->id = (! empty ( $data ['id'] )) ? $data ['id'] : null;
		$this->libelle = (! empty ( $data ['libelle'] )) ? $data ['libelle'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
	}
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
}