<?php

namespace Personnel\Model;

use Zend\Db\TableGateway\TableGateway;

class LogistiqueTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getLogistique($id_personne)
	{
		$id_personne  = (int) $id_personne;
		$rowset = $this->tableGateway->select(array('id_employe' => $id_personne));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	
	public function saveLogistique(Personnel $personnel, $id_personnel, $id_employe)
	{
		$today = (new \DateTime ( 'now' ))->format ( 'Y-m-d H:i:s' );
		
 		$data = array(
 				'id_employe' => $id_personnel,
 				'matricule' => $personnel->matricule_logistique,
 				'grade' => $personnel->grade_logistique,
 				'domaine' => $personnel->domaine_logistique,
 				'autres' => $personnel->autres_logistique,
 				'id_personne' => $id_employe,
 				'date_enregistrement' => $today,
 		);
 		
 		$id_personne = (int)$personnel->id_personne;
 		if($id_personne == 0){
 			$this->tableGateway->insert($data);
 		} else {
 			if($this->getLogistique($id_personne)) {
 				$data = array_splice($data, 0, -1); //Pour enlever la date d'enregistrement
 				$this->tableGateway->update($data, array('id_employe' => $id_personne));
 			} else {
 				if($personnel->matricule_logistique){
 					$this->tableGateway->insert($data);
 				}
 			}
 		}
	}
	
	public function deleteLogistique($id_personne){
		$id_personne = (int) $id_personne;
	
		if ($this->getLogistique($id_personne)) {
			$this->tableGateway->delete( array('id_employe' => $id_personne));
		} else {
			return null;
		}
	}
}