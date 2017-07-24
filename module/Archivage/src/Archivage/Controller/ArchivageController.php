<?php

namespace Archivage\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Consultation\Model\Consultation;
use Zend\Json\Json;
use Facturation\View\Helper\DateHelper;
use Consultation\Form\LibererPatientForm;
use Zend\Form\View\Helper\FormRow;
use Zend\Form\View\Helper\FormTextarea;
use Zend\Form\View\Helper\FormHidden;
use Consultation\Form\SoinmodificationForm;
use Zend\Form\View\Helper\FormText;
use Zend\Form\View\Helper\FormSelect;
use Archivage\Form\PatientForm;
use Archivage\Form\AdmissionForm;
use Archivage\Form\ConsultationForm;
use Archivage\Form\HospitaliserForm;
use Archivage;
use Archivage\Form\SoinForm;
use Archivage\Form\AppliquerSoinForm;
use Archivage\Form\AppliquerExamenForm;
use Zend\Form\View\Helper\FormRadio;
use Archivage\Form\VpaForm;

class ArchivageController extends AbstractActionController {
	protected $controlDate;
	protected $patientTable;
	protected $consultationTable;
	protected $motifAdmissionTable;
	protected $rvPatientConsTable;
	protected $serviceTable;
	protected $hopitalTable;
	protected $transfererPatientServiceTable;
	protected $consommableTable;
	protected $donneesExamensPhysiquesTable;
	protected $diagnosticsTable;
	protected $ordonnanceTable;
	protected $demandeVisitePreanesthesiqueTable;
	protected $notesExamensMorphologiquesTable;
	protected $demandeExamensTable;
	protected $ordonConsommableTable;
	protected $antecedantPersonnelTable;
	protected $antecedantsFamiliauxTable;
	protected $demandeHospitalisationTable;

	protected $soinhospitalisationTable;
	protected $soinsTable;
	protected $hospitalisationTable;
	protected $hospitalisationlitTable;
	protected $litTable;
	protected $salleTable;
	protected $batimentTable;
	protected $soinhospitalisation4Table;
	protected $resultatVpaTable;
	
	public function getPatientTable() {
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Archivage\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function getConsultationTable() {
		if (! $this->consultationTable) {
			$sm = $this->getServiceLocator ();
			$this->consultationTable = $sm->get ( 'Archivage\Model\ConsultationTable' );
		}
		return $this->consultationTable;
	}
	public function getMotifAdmissionTable() {
		if (! $this->motifAdmissionTable) {
			$sm = $this->getServiceLocator ();
			$this->motifAdmissionTable = $sm->get ( 'Consultation\Model\MotifAdmissionTable' );
		}
		return $this->motifAdmissionTable;
	}
	public function getRvPatientConsTable() {
		if (! $this->rvPatientConsTable) {
			$sm = $this->getServiceLocator ();
			$this->rvPatientConsTable = $sm->get ( 'Consultation\Model\RvPatientConsTable' );
		}
		return $this->rvPatientConsTable;
	}
	public function getServiceTable() {
		if (! $this->serviceTable) {
			$sm = $this->getServiceLocator ();
			$this->serviceTable = $sm->get ( 'Archivage\Model\ServiceTable' );
		}
		return $this->serviceTable;
	}
	public function getHopitalTable() {
		if (! $this->hopitalTable) {
			$sm = $this->getServiceLocator ();
			$this->hopitalTable = $sm->get ( 'Personnel\Model\HopitalTable' );
		}
		return $this->hopitalTable;
	}
	public function getTransfererPatientServiceTable() {
		if (! $this->transfererPatientServiceTable) {
			$sm = $this->getServiceLocator ();
			$this->transfererPatientServiceTable = $sm->get ( 'Archivage\Model\TransfererPatientServiceTable' );
		}
		return $this->transfererPatientServiceTable;
	}
	public function getConsommableTable() {
		if (! $this->consommableTable) {
			$sm = $this->getServiceLocator ();
			$this->consommableTable = $sm->get ( 'Pharmacie\Model\ConsommableTable' );
		}
		return $this->consommableTable;
	}
	public function getDonneesExamensPhysiquesTable() {
		if (! $this->donneesExamensPhysiquesTable) {
			$sm = $this->getServiceLocator ();
			$this->donneesExamensPhysiquesTable = $sm->get ( 'Consultation\Model\DonneesExamensPhysiquesTable' );
		}
		return $this->donneesExamensPhysiquesTable;
	}
	public function getDiagnosticsTable() {
		if (! $this->diagnosticsTable) {
			$sm = $this->getServiceLocator ();
			$this->diagnosticsTable = $sm->get ( 'Consultation\Model\DiagnosticsTable' );
		}
		return $this->diagnosticsTable;
	}
	public function getOrdonnanceTable() {
		if (! $this->ordonnanceTable) {
			$sm = $this->getServiceLocator ();
			$this->ordonnanceTable = $sm->get ( 'Consultation\Model\OrdonnanceTable' );
		}
		return $this->ordonnanceTable;
	}
	public function getDemandeVisitePreanesthesiqueTable() {
		if (! $this->demandeVisitePreanesthesiqueTable) {
			$sm = $this->getServiceLocator ();
			$this->demandeVisitePreanesthesiqueTable = $sm->get ( 'Consultation\Model\DemandeVisitePreanesthesiqueTable' );
		}
		return $this->demandeVisitePreanesthesiqueTable;
	}
	public function getNotesExamensMorphologiquesTable() {
		if (! $this->notesExamensMorphologiquesTable) {
			$sm = $this->getServiceLocator ();
			$this->notesExamensMorphologiquesTable = $sm->get ( 'Consultation\Model\NotesExamensMorphologiquesTable' );
		}
		return $this->notesExamensMorphologiquesTable;
	}
	public function demandeExamensTable() {
		if (! $this->demandeExamensTable) {
			$sm = $this->getServiceLocator ();
			$this->demandeExamensTable = $sm->get ( 'Consultation\Model\DemandeTable' );
		}
		return $this->demandeExamensTable;
	}
	public function getOrdonConsommableTable() {
		if (! $this->ordonConsommableTable) {
			$sm = $this->getServiceLocator ();
			$this->ordonConsommableTable = $sm->get ( 'Consultation\Model\OrdonConsommableTable' );
		}
		return $this->ordonConsommableTable;
	}
	public function getAntecedantPersonnelTable() {
		if (! $this->antecedantPersonnelTable) {
			$sm = $this->getServiceLocator ();
			$this->antecedantPersonnelTable = $sm->get ( 'Consultation\Model\AntecedentPersonnelTable' );
		}
		return $this->antecedantPersonnelTable;
	}
	
	public function getAntecedantsFamiliauxTable() {
		if (! $this->antecedantsFamiliauxTable) {
			$sm = $this->getServiceLocator ();
			$this->antecedantsFamiliauxTable = $sm->get ( 'Consultation\Model\AntecedentsFamiliauxTable' );
		}
		return $this->antecedantsFamiliauxTable;
	}
	
	public function getDemandeHospitalisationTable() {
		if (! $this->demandeHospitalisationTable) {
			$sm = $this->getServiceLocator ();
			$this->demandeHospitalisationTable = $sm->get ( 'Archivage\Model\DemandehospitalisationTable' );
		}
		return $this->demandeHospitalisationTable;
	}
	
	/*POUR LA GESTION DES HOSPITALISATIONS*/
	public function getSoinHospitalisationTable() {
		if (! $this->soinhospitalisationTable) {
			$sm = $this->getServiceLocator ();
			$this->soinhospitalisationTable = $sm->get ( 'Consultation\Model\SoinhospitalisationTable' );
		}
		return $this->soinhospitalisationTable;
	}
	
	public function getSoinsTable() {
		if (! $this->soinsTable) {
			$sm = $this->getServiceLocator ();
			$this->soinsTable = $sm->get ( 'Consultation\Model\SoinsTable' );
		}
		return $this->soinsTable;
	}
	
	public function getHospitalisationTable() {
		if (! $this->hospitalisationTable) {
			$sm = $this->getServiceLocator ();
			$this->hospitalisationTable = $sm->get ( 'Archivage\Model\HospitalisationTable' );
		}
		return $this->hospitalisationTable;
	}
	
	public function getHospitalisationlitTable() {
		if (! $this->hospitalisationlitTable) {
			$sm = $this->getServiceLocator ();
			$this->hospitalisationlitTable = $sm->get ( 'Archivage\Model\HospitalisationlitTable' );
		}
		return $this->hospitalisationlitTable;
	}
	
	public function getLitTable() {
		if (! $this->litTable) {
			$sm = $this->getServiceLocator ();
			$this->litTable = $sm->get ( 'Archivage\Model\LitTable' );
		}
		return $this->litTable;
	}
	
	public function getSalleTable() {
		if (! $this->salleTable) {
			$sm = $this->getServiceLocator ();
			$this->salleTable = $sm->get ( 'Archivage\Model\SalleTable' );
		}
		return $this->salleTable;
	}
	
	public function getBatimentTable() {
		if (! $this->batimentTable) {
			$sm = $this->getServiceLocator ();
			$this->batimentTable = $sm->get ( 'Archivage\Model\BatimentTable' );
		}
		return $this->batimentTable;
	}
	
	public function getResultatVpa() {
		if (! $this->resultatVpaTable) {
			$sm = $this->getServiceLocator ();
			$this->resultatVpaTable = $sm->get ( 'Archivage\Model\ResultatVisitePreanesthesiqueTable' );
		}
		return $this->resultatVpaTable;
	}
	/**
	 * =========================================================================
	 * =========================================================================
	 * =========================================================================
	 */
	protected $utilisateurTable;
	
	public function getUtilisateurTable(){
		if(!$this->utilisateurTable){
			$sm = $this->getServiceLocator();
			$this->utilisateurTable = $sm->get('Admin\Model\UtilisateursTable');
		}
		return $this->utilisateurTable;
	}
	
	public function user(){
		$uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
		$username = $uAuth->getAuthService()->getIdentity();
		$user = $this->getUtilisateurTable()->getUtilisateursWithUsername($username);
		
		return $user;
	}
	
	/**
	 * =========================================================================
	 * ==================== FACTURATION ----- FACTURATION ======================
	 * =========================================================================
	 */
	protected $tarifConsultationTable;
	protected $admissionTable;
	
	public function getTarifConsultationTable() {
		if (! $this->tarifConsultationTable) {
			$sm = $this->getServiceLocator ();
			$this->tarifConsultationTable = $sm->get ( 'Archivage\Model\TarifConsultationTable' );
		}
		return $this->tarifConsultationTable;
	}
	
    public function getAdmissionTable() {
		if (! $this->admissionTable) {
			$sm = $this->getServiceLocator ();
			$this->admissionTable = $sm->get ( 'Archivage\Model\AdmissionTable' );
		}
		return $this->admissionTable;
	}
	
	/**
	 * =========================================================================
	 * ================== HSOPITALISATION ----- HSOPITALISATION ================
	 * =========================================================================
	 */
	protected $soinhospitalisation3Table;
	
	public function getSoinHospitalisation3Table() {
		if (! $this->soinhospitalisation3Table) {
			$sm = $this->getServiceLocator ();
			$this->soinhospitalisation3Table = $sm->get ( 'Archivage\Model\Soinhospitalisation3Table' );
		}
		return $this->soinhospitalisation3Table;
	}
	
	/**
	 * =========================================================================
	 * ======================== RADIOLOGIE ----- RADIOLOGIE ====================
	 * =========================================================================
	 */
	protected $demandeTable;
	protected $examenTable;
	protected $resultatExamenTable;
	
	public function getDemandeTable() {
		if (! $this->demandeTable) {
			$sm = $this->getServiceLocator ();
			$this->demandeTable = $sm->get ( 'Archivage\Model\DemandeTable' );
		}
		return $this->demandeTable;
	}
	
	public function getExamenTable() {
		if (! $this->examenTable) {
			$sm = $this->getServiceLocator ();
			$this->examenTable = $sm->get ( 'Archivage\Model\ExamenTable' );
		}
		return $this->examenTable;
	}
	
	public function getResultatExamenTable() {
		if (! $this->resultatExamenTable) {
			$sm = $this->getServiceLocator ();
			$this->resultatExamenTable = $sm->get ( 'Archivage\Model\ResultatExamenTable' );
		}
		return $this->resultatExamenTable;
	}
/***
 * *********************************************************************************************************************************
 * *********************************************************************************************************************************
 * *********************************************************************************************************************************
 */	
	
	public function  getDateHelper(){
		$this->controlDate = new DateHelper();
	}
	
	/**
	 * ARCHIVAGE ARCHIVAGE ARCHIVAGE
	 */
	public function consulterAction() {
		$this->layout ()->setTemplate ( 'layout/archivage' );
		
		$user = $this->layout()->user;
		$IdDuService = $user['IdService'];
		
		if($user['role'] == 'archivage'){
		    $lespatients = $this->getPatientTable ()->listePatientsConsParMedecinPourArchiviste();
		}else{
		    $lespatients = $this->getPatientTable ()->listePatientsConsParMedecin ( $IdDuService );
		}
	
		return new ViewModel ( array (
				'donnees' => $lespatients,
		) );
	}
	
	/**
	 * ARCHIVAGE ARCHIVAGE ARCHIVAGE
	 */
	public function consultationAction() {
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$user = $this->layout()->user;
		$IdDuService = $user['IdService'];
		$id_medecin = $user['id_personne'];
		
		$id_admission_patient = $this->params ()->fromQuery ( 'id_admission_patient', 0 );

		$admission_patient = $this->getPatientTable ()->admissionPatient ( $id_admission_patient );
		$id_pat = $admission_patient['id_patient'];
		
		$listeMedicament = $this->getConsommableTable()->listeDeTousLesMedicaments();
		$listeForme = $this->getConsommableTable()->formesMedicaments();
		$listetypeQuantiteMedicament = $this->getConsommableTable()->typeQuantiteMedicaments();
	
		$detailInfoPatient = $this->getPatientTable ()->getInfoPatient ( $id_pat );
	
		// Recuperer la photo du patient
		$image = $this->getPatientTable ()->getPhoto ( $id_pat );
	
		$form = new ConsultationForm ();
	
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		$listeConsultation = $this->getConsultationTable ()->getConsultationPatient($id_pat);
		
		//*** Liste des Hospitalisations
		$listeHospitalisation = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdPatient($id_pat);
	
		// recuperation de la liste des hopitaux
		$hopital = $this->getTransfererPatientServiceTable ()->fetchHopital ();
		$form->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		// RECUPERATION DE L'HOPITAL DU SERVICE
		$transfertPatientHopital = $this->getTransfererPatientServiceTable ()->getHopitalPatientTransfert($IdDuService);
		$idHopital = $transfertPatientHopital['ID_HOPITAL'];
		
		// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
		$serviceHopital = $this->getTransfererPatientServiceTable ()->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
	
		// LISTE DES SERVICES DE L'HOPITAL
		$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
	
		// liste des heures rv
		$heure_rv = array (
				'08:00' => '08:00',
				'09:00' => '09:00',
				'10:00' => '10:00',
				'15:00' => '15:00',
				'16:00' => '16:00'
		);
		$form->get ( 'heure_rv' )->setValueOptions ( $heure_rv );
	
		$id_cons = 'arch_'. $id_pat.'_'.$id_admission_patient;
		$data = array (
				'id_cons' => $id_cons,
				'id_medecin' => $id_medecin,
				'id_patient' => $id_pat,
				'hopital_accueil' => $idHopital,
				'dateonly' =>  $admission_patient['date_cons'],
				'id_facturation' => $id_admission_patient,
		);
		
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		$donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
		$donneesAntecedentsFamiliaux  = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		
		$form->populateValues ( array_merge($data,$donneesAntecedentsPersonnels,$donneesAntecedentsFamiliaux) );
		return array (
				'lesdetails' => $detailInfoPatient,
				'id_cons' => $id_cons,
				'nbMotifs' => 1,
				'image' => $image,
				'form' => $form,
				'dateBasVue' => $admission_patient['date_cons'],
				'liste_med' => $listeMedicament,
				'listeForme' => $listeForme,
				'listetypeQuantiteMedicament'  => $listetypeQuantiteMedicament,
				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				'donneesAntecedentsFamiliaux'  => $donneesAntecedentsFamiliaux,
				'liste' => $listeConsultation,
				'temoin' => 0,
				'listeHospitalisation' => $listeHospitalisation,
		);
	}
	
	/**
	 * ARCHIVAGE ARCHIVAGE ARCHIVAGE
	 */
	public function updateComplementConsultationAction(){
		
		$this->getDateHelper();
		$id_cons = $this->params()->fromPost('id_cons');
		$id_admission = $this->params()->fromPost('id_facturation');
		
		$user = $this->layout()->user;
		$IdDuService = $user['IdService'];
		$id_medecin = $user['id_personne'];
		
		//**********-- MODIFICATION DES CONSTANTES --********
		//**********-- MODIFICATION DES CONSTANTES --********
		//**********-- MODIFICATION DES CONSTANTES --********
		$form = new ConsultationForm ();
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
	
		if($this->params()->fromPost('temoinInterfaceSoumis') == 1) {
			// instancier Consultation
			$this->getConsultationTable ()->addConsultation ( $form, $IdDuService, $id_medecin );
			$this->getConsultationTable ()->addConsultationEffective($id_cons);
		}else if($this->params()->fromPost('temoinInterfaceSoumis') == 2) {
			//mettre a jour la consultation
			$this->getConsultationTable ()->updateConsultation ( $form );
		}
		
		
		// mettre a jour les motifs d'admission
		$this->getMotifAdmissionTable ()->deleteMotifAdmission ( $id_cons );
		$this->getMotifAdmissionTable ()->addMotifAdmission ( $form );
	
		
		
		//Recuperer les donnees sur les bandelettes urinaires
		//Recuperer les donnees sur les bandelettes urinaires
		$bandelettes = array(
				'id_cons' => $id_cons,
				'albumine' => $this->params()->fromPost('albumine'),
				'sucre' => $this->params()->fromPost('sucre'),
				'corpscetonique' => $this->params()->fromPost('corpscetonique'),
				'croixalbumine' => $this->params()->fromPost('croixalbumine'),
				'croixsucre' => $this->params()->fromPost('croixsucre'),
				'croixcorpscetonique' => $this->params()->fromPost('croixcorpscetonique'),
		);
		
		//mettre a jour les bandelettes urinaires
		$this->getConsultationTable ()->deleteBandelette($id_cons);
		$this->getConsultationTable ()->addBandelette($bandelettes);
	
		//POUR LES EXAMENS PHYSIQUES
		//POUR LES EXAMENS PHYSIQUES
		//POUR LES EXAMENS PHYSIQUES
		$info_donnees_examen_physique = array(
				'id_cons' => $id_cons,
				'donnee1' => $this->params()->fromPost('examen_donnee1'),
				'donnee2' => $this->params()->fromPost('examen_donnee2'),
				'donnee3' => $this->params()->fromPost('examen_donnee3'),
				'donnee4' => $this->params()->fromPost('examen_donnee4'),
				'donnee5' => $this->params()->fromPost('examen_donnee5')
		);
		$this->getDonneesExamensPhysiquesTable()->updateExamenPhysique($info_donnees_examen_physique);
	
		//POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
		//POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
		//POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
		$donneesDesAntecedents = array(
				//**=== ANTECEDENTS PERSONNELS
				//**=== ANTECEDENTS PERSONNELS
				//LES HABITUDES DE VIE DU PATIENTS
				/*Alcoolique*/
				'AlcooliqueHV' => $this->params()->fromPost('AlcooliqueHV'),
				'DateDebutAlcooliqueHV' => $this->params()->fromPost('DateDebutAlcooliqueHV'),
				'DateFinAlcooliqueHV' => $this->params()->fromPost('DateFinAlcooliqueHV'),
				/*Fumeur*/
				'FumeurHV' => $this->params()->fromPost('FumeurHV'),
				'DateDebutFumeurHV' => $this->params()->fromPost('DateDebutFumeurHV'),
				'DateFinFumeurHV' => $this->params()->fromPost('DateFinFumeurHV'),
				'nbPaquetFumeurHV' => $this->params()->fromPost('nbPaquetFumeurHV'),
				/*Droguer*/
				'DroguerHV' => $this->params()->fromPost('DroguerHV'),
				'DateDebutDroguerHV' => $this->params()->fromPost('DateDebutDroguerHV'),
				'DateFinDroguerHV' => $this->params()->fromPost('DateFinDroguerHV'),
				 
				//LES ANTECEDENTS MEDICAUX
		'DiabeteAM' => $this->params()->fromPost('DiabeteAM'),
		'htaAM' => $this->params()->fromPost('htaAM'),
		'drepanocytoseAM' => $this->params()->fromPost('drepanocytoseAM'),
		'dislipidemieAM' => $this->params()->fromPost('dislipidemieAM'),
		'asthmeAM' => $this->params()->fromPost('asthmeAM'),
		 
		//GYNECO-OBSTETRIQUE
		/*Menarche*/
		'MenarcheGO' => $this->params()->fromPost('MenarcheGO'),
		'NoteMenarcheGO' => $this->params()->fromPost('NoteMenarcheGO'),
		/*Gestite*/
		'GestiteGO' => $this->params()->fromPost('GestiteGO'),
		'NoteGestiteGO' => $this->params()->fromPost('NoteGestiteGO'),
		/*Parite*/
		'PariteGO' => $this->params()->fromPost('PariteGO'),
		'NotePariteGO' => $this->params()->fromPost('NotePariteGO'),
		/*Cycle*/
		'CycleGO' => $this->params()->fromPost('CycleGO'),
		'DureeCycleGO' => $this->params()->fromPost('DureeCycleGO'),
		'RegulariteCycleGO' => $this->params()->fromPost('RegulariteCycleGO'),
		'DysmenorrheeCycleGO' => $this->params()->fromPost('DysmenorrheeCycleGO'),
		 
		//**=== ANTECEDENTS FAMILIAUX
		//**=== ANTECEDENTS FAMILIAUX
		'DiabeteAF' => $this->params()->fromPost('DiabeteAF'),
		'NoteDiabeteAF' => $this->params()->fromPost('NoteDiabeteAF'),
		'DrepanocytoseAF' => $this->params()->fromPost('DrepanocytoseAF'),
		'NoteDrepanocytoseAF' => $this->params()->fromPost('NoteDrepanocytoseAF'),
		'htaAF' => $this->params()->fromPost('htaAF'),
		'NoteHtaAF' => $this->params()->fromPost('NoteHtaAF'),
		);
		 
		$id_patient = $form->get ( "id_patient" )->getValue ();
		$this->getAntecedantPersonnelTable()->addAntecedentsPersonnels($donneesDesAntecedents, $id_patient, $id_medecin);
		$this->getAntecedantsFamiliauxTable()->addAntecedentsFamiliaux($donneesDesAntecedents, $id_patient, $id_medecin);
		 
		//POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		//POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		//POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES
	
		$info_examen_morphologique = array(
				'id_cons'=> $id_cons,
				'8'  => $this->params()->fromPost('radio_'),
				'9'  => $this->params()->fromPost('ecographie_'),
				'12' => $this->params()->fromPost('irm_'),
				'11' => $this->params()->fromPost('scanner_'),
				'10' => $this->params()->fromPost('fibroscopie_'),
		);
	
		$this->getNotesExamensMorphologiquesTable()->updateNotesExamensMorphologiques($info_examen_morphologique);
	
		//var_dump($form); exit();
		
		//POUR LES DIAGNOSTICS
		//POUR LES DIAGNOSTICS
		//POUR LES DIAGNOSTICS
	
		$info_diagnostics = array(
				'id_cons' => $id_cons,
				'diagnostic1' => $this->params()->fromPost('diagnostic1'),
				'diagnostic2' => $this->params()->fromPost('diagnostic2'),
				'diagnostic3' => $this->params()->fromPost('diagnostic3'),
				'diagnostic4' => $this->params()->fromPost('diagnostic4'),
		);
	
		$this->getDiagnosticsTable()->updateDiagnostics($info_diagnostics);
	
		//POUR LES TRAITEMENTS
		//POUR LES TRAITEMENTS
		//POUR LES TRAITEMENTS
		/**** MEDICAUX ****/
		/**** MEDICAUX ****/
		$dureeTraitement = $this->params()->fromPost('duree_traitement_ord');
		$donnees = array('id_cons' => $id_cons, 'duree_traitement' => $dureeTraitement);
	
		$tab = array();
		$j = 1;
		for($i = 1 ; $i < 10 ; $i++ ){
			if($this->params()->fromPost("medicament_0".$i)){
				$tab[$j++] = $this->getOrdonConsommableTable()->getMedicamentByName($this->params()->fromPost("medicament_0".$i))['ID_MATERIEL'];
				$tab[$j++] = $this->params()->fromPost("forme_".$i);
				$tab[$j++] = $this->params()->fromPost("nb_medicament_".$i);
				$tab[$j++] = $this->params()->fromPost("quantite_".$i);
			}
		}
	
		/*Mettre a jour la duree du traitement de l'ordonnance*/
		$idOrdonnance = $this->getOrdonnanceTable()->updateOrdonnance($tab, $donnees);
	
		/*Mettre a jour les medicaments*/
		$resultat = $this->getOrdonConsommableTable()->updateOrdonConsommable($tab, $idOrdonnance);
	
		/*si aucun médicament n'est ajouté ($resultat = false) on supprime l'ordonnance*/
		if($resultat == false){ $this->getOrdonnanceTable()->deleteOrdonnance($idOrdonnance);}
	
		/**** CHIRURGICAUX ****/
		/**** CHIRURGICAUX ****/
		/**** CHIRURGICAUX ****/
		$infoDemande = array(
				'diagnostic' => $this->params()->fromPost("diagnostic_traitement_chirurgical"),
				'intervention_prevue' => $this->params()->fromPost("intervention_prevue"),
				'observation' => $this->params()->fromPost("observation"),
				'ID_CONS'=>$id_cons
		);
	
		$this->getDemandeVisitePreanesthesiqueTable()->updateDemandeVisitePreanesthesique($infoDemande);
	
		/**** INSTRUMENTAL ****/
		/**** INSTRUMENTAL ****/
		/**** INSTRUMENTAL ****/
		$traitement_instrumental = array(
				'id_cons' => $id_cons,
				'endoscopie_interventionnelle' => $this->params()->fromPost('endoscopieInterventionnelle'),
				'radiologie_interventionnelle' => $this->params()->fromPost('radiologieInterventionnelle'),
				'cardiologie_interventionnelle' => $this->params()->fromPost('cardiologieInterventionnelle'),
				'autres_interventions' => $this->params()->fromPost('autresIntervention'),
		);
		$this->getConsultationTable()->addTraitementsInstrumentaux($traitement_instrumental);
		
		//POUR LES COMPTES RENDU DES TRAITEMENTS
		//POUR LES COMPTES RENDU DES TRAITEMENTS
		  //$note_compte_rendu1 = $this->params()->fromPost('note_compte_rendu_operatoire');
		  //$note_compte_rendu2 = $this->params()->fromPost('note_compte_rendu_operatoire_instrumental');
		
		  //$this->getConsultationTable()->addCompteRenduOperatoire($note_compte_rendu1, 1, $id_cons);
		  //$this->getConsultationTable()->addCompteRenduOperatoire($note_compte_rendu2, 2, $id_cons);
		
		//POUR LES RENDEZ VOUS
		//POUR LES RENDEZ VOUS
		//POUR LES RENDEZ VOUS
		$id_patient = $this->params()->fromPost('id_patient');
		$date_RV_Recu = $this->params()->fromPost('date_rv');
		if($date_RV_Recu){
			$date_RV = $this->controlDate->convertDateInAnglais($date_RV_Recu);
		}
		else{
			$date_RV = $date_RV_Recu;
		}
		$infos_rv = array(
				'ID_CONS' => $id_cons,
				'NOTE'    => $this->params()->fromPost('motif_rv'),
				'HEURE'   => $this->params()->fromPost('heure_rv'),
				'DATE'    => $date_RV,
		);
		$this->getRvPatientConsTable()->updateRendezVous($infos_rv);
	
		//POUR LES TRANSFERT
		//POUR LES TRANSFERT
		//POUR LES TRANSFERT
		$info_transfert = array(
				'ID_SERVICE'      => $this->params()->fromPost('id_service'),
				'ID_MEDECIN' => $this->params()->fromPost('med_id_personne'),
				'MOTIF_TRANSFERT' => $this->params()->fromPost('motif_transfert'),
				'ID_CONS' => $id_cons
		);
		
		$this->getTransfererPatientServiceTable()->updateTransfertPatientService($info_transfert);
		
		//POUR LES HOSPITALISATION
		//POUR LES HOSPITALISATION
		//POUR LES HOSPITALISATION
		$this->getDateHelper();
		$today = new \DateTime ();
		$dateAujourdhui = $today->format ( 'Y-m-d H:i:s' );
		$infoDemandeHospitalisation = array(
				'motif_demande_hospi' => $this->params()->fromPost('motif_hospitalisation'),
				'date_demande_hospi' => $dateAujourdhui,
				'date_fin_prevue_hospi' => $this->controlDate->convertDateInAnglais($this->params()->fromPost('date_fin_hospitalisation_prevue')),
				'id_cons' => $id_cons,
		);
		
		$this->getDemandeHospitalisationTable()->saveDemandehospitalisation($infoDemandeHospitalisation);
		
		//VALIDER EN METTANT '1' DANS CONSPRISE Signifiant que le medecin a consulter le patient
		$this->getConsultationTable ()->validerConsultation ( $id_cons );
		$this->getConsultationTable ()->validerAdmission ( $id_admission );
		
		return $this->redirect ()->toRoute ( 'archivage', array (
				'action' => 'liste-consultation'
		) );
	}
	
	public function listeConsultationAction() {
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$user = $this->layout()->user;
		$IdService = $user['IdService'];
	
		$tab =  $this->getPatientTable ()->listePatientsConsulterDansLeService ( $IdService );
		return new ViewModel ( array (
				'donnees' => $tab
		) );
	}
	
 	public function visualisationConsultationAction() {

 		$this->layout ()->setTemplate ( 'layout/archivage' );
 			
 		$user = $this->layout()->user;
 		$IdDuService = $user['IdService'];
 		$id_medecin = $user['id_personne'];
 		
 		$this->getDateHelper();
 		$id_pat = $this->params()->fromQuery ( 'id_patient', 0 );
 		$id = $this->params()->fromQuery ( 'id_cons' );
 		$id_demande_hospi = $this->params()->fromQuery ( 'id_demande_hospi' );
 			
 		if($id_demande_hospi){
 			return $this->redirect ()->toRoute ( 'consultation', array ('action' => 'visualisation-hospitalisation'),
 					array('query'=>array('id_demande_hospi' => $id_demande_hospi
 					) ) );
 		}
 		
 		$form = new ConsultationForm();
 			
 		$liste = $this->getPatientTable()->getInfoPatient ( $id_pat );
 		$image = $this->getPatientTable()->getPhoto ( $id_pat );
 		
 		//POUR LES CONSTANTES
 		//POUR LES CONSTANTES
 		//POUR LES CONSTANTES
 		$consult = $this->getConsultationTable ()->getConsult ( $id );
 		$pos = strpos($consult->pression_arterielle, '/') ;
 		$tensionmaximale = substr($consult->pression_arterielle, 0, $pos);
 		$tensionminimale = substr($consult->pression_arterielle, $pos+1);
 		
 		$data = array (
 				'id_cons' => $consult->id_cons,
 				'id_medecin' => $consult->id_medecin,
 				'id_patient' => $consult->id_patient,
 				'date_cons' => $consult->date,
 				'poids' => $consult->poids,
 				'taille' => $consult->taille,
 				'temperature' => $consult->temperature,
 				'tensionmaximale' => $tensionmaximale,
				'tensionminimale' => $tensionminimale,
 				'pouls' => $consult->pouls,
 				'frequence_respiratoire' => $consult->frequence_respiratoire,
 				'glycemie_capillaire' => $consult->glycemie_capillaire,
 		);
 			
 		//POUR LES MOTIFS D'ADMISSION
 		//POUR LES MOTIFS D'ADMISSION
 		//POUR LES MOTIFS D'ADMISSION
 		// instancier le motif d'admission et recupï¿½rer l'enregistrement
 		$motif_admission = $this->getMotifAdmissionTable ()->getMotifAdmission ( $id );
 		$nbMotif = $this->getMotifAdmissionTable ()->nbMotifs ( $id );
 			
 		//POUR LES MOTIFS D'ADMISSION
 		$k = 1;
 		foreach ( $motif_admission as $Motifs ) {
 			$data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
 			$k ++;
 		}
 			
 		//POUR LES EXAMEN PHYSIQUES
 		//POUR LES EXAMEN PHYSIQUES
 		//POUR LES EXAMEN PHYSIQUES
 		$examen_physique = $this->getDonneesExamensPhysiquesTable()->getExamensPhysiques($id);
 			
 		//POUR LES EXAMEN PHYSIQUES
 		$kPhysique = 1;
 		foreach ($examen_physique as $Examen) {
 			$data['examen_donnee'.$kPhysique] = $Examen['libelle_examen'];
 			$kPhysique++;
 		}
 			
 		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
 		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
 		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
 		$listeConsultation = $this->getConsultationTable ()->getConsultationPatientSaufActu($id_pat, $id);
 		
 		//Recuperer les informations sur le surveillant de service pour les consultations qui diffèrent des consultations prises lors des archives 
 		$tabInfoSurv = array();
 		foreach ($listeConsultation as $listeCons){
 			if($listeCons['ID_SURVEILLANT']){
 				$tabInfoSurv [$listeCons['ID_CONS']] = $this->getConsultationTable ()->getInfosSurveillant($listeCons['ID_SURVEILLANT'])['PRENOM'].' '.$this->getConsultationTable ()->getInfosSurveillant($listeCons['ID_SURVEILLANT'])['NOM'];
 			}else{
 				$tabInfoSurv [$listeCons['ID_CONS']] = '_________'; 
 			}
 		}
 		//var_dump($tabInfoSurv); exit();
 		
 		$listeConsultation = $this->getConsultationTable ()->getConsultationPatientSaufActu($id_pat, $id);
 		
 		//*** Liste des Hospitalisations
 		$listeHospitalisation = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdPatient($id_pat);
 			
 		//POUR LES EXAMENS COMPLEMENTAIRES
 		//POUR LES EXAMENS COMPLEMENTAIRES
 		//POUR LES EXAMENS COMPLEMENTAIRES
 		// DEMANDES DES EXAMENS COMPLEMENTAIRES
 		$listeDemandesMorphologiques = $this->demandeExamensTable()->getDemandeExamensMorphologiques($id);
 		$listeDemandesBiologiques = $this->demandeExamensTable()->getDemandeExamensBiologiques($id);
 			
 		////RESULTATS DES EXAMENS BIOLOGIQUES DEJA EFFECTUES ET ENVOYER PAR LE BIOLOGISTE
 		$listeDemandesBiologiquesEffectuerEnvoyer = $this->demandeExamensTable()->getDemandeExamensBiologiquesEffectuesEnvoyer($id);
 		$listeDemandesBiologiquesEffectuer = $this->demandeExamensTable()->getDemandeExamensBiologiquesEffectues($id);
 			
 		$tableauResultatsExamensBio = array(
 				'temoinGSan' => 0,
 				'temoinHSan' => 0,
 				'temoinBHep' => 0,
 				'temoinBRen' => 0,
 				'temoinBHem' => 0,
 				'temoinBInf' => 0,
 		);
 		
 		foreach ($listeDemandesBiologiquesEffectuerEnvoyer as $listeExamenBioEffectues){
			if($listeExamenBioEffectues['idExamen'] == 1){ 
				$data['groupe_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
				$tableauResultatsExamensBio['groupe_sanguin_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
				$tableauResultatsExamensBio['groupe_sanguin_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
				$tableauResultatsExamensBio['groupe_sanguin_conclusion'] = $listeExamenBioEffectues['conclusion'];
				$tableauResultatsExamensBio['temoinGSan'] = 1;
			}
			if($listeExamenBioEffectues['idExamen'] == 2){ 
				$data['hemogramme_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
				$tableauResultatsExamensBio['hemogramme_sanguin_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
				$tableauResultatsExamensBio['hemogramme_sanguin_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
				$tableauResultatsExamensBio['hemogramme_sanguin_conclusion'] = $listeExamenBioEffectues['conclusion'];
				$tableauResultatsExamensBio['temoinHSan'] = 1;
			}
			if($listeExamenBioEffectues['idExamen'] == 3){ 
				$data['bilan_hepatique'] =  $listeExamenBioEffectues['noteResultat'];
				$tableauResultatsExamensBio['bilan_hepatique_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
				$tableauResultatsExamensBio['bilan_hepatique_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
				$tableauResultatsExamensBio['bilan_hepatique_conclusion'] = $listeExamenBioEffectues['conclusion'];
				$tableauResultatsExamensBio['temoinBHep'] = 1;
			}
			if($listeExamenBioEffectues['idExamen'] == 4){ 
				$data['bilan_renal'] =  $listeExamenBioEffectues['noteResultat'];
				$tableauResultatsExamensBio['bilan_renal_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
				$tableauResultatsExamensBio['bilan_renal_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
				$tableauResultatsExamensBio['bilan_renal_conclusion'] = $listeExamenBioEffectues['conclusion'];
				$tableauResultatsExamensBio['temoinBRen'] = 1;
			}
			if($listeExamenBioEffectues['idExamen'] == 5){ 
				$data['bilan_hemolyse'] =  $listeExamenBioEffectues['noteResultat'];
				$tableauResultatsExamensBio['bilan_hemolyse_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
				$tableauResultatsExamensBio['bilan_hemolyse_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
				$tableauResultatsExamensBio['bilan_hemolyse_conclusion'] = $listeExamenBioEffectues['conclusion'];
				$tableauResultatsExamensBio['temoinBHem'] = 1;
			}
			if($listeExamenBioEffectues['idExamen'] == 6){
				$data['bilan_inflammatoire'] =  $listeExamenBioEffectues['noteResultat'];
				$tableauResultatsExamensBio['bilan_inflammatoire_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
				$tableauResultatsExamensBio['bilan_inflammatoire_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
				$tableauResultatsExamensBio['bilan_inflammatoire_conclusion'] = $listeExamenBioEffectues['conclusion'];
				$tableauResultatsExamensBio['temoinBInf'] = 1;
			}
		}
 			
 		//var_dump($data); exit();
 		
 		////RESULTATS DES EXAMENS MORPHOLOGIQUE
 		$examen_morphologique = $this->getNotesExamensMorphologiquesTable()->getNotesExamensMorphologiques($id);
 			
 		$data['radio'] = $examen_morphologique['radio'];
 		$data['ecographie'] = $examen_morphologique['ecographie'];
 		$data['fibrocospie'] = $examen_morphologique['fibroscopie'];
 		$data['scanner'] = $examen_morphologique['scanner'];
 		$data['irm'] = $examen_morphologique['irm'];
 			
 		////RESULTATS DES EXAMENS MORPHOLOGIQUES DEJA EFFECTUES ET ENVOYER PAR LE BIOLOGISTE
 		$listeDemandesMorphologiquesEffectuer = $this->demandeExamensTable()->getDemandeExamensMorphologiquesEffectues($id);
 		
 		//var_dump($listeDemandesBiologiques->current()); exit();
 		
 		//DIAGNOSTICS
 		//DIAGNOSTICS
 		//DIAGNOSTICS
 		$infoDiagnostics = $this->getDiagnosticsTable()->getDiagnostics($id);
 		// POUR LES DIAGNOSTICS
 		$k = 1;
 		foreach ($infoDiagnostics as $diagnos){
 			$data['diagnostic'.$k] = $diagnos['libelle_diagnostics'];
 			$k++;
 		}
 			
 		//TRAITEMENT (Ordonnance) *********************************************************
 		//TRAITEMENT (Ordonnance) *********************************************************
 		//TRAITEMENT (Ordonnance) *********************************************************
 			
 		//POUR LES MEDICAMENTS
 		//POUR LES MEDICAMENTS
 		//POUR LES MEDICAMENTS
 		// INSTANCIATION DES MEDICAMENTS de l'ordonnance
 		$listeMedicament = $this->getPatientTable()->listeDeTousLesMedicaments();
 		$listeForme = $this->getPatientTable()->formesMedicaments();
 		$listetypeQuantiteMedicament = $this->getPatientTable()->typeQuantiteMedicaments();
 			
 		// INSTANTIATION DE L'ORDONNANCE
 		$infoOrdonnance = $this->getOrdonnanceTable()->getOrdonnance($id);
 			
 		if($infoOrdonnance) {
 			$idOrdonnance = $infoOrdonnance->id_document;
 			$duree_traitement = $infoOrdonnance->duree_traitement;
 			//LISTE DES MEDICAMENTS PRESCRITS
 			$listeMedicamentsPrescrits = $this->getOrdonnanceTable()->getMedicamentsParIdOrdonnance($idOrdonnance);
 			$nbMedPrescrit = $listeMedicamentsPrescrits->count();
 		}else{
 			$nbMedPrescrit = null;
 			$listeMedicamentsPrescrits =null;
 			$duree_traitement = null;
 		}
 			
 		//POUR LA DEMANDE PRE-ANESTHESIQUE
 		//POUR LA DEMANDE PRE-ANESTHESIQUE
 		//POUR LA DEMANDE PRE-ANESTHESIQUE
 		$donneesDemandeVPA = $this->getDemandeVisitePreanesthesiqueTable()->getDemandeVisitePreanesthesique($id);
 			
 		$resultatVpa = null;
 		if($donneesDemandeVPA) {
 			$data['diagnostic_traitement_chirurgical'] = $donneesDemandeVPA['DIAGNOSTIC'];
 			$data['observation'] = $donneesDemandeVPA['OBSERVATION'];
 			$data['intervention_prevue'] = $donneesDemandeVPA['INTERVENTION_PREVUE'];
 		
 			$resultatVpa = $this->getResultatVpa()->getResultatVpa($donneesDemandeVPA['idVpa']);
 		}
 			
 		/**** INSTRUMENTAL ****/
 		/**** INSTRUMENTAL ****/
 		/**** INSTRUMENTAL ****/
 		$traitement_instrumental = $this->getConsultationTable()->getTraitementsInstrumentaux($id);
 		$data['endoscopieInterventionnelle'] = $traitement_instrumental['endoscopie_interventionnelle'];
 		$data['radiologieInterventionnelle'] = $traitement_instrumental['radiologie_interventionnelle'];
 		$data['cardiologieInterventionnelle'] = $traitement_instrumental['cardiologie_interventionnelle'];
 		$data['autresIntervention'] = $traitement_instrumental['autres_interventions'];
 		
 		//POUR LE TRANSFERT
 		//POUR LE TRANSFERT
 		//POUR LE TRANSFERT
 		// INSTANCIATION DU TRANSFERT
 		// RECUPERATION DE LA LISTE DES HOPITAUX
 		$hopital = $this->getTransfererPatientServiceTable ()->fetchHopital ();
 			
 		//LISTE DES HOPITAUX
 		$form->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
 		// RECUPERATION DU SERVICE OU EST TRANSFERE LE PATIENT
 		$transfertPatientService = $this->getTransfererPatientServiceTable ()->getServicePatientTransfert($id);
 			
 		if( $transfertPatientService ){
 			$idService = $transfertPatientService['ID_SERVICE'];
 			// RECUPERATION DE L'HOPITAL DU SERVICE
 			$transfertPatientHopital = $this->getTransfererPatientServiceTable ()->getHopitalPatientTransfert($idService);
 			$idHopital = $transfertPatientHopital['ID_HOPITAL'];
 			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU IL EST TRANSFERE
 			$serviceHopital = $this->getTransfererPatientServiceTable ()->fetchServiceWithHopital($idHopital);
 		
 			// LISTE DES SERVICES DE L'HOPITAL
 			$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
 		
 			// SELECTION DE L'HOPITAL ET DU SERVICE SUR LES LISTES
 			$data['hopital_accueil'] = $idHopital;
 			$data['service_accueil'] = $idService;
 			$data['motif_transfert'] = $transfertPatientService['MOTIF_TRANSFERT'];
 			$hopitalSelect = 1;
 		}else {
 			$hopitalSelect = 0;
 			// RECUPERATION DE L'HOPITAL DU SERVICE
 			$transfertPatientHopital = $this->getTransfererPatientServiceTable ()->getHopitalPatientTransfert($IdDuService);
 			$idHopital = $transfertPatientHopital['ID_HOPITAL'];
 			$data['hopital_accueil'] = $idHopital;
 			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
 			$serviceHopital = $this->getTransfererPatientServiceTable ()->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
 			// LISTE DES SERVICES DE L'HOPITAL
 			$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
 		}
 			
 		//POUR LE RENDEZ VOUS
 		//POUR LE RENDEZ VOUS
 		//POUR LE RENDEZ VOUS
 		// RECUPERE LE RENDEZ VOUS
 		$leRendezVous = $this->getRvPatientConsTable()->getRendezVous($id);
 		
 		if($leRendezVous) {
 			$data['heure_rv'] = $leRendezVous->heure;
 			$data['date_rv']  = $this->controlDate->convertDate($leRendezVous->date);
 			$data['motif_rv'] = $leRendezVous->note;
 		}
 		// Pour recuper les bandelettes
 		$bandelettes = $this->getConsultationTable ()->getBandelette($id);
 			
 		//RECUPERATION DES ANTECEDENTS
 		//RECUPERATION DES ANTECEDENTS
 		//RECUPERATION DES ANTECEDENTS
 		$donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
 		$donneesAntecedentsFamiliaux = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);
 		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
 		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
 			
 		//POUR LES DEMANDES D'HOSPITALISATION
 		//POUR LES DEMANDES D'HOSPITALISATION
 		//POUR LES DEMANDES D'HOSPITALISATION
 		$donneesHospi = $this->getDemandeHospitalisationTable()->getDemandehospitalisationParIdcons($id);
 		if($donneesHospi){
 			$data['motif_hospitalisation'] = $donneesHospi->motif_demande_hospi;
 			$data['date_fin_hospitalisation_prevue'] = $this->controlDate->convertDate($donneesHospi->date_fin_prevue_hospi);
 		}
 		
 		$form->populateValues ( array_merge($data,$bandelettes,$donneesAntecedentsPersonnels,$donneesAntecedentsFamiliaux) );
 		return array(
 				'id_cons' => $id,
 				'lesdetails' => $liste,
 				'form' => $form,
 				'nbMotifs' => $nbMotif,
 				'image' => $image,
 				'heure_cons' => $consult->heurecons,
 				'liste' => $listeConsultation,
 				'liste_med' => $listeMedicament,
 				'nb_med_prescrit' => $nbMedPrescrit,
 				'liste_med_prescrit' => $listeMedicamentsPrescrits,
 				'duree_traitement' => $duree_traitement,
 				'verifieRV' => $leRendezVous,
 				'listeDemandesMorphologiques' => $listeDemandesMorphologiques,
 				'listeDemandesBiologiques' => $listeDemandesBiologiques,
 				'hopitalSelect' =>$hopitalSelect,
 				'nbDiagnostics'=> $infoDiagnostics->count(),
 				'nbDonneesExamenPhysique' => $kPhysique,
 				'dateonly' => $consult->dateonly,
 				'temoin' => $bandelettes['temoin'],
 				'listeForme' => $listeForme,
 				'listetypeQuantiteMedicament'  => $listetypeQuantiteMedicament,
 				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
 				'donneesAntecedentsFamiliaux'  => $donneesAntecedentsFamiliaux,
 				'listeDemandesBioEff' => $listeDemandesBiologiquesEffectuer->count(),
 				'listeDemandesMorphoEff' => $listeDemandesMorphologiquesEffectuer->count(),
 				'resultatVpa' => $resultatVpa,
 				'listeHospitalisation' => $listeHospitalisation,
 				'tabInfoSurv' => $tabInfoSurv,
 				'tableauResultatsExamensBio' => $tableauResultatsExamensBio,
 		);

 	}
	
	public function visualisationConsultationVueAction(){

	    $this->layout ()->setTemplate ( 'layout/consultation' );
	    
	    $user = $this->layout()->user;
	    $IdDuService = $user['IdService'];
	    $id_medecin = $user['id_personne'];
	    	
	    $this->getDateHelper();
	    $id_pat = $this->params()->fromQuery ( 'id_patient', 0 );
	    $id = $this->params()->fromQuery ( 'id_cons' );
	    $form = new ConsultationForm();
	    
	    $liste = $this->getConsultationTable()->getInfoPatient ( $id_pat );
	    $image = $this->getConsultationTable()->getPhoto ( $id_pat );
	    	
	    	
	    //POUR LES CONSTANTES
	    //POUR LES CONSTANTES
	    //POUR LES CONSTANTES
	    $consult = $this->getConsultationTable ()->getConsult ( $id );
	    $pos = strpos($consult->pression_arterielle, '/') ;
	    $tensionmaximale = substr($consult->pression_arterielle, 0, $pos);
	    $tensionminimale = substr($consult->pression_arterielle, $pos+1);
	    
	    $data = array (
	        'id_cons' => $consult->id_cons,
	        'id_medecin' => $consult->id_medecin,
	        'id_patient' => $consult->id_patient,
	        'date_cons' => $consult->date,
	        'poids' => $consult->poids,
	        'taille' => $consult->taille,
	        'temperature' => $consult->temperature,
	        'tensionmaximale' => $tensionmaximale,
	        'tensionminimale' => $tensionminimale,
	        'pouls' => $consult->pouls,
	        'frequence_respiratoire' => $consult->frequence_respiratoire,
	        'glycemie_capillaire' => $consult->glycemie_capillaire,
	    );
	    
	    //POUR LES MOTIFS D'ADMISSION
	    //POUR LES MOTIFS D'ADMISSION
	    //POUR LES MOTIFS D'ADMISSION
	    // instancier le motif d'admission et recupï¿½rer l'enregistrement
	    $motif_admission = $this->getMotifAdmissionTable ()->getMotifAdmission ( $id );
	    $nbMotif = $this->getMotifAdmissionTable ()->nbMotifs ( $id );
	    
	    //POUR LES MOTIFS D'ADMISSION
	    $k = 1;
	    foreach ( $motif_admission as $Motifs ) {
	        $data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
	        $k ++;
	    }
	    
	    //POUR LES EXAMEN PHYSIQUES
	    //POUR LES EXAMEN PHYSIQUES
	    //POUR LES EXAMEN PHYSIQUES
	    $examen_physique = $this->getDonneesExamensPhysiquesTable()->getExamensPhysiques($id);
	    
	    //POUR LES EXAMEN PHYSIQUES
	    $kPhysique = 1;
	    foreach ($examen_physique as $Examen) {
	        $data['examen_donnee'.$kPhysique] = $Examen['libelle_examen'];
	        $kPhysique++;
	    }
	    
	    // POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
	    // POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
	    // POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
	    //$listeConsultation = $this->getConsultationTable ()->getConsultationPatient($id_pat, $id);
	    
	    $listeConsultation = $this->getConsultationTable ()->getConsultationPatientSaufActu($id_pat, $id);
	    
	    //Recuperer les informations sur le surveillant de service pour les consultations qui diffèrent des consultations prises lors des archives
	    $tabInfoSurv = array();
	    foreach ($listeConsultation as $listeCons){
	        if($listeCons['ID_SURVEILLANT']){
	            $tabInfoSurv [$listeCons['ID_CONS']] = $this->getConsultationTable ()->getInfosSurveillant($listeCons['ID_SURVEILLANT'])['PRENOM'].' '.$this->getConsultationTable ()->getInfosSurveillant($listeCons['ID_SURVEILLANT'])['NOM'];
	        }else{
	            $tabInfoSurv [$listeCons['ID_CONS']] = '_________';
	        }
	    }
	    $listeConsultation = $this->getConsultationTable ()->getConsultationPatientSaufActu($id_pat, $id);
	    
	    //*** Liste des Hospitalisations
	    $listeHospitalisation = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdPatient($id_pat);
	    
	    //POUR LES EXAMENS COMPLEMENTAIRES
	    //POUR LES EXAMENS COMPLEMENTAIRES
	    //POUR LES EXAMENS COMPLEMENTAIRES
	    // DEMANDES DES EXAMENS COMPLEMENTAIRES
	    $listeDemandesMorphologiques = $this->demandeExamensTable()->getDemandeExamensMorphologiques($id);
	    $listeDemandesBiologiques = $this->demandeExamensTable()->getDemandeExamensBiologiques($id);
	    
	    ////RESULTATS DES EXAMENS BIOLOGIQUES DEJA EFFECTUES ET ENVOYER PAR LE BIOLOGISTE
	    $listeDemandesBiologiquesEffectuerEnvoyer = $this->demandeExamensTable()->getDemandeExamensBiologiquesEffectuesEnvoyer($id);
	    $listeDemandesBiologiquesEffectuer = $this->demandeExamensTable()->getDemandeExamensBiologiquesEffectues($id);
	    
	    $tableauResultatsExamensBio = array(
	        'temoinGSan' => 0,
	        'temoinHSan' => 0,
	        'temoinBHep' => 0,
	        'temoinBRen' => 0,
	        'temoinBHem' => 0,
	        'temoinBInf' => 0,
	    );
	    foreach ($listeDemandesBiologiquesEffectuerEnvoyer as $listeExamenBioEffectues){
	        if($listeExamenBioEffectues['idExamen'] == 1){
	            $data['groupe_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
	            $tableauResultatsExamensBio['groupe_sanguin_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
	            $tableauResultatsExamensBio['groupe_sanguin_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
	            $tableauResultatsExamensBio['groupe_sanguin_conclusion'] = $listeExamenBioEffectues['conclusion'];
	            $tableauResultatsExamensBio['temoinGSan'] = 1;
	        }
	        if($listeExamenBioEffectues['idExamen'] == 2){
	            $data['hemogramme_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
	            $tableauResultatsExamensBio['hemogramme_sanguin_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
	            $tableauResultatsExamensBio['hemogramme_sanguin_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
	            $tableauResultatsExamensBio['hemogramme_sanguin_conclusion'] = $listeExamenBioEffectues['conclusion'];
	            $tableauResultatsExamensBio['temoinHSan'] = 1;
	        }
	        if($listeExamenBioEffectues['idExamen'] == 3){
	            $data['bilan_hepatique'] =  $listeExamenBioEffectues['noteResultat'];
	            $tableauResultatsExamensBio['bilan_hepatique_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
	            $tableauResultatsExamensBio['bilan_hepatique_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
	            $tableauResultatsExamensBio['bilan_hepatique_conclusion'] = $listeExamenBioEffectues['conclusion'];
	            $tableauResultatsExamensBio['temoinBHep'] = 1;
	        }
	        if($listeExamenBioEffectues['idExamen'] == 4){
	            $data['bilan_renal'] =  $listeExamenBioEffectues['noteResultat'];
	            $tableauResultatsExamensBio['bilan_renal_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
	            $tableauResultatsExamensBio['bilan_renal_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
	            $tableauResultatsExamensBio['bilan_renal_conclusion'] = $listeExamenBioEffectues['conclusion'];
	            $tableauResultatsExamensBio['temoinBRen'] = 1;
	        }
	        if($listeExamenBioEffectues['idExamen'] == 5){
	            $data['bilan_hemolyse'] =  $listeExamenBioEffectues['noteResultat'];
	            $tableauResultatsExamensBio['bilan_hemolyse_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
	            $tableauResultatsExamensBio['bilan_hemolyse_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
	            $tableauResultatsExamensBio['bilan_hemolyse_conclusion'] = $listeExamenBioEffectues['conclusion'];
	            $tableauResultatsExamensBio['temoinBHem'] = 1;
	        }
	        if($listeExamenBioEffectues['idExamen'] == 6){
	            $data['bilan_inflammatoire'] =  $listeExamenBioEffectues['noteResultat'];
	            $tableauResultatsExamensBio['bilan_inflammatoire_infoInfirmier'] = $this->getConsultationTable()->getInfosSurveillant( $listeExamenBioEffectues['id_personne'] );
	            $tableauResultatsExamensBio['bilan_inflammatoire_date_enregistrement'] = $this->controlDate->convertDateTime($listeExamenBioEffectues['date_enregistrement']);
	            $tableauResultatsExamensBio['bilan_inflammatoire_conclusion'] = $listeExamenBioEffectues['conclusion'];
	            $tableauResultatsExamensBio['temoinBInf'] = 1;
	        }
	    }
	    
	    ////RESULTATS DES EXAMENS MORPHOLOGIQUE
	    $examen_morphologique = $this->getNotesExamensMorphologiquesTable()->getNotesExamensMorphologiques($id);
	    
	    $data['radio'] = $examen_morphologique['radio'];
	    $data['ecographie'] = $examen_morphologique['ecographie'];
	    $data['fibrocospie'] = $examen_morphologique['fibroscopie'];
	    $data['scanner'] = $examen_morphologique['scanner'];
	    $data['irm'] = $examen_morphologique['irm'];
	    
	    ////RESULTATS DES EXAMENS MORPHOLOGIQUES DEJA EFFECTUES ET ENVOYER PAR LE BIOLOGISTE
	    $listeDemandesMorphologiquesEffectuer = $this->demandeExamensTable()->getDemandeExamensMorphologiquesEffectues($id);
	    
	    //DIAGNOSTICS
	    //DIAGNOSTICS
	    //DIAGNOSTICS
	    $infoDiagnostics = $this->getDiagnosticsTable()->getDiagnostics($id);
	    // POUR LES DIAGNOSTICS
	    $k = 1;
	    foreach ($infoDiagnostics as $diagnos){
	        $data['diagnostic'.$k] = $diagnos['libelle_diagnostics'];
	        $k++;
	    }
	    
	    //TRAITEMENT (Ordonnance) *********************************************************
	    //TRAITEMENT (Ordonnance) *********************************************************
	    //TRAITEMENT (Ordonnance) *********************************************************
	    
	    //POUR LES MEDICAMENTS
	    //POUR LES MEDICAMENTS
	    //POUR LES MEDICAMENTS
	    // INSTANCIATION DES MEDICAMENTS de l'ordonnance
	    $listeMedicament = $this->getConsultationTable()->listeDeTousLesMedicaments();
	    $listeForme = $this->getConsultationTable()->formesMedicaments();
	    $listetypeQuantiteMedicament = $this->getConsultationTable()->typeQuantiteMedicaments();
	    
	    // INSTANTIATION DE L'ORDONNANCE
	    $infoOrdonnance = $this->getOrdonnanceTable()->getOrdonnanceNonHospi($id);
	    
	    if($infoOrdonnance) {
	        $idOrdonnance = $infoOrdonnance->id_document;
	        $duree_traitement = $infoOrdonnance->duree_traitement;
	        //LISTE DES MEDICAMENTS PRESCRITS
	        $listeMedicamentsPrescrits = $this->getOrdonnanceTable()->getMedicamentsParIdOrdonnance($idOrdonnance);
	        $nbMedPrescrit = $listeMedicamentsPrescrits->count();
	    }else{
	        $nbMedPrescrit = null;
	        $listeMedicamentsPrescrits =null;
	        $duree_traitement = null;
	    }
	    
	    //POUR LA DEMANDE PRE-ANESTHESIQUE
	    //POUR LA DEMANDE PRE-ANESTHESIQUE
	    //POUR LA DEMANDE PRE-ANESTHESIQUE
	    $donneesDemandeVPA = $this->getDemandeVisitePreanesthesiqueTable()->getDemandeVisitePreanesthesique($id);
	    
	    $resultatVpa = null;
	    if($donneesDemandeVPA) {
	        $data['diagnostic_traitement_chirurgical'] = $donneesDemandeVPA['DIAGNOSTIC'];
	        $data['observation'] = $donneesDemandeVPA['OBSERVATION'];
	        $data['intervention_prevue'] = $donneesDemandeVPA['INTERVENTION_PREVUE'];
	    
	        $resultatVpa = $this->getResultatVpa()->getResultatVpa($donneesDemandeVPA['idVpa']);
	    }
	    
	    /**** INSTRUMENTAL ****/
	    /**** INSTRUMENTAL ****/
	    /**** INSTRUMENTAL ****/
	    $traitement_instrumental = $this->getConsultationTable()->getTraitementsInstrumentaux($id);
	    
	    $data['endoscopieInterventionnelle'] = $traitement_instrumental['endoscopie_interventionnelle'];
	    $data['radiologieInterventionnelle'] = $traitement_instrumental['radiologie_interventionnelle'];
	    $data['cardiologieInterventionnelle'] = $traitement_instrumental['cardiologie_interventionnelle'];
	    $data['autresIntervention'] = $traitement_instrumental['autres_interventions'];
	    
	    //POUR LE TRANSFERT
	    //POUR LE TRANSFERT
	    //POUR LE TRANSFERT
	    // INSTANCIATION DU TRANSFERT
	    // RECUPERATION DE LA LISTE DES HOPITAUX
	    $hopital = $this->getTransfererPatientServiceTable ()->fetchHopital ();
	    
	    //LISTE DES HOPITAUX
	    $form->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
	    // RECUPERATION DU SERVICE OU EST TRANSFERE LE PATIENT
	    $transfertPatientService = $this->getTransfererPatientServiceTable ()->getServicePatientTransfert($id);
	    
	    if( $transfertPatientService ){
	        $idService = $transfertPatientService['ID_SERVICE'];
	        // RECUPERATION DE L'HOPITAL DU SERVICE
	        $transfertPatientHopital = $this->getTransfererPatientServiceTable ()->getHopitalPatientTransfert($idService);
	        $idHopital = $transfertPatientHopital['ID_HOPITAL'];
	        // RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU IL EST TRANSFERE
	        $serviceHopital = $this->getTransfererPatientServiceTable ()->fetchServiceWithHopital($idHopital);
	    
	        // LISTE DES SERVICES DE L'HOPITAL
	        $form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
	    
	        // SELECTION DE L'HOPITAL ET DU SERVICE SUR LES LISTES
	        $data['hopital_accueil'] = $idHopital;
	        $data['service_accueil'] = $idService;
	        $data['motif_transfert'] = $transfertPatientService['MOTIF_TRANSFERT'];
	        $hopitalSelect = 1;
	    }else {
	        $hopitalSelect = 0;
	        // RECUPERATION DE L'HOPITAL DU SERVICE
	        $transfertPatientHopital = $this->getTransfererPatientServiceTable ()->getHopitalPatientTransfert($IdDuService);
	        $idHopital = $transfertPatientHopital['ID_HOPITAL'];
	        $data['hopital_accueil'] = $idHopital;
	        // RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
	        $serviceHopital = $this->getTransfererPatientServiceTable ()->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
	        // LISTE DES SERVICES DE L'HOPITAL
	        $form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
	    }
	    
	    //POUR LE RENDEZ VOUS
	    //POUR LE RENDEZ VOUS
	    //POUR LE RENDEZ VOUS
	    // RECUPERE LE RENDEZ VOUS
	    $leRendezVous = $this->getRvPatientConsTable()->getRendezVous($id);
	    	
	    if($leRendezVous) {
	        $data['heure_rv'] = $leRendezVous->heure;
	        $data['date_rv']  = $this->controlDate->convertDate($leRendezVous->date);
	        $data['motif_rv'] = $leRendezVous->note;
	    }
	    // Pour recuper les bandelettes
	    $bandelettes = $this->getConsultationTable ()->getBandelette($id);
	    
	    //RECUPERATION DES ANTECEDENTS
	    //RECUPERATION DES ANTECEDENTS
	    //RECUPERATION DES ANTECEDENTS
	    $donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
	    $donneesAntecedentsFamiliaux = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);
	    
	    //Recuperer les antecedents medicaux ajouter pour le patient
	    //Recuperer les antecedents medicaux ajouter pour le patient
	    $antMedPat = $this->getConsultationTable()->getAntecedentMedicauxPersonneParIdPatient($id_pat);
	    
	    //Recuperer les antecedents medicaux
	    //Recuperer les antecedents medicaux
	    $listeAntMed = $this->getConsultationTable()->getAntecedentsMedicaux();
	    
	    
	    //Recuperer la liste des actes
	    //Recuperer la liste des actes
	    $listeActes = $this->getConsultationTable()->getListeDesActes();
	    $listeDemandesActes = $this->getConsultationTable()->getDemandeActe($id);
	    
	    //FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
	    //FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
	    
	    //Liste des examens biologiques
	    $listeDesExamensBiologiques = $this->demandeExamensTable()->getDemandeDesExamensBiologiques();
	    //Liste des examens Morphologiques
	    $listeDesExamensMorphologiques = $this->demandeExamensTable()->getDemandeDesExamensMorphologiques();
	    
	    
	    //POUR LES DEMANDES D'HOSPITALISATION
	    //POUR LES DEMANDES D'HOSPITALISATION
	    //POUR LES DEMANDES D'HOSPITALISATION
	    $donneesHospi = $this->getDemandeHospitalisationTable()->getDemandehospitalisationParIdcons($id);
	    if($donneesHospi){
	        $data['motif_hospitalisation'] = $donneesHospi->motif_demande_hospi;
	        $data['date_fin_hospitalisation_prevue'] = $this->controlDate->convertDate($donneesHospi->date_fin_prevue_hospi);
	    }
	    $form->populateValues ( array_merge($data,$bandelettes,$donneesAntecedentsPersonnels,$donneesAntecedentsFamiliaux) );
	    return array(
	        'id_cons' => $id,
	        'lesdetails' => $liste,
	        'form' => $form,
	        'nbMotifs' => $nbMotif,
	        'image' => $image,
	        'heure_cons' => $consult->heurecons,
	        'liste' => $listeConsultation,
	        'liste_med' => $listeMedicament,
	        'nb_med_prescrit' => $nbMedPrescrit,
	        'liste_med_prescrit' => $listeMedicamentsPrescrits,
	        'duree_traitement' => $duree_traitement,
	        'verifieRV' => $leRendezVous,
	        'listeDemandesMorphologiques' => $listeDemandesMorphologiques,
	        'listeDemandesBiologiques' => $listeDemandesBiologiques,
	        'hopitalSelect' =>$hopitalSelect,
	        'nbDiagnostics'=> $infoDiagnostics->count(),
	        'nbDonneesExamenPhysique' => $kPhysique,
	        'dateonly' => $consult->dateonly,
	        'temoin' => $bandelettes['temoin'],
	        'listeForme' => $listeForme,
	        'listetypeQuantiteMedicament'  => $listetypeQuantiteMedicament,
	        'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
	        'donneesAntecedentsFamiliaux'  => $donneesAntecedentsFamiliaux,
	        'listeDemandesBioEff' => $listeDemandesBiologiquesEffectuer->count(),
	        'listeDemandesMorphoEff' => $listeDemandesMorphologiquesEffectuer->count(),
	        'resultatVpa' => $resultatVpa,
	        'listeHospitalisation' => $listeHospitalisation,
	        'tabInfoSurv' => $tabInfoSurv,
	        'tableauResultatsExamensBio' => $tableauResultatsExamensBio,
	        'listeAntMed' => $listeAntMed,
	        'antMedPat' => $antMedPat,
	        'nbAntMedPat' => $antMedPat->count(),
	        'listeDemandesActes' => $listeDemandesActes,
	        'listeActes' => $listeActes,
	        'listeDesExamensBiologiques' => $listeDesExamensBiologiques,
	        'listeDesExamensMorphologiques' => $listeDesExamensMorphologiques,
	    
	    );
	    
	}
	
	public function visualiserConsultationAction(){
	
		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
	
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$this->getDateHelper();
		$id_pat = $this->params()->fromQuery ( 'id_patient', 0 );
		$id = $this->params()->fromQuery ( 'id_cons' );
		$form = new ConsultationForm();
			
		$list = $this->getPatientTable ();
		$liste = $list->getPatient ( $id_pat );
		// Recuperer la photo du patient
		$image = $list->getPhoto ( $id_pat );
			
		//POUR LES CONSTANTES
		//POUR LES CONSTANTES
		//POUR LES CONSTANTES
		$cons = $this->getConsultationTable ();
		$consult = $cons->getConsult ( $id );
	
		$data = array (
				'id_cons' => $consult->id_cons,
				'id_medecin' => $consult->id_personne,
				'id_patient' => $consult->pat_id_personne,
				'date_cons' => $consult->date,
				'poids' => $consult->poids,
				'taille' => $consult->taille,
				'temperature' => $consult->temperature,
				'pressionarterielle' => $consult->pression_arterielle,
				'pouls' => $consult->pouls,
				'frequence_respiratoire' => $consult->frequence_respiratoire,
				'glycemie_capillaire' => $consult->glycemie_capillaire,
		);
	
		//POUR LES MOTIFS D'ADMISSION
		//POUR LES MOTIFS D'ADMISSION
		//POUR LES MOTIFS D'ADMISSION
		// instancier le motif d'admission et recupï¿½rer l'enregistrement
		$motif = $this->getMotifAdmissionTable ();
		$motif_admission = $motif->getMotifAdmission ( $id );
		$nbMotif = $motif->nbMotifs ( $id );
		//POUR LES MOTIFS D'ADMISSION
		$k = 1;
		foreach ( $motif_admission as $Motifs ) {
			$data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
			$k ++;
		}
		//POUR LES EXAMEN PHYSIQUES
		//POUR LES EXAMEN PHYSIQUES
		//POUR LES EXAMEN PHYSIQUES
		//instancier les donnï¿½es de l'examen physique
		$examen = $this->getDonneesExamensPhysiquesTable();
		$examen_physique = $examen->getExamensPhysiques($id);
		//POUR LES EXAMEN PHYSIQUES
		$kPhysique = 1;
		foreach ($examen_physique as $Examen) {
			$data['examen_donnee'.$kPhysique] = $Examen['libelle_examen'];
			$kPhysique++;
		}
	
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		$listeConsultation = $cons->getConsultationPatient($id_pat);
	
		//POUR LES EXAMENS COMPLEMENTAIRES
		//POUR LES EXAMENS COMPLEMENTAIRES
		//POUR LES EXAMENS COMPLEMENTAIRES
		// DEMANDES DES EXAMENS COMPLEMENTAIRES
		$demandeExamen = $this->demandeExamensTable();
		$listeDemandesMorphologiques = $demandeExamen->getDemandeExamensMorphologiques($id);
		$listeDemandesBiologiques = $demandeExamen->getDemandeExamensBiologiques($id);
	
		////RESULTATS DES EXAMENS BIOLOGIQUES DEJA EFFECTUES ET ENVOYER PAR LE BIOLOGISTE
		$listeDemandesBiologiquesEffectuerEnvoyer = $demandeExamen->getDemandeExamensBiologiquesEffectuesEnvoyer($id);
	
		foreach ($listeDemandesBiologiquesEffectuerEnvoyer as $listeExamenBioEffectues){
			if($listeExamenBioEffectues['idExamen'] == 1){
				$data['groupe_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 2){
				$data['hemogramme_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 3){
				$data['bilan_hepatique'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 4){
				$data['bilan_renal'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 5){
				$data['bilan_hemolyse'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 6){
				$data['bilan_inflammatoire'] =  $listeExamenBioEffectues['noteResultat'];
			}
		}
	
		// RESULTATS DES EXAMENS COMPLEMENTAIRES
		$resultatExamenMorphologique = $this->getNotesExamensMorphologiquesTable();
		$examen_morphologique = $resultatExamenMorphologique->getNotesExamensMorphologiques($id);
	
		$data['radio'] = $examen_morphologique['radio'];
		$data['ecographie'] = $examen_morphologique['ecographie'];
		$data['fibrocospie'] = $examen_morphologique['fibroscopie'];
		$data['scanner'] = $examen_morphologique['scanner'];
		$data['irm'] = $examen_morphologique['irm'];
	
		//DIAGNOSTICS
		//DIAGNOSTICS
		//DIAGNOSTICS
		//instancier les donnï¿½es des diagnostics
		$diagnostics = $this->getDiagnosticsTable();
		$infoDiagnostics = $diagnostics->getDiagnostics($id);
		// POUR LES DIAGNOSTICS
		$k = 1;
		foreach ($infoDiagnostics as $diagnos){
			$data['diagnostic'.$k] = $diagnos['libelle_diagnostics'];
			$k++;
		}
	
		//TRAITEMENT (Ordonnance) *********************************************************
		//TRAITEMENT (Ordonnance) *********************************************************
		//TRAITEMENT (Ordonnance) *********************************************************
	
		//POUR LES MEDICAMENTS
		//POUR LES MEDICAMENTS
		//POUR LES MEDICAMENTS
		// INSTANCIATION DES MEDICAMENTS de l'ordonnance
		$consommable = $this->getConsommableTable();
		$listeMedicament = $consommable->listeDeTousLesMedicaments();
		$listeForme = $consommable->formesMedicaments();
		$listetypeQuantiteMedicament = $consommable->typeQuantiteMedicaments();
	
		// INSTANTIATION DE L'ORDONNANCE
		$ordonnance = $this->getOrdonnanceTable();
		$infoOrdonnance = $ordonnance->getOrdonnance($id); //on recupere l'id de l'ordonnance
	
		if($infoOrdonnance) {
			$idOrdonnance = $infoOrdonnance->id_document;
			$duree_traitement = $infoOrdonnance->duree_traitement;
	
			//LISTE DES MEDICAMENTS PRESCRITS
			$listeMedicamentsPrescrits = $ordonnance->getMedicamentsParIdOrdonnance($idOrdonnance);
			$nbMedPrescrit = $listeMedicamentsPrescrits->count();
		}else{
			$nbMedPrescrit = null;
			$listeMedicamentsPrescrits =null;
			$duree_traitement = null;
		}
		//POUR LA DEMANDE PRE-ANESTHESIQUE
		//POUR LA DEMANDE PRE-ANESTHESIQUE
		//POUR LA DEMANDE PRE-ANESTHESIQUE
		$DemandeVPA = $this->getDemandeVisitePreanesthesiqueTable();
		$donneesDemandeVPA = $DemandeVPA->getDemandeVisitePreanesthesique($id);
		$resultatVpa = null;
		if($donneesDemandeVPA) {
			$data['diagnostic_traitement_chirurgical'] = $donneesDemandeVPA['DIAGNOSTIC'];
			$data['observation'] = $donneesDemandeVPA['OBSERVATION'];
			$data['intervention_prevue'] = $donneesDemandeVPA['INTERVENTION_PREVUE'];
			 
			$resultatVpa = $this->getResultatVpa()->getResultatVpa($donneesDemandeVPA['idVpa']);
		}
	
		//POUR LE TRANSFERT
		//POUR LE TRANSFERT
		//POUR LE TRANSFERT
		// INSTANCIATION DU TRANSFERT
		$transferer = $this->getTransfererPatientServiceTable ();
		// RECUPERATION DE LA LISTE DES HOPITAUX
		$hopital = $transferer->fetchHopital ();
		//LISTE DES HOPITAUX
		$form->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		// RECUPERATION DU SERVICE OU EST TRANSFERE LE PATIENT
		$transfertPatientService = $transferer->getServicePatientTransfert($id);
	
		if( $transfertPatientService ){
			$idService = $transfertPatientService['ID_SERVICE'];
			// RECUPERATION DE L'HOPITAL DU SERVICE
			$transfertPatientHopital = $transferer->getHopitalPatientTransfert($idService);
			$idHopital = $transfertPatientHopital['ID_HOPITAL'];
			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU IL EST TRANSFERE
			$serviceHopital = $transferer->fetchServiceWithHopital($idHopital);
	
			// LISTE DES SERVICES DE L'HOPITAL
			$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
	
			// SELECTION DE L'HOPITAL ET DU SERVICE SUR LES LISTES
			$data['hopital_accueil'] = $idHopital;
			$data['service_accueil'] = $idService;
			$data['motif_transfert'] = $transfertPatientService['motif_transfert'];
			$hopitalSelect = 1;
		}else {
			$hopitalSelect = 0;
			// RECUPERATION DE L'HOPITAL DU SERVICE
			$transfertPatientHopital = $transferer->getHopitalPatientTransfert($IdDuService);
			$idHopital = $transfertPatientHopital['ID_HOPITAL'];
			$data['hopital_accueil'] = $idHopital;
			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
			$serviceHopital = $transferer->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
			// LISTE DES SERVICES DE L'HOPITAL
			$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
		}
		//POUR LE RENDEZ VOUS
		//POUR LE RENDEZ VOUS
		//POUR LE RENDEZ VOUS
		// RECUPERE LE RENDEZ VOUS
		$rendezVous = $this->getRvPatientConsTable();
		$leRendezVous = $rendezVous->getRendezVous($id);
	
		if($leRendezVous) {
			$data['heure_rv'] = $leRendezVous->heure;
			$data['date_rv']  = $this->controlDate->convertDate($leRendezVous->date);
			$data['motif_rv'] = $leRendezVous->note;
		}
		// Pour recuper les bandelettes
		$bandelettes = $this->getConsultationTable ()->getBandelette($id);
	
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		$donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
		$donneesAntecedentsFamiliaux = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
	
		$form->populateValues ( array_merge($data,$bandelettes,$donneesAntecedentsPersonnels,$donneesAntecedentsFamiliaux) );
		return array(
				'id_cons' => $id,
				'lesdetails' => $liste,
				'form' => $form,
				'nbMotifs' => $nbMotif,
				'image' => $image,
				'heure_cons' => $consult->heurecons,
				'liste' => $listeConsultation,
				'liste_med' => $listeMedicament,
				'nb_med_prescrit' => $nbMedPrescrit,
				'liste_med_prescrit' => $listeMedicamentsPrescrits,
				'duree_traitement' => $duree_traitement,
				'verifieRV' => $leRendezVous,
				'listeDemandesMorphologiques' => $listeDemandesMorphologiques,
				'listeDemandesBiologiques' => $listeDemandesBiologiques,
				'hopitalSelect' =>$hopitalSelect,
				'nbDiagnostics'=> $infoDiagnostics->count(),
				'nbDonneesExamenPhysique' => $kPhysique,
				'dateonly' => $consult->dateonly,
				'temoin' => $bandelettes['temoin'],
				'listeForme' => $listeForme,
				'listetypeQuantiteMedicament'  => $listetypeQuantiteMedicament,
				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				'donneesAntecedentsFamiliaux'  => $donneesAntecedentsFamiliaux,
				'resultatVpa' => $resultatVpa,
		);
	
	}
	
	//******* Rï¿½cupï¿½rer les services correspondants en cliquant sur un hopital
	public function servicesAction()
	{
		$id=(int)$this->params()->fromPost ('id');
	
		if ($this->getRequest()->isPost()){
			$liste_select = "";
			$services= $this->getServiceTable();
			foreach($services->getServiceHopital($id) as $listeServices){
				$liste_select.= "<option value=".$listeServices['Id_service'].">".$listeServices['Nom_service']."</option>";
			}
				
			$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
			return $this->getResponse ()->setContent(Json::encode ( $liste_select));
		}
	
	}
	
	/***
	 * *********************************************************************************************************************************
	* *********************************************************************************************************************************
	* *********************************************************************************************************************************
	 * *********************************************************************************************************************************
	* *********************************************************************************************************************************
	* *********************************************************************************************************************************
	 * *********************************************************************************************************************************
	* *********************************************************************************************************************************
	* *********************************************************************************************************************************
	 * *********************************************************************************************************************************
	* *********************************************************************************************************************************
	* *********************************************************************************************************************************
	
	*/
	
	//********************************************************
	//********************************************************
	//********************************************************
	public function imagesExamensMorphologiquesAction()
	{
		$id_cons = $this->params()->fromPost( 'id_cons' );
		$ajout = (int)$this->params()->fromPost( 'ajout' );
		$idExamen = (int)$this->params()->fromPost( 'typeExamen' ); /*Le type d'examen*/
		$utilisateur = (int)$this->params()->fromPost( 'utilisateur' , 0); /* 1==radiologue sinon Medecin  */
		
		$user = $this->layout()->user;
		$id_personne = $user['id_personne']; //Identité de l'utilisateur connecté
		
		/***
		 * INSERTION DE LA NOUVELLE IMAGE
		 */
		if($ajout == 1) {
			/***
			 * Enregistrement de l'image
			 * Enregistrement de l'image
			 * Enregistrement de l'image
			*/
			$today = new \DateTime ( 'now' );
			$nomImage = $today->format ( 'dmy_His' );
			if($idExamen == 8) { $nomImage = "radio_".$nomImage;}
			if($idExamen == 9) { $nomImage = "echographie_".$nomImage;}
			if($idExamen == 10) { $nomImage = "irm_".$nomImage;}
			if($idExamen == 11) { $nomImage = "scanner_".$nomImage;}
			if($idExamen == 12) { $nomImage = "fibroscopie_".$nomImage;}
			
			$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
			$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
			
			$typeFichier = substr ( $fileBase64, 5, 5 );
			$formatFichier = substr ($fileBase64, 11, 4 );
			$fileBase64 = substr ( $fileBase64, 23 );
			
			if($utilisateur == 1){
				
				if($fileBase64 && $typeFichier == 'image' && $formatFichier =='jpeg'){
					$img = imagecreatefromstring(base64_decode($fileBase64));
					if($img){
						$resultatAjout = $this->demandeExamensTable()->ajouterImageMorpho($id_cons, $idExamen, $nomImage, $date_enregistrement, $id_personne);
					}
					if($resultatAjout){
						imagejpeg ( $img, 'C:\wamp\www\simens\public\images\images\\' . $nomImage . '.jpg' );
					}
				}
				
			}else {
				
				if($fileBase64 && $typeFichier == 'image' && $formatFichier =='jpeg'){
					$img = imagecreatefromstring(base64_decode($fileBase64));
					if($img){
						$resultatAjout = $this->demandeExamensTable()->ajouterImage($id_cons, $idExamen, $nomImage, $date_enregistrement, $id_personne);
					}
					if($resultatAjout){
						imagejpeg ( $img, 'C:\wamp\www\simens\public\images\images\\' . $nomImage . '.jpg' );
					}
				}
				
			}
			
		}
		
		/**
		 * RECUPERATION DE TOUS LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		 */
		if($utilisateur == 1){
			$result = $this->demandeExamensTable()->resultatExamensMorpho($id_cons);
		}else {
			$result = $this->demandeExamensTable()->resultatExamens($id_cons);
		}

		$radio = false;
		$echographie = false;
		$irm = false;
		$scanner = false;
		$fibroscopie = false;
		
		$html = "";
		$pickaChoose = "";
		
		if($result){
			foreach ($result as $resultat) {
				/**==========================**/
				/**Recuperer les images RADIO**/
				/**==========================**/
				if($resultat['idExamen'] == 8 && $idExamen == 8){
					$radio = true;
					$pickaChoose .=" <li><a href='../images/images/".$resultat['NomImage'].".jpg'><img src='../images/images/".$resultat['NomImage'].".jpg'/></a><span></span></li>";
				} else
				/**================================**/
				/**Recuperer les images ECHOGRAPHIE**/
				/**================================**/
				if($resultat['idExamen'] == 9 && $idExamen == 9){
					$echographie = true;
					$pickaChoose .=" <li><a href='../images/images/".$resultat['NomImage'].".jpg'><img src='../images/images/".$resultat['NomImage'].".jpg'/></a><span></span></li>";
				} else
				/**================================**/
				/**Recuperer les images IRM**/
				/**================================**/
				if($resultat['idExamen'] == 10 && $idExamen == 10){
					$irm = true;
					$pickaChoose .=" <li><a href='../images/images/".$resultat['NomImage'].".jpg'><img src='../images/images/".$resultat['NomImage'].".jpg'/></a><span></span></li>";
				} else
				/**================================**/
				/**Recuperer les images SCANNER**/
				/**================================**/
				if($resultat['idExamen'] == 11 && $idExamen == 11){
					$scanner = true;
					$pickaChoose .=" <li><a href='../images/images/".$resultat['NomImage'].".jpg'><img src='../images/images/".$resultat['NomImage'].".jpg'/></a><span></span></li>";
				} else
				/**================================**/
				/**Recuperer les images FIBROSCOPIE**/
				/**================================**/
				if($resultat['idExamen'] == 12 && $idExamen == 12){
					$fibroscopie = true;
					$pickaChoose .=" <li><a href='../images/images/".$resultat['NomImage'].".jpg'><img src='../images/images/".$resultat['NomImage'].".jpg'/></a><span></span></li>";
				}
			}
		}

		if($radio) {
			$html ="<div id='pika2'>
				    <div class='pikachoose' style='height: 210px;'>
                      <ul id='pikame' class='jcarousel-skin-pika'>";
			$html .=$pickaChoose;
			$html .=" </ul>
                     </div>
				     </div>";

			$html.="<script>
					  $(function(){ $('.imageRadio').toggle(true);});
					  scriptExamenMorpho();
					</script>";
		} else 
			if($echographie) {
				$html ="<div id='pika4'>
				        <div class='pikachoose' style='height: 210px;'>
                          <ul id='pikameEchographie' class='jcarousel-skin-pika'>";
				$html .=$pickaChoose;
				$html .=" </ul>
                         </div>
				         </div>";
			
				$html.="<script>
						  $(function(){ $('.imageEchographie').toggle(true);});
					      scriptEchographieExamenMorpho();
					    </script>";
			} else 
				if($irm) {
					$html ="<div id='pika6'>
				             <div class='pikachoose' style='height: 210px;'>
                              <ul id='pikameIRM' class='jcarousel-skin-pika'>";
					$html .=$pickaChoose;
					$html .=" </ul>
                              </div>
				             </div>";
						
					$html.="<script>
						     $(function(){ $('.imageIRM').toggle(true);});
					         scriptIRMExamenMorpho();
					        </script>";
				} else 
					if($scanner) {
						$html ="<div id='pika8'>
				             <div class='pikachoose' style='height: 210px;'>
                              <ul id='pikameScanner' class='jcarousel-skin-pika'>";
						$html .=$pickaChoose;
						$html .=" </ul>
                              </div>
				             </div>";
					
						$html.="<script>
						     $(function(){ $('.imageScanner').toggle(true);});
					         scriptScannerExamenMorpho();
					        </script>";
					} else 
						if($fibroscopie) {
							$html ="<div id='pika10'>
				             <div class='pikachoose' style='height: 210px;'>
                              <ul id='pikameFibroscopie' class='jcarousel-skin-pika'>";
							$html .=$pickaChoose;
							$html .=" </ul>
                              </div>
				             </div>";
								
							$html.="<script>
						     $(function(){ $('.imageFibroscopie').toggle(true);});
					         scriptFibroscopieExamenMorpho();
					        </script>";
						}
		
						//$html .="<script> $(".$Responsable."); </script>";

		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode ( $html ));
	}
	
	
	//************************************************************************************
	//************************************************************************************
	//************************************************************************************
	public function supprimerImageAction()
	{
		$id_cons = $this->params()->fromPost('id_cons');
		$id = $this->params()->fromPost('id'); //numero de l'image dans le diapo
		$typeExamen = $this->params()->fromPost('typeExamen');

		/**
		 * RECUPERATION DE TOUS LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		 */
		$result = $this->demandeExamensTable()->recupererDonneesExamen($id_cons, $id, $typeExamen);
		/**
		 * SUPPRESSION PHYSIQUE DE L'IMAGE
		 */
		unlink ( 'C:\wamp\www\simens\public\images\images\\' . $result['NomImage'] . '.jpg' );
		/**
		 * SUPPRESSION DE L'IMAGE DANS LA BASE
		 */
		$this->demandeExamensTable()->supprimerImage($result['IdImage']);
		
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode ( ));
	}
	
	/** POUR LES EXAMENS MORPHOLOGIQUES **/
	/** POUR LES EXAMENS MORPHOLOGIQUES **/
	/** POUR LES EXAMENS MORPHOLOGIQUES **/
	public function supprimerImageMorphoAction()
	{
		$id_cons = $this->params()->fromPost('id_cons');
		$id = $this->params()->fromPost('id'); //numero de l'image dans le diapo
		$typeExamen = $this->params()->fromPost('typeExamen');
	
		/**
		 * RECUPERATION DE TOUS LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		*/
		 $result = $this->demandeExamensTable()->recupererDonneesExamenMorpho($id_cons, $id, $typeExamen);
		/**
		 * SUPPRESSION PHYSIQUE DE L'IMAGE
		*/
		 unlink ( 'C:\wamp\www\simens\public\images\images\\' . $result['NomImage'] . '.jpg' );
		/**
		 * SUPPRESSION DE L'IMAGE DANS LA BASE
		*/
		 $this->demandeExamensTable()->supprimerImage($result['IdImage']);
	
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode ());
	}
	
	//************************************************************************************
	//************************************************************************************
	//************************************************************************************
	public function demandeExamenAction()
	{
		$id_cons = $this->params()->fromPost('id_cons');
		$examens = $this->params()->fromPost('examens');
		$notes = $this->params()->fromPost('notes');
	

		$this->demandeExamensTable()->saveDemandesExamensMorphologiques($id_cons, $examens, $notes);
		
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode (  ));
	}
	
	//************************************************************************************
	//************************************************************************************
	//************************************************************************************
	public function demandeExamenBiologiqueAction()
	{
		$id_cons = $this->params()->fromPost('id_cons');
		$examensBio = $this->params()->fromPost('examensBio');
		$notesBio = $this->params()->fromPost('notesBio');
	
	
		$this->demandeExamensTable()->saveDemandesExamensBiologiques($id_cons, $examensBio, $notesBio);
	
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode (  ));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/****************************************************************************************/
	/****************************************************************************************/
	/****************************************************************************************/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/****************************************************************************************/
	/****************************************************************************************/
	/****************************************************************************************/

	public function listeDemandeHospitalisationAction() {
		$this->layout()->setTemplate('layout/Archivage');
	
		$formHospitalisation = new HospitaliserForm();
		$formHospitalisation->get('division')->setvalueOptions($this->getBatimentTable()->listeBatiments());
	
		if($this->getRequest()->isPost()) {
			$id_lit = $this->params()->fromPost('lit',0);
			$code_demande = $this->params()->fromPost('code_demande',0);
			
			$result = $this->getDemandeHospitalisationTable()->getDemandehospitalisationWithIdDemHospi($code_demande);
			if($result) {$date_debut = $result->date_demande_hospi; } else {$date_debut = null;}
	
			$id_hosp = $this->getHospitalisationTable()->saveHospitalisation($code_demande, $date_debut);
			$this->getHospitalisationlitTable()->saveHospitalisationlit($id_hosp, $id_lit);
	
			$this->getDemandeHospitalisationTable()->validerDemandeHospitalisation($code_demande);
	
			//Le lit ne doit pas être occuper puisqu'on ne fait que archiver
			//$this->getLitTable()->updateLit($id_lit);
	
			return $this->redirect()->toRoute('archivage' , array('action' => 'liste-demande-hospitalisation'));
		}
	
		return array(
				'form' => $formHospitalisation
		);
	}
	
	public function listePatientEncoursAjaxAction() {
		$user = $this->layout()->user;
		$IdDuService = $user['IdService'];
		
		$output = $this->getDemandeHospitalisationTable()->getListePatientEncoursHospitalisation($IdDuService);
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function sallesAction()
	{
		$id_batiment = (int)$this->params()->fromPost ('id_batiment');
	
		if ($this->getRequest()->isPost()){
			$liste_select = "";
	
			foreach($this->getBatimentTable()->listeSalleDisponible($id_batiment) as $listeSalles){
				$liste_select.= "<option value=".$listeSalles['IdSalle'].">".$listeSalles['NumeroSalle']."</option>";
			}
	
			$liste_select.="<script> $('#salle').val(''); $('#lit').html('');</script>";
		}
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode ( $liste_select));
	}
	
	public function litsAction()
	{
		$id_salle = (int)$this->params()->fromPost ('id_salle');
	
		if ($this->getRequest()->isPost()){
			$liste_select = "";
	
			foreach($this->getBatimentTable()->listeLitDisponible($id_salle) as $listeLits){
				$liste_select.= "<option value=".$listeLits['IdLit'].">".$listeLits['NomLit']."</option>";
			}
	
			$liste_select.="<script> $('#lit').val('');</script>";
		}
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode ( $liste_select));
	}
	
	public function infoPatientAction() {
		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$encours = $this->params()->fromPost('encours',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$id_demande_hospi = $this->params()->fromPost('id_demande_hospi',0);
		
		$unPatient = $this->getPatientTable()->getInfoPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
		
		$demande = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdcons($id_cons);
		
		$date = $this->controlDate->convertDate( $unPatient['DATE_NAISSANCE'] );
		
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 200px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE']. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
		
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></td>";
		
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 200px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		$html .= "<div id='titre_info_deces'> 
				     <span id='titre_info_demande41' style='margin-left:-5px; cursor:pointer;'>
				        <img src='../img/light/plus.png' /> D&eacute;tails des infos sur la demande
				     </span>
				  </div>
		          <div id='barre'></div>";
		
		$html .= "<div id='info_demande41'>";
		$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
		$html .= "<tr style='width: 95%;'>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d'enregistrement:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($demande['date_demande_hospi']) . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date fin pr&eacute;vue:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDate($demande['date_fin_prevue_hospi']) . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$demande['PrenomMedecin'].' '.$demande['NomMedecin']. "</p></td>";
		$html .= "</tr>";
		$html .= "</table>";
		
		$html .="<table style='margin-top:0px; margin-left:18%; width: 70%;'>";
		$html .="<tr style='width: 70%'>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Motif de la demande:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>". $demande['motif_demande_hospi'] ."</p></td>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'> </p></td>";
		$html .="</tr>";
		$html .="</table>";
		$html .= "</div>";
		
		/***
		 * UTILISER UNIQUEMENT DANS LA VUE DE LA LISTE DES PATIENTS EN COURS D'HOSPITALISATION
		*/
		if($encours == 111) {
			$this->getDateHelper();
			$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
			$lit_hospitalisation = $this->getHospitalisationlitTable()->getHospitalisationlit($hospitalisation->id_hosp);
			$lit = $this->getLitTable()->getLit($lit_hospitalisation->id_materiel);
			$salle = $this->getSalleTable()->getSalle($lit->id_salle);
			$batiment = $this->getBatimentTable()->getBatiment($salle->id_batiment);
				
			$html .= "<div id='titre_info_deces'>
					   <span id='titre_info_hospitalisation21' style='margin-left:-5px; cursor:pointer;'>
				          <img src='../img/light/plus.png' /> Infos sur l'hospitalisation
				       </span>
					  </div>
		              
					  <div id='barre'></div>";
			
			$html .= "<div id='info_hospitalisation21'>";
			$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d&eacute;but:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDate($demande['Datedemandehospi']) . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Batiment:</a><br><p style=' font-weight:bold; font-size:17px;'>".$batiment->intitule."</p></td>";
			$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Salle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$salle->numero_salle."</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lit:</a><br><p style=' font-weight:bold; font-size:17px;'>".$lit->intitule."</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
		}
		
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminerVisualisationHosp'>Terminer</button></div>
                     </div>";
		}
		/***
		 * UTILISER UNIQUEMENT DANS LA PAGE POUR LA LIBERATION DU PATIENT EN COURS D'HOSPITALISATION
		*/
		else if($terminer == 111) {
			$html .="<div style='width: 100%; height: 270px;'>";
				
			$html .= "<div id='titre_info_deces' >Infos sur la lib&eacute;ration du patient </div>
		              <div id='barre'></div>";
				
			$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
			$formLiberation = new LibererPatientForm();
			$data = array('id_demande_hospi' => $id_demande_hospi);
			$formLiberation->populateValues($data);
				
			$formRow = new FormRow();
			$formTextArea = new FormTextarea();
			$formHidden = new FormHidden();
				
			$html .="<form id='Formulaire_Liberer_Patient'  method='post' action='".$chemin."/archivage/liberer-patient'>";
			$html .=$formHidden($formLiberation->get('id_demande_hospi'));
			$html .=$formHidden($formLiberation->get('temoin_transfert'));
			$html .=$formHidden($formLiberation->get('id_cons'));
			$html .="<div style='width: 80%; margin-left: 18%;'>";
			$html .="<table id='form_patient' style='width: 100%; '>
					 <tr class='comment-form-patient' style='width: 100%'>
					   <td id='note_soin'  style='width: 45%; '>". $formRow($formLiberation->get('resumer_medical')).$formTextArea($formLiberation->get('resumer_medical'))."</td>
					   <td id='note_soin'  style='width: 45%; '>". $formRow($formLiberation->get('motif_sorti')).$formTextArea($formLiberation->get('motif_sorti'))."</td>
					   <td  style='width: 10%;'><a href='javascript:vider_liberation()'><img id='test' style=' margin-left: 25%;' src='../images_icons/118.png' title='vider tout'></a></td>
					 </tr>
					 </table>";
			$html .="</div>";
				
			$html .="<div style=' margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
				
			$html .="<div style='width: 10%; padding-left: 30%; float:left;'>";
			$html .="<div class='block' id='thoughtbot' style=' float:left; width: 30%; vertical-align: bottom;  margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button id='terminerLiberer'>Annuler</button></div>";
            $html .="</div>";
			
            $html .="<div class='block' id='thoughtbot' style=' float:left; width: 30%; vertical-align: bottom;  margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='liberer'>Lib&eacute;rer</button></div>";
			$html .="</form>";
		
			$html .="<script>
					  function vider_liberation(){
	                   $('#resumer_medical').val('');
	                   $('#motif_sorti').val('');
		              }
					  //$('#resumer_medical, #motif_sorti').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'16px'});
					  $('#resumer_medical, #motif_sorti').css({'font-size':'17px'});
					</script>
					";
		}
		$html .="</div>";
		
		$html .="<script>
				  listepatient();
				  initAnimationVue();
				  animationPliantDepliant21();
		          animationPliantDepliant41();
				  
				  var clickUneSeuleFois = 0;
				  $('#prescriptionOrdonnance').click(function(){ 
			        $( '#confirmationDeLaLiberation' ).dialog( 'close' ); 
			        PrescriptionOrdonnancePopup();
			        $('#PrescriptionOrdonnancePopupInterface').dialog('open');
			        if(clickUneSeuleFois == 0){ 
				       $('#ajouter_medicament').trigger('click'); 
				       $('#impressionPdf').toggle(false); 
				       $('#id_personneForOrdonnance').val(".$id_personne.");
				       $('#id_consForOrdonnance').val('".$id_cons."');
				       		
				       clickUneSeuleFois = 1;
	                }
			        return false;
		          });
				
				 </script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function informationPatientAction() {
		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$encours = $this->params()->fromPost('encours',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$id_demande_hospi = $this->params()->fromPost('id_demande_hospi',0);
		
		$unPatient = $this->getPatientTable()->getInfoPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
		
		$demande = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdcons($id_cons);
		
		$date = $this->controlDate->convertDate( $unPatient['DATE_NAISSANCE'] );
		
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 200px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE']. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
		
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></td>";
		
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 200px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		$html .= "<div id='titre_info_deces'>
				     <span id='titre_info_demande41' style='margin-left:-5px; cursor:pointer;'>
				        <img src='../img/light/plus.png' /> D&eacute;tails des infos sur la demande
				     </span>
				  </div>
		          <div id='barre'></div>";
		
		$html .= "<div id='info_demande41'>";
		$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
		$html .= "<tr style='width: 95%;'>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($demande['date_demande_hospi']) . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date fin pr&eacute;vue:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDate($demande['date_fin_prevue_hospi']) . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$demande['PrenomMedecin'].' '.$demande['NomMedecin']. "</p></td>";
		$html .= "</tr>";
		$html .= "</table>";
		
		$html .="<table style='margin-top:0px; margin-left:18%; width: 70%;'>";
		$html .="<tr style='width: 70%'>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Motif de la demande:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>". $demande['motif_demande_hospi'] ."</p></td>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'> </p></td>";
		$html .="</tr>";
		$html .="</table>";
		$html .= "</div>";
		
		/***
		 * UTILISER UNIQUEMENT DANS LA VUE DE LA LISTE DES PATIENTS EN COURS D'HOSPITALISATION
		*/
		if($encours == 111) {
			$this->getDateHelper();
			$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
			$lit_hospitalisation = $this->getHospitalisationlitTable()->getHospitalisationlit($hospitalisation->id_hosp);
			$lit = $this->getLitTable()->getLit($lit_hospitalisation->id_materiel);
			$salle = $this->getSalleTable()->getSalle($lit->id_salle);
			$batiment = $this->getBatimentTable()->getBatiment($salle->id_batiment);
		
			$html .= "<div id='titre_info_deces'>
					   <span id='titre_info_hospitalisation21' style='margin-left:-5px; cursor:pointer;'>
				          <img src='../img/light/plus.png' /> Infos sur l'hospitalisation
				       </span>
					  </div>
		
					  <div id='barre'></div>";
				
			$html .= "<div id='info_hospitalisation21'>";
			$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d&eacute;but:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($hospitalisation->date_debut) . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Batiment:</a><br><p style=' font-weight:bold; font-size:17px;'>".$batiment->intitule."</p></td>";
			$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Salle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$salle->numero_salle."</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lit:</a><br><p style=' font-weight:bold; font-size:17px;'>".$lit->intitule."</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
		}
		
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminerVisualisationHosp'>Terminer</button></div>
                     </div>";
		}
		/***
		 * UTILISER UNIQUEMENT DANS LA PAGE POUR LA LIBERATION DU PATIENT EN COURS D'HOSPITALISATION
		*/
		else if($terminer == 111) {
			$html .="<div style='width: 100%; height: 270px;'>";
		
			$html .= "<div id='titre_info_deces' >Infos sur la lib&eacute;ration du patient </div>
		              <div id='barre'></div>";
		
			$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
			$formLiberation = new LibererPatientForm();
			$data = array('id_demande_hospi' => $id_demande_hospi);
			$formLiberation->populateValues($data);
		
			$formRow = new FormRow();
			$formTextArea = new FormTextarea();
			$formHidden = new FormHidden();
		
			$html .="<form id='Formulaire_Liberer_Patient'  method='post' action='".$chemin."/archivage/liberer-patient'>";
			$html .=$formHidden($formLiberation->get('id_demande_hospi'));
			$html .=$formHidden($formLiberation->get('temoin_transfert'));
			$html .=$formHidden($formLiberation->get('id_cons'));
			$html .="<div style='width: 80%; margin-left: 18%;'>";
			$html .="<table id='form_patient' style='width: 100%; '>
					 <tr class='comment-form-patient' style='width: 100%'>
					   <td id='note_soin'  style='width: 45%; '>". $formRow($formLiberation->get('resumer_medical')).$formTextArea($formLiberation->get('resumer_medical'))."</td>
					   <td id='note_soin'  style='width: 45%; '>". $formRow($formLiberation->get('motif_sorti')).$formTextArea($formLiberation->get('motif_sorti'))."</td>
					   <td  style='width: 10%;'><a href='javascript:vider_liberation()'><img id='test' style=' margin-left: 25%;' src='../images_icons/118.png' title='vider tout'></a></td>
					 </tr>
					 </table>";
			$html .="</div>";
		
			$html .="<div style=' margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
		
			$html .="<div style='width: 10%; padding-left: 30%; float:left;'>";
			$html .="<div class='block' id='thoughtbot' style=' float:left; width: 30%; vertical-align: bottom;  margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button id='terminerLiberer'>Annuler</button></div>";
			$html .="</div>";
				
			$html .="<div class='block' id='thoughtbot' style=' float:left; width: 30%; vertical-align: bottom;  margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='liberer'>Lib&eacute;rer</button></div>";
			$html .="</form>";
		
			$html .="<script>
					  function vider_liberation(){
	                   $('#resumer_medical').val('');
	                   $('#motif_sorti').val('');
		              }
					  //$('#resumer_medical, #motif_sorti').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'16px'});
					  $('#resumer_medical, #motif_sorti').css({'font-size':'17px'});
					</script>
					";
		}
		$html .="</div>";
		
		$html .="<script>
				  listepatient();
				  initAnimationVue();
				  animationPliantDepliant21();
		          animationPliantDepliant41();
				 </script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function libererPatientAction() {
		$id_demande_hospi = $this->params()->fromPost('id_demande_hospi', 0);
		$resumer_medical = $this->params()->fromPost('resumer_medical', 0);
		$motif_sorti = $this->params()->fromPost('motif_sorti', 0);
	
		$this->getHospitalisationTable()->libererPatient($id_demande_hospi, $resumer_medical, $motif_sorti);
	
		return $this->redirect()->toRoute('archivage', array('action' =>'administrer-soin'));
	}
	
	public function infoPatientHospiAction(){
	
		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$administrerSoin = $this->params()->fromPost('administrerSoin',0);
	
		$unPatient = $this->getPatientTable()->getInfoPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
	
		$date = $this->controlDate->convertDate( $unPatient['DATE_NAISSANCE'] );
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE']. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		if($administrerSoin != 111) {
			$html .= "<div id='titre_info_deces'>Attribution d'un lit</div>
		              <div id='barre'></div>";
	
			$html .= "<script>$('#salle, #division, #lit').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});</script>";
		}else if($administrerSoin == 111){
			$html .= "<script>$('#salle, #division, #lit').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});</script>";
		}
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function administrerSoinAction() {
		$this->layout()->setTemplate('layout/archivage');
	
		$user = $this->layout()->user;
		$IdDuService = $user['IdService'];
 		$id_medecin = $user['id_personne'];
		
		$formSoin = new SoinForm();
	
		$hopital = $this->getTransfererPatientServiceTable ()->fetchHopital ();
		$formSoin->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		//RECUPERATION DE L'HOPITAL DU SERVICE
		$transfertPatientHopital = $this->getTransfererPatientServiceTable ()->getHopitalPatientTransfert($IdDuService);
		$idHopital = $transfertPatientHopital['ID_HOPITAL'];
		//RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
		$serviceHopital = $this->getTransfererPatientServiceTable ()->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
		//LISTE DES SERVICES DE L'HOPITAL
		$formSoin->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
	
		$date = new \DateTime();
		$aujourdhui = $date->format('dmy');
		$data = array (
				'hopital_accueil' => $idHopital,
				'date_cons' => $aujourdhui,
		);
	
		$formSoin->populateValues($data);
		if($this->getRequest()->isPost()) {
	
			$data = $this->getRequest()->getPost();
				
			$id_sh = $this->getSoinHospitalisationTable()->saveSoinhospitalisation($data, $id_medecin);
			$this->getSoinHospitalisationTable()->saveHeure($data,$id_sh);
			//$test = 'En cours de dÃ©veloppement';
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode () );
		}
	
		$listeMedicament = $this->getConsommableTable()->listeDeTousLesMedicaments();
	
		$listeMedicamentOrd = $this->getConsommableTable()->listeDeTousLesMedicaments();
		$listeFormeOrd = $this->getConsommableTable()->formesMedicaments();
		$listetypeQuantiteMedicamentOrd = $this->getConsommableTable()->typeQuantiteMedicaments();
		
		return array(
				'form' => $formSoin,
				'liste_med' => $listeMedicament,
		
				'liste_medOrdonnance' => $listeMedicamentOrd,
				'listeFormeOrdonnance' => $listeFormeOrd,
				'listetypeQuantiteMedicamentOrdonnance'  => $listetypeQuantiteMedicamentOrd,
		);

	}
	
	public function listeSoinsPrescritsAction() {
		$id_hosp = $this->params()->fromPost('id_hosp', 0);
	
		$html = "<div id='titre_info_admis'>
				  <span id='titre_info_liste_soin' style='margin-left:-5px; cursor:pointer; margin-top: 100px;'>
				    <img src='../img/light/minus.png' /> Liste des soins</div>
				  </span>
		        <div id='barre_admis'></div>";
		$html .="<div id='Liste_soins_deja_prescrit'>";
		$html .= $this->raffraichirListeSoins($id_hosp);
		$html .="</div>";
	
		$html .="<script>
				  /*$('#Liste_soins_deja_prescrit').toggle(false);*/
				  depliantPlus6();
				 </script>";
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function raffraichirListeSoinsPrescrit($id_hosp){
	
		$liste_soins = $this->getSoinHospitalisationTable()->getAllSoinhospitalisation($id_hosp);
		$html = "";
		$this->getDateHelper();
		
		$today = new \DateTime();
		$aujourdhui = $today->format('Y-m-d');
		
		$html .="<div style='margin-right: 10px; float:right; font-family: Times New Roman; font-size: 15px; color: green;'>
				   <i style='cursor:pointer;' id='afficherTerminer'> Termin&eacute; </i> |
				   <i style='cursor:pointer;' id='afficherEncours'> Encours </i> |
				   <i style='cursor:pointer;' id='afficherAvenir'> A venir </i>
				</div>";
			
		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; width:100%;' id='listeSoin'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer;'>
					<th style='width: 23%;'>M&eacute;dicament</th>
					<th style='width: 21%;'>Voie d'administration</th>
					<th style='width: 21%;'>Dosage <span style='font-weight: normal;'>X</span> Fr&eacute;quence</th>
					<th style='width: 17%;'>Heure suivante</th>
				    <th style='width: 12%;'>Options</th>
				    <th style='width: 6%;'>Etat</th>
				  </tr>
			     </thead>";
			
		$html .="<tbody style='width: 100%;'>";
	
		rsort($liste_soins);
		foreach ($liste_soins as $cle => $Liste){
			//Récupération de l'heure suivante pour l'application du soin par l'infirmier
			$heureSuivante = $this->getSoinHospitalisationTable()->getHeureSuivantePourAujourdhui($Liste['id_sh']);
			$heurePrecedente = $this->getSoinHospitalisationTable()->getHeurePrecedentePourAujourdhui($Liste['id_sh']);
				
			$temoin = 0;
			$idHeure = null;
			$heureSuiv = null;
			if($heureSuivante || $heurePrecedente){
				$heurePrecedenteH = substr($heurePrecedente['heure'], 0, 2);
				
				$heureActuelleH = $today->format('H');
				$heureSuivanteH = substr($heureSuivante['heure'], 0, 2);
				
				if($heureSuivanteH-$heureActuelleH == 1){
					$heureActuelleM = $today->format('i');
					$heureSuivanteM = 59;
					$diff = $heureSuivanteM - $heureActuelleM;
					
					if($diff <= 10){
						$heureSuiv = "<khass id='alertHeureApplicationSoinUrgent".$Liste['id_sh']."' style='color: orange; font-weight: bold; font-size: 20px;'>".$heureSuivante['heure']."
								      </khass>";
						              $play = true;
					}else if ($diff <= 30) {
						$heureSuiv = "<khass id='alertHeureApplicationSoin".$Liste['id_sh']."' style='color: orange; font-weight: bold; font-size: 20px;'>".$heureSuivante['heure']."</khass>";
					}else {
						$heureSuiv = "<khass style='color: orange; font-weight: bold; font-size: 20px;'>".$heureSuivante['heure']."</khass>";
					}
					
				}else 
				    if ($heurePrecedenteH == $heureActuelleH){
				    	$heureActuelleM = $today->format('i');
				    	if($heureActuelleM <= 30){
				    		$heureSuiv ="<khass id='alertHeureApplicationSoinUrgent2".$Liste['id_sh']."' style='color: red; font-weight: bold; font-size: 20px;'>".$heurePrecedente['heure']."
								         </khass>
								         <audio id='audioPlayer' src='../images_icons/alarme.mp3' ></audio>";
				    		$temoin = 1;
				    		$play = true;
				    	}else {
				    		if($heureSuivante['heure']){
				    			$heureSuiv = "<khass style='color: orange; font-weight: bold; font-size: 20px;'>".$heureSuivante['heure']."</khass>";
				    		}				    	}
				    }
					else {
						if($heureSuivante['heure']){
							$heureSuiv = "<khass style='color: orange; font-weight: bold; font-size: 20px;'>".$heureSuivante['heure']."</khass>";
						}
					}
			}
			
			
			$html .="<tr style='width: 100%;' id='".$Liste['id_sh']."'>";
			$html .="<td style='width: 23%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['medicament']."</div></td>";
			$html .="<td style='width: 21%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['voie_administration']."</div></td>";
			$html .="<td style='width: 21%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['dosage']." <span style='font-weight: normal; font-family: arial; color: green; font-size: 13px;'>X</span> ".$Liste['frequence']."</div></td>";
	
			if($heureSuiv == null){
				$JourSuivant = $this->getSoinHospitalisationTable()->getDateApresDateDonnee($Liste['id_sh'], $aujourdhui);
				$HeuresPourAujourdhui = $this->getSoinHospitalisationTable()->getHeuresPourAujourdhui($Liste['id_sh']);
				if($JourSuivant && $HeuresPourAujourdhui){
					$html .="<td style='width: 17%;'>
							   <div id='inform' style='float:left; font-size:16px;'>
							     ".$this->controlDate->convertDate($JourSuivant['date'])." - ".$JourSuivant['heure']."
							     <khassSpan style='font-size: 10px;' > soin_encours </khassSpan>
							   </div>
							   
							 </td>";
				}elseif($JourSuivant && !$HeuresPourAujourdhui){
					$html .="<td style='width: 17%;'>
							   <div id='inform' style='float:left; font-size:16px;'>
							     ".$this->controlDate->convertDate($JourSuivant['date'])." - ".$JourSuivant['heure']."
							     <khassSpan style='font-size: 10px;' > soin_avenir </khassSpan>
							   </div>
							 </td>";
				}elseif(!$JourSuivant && $HeuresPourAujourdhui){
					$html .="<td style='width: 17%;'>
							   <div id='inform' style='float:left; font-size:17px;'>
							      Termin&eacute;
							      <khassSpan style='font-size: 10px;' > soin_encours </khassSpan>
							   </div>
							   
							</td>";
				}elseif(!$JourSuivant && !$HeuresPourAujourdhui){
					$html .="<td style='width: 17%;'>
							   <div id='inform' style='float:left; font-size:17px;'>
							      Termin&eacute;
							      <khassSpan style='font-size: 10px;' > soin_terminer </khassSpan>
							   </div>
							</td>";
				}

			}else{
				$html .="<td style='width: 17%;'>
						   <div id='inform' style='float:left; font-weight:bold; font-size:17px;'>
						     ".$heureSuiv."
						     <khassSpan style='font-size: 10px;' > soin_encours </khassSpan>
						   </div>
						 </td>";
			}
			
			if($Liste['appliquer'] == 0) {
				$html .="<td style='width: 12%;'> <a href='javascript:vuesoin(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='../images_icons/voird.png'  title='d&eacute;tails' />
					  </a>&nbsp";
	
				//Si au moin pour une heure un soin a ete applique impossible de Supprimer le soin
				$ListeHeureSoinApplique = $this->getSoinHospitalisationTable()->getHeureAppliquer($Liste['id_sh']);
				if($ListeHeureSoinApplique != 0){
					$html .="<span>
					    	  <img style='color: white; opacity: 0.15;' src='../images_icons/modifier.png'/>
					         </span>&nbsp;";
					$html .="<span> <img  style='color: white; opacity: 0.15;' src='../images_icons/sup.png' /> </span>
				             </td>";
				} else {
					$html .="<a href='javascript:modifiersoin(".$Liste['id_sh'].",".$Liste['id_hosp'].")'>
					    	  <img class='modifier".$Liste['id_sh']."'  src='../images_icons/modifier.png' title='modifier'/>
					         </a>&nbsp;";
					$html .="<a href='javascript:supprimersoin(".$Liste['id_sh'].",".$Liste['id_hosp'].")'>
					    	  <img class='supprimer".$Liste['id_sh']."'  src='../images_icons/sup.png' title='annuler' />
					         </a>
				             </td>";
				}
				
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_oui".$Liste['id_sh']."' style='margin-left: 20%;' src='../images_icons/non.png' title='pas totalement appliqu&eacute;' />
					     &nbsp;
				         </td>";
			}else {
	
				$html .="<td style='width: 12%;'> <a href='javascript:vuesoinApp(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='../images_icons/voird.png' title='d&eacute;tails' />
					  </a>&nbsp";
				
				$html .="<a>
					    	<img class='modifier".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='../images_icons/modifier.png' />
					     </a>&nbsp;
	
				         <a >
					    	<img class='supprimer".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='../images_icons/sup.png' />
					     </a>
				         </td>";
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_non".$Liste['id_sh']."' style='margin-left: 20%;' src='../images_icons/oui.png' title='totalement appliqu&eacute;' />
					     &nbsp;
				         </td>";
	
			}
	
			$html .="</tr>";
	
			$html .="<script>
					  $('.visualiser".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.visualiser".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.visualiser".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.visualiser".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /************************/
	                  /************************/
	                  /************************/
                      $('.modifier".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.modifier".$Liste['id_sh']." ' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
				      $('.modifier".$Liste['id_sh']." ').mouseleave(function(){
	                    var tooltips = $( '.modifier".$Liste['id_sh']." ' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.supprimer".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.supprimer".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.supprimer".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.supprimer".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_oui".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_oui".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_oui".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.etat_oui".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_non".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_non".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_non".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.etat_non".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                    		
	                  function FaireClignoterPourAlerteUrgent".$Liste['id_sh']." (){
                          $('#alertHeureApplicationSoinUrgent".$Liste['id_sh']."').fadeOut(250).fadeIn(200);
                      }
                      $(function(){
                          setInterval('FaireClignoterPourAlerteUrgent".$Liste['id_sh']." ()',500);
                      });

                          		
                      function FaireClignoterPourAlerteUrgent2".$Liste['id_sh']." (){
                          $('#alertHeureApplicationSoinUrgent2".$Liste['id_sh']."').fadeOut(100).fadeIn(50);
                      }
                      $(function(){
                          setInterval('FaireClignoterPourAlerteUrgent2".$Liste['id_sh']." ()',500);
                      });
                          		
                          		
                      function FaireClignoterPourAlerte".$Liste['id_sh']." (){
                          $('#alertHeureApplicationSoin".$Liste['id_sh']."').fadeOut(900).fadeIn(800);
                      }
                      $(function(){
                          setInterval('FaireClignoterPourAlerte".$Liste['id_sh']." ()',4200);
                      });
                          		
			        </script>";
		}
		$html .="</tbody>";
		$html .="</table>";
	
		$html .="<style>
	
				  #listeSoin tbody tr{
				    background: #fbfbfb;
				  }
	
				  #listeSoin tbody tr:hover{
				    background: #fefefe;
				  }
				 </style>";
		$html .="<script> $('#listeSoin khassSpan').toggle(false); listepatient (); listeDesSoins(); </script>";
	
		return $html;
	
	}
	
	public function appliquerSoinAction() {
		$this->layout()->setTemplate('layout/archivage');
	
		$formAppliquerSoin = new AppliquerSoinForm();
	
		return array(
				'form' => $formAppliquerSoin
		);
	}
	
	public function listePatientSuiviAjaxAction() {
		$user = $this->layout()->user;
		$IdDuService = $user['IdService'];
		$output = $this->getDemandeHospitalisationTable()->getListePatientSuiviHospitalisation($IdDuService);
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function administrerSoinPatientAction() {
		$this->getDateHelper();
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$encours = $this->params()->fromPost('encours',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$id_demande_hospi = $this->params()->fromPost('id_demande_hospi',0);
	
		$demande = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdcons($id_cons);
	
		$unPatient = $this->getPatientTable()->getInfoPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
	
		$date = $this->controlDate->convertDate( $unPatient['DATE_NAISSANCE'] );
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE']. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		$html .= "<div id='titre_info_deces'>
				     <span id='titre_info_demande41' style='margin-left:-5px; cursor:pointer;'>
				        <img src='".$chemin."/img/light/plus.png' /> D&eacute;tails des infos sur la demande
				     </span>
				  </div>
		          <div id='barre'></div>";
	
		$html .= "<div id='info_demande41'>";
		$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
		$html .= "<tr style='width: 80%;'>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($demande['Datedemandehospi']) . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date fin pr&eacute;vue:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($demande['date_fin_prevue_hospi']) . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$demande['PrenomMedecin'].' '.$demande['NomMedecin']. "</p></td>";
		$html .= "</tr>";
		$html .= "</table>";
	
		$html .="<table style='margin-top:0px; margin-left:18%; width: 70%;'>";
		$html .="<tr style='width: 70%'>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Motif de la demande:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>". $demande['motif_demande_hospi'] ."</p></td>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'> </p></td>";
		$html .="</tr>";
		$html .="</table>";
		$html .= "</div>";
	
		/***
		 * UTILISER UNIQUEMENT DANS LA VUE DE LA LISTE DES PATIENTS EN COURS D'HOSPITALISATION
		*/
		if($encours == 111) {
			$this->getDateHelper();
			$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
			$lit_hospitalisation = $this->getHospitalisationlitTable()->getHospitalisationlit($hospitalisation->id_hosp);
			$lit = $this->getLitTable()->getLit($lit_hospitalisation->id_materiel);
			$salle = $this->getSalleTable()->getSalle($lit->id_salle);
			$batiment = $this->getBatimentTable()->getBatiment($salle->id_batiment);
	
			$html .= "<div id='titre_info_deces'>
					   <span id='titre_info_hospitalisation21' style='margin-left:-5px; cursor:pointer;'>
				          <img src='".$chemin."/img/light/plus.png' /> Infos sur l'hospitalisation
				       </span>
					  </div>
		              <div id='barre'></div>";
	
			$html .= "<div id='info_hospitalisation21'>";
			$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d&eacute;but:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($hospitalisation->date_debut) . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Batiment:</a><br><p style=' font-weight:bold; font-size:17px;'>".$batiment->intitule."</p></td>";
			$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Salle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$salle->numero_salle."</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lit:</a><br><p style=' font-weight:bold; font-size:17px;'>".$lit->intitule."</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
		}
	
		$html .= "<div id='titre_info_deces'>
				    <span id='titre_info_liste' style='margin-left:-5px; cursor:pointer;'>
				      <img src='".$chemin."/img/light/minus.png' /> Liste des soins
				    </span>
				  </div>
		          <div id='barre'></div>";
	
		$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
		$html .= "<div id='info_liste'>";
		$html .= $this->listeSoinsAAppliquer($hospitalisation->id_hosp);
		$html .= "</div>";
	
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$chemin."/images_icons/fleur1.jpg' />
                     </div>";
			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminerdetailhospi'>Terminer</button></div>
                     </div>";
		}
	
		$html .="<script>
				  listepatient();
				  initAnimationVue();
				  animationPliantDepliant21();
				  animationPliantDepliant3();
		          animationPliantDepliant41();
				 </script>";
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function listeSoinsAAppliquer($id_hosp){
		$liste_soins = $this->getSoinHospitalisationTable()->getAllSoinhospitalisation($id_hosp);
		$html = "";
		$this->getDateHelper();
			
		$today = new \DateTime();
		$aujourdhui = $today->format('Y-m-d');
		
		$html .="<div id='listeDeTousLesSoinsDuPatient'>
				 <table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; margin-left:18%; width:80%;' id='listeSoin'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer; '>
					<th style='width: 24%;'>M<minus>&eacute;dicament</minus></th>
					<th style='width: 21%;'>V<minus>oie d'administration</minus></th>
					<th style='width: 22%;'>D<minus>osage </minus>  <text style='font-weight: normal; font-family: arial; color: green; font-size: 15px;'> X </text> F<minus>r&eacute;quence </minus></th>
					<th style='width: 17%;'>H<minus>eure suivante </minus></th>
				    <th style='width: 10%;'>O<minus>ptions</minus></th>
				    <th style='width: 6%;'>E<minus>tat</minus></th>
				  </tr>
			     </thead>";
			
		$html .="<tbody style='width: 100%;'>";
	
		$play = false;
		sort($liste_soins);
 		foreach ($liste_soins as $cle => $Liste){
 			//Récupération de l'heure suivante pour l'application du soin
 			$heureSuivante = $this->getConsultationTable()->getHeureSuivante($Liste['id_sh']);
			
 			$idHeure = 0;
 			$heureSuiv = 'Termin&eacute;';
 			if($heureSuivante){
 				$idHeure = $heureSuivante['id_heure'];
 				$heureSuiv = "<khass style='color: orange; font-weight: bold; font-size: 20px;'>".$heureSuivante['heure']."</khass>";
 			}
 			
 			$html .="<tr style='width: 100%;' id='".$Liste['id_sh']."'>";
 			$html .="<td style='width: 24%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['medicament']."</div></td>";
			$html .="<td style='width: 21%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['voie_administration']."</div></td>";
			$html .="<td style='width: 22%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['dosage']." <text style='font-weight: normal; font-family: arial; color: green; font-size: 13px;'> X </text> ".$Liste['frequence']."</div></td>";

				
			$html .="<td style='width: 17%;'>
					   <div id='inform' style='float:left; font-weight:bold; font-size:17px;'>
					     ".$heureSuiv."
					   </div>
					 </td>";
			$html .="<td style='width: 10%;'> <a href='javascript:vuesoin(".$Liste['id_sh'].") '>
				       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='../images_icons/voird.png' title='d&eacute;tails' />
					  </a>&nbsp";
			
			if($heureSuiv != 'Termin&eacute;'){
				$html .="<a href='javascript:appliquerSoin(".$Liste['id_sh'].",".$Liste['id_hosp'].",".$idHeure.")'>
					    	<img class='modifier".$Liste['id_sh']."'  src='../img/dark/blu-ray.png' title='appliquer le soin'/>
					     </a>&nbsp;
				
				         </td>";
			} else {
				$html .="<a style='color: white; opacity: 0.09;'>
					    	<img src='../img/dark/blu-ray.png' />
					     </a>&nbsp;
				
				         </td>";
			}
			
			if($Liste['appliquer'] == 0) {
				$html .="<td style='width: 6%;'>
					       <img class='etat_oui".$Liste['id_sh']."' style='margin-left: 20%;' src='/simens/public/images_icons/non.png' title='pas totalement appliqu&eacute;' />
					     &nbsp;
				         </td>";
			}else {
				$html .="<td style='width: 6%;'>
					       <img class='etat_non".$Liste['id_sh']."' style='margin-left: 20%;' src='/simens/public/images_icons/oui.png' title='totalement appliqu&eacute;' />
					     &nbsp;
				         </td>";
			}
				
 			$html .="</tr>";
				
			$html .="<script>
					  $('.visualiser".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.visualiser".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.visualiser".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.visualiser".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /************************/
	                  /************************/
	                  /************************/
                      $('.modifier".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.modifier".$Liste['id_sh']." ' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
				      $('.modifier".$Liste['id_sh']." ').mouseleave(function(){
	                    var tooltips = $( '.modifier".$Liste['id_sh']." ' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.supprimer".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.supprimer".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.supprimer".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.supprimer".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	           
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_oui".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_oui".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_oui".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.etat_oui".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_non".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_non".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_non".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.etat_non".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  var intervalAlerte; 
	                  function FaireClignoterPourAlerte".$Liste['id_sh']." (){
                          $('#alertHeureApplicationSoinUrgent".$Liste['id_sh']."').fadeOut(250).fadeIn(200);
                      }

                      $(function(){
                          intervalAlerte = setInterval('FaireClignoterPourAlerte".$Liste['id_sh']." ()',500);
                      });
                          		

                      var intervalAlerteUrgent2;     		
                      function FaireClignoterPourAlerteUrgent2".$Liste['id_sh']." (){
                          $('#alertHeureApplicationSoinUrgent2".$Liste['id_sh']."').fadeOut(200).fadeIn(50);
                      }
                      $(function(){
                          intervalAlerteUrgent2 = setInterval('FaireClignoterPourAlerteUrgent2".$Liste['id_sh']." ()',500);
                      });
			        </script>";
 		}
 		
		$html .="</tbody>";
		$html .="</table></div>";
	
		$html .="<style>
				  #listeDeTousLesSoinsDuPatient .listeDataTable{
	                margin-left: 215px;
                  }
	
				  #listeDeTousLesSoinsDuPatient div .dataTables_paginate{
				    margin-right: 20px;
                  }
				
				  #listeSoin tbody tr{
				    background: #fbfbfb;
				  }
				
				  #listeSoin tbody tr:hover{
				    background: #fefefe;
				  }
				  
				 </style>";

		
 		$html .="<script>
 				  $('#listeSoin span').toggle(false);
 				  listepatient(); 
 				  listeDesSoins(); 
 				  $('#id_hosp').val(".$id_hosp.");
 				 </script>";
		
	
		return $html;
	}
	
	public function getLesHeuresDuSoin($id_sh, $date){
	
		$heure = $this->getSoinHospitalisationTable()->getHeuresPourUneDate($id_sh, $date);
			
		$heureSuivante = $this->getSoinHospitalisationTable()->getHeureSuivantePourUneDate($id_sh, $date);
			
		$dateTime = new \DateTime();
		$aujoudhui = $dateTime->format('Y-m-d');
	
		if($date < $aujoudhui){
			$heureSuivante = null;
		}
	
		$lesHeures = "";
			
		//S'il y'a une heure suivante et bien-sur des heures pour appliquer des soins
		if($heure && $heureSuivante){
			for ($i = 0; $i<count($heure); $i++){
				$appliquer = $this->getSoinHospitalisationTable()->getHeureAppliqueePourUneDate($id_sh, $heure[$i], $date)['applique'];
					
				if($i == count($heure)-1) {
					if($heureSuivante['heure'] == $heure[$i]){
						$lesHeures.= '<span id="clignoterHeure" style="font-weight: bold; color: orange;">'.$heure[$i].'</span>';
					}else{
							
						if($heure[$i] < $heureSuivante['heure'] &&  $appliquer == 0){
							$lesHeures.= '<span style="font-weight: bold; color: red;">'.$heure[$i].'</span> ';
						} else if ($heure[$i] > $heureSuivante['heure']){
							$lesHeures.= '<span style="color: #ccc;">'.$heure[$i].'</span>';
						} else {
							$lesHeures.= $heure[$i];
						}
							
					}
				} else {
					if($heureSuivante['heure'] == $heure[$i]){
						$lesHeures.= '<span id="clignoterHeure" style="font-weight: bold; color: orange;">'.$heure[$i].'</span>  -  ';
					}else{
							
						if($heure[$i] < $heureSuivante['heure'] &&  $appliquer == 0){
							$lesHeures.= '<span style="font-weight: bold; color: red;">'.$heure[$i].'</span>  -  ';
						} else if ($heure[$i] > $heureSuivante['heure']){
							$lesHeures.= '<span style="color: #ccc;">'.$heure[$i].' - </span>';
						} else {
							$lesHeures.= $heure[$i].' - ';
						}
							
					}
				}
			}
		}
			
		//S'il n'y a plus une heure suivante c'est a dire toutes les heures sont passées
		if($heure && !$heureSuivante && $date == $aujoudhui){
			for ($i = 0; $i<count($heure); $i++){
				$appliquer = $this->getSoinHospitalisationTable()->getHeureAppliqueePourUneDate($id_sh, $heure[$i], $date)['applique'];
					
				if($i == count($heure)-1) {
	
					if($appliquer == 0){
						$lesHeures.= '<span style="font-weight: bold; color: red;">'.$heure[$i].'</span> ';
					} else {
						$lesHeures.= $heure[$i];
					}
	
				} else {
	
					if($appliquer == 0){
						$lesHeures.= '<span style="font-weight: bold; color: red;">'.$heure[$i].'</span>  -  ';
					} else {
						$lesHeures.= $heure[$i].'  -  ';
					}
	
				}
					
			}
		}
	
		//S'il n'y a plus une heure suivante c'est a dire toutes les heures sont passées
		if($heure && !$heureSuivante && $date != $aujoudhui){
			for ($i = 0; $i<count($heure); $i++){
				$appliquer = $this->getSoinHospitalisationTable()->getHeureAppliqueePourUneDate($id_sh, $heure[$i], $date)['applique'];
					
				if($i == count($heure)-1) {
	
					if($appliquer == 0){
						$lesHeures.= '<span style="font-weight: bold; color: orange; text-decoration:underline;">'.$heure[$i].'</span> ';
					} else {
						$lesHeures.= $heure[$i];
					}
	
				} else {
	
					if($appliquer == 0){
						$lesHeures.= '<span style="font-weight: bold; color: orange; text-decoration:underline;">'.$heure[$i].'</span>  -  ';
					} else {
						$lesHeures.= $heure[$i].'  -  ';
					}
	
				}
					
			}
		}
	
		return $lesHeures;
	}
	
	public function getHeuresAVenir($id_sh, $date){
		$heure = $this->getSoinHospitalisationTable()->getHeuresPourUneDate($id_sh, $date);
		$lesHeures ="";
		for ($i = 0; $i<count($heure); $i++){
			if($i == count($heure)-1) {
				$lesHeures.= '<span style="color: #ccc;">'.$heure[$i].'</span>';
			} else {
				$lesHeures.= '<span style="color: #ccc;">'.$heure[$i].' - </span>';
			}
		}
	
		return $lesHeures;
	}
	
	public function vueSoinAppliquerAction() {

		$this->getDateHelper();
		$id_sh = $this->params()->fromPost('id_sh', 0);
		$soinHosp = $this->getSoinHospitalisationTable()->getSoinhospitalisationWithId_sh($id_sh);
			
		$today = new \DateTime();
		$aujourdhui = $today->format('Y-m-d');
		$hier = date("Y-m-d", strtotime('-1 day'));
			
		$lesHeures = $this->getLesHeuresDuSoin($id_sh, $aujourdhui);
		$finDuSoin = date("Y-m-d", strtotime($soinHosp->date_debut_application.'+'.($soinHosp->duree-1).' day' ));
		
		$dateAvenir = null;
		if(!$lesHeures){
			$dateAvenir = $soinHosp->date_debut_application;
			$lesHeures  = $this->getHeuresAVenir($id_sh, $soinHosp->date_debut_application);
		}
			
		$html  ="<table style='width: 99%;'>";
			
		$html .="<tr style='width: 99%;'>
					   <td colspan='3' style='width: 99%;'>
					     <div id='titre_info_admis' style='margin-top: 0px;'>Prescription du soin : <i style='font-size: 15px;'>".$this->controlDate->convertDateTime($soinHosp->date_enregistrement)."</i></div><div id='barre_admis'></div>
					   </td>
					 </tr>";
			
		$html .="<tr style='width: 99%; '>";
		$html .="<td style='width: 36%; padding-top: 15px; padding-right: 15px;'><span style='text-decoration:underline; font-weight:bold; font-size:15px; color: #065d10; font-family: Times  New Roman;'>M&eacute;dicament</span><br><p id='zoneChampInfo' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$soinHosp->medicament." </p></td>";
		$html .="<td style='width: 33%; padding-top: 15px; padding-right: 15px;'><span style='text-decoration:underline; font-weight:bold; font-size:15px; color: #065d10; font-family: Times  New Roman;'>Voie d'administration</span><br><p id='zoneChampInfo' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$soinHosp->voie_administration." </p></td>";
		$html .="<td style='width: 30%; padding-top: 15px;'><span style='text-decoration:underline; font-weight:bold; font-size:15px; color: #065d10; font-family: Times  New Roman;'>Dosage & Fr&eacute;quence</span><br><p id='zoneChampInfo' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$soinHosp->dosage." - ".$soinHosp->frequence."</p></td>";
		$html .="</tr>";
			
		$html .="<tr style='width: 99%;'>";
 		$html .="<td style='vertical-align:top; padding-right: 15px; padding-top: 10px;'><span style='text-decoration:underline; font-weight:bold; font-size:15px; color: #065d10; font-family: Times  New Roman;'>Date de d&eacute;but & Dur&eacute;e & Fin</span><br><p id='zoneChampInfo' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$this->controlDate->convertDate($soinHosp->date_debut_application)." - ".$soinHosp->duree." jr(s) - ".$this->controlDate->convertDate($finDuSoin)."</p></td>";
		$html .="<td colspan='2' style='width: 60%; vertical-align:top; padding-top: 10px;'>
				 <span style='text-decoration:underline; font-weight:bold; font-size:15px; color: #065d10; font-family: Times  New Roman;'>Heures recommand&eacute;es</span><br><p id='zoneChampInfo' class='lesHeuresRecAppDuSoin'  style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$lesHeures." </p>
				 </td>
				 </tr>";
			
		$html .="</table>";
			
		$html .="<table style='width: 99%;'>";
		$html .="<tr style='width: 95%;'>";
		$html .="<td style='width: 50%; padding-top: 10px; padding-right:25px;'><span style='text-decoration:underline; font-weight:bold; font-size:16px; color: #065d10; font-family: Times  New Roman;'>Motif</span><br><p id='label_Champ_NoteInformation' style='background:#f8faf8; font-size:17px; padding-left: 10px;'> ".$soinHosp->motif." </p></td>";
		$html .="<td style='width: 50%; padding-top: 10px;'><span style='text-decoration:underline; font-weight:bold; font-size:16px; color: #065d10; font-family: Times  New Roman;'>Note</span><br><p id='label_Champ_NoteInformation' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$soinHosp->note." </p></td>";
		$html .="<td style='width: 0%;'> </td>";
		$html .= "</tr>";
		
			
		$html .="<tr style='width: 99%;'>
				    <td colspan='2' style='width: 99%;'>
					  <div id='titre_info_admis'>
 				         Informations sur l'application du soin
 				         <span style='padding-left: 30px;'>
 				           <img class='transfert_gauche' style='height: 14px; width: 18px; cursor:pointer;' src='".$this->getPath()."/images_icons/transfert_gauche.png' >
 				           <img class='transfert_droite2' style='height: 14px; width: 18px;' src='".$this->getPath()."/images_icons/transfert_droite2.png' >
 				         </span>
		
 				         <span class='laDateDesSoins' style='font-size: 15px; padding-left: 15px;'> Aujourd'hui - ".$this->controlDate->convertDate($aujourdhui)."</span>
 				      </div>
 				 
 				      <div id='barre_admis'></div>
					</td>
			     </tr>";
			
		if($soinHosp){
			
			//if($soinHosp->appliquer == 0) {
		
				$listeTouteDate = $this->getSoinHospitalisationTable()->getToutesDateDuSoin($id_sh);
				$html .="<script> var j = 0; </script>";
				$i = 0;
				foreach ($listeTouteDate as $listeDate){
		
					$html .="<table id='".$listeDate['date']."' style='width: 99%; margin-top: 10px;'>";
		
					$listeHeure = $this->getSoinHospitalisationTable()->getToutesHeures($id_sh, $listeDate['date']);
		
					if($listeHeure){
						foreach ($listeHeure as $listeH) {
							if($listeH['applique'] == 1){
		
								//RECUPERATION DES INFORMATIONS DE L'INFIRMIER AYANT APPLIQUER LES DONNEES
								$infosInfirmier = $this->getSoinHospitalisationTable()->getInfosInfirmiers($listeH['id_personne_infirmier']);
								$PrenomInfirmier = " Prenom  ";
								$NomInfirmier = " Nom ";
								if($infosInfirmier){
									$PrenomInfirmier = $infosInfirmier['PRENOM'];
									$NomInfirmier = $infosInfirmier['NOM'];
								}
		
								$html .="<tr style='width: 99%;'>";
								$html .="<td style='width: 100%; vertical-align:top;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:19px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>".$listeH['heure']."</span>
								        <div class='infoUtilisateur".$listeH['id_heure']."' style='float: right; padding-top: 10px; padding-right: 10px; cursor:pointer'> <img src='../images_icons/info_infirmier.png' title='Infirmier: ".$PrenomInfirmier." ".$NomInfirmier." ".$this->controlDate->convertDateTime($listeH['date_application'])." ' /> </div>
								        <br><p id='zoneTexte' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$listeH['note']." </p>
								     </td>";
								$html .="</tr>";
		
								$html .="<script>
								         $('.infoUtilisateur".$listeH['id_heure']."').mouseenter(function(){
								           var tooltips = $( '.infoUtilisateur".$listeH['id_heure']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
								           tooltips.tooltip( 'open' );
       					                 });
	                                     $('.infoUtilisateur".$listeH['id_heure']."').mouseleave(function(){
	                                       var tooltips = $( '.infoUtilisateur".$listeH['id_heure']."' ).tooltip();
	                                       tooltips.tooltip( 'close' );
	                                     });
	                                     </script>";
							}
						}
					}
		
					$html .="<script>
 							  if(".$listeDate['date']." != ".$aujourdhui."){
                            	   $('#".$listeDate['date']."').toggle(false);
                        	  } else {
                            	   j = ".$i."; //la position de la date d aujourdhui dans le tableau
 				                }
		
 							 </script>";
					$html .="</table>";
					$i++;
				}
			//}
		
			$html .="<script> var tableau = ['']; var tableauDate = ['']; var indice=0; var position = j; encours = 1; var tableauHeures = ['']; </script>";
			//LISTE DES DATE EN TABLEAU JS
			$listeTouteDate = $this->getSoinHospitalisationTable()->getToutesDateDuSoinPourUneDate($id_sh, $aujourdhui);
			$lastDate = null;
			foreach ($listeTouteDate as $listeDate){
				$html .="<script> tableau[indice] = '".$listeDate['date']."'; </script>";
				$html .="<script> tableauDate[indice] = '".$this->controlDate->convertDate($listeDate['date'])."'; </script>";
				$html .="<script> tableauHeures[indice++] = '".$this->getLesHeuresDuSoin($id_sh, $listeDate['date'])."'; </script>";
				$lastDate = $listeDate['date'];
			}
				
			$html .="<script>
 					 if( j == 0 ){
 					     j = position = tableau.length-1;
 					     $('#'+tableau[j]).toggle(true);
 					     $('.laDateDesSoins').text(tableauDate[j]);
 					     encours = 0; // les date pour l appmication du soin sont depassees
 					     if(tableau[position] == '".$hier."') {
                   		    infoPlus = 'Hier - '+tableauDate[position];
                       	    $('.laDateDesSoins').text(infoPlus);
 		                 }else if(tableau[position] == '".$aujourdhui."') {
 					     	infoPlus = 'Aujourd\'hui - '+tableauDate[position];
                       	    $('.laDateDesSoins').text(infoPlus);
 					     }
 		                 		
 					     $('.lesHeuresRecAppDuSoin').html(tableauHeures[j]);
 		                 //Si la date est superieur a la date actuelle alors
 		                 if('".$dateAvenir."' > '".$aujourdhui."'){
 		                  	$('.lesHeuresRecAppDuSoin').html('".$lesHeures."');
 		                 }
 		             }
		
 					 var infoPlus;
 					 function gauche(){
                      $('.transfert_gauche').click(function(){ if(position > j) { position = j;}
 					    if(position > 0) {
		
 					      //Active licone suivant
 					      $('.transfert_droite2').replaceWith(
			                    '<img class=\'transfert_droite\' style=\'height: 14px; width: 18px; cursor:pointer;\' src=\'".$this->getPath()."/images_icons/transfert_droite.png\' >'
			                  );
 					      droite();
 					      $('#'+tableau[position]).fadeOut(function(){
			                    if(position > 0) { $('#'+tableau[position]).toggle(false); }
 					            $('#'+tableau[--position]).fadeIn();
 					            $('.lesHeuresRecAppDuSoin').html(tableauHeures[position]);
			          
			                    if(encours == 1){
			                      if(position == j){ infoPlus = 'Aujourd\'hui - '+tableauDate[position]; }
 					                else if(position == j-1) { infoPlus = 'Hier - '+tableauDate[position];}
 					                     else { infoPlus = tableauDate[position]; }
 					               $('.laDateDesSoins').text(infoPlus);
			                    }
			                    else if(encours == 0){
 		                       		      infoPlus = tableauDate[position];
			                       	      $('.laDateDesSoins').text(infoPlus);
 		                             }
 		                  });
		
			              if(position-1 == 0){
			                $('.transfert_gauche').replaceWith(
			                   '<img class=\'transfert_gauche2\' style=\'height: 14px; width: 18px;\' src=\'".$this->getPath()."/images_icons/transfert_gauche2.png\' >'
			                );
			              }
		
 					    }else {
			                   $('.transfert_gauche').replaceWith(
			                    '<img class=\'transfert_gauche2\' style=\'height: 14px; width: 18px;\' src=\'".$this->getPath()."/images_icons/transfert_gauche2.png\' >'
			                  );
			                   return false;
 		                 }
	                    stopPropagation();
		               });
			           return false;
	                 }
			          
			         function droite(){
	                   $('.transfert_droite').click(function(){ if(position < 0) { position = 0;}
	                    if(position <j) {
			          
			               //Active l icone precedent
			               $('.transfert_gauche2').replaceWith(
			                    '<img class=\'transfert_gauche\' style=\'height: 14px; width: 18px; cursor:pointer;\' src=\'".$this->getPath()."/images_icons/transfert_gauche.png\' >'
			                  );
			               gauche();
		
	                      $('#'+tableau[position]).fadeOut(function(){
			                    if(position < j ) { $('#'+tableau[position]).toggle(false); }
	                    		$('#'+tableau[++position]).fadeIn();
 					            $('.lesHeuresRecAppDuSoin').html(tableauHeures[position]);
			          
			                    if(encours == 1){
			                       if(position == j){ infoPlus = 'Aujourd\'hui - '+tableauDate[position]; }
                                     else if(position == j-1) { infoPlus = 'Hier - '+tableauDate[position];}
 					                      else { infoPlus = tableauDate[position]; }
 					               $('.laDateDesSoins').text(infoPlus);
			                    }
			         
			                    //Une fois les dates d application du soin sont depassees
			                    if(encours == 0){
			                       if(tableau[position] == '".$hier."') {
 		                       		  infoPlus = 'Hier - '+tableauDate[position];
			                       	  $('.laDateDesSoins').text(infoPlus);
 		                           } else{
			                       		infoPlus = tableauDate[position];
			                       	    $('.laDateDesSoins').text(infoPlus);
 		                             }
			                    }
 		                  });
			          
			              if(position+1 == j){
			                 $('.transfert_droite').replaceWith(
			                    '<img class=\'transfert_droite2\' style=\'height: 14px; width: 18px;\' src=\'".$this->getPath()."/images_icons/transfert_droite2.png\' >'
			                  );
			               }
 					    }else {
			                   $('.transfert_droite').replaceWith(
			                    '<img class=\'transfert_droite2\' style=\'height: 14px; width: 18px;\' src=\'".$this->getPath()."/images_icons/transfert_droite2.png\' >'
			                  );
			                   return false;
 		                 }
			          
	                    stopPropagation();
		               });
			           return false;
			          
			         }
			          
			         gauche();
			         droite();
 					 </script>";
		
		}
			
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function heureSuivanteAction() {
		$id_hosp = $this->params()->fromPost('id_hosp',0);
		$id_sh = $this->params()->fromPost('id_sh',0);
		$id_heure = $this->params()->fromPost('id_heure',0);
	
		$heureSuivante = $this->getSoinHospitalisation3Table()->getHeureSuivante($id_sh);
			
		$heureSuivPopup = null;
		if($heureSuivante){
			$heureSuivPopup = $heureSuivante['heure'];
		}
	
		$html = $heureSuivPopup;
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function applicationSoinAction() {
		$id_heure = $this->params()->fromPost('id_heure', 0);
		$id_sh = $this->params()->fromPost('id_sh', 0);
		$note = $this->params()->fromPost('note', 0);
	
		$user = $this->layout()->user;
		$id_personne = $user['id_personne']; //L'infirmier qui a appliqué le soin au patient
	
		$this->getSoinHospitalisation3Table()->saveHeureSoinAppliquer($id_heure, $id_sh, $note, $id_personne);
	
		$heureSuivante = $this->getSoinHospitalisation3Table()->getHeureSuivante($id_sh);
		if(!$heureSuivante){ //S'il n y avait aucune heure suivante On met Appliquer a 1 (dans la table soinHospitalisation3)
			$this->getSoinHospitalisation3Table()->appliquerSoin($id_sh);
		}
	
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode (  ) );
	}
	
	public function raffraichirListeAction() {
		$id_hosp = $this->params()->fromPost('id_hosp',0);
	
		$html = $this->listeSoinsAAppliquer($id_hosp);
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function detailInfoLiberationPatientAction() {
		$this->getDateHelper();
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$encours = $this->params()->fromPost('encours',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$id_demande_hospi = $this->params()->fromPost('id_demande_hospi',0);
	
		$demande = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdcons($id_cons);
	
		$unPatient = $this->getPatientTable()->getInfoPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
	
		$date = $this->controlDate->convertDate( $unPatient['DATE_NAISSANCE'] );
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE']. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		$html .= "<div id='titre_info_deces'>
				     <span id='titre_info_demande' style='margin-left:-5px; cursor:pointer;'>
				        <img src='".$chemin."/img/light/plus.png' /> D&eacute;tails des infos sur la demande
				     </span>
				  </div>
		          <div id='barre'></div>";
	
		$html .= "<div id='info_demande'>";
		$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
		$html .= "<tr style='width: 80%;'>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d'enregistrement:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($demande['date_demande_hospi']) . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date fin pr&eacute;vue:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDate($demande['date_fin_prevue_hospi']) . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$demande['PrenomMedecin'].' '.$demande['NomMedecin']. "</p></td>";
		$html .= "</tr>";
		$html .= "</table>";
	
		$html .="<table style='margin-top:0px; margin-left:18%; width: 70%;'>";
		$html .="<tr style='width: 70%'>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Motif de la demande:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>". $demande['motif_demande_hospi'] ."</p></td>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'> </p></td>";
		$html .="</tr>";
		$html .="</table>";
		$html .= "</div>";
	
		/***
		 * UTILISER UNIQUEMENT DANS LA VUE DE LA LISTE DES PATIENTS EN COURS D'HOSPITALISATION
		*/
		if($encours == 111) {
			$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
			$lit_hospitalisation = $this->getHospitalisationlitTable()->getHospitalisationlit($hospitalisation->id_hosp);
			$lit = $this->getLitTable()->getLit($lit_hospitalisation->id_materiel);
			$salle = $this->getSalleTable()->getSalle($lit->id_salle);
			$batiment = $this->getBatimentTable()->getBatiment($salle->id_batiment);
	
			$html .= "<div id='titre_info_deces'>
					   <span id='titre_info_hospitalisation' style='margin-left:-5px; cursor:pointer;'>
				          <img src='".$chemin."/img/light/plus.png' /> Infos sur l'hospitalisation
				       </span>
					  </div>
		              <div id='barre'></div>";
	
			$html .= "<div id='info_hospitalisation'>";
			$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d&eacute;but:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDate($demande['Datedemandehospi']) . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Batiment:</a><br><p style=' font-weight:bold; font-size:17px;'>".$batiment->intitule."</p></td>";
			$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Salle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$salle->numero_salle."</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lit:</a><br><p style=' font-weight:bold; font-size:17px;'>".$lit->intitule."</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
		}
	
		$html .= "<div id='titre_info_deces'>
				    <span id='titre_info_liste' style='margin-left:-5px; cursor:pointer;'>
				      <img src='".$chemin."/img/light/plus.png' /> Liste des soins
				    </span>
				  </div>
		          <div id='barre'></div>";
	
		$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
		$html .= "<div id='info_liste' style='margin-left: 18%; width: 80%;'>";
		$html .= $this->raffraichirListeSoins($hospitalisation->id_hosp);
		$html .= "</div>";
	
		$html .= "<div id='titre_info_deces'>
				   <span id='titre_info_liberation' style='margin-left:-5px; cursor:pointer;'>
				      <img src='".$chemin."/img/light/plus.png' /> Infos sur la lib&eacute;ration du patient
				   </span>
				  </div>
		          <div id='barre'></div>";
	
		
		
				
		
		//Pour les infos sur le transfert du patient hospitalisé
		//Pour les infos sur le transfert du patient hospitalisé
		//Pour les infos sur le transfert du patient hospitalisé
		$infoTransfert = $this->getTransfererPatientServiceTable()->getPatientMedecinDonnees($id_cons);
		
		//POUR LES MEDICAMENTS
		//POUR LES MEDICAMENTS
		//POUR LES MEDICAMENTS
		// INSTANTIATION DE L'ORDONNANCE
		$infoOrdonnance = $this->getOrdonnanceTable()->getOrdonnanceHospi($id_cons);
		
		if($infoOrdonnance) {
			$idOrdonnance = $infoOrdonnance->id_document;
			//LISTE DES MEDICAMENTS PRESCRITS
			$listeMedicamentsPrescrits = $this->getOrdonnanceTable()->getMedicamentsParIdOrdonnance($idOrdonnance);
			$nbMedPrescrit = $listeMedicamentsPrescrits->count();
		}else{
			$nbMedPrescrit = 0;
			$listeMedicamentsPrescrits = null;
		}
		
		//------------------------------------------------------
		//------------------------------------------------------
		//------------------------------------------------------
		$html .= "<div id='info_liberation'>";
		$html .= "<table style='margin-top:0px; margin-left:18%; width: 80%;'>";
		$html .= "<tr style='width: 80%'>";
		
		$popupOrdonnace = "";
		
		if($infoTransfert){
			
			$html .= "<td style='padding-top: 10px; width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:14px;'>Date du transfert:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($hospitalisation->date_fin) . "</p></td>";
			$html .= "<td style='padding-top: 10px; width: 32%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:14px;'>Pr&eacute;nom & nom du m&eacute;decin:</a><br><p style='font-weight:bold; font-size:17px;'>".$infoTransfert['PrenomMedecin']." ".$infoTransfert['NomMedecin']."</p></td>";
			$html .= "<td style='padding-top: 10px; width: 43%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:14px;'>Service d'accueil:</a><br><p style='font-weight:bold; font-size:17px;'>".$infoTransfert['NomService']."</p></td>";
		
		} else {
				
			if($infoOrdonnance){
				$popupOrdonnace = "<div style='padding-top: 10px; height: 50px;'><img id='afficherOrdonnance' style='cursor:pointer;' src='".$chemin."/images_icons/clipboard_32.png' /> <span style='font-weight:bold; font-size:17px; font-family: Times  New Roman; color: #065d10;'> Ordonnance </span></div>";
			}
		
		}
		
		$html .= "</tr>";
		$html .= "</table>";

		
		
		
		
		$html .= "<table style='margin-top:0px; margin-left:18%; width: 80%;'>";
		$html .= "<tr style='width: 80%'>";
		$html .= "<td style='padding-top: 10px; width: 10%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:14px;'>Date de la lib&eacute;ration:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($hospitalisation->date_fin) . "</p> <p>".$popupOrdonnace."</p></td>";
		$html .= "<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:14px;'>R&eacute;sum&eacute; m&eacute;dical:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>".$hospitalisation->resumer_medical."</p></td>";
		$html .= "<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:14px;'>Motif sortie:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>".$hospitalisation->motif_sorti."</p></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
	
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$chemin."/images_icons/fleur1.jpg' />
                     </div>";
			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminerdetailhospi'>Terminer</button></div>
                     </div>";
		}
	
		$html .="<script>
				  listepatient();
				  initAnimation();
				  animationPliantDepliant();
				  animationPliantDepliant2();
				  animationPliantDepliant3();
		          animationPliantDepliant4();
				
				  $('#nbMedecamentPourVisualisation').val(".$nbMedPrescrit.");
				  var ik = 1;
				 </script>";
		//Remplissage automatique des champs
		if($nbMedPrescrit != 0) {
			foreach($listeMedicamentsPrescrits as $Medicaments){
				$html .="<script> setTimeout(function(){ $('#medicament_0'+ik).val('".$Medicaments['Intitule']."'); }, 2000);  </script>";
				$html .="<script> setTimeout(function(){ $('#forme_'+ik).val('".$Medicaments['FORME']."'); }, 2000);</script>";
				$html .="<script> setTimeout(function(){ $('#nb_medicament_'+ik).val('".substr($Medicaments['QUANTITE'], 0, strpos($Medicaments['QUANTITE'], ' '))."'); }, 2000);  </script>";
				$html .="<script> setTimeout(function(){ $('#quantite_'+ik).val('".substr($Medicaments['QUANTITE'], strpos($Medicaments['QUANTITE'], ' ')+1)."'); ik++; }, 2000);  </script>";
			}
			 
			$html .="<script>
		   			  setTimeout(function(){
		   		        $('#listeMedicaments input, .form-duree_ input, .ordonnance input').attr('disabled', true).css({'background':'#f8f8f8'});
		   		        $('#controls_medicament div').toggle(false);
		   		        $('#iconeMedicament_supp_vider a img').toggle(false);
	                    $('#bouton_Medicament_modifier_demande').toggle(false);
	                    $('#bouton_Medicament_valider_demande').toggle(false);
	                    $('#increm_decrem img').toggle(false);
		              }, 2000);
		   		    </script>";
		}
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	
	}
	
	public function listeDemandeHospiAjaxAction() {
		$output = $this->getDemandeHospitalisationTable()->getListeDemandeHospitalisation();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
			'enableJsonExprFinder' => true	) ) );
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    public function HospitaliserAction() {
		$this->layout()->setTemplate('layout/archivage');
		
		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
		
		$user = $this->layout()->user;
		$id_medecin = $user->id_personne;
		
 		$formSoin = new SoinForm();
		
		$transferer = $this->getTransfererPatientServiceTable ();
		$hopital = $transferer->fetchHopital ();
		$formSoin->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		//RECUPERATION DE L'HOPITAL DU SERVICE
		$transfertPatientHopital = $transferer->getHopitalPatientTransfert($IdDuService);
		$idHopital = $transfertPatientHopital['ID_HOPITAL'];
		//RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
		$serviceHopital = $transferer->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
		//LISTE DES SERVICES DE L'HOPITAL
		$formSoin->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
		
		$data = array (
				'hopital_accueil' => $idHopital,
		);
		
		$formSoin->populateValues($data);
		if($this->getRequest()->isPost()) {

			$data = $this->getRequest()->getPost();
			
		    $id_sh = $this->getSoinHospitalisation4Table()->saveSoinhospitalisation($data, $id_medecin);
		    $this->getSoinHospitalisation4Table()->saveHeure($data,$id_sh);
			//$test = 'En cours de dÃ©veloppement';
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		    return $this->getResponse ()->setContent ( Json::encode () );
		}
		
		$listeMedicament = $this->getConsommableTable()->listeDeTousLesMedicaments();
		
		return array(
				'form' => $formSoin,
				'liste_med' => $listeMedicament,
		);
	}
	
	public function getPath(){
		$this->path = $this->getServiceLocator()->get('Request')->getBasePath();
		return $this->path;
	}
	
	public function raffraichirListeSoins($id_hosp){
	
		$liste_soins = $this->getSoinHospitalisationTable()->getAllSoinhospitalisation($id_hosp);
		$html = "";
		$this->getDateHelper();
			
		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; width:100%;' id='listeSoin'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer;'>
					<th style='width: 23%;'>M&eacute;dicament</th>
					<th style='width: 21%;'>Voie d'administration</th>
					<th style='width: 19%;'>Dosage <span style='font-weight: normal;'>X</span> Fr&eacute;quence</th>
					<th style='width: 19%;'>Heure suivante</th>
				    <th style='width: 12%;'>Options</th>
				    <th style='width: 6%;'>Etat</th>
				  </tr>
			     </thead>";
			
		$html .="<tbody style='width: 100%;'>";
	
		rsort($liste_soins);
 		foreach ($liste_soins as $cle => $Liste){
			//Récupération de l'heure suivante pour l'application du soin par l'infirmier
			$heureSuivante = $this->getSoinHospitalisationTable()->getHeureSuivante($Liste['id_sh']);
	
			$heureSuiv = null;
			if($heureSuivante){
				$heureSuiv = "<span style='color: red; font-weight: bold; font-size: 20px;'>".$heureSuivante['heure']."</span>";
			}
				
				
			$html .="<tr style='width: 100%;' id='".$Liste['id_sh']."'>";
			$html .="<td style='width: 23%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['medicament']."</div></td>";
			$html .="<td style='width: 21%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['voie_administration']."</div></td>";
 			$html .="<td style='width: 19%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['dosage']." <span style='font-weight: normal; font-family: arial; color: green; font-size: 13px;'>X</span> ".$Liste['frequence']."</div></td>";
	
			if($heureSuiv == null){
				$html .="<td style='width: 18%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>Termin&eacute; </div></td>";
			}else{
				$html .="<td id='clignoterHeure".$Liste['id_sh']."' style='width: 18%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$heureSuiv."</div></td>";
			}
				
			if($Liste['appliquer'] == 0) {
				$html .="<td style='width: 12%;'> <a href='javascript:vuesoin(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='../images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
					  </a>&nbsp";
	
				//Si au moin pour une heure un soin a ete applique impossible de Supprimer le soin
				$ListeHeureSoinApplique = $this->getSoinHospitalisationTable()->getHeureAppliquer($Liste['id_sh']);
				if($ListeHeureSoinApplique != 0){
					$html .="<span>
					    	  <img style='color: white; opacity: 0.15;' src='../images_icons/modifier.png'/>
					         </span>&nbsp;";
					$html .="<span> <img  style='color: white; opacity: 0.15;' src='../images_icons/sup.png' /> </span>
				             </td>";
				} else {
					$html .="<a href='javascript:modifiersoin(".$Liste['id_sh'].",".$Liste['id_hosp'].")'>
					    	  <img class='modifier".$Liste['id_sh']."'  src='../images_icons/modifier.png' alt='Constantes' title='modifier'/>
					         </a>&nbsp;";
					$html .="<a href='javascript:supprimersoin(".$Liste['id_sh'].",".$Liste['id_hosp'].")'>
					    	  <img class='supprimer".$Liste['id_sh']."'  src='../images_icons/sup.png' alt='Constantes' title='annuler' />
					         </a>
				             </td>";
				}
				 
	
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_oui".$Liste['id_sh']."' style='margin-left: 20%;' src='../images_icons/non.png' alt='Constantes' title='soin non encore appliqu&eacute;' />
					     &nbsp;
				         </td>";
			}else {
	
				$html .="<td style='width: 12%;'> <a href='javascript:vuesoinApp(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='../images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
					  </a>&nbsp";
	
				$html .="<a>
					    	<img class='modifier".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='../images_icons/modifier.png' alt='Constantes'/>
					     </a>&nbsp;
	
				         <a >
					    	<img class='supprimer".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='../images_icons/sup.png' alt='Constantes'/>
					     </a>
				         </td>";
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_non".$Liste['id_sh']."' style='margin-left: 20%;' src='../images_icons/oui.png' alt='Constantes' title='soin d&eacute;ja appliqu&eacute;' />
					     &nbsp;
				         </td>";
	
			}
	
			$html .="</tr>";
	
			$html .="<script>
					  $('.visualiser".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.visualiser".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.visualiser".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.visualiser".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /************************/
	                  /************************/
	                  /************************/
                      $('.modifier".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.modifier".$Liste['id_sh']." ' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
				      $('.modifier".$Liste['id_sh']." ').mouseleave(function(){
	                    var tooltips = $( '.modifier".$Liste['id_sh']." ' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.supprimer".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.supprimer".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.supprimer".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.supprimer".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_oui".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_oui".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_oui".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.etat_oui".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_non".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_non".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_non".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.etat_non".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
			        </script>";
				
 		}
		$html .="</tbody>";
		$html .="</table>";
	
		$html .="<style>
				  #listeDataTable{
	                /*margin-left: 185px;*/
                  }
	
				  div .dataTables_paginate
                  {
				    /*margin-right: 20px;*/
                  }
	
				  #listeSoin tbody tr{
				    background: #fbfbfb;
				  }
	
				  #listeSoin tbody tr:hover{
				    background: #fefefe;
				  }
				 </style>";
		$html .="<script> listepatient (); listeDesSoins(); </script>";
	
		return $html;
	
	}
	
	public function listeSoinAction() {
		$id_hosp = $this->params()->fromPost('id_hosp', 0);
	
		$html = "<div id='titre_info_admis'>Liste des soins</div>
		          <div id='barre_admis'></div>";
		$html .= $this->raffraichirListeSoins($id_hosp);
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function supprimerSoinAction() {
		$id_sh = $this->params()->fromPost('id_sh', 0);
		$this->getSoinHospitalisationTable()->supprimerHospitalisation($id_sh);
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode () );
	}
	
	public function modifierSoinAction() {

		$id_sh = $this->params()->fromPost('id_sh', 0);
		
		$this->getDateHelper();
		$soin = $this->getSoinHospitalisationTable()->getSoinhospitalisationWithId_sh($id_sh);
		$heure = $this->getSoinHospitalisationTable()->getHeuresGroup($id_sh);
		
		$lesHeures = "";
		if($heure){
			for ($i = 0; $i<count($heure); $i++){
			if($i == count($heure)-1) {
					$lesHeures.= $heure[$i];
				} else {
					$lesHeures.= $heure[$i].'  -  ';
				}
			}
		}
		
		$form = new SoinmodificationForm();
		if($soin){
				
			$data = array(
					'medicament_m' => $soin->medicament,
 					'voie_administration_m' => $soin->voie_administration,
					'frequence_m' => $soin->frequence,
					'dosage_m' => $soin->dosage,
 					'date_application_m' => $this->controlDate->convertDate($soin->date_debut_application),
					'motif_m' => $soin->motif,
					'note_m' => $soin->note,
					'duree_m' => $soin->duree,
			);
				
			$form->populateValues($data);
		}
		
		$formRow = new FormRow();
		$formText = new FormText();
		$formSelect = new FormSelect();
		$formTextArea = new FormTextarea();
		
		$listeMedicament = $this->getConsommableTable()->listeDeTousLesMedicaments();
		
		$html ="<table id='form_patient' style='width: 100%;'>
		
		           <tr class='comment-form-patient' style='width: 100%;'>
		             <td style='width: 25%;'> ".$formRow($form->get('medicament_m')).$formText($form->get('medicament_m'))."</td>
		             <td style='width: 25%;'>".$formRow($form->get('voie_administration_m')).$formText($form->get('voie_administration_m'))."</td>
		             <td style='width: 25%;'>".$formRow($form->get('frequence_m')).$formText($form->get('frequence_m'))."</td>
		             <td style='width: 25%;'>".$formRow($form->get('dosage_m')).$formText($form->get('dosage_m'))."</td>
		           </tr>
		             		
		           <tr class='comment-form-patient' style='width: 100%;'>
		             <td style='width: 25%;'> ".$formRow($form->get('date_application_m')).$formText($form->get('date_application_m'))."</td>
		             <td style='width: 25%;'> ".$formRow($form->get('duree_m')).$formText($form->get('duree_m'))."</td>
             		 <td colspan='2' style='width: 25%;'>".$formRow($form->get('heure_recommandee_m')).$formText($form->get('heure_recommandee_m'))."</td>
		           </tr>
		         </table>
		
		         <table id='form_patient' style='width: 100%;'>
		           <tr class='comment-form-patient'>
		             <td id='note_soin' style='width: 40%; '>". $formRow($form->get('motif_m')).$formTextArea($form->get('motif_m'))."</td>
		             <td id='note_soin' style='width: 40%; '>". $formRow($form->get('note_m')).$formTextArea($form->get('note_m'))."</td>
		             <td  style='width: 10%;' id='ajouter'></td>
		             <td  style='width: 10%;'></td>
		           </tr>
		         </table>";
		$html .="<script>
				    //$('#medicament_m, #voie_administration_m, #frequence_m, #dosage_m, #date_application_m, #heure_recommandee_m, #motif_m, #note_m').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'18px'});
				    $('#duree_m, #heure_recommandee_m').attr('disabled', true).css({'background':'f9f9f9'});
				    $('#heure_recommandee_m').val('".$lesHeures."');
				    $(function() {
    	              $('.SlectBox_m').SumoSelect({ csvDispCount: 6 });
				    });
				    var myArrayMedicament = [''];
			        var j = 0;";
                foreach($listeMedicament as $Liste) {
                	$html .="myArrayMedicament[j++] = '". $Liste['INTITULE']."';"; 
                }
		$html .=" $('#medicament_m' ).autocomplete({
    		         source: myArrayMedicament
                     });
				     listepatient();
				 </script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	//=================================================================================================
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//=================================================================================================
	protected $formPatient;
	public function getForm() {
		if (! $this->formPatient) {
			$this->formPatient = new PatientForm ();
		}
		return $this->formPatient;
	}
	public function baseUrl(){
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
		return $tabURI[0];
	}
	
	public function convertDate($date) {
		$nouv_date = substr ( $date, 8, 2 ) . '/' . substr ( $date, 5, 2 ) . '/' . substr ( $date, 0, 4 );
		return $nouv_date;
	}
	
	public function ajouterAction() { 
		$this->layout ()->setTemplate ( 'layout/Archivage' );
		$form = $this->getForm ();
		$patientTable = $this->getPatientTable();
		$form->get('nationalite_origine')->setvalueOptions($patientTable->listeDeTousLesPays());
		$form->get('nationalite_actuelle')->setvalueOptions($patientTable->listeDeTousLesPays());
		$data = array('nationalite_origine' => 'SÃ©nÃ©gal', 'nationalite_actuelle' => 'SÃ©nÃ©gal');
	
		$form->populateValues($data);
	
		return new ViewModel ( array (
				'form' => $form
		) );
	}
	
	public function enregistrementAction() {
	
		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connecté
		
		// CHARGEMENT DE LA PHOTO ET ENREGISTREMENT DES DONNEES
		if (isset ( $_POST ['terminer'] ))  //si formulaire soumis
		{
			$Control = new DateHelper();
			$form = new PatientForm ();
			$Patient = $this->getPatientTable ();
			$today = new \DateTime ( 'now' );
			$nomfile = $today->format ( 'dmy_His' );
			$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
			$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
			$fileBase64 = substr ( $fileBase64, 23 );
				
			if($fileBase64){
				$img = imagecreatefromstring(base64_decode($fileBase64));
			}else {
				$img = false;
			}
	
			$donnees = array(
					'LIEU_NAISSANCE' => $this->params ()->fromPost ( 'lieu_naissance' ),
					'EMAIL' => $this->params ()->fromPost ( 'email' ),
					'NOM' => $this->params ()->fromPost ( 'nom' ),
					'TELEPHONE' => $this->params ()->fromPost ( 'telephone' ),
					'NATIONALITE_ORIGINE' => $this->params ()->fromPost ( 'nationalite_origine' ),
					'PRENOM' => $this->params ()->fromPost ( 'prenom' ),
					'PROFESSION' => $this->params ()->fromPost ( 'profession' ),
					'NATIONALITE_ACTUELLE' => $this->params ()->fromPost ( 'nationalite_actuelle' ),
					'DATE_NAISSANCE' => $Control->convertDateInAnglais($this->params ()->fromPost ( 'date_naissance' )),
					'ADRESSE' => $this->params ()->fromPost ( 'adresse' ),
					'SEXE' => $this->params ()->fromPost ( 'sexe' ),
   			        'AGE' => $this->params ()->fromPost ( 'age' ),
			);

			if ($img != false) {
	
				$donnees['PHOTO'] = $nomfile;
				//ENREGISTREMENT DE LA PHOTO
				imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
				//ENREGISTREMENT DES DONNEES
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
					
				return $this->redirect ()->toRoute ( 'archivage', array (
						'action' => 'liste-dossiers-patients'
				) );
			} else {
				// On enregistre sans la photo
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
				return $this->redirect ()->toRoute ( 'archivage', array (
						'action' => 'liste-dossiers-patients'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'archivage', array (
						'action' => 'liste-dossiers-patients'
				) );
	}
	
	public function listePatientAjaxAction() {
		$output = $this->getPatientTable ()->getListePatient ();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listeDossiersPatientsAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/archivage' );
		$view = new ViewModel ();
		return $view;
	}
	
	public function infoDossierPatientAction() {
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$id_pat = $this->params ()->fromRoute ( 'val', 0 );

		$unPatient = $this->getPatientTable ()->getInfoPatient ( $id_pat );
		
		return array (
				'lesdetails' => $unPatient,
				'image' => $this->getPatientTable ()->getPhoto ( $id_pat ),
				'id_cons' => $unPatient['ID_PERSONNE'],
				'heure_cons' => $unPatient['DATE_ENREGISTREMENT']
		);
	}
	
	public function modifierAction() {
		$control = new DateHelper();
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$id_patient = $this->params ()->fromRoute ( 'val', 0 );
	
		try {
			$info = $this->getPatientTable ()->getInfoPatient ( $id_patient );
			$info['nom'] = $info['NOM'];
			$info['prenom'] = $info['PRENOM'];
			$info['adresse'] = $info['ADRESSE'];
			$info['lieu_naissance'] = $info['LIEU_NAISSANCE'];
			$info['telephone'] = $info['TELEPHONE'];
			$info['profession'] = $info['PROFESSION'];
			$info['sexe'] = $info['SEXE'];
			$info['email'] = $info['EMAIL'];
			$info['nationalite_origine'] = $info['NATIONALITE_ORIGINE'];
			$info['nationalite_actuelle'] = $info['NATIONALITE_ACTUELLE'];
			$info['id_personne'] = $info['ID_PERSONNE'];
			$info['age'] = $info['AGE'];
		} catch ( \Exception $ex ) {
			return $this->redirect ()->toRoute ( 'facturation', array (
					'action' => 'liste-patient'
			) );
		}
		
		$form = new PatientForm ();
		$form->get('nationalite_origine')->setvalueOptions($this->getPatientTable ()->listeDeTousLesPays());
		$form->get('nationalite_actuelle')->setvalueOptions($this->getPatientTable ()->listeDeTousLesPays());
		$info['date_naissance'] = $control->convertDate($info['DATE_NAISSANCE']); 
	
		$form->populateValues ( $info );
		if (! $info['PHOTO']) {
			$info['PHOTO'] = "identite";
		}
		return array (
				'form' => $form,
				'photo' => $info['PHOTO']
		);
	}
	
	public function enregistrementModificationAction() {

		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connecté
		
		if (isset ( $_POST ['terminer'] ))
		{
			$Control = new DateHelper();
			$Patient = $this->getPatientTable ();
			$today = new \DateTime ( 'now' );
			$nomfile = $today->format ( 'dmy_His' );
			$date_modification = $today->format ( 'Y-m-d H:i:s' );
			$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
			$fileBase64 = substr ( $fileBase64, 23 );
		
			if($fileBase64){
				$img = imagecreatefromstring(base64_decode($fileBase64));
			}else {
				$img = false;
			}
		
			$donnees = array(
					'LIEU_NAISSANCE' => $this->params ()->fromPost ( 'lieu_naissance' ),
					'EMAIL' => $this->params ()->fromPost ( 'email' ),
					'NOM' => $this->params ()->fromPost ( 'nom' ),
					'TELEPHONE' => $this->params ()->fromPost ( 'telephone' ),
					'NATIONALITE_ORIGINE' => $this->params ()->fromPost ( 'nationalite_origine' ),
					'PRENOM' => $this->params ()->fromPost ( 'prenom' ),
					'PROFESSION' => $this->params ()->fromPost ( 'profession' ),
					'NATIONALITE_ACTUELLE' => $this->params ()->fromPost ( 'nationalite_actuelle' ),
					'DATE_NAISSANCE' => $Control->convertDateInAnglais($this->params ()->fromPost ( 'date_naissance' )),
					'ADRESSE' => $this->params ()->fromPost ( 'adresse' ),
					'SEXE' => $this->params ()->fromPost ( 'sexe' ),
		 	        'AGE' => $this->params ()->fromPost ( 'age' ),
			);
		
			$id_patient =  $this->params ()->fromPost ( 'id_personne' );
			
			if ($img != false) {
		
				$lePatient = $Patient->getInfoPatient ( $id_patient );
				$ancienneImage = $lePatient['PHOTO'];
		
				if($ancienneImage) {
					unlink ( 'C:\wamp\www\simens\public\img\photos_patients\\' . $ancienneImage . '.jpg' );
				}
				imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
		
				$donnees['PHOTO'] = $nomfile;
				$Patient->updatePatient ( $donnees , $id_patient, $date_modification, $id_employe);
		
				return $this->redirect ()->toRoute ( 'archivage', array (
						'action' => 'liste-dossiers-patients'
				) );
			} else {
				$Patient->updatePatient($donnees, $id_patient, $date_modification, $id_employe);
				return $this->redirect ()->toRoute ( 'archivage', array (
						'action' => 'liste-dossiers-patients'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'archivage', array (
						'action' => 'liste-dossiers-patients'
				) );
	}
	
	public function creerNumeroFacturation($numero) {
		$nbCharNum = 10 - strlen($numero);
	
		$chaine ="";
		for ($i=1 ; $i <= $nbCharNum ; $i++){
			$chaine .= '0';
		}
		$chaine .= $numero;
	
		return $chaine;
	}
	
	public function numeroFacture() {
		$lastAdmission = $this->getAdmissionTable()->getLastAdmission();
		return $this->creerNumeroFacturation($lastAdmission['id_admission']+1);
	}
	
	public function admissionAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/archivage' );
		
		// INSTANCIATION DU FORMULAIRE d'ADMISSION
		$formAdmission = new AdmissionForm ();
		// rï¿½cupï¿½ration de la liste des hopitaux
		$service = $this->getTarifConsultationTable()->listeService();
	
		$listeService = $this->getServiceTable ()->listeService ();
		$afficheTous = array ("" => 'Tous');
	
		$tab_service = array_merge ( $afficheTous, $listeService );
		$formAdmission->get ( 'service' )->setValueOptions ( $service );
		$formAdmission->get ( 'liste_service' )->setValueOptions ( $tab_service );
	
		if ($this->getRequest ()->isPost ()) {
			$user = $this->layout()->user;
			$id_service = $user['IdService'];
			
			$service = $this->getServiceTable()->getServiceparId($id_service);
			
			$today = new \DateTime ();
			$numero = $this->numeroFacture();//$today->format ( 'mHis' );
			
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			$pat = $this->getPatientTable ();
			
			$unPatient = $pat->getInfoPatient( $id );
			$photo = $pat->getPhoto ( $id );

			$date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] );

			$html  = "<div style='width:100%;'>";
			
			$html .= "<div style='width: 18%; height: 190px; float:left;'>";
			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
			$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
			$html .= "</div>";
			
			$html .= "<div style='width: 67%; height: 200px; float:left;'>";
			$html .= "<table style='margin-top:10px; width: 100%;'>";
			$html .= "<tr style='width: 100%;'>";
			$html .= "<td style='width: 19%; height: 50px; vertical-align: top; '><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 90%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></div></td>";
			$html .= "<td style='width: 29%; height: 50px; vertical-align: top; '><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 90%; max-width: 230px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
			$html .= "<td style='width: 23%; height: 50px; vertical-align: top; '><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 90%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
			$html .= "<td style='width: 29%; height: 50px;'></td>";
			$html .= "</tr>";
					
			$html .= "<tr style='width: 100%;'>";
			$html .= "<td style='height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 90%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
			$html .= "<td style='height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 90%; max-width: 230px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
			$html .= "<td style='height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 90%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></div></td>";
			$html .= "<td style='height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 90%; '><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
			$html .= "</tr>";
			
			$html .= "<tr style='width: 100%;'>";
			$html .= "<td style='height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 90%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></div></td>";
			$html .= "<td style='height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 90%; max-width: 235px; height:50px; overflow:auto; margin-bottom: 5px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></div></td>";
			$html .= "<td style='height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><div style='width: 90%; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></div></td>";
			$html .= "<td style='height: 50px;'>";
			$html .="</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .="</div>";
			
			$html .= "<div style='width: 15%; height: 190px; float:left;'>";
			$html .= "<div style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
			
			$html .= "</div>";
			
			$html .= "<script>
					         $('#numero').val('" . $numero . "');
					         /*$('#numero').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});*/
					         /*$('#numero').attr('readonly',true);*/

					         $('#service').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'14px'});
					         $('#service').val(" . $id_service . ");
					         //$('#service').attr('disabled',true);
					         		
					         $('#numero, #date').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});

					         $('#montant').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'blue','font-family': 'Times  New Roman','font-size':'22px'});
					         $('#montant').attr('readonly',true);
					         $('#montant').val(" . $service['TARIF'] . ");
					        
					 </script>";

			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
		return array (
				'form' => $formAdmission
		);
	}
	
	public function listeAdmissionAjaxAction() {
		$output = $this->getPatientTable ()->laListePatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	
	public function popupVisualisationAction() {
		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
	
			$unPatient = $this->getPatientTable ()->getInfoPatient( $id );
			$photo = $this->getPatientTable ()->getPhoto ( $id );
			$date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] );
			
			$html = "<div id='photo' style='float:left; margin-right:20px;'> <img  src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'  style='width:105px; height:105px;'></div>";
	
			$html .= "<table>";
	
			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
			$html .= "</tr>";
	
			$html .= "</table>";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
	}
	
	
	public function montantAction() {
		if ($this->getRequest ()->isPost ()) {
	
			$id_service = ( int ) $this->params ()->fromPost ( 'id', 0 );
	
			$tarif = $this->getTarifConsultationTable ()->TarifDuService ( $id_service );
	
			if ($tarif) {
				$montant = $tarif['TARIF'] . ' frs';
			} else {
				$montant = '';
			}
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $montant ) );
		}
	}
	
	
	public function enregistrerAdmissionAction() {

		$user = $this->layout()->user;
		$id_employe = $user['id_personne'];
		
		if ($this->getRequest ()->isPost ()) {
			$today = new \DateTime ( "now" );
			$date = $today->format ( 'Y-m-d' );
			$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		
			$id_patient = ( int ) $this->params ()->fromPost ( 'id_patient', 0 ); // id du patient
		
			$this->getDateHelper();
			
			$numero = $this->params ()->fromPost ( 'numero' );
			$id_service = $this->params ()->fromPost ( 'service' );
			$montant = $this->params ()->fromPost ( 'montant' );
			$date_cons = $this->controlDate->convertDateInAnglais($this->params ()->fromPost ( 'date' ));
		
			$donnees = array (
					'id_patient' => $id_patient,
					'id_service' => $id_service,
					'date_cons' => $date_cons,
					'montant' => $montant,
					'numero' => $numero,
					'date_enregistrement' => $date_enregistrement,
					'id_employe' => $id_employe,
					'archivage' => 1
			);
		
			$this->getAdmissionTable ()->addAdmission ( $donnees );
		
			return $this->redirect()->toRoute('archivage', array(
					'action' =>'liste-admission'));
		}
	}
	
	public function listeAdmissionAction() {
		$this->layout ()->setTemplate ( 'layout/archivage' );
		// INSTANCIATION DU FORMULAIRE
		$formAdmission = new AdmissionForm ();
		$service = $this->getServiceTable ()->fetchService ();
		$listeService = $this->getServiceTable ()->listeService ();

		$afficheTous = array (
				"" => 'Tous'
		);
		$tab_service = array_merge ( $afficheTous, $listeService );
		$formAdmission->get ( 'service' )->setValueOptions ( $service );
		$formAdmission->get ( 'liste_service' )->setValueOptions ( $tab_service );
		
		return new ViewModel ( array (
				'listePatientsAdmis' => $this->getAdmissionTable ()->getPatientsAdmis (),
				'form' => $formAdmission,
		) );
	}
	
	
	public function vuePatientAdmisAction(){
		$this->getDateHelper();
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id = (int)$this->params()->fromPost ('id');
		$idAdmission = (int)$this->params()->fromPost ('idAdmission');
		
		$unPatient = $this->getPatientTable()->getInfoPatient($id);
		$photo = $this->getPatientTable()->getPhoto($id);
	
		//Informations sur l'admission
		$InfoAdmis = $this->getAdmissionTable()->getPatientAdmis($idAdmission);
	
		//Verifier si le patient a un rendez-vous et si oui dans quel service et a quel heure
		$today = new \DateTime ();
		$dateAujourdhui = $today->format( 'Y-m-d' );
		$pat = $this->getPatientTable ();
		$RendezVOUS = $this->getPatientTable ()->verifierRV($id, $dateAujourdhui);
	
		//Recuperer le service
		$service = $this->getServiceTable();
		$InfoService = $service->getServiceAffectation($InfoAdmis->id_service);
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 70%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left'>";
		$html .= "<tr>";
		$html .= "<td style='width: 19%;' ><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 90%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></div></td>";
		$html .= "<td style='width: 29%;' ><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 90%; max-width: 235px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='width: 23%;' ><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><div style='width: 90%; '><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
		$html .= "<td style='width: 29%;' ></td>";
		$html .= "</tr><tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 90%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 90%; max-width: 235px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 90%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></div></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 90%;'><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
		$html .= "</tr><tr>";
		$html .= "<td style=' vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 90%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDate($unPatient['DATE_NAISSANCE']) . "</p></div></td>";
		$html .= "<td style=' vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 90%; max-width: 235px; height:50px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></div></td>";
		$html .= "<td style=' vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><div style='width: 90%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PROFESSION'] . "</p></div></td>";
		$html .= "<td style=' '>";
	
		if($RendezVOUS){
			$html .= "<span> <i style='color:green;'>
					        <span id='image-neon' style='color:red; font-weight:bold;'>Rendez-vous! </span> <br>
					        <span style='font-size: 16px;'>Service:</span> <span style='font-size: 16px; font-weight:bold;'> ". $this->getPatientTable ()->getServiceParId($RendezVOUS[ 'ID_SERVICE' ])[ 'NOM' ]." </span> <br>
					        <span style='font-size: 16px;'>Heure:</span>  <span style='font-size: 16px; font-weight:bold;'>". $RendezVOUS[ 'heure' ]." </span> </i>
			              </span>";
		}
		$html .= "</td'>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 12%; height: 180px; float:left; '>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:10px; margin-left:5px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		$html .="<div id='titre_info_admis'>Informations sur l'admission</div>";
		$html .="<div id='barre_separateur'></div>";
	
		$html .="<table style='margin-top:10px; margin-left:18%; width: 80%;'>";
	
		$html .="<tr style='width: 80%;'>";
		$html .= "<td style='width: 25%;' ><a style='text-decoration:underline; font-size:12px;'>Date d'enregistrement:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime( $InfoAdmis->date_enregistrement ) . "</p></td>";
		$html .= "<td style='width: 25%;'><a style='text-decoration:underline; font-size:12px;'>Date consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->convertDate($InfoAdmis->date_cons) . "</p></td>";
		$html .= "<td style='width: 25%;'><a style='text-decoration:underline; font-size:12px;'>Frais consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $InfoAdmis->montant . "</p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'></td>";
		$html .="</tr>";
	
		$html .="<tr style='width: 80%;'>";
		$html .= "<td style='width: 25%;'><a style='text-decoration:underline; font-size:12px;'>Num&eacute;ro facture:</a><br><p style='font-weight:bold; font-size:17px;'>" . $InfoAdmis->numero . "</p></td>";
		$html .= "<td style='width: 25%;'><a style='text-decoration:underline; font-size:12px;'>Service:</a><br><p style='font-weight:bold; font-size:17px;'>" . $InfoService->nom . "</p></td>";
		$html .="</tr>";
		
		$html .="</table>";
		$html .="<table style='margin-top:10px; margin-left:18%; width: 80%;'>";
		$html .="<tr style='width: 80%;'>";
	
		$html .="<td class='block' id='thoughtbot' style='width: 35%;  vertical-align: bottom; padding-left:350px; padding-bottom: 15px; padding-top: 30px; padding-right: 150px;'><button type='submit' id='terminer'>Terminer</button></td>";
	
		$html .="</tr>";
		$html .="</table>";
	
		$html .="<div style='color: white; opacity: 1; margin-top: -100px; margin-right:20px; width:95px; height:40px; float:right'>
                          <img  src='".$chemin."/images_icons/fleur1.jpg' />
                     </div>";
	
		$html .="<script>listepatient();
				  function FaireClignoterImage (){
                    $('#image-neon').fadeOut(900).delay(300).fadeIn(800);
                  }
                  setInterval('FaireClignoterImage()',2200);
				 </script>";
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode($html));
	
	}
	
	public function supprimerAdmissionAction(){
		if ($this->getRequest()->isPost()){
			$id = (int)$this->params()->fromPost ('id');
			$this->getAdmissionTable()->deleteAdmissionPatient($id);
	
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse()->setContent(Json::encode());
		}
	}
	
	
	//=================================================================================================
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//**** RADIOLOGIE ----- RADIOLOGIE ----- RADIOLOGIE ****
	//=================================================================================================
	
	public function listeResultatsRadiologieAction() {
		$this->layout()->setTemplate('layout/archivage');
	
		//$demande = $this->getDemandeTable()->getDemandeWithIdcons('arch_264_10');
		
		//var_dump($demande); exit();
		$formAppliquerExamen = new AppliquerExamenForm();
	
		return array(
				'form' => $formAppliquerExamen
		);
	}
	//POUR LA LISTE DES EXAMENS DEJA EFFECTUES PAR LE RADIOLOGUE
	public function listeRechercheExamensEffectuesMorphoAjaxAction() {
		$output = $this->getDemandeTable()->getListeExamensMorphoEffectues();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	Public function listeExamensDemanderMorphoAction() {
		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$examensBio = $this->params()->fromPost('examensBio',0);
		$idListe = $this->params()->fromPost('id',0); //POUR SAVOIR S'IL S'AGIT DE LA LISTE 'RECHERCHE' ou 'EN-COURS'
	
		$demande = $this->getDemandeTable()->getDemandeWithIdcons($id_cons);
	
		$unPatient = $this->getPatientTable()->getInfoPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
	
		$date = $this->controlDate->convertDate( $unPatient['DATE_NAISSANCE'] );
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE']. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		$html .= "<div id='titre_info_deces'>Informations sur la demande d'examen </div>
		          <div id='barre'></div>
		
		          <div style='width: 100%;'>
		          <table style='width:100%;'>
		          <tr style='width:100%;'>
		          <td style='width: 18%;'> </td>
		          <td style='width: 80%;'>";
		foreach ($demande as $donnees) {
			$html .= "<table style='margin-top:10px; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$this->controlDate->convertDate( $donnees['Datedemande']). "</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $donnees['PrenomMedecin'] ." ".$donnees['NomMedecin'] . "</p></td>";
			$html .= "</tr>";
			$html .= "</table>
					
					</td>
				    </tr>
				    </table>
				    </div>";
		}
	
		$html .= "<div id='titre_info_deces'>Liste des examens demand&eacute;s </div>
		          <div id='barre'></div>
	
				  <div id='info_liste' style='width: 100%;'>
		          <table style='width:100%;'>
		          <tr style='width:100%;'>
		          <td style='width: 18%;'> </td>
		          <td id='info_liste_table' style='width: 80%;'>";
		if($examensBio == 1){
			$html .= $this->listeExamensBiologiquesAction($id_cons);
		}
		else /* POUR LES EXAMENS MORPHOLOGIQUES (Radiologie ... )*/
		{
			$html .= $this->listeExamensAction($id_cons, $idListe);
		}
		$html .="
				 </td>
				 </tr>
				 </table>
				</div>";
	
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminer'>Terminer</button></div>
                     </div>";
		}
	
		$html .="</div>";
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
 	public function listeExamensAction($id_cons, $idListe=null) {
	
		$liste_examens_demandes = $this->getDemandeTable()->getDemandesExamensMorphologiques($id_cons);
		$html = "";
		$this->getDateHelper();
			
		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px;  width:98%;' id='listeDesExamens'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer; font-family: Times New Roman; font-weight: bold;'>
					<th style='width: 9%;'>Num&eacute;ro</th>
					<th style='width: 32%;'>Libelle examen</th>
					<th style='width: 40%;'>Note</th>
				    <th style='width: 13%;'>Options</th>
				    <th style='width: 6%;'>Etat</th>
				  </tr>
			     </thead>";
			
 		$html .="<tbody style='width: 100%;'>";
		$cmp = 1;
		foreach ($liste_examens_demandes as $Liste){
			$html .="<tr style='width: 100%;' id='".$Liste['idDemande']."'>";
			$html .="<td style='width: 9%;'><div id='inform' style='margin-left: 25%; float:left; font-weight:bold; font-size:17px;'> " .$cmp++. ". </div></td>";
			$html .="<td style='width: 32%;'><div  style='color: green; font-family: Times New Roman; float:left; font-weight: bold; font-size:18px;'> " .$this->getExamenTable()->getExamen($Liste['idExamen'])->libelleExamen. " </div></td>";
			$html .="<td style='width: 40%;'><div  style='color: green; font-family: Times New Roman; float:left; font-weight: bold; font-size:18px;'> " .$Liste['noteDemande']. " </div></td>";
			$html .="<td style='width: 13%;'>
  					    <a href='javascript:vueExamenMorpho(".$Liste['idDemande'].") '>
  					       <img class='visualiser".$Liste['idDemande']."' style='margin-right: 9%; margin-left: 3%;' src='../images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
  					    </a>&nbsp";
	
			if($Liste['appliquer'] == 0) {
	
				if($idListe != 2){ //L'APPEL EST FAIT DANS LA LISTE 'RECHERCHE' POUR UNIQUEMENT LA VISUALISATION
					$html .="<a href='javascript:appliquerExamen(".$Liste['idDemande'].")'>
 				     	 <img class='modifier".$Liste['idDemande']."' style='margin-right: 16%;' src='../images_icons/aj.gif' alt='Constantes' title='Entrer les r&eacute;sultats'/>
 					     </a>";
	
					$html .="<a>
 					    	<img style='color: white; opacity: 0.09;' src='../images_icons/74biss.png' alt='Constantes' />
 					     </a>
 				         </td>";
						
				}
	
				$html .="<td style='width: 6%;'>
  					     <a>
  					        <img class='etat_non".$Liste['idDemande']."' style='margin-left: 25%;' src='../images_icons/non.png' alt='Constantes' title='examen non encore effectu&eacute;' />
  					     </a>
  					     </td>";
 			}else {
	
				if($idListe != 2){ //L'APPEL EST FAIT DANS LA LISTE 'RECHERCHE' POUR UNIQUEMENT LA VISUALISATION
						
					$resultat = $this->getResultatExamenTable()->getResultatExamen($Liste['idDemande']);
	
					if($resultat->envoyer == 1) {
							
						$html .="<a>
 					  	     <img style='margin-right: 16%; color: white; opacity: 0.09;' src='../images_icons/pencil_16.png'/>
 					         </a>";
							
						if($Liste['responsable'] == 1) { /*Envoyer par le medecin*/
							$html .="<a>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/tick_16.png' title='examen valid&eacute; par le medecin'/>
 					     </a>
 				         </td>";
						} else
						{ /*Envoyer par le laborantin*/
							$html .="<a>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/tick_16.png' title='examen envoy&eacute;'/>
 					     </a>
 				         </td>";
						}
	
	
					} else {
						$html .="<a href='javascript:modifierExamen(".$Liste['idDemande'].")'>
 					    	<img class='modifier".$Liste['idDemande']."' style='margin-right: 16%;' src='../images_icons/pencil_16.png' alt='Constantes' title='modifier r&eacute;sultat'/>
 					     </a>";
						$html .="<a href='javascript:envoyer(".$Liste['idDemande'].")'>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/74biss.png' alt='Constantes' title='envoyer'/>
 					     </a>
 				         </td>";
					}
						
						
 				}
	
				$html .="<td style='width: 6%;'>
  					     <a>
  					        <img class='etat_oui".$Liste['idDemande']."' style='margin-left: 25%;' src='../images_icons/oui.png' alt='Constantes' title='examen d&eacute;ja effectu&eacute;' />
  					     </a>
  					     </td>";
 			}
	
			$html .="</tr>";
	
			$html .="<script>
					  $('.visualiser".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.visualiser".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.visualiser".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.visualiser".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /************************/
	                  /************************/
	                  /************************/
                      $('.modifier".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.modifier".$Liste['idDemande']." ' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
				      $('.modifier".$Liste['idDemande']." ').mouseleave(function(){
	                    var tooltips = $( '.modifier".$Liste['idDemande']." ' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.supprimer".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.supprimer".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.supprimer".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.supprimer".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_oui".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_oui".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_oui".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.etat_oui".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_non".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_non".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_non".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.etat_non".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                   /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.envoyer".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.envoyer".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
			        </script>";
 		}
 		$html .="</tbody>";
 		$html .="</table>";
	
		$html .="<style>
				  #listeDataTable{
	                margin-left: 185px;
                  }
	
				  div .dataTables_paginate
                  {
				    margin-right: 20px;
                  }
	
				  #listeDesExamens tbody tr{
				    background: #fbfbfb;
				  }
	
				  #listeDesExamens tbody tr:hover{
				    background: #fefefe;
				  }
	
				 </style>";
 		$html .="<script> listepatient (); listeDesSoins(); $('#Examen_id_cons').val('".$id_cons."'); </script>";
	
 		return $html;
	
 	}
 	
 	
 	public function verifierSiResultatExisteAction() {
 		$idDemande = $this->params()->fromPost('idDemande', 0);
 		$demande = $this->getDemandeTable()->getDemande($idDemande);
 	
 		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
 		return $this->getResponse ()->setContent ( Json::encode ($demande->appliquer) );
 	}
 	
 	public function vueExamenAppliquerMorphoAction() {
 		$this->getDateHelper();
 		$idDemande = $this->params()->fromPost('idDemande', 0);
 	
 		$demande = $this->getDemandeTable()->getDemande($idDemande);
 	
 		$html  ="<table style='width: 95%;'>";
 		$html .="<tr style='width: 95%;'>";
 		$html .="<td style='width: 100%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Libelle examen:</a><br><p style='font-weight:bold; font-size:17px;'> ". $this->getExamenTable()->getExamen($demande->idExamen)->libelleExamen ." </p></td>";
 		$html .="</tr>";
 		$html .="</table>";
 	
 		$html .="<table style='width: 95%; margin-bottom: 25px;'>";
 		$html .="<tr style='width: 95%;'>";
 		$html .="<td style='width: 90%; padding-top: 10px; padding-right:25px;'><a style='text-decoration:underline; font-size:13px;'>Motif:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $demande->noteDemande ." </p></td>";
 		$html .="<td style='width: 10%;'> </td>";
 		$html .= "</tr>";
 		$html .="</table>";
 	
//  		if($demande->appliquer == 1){
//  			$resultat = $this->getResultatExamenTable()->getResultatExamen($idDemande);
//  			$date = 'pas de date';
//  			if($this->controlDate->convertDateTime($resultat->date_modification) == '00/00/0000 - 00:00:00'){
//  				$date = $this->controlDate->convertDateTime($resultat->date_enregistrement);
//  			} else {
//  				$date = $this->controlDate->convertDateTime($resultat->date_modification);
//  			}
//  			$html .= "<div id='titre_info_resultat_examen'>R&eacute;sultat de l'examen  <span style='position: absolute; right: 20px; font-size: 14px; font-weight: bold;'>". $this->controlDate->convertDateTime($demande->dateDemande) ." </span></div>
// 			          <div id='barre_resultat' ></div>";
 	
//  			$html .="<table style='width: 100%; margin-top: 10px;'>";
//  			$html .="<tr style='width: 100%;'>";
//  			$html .="<td style='width: 100%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Technique utilis&eacute;e:</a><br><p style='font-weight:bold; font-size:17px;'> ". $resultat->techniqueUtiliser ." </p></td>";
//  			$html .="</tr>";
//  			$html .="</table>";
 	
//  			$html .="<table style='width: 100%;'>";
//  			$html .="<tr style='width: 100%;'>";
//  			$html .="<td style='width: 50%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Note R&eacute;sultat:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $resultat->noteResultat ." </p></td>";
//  			$html .="<td style='width: 50%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Conclusion:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $resultat->conclusion ." </p></td>";
//  			$html .= "</tr>";
//  			$html .="</table>";
//  		}
 	
 		$html .="<script> $('#typeExamen_tmp').val(".$demande->idExamen.");</script>";
 	
 		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
 		return $this->getResponse ()->setContent ( Json::encode ($html) );
 	}
 	
 	//=================================================================================================
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//**** BIOLOGIE ----- BIOLOGIE ----- BIOLOGIE ****
 	//=================================================================================================
 	
 	public function listeDemandesExamensAjaxAction() {
 		$output = $this->getDemandeTable()->getListeDemandesExamens();
 		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
 				'enableJsonExprFinder' => true
 		) ) );
 	}
 	
 	public function ajouterResultatBiologiqueAction() {
 		//$output = $this->getDemandeTable()->getListeDemandesExamens();
 		//var_dump($output); exit();
 		$this->layout()->setTemplate('layout/archivage');
 	
 		$formAppliquerExamen = new AppliquerExamenForm();
 	
 		return array(
 				'form' => $formAppliquerExamen
 		);
 	}
 	
 	public function listeExamensDemanderAction() {
 	
 		$this->getDateHelper();
 		$id_personne = $this->params()->fromPost('id_personne',0);
 		$id_cons = $this->params()->fromPost('id_cons',0);
 		$terminer = $this->params()->fromPost('terminer',0);
 		$examensBio = $this->params()->fromPost('examensBio',0);
 	
 		$demande = $this->getDemandeTable()->getDemandeWithIdcons($id_cons);
 	
 		$unPatient = $this->getPatientTable()->getInfoPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
	
		$date = $this->controlDate->convertDate( $unPatient['DATE_NAISSANCE'] );
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE']. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
 	
 		$html .= "<div id='titre_info_deces'>Informations sur la demande d'examen </div>
		          <div id='barre'></div>
 				
     			  <div style='width: 100%;'>
		          <table style='width:100%;'>
				  <tr style='width:100%;'>
				  <td style='width: 18%;'></td>
				  <td style='width: 80%;'>";
 		foreach ($demande as $donnees) {
 			$html .= "<table style='margin-top:10px; width: 80%;'>";
 			$html .= "<tr style='width: 80%;'>";
 			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
 			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$this->controlDate->convertDate($donnees['Datedemande']). "</p></td>";
 			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $donnees['PrenomMedecin'] ." ".$donnees['NomMedecin'] . "</p></td>";
 			$html .= "</tr>";
 			$html .= "</table>
 					
 					</td>
				    </tr>
				    </table>
				    </div>";
 		}
 	
 		$html .= "<div id='titre_info_deces'>Liste des examens demand&eacute;s </div>
		          <div id='barre'></div>
 	
 		          <div id='info_liste' style='width: 100%;'>
 		          <table style='width:100%;'>
 		          <tr style='width:100%;'>
 		          <td style='width: 18%;'> </td>
 		          <td id='info_liste_table' style='width: 80%;'>";
 		if($examensBio == 1){
 			$html .= $this->listeExamensBiologiquesAction($id_cons);
 		}
 		else /* POUR LES EXAMENS MORPHOLOGIQUES (Radiologie ... )*/
 		{
 			//$html .= $this->listeExamensAction($id_cons);
 		}
 		$html .="
 				 </td>
				 </tr>
				 </table>
				 </div>
 				 </div>";
 	
 		if($terminer == 0) {
 			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
 			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminer'>Terminer</button></div>
                     </div>";
 		}
 	
 		$html .="</div>";
 	
 		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
 		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
 	}
 	
 	public function listeExamensBiologiquesAction($id_cons) {
 	
 		$liste_examens_demandes = $this->getDemandeTable()->getDemandesExamensBiologiques($id_cons);
 		$html = "";
 		$this->getDateHelper();
 			
 		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; width:98%;' id='listeDesExamens'>";
 			
 		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer; font-family: Times New Roman; font-weight: bold;'>
					<th style='width: 9%;'>Num&eacute;ro</th>
					<th style='width: 32%;'>Libelle examen</th>
					<th style='width: 40%;'>Note</th>
				    <th style='width: 13%;'>Options</th>
				    <th style='width: 6%;'>Etat</th>
				  </tr>
			     </thead>";
 			
 		$html .="<tbody style='width: 100%;'>";
 		$cmp = 1;
 		foreach ($liste_examens_demandes as $Liste){
 			$html .="<tr style='width: 100%;' id='".$Liste['idDemande']."'>";
 			$html .="<td style='width: 9%;'><div id='inform' style='margin-left: 25%; float:left; font-weight:bold; font-size:17px;'> " .$cmp++. ". </div></td>";
 			$html .="<td style='width: 32%;'><div  style='color: green; font-family: Times New Roman; float:left; font-weight: bold; font-size:18px;'> " .$this->getExamenTable()->getExamen($Liste['idExamen'])->libelleExamen. " </div></td>";
 			$html .="<td style='width: 40%;'><div  style='color: green; font-family: Times New Roman; float:left; font-weight: bold; font-size:18px;'> " .$Liste['noteDemande']. " </div></td>";
 			$html .="<td style='width: 13%;'>
  					    <a href='javascript:vueExamenBio(".$Liste['idDemande'].") '>
  					       <img class='visualiser".$Liste['idDemande']."' style='margin-right: 9%; margin-left: 3%;' src='../images_icons/voird.png' title='d&eacute;tails' />
  					    </a>&nbsp";
 	
 			if($Liste['appliquer'] == 0) {
 				$html .="<a href='javascript:appliquerExamenBio(".$Liste['idDemande'].")'>
 					    	<img class='modifier".$Liste['idDemande']."' style='margin-right: 16%;' src='../images_icons/aj.gif' title='Entrer les r&eacute;sultats'/>
 					     </a>";
 					
 				$html .="<a>
 					    	<img style='color: white; opacity: 0.09;' src='../images_icons/74biss.png'  />
 					     </a>
 				         </td>";
 					
 				$html .="<td style='width: 6%;'>
  					     <a>
  					        <img class='etat_non".$Liste['idDemande']."' style='margin-left: 25%;' src='../images_icons/non.png' title='examen non encore effectu&eacute;' />
  					     </a>
  					     </td>";
 			}else {
 					
 				$resultat = $this->getResultatExamenTable()->getResultatExamen($Liste['idDemande']);
 	
 				if($resultat->envoyer == 1) {
 					$html .="<a>
 					    	<img style='margin-right: 16%; color: white; opacity: 0.09;' src='../images_icons/pencil_16.png'/>
 					     </a>";
 	
 					if($Liste['responsable'] == 1) { /*Envoyer par le medecin*/
 						$html .="<a>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/tick_16.png' title='examen valid&eacute; par le medecin'/>
 					     </a>
 				         </td>";
 					} else
 					{ /*Envoyer par le laborantin*/
 						$html .="<a>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/tick_16.png' title='examen envoy&eacute;'/>
 					     </a>
 				         </td>";
 					}
 	
 	
 				} else {
 					$html .="<a href='javascript:modifierExamenBio(".$Liste['idDemande'].")'>
 					    	<img class='modifier".$Liste['idDemande']."' style='margin-right: 16%;' src='../images_icons/pencil_16.png'  title='modifier r&eacute;sultat'/>
 					     </a>";
 					$html .="<a href='javascript:envoyerBio(".$Liste['idDemande'].")'>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/74biss.png'  title='envoyer'/>
 					     </a>
 				         </td>";
 				}
 					
 					
 				$html .="<td style='width: 6%;'>
  					     <a>
  					        <img class='etat_oui".$Liste['idDemande']."' style='margin-left: 25%;' src='../images_icons/oui.png' title='examen d&eacute;ja effectu&eacute;' />
  					     </a>
  					     </td>";
 			}
 	
 			$html .="</tr>";
 	
 			$html .="<script>
					  $('.visualiser".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.visualiser".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.visualiser".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.visualiser".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /************************/
	                  /************************/
	                  /************************/
                      $('.modifier".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.modifier".$Liste['idDemande']." ' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
				      $('.modifier".$Liste['idDemande']." ').mouseleave(function(){
	                    var tooltips = $( '.modifier".$Liste['idDemande']." ' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.supprimer".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.supprimer".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.supprimer".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.supprimer".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
 	
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_oui".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_oui".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_oui".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.etat_oui".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_non".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_non".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_non".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.etat_non".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                   /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.envoyer".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.envoyer".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
			        </script>";
 		}
 		$html .="</tbody>";
 		$html .="</table>";
 	
 		$html .="<style>
				 /* #listeDataTable{
	                margin-left: 35%;
                  }*/
 				
 	
				  div .dataTables_paginate
                  {
				    margin-right: 20px;
                  }
 	
				  #listeDesExamens tbody tr{
				    background: #fbfbfb;
				  }
 	
				  #listeDesExamens tbody tr:hover{
				    background: #fefefe;
				  }
 	
				 </style>";
 		$html .="<script> listepatient (); listeDesSoins(); $('#Examen_id_cons').val('".$id_cons."'); </script>";
 	
 		return $html;
 	
 	}
 	
 	public function vueExamenAppliquerAction() {
 		$this->getDateHelper();
 		$idDemande = $this->params()->fromPost('idDemande', 0);
 	
 		$demande = $this->getDemandeTable()->getDemande($idDemande);
 	
 		$html  ="<table style='width: 95%;'>";
 		$html .="<tr style='width: 95%;'>";
 		$html .="<td style='width: 100%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Libelle examen:</a><br><p style='font-weight:bold; font-size:17px;'> ". $this->getExamenTable()->getExamen($demande->idExamen)->libelleExamen ." </p></td>";
 		$html .="</tr>";
 		$html .="</table>";
 	
 		$html .="<table style='width: 95%; margin-bottom: 25px;'>";
 		$html .="<tr style='width: 95%;'>";
 		$html .="<td style='width: 90%; padding-top: 10px; padding-right:25px;'><a style='text-decoration:underline; font-size:13px;'>Motif:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $demande->noteDemande ." </p></td>";
 		$html .="<td style='width: 10%;'> </td>";
 		$html .= "</tr>";
 		$html .="</table>";
 	
 		if($demande->appliquer == 1){
 			$resultat = $this->getResultatExamenTable()->getResultatExamen($idDemande);
 			$date = 'pas de date';
 			if($this->controlDate->convertDateTime($resultat->date_modification) == '00/00/0000 - 00:00:00'){
 				$date = $this->controlDate->convertDateTime($resultat->date_enregistrement);
 			} else {
 				$date = $this->controlDate->convertDateTime($resultat->date_modification);
 			}
 			$html .= "<div id='titre_info_resultat_examen'>R&eacute;sultat de l'examen  <span style='position: absolute; right: 20px; font-size: 14px; font-weight: bold;'>". $date ." </span></div>
			          <div id='barre_resultat' ></div>";
 				
 			$html .="<table style='width: 100%; margin-top: 10px;'>";
 			$html .="<tr style='width: 100%;'>";
 			$html .="<td style='width: 50%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Technique utilis&eacute;e:</a><br><p style='font-weight:bold; font-size:17px;'> ". $resultat->techniqueUtiliser ." </p></td>";
 			$html .="<td id='visualisationImageResultats' style='width: 50%; vertical-align:top;'><img style='height: 50px;' src='../images_icons/jpg_file.png' title='Visualiser'/></td>";
 			$html .="</tr>";
 			$html .="</table>";
 				
 			$html .="<table style='width: 100%;'>";
 			$html .="<tr style='width: 100%;'>";
 			$html .="<td style='width: 50%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Note R&eacute;sultat:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $resultat->noteResultat ." </p></td>";
 			$html .="<td style='width: 50%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Conclusion:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $resultat->conclusion ." </p></td>";
 			$html .= "</tr>";
 			$html .="</table>";
 		}
 	
 		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
 		return $this->getResponse ()->setContent ( Json::encode ($html) );
 	}
 	
 	public function appliquerExamenAction() {
 	
 		$donnees = $this->getRequest()->getPost();
 		$user = $this->layout()->user;
 		$id_personne = $user['id_personne'];
 		 
 		$this->getResultatExamenTable()->saveResultatsExamens($donnees, $id_personne);
 		$this->getDemandeTable()->demandeEffectuee($donnees->idDemande);
 	
 		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
 		return $this->getResponse ()->setContent ( Json::encode () );
 	}
 	
 	public function raffraichirListeExamensBioAction() {
 		$id_cons = $this->params()->fromPost('id_cons');
 	
 		$html = $this->listeExamensBiologiquesAction($id_cons);
 	
 		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
 		return $this->getResponse ()->setContent ( Json::encode ($html) );
 	}
 	
 	public function modifierExamenAction() {
 		$idDemande = $this->params()->fromPost('idDemande');
 	
 		$demandeDem = $this->getDemandeTable()->getDemande($idDemande);
 	
 		$demande = $this->getResultatExamenTable()->getResultatExamen($idDemande);
 		$html ="<script>
				   $('#technique_utilise').val('".str_replace("'", "\'", $demande->techniqueUtiliser)."');
				   $('#resultat').val('".str_replace("'", "\'", $demande->noteResultat)."');
				   $('#conclusion').val('".str_replace("'", "\'", $demande->conclusion)."');
				   $('#typeExamen_tmp').val(".$demandeDem->idExamen.");
				</script>";
 	
 		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
 		return $this->getResponse ()->setContent ( Json::encode ($html) );
 	}
 	
 	public function envoyerExamenBioAction() {
 		$idDemande = $this->params()->fromPost('idDemande');
 		$id_cons = $this->params()->fromPost('id_cons');
 	
 		$this->getResultatExamenTable()->examenEnvoyer($idDemande);
 		$html = $this->listeExamensBiologiquesAction($id_cons);
 	
 		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
 		return $this->getResponse ()->setContent ( Json::encode ($html) );
 	}
 	
 	public function listeResultatsBiologieAction() {
 		
 		$this->layout()->setTemplate('layout/Archivage');
		
		$formAppliquerExamen = new AppliquerExamenForm();
		
		return array(
				'form' => $formAppliquerExamen
		);
	}
	
	public function listeRechercheExamensEffectuesAjaxAction() {
		$user = $this->layout()->user;
		$IdDuService = $user['IdService'];
		
		$output = $this->getDemandeTable()->getListeExamensEffectues($IdDuService);
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	//=================================================================================================
	//**** ANESTHESIE ----- ANESTHESIE ----- ANESTHESIE ****
	//**** ANESTHESIE ----- ANESTHESIE ----- ANESTHESIE ****
	//**** ANESTHESIE ----- ANESTHESIE ----- ANESTHESIE ****
	//**** ANESTHESIE ----- ANESTHESIE ----- ANESTHESIE ****
	//**** ANESTHESIE ----- ANESTHESIE ----- ANESTHESIE ****
	//**** ANESTHESIE ----- ANESTHESIE ----- ANESTHESIE ****
	//**** ANESTHESIE ----- ANESTHESIE ----- ANESTHESIE ****
	//**** ANESTHESIE ----- ANESTHESIE ----- ANESTHESIE ****
	//**** ANESTHESIE ----- ANESTHESIE ----- ANESTHESIE ****
	//**** ANESTHESIE ----- ANESTHESIE ----- ANESTHESIE ****
	//=================================================================================================
	
	public function ajouterResultatVpaAction() {
		$this->layout()->setTemplate('layout/Archivage');
	}
	
	public function listeDemandesVpaAjaxAction() {
		$output = $this->getDemandeTable()->getListeDemandesVpa();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function detailsDemandeVisiteAction() {
		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$idVpa = $this->params()->fromPost('idVpa',0);
	
		$demande = $this->getDemandeTable()->getDemandeVpaWidthIdcons($id_cons);
	
		$unPatient = $this->getPatientTable()->getInfoPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
	
		$date = $this->controlDate->convertDate( $unPatient['DATE_NAISSANCE'] );
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE']. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		$html .= "<div id='titre_info_deces'>Informations sur la demande de VPA </div>
		          <div id='barre'></div>";
		foreach ($demande as $donnees) {
			$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$this->controlDate->convertDate($donnees['Datedemande']). "</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $donnees['PrenomMedecin'] ." ".$donnees['NomMedecin'] . "</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
				
			$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Diagnostic:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['DIAGNOSTIC'] ." </p></td>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>observation:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['OBSERVATION'] ." </p></td>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Intervention pr&eacute;vue:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['INTERVENTION_PREVUE'] ." </p></td>";
			$html .= "</tr>";
			$html .= "</table>";
		}
	
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$formVpa = new VpaForm();
	
		$user = $this->layout()->user;
		$id_personne = $user['id_personne'];
	
		$formRow = new FormRow();
		$formText = new FormText();
		$formTextArea = new FormTextarea();
		$formRadio = new FormRadio();
		$formHidden = new FormHidden();
	
		$html .= "<div id='titre_info_deces'>Entrez les r&eacute;sultats </div>
		          <div id='barre'></div>";
		$html .="<form  method='post' action='".$chemin."/archivage/save-result-vpa'>";
		$html .= $formHidden($formVpa->get('idVpa'));
		$html .= $formHidden($formVpa->get('idPersonne'));
	
		$html .="<div style='width: 80%; margin-left: 18%;'>";
		$html .="<table id='form_patient_vpa' style='width: 100%; '>
					 <tr  style='width: 100%'>
					   <td  class='comment-form-patient'  style='width: 35%; '>". $formRow($formVpa->get('numero_vpa')).$formText($formVpa->get('numero_vpa'))."</td>
					   <td  class='comment-form-patient'  style='width: 35%; '>". $formRow($formVpa->get('type_intervention')).$formText($formVpa->get('type_intervention'))."</td>
				       <td  style='width: 10%; '> <span class='comment-form-patient'> <label style=''>Aptitude</label> </span> <span style='width: 10%;' class='comment-form-patient-radio'>".$formRadio($formVpa->get('aptitude'))."</span></td>
					   <td  class='comment-form-patient-label-im'>
				       		<label style='width: 48px; height: 48px; position: relative; right: 43px; top: 25px; z-index: 3;'> <img id='DeCoche' src='../images_icons/negatif.png'> </label>
				            <label style='width: 40px; height: 40px; position: relative; right: 40px; top: 20px; z-index: 3;'> <img id='Coche' src='../images_icons/tick-icon2.png'>   </label>
				       </td>
				       <td  style='width: 15%;'><a href='javascript:vider()'><img style=' margin-left: 45%;' src='../images_icons/118.png' title='vider tout'></a></td>
					 </tr>
					</table>";
		$html .="</div>";
	
		$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			
		$html .="<div class='block' id='thoughtbot' style='position: absolute; right: 40%; bottom: 70px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminer'>Terminer</button></div>
                 </div>";
		$html .="<div class='block' id='thoughtbot' style='position: absolute; right: 49%; bottom: 70px; font-size: 18px; font-weight: bold;'><button type='submit' id='annuler'>Annuler</button></div>
                 </div>";
	
		$html .="</div>";
	
		$typeAnesthesie = $this->getDemandeTable()->listeDesTypeAnesthesie();
	
		$html .="<script>
				  scriptTerminer();
				  $('#DeCoche').toggle(false);
				  $('#Coche').toggle(false);
				  $('#idVpa').val(".$idVpa.");
				  $('#idPersonne').val(".$id_personne.");
				  $('#form_patient_vpa input[name=aptitude]').click(function(){
				      var boutons = $('#form_patient_vpa input[name=aptitude]');
				      if( boutons[1].checked){ $('#Coche').toggle(true);  $('#DeCoche').toggle(false); }
				      if(!boutons[1].checked){ $('#Coche').toggle(false); $('#DeCoche').toggle(true);}
			      });
				  $('#form_patient_vpa input').attr('autocomplete', 'off');
				  $('#form_patient_vpa input').css({'font-size':'18px', 'color':'#065d10'});
	
				  var myArrayTypeAnesthesie = [''];
				  var j = 0;
				 </script>";
	
		foreach ($typeAnesthesie as $liste){
			$html .="<script> myArrayTypeAnesthesie[j++]  = '" .$liste['libelle']. "'</script>";
		}
		$html .="<script>
				  $(function(){
                     $( '#type_intervention' ).autocomplete({
	                 source: myArrayTypeAnesthesie
	                 });
				  });
                 </script>";
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function saveResultVpaAction(){
		$resultatVpa = $this->getRequest()->getPost();
		$this->getResultatVpa()->saveResultat($resultatVpa);
	
		return $this->redirect()->toRoute('archivage' , array('action' => 'liste-resultats-vpa'));
	}
	
	public function listeResultatsVpaAction() {
		$this->layout()->setTemplate('layout/Archivage');
	}
	
	public function listeRechercheVpaAjaxAction() {
		$output = $this->getDemandeTable()->getListeRechercheVpa();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function detailsRechercheVisiteAction() {
	
		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$idVpa = $this->params()->fromPost('idVpa',0);
	
		$demande = $this->getDemandeTable()->getDemandeVpaWidthIdcons($id_cons);
	
		$unPatient = $this->getPatientTable()->getInfoPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
	
		$date = $this->controlDate->convertDate( $unPatient['DATE_NAISSANCE'] );
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE']. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		$html .= "<div id='titre_info_deces'>Informations sur la demande de VPA </div>
		          <div id='barre'></div>";
		foreach ($demande as $donnees) {
			$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$this->controlDate->convertDate($donnees['Datedemande']). "</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $donnees['PrenomMedecin'] ." ".$donnees['NomMedecin'] . "</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
	
			$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Diagnostic:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['DIAGNOSTIC'] ." </p></td>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Observation:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['OBSERVATION'] ." </p></td>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Intervention pr&eacute;vue:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['INTERVENTION_PREVUE'] ." </p></td>";
			$html .= "</tr>";
			$html .= "</table>";
		}
		$html .= "<div id='titre_info_deces'>Informations sur les r&eacute;sultats de la VPA </div>
		          <div id='barre'></div>";
	
		$resultatVpa = $this->getResultatVpa()->getResultatVpa($idVpa);
	
		$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
	
		$html .= "<tr style='width: 80%; font-family: time new romans'>";
		$html .= "<td style='width: 55%; height: 50px; '><span style='font-size:15px; font-family: Felix Titling;'>Num&eacute;ro VPA: </span> <span style='font-weight:bold; font-size:20px; color: #065d10;'>" .$resultatVpa->numeroVpa. "</span></td>";
		$html .= "<td rowspan='2' style='width: 2%; vertical-align: top;'> <div style='width: 4px; height: 110px; background: #ccc;'> </div> </td>";
	
		if($resultatVpa->aptitude == 1){
			$html .= "<td rowspan='2' style='width: 43%; height: 50px; '><span style='font-size:17px; font-family: Felix Titling;'>APTITUDE:  </span> <span style='font-weight:bold; font-size:25px; color: #065d10;'>  Oui <img src='../images_icons/coche.PNG' /></span></td>";
		}else {
			$html .= "<td rowspan='2' style='width: 43%; height: 50px; '><span style='font-size:17px; font-family: Felix Titling;'>APTITUDE:  </span> <span style='font-weight:bold; font-size:25px; color: #e91a1a;'>  Non <img src='../images_icons/decoche.PNG' /></span></td>";
		}
	
		$html .= "</tr>";
	
		$html .= "<tr style='width: 80%; font-family: time new romans; vertical-align: top;'>";
		$html .= "<td style='width: 50%; height: 50px; '><span style='font-size:15px; font-family: Felix Titling;'>Type d'anesth&eacute;sie: </span> <span style=' font-weight:bold; font-size:20px; color: #065d10;'>" . $resultatVpa->typeIntervention. "</span></td>";
		$html .= "</tr>";
	
		$html .= "</table>";
	
		$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='../images_icons/fleur1.jpg' />
                     </div>";
			
		$html .="<div class='block' id='thoughtbot' style='position: absolute; right: 40%; bottom: 70px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminer2'>Terminer</button></div>
                 </div>";
	
		$html .="<script>
				  scriptAnnulerVisualisation();
				 </script>";
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	/***** LECTEUR VIDEO ---- LECTEUR VIDEO  *****/
	/***** LECTEUR VIDEO ---- LECTEUR VIDEO  *****/
	/***** LECTEUR VIDEO ---- LECTEUR VIDEO  *****/
	public function lecteurVideoAction($ListeDesVideos){
	
		$html ='<script>
				 var tab = [];
		        </script>';
		$i = 0;
		foreach ($ListeDesVideos as $Liste) {
				
			if($Liste['format'] == "video/mp4" || $Liste['format'] == "video/m4v") {
				$html .='<script>
        		 tab['.$i++.'] = {
	                     "title":"'. $Liste['titre'] .' <span class=\'supprimerVideoIns'.$i.'\' >  </span>",
		                 "m4v":"/simens/public/videos/'. $Liste['nom'] .'",
		         };
	
		         setTimeout(function() {
	                $(function () {
		              $(".supprimerVideoIns'.$i.'").click(function () { return false; });
		              $(".supprimerVideoIns'.$i.'").dblclick(function () { supprimerVideo('.$Liste['id'].'); return false; });
	                });
                 }, 1000);
        		 </script>';
			}
			else
			if($Liste['format'] == "video/webm") {
				$html .='<script>
        		 tab['.$i++.'] = {
	                     "title":"'. $Liste['titre'] .'<span class=\'supprimerVideoIns'.$i.'\' >  </span>",
		                 "webmv":"/simens/public/videos/'. $Liste['nom'] .'",
		         };
		  
		         setTimeout(function() {
	                $(function () {
		              $(".supprimerVideoIns'.$i.'").click(function () { return false; });
		              $(".supprimerVideoIns'.$i.'").dblclick(function () { supprimerVideo('.$Liste['id'].'); return false; });
	                });
                 }, 1000);
        		 </script>';
			}
		}
	
		$html .='<script>
				 $(document).ready(function(){
	
	               new jPlayerPlaylist({
		             jPlayer: "#jquery_jplayer_1",
		             cssSelectorAncestor: "#jp_container_1"
	               },
				      tab
				    ,{
		               swfPath: "../../dist/jplayer",
		               supplied: "webmv, ogv, m4v",
		               useStateClassSkin: true,
		               autoBlur: false,
		               smoothPlayBar: true,
		               keyEnabled: true
	               });
	
                 });
	
				scriptAjoutVideo();
		        </script>';
			
		$html .='
	
		<form id="my_form_video" method="post" action="/simens/public/consultation/ajouter-video" enctype="multipart/form-data">
		<div id="jp_container_1" class="jp-video jp-video-270p" role="application" aria-label="media player" style="margin: auto;">
	    <div class="jp-type-playlist">
		<div id="jquery_jplayer_1" class="jp-jplayer"></div>
		<div class="jp-gui">
			<div class="jp-video-play">
				<button class="jp-video-play-icon" role="button" tabindex="0">play</button>
			</div>
			<div class="jp-interface">
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
				<div class="jp-controls-holder">
					<div class="jp-controls">
						<button class="jp-previous" role="button" tabindex="0">previous</button>
						<button class="jp-play" role="button" tabindex="0">play</button>
						<button class="jp-next" role="button" tabindex="0">next</button>
						<button class="jp-stop" role="button" tabindex="0">stop</button>
					</div>
					<div class="jp-volume-controls">
						<button class="jp-mute" role="button" tabindex="0">mute</button>
						<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div>
					<div class="jp-toggles">
						<button class="jp-full-screen" role="button" tabindex="0">full screen</button>
					</div>
	
				    <div class="jp-toggles2" id="jp-toggles-video" >
				        <div class="jp-ajouter-video">
				           <input type="file" name="fichier-video" id="fichier-video">
				        </div>
					</div>
	
				</div>
				<div class="jp-details">
					<div class="jp-title" aria-label="title">&nbsp;</div>
				</div>
			</div>
		</div>
		<div class="jp-playlist">
			<ul>
				<li>&nbsp;</li>
			</ul>
		</div>
	    </div>
        </div>
		</form>';
		return $html;
	}
	
	public function afficherVideoAction(){
		$id_cons = $this->params()->fromPost('id_cons', 0);
		$listeDesVideos = $this->getConsultationTable()->getVideos($id_cons);
		$html = $this->lecteurVideoAction($listeDesVideos);
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	
	public function ajouterVideoAction(){
	
		$type = $_FILES['fichier-video']['type'];
		$nom_file = "";
		$tmp = $_FILES['fichier-video']['tmp_name'];
	
		$date = new \DateTime();
		$aujourdhui = $date->format('H-i-s_d-m-y');
			
		/**
		 * 'video/mp4' pour chrome
		 * 'video/x-m4v pour firefox
		*/
			
		if($type == 'video/webm' || $type == 'video/mp4' || $type == 'video/x-m4v'){
			if($type == 'video/webm'){
				$nom_file ="arch_v_scan_".$aujourdhui.".webm";
			}
			else
			if($type == 'video/mp4'){
				$nom_file ="arch_v_scan_".$aujourdhui.".mp4";
			}
			else
			if($type == 'video/x-m4v'){
				$nom_file ="arch_v_scan_".$aujourdhui.".m4v";
				$type = 'video/m4v';
			}
			$result = move_uploaded_file($tmp, 'C:\wamp\www\simens\public\videos\\'.$nom_file);
		}
			
		$html = array($nom_file, $type);
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	
	}
	
	
	public function insererBdVideoAction(){
		$id_cons = $this->params()->fromPost('id_cons', 0);
		$nom_file = $this->params()->fromPost('nom_file', 0);
		$type_file = $this->params()->fromPost('type_file', 0);
	
		$html = 0;
		if($type_file == 'video/webm' || $type_file == 'video/mp4' || $type_file == 'video/m4v'){
			$this->getConsultationTable ()->insererVideo($nom_file, $nom_file, $type_file, $id_cons);
			$ListeDesVideos = $this->getConsultationTable ()->getVideos($id_cons);
			$html = $this->lecteurVideoAction($ListeDesVideos);
		}
	
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function supprimerVideoAction(){
		$id = $this->params()->fromPost('id', 0);
	
		$result = $this->getConsultationTable ()->supprimerVideo($id);
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($result) );
	}
	
	/***** LECTEUR MP3 ---- LECTEUR MP3  *****/
	/***** LECTEUR MP3 ---- LECTEUR MP3  *****/
	/***** LECTEUR MP3 ---- LECTEUR MP3  *****/
	public function lecteurMp3Action($ListeDesSons){
		$html ='<script>
				 var tab = [];
		        </script>';
		$i = 0;
		foreach ($ListeDesSons as $Liste) {
			$html .='<script>
        		 tab['.$i++.'] = {
	                     "title":"'. $Liste['titre'] .'<span class=\"supprimerSon'.$i.'\" >  </span>",
		                 "mp3":"/simens/public/audios/'. $Liste['nom'] .'",
		         };
		         
		         setTimeout(function() {
	                $(function () {
		              $(".supprimerSon'.$i.'").click(function () { return false; });
		              $(".supprimerSon'.$i.'").dblclick(function () { supprimerAudioMp3('.$i.'); return false; });
	                });
                 }, 1000);
        		 </script>';
		}
	
		$html .='<script>
        		$(function(){
	              new jPlayerPlaylist({
		          jPlayer: "#jquery_jplayer_2",
		          cssSelectorAncestor: "#jp_container_2"
	            }, tab , {
		        swfPath: "/simens/public/js/plugins/jPlayer-2.9.2/dist/jplayer",
		        supplied: "mp3",
		        wmode: "window",
		        useStateClassSkin: true,
		        autoBlur: false,
		        smoothPlayBar: true,
		        keyEnabled: true,
		        remainingDuration: true,
		        toggleDuration: true
	            });
                });
        		scriptAjoutMp3();
                </script>';
		 
		$html .='
				<form id="my_form" method="post" action="/simens/public/consultation/ajouter-mp3" enctype="multipart/form-data">
                <div id="jquery_jplayer_2" class="jp-jplayer" style="margin-bottom: 30px;"></div>
                <div id="jp_container_2" class="jp-audio" role="application" aria-label="media player"  style="margin-bottom: 30px;">
	            <div class="jp-type-playlist">
		         <div class="jp-gui jp-interface">
			       <div class="jp-controls">
				      <button class="jp-previous" role="button" tabindex="0">previous</button>
				      <button class="jp-play" role="button" tabindex="0">play</button>
				      <button class="jp-next" role="button" tabindex="0">next</button>
				      <button class="jp-stop" role="button" tabindex="0">stop</button>
			       </div>
			   <div class="jp-progress">
				<div class="jp-seek-bar">
					<div class="jp-play-bar"></div>
				</div>
			   </div>
			   <div class="jp-volume-controls">
				<button class="jp-mute" role="button" tabindex="0">mute</button>
				<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
				<div class="jp-volume-bar">
					<div class="jp-volume-bar-value"></div>
				</div>
			   </div>
			   <div class="jp-time-holder">
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
			   </div>
			   <div class="jp-toggles">
				<button class="jp-repeat" role="button" tabindex="0">repeat</button>
				<!-- button class="jp-shuffle" role="button" tabindex="0">shuffle</button-->
				<div class="jp-ajouter" id="ajouter">
				  <input type="file" name="fichier" id="fichier">
				</div>
			   </div>
		       </div>
		       <div class="jp-playlist">
			      <ul>
				     <li>&nbsp;</li>
			      </ul>
		       </div>
	           </div>
               </div>
               </form>';
		return $html;
	}
	
	public function lecteurMp3InstrumentalAction($ListeDesSons){
		$html ='<script>
				 var tab = [];
		        </script>';
		$i = 0;
		foreach ($ListeDesSons as $Liste) {
			$html .='<script>
        		 tab['.$i++.'] = {
	                     "title":"'. $Liste['titre'] .'<span class=\"supprimerSonIns'.$i.'\" >  </span>",
		                 "mp3":"/simens/public/audios/'. $Liste['nom'] .'",
		         };
		    
		         setTimeout(function() {
	                $(function () {
		              $(".supprimerSonIns'.$i.'").click(function () { return false; });
		              $(".supprimerSonIns'.$i.'").dblclick(function () { supprimerAudioMp3('.$i.'); return false; });
	                });
                 }, 1000);
        		 </script>';
		}
	
		$html .='<script>
        		$(function(){
	              new jPlayerPlaylist({
		          jPlayer: "#jquery_jplayer",
		          cssSelectorAncestor: "#jp_container"
	            }, tab , {
		        swfPath: "/simens/public/js/plugins/jPlayer-2.9.2/dist/jplayer",
		        supplied: "mp3",
		        wmode: "window",
		        useStateClassSkin: true,
		        autoBlur: false,
		        smoothPlayBar: true,
		        keyEnabled: true,
		        remainingDuration: true,
		        toggleDuration: true
	            });
                });
        		scriptAjoutMp3_Instrumental();
                </script>';
			
		$html .='
				<form id="my_form2" method="post" action="/simens/public/consultation/ajouter-mp3" enctype="multipart/form-data">
                <div id="jquery_jplayer" class="jp-jplayer" style="margin-bottom: 30px;"></div>
                <div id="jp_container" class="jp-audio" role="application" aria-label="media player"  style="margin-bottom: 30px;">
	            <div class="jp-type-playlist">
		         <div class="jp-gui jp-interface">
			       <div class="jp-controls">
				      <button class="jp-previous" role="button" tabindex="0">previous</button>
				      <button class="jp-play" role="button" tabindex="0">play</button>
				      <button class="jp-next" role="button" tabindex="0">next</button>
				      <button class="jp-stop" role="button" tabindex="0">stop</button>
			       </div>
			   <div class="jp-progress">
				<div class="jp-seek-bar">
					<div class="jp-play-bar"></div>
				</div>
			   </div>
			   <div class="jp-volume-controls">
				<button class="jp-mute" role="button" tabindex="0">mute</button>
				<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
				<div class="jp-volume-bar">
					<div class="jp-volume-bar-value"></div>
				</div>
			   </div>
			   <div class="jp-time-holder">
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
			   </div>
			   <div class="jp-toggles">
				<button class="jp-repeat" role="button" tabindex="0">repeat</button>
				<!-- button class="jp-shuffle" role="button" tabindex="0">shuffle</button-->
				<div class="jp-ajouter" id="ajouter2">
				  <input type="file" name="fichier" id="fichier">
				</div>
			   </div>
		       </div>
		       <div class="jp-playlist">
			      <ul>
				     <li>&nbsp;</li>
			      </ul>
		       </div>
	           </div>
               </div>
               </form>';
		return $html;
	}
	
	public function afficherMp3Action(){
		$id_cons = $this->params()->fromPost('id_cons', 0);
		$type = (int)$this->params()->fromPost('type', 0);
	
		$ListeDesSons = $this->getConsultationTable ()->getMp3($id_cons, $type);
	
		$html = null;
		if($type == 1){
			$html = $this->lecteurMp3Action($ListeDesSons);
		}else {
			$html = $this->lecteurMp3InstrumentalAction($ListeDesSons);
		}
	
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function supprimerMp3Action(){
		$id = $this->params()->fromPost('id', 0);
		$id_cons = $this->params()->fromPost('id_cons', 0);
		$type = $this->params()->fromPost('type', 0);
	
		$this->getConsultationTable ()->supprimerMp3($id, $id_cons, $type);
	
		$ListeDesSons = $this->getConsultationTable ()->getMp3($id_cons, $type);
	
		$html = null;
		if($type == 1){
			$html = $this->lecteurMp3Action($ListeDesSons);
		}else {
			$html = $this->lecteurMp3InstrumentalAction($ListeDesSons);
		}
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function ajouterMp3Action(){
	
		$type = $_FILES['fichier']['type'];
		//$nom_file = $_FILES['fichier']['name'];
		$tmp = $_FILES['fichier']['tmp_name'];
	
		$date = new \DateTime();
		$aujourdhui = $date->format('H-i-s_d-m-y');
		$nom_file = "arch_audio_".$aujourdhui.".mp3";
	
		if($type == 'audio/mp3'){
			$result = move_uploaded_file($tmp, 'C:\wamp\www\simens\public\audios\\'.$nom_file);
		} else {
			$nom_file = 0;
		}
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($nom_file) );
	
	}
	
	public function insererBdMp3Action(){
		$id_cons = $this->params()->fromPost('id_cons', 0);
		$nom_file = $this->params()->fromPost('nom_file', 0);
		$type = $this->params()->fromPost('type', 0);
	
		$this->getConsultationTable ()->insererMp3($nom_file, $nom_file, $id_cons, $type);
		$ListeDesSons = $this->getConsultationTable ()->getMp3($id_cons, $type);
	
		$html = null;
		if($type == 1){
			$html = $this->lecteurMp3Action($ListeDesSons);
		}else {
			$html = $this->lecteurMp3InstrumentalAction($ListeDesSons);
		}
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	
	//ENREGISTREMENT DES EXAMENS DU JOUR
	//ENREGISTREMENT DES EXAMENS DU JOUR
	//ENREGISTREMENT DES EXAMENS DU JOUR
	//ENREGISTREMENT DES EXAMENS DU JOUR
	//ENREGISTREMENT DES EXAMENS DU JOUR
	//ENREGISTREMENT DES EXAMENS DU JOUR
	//ENREGISTREMENT DES EXAMENS DU JOUR
	public function listeExamenDuJourAction(){
		$user = $this->layout()->user;
		$IdService = $user['IdService'];
		$id_hosp = $this->params()->fromPost('id_hosp', 0);
	
		$this->getDateHelper();
		$listeExamens = $this->getConsultationTable()->getExamenDuJour($id_hosp);
	
		$html ="";
	
		$html .='<table id="ListingExamens" class="table table-bordered tab_list_mini" >
		           <thead>
		             <tr id="nomMaj" style="height: 40px; width:100%;">
		                <th style="width: 20%; cursor: pointer;">D<minus>ate</minus></th>
		                <th style="width: 20%; cursor: pointer;">H<minus>eure</minus></th>
		                <th style="width: 50%; cursor: pointer;">P<minus>r&eacute;nom & nom m&eacute;decin</minus></th>
		                <th style="width: 10%;" >O<minus>ptions</minus></th>
		             </tr>
		           </thead>
	
		         <tbody id="donnees" class="liste_patient">';
	
		foreach ($listeExamens as $liste) {
			$html .='<tr id="ExamenDuJourLigne'.$liste['ID_EXAMEN_JOUR'].'">
					  <td> '.$this->controlDate->convertDate($liste['DATEONLY']).' </td>
					  <td> '.$this->controlDate->getTime($liste['DATE']).' </td>
					  <td> '.$liste['PrenomMedecin'].' '.$liste['NomMedecin'].' </td>
					  <td>
					  	 <a href="javascript:visualiserExamenDuJour('.$liste['ID_EXAMEN_JOUR'].')"><img style="margin-left: 5%;" src="../images_icons/voird.png" title="visualiser"></a>
					     <a href="javascript:supprimerExamenDuJour('.$liste['ID_EXAMEN_JOUR'].')"><img style="margin-left: 20%;" src="../images_icons/sup.png" title="supprimer"></a>
			  		  </td>
					</tr>';
				
		}
	
		$html .='</tbody>
				 </table>';
	
		$html .="<script>
				  initialisationScriptDataTable();
				</script>";
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
}
