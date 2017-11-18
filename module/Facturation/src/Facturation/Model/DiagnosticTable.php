<?php

namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class DiagnosticTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}	
	
	public function getListeDiagnostic(){
		return $this->tableGateway->select()->toArray();
	}
	
	public function getListeDiagnosticDecroissante(){
		return $this->tableGateway->select(function(Select $select){
			$select->order('id DESC');
		})->toArray();
	}
	
	public function getDiagnosticBloc($id_diagnostic){
		return $this->tableGateway->select(array('id' => $id_diagnostic))->current();
	}
	
	public function addListeDiagnosticBloc($tabListeDiagnostic){
		for($i=0 ; $i<count($tabListeDiagnostic) ; $i++){
			$this->tableGateway->insert(array('libelle' => trim($tabListeDiagnostic[$i])));
		}
	}
	
	public function updateDiagnosticBloc($id, $libelle){
		$this->tableGateway->update(array('libelle' => trim($libelle)), array('id' => $id));
	}
	
	public function deleteUnDiagnosticBloc($id){
		return $this->tableGateway->delete(array('id' => $id));
	}
	
	/**
	 * Liste des id diagnostics faisant objet d'une admission
	 */
	public function getListeIdDiagnosticDansAdmission(){

		$listeDiagnostic = $this->tableGateway->select(function(Select $select){
			$select->join(array('adb' => 'admission_diagnostic_bloc'), 'adb.id_diagnostic = id', array('*'));
			$select->group('id_diagnostic');
		})->toArray();
		
		$tabDiagnostic = array();
		for($i=0 ; $i<count($listeDiagnostic) ; $i++){
			$tabDiagnostic[] = $listeDiagnostic[$i]['id'];
		}
		
		return $tabDiagnostic;
	}
	
	/**
	 * Liste des id et libelle diagnostics faisant objet d'une admission
	 */
	public function getListeIdLibelleDiagnosticDansAdmission(){
	
		$listeDiagnostic = $this->tableGateway->select(function(Select $select){
			$select->join(array('adb' => 'admission_diagnostic_bloc'), 'adb.id_diagnostic = id', array('*'));
			$select->group('id_diagnostic');
		})->toArray();
	
		$tabDiagnostic = array(0 => 'Tous');
		for($i=0 ; $i<count($listeDiagnostic) ; $i++){
			$tabDiagnostic[$listeDiagnostic[$i]['id']] = $listeDiagnostic[$i]['libelle'];
		}
	
		return $tabDiagnostic;
	}
	
	/**
	 * Liste des id et libelle diagnostics faisant objet d'une admission
	 */
	public function getListeIdLibelleDiagnosticAdmissionServicesBloc(){
	
		$listeDiagnostic = $this->tableGateway->select(function(Select $select){
			$select->join(array('adb' => 'admission_diagnostic_bloc'), 'adb.id_diagnostic = id', array('*'));
			$select->join(array('ab' => 'admission_bloc'), 'ab.id_admission = adb.id_admission', array('*'));
			$select->join(array('se' => 'service_employe'), 'se.id_employe = ab.id_employe', array('*'));
			$select->join(array('s' => 'service'), 's.ID_SERVICE = se.id_service', array('NOM','ID_SERVICE'));
			$select->order(array('NOM DESC', 'id ASC'));
			$select->group('NOM');
		})->toArray();
	
		
		$tabDiagnostic = array(0 => 'Tous');
		for($i=0 ; $i<count($listeDiagnostic) ; $i++){
			$tabDiagnostic[$listeDiagnostic[$i]['id_service']] = $listeDiagnostic[$i]['nom_service'];
		}
		
		return $tabDiagnostic;
	}
	
	
	
	
	/**
	 * Liste des diagnostics faisant objet d'une admission pour les differents services
	 */
	public function getListeDiagnosticAdmissionServicesBloc(){
	
		$listeDiagnostic = $this->tableGateway->select(function(Select $select){
			$select->join(array('adb' => 'admission_diagnostic_bloc'), 'adb.id_diagnostic = id', array('*'));
			$select->join(array('ab' => 'admission_bloc'), 'ab.id_admission = adb.id_admission', array('*'));
			$select->join(array('se' => 'service_employe'), 'se.id_employe = ab.id_employe', array('*'));
			$select->join(array('s' => 'service'), 's.ID_SERVICE = se.id_service', array('NOM'));
			$select->order(array('NOM DESC', 'id ASC'));
		})->toArray();
	
		return $listeDiagnostic;
	}
	
	/**
	 * Liste des diagnostics faisant objet d'une admission pour un service donné
	 */
	public function getListeDiagnosticAdmissionBlocPourUnService($id_service){
	
		$listeDiagnostic = $this->tableGateway->select(function(Select $select) use ($id_service){
			$select->join(array('adb' => 'admission_diagnostic_bloc'), 'adb.id_diagnostic = id', array('*'));
			$select->join(array('ab' => 'admission_bloc'), 'ab.id_admission = adb.id_admission', array('*'));
			$select->join(array('se' => 'service_employe'), 'se.id_employe = ab.id_employe', array('*'));
			$select->join(array('s' => 'service'), 's.ID_SERVICE = se.id_service', array('NOM'));
			$select->where(array('s.ID_SERVICE' => $id_service));
			$select->order(array('NOM DESC', 'id ASC'));
		})->toArray();
	
		return $listeDiagnostic;
	}
	
	
	/**
	 * Liste des diagnostics faisant l'objet d'une admission pour une période (Date_debut et date_fin) donnée
	 */
    public function getListeDiagnosticAdmissionBlocPourUnePeriode($date_debut, $date_fin){
	
		$listeDiagnostic = $this->tableGateway->select(function(Select $select) use ($date_debut, $date_fin){
			$select->join(array('adb' => 'admission_diagnostic_bloc'), 'adb.id_diagnostic = id', array('*'));
			$select->join(array('ab' => 'admission_bloc'), 'ab.id_admission = adb.id_admission', array('*'));
			$select->join(array('se' => 'service_employe'), 'se.id_employe = ab.id_employe', array('*'));
			$select->join(array('s' => 'service'), 's.ID_SERVICE = se.id_service', array('NOM'));
			$select->where(array('ab.date  >= ?' => $date_debut, 'ab.date <= ?' => $date_fin));
			$select->order(array('NOM DESC', 'id ASC'));
		})->toArray();
	
		return $listeDiagnostic;
	}
	
	
	/**
	 * Liste des diagnostics faisant l'objet d'une admission pour un service et pour une période (Date_debut et date_fin) donnée
	 */
	public function getListeDiagnosticAdmissionBlocPourServicePourUnePeriode($id_service, $date_debut, $date_fin){
	
		$listeDiagnostic = $this->tableGateway->select(function(Select $select) use ($id_service, $date_debut, $date_fin){
			$select->join(array('adb' => 'admission_diagnostic_bloc'), 'adb.id_diagnostic = id', array('*'));
			$select->join(array('ab' => 'admission_bloc'), 'ab.id_admission = adb.id_admission', array('*'));
			$select->join(array('se' => 'service_employe'), 'se.id_employe = ab.id_employe', array('*'));
			$select->join(array('s' => 'service'), 's.ID_SERVICE = se.id_service', array('NOM'));
			$select->where(array('s.ID_SERVICE' => $id_service, 'ab.date  >= ?' => $date_debut, 'ab.date <= ?' => $date_fin));
			$select->order(array('NOM DESC', 'id ASC'));
		})->toArray();
	
		return $listeDiagnostic;
	}
	
	
	/**
	 * Liste des diagnostics faisant l'objet d'une admission pour un diagnostic et pour une période donnée
	 */
	public function getListeDiagnosticAdmissionBlocPourDiagnosticPourUnePeriode($id_diagnostic, $date_debut, $date_fin){
	
		$listeDiagnostic = $this->tableGateway->select(function(Select $select) use ($id_diagnostic, $date_debut, $date_fin){
			$select->join(array('adb' => 'admission_diagnostic_bloc'), 'adb.id_diagnostic = id', array('*'));
			$select->join(array('ab' => 'admission_bloc'), 'ab.id_admission = adb.id_admission', array('*'));
			$select->join(array('se' => 'service_employe'), 'se.id_employe = ab.id_employe', array('*'));
			$select->join(array('s' => 'service'), 's.ID_SERVICE = se.id_service', array('NOM'));
			$select->where(array('adb.id_diagnostic' => $id_diagnostic, 'ab.date  >= ?' => $date_debut, 'ab.date <= ?' => $date_fin));
			$select->order(array('NOM DESC', 'id ASC'));
		})->toArray();
	
		return $listeDiagnostic;
	}
	
	/**
	 * Liste des diagnostics faisant l'objet d'une admission pour un diagnostic donnée
	 */
	public function getListeDiagnosticAdmissionBlocPourDiagnostic($id_diagnostic){
	
		$listeDiagnostic = $this->tableGateway->select(function(Select $select) use ($id_diagnostic){
			$select->join(array('adb' => 'admission_diagnostic_bloc'), 'adb.id_diagnostic = id', array('*'));
			$select->join(array('ab' => 'admission_bloc'), 'ab.id_admission = adb.id_admission', array('*'));
			$select->join(array('se' => 'service_employe'), 'se.id_employe = ab.id_employe', array('*'));
			$select->join(array('s' => 'service'), 's.ID_SERVICE = se.id_service', array('NOM'));
			$select->where(array('adb.id_diagnostic' => $id_diagnostic,));
			$select->order(array('NOM DESC', 'id ASC'));
		})->toArray();
	
		return $listeDiagnostic;
	}
	
	
	/**
	 * Liste des diagnostics faisant l'objet d'une admission pour un diagnostic et pour service et pour une période donnée
	 */
	public function getListeDiagnosticAdmissionBlocPourDiagnosticPourServicePourUnePeriode($id_diagnostic, $id_service, $date_debut, $date_fin){
	
		$listeDiagnostic = $this->tableGateway->select(function(Select $select) use ($id_diagnostic, $id_service, $date_debut, $date_fin){
			$select->join(array('adb' => 'admission_diagnostic_bloc'), 'adb.id_diagnostic = id', array('*'));
			$select->join(array('ab' => 'admission_bloc'), 'ab.id_admission = adb.id_admission', array('*'));
			$select->join(array('se' => 'service_employe'), 'se.id_employe = ab.id_employe', array('*'));
			$select->join(array('s' => 'service'), 's.ID_SERVICE = se.id_service', array('NOM'));
			$select->where(array('adb.id_diagnostic' => $id_diagnostic, 's.ID_SERVICE' => $id_service, 'ab.date  >= ?' => $date_debut, 'ab.date <= ?' => $date_fin));
			$select->order(array('NOM DESC', 'id ASC'));
		})->toArray();
	
		return $listeDiagnostic;
	}
	
	/**
	 * Liste des diagnostics faisant l'objet d'une admission pour un diagnostic et pour service et pour une période donnée
	 */
	public function getListeDiagnosticAdmissionBlocPourDiagnosticPourService($id_diagnostic, $id_service){
	
		$listeDiagnostic = $this->tableGateway->select(function(Select $select) use ($id_diagnostic, $id_service){
			$select->join(array('adb' => 'admission_diagnostic_bloc'), 'adb.id_diagnostic = id', array('*'));
			$select->join(array('ab' => 'admission_bloc'), 'ab.id_admission = adb.id_admission', array('*'));
			$select->join(array('se' => 'service_employe'), 'se.id_employe = ab.id_employe', array('*'));
			$select->join(array('s' => 'service'), 's.ID_SERVICE = se.id_service', array('NOM'));
			$select->where(array('adb.id_diagnostic' => $id_diagnostic, 's.ID_SERVICE' => $id_service));
			$select->order(array('NOM DESC', 'id ASC'));
		})->toArray();
	
		return $listeDiagnostic;
	}
}