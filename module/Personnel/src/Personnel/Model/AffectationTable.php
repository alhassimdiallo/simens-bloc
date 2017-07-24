<?php

namespace Personnel\Model;

use Zend\Db\TableGateway\TableGateway;
use Facturation\View\Helper\DateHelper;
use Zend\Db\Sql\Sql;

class AffectationTable {
	protected $tableGateway;
	protected $conversionDate;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getConversionDate(){
		$this->conversionDate = new DateHelper();
		
		return $this->conversionDate;
	}
	
	public function getAffectation($id_personne)
	{
		$id_personne  = (int) $id_personne;
		$rowset = $this->tableGateway->select(array('id_employe' => $id_personne));
		$row = $rowset->current();
		if (!$row) {
			$row = null;
		}
		return $row;
	}
	
	public function modifierServiceEmploye($id_employe, $id_service){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		
		$donnees = array( 'id_service' => $id_service );
		
		$sQuery = $sql->update()
		->table('service_employe')
		->set( $donnees )->where(array('id_employe' => $id_employe ));

		$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function insererServiceEmploye($id_employe, $id_service){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		
		$donnees = array(
				'id_employe' => $id_employe,
				'id_service' => $id_service,
		);
		
		$sQuery = $sql->insert() ->into('service_employe') ->values( $donnees );
		
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function saveAffectation(Personnel $personnel, $id_personnel, $id_employe)
	{
		$today = (new \DateTime ( 'now' ))->format ( 'Y-m-d H:i:s' );
		$this->getConversionDate();
		
		$date_debut = $personnel->date_debut;
		if($date_debut){ $date_debut = $this->conversionDate->convertDateInAnglais($date_debut); } else { $date_debut = null; }
		
		$date_fin = $personnel->date_fin;
		if($date_fin){ $date_fin = $this->conversionDate->convertDateInAnglais($date_fin); } else { $date_fin = null; }
		
 		$data = array(
 				'id_employe' => $id_personnel,
 				'id_service' => $personnel->service_accueil,
 				'date_debut' => $date_debut,
 				'date_fin' => $date_fin,
 				'numero_os' => $personnel->numero_os,
 				'id_personne' => $id_employe,
 				'date_enregistrement' => $today,
 		);
 		
 		$id_personne = (int)$personnel->id_personne;
 		if($id_personne == 0){
 			$this->tableGateway->insert($data);
 			$this->insererServiceEmploye($id_personnel, $personnel->service_accueil);
 		} else {
 			if($this->getAffectation($id_personne)) {
 				$data = array_splice($data, 0, -1); //Pour enlever la date d'enregistrement
 				$this->tableGateway->update($data, array('id_employe' => $id_personne));
 				$this->modifierServiceEmploye($id_personnel, $personnel->service_accueil);
 			}
 		}
	}
	
	public function deleteAffectation($id_personne){
		$id_personne = (int) $id_personne;
	
		if ($this->getAffectation($id_personne)) {
			$this->tableGateway->delete( array('id_employe' => $id_personne));
		} else {
			return null;
		}
	}
	
	/*
	 * Recuperer le service ou l'agent est affecte
	 */
	public function getServiceAgentAffecter($id_personne){
		$id_personne = (int) $id_personne;
		
		$row = $this->getAffectation($id_personne);
		
		if ($row) {
			return $row->service_accueil;
		} else {
			return null;
		}
	}
}