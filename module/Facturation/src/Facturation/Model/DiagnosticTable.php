<?php

namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;

class DiagnosticTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}	
	
	public function getListeDiagnostic(){
		return $this->tableGateway->select()->toArray();
	}
	
}