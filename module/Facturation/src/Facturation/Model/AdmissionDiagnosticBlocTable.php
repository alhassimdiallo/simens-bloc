<?php

namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;


class AdmissionDiagnosticBlocTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getListeAdmissionDiagnosticBloc(){
		return $this->tableGateway->select()->toArray();
	}
	
	public function addAdmissionDiagnosticBloc($donnees){
		for($i=0 ; $i<count($donnees) ; $i++){
			$this->tableGateway->insert($donnees[$i]);
		}
	}
	
	public function getAdmissionDiagnosticBloc($id_admission){
		return $this->tableGateway->select(array('id_admission' => $id_admission))->toArray();
	}
	
	public function updateAdmissionDiagnosticBloc($donnees, $id_admission){
		$this->tableGateway->delete(array('id_admission' => $id_admission));
		$this->addAdmissionDiagnosticBloc($donnees);
	}
	
}