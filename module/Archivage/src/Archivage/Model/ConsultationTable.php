<?php
namespace Archivage\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class ConsultationTable {

	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getConsult($id){
		$id = (String) $id;
		$rowset = $this->tableGateway->select ( array (
				'ID_CONS' => $id
		) );
		$row =  $rowset->current ();
 		if (! $row) {
 			throw new \Exception ( "Could not find row $id" );
 		}
		return $row;
	}
	public function getConsultationPatient($id_pat){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns( array( '*' ));
		$select->from( array( 'c' => 'consultation' ));
		$select->join( array('e1' => 'employe'), 'e1.id_personne = c.ID_MEDECIN' , array());
		$select->join( array('p1' => 'personne'), 'e1.id_personne = p1.ID_PERSONNE' , array('*'));
		$select->join( array('s' => 'service'), 's.ID_SERVICE = c.ID_SERVICE' , array('nomService' => 'NOM', 'domaineService' => 'DOMAINE'));

		//On affiche toutes les consultations sauf celle ouverte
		$where = new Where();
		$where->equalTo('c.ID_PATIENT', $id_pat);
		$select->where($where);
		$select->order('DATEONLY DESC');
		
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		
		return $result;
	}
	
	public function getConsultationPatientSaufActu($id_pat, $id_cons){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns( array( '*' ));
		$select->from( array( 'c' => 'consultation' ));
		$select->join( array('e1' => 'employe'), 'e1.id_personne = c.ID_MEDECIN' , array('*'));
		$select->join( array('p1' => 'personne'), 'e1.id_personne = p1.ID_PERSONNE' , array('*'));
		$select->join( array('s' => 'service'), 's.ID_SERVICE = c.ID_SERVICE' , array('nomService' => 'NOM', 'domaineService' => 'DOMAINE'));
	
		//On affiche toutes les consultations sauf celle ouverte
		$where = new Where();
		$where->equalTo('c.ID_PATIENT', $id_pat);
		$where->notEqualTo('c.ID_CONS', $id_cons);
		$select->where($where);
		$select->order('DATEONLY DESC');
	
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
	
		return $result;
	}
	
	public function getInfosSurveillant($id_personne){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns( array( '*' ));
		$select->from( array('e1' => 'employe'));
		$select->join( array('p1' => 'personne'), 'e1.id_personne = p1.ID_PERSONNE' , array('*'));
	
		$where = new Where();
		$where->equalTo('e1.id_personne', $id_personne);
		$select->where($where);
	
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
	
		return $result->current();
	}
	
	public function updateConsultation($values)
	{
		$donnees = array(
				'POIDS' => $values->get ( "poids" )->getValue (), 
				'TAILLE' => $values->get ( "taille" )->getValue (), 
				'TEMPERATURE' => $values->get ( "temperature" )->getValue (), 
				'PRESSION_ARTERIELLE' => $values->get ( "tensionmaximale" )->getValue ().'/'.$values->get ( "tensionminimale" )->getValue (), 
				'POULS' => $values->get ( "pouls" )->getValue (), 
				'FREQUENCE_RESPIRATOIRE' => $values->get ( "frequence_respiratoire" )->getValue (), 
				'GLYCEMIE_CAPILLAIRE' => $values->get ( "glycemie_capillaire" )->getValue (), 
		);
		$this->tableGateway->update( $donnees, array('ID_CONS'=> $values->get ( "id_cons" )->getValue ()) );
	}
	
	public function validerConsultation($id_cons){
		$donnees = array(
				'CONSPRISE' => 1,
				'ARCHIVAGE' => 1,
		);
		$this->tableGateway->update($donnees, array('ID_CONS'=> $id_cons));
	}
	
	public function validerAdmission($id_admission){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->update('admission')
		->set(array('cons_archive_applique' => 1))
		->where(array('id_admission' => $id_admission));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$stat->execute();
	}
	
	public function addConsultation($values , $IdDuService, $id_medecin){
		$this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();
		
		try {
			
			$dataconsultation = array(
					'ID_CONS'=> $values->get ( "id_cons" )->getValue (), 
					'ID_MEDECIN'=> $id_medecin,
					'ID_PATIENT'=> $values->get ( "id_patient" )->getValue (), 
					'DATE'=> $values->get ( "date_cons" )->getValue (), 
					'POIDS' => $values->get ( "poids" )->getValue (), 
					'TAILLE' => $values->get ( "taille" )->getValue (), 
					'TEMPERATURE' => $values->get ( "temperature" )->getValue (), 
					'PRESSION_ARTERIELLE' => $values->get ( "tensionmaximale" )->getValue ().'/'.$values->get ( "tensionminimale" )->getValue (),
					'POULS' => $values->get ( "pouls" )->getValue (), 
					'FREQUENCE_RESPIRATOIRE' => $values->get ( "frequence_respiratoire" )->getValue (), 
					'GLYCEMIE_CAPILLAIRE' => $values->get ( "glycemie_capillaire" )->getValue (), 
					'DATEONLY' => $values->get ( "date_cons" )->getValue (),
					'CONSPRISE' => 1,
					'ID_SERVICE' => $IdDuService
			);
			
			$this->tableGateway->insert($dataconsultation);

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
	
	public function getInfoPatientMedecin($idcons){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns( array( '*' ));
		$select->from( array( 'c' => 'consultation' ));
		$select->join( array( 
				's' => 'service'
		), 's.ID_SERVICE = c.ID_SERVICE' , array (
				'NomService' => 'NOM',
				'DomaineService' => 'DOMAINE'
		) );
		$select->join( array( 
				'p' => 'patient'
		), 'p.ID_PERSONNE = c.PAT_ID_PERSONNE' , array('*'));
		$select->join( array(
				'm' => 'medecin'
		), 'm.ID_PERSONNE = c.ID_PERSONNE' , array(
				'NomMedecin' => 'NOM', 
				'PrenomMedecin' => 'PRENOM', 
				'AdresseMedecin' => 'ADRESSE',
				'TelephoneMedecin' => 'TELEPHONE'
		));
		$select->where ( array( 'c.ID_CONS' => $idcons));
		
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		
		return $result;
	}
	
	public function addBandelette($bandelettes){
		$values = array();
		if($bandelettes['albumine'] == 1){
			$values[] = array('ID_TYPE_BANDELETTE'=>1, 'ID_CONS'=>$bandelettes['id_cons'], 'CROIX_BANDELETTE'=>(int)$bandelettes['croixalbumine']);
		}
		if($bandelettes['sucre'] == 1){
			$values[] = array('ID_TYPE_BANDELETTE'=>2, 'ID_CONS'=>$bandelettes['id_cons'], 'CROIX_BANDELETTE'=>(int)$bandelettes['croixsucre']);
		}
		if($bandelettes['corpscetonique'] == 1){
			$values[] = array('ID_TYPE_BANDELETTE'=>3, 'ID_CONS'=>$bandelettes['id_cons'], 'CROIX_BANDELETTE'=>(int)$bandelettes['croixcorpscetonique']);
		}
		
		for($i = 0 ; $i < count($values) ; $i++ ){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->insert()
			->into('bandelette')
			->columns(array('ID_TYPE_BANDELETTE', 'ID_CONS', 'CROIX_BANDELETTE'))
			->values($values[$i]);
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$stat->execute();
		}
		
	}
	
	public function getBandelette($id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from('bandelette')
		->columns(array('*'))
		->where(array('id_cons' => $id_cons));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
		
		$donnees = array();
		$donnees['temoin'] = 0;
		foreach ($result as $resultat){
			if($resultat['ID_TYPE_BANDELETTE'] == 1){
				$donnees['albumine'] = 1; //C'est à coché
				$donnees['croixalbumine'] = $resultat['CROIX_BANDELETTE'];
			}
			if($resultat['ID_TYPE_BANDELETTE'] == 2){
				$donnees['sucre'] = 1; //C'est à coché
				$donnees['croixsucre'] = $resultat['CROIX_BANDELETTE'];
			}
			if($resultat['ID_TYPE_BANDELETTE'] == 3){
				$donnees['corpscetonique'] = 1; //C'est à coché
				$donnees['croixcorpscetonique'] = $resultat['CROIX_BANDELETTE'];
			}
			
			//temoin
			$donnees['temoin'] = 1;
		}
		
		return $donnees;
	}
	
	public function deleteBandelette($id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->delete()
		->from('bandelette')
		->where(array('id_cons' => $id_cons));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
	}
	
	public function addTraitementsInstrumentaux($traitement_instrumental){
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->delete()
		->from('traitement_instrumental')
		->where(array('id_cons' => $traitement_instrumental['id_cons']));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
			
		if($traitement_instrumental['endoscopie_interventionnelle'] || $traitement_instrumental['radiologie_interventionnelle'] ||
		$traitement_instrumental['cardiologie_interventionnelle'] || $traitement_instrumental['autres_interventions']){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->insert()
			->into('traitement_instrumental')
			->columns(array('id_cons', 'endoscopie_interventionnelle', 'radiologie_interventionnelle', 'cardiologie_interventionnelle', 'autres_interventions'))
			->values($traitement_instrumental);
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$stat->execute();
		}
	}
	
	public function getTraitementsInstrumentaux($id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from('traitement_instrumental')
		->where(array('id_cons' => $id_cons));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute()->current();
		return $result;
	}
	
	//GESTION DES FICHIER MP3
	//GESTION DES FICHIER MP3
	//GESTION DES FICHIER MP3
	public function insererMp3($titre , $nom, $id_cons, $type){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('fichier_mp3')
		->columns(array('titre', 'nom', 'id_cons', 'type'))
		->values(array('titre' => $titre , 'nom' => $nom, 'id_cons'=>$id_cons, 'type'=>$type));
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		return $stat->execute();
	}
	
	public function getMp3($id_cons, $type){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('f' => 'fichier_mp3'))->columns(array('*'))
		->where(array('id_cons' => $id_cons, 'type' => $type))
		->order('id DESC');
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
		return $result;
	}
	
	public function supprimerMp3($idLigne, $id_cons, $type){
		$liste = $this->getMp3($id_cons, $type);
	
		$i=1;
		foreach ($liste as $list){
			if($i == $idLigne){
				unlink('C:\wamp\www\simens\public\audios\\'.$list['nom']);
	
				$db = $this->tableGateway->getAdapter();
				$sql = new Sql($db);
				$sQuery = $sql->delete()
				->from('fichier_mp3')
				->where(array('id' => $list['id']));
	
				$stat = $sql->prepareStatementForSqlObject($sQuery);
				$stat->execute();
	
				return true;
			}
			$i++;
		}
		return false;
	}
	
	//GESTION DES FICHIERS VIDEOS
	//GESTION DES FICHIERS VIDEOS
	//GESTION DES FICHIERS VIDEOS
	public function insererVideo($titre , $nom, $format, $id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('fichier_video')
		->columns(array('titre', 'nom', 'format', 'id_cons'))
		->values(array('titre' => $titre , 'nom' => $nom, 'format' => $format, 'id_cons'=>$id_cons));
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		return $stat->execute();
	}
	
	public function getVideos($id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('f' => 'fichier_video'))->columns(array('*'))
		->where(array('id_cons' => $id_cons))
		->order('id DESC');
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
		return $result;
	}
	
	public function getVideoWithId($id){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('f' => 'fichier_video'))->columns(array('*'))
		->where(array('id' => $id));
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute()->current();
		return $result;
	}
	
	public function supprimerVideo($id){
	
		$laVideo = $this->getVideoWithId($id);
		$result = unlink('C:\wamp\www\simens\public\videos\\'.$laVideo['nom']);
			
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->delete()->from('fichier_video')->where(array('id' => $id));
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$stat->execute();
			
		return $result;
	}
	
	//GESTION DES EXAMENS DU JOUR LORS D'UNE HOSPITALISATION
	//GESTION DES EXAMENS DU JOUR LORS D'UNE HOSPITALISATION
	public function addConsultationExamenDuJour($codeExamen, $values , $IdDuService , $idMedecin){
		$this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();
		$date = new \DateTime();
		$aujourdhui = $date->format('Y-m-d H:i:s');
		$dateonly = $date->format('Y-m-d');
			
		try {
			$dataconsultation = array(
					'ID_CONS'=> $codeExamen,
					'ID_MEDECIN'=> $idMedecin,
					'ID_PATIENT'=> $values->id_personne,
					'DATE'=> $aujourdhui,
					'POIDS' => $values->poids,
					'TAILLE' => $values->taille,
					'TEMPERATURE' => $values->temperature,
					'PRESSION_ARTERIELLE' => $values->pressionarterielle,
					'POULS' => $values->pouls,
					'FREQUENCE_RESPIRATOIRE' => $values->frequence_respiratoire,
					'GLYCEMIE_CAPILLAIRE' => $values->glycemie_capillaire,
					'DATEONLY' => $dateonly,
					'ID_SERVICE' => $IdDuService
			);
	
			$this->tableGateway->insert($dataconsultation);
	
			$this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();
		} catch (\Exception $e) {
			$this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();
		}
	}
	
	public function addExamenDuJour($id_cons, $id_hosp){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('examen_du_jour')
		->values(array('ID_CONS' => $id_cons, 'ID_HOSP' => $id_hosp));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		$requete->execute();
	}
	
	public function getExamenDuJour($id_hosp){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('e' => 'examen_du_jour'))
		->join(array('c' => 'consultation'), 'c.ID_CONS = e.ID_CONS' , array('*'))
		->join(array('p' => 'personne'), 'p.ID_PERSONNE = c.ID_MEDECIN' , array('NomMedecin' => 'NOM', 'PrenomMedecin' => 'PRENOM'))
		->where(array('ID_HOSP' => $id_hosp))
		->order('DATE DESC');
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute();
	}
	
	public function supprimerExamenDuJour($id_examen_jour){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('e' => 'examen_du_jour'))
		->where(array('ID_EXAMEN_JOUR' => $id_examen_jour));
			
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		$result = $requete->execute()->current();
			
		$db2 = $this->tableGateway->getAdapter();
		$sql2 = new Sql($db2);
		$sQuery2 = $sql2->delete()
		->from('consultation')
		->where(array('ID_CONS' => $result['ID_CONS']));
	
		$requete2 = $sql2->prepareStatementForSqlObject($sQuery2);
		$requete2->execute();
			
		return $result['ID_HOSP'];
	}
	
	public function getExamenDuJourParIdExamenJour($id_examen_jour){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('e' => 'examen_du_jour'))
		->join(array('c' => 'consultation'), 'c.ID_CONS = e.ID_CONS' , array('*'))
		->join(array('p' => 'personne'), 'p.ID_PERSONNE = c.ID_MEDECIN' , array('NomMedecin' => 'NOM', 'PrenomMedecin' => 'PRENOM'))
		->where(array('ID_EXAMEN_JOUR' => $id_examen_jour));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getConsultationExamenJour($id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('c' => 'consultation'))
		->where(array('ID_CONS' => $id_cons));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	
	/*Heure suivante*/
	/*Heure suivante*/
	public function getHeureSuivante($id_sh)
	{
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('heures_soins');
		$select->where(array('id_sh' => $id_sh, 'applique' => 0));
		$select->order(array('date ASC','heure ASC'));
	
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->current();
			
		return $result;
	}
	
	/*Heure precedente*/
	/*Heure precedente*/
	public function getHeurePrecedente($id_sh)
	{
		$today = new \DateTime();
		$date = $today->format ( 'Y-m-d' );
		$heure = $today->format ( 'H:i:s' );
	
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('heures_soins');
		$select->where(array('id_sh' => $id_sh, 'applique' => 0, 'date' => $date, 'heure < ?' => $heure));
		$select->order('heure DESC');
	
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->current();
			
		return $result;
	}
	
	public function getHeuresPourAujourdhui($id_sh)
	{
		$today = new \DateTime();
		$date = $today->format ( 'Y-m-d' );
	
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('heures_soins');
		$select->where(array('id_sh'=>$id_sh, 'date'=>$date));
		$select->order('id_heure ASC');
	
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
			
		$tab = array();
		foreach ($result as $resultat){
			$tab[] = $resultat['heure'];
		}
		return $tab;
	}
	
	public function getToutesHeuresPourAujourdhui($id_sh)
	{
		$today = new \DateTime();
		$date = $today->format ( 'Y-m-d' );
	
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('heures_soins');
		$select->where(array('id_sh' => $id_sh, 'date' => $date));
		$select->order('id_heure ASC');
	
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
			
		return $result;
	}
	
	public function getHeureAppliqueePourAujourdhui($id_sh, $heure)
	{
		$today = new \DateTime();
		$date = $today->format ( 'Y-m-d' );
	
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('heures_soins');
		$select->where(array('id_sh' => $id_sh, 'date' => $date, 'heure' => $heure));
	
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->current();
			
		return $result;
	}
	
	
	
	public function getInfoPatient($id_personne) {
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select()
	    ->from(array('pat' => 'patient'))
	    ->columns( array( '*' ))
	    ->join(array('pers' => 'personne'), 'pers.id_personne = pat.id_personne' , array('*'))
	    ->where(array('pat.ID_PERSONNE' => $id_personne));
	
	    $stat = $sql->prepareStatementForSqlObject($sQuery);
	    $resultat = $stat->execute()->current();
	
	    return $resultat;
	}
	
	public function getPhoto($id) {
	    $donneesPatient =  $this->getInfoPatient( $id );
	
	    $nom = null;
	    if($donneesPatient){$nom = $donneesPatient['PHOTO'];}
	    if ($nom) {
	        return $nom . '.jpg';
	    } else {
	        return 'identite.jpg';
	    }
	}
	
	
	
	
	/**
	 * Recuperation de la liste des medicaments
	 */
	public function listeDeTousLesMedicaments(){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql ( $adapter );
	    $select = $sql->select('consommable');
	    $select->columns(array('ID_MATERIEL','INTITULE'));
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute();
	
	    return $result;
	}
	
	/**
	 * RECUPERER LA FORME DES MEDICAMENTS
	 */
	
	public function formesMedicaments(){
	    $adapter = $this->tableGateway->getAdapter ();
	    $sql = new Sql ( $adapter );
	    $select = $sql->select ();
	    $select->columns( array('*'));
	    $select->from( array( 'forme' => 'forme_medicament' ));
	
	    $stat = $sql->prepareStatementForSqlObject ( $select );
	    $result = $stat->execute ();
	
	    return $result;
	}
	
	/**
	 * RECUPERER LES TYPES DE QUANTITE DES MEDICAMENTS
	 */
	
	public function typeQuantiteMedicaments(){
	    $adapter = $this->tableGateway->getAdapter ();
	    $sql = new Sql ( $adapter );
	    $select = $sql->select ();
	    $select->columns( array('*'));
	    $select->from( array( 'typeQuantite' => 'quantite_medicament' ));
	
	    $stat = $sql->prepareStatementForSqlObject ( $select );
	    $result = $stat->execute ();
	
	    return $result;
	}
	
	
	//Recupere les antecedents médicaux de la personne
	//Recupere les antecedents médicaux de la personne
	public function getAntecedentMedicauxPersonneParIdPatient($id_patient){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('amp'=>'ant_medicaux_personne'));
	    $select->join( array('am' => 'ant_medicaux'), 'am.id = amp.id_ant_medicaux' , array('*'));
	    $select->where(array('amp.id_patient' => $id_patient));
	    return $sql->prepareStatementForSqlObject($select)->execute();
	}
	
	
	//Recupere les antecedents médicaux
	//Recupere les antecedents médicaux
	public function getAntecedentsMedicaux(){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('am'=>'ant_medicaux'));
	    return $sql->prepareStatementForSqlObject($select)->execute();
	}
	
	//Recupere la liste des actes
	//Recupere la liste des actes
	public function getListeDesActes(){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('a'=>'actes'));
	    return $sql->prepareStatementForSqlObject($select)->execute();
	}
	
	/**
	 * Recuperer la liste des actes de la consultation donnée en paramètre
	 */
	public function getDemandeActe($id){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->join( array( 'a' => 'actes' ), 'd.idActe = a.id' , array ( '*' ) );
	    $select->where(array('d.idCons' => $id));
	    $select->order('d.idDemande ASC');
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute();
	
	    return $result;
	}
	
	
	public function getLaListeDesDemandesActesDuPatient($idDemande){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->where(array('d.idDemande' => $idDemande));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute()->current();
	
	    return $this->getDemandeActe($result['idCons']);
	}
	
	
	public function addPaiement($id_employe, $date, $idDemande){
	
	    $this->tableGateway->update(
	
	        array('reglement' => 1, 'dateReglement' => $date, 'responsableReglement' => $id_employe) ,
	        array('idDemande' => $idDemande)
	
	    );
	
	}
	
	
	
	
	/**
	 * Recuperer un acte paye
	 */
	public function getDemandeActePaye($id){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->join( array( 'a' => 'actes' ), 'd.idActe = a.id' , array ( '*' ) );
	    $select->where(array('d.idCons' => $id, 'd.reglement' => 1));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute()->current();
	
	    if($result){
	        return 1;
	    }
	    return 0;
	}
	
	public function getUnActePaye($idDemande){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->where(array('d.idDemande' => $idDemande));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute()->current();
	
	    return $this->getDemandeActePaye($result['idCons']);
	}
	
	
	/**
	 * Recuperer la somme des actes impayes du patient
	 */
	public function getResultSommeActesImpayes($id){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->join( array( 'a' => 'actes' ), 'd.idActe = a.id' , array ( '*' ) );
	    $select->where(array('d.idCons' => $id, 'd.reglement' => 0));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute();
	
	    $somme = 0;
	    foreach ($result as $resultat){
	        $somme += $resultat['tarif'];
	    }
	
	    return $somme;
	}
	
	public function getSommeActesImpayes($idDemande){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->where(array('d.idDemande' => $idDemande));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute()->current();
	
	    return $this->getResultSommeActesImpayes($result['idCons']);
	}
	
	/**
	 * Recuperer le montant total des actes du patient
	 */
	public function getResultMontantTotalActes($id){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->join( array( 'a' => 'actes' ), 'd.idActe = a.id' , array ( '*' ) );
	    $select->where(array('d.idCons' => $id));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute();
	
	    $somme = 0;
	    foreach ($result as $resultat){
	        $somme += $resultat['tarif'];
	    }
	
	    return $somme;
	}
	
	public function getMontantTotalActes($idDemande){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->where(array('d.idDemande' => $idDemande));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute()->current();
	
	    return $this->getResultMontantTotalActes($result['idCons']);
	}
	
	/**
	 * Recuperer la somme des actes impayes du patient
	 */
	public function getResultSommeActesPayes($id){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->join( array( 'a' => 'actes' ), 'd.idActe = a.id' , array ( '*' ) );
	    $select->where(array('d.idCons' => $id, 'd.reglement' => 1));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute();
	
	    $somme = 0;
	    foreach ($result as $resultat){
	        $somme += $resultat['tarif'];
	    }
	
	    return $somme;
	}
	
	public function getSommeActesPayes($idDemande){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->where(array('d.idDemande' => $idDemande));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute()->current();
	
	    return $this->getResultSommeActesPayes($result['idCons']);
	}
	
	
	/**
	 * Recuperer la liste des actes payes
	 */
	public function getDemandeActesPayes($id){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->join( array( 'a' => 'actes' ), 'd.idActe = a.id' , array ( '*' ) );
	    $select->where(array('d.idCons' => $id, 'd.reglement' => 1));
	    $select->order('d.dateDemande ASC');
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute();
	
	    return $result;
	}
	
	
	public function getLaListeActesPayesParLePatient($idDemande){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->where(array('d.idDemande' => $idDemande));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute()->current();
	
	    return $this->getDemandeActesPayes($result['idCons']);
	}
	
	public function getmontantTotalActesPayesParLePatient($idDemande){
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->where(array('d.idDemande' => $idDemande));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute()->current();
	
	    return $this->getResultSommeActesPayes($result['idCons']);
	}
	
	
	public function getInfoPatientPayantActe($idDemande){
	
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array('d'=>'demande_acte'));
	    $select->where(array('d.idDemande' => $idDemande));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $result = $stat->execute()->current();
	
	    $adapter = $this->tableGateway->getAdapter();
	    $sql = new Sql($adapter);
	    $select = $sql->select();
	    $select->columns(array('*'));
	    $select->from(array( 'cons'=>'consultation' ));
	    $select->join(array( 'p'=>'personne' ) , 'cons.ID_PATIENT = p.ID_PERSONNE' , array('*'));
	    $select->where(array('cons.ID_CONS' => $result['idCons'] ));
	
	    $stat = $sql->prepareStatementForSqlObject($select);
	    $resultat = $stat->execute()->current();
	
	    return $resultat;
	}
	
}