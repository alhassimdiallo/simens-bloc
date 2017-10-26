<?php

namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate\In;

class AdmissionTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getPatientsAdmis() {
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->from ( array (
				'p' => 'patient'
		) );
		$select->columns ( array () );
		$select->join(array('pers' => 'personne'), 'pers.ID_PERSONNE = p.ID_PERSONNE', array(
				'Nom' => 'NOM',
				'Prenom' => 'PRENOM',
				'Datenaissance' => 'DATE_NAISSANCE',
				'Sexe' => 'SEXE',
				'Adresse' => 'ADRESSE',
				'Nationalite' => 'NATIONALITE_ACTUELLE',
				'Id' => 'ID_PERSONNE'
		));
		$select->join ( array (
				'a' => 'admission'
		), 'p.ID_PERSONNE = a.id_patient', array (
				'Id_admission' => 'id_admission'
		) );
		$select->join ( array (
				's' => 'service'
		), 's.ID_SERVICE = a.id_service', array (
				'Id_Service' => 'ID_SERVICE',
				'Nomservice' => 'NOM'
		) );
				$select->where ( array (
				'a.date_cons' => $date
		) );
		
		$select->order ( 'id_admission DESC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		return $result;
	}
	
	public function nbAdmission() {
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'admission' );
		$select->columns ( array (
				'id_admission'
		) );
		$select->where ( array (
				'date_cons' => $date
		) );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$nb = $stat->execute ()->count ();
		return $nb;
	}
	
	public function addAdmission($donnees){
		$this->tableGateway->insert($donnees);
	}
	
	public function addAdmissionBloc($donnees){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
			$sQuery = $sql->insert()
			->into('admission_bloc')
			->values($donnees);
			$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function updateAdmissionBloc($donnees){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->update()
		->table('admission_bloc')
		->set( $donnees )
		->where(array('id_admission' => $donnees['id_admission'] ));
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	
	}
	
	/*
	 * Recupérer la liste des patients admis et déjà consultés pour aujourd'hui
	 */
	public function getPatientAdmisCons(){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'consultation' );
		$select->columns ( array (
				'ID_PATIENT'
		) );
		$select->where ( array (
				'DATEONLY' => $date,
		) );
		
		$result = $sql->prepareStatementForSqlObject ( $select )->execute ();
		$tab = array();
		foreach ($result as $res) {
			$tab[] = $res['ID_PATIENT'];
		}
		
		return $tab;
	}
	
	/*
	 * Fonction qui vérifie est ce que le patient n'est pas déja consulté
	 */
	public function verifierPatientConsulter($idPatient, $idService){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'consultation' );
		$select->columns ( array (
				'ID_PATIENT'
		) );
		$select->where ( array (
				'DATEONLY' => $date,
				'ID_SERVICE' => $idService,
				'ID_PATIENT' => $idPatient,
		) );
		
		return $sql->prepareStatementForSqlObject ( $select )->execute ()->current();
	}
	
	public function deleteAdmissionPatient($id, $idPatient, $idService){
		if($this->verifierPatientConsulter($idPatient, $idService)){
		    return 1;
		} else {
			$this->tableGateway->delete(array('id_admission'=> $id));
			return 0;
		}

	}
	
	public function getPatientAdmis($id){
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( array (
				'id_admission' => $id
		) );
		$row =  $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	
	public function getPatientAdmisBloc($idAdmission){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('admission_bloc')
		->where(array('id_admission' => $idAdmission));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	
	public function getProtocoleOperatoireBloc($idAdmission){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('protocole_operatoire_bloc')
		->where(array('id_admission_bloc' => $idAdmission));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getListeProtocoleOperatoireBloc(){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select('protocole_operatoire_bloc')
	    ->group("protocole_operatoire")
	    ->where(array("id_protocole < ?" => 100));
	    
	    $requete = $sql->prepareStatementForSqlObject($sQuery);
	    return $requete->execute();
	}
	
	public function getListeSoinsPostOperatoireBloc(){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select('protocole_operatoire_bloc')
	    ->group("soins_post_operatoire")
	    ->where(array("id_protocole < ?" => 100));
	     
	    $requete = $sql->prepareStatementForSqlObject($sQuery);
	    return $requete->execute();
	}
	
	public function getListeProtocoleOperatoireBloc2(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('protocole_operatoire_bloc')
		->group("protocole_operatoire")
		->where(array("id_protocole < ?" => 50));
		 
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getListeSoinsPostOperatoireBloc2(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('protocole_operatoire_bloc')
		->group("soins_post_operatoire")
		->where(array("id_protocole < ?" => 50));
	
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getListeIndicationPOBloc(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('protocole_operatoire_bloc')
		->group("indication")
		->columns(array('indication'));
		 
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getListeTypeAnesthesiePOBloc(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('protocole_operatoire_bloc')
		->group("type_anesthesie")
		->columns(array('type_anesthesie'));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getLastAdmission() {
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('admission')
		->order('id_admission DESC');
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	//Ajouter la consultation dans la table << consultation >> pour permettre au medecin de pouvoir lui même ajouter les constantes
	//Ajouter la consultation dans la table << consultation >> pour permettre au medecin de pouvoir lui même ajouter les constantes
	public function addConsultation($values , $IdDuService){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
		$dateOnly = $today->format ( 'Y-m-d' );
		
		$db = $this->tableGateway->getAdapter();
		$this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();
		try {
	
			$dataconsultation = array(
					'ID_CONS'=> $values->get ( "id_cons" )->getValue (),
					'ID_PATIENT'=> $values->get ( "id_patient" )->getValue (),
					'DATE'=> $date,
 					'DATEONLY' => $dateOnly,
					'HEURECONS' => $values->get ( "heure_cons" )->getValue (),
					'ID_SERVICE' => $IdDuService
			);
			
			$sql = new Sql($db);
			$sQuery = $sql->insert()
			->into('consultation')
			->values($dataconsultation);
			$sql->prepareStatementForSqlObject($sQuery)->execute();
	
			$this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();
		} catch (\Exception $e) {
			$this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();
		}
	}
	
	public function addConsultationEffective($id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('consultation_effective')
		->values(array('ID_CONS' => $id_cons));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		$requete->execute();
	}
	
	
	public function getCompteRenduAnesthesiqueAvecIdProtocole($idProtocoleOperatoire){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('compte_rendu_anesthesique')
		->where(array('id_protocole_operatoire_bloc' => $idProtocoleOperatoire));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	//Gestion des positions d'installations --- Gestion des positions d'installations 
	//Gestion des positions d'installations --- Gestion des positions d'installations
	public function getCraPositionInstallationAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_position_installation')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraPositionInstallation(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_position_installation');
		 
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraPositionInstallationAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_position_installation')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraPositionInstallationAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
		
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_position_installation')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	
	//Gestion acces veineux --- Gestion acces veineux --- Gestion acces veineux
	//Gestion acces veineux --- Gestion acces veineux --- Gestion acces veineux
	public function getCraAccesVeineuxAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_acces_veineux')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraAccesVeineux(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_acces_veineux');
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraAccesVeineuxAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_acces_veineux')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraAccesVeineuxAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_acces_veineux')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	//Gestion des antibiotiques --- Gestion des antibiotiques --- Gestion des antibiotiques 
	//Gestion des antibiotiques --- Gestion des antibiotiques --- Gestion des antibiotiques
	public function getCraAntibiotiqueAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_antibiotique')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraAntibiotique(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_antibiotique');
		
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraAntibiotiqueAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_antibiotique')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraAntibiotiqueAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_antibiotique')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	//Gestion des pré-remplissages --- Gestion des pré-remplissages --- Gestion des pré-remplissages
	//Gestion des pré-remplissages --- Gestion des pré-remplissages --- Gestion des pré-remplissages
	public function getCraPreRemplissageAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_pre_remplissage')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraPreremplissage(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_pre_remplissage');
		
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraPreremplissageAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_pre_remplissage')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraPreremplissageAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_pre_remplissage')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	//Gestion des monitorrages --- Gestion des monitorrage --- Gestion des monitorrages
	//Gestion des monitorrages --- Gestion des monitorrage --- Gestion des monitorrages
	public function getCraMonitorrageAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_monitorrage')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraMonitorrage(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_monitorrage');
		
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}

	public function getCraMonitorrageAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_monitorrage')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraMonitorrageAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_monitorrage')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	//Gestion des inductions anesthésiques --- Gestion des inductions anesthésiques
	//Gestion des inductions anesthésiques --- Gestion des inductions anesthésiques
	public function getCraInductionAnesthesiqueAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_induction_anesthesique')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraInductionAnesthesique(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_induction_anesthesique');
		
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraInductionAnesthesiqueAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_induction_anesthesique')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraInductionAnesthesiqueAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_induction_anesthesique')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	//Gestion des entretiens anesthésiques --- Gestion des entretiens anesthesiques
	//Gestion des entretiens anesthésiques --- Gestion des entretiens anesthesiques
	public function getCraEntretienAnesthesiqueAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_entretien_anesthesique')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraEntretienAnesthesique(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_entretien_anesthesique');
		
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraEntretienAnesthesiqueAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_entretien_anesthesique')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraEntretienAnesthesiqueAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_entretien_anesthesique')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	//Gestion des Hémodynamique per opératoire --- Gestion des Hémodynamique per opératoire
	//Gestion des Hémodynamique per opératoire --- Gestion des Hémodynamique per opératoire
	public function getCraHemodynamiquePerOperatoireAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_hemodynamique_per_operatoire')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraHemodynamiquePerOperatoire(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_hemodynamique_per_operatoire');
	
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraHemodynamiquePerOperatoireAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_hemodynamique_per_operatoire')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraHemodynamiquePerOperatoireAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_hemodynamique_per_operatoire')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	//Gestion des Réveil Extubation --- Gestion des Réveil Extubation 
	//Gestion des Réveil Extubation --- Gestion des Réveil Extubation
	public function getCraReveilExtubationAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_reveil_extubation')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraReveilExtubation(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_reveil_extubation');
	
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraReveilExtubationAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_reveil_extubation')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraReveilExtubationAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_reveil_extubation')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	//Gestion des Bilan hydrique --- Gestion des Bilan hydrique
	//Gestion des Bilan hydrique --- Gestion des Bilan hydrique
	public function getCraBilanHydriqueAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_bilan_hydrique')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraBilanhydrique(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_bilan_hydrique');
	
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraBilanhydriqueAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_bilan_hydrique')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraBilanhydriqueAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_bilan_hydrique')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	//Gestion des entrées --- Gestion des entrées --- Gestion des entrées
	//Gestion des entrées --- Gestion des entrées --- Gestion des entrées
	public function getCraEntreesAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_entrees')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraEntrees(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_entrees');
	
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraEntreesAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_entrees')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraEntreesAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_entrees')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	//Gestion des sorties --- Gestions des sorties --- Gestion des sorties
	//Gestion des sorties --- Gestions des sorties --- Gestion des sorties
	public function getCraSortiesAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_sorties')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraSorties(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_sorties');
	
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraSortiesAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_sorties')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraSortiesAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_sorties')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	//Gestion des scores cormack --- Gestions des scores cormack --- Gestion des scores cormack
	//Gestion des scores cormack --- Gestions des scores cormack --- Gestion des scores cormack
	public function getCraScoreCormackAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_score_cormack')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraScoreCormack(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_score_cormack');
	
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraScoreCormackAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_score_cormack')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraScoreCormackAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_score_cormack')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	//Gestion des types anesthesie --- Gestions des type anesthesie --- Gestion des type anesthesie
	//Gestion des types anesthesie --- Gestions des type anesthesie --- Gestion des type anesthesie
	public function getCraTypeAnesthesieAvecIdProtocole($id_position_installation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_type_anesthesie')
		->where(array('id' => $id_position_installation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getCraTypeAnesthesie(){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_type_anesthesie');
	
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function getCraTypeAnesthesieAvecDesignation($designation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('cra_type_anesthesie')
		->where(array('designation' => $designation));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function addCraTypeAnesthesieAvecDesignation($designation, $id_employe){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('cra_type_anesthesie')
		->values(array('designation' => $designation, 'id_employe' => $id_employe, 'date_enregistrement' => $date));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function addCompteRenduAnesthesique($donnees){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('compte_rendu_anesthesique')
		->values($donnees);
		return $sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function updateCompteRenduAnesthesique($donnees, $id_protocole){
		if($this->getCompteRenduAnesthesiqueAvecIdProtocole($id_protocole)){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->update()
			->table('compte_rendu_anesthesique')
			->set( $donnees )
			->where(array('id_protocole_operatoire_bloc' => $id_protocole ));
			$sql->prepareStatementForSqlObject($sQuery)->execute();
		}else{
			$donnees['id_protocole_operatoire_bloc'] = $id_protocole;
			
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->insert()
			->into('compte_rendu_anesthesique')
			->values($donnees);
			return $sql->prepareStatementForSqlObject($sQuery)->execute();
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	//CONCERNE LA PARTIE POUR LE BLOC OPERATOIRE
	//CONCERNE LA PARTIE POUR LE BLOC OPERATOIRE
	//CONCERNE LA PARTIE POUR LE BLOC OPERATOIRE
	
	public function addProtocoleOperatoire($donnees){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('protocole_operatoire_bloc')
		->values($donnees);
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}

	public function updateProtocoleOperatoire($donnees, $id_protocole){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->update()
		->table('protocole_operatoire_bloc')
		->set( $donnees )
		->where(array('id_protocole' => $id_protocole ));
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function addImagesProtocole($nomImage, $id_admission, $id_employe){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->insert()
	    ->into('protocole_operatoire_image')
	    ->columns(array('nomImage', 'dateEnregistrement', 'idResultat'))
	    ->values(array('nomImage' => $nomImage,  'id_admission' => $id_admission , 'id_employe' => $id_employe));
	    $stat = $sql->prepareStatementForSqlObject($sQuery);
	    $result = $stat->execute();
	    return $result;
	}
	
	public function getImagesProtocoles($id_admission) {
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select('protocole_operatoire_image')
	    ->order('idImage DESC')
	    ->where(array('id_admission' => $id_admission));
	    
	    return $sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function recupererImageProtocole($id, $idAdmission)
	{
	        
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	     $sQuery = $sql->select('protocole_operatoire_image')
	    ->order('idImage DESC')
	    ->where(array('id_admission' => $idAdmission));

	    $Result = $sql->prepareStatementForSqlObject($sQuery)->execute();
	        
	    $i = 1;
	    $tabIdImage = array();
	    $tabNomImage = array();
	    
	    foreach ($Result as $resultat){
	         $tabIdImage[$i] = $resultat['idImage'];
	         $tabNomImage[$i] = $resultat['nomImage'];
	         $i++;
	    }
	        	
	    return  array('idImage' => $tabIdImage[$id], 'nomImage'=> $tabNomImage[$id]);
	
	}
	
	
	public function supprimerImageProtocole($idImage)
	{
	    $idImage = (int) $idImage;
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->delete('protocole_operatoire_image')
	    ->where(array('idImage' => $idImage));
	    return $sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	
	public function getProtocoleOperatoire($id_admission) 
	{
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select('protocole_operatoire_bloc')
	    ->where(array('id_admission_bloc' => $id_admission));
	     
	    return $sql->prepareStatementForSqlObject($sQuery)->execute()->current();
	}
	
	public function cheminBaseUrl(){
	    $baseUrl = $_SERVER['SCRIPT_FILENAME'];
	    $tabURI  = explode('public', $baseUrl);
	    return $tabURI[0];
	}
	
	public function supprimerImagesSansProtocole($id_admission)
	{
	    if(!$this->getProtocoleOperatoire($id_admission)){
	        
	        //On supprime les images sur le disque
	        //On supprime les images sur le disque
	        $db = $this->tableGateway->getAdapter();
	        $sql = new Sql($db);
	        $sQuery = $sql->select('protocole_operatoire_image')
	        ->order('idImage DESC')
	        ->where(array('id_admission' => $id_admission));
	        
	        $Result = $sql->prepareStatementForSqlObject($sQuery)->execute();
	         
	        foreach ($Result as $resultat){
	            unlink ( $this->cheminBaseUrl().'public/images/protocoles/' . $resultat['nomImage'] . '.jpg' );
	        }
	        
	        
	        //On supprime les images dans la base de données
	        //On supprime les images dans la base de données
	        $db = $this->tableGateway->getAdapter();
	        $sql = new Sql($db);
	        $sQuery = $sql->delete('protocole_operatoire_image')
	        ->where(array('id_admission' => $id_admission));
	        return $sql->prepareStatementForSqlObject($sQuery)->execute();
	    }
	}
	
	//GESTION DES FICHIER MP3 DES PROTOCOLES
	//GESTION DES FICHIER MP3 DES PROTOCOLES
	//GESTION DES FICHIER MP3 DES PROTOCOLES
	public function insererProtocoleMp3($titre , $nom, $id_admission, $id_employe){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->insert()
	    ->into('fichier_mp3_protocole')
	    ->columns(array('titre', 'nom', 'id_admission'))
	    ->values(array('titre' => $titre , 'nom' => $nom, 'id_admission'=>$id_admission, 'id_employe'=>$id_employe));
	
	    return $sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function getProtocoleMp3($id_admission){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select()
	    ->from(array('f' => 'fichier_mp3_protocole'))->columns(array('*'))
	    ->where(array('id_admission' => $id_admission))
	    ->order('id DESC');
	
	    $stat = $sql->prepareStatementForSqlObject($sQuery);
	    $result = $stat->execute();
	    return $result;
	}
	
	public function supprimerProtocoleMp3($id, $id_admission){
	    $liste = $this->getProtocoleMp3($id_admission);
	
	    $i=1;
	    foreach ($liste as $list){
	        if($i == $id){
	            unlink($this->cheminBaseUrl().'public/audios/protocoles/'.$list['nom']);
	
	            $db = $this->tableGateway->getAdapter();
	            $sql = new Sql($db);
	            $sQuery = $sql->delete()
	            ->from('fichier_mp3_protocole')
	            ->where(array('id' => $list['id']));
	
	            $sql->prepareStatementForSqlObject($sQuery)->execute();
	
	            return true;
	        }
	        $i++;
	    }
	    return false;
	}
	
}