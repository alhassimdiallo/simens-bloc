<?php

namespace Archivage\Form;

use Zend\Form\Form;

class PatientForm extends Form {
	public function __construct($name = null) {
		parent::__construct ();

		$this->add ( array (
				'name' => 'id_personne',
				'type' => 'Hidden',
				'attributes' => array (
				)
		) );
		
		$this->add ( array (
				'name' => 'civilite',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Civilite',
						'value_options' => array (
								'Mme' => 'Mme',
								'Mlle' => 'Mlle',
								'M' => 'M'
						)
				),
				'attributes' => array (
						'id' => 'civilite',
						'value' => 'M',
				)
		) );
		
		$this->add ( array (
				'name' => 'sexe',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Sexe',
						'value_options' => array (
								'' => '',
								'Masculin' => 'Masculin',
								iconv ( 'ISO-8859-1', 'UTF-8','Féminin') => iconv ( 'ISO-8859-1', 'UTF-8','Féminin')
						)
				),
				'attributes' => array (
						'id' => 'sexe',
						'required' => true,
						'tabindex' => 1,
				)
		) );
		
		$this->add ( array (
				'name' => 'nom',
				'type' => 'Text',
				'options' => array (
						'label' => 'Nom'
				),
				'attributes' => array (
// 						'class' => 'only_Char',
						'id' => 'nom',
						'required' => true,
						'tabindex' => 2,
				)
		) );
		
		$this->add ( array (
				'name' => 'prenom',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Prénom' )
				),
				'attributes' => array (
						'id' => 'prenom',
// 						'class' => 'only_Char',
						'required' => true,
						'tabindex' => 3,
				)
		) );

		$this->add ( array (
				'name' => 'date_naissance',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date de naissance'
				),
				'attributes' => array (
						'id' => 'date_naissance',
						'required' => true,
						'tabindex' => 4,
				)
				) );
		
		$this->add ( array (
		    'name' => 'age',
		    'type' => 'Text',
		    'options' => array (
		        'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Âge' )
		    ),
		    'attributes' => array (
		        'id' => 'age',
		        'tabindex' => 4,
		        'required' => true,
		    )
		) );

		$this->add ( array (
				'name' => 'lieu_naissance',
				'type' => 'Text',
				'options' => array (
						'label' => 'Lieu de naissance'
				),
				'attributes' => array (
						'id' => 'lieu_naissance',
						'tabindex' => 5,
				)
				) );

		$this->add ( array (
				'name' => 'telephone',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Téléphone' )
				),
				'attributes' => array (
						'id' => 'telephone',
						'tabindex' => 6,
				)
		) );
		
		$this->add ( array (
				'name' => 'profession',
				'type' => 'Text',
				'options' => array (
						'label' => 'Profession'
				),
				'attributes' => array (
						'id' => 'profession',
						'tabindex' => 7,
				)
		) );
		
		$this->add ( array (
				'name' => 'adresse',
				'type' => 'Text',
				'options' => array (
						'label' => 'Adresse'
				),
				'attributes' => array (
						'id' => 'adresse',
						'tabindex' => 8,
				)
		) );
		
		$this->add ( array (
				'type' => 'Zend\Form\Element\Email',
				'name' => 'email',
				'options' => array (
						'label' => 'Email'
				),
				'attributes' => array (
						'placeholder' => 'votre@domain.com',
						'id' => 'email',
						'tabindex' => 9,
				)
		) );
		
		$this->add ( array (
				'name' => 'nationalite_origine',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8','Nationalité origine'),
				),
				'attributes' => array (
						'id' => 'nationalite_origine',
						'tabindex' => 10,
				)
		) );
		
		$this->add ( array (
				'name' => 'nationalite_actuelle',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8','Nationalité actuelle'),
						'value_options' => array (
								'' => ''
						)
				),
				'attributes' => array (
						'id' => 'nationalite_actuelle',
						'tabindex' => 11,
				)
		
		) );
		
		$this->add ( array (
				'name' => 'submit',
				'type' => 'Submit',
				'options' => array (
						'label' => 'Sauvegarder'
				)
		) );
	}
}