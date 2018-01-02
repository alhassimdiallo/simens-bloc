<?php
namespace Facturation\Model;

class AdmissionDiagnosticBloc {
	public $id_admission;
	public $id_diagnostic;
	public $precision_diagnostic;
	
	public function exchangeArray($data) {
		$this->id_admission = (! empty ( $data ['id_admission'] )) ? $data ['id_admission'] : null;
		$this->id_diagnostic = (! empty ( $data ['id_diagnostic'] )) ? $data ['id_diagnostic'] : null;
		$this->precision_diagnostic = (! empty ( $data ['precision_diagnostic'] )) ? $data ['precision_diagnostic'] : null;
	}
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
}