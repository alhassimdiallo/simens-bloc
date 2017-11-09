<?php
namespace Consultation\Form;

use Zend\Form\Form;

class ProtocoleOperatoireForm extends Form{

	public function __construct() {
		parent::__construct ();

		$this->add ( array (
				'name' => 'id_admission',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'id_admission'
				)
		) );
		
		$this->add ( array (
				'name' => 'id_patient',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'id_patient'
				)
		) );
		
		$this->add ( array (
				'name' => 'id_protocole',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'id_protocole'
				)
		) );


		$this->add ( array (
				'name' => 'anesthesiste',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Anesthésiste')
				),
				'attributes' => array (
						'id' => 'anesthesiste',
						'required' => true,
				        'tabindex' => 1,
				)
		) );
		
		
		$this->add ( array (
				'name' => 'indication',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Indication')
				),
				'attributes' => array (
						'id' => 'indication',
						'required' => true,
    				    'tabindex' => 2,
				)
		) );
		
		$this->add ( array (
				'name' => 'type_anesthesie',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Type d\'anesthésie')
				),
				'attributes' => array (
						'id' => 'type_anesthesie',
						'required' => true,
				        'tabindex' => 3,
				)
		) );
		
		$this->add ( array (
				'name' => 'protocole_operatoire',
				'type' => 'TextArea',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Protocole opératoire')
				),
				'attributes' => array (
						'id' => 'protocole_operatoire',
						'required' => true,
						'maxlength' => 5000,
    				    'tabindex' => 4,
				)
		) );
		
		$this->add ( array (
				'name' => 'soins_post_operatoire',
				'type' => 'TextArea',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Soins post Opératoire')
				),
				'attributes' => array (
						'id' => 'soins_post_operatoire',
						'maxlength' => 2500,
						'required' => true,
    				    'tabindex' => 5,
				)
		) );
		
		
		//******************************************************************************
		//******************************************************************************
		//******************************************************************************
		$this->add ( array (
		    'name' => 'check_list_securite',
		    'type' => 'Hidden',
		    'attributes' => array (
		        'id' => 'check_list_securite',
		    )
		) );
		
		
		//La liste des participants à l'opération
		//La liste des participants à l'opération
		$this->add ( array (
		    'name' => 'aides_operateurs',
		    'type' => 'TextArea',
		    'options' => array (
		        'label' => iconv('ISO-8859-1', 'UTF-8','Aides opérateurs')
		    ),
		    'attributes' => array (
		        'id' => 'aides_operateurs',
		        'tabindex' => 6,
		    )
		) );
		
		//Les complications de l'opération
		//Les complications de l'opération
		$this->add ( array (
		    'name' => 'complications',
		    'type' => 'TextArea',
		    'options' => array (
		        'label' => iconv('ISO-8859-1', 'UTF-8','Les complications')
		    ),
		    'attributes' => array (
		        'id' => 'complications',
		        'maxlength' => 2500,
		        'tabindex' => 5,
		    )
		) );
		
		//Note relative au protocole opératoire
		//Note relative au protocole opératoire
		$this->add ( array (
		    'name' => 'note_audio_cro',
		    'type' => 'TextArea',
		    'options' => array (
		        'label' => iconv('ISO-8859-1', 'UTF-8','Note')
		    ),
		    'attributes' => array (
		        'id' => 'note_audio_cro',
		        'maxlength' => 200,
		        'tabindex' => 8,
		    )
		) );
		
		//******************************************************************************
		//******************************************************************************
		//******************************************************************************
		
		//Position d'installation
		$this->add ( array (
				'name' => 'position_installation',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Position d\'installation')
				),
				'attributes' => array (
						'id' => 'position_installation',
						'tabindex' => 8,
				)
		) );
		
		//Acces veineux 
		$this->add ( array (
				'name' => 'acces_veineux',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Accès veineux')
				),
				'attributes' => array (
						'id' => 'acces_veineux',
						'tabindex' => 8,
				)
		) );
		
		//Pre-remplissage
		$this->add ( array (
				'name' => 'preremplissage',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Pré-remplissage')
				),
				'attributes' => array (
						'id' => 'preremplissage',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );

		//Antibiotique
		$this->add ( array (
				'name' => 'antibiotique',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Antibiotique')
				),
				'attributes' => array (
						'id' => 'antibiotique',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );
		
		//Monitorrage
		$this->add ( array (
				'name' => 'monitorrage',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Monitorrage')
				),
				'attributes' => array (
						'id' => 'monitorrage',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );
		
		//Type d'anesthésie
		$this->add ( array (
				'name' => 'type_anesthesie_2',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Type d\'anesthésie')
				),
				'attributes' => array (
						'id' => 'type_anesthesie_2',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );
		
		//Score de cormack
		$this->add ( array (
				'name' => 'score_cormack',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Score de cormack')
				),
				'attributes' => array (
						'id' => 'score_cormack',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );
		
		//Induction anesthesique
		$this->add ( array (
				'name' => 'induction_anesthesique',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Induction anesthésique')
				),
				'attributes' => array (
						'id' => 'induction_anesthesique',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );
		
		//Entretien anesthesique
		$this->add ( array (
				'name' => 'entretien_anesthesique',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Entretien anesthésique')
				),
				'attributes' => array (
						'id' => 'entretien_anesthesique',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );
		
		//Hemodynamique per operatoire
		$this->add ( array (
				'name' => 'hemodynamique_per_operatoire',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Hémodynamique per opératoire')
				),
				'attributes' => array (
						'id' => 'hemodynamique_per_operatoire',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );
		
		//Reveil extubation
		$this->add ( array (
				'name' => 'reveil_extubation',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Réveil / Extubation')
				),
				'attributes' => array (
						'id' => 'reveil_extubation',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );
		
		//Bilan hydrique --- Bilan hydrique --- Bilan hydrique
		//Bilan hydrique --- Bilan hydrique --- Bilan hydrique
		
		$this->add ( array (
				'name' => 'bilan_hydrique',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Bilan hydrique')
				),
				'attributes' => array (
						'id' => 'bilan_hydrique',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );
		
		$this->add ( array (
				'name' => 'entrees',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Entrées')
				),
				'attributes' => array (
						'id' => 'entrees',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );
		
		$this->add ( array (
				'name' => 'sorties',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Sorties')
				),
				'attributes' => array (
						'id' => 'sorties',
						'maxlength' => 200,
						'tabindex' => 8,
				)
		) );
		
	}
}