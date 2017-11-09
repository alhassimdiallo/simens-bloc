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
	
}