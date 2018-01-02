<?php

namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;


class AdmissionBlocTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getListeAdmissionBloc(){
		return $this->tableGateway->select()->toArray();
	}
	
	public function addAdmissionBloc($donnees){
		$this->tableGateway->insert($donnees);
		return $this->tableGateway->getLastInsertValue();
	}
	
}