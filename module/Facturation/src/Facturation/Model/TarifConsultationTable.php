<?php
namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class TarifConsultationTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getActe($id) {
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( array (
				'ID_TARIF_CONSULTATION' => $id
		) );
		$row =  $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	
	public function fetchService()
	{
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql($adapter);
		$select = $sql->select('tarif_consultation');
		$select->columns(array('ID_TARIF_CONSULTATION', 'LIBELLE'));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['ID_TARIF_CONSULTATION']] = $data['LIBELLE'];
		}
		return $options;
	}

	public function listeService(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('s'=>'service'));
		$select->columns(array('ID_SERVICE','NOM'));
		$select->where(array('DOMAINE' => 'MEDECINE'));
		$select->order('ID_SERVICE ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		
		$options = array("");
		foreach ($result as $data) {
			$options[$data['ID_SERVICE']] = $data['NOM'];
		}
		return $options;
	}
	
	public function listeMedecins(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('e'=>'employe'));
		$select->columns(array('Id_personne','id_personne'));
		$select->join(array('p' => 'personne') , 'p.ID_PERSONNE = e.id_personne' , array('Nom' => 'NOM', 'Prenom' => 'PRENOM'));
		$select->join(array('t' => 'type_employe') , 't.id = e.id_type_employe' , array('*'));
		$select->where(array('t.id' => 1));
		$select->order('e.id_personne ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		$options = array();
		foreach ($result as $data) {
			$options[$data['Id_personne']] = $data['Prenom'].' '.$data['Nom'];
		}
		return $options;
	}
	
	public function getServiceMedecin($id_medecin){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('e'=>'employe'));
		$select->columns(array('id_personne'));
		$select->join(array('s' => 'service_employe') , 's.id_employe = e.id_personne' , array('Id_service' => 'id_service'));
		$select->where(array('e.id_personne' => $id_medecin));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->current();
		return $result;
	}
	
	
	public function TarifDuService($id_service){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('s'=>'service'));
		$select->columns(array('*'));
		$select->where(array('ID_SERVICE' => $id_service));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->current();
		return $result;
	}
	
	//LISTE DES SERVICES DANS LESQUELS IL EXISTE DES PATIENTS OPERES 
	public function listeServicePatientsOperes(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('s'=>'service'));
		$select->join(array('se' => 'service_employe') , 'se.id_service = s.ID_SERVICE' , array('*'));
		$select->join(array('pob' => 'protocole_operatoire_bloc') , 'pob.id_employe = se.id_employe' , array('*'));
		$select->columns(array('ID_SERVICE','NOM'));
		$select->where(array('DOMAINE' => 'MEDECINE'));
		$select->order('s.ID_SERVICE ASC');
		$select->group('s.ID_SERVICE');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
	
		$options = array("Tous");
		foreach ($result as $data) {
			$options[$data['ID_SERVICE']] = $data['NOM'];
		}
		return $options;
	}
	
	//LISTE DES DIAGNOSTICS FAISANT L'OBJET D'INTERVENTION DANS L'ENSEMBLE DES SERVICES
	public function listeDiagnosticsPatientsOperes(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('s'=>'service'));
		$select->join(array('se' => 'service_employe') , 'se.id_service = s.ID_SERVICE' , array('*'));
		$select->join(array('pob' => 'protocole_operatoire_bloc') ,'pob.id_employe = se.id_employe' , array('Id_protocole' => 'id_protocole',));
		$select->join(array('ab' => 'admission_bloc') , 'ab.id_admission = pob.id_admission_bloc' , array('Diagnostic' => 'diagnostic'));
		$select->where(array('DOMAINE' => 'MEDECINE'));
		$select->group('ab.diagnostic');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
	
		$options = array("Tous");
		foreach ($result as $data) {
			$options[$data['Diagnostic']] = $data['Diagnostic'];
		}
		return $options;
	}
	
	//LISTE DES DIAGNOSTICS FAISANT L'OBJET D'INTERVENTION DANS UN SERVICE DONNE
	public function listeDiagnosticsPatientsOperesServiceDonne($id_service){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('s'=>'service'));
		$select->join(array('se' => 'service_employe') , 'se.id_service = s.ID_SERVICE' , array('*'));
		$select->join(array('pob' => 'protocole_operatoire_bloc') ,'pob.id_employe = se.id_employe' , array('Id_protocole' => 'id_protocole',));
		$select->join(array('ab' => 'admission_bloc') , 'ab.id_admission = pob.id_admission_bloc' , array('Diagnostic' => 'diagnostic'));
		$select->where(array('s.ID_SERVICE' => $id_service));
		$select->group('ab.diagnostic');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
	
		$options = array();
		foreach ($result as $data) {
			$options[] = $data['Diagnostic'];
		}
		return $options;
	}
	
	
	//LISTE DES DIAGNOSTICS FAISANT L'OBJET D'INTERVENTION DANS TOUS LES SERVICES 
	public function listeDiagnosticsPatientsOperesTousServices(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('s'=>'service'));
		$select->join(array('se' => 'service_employe') , 'se.id_service = s.ID_SERVICE' , array('*'));
		$select->join(array('pob' => 'protocole_operatoire_bloc') ,'pob.id_employe = se.id_employe' , array('Id_protocole' => 'id_protocole',));
		$select->join(array('ab' => 'admission_bloc') , 'ab.id_admission = pob.id_admission_bloc' , array('Diagnostic' => 'diagnostic'));
		$select->group('ab.diagnostic');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
	
		$options = array();
		foreach ($result as $data) {
			$options[] = $data['Diagnostic'];
		}
		return $options;
	}
	
	
}