<?php
namespace Facturation\Form;

use Zend\Form\Form;

class AdmissionBlocForm extends Form{

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
				'name' => 'service',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Service'),
						'value_options' => array (
								''=>''
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getmontant(this.value)',
						'id' =>'service',
						'required' => true,
				)
		) );

		$this->add ( array (
				'name' => 'diagnostic',
				'type' => 'TextArea',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Diagnostic')
				),
				'attributes' => array (
						'id' => 'diagnostic',
				)
		) );
		
		
		$this->add ( array (
				'name' => 'intervention_prevue',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Intervention prévue')
				),
				'attributes' => array (
						'id' => 'intervention_prevue',
				)
		) );
		
		$this->add ( array (
				'name' => 'vpa',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','VPA')
				),
				'attributes' => array (
						'id' => 'vpa',
				)
		) );
		
		$this->add ( array (
				'name' => 'salle',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Salle')
				),
				'attributes' => array (
						'id' => 'salle',
				)
		) );
		
		$this->add ( array (
				'name' => 'operateur',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Opérateur (Dr.)')
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getservice(this.value)',
						'id' =>'operateur',
						'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'montant_avec_majoration',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Tarif (frs)')
				),
				'attributes' => array (
						'id' => 'montant_avec_majoration',
				)
		) );
		
		$this->add ( array (
				'name' => 'numero',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Numéro facture')
				),
				'attributes' => array (
						'id' => 'numero'
				)
		) );
		$this->add ( array (
				'name' => 'liste_service',
				'type' => 'Select',
				'options' => array (
						'value_options' => array (
								''=>''
						)
				),
				'attributes' => array (
						'id' => 'liste_service',
				)
		) );
		
		$this->add(array(
				'name' => 'type_facturation',
				'type' => 'Zend\Form\Element\radio',
				'options' => array (
						'value_options' => array(
								1 => 'Normal',
								2 => iconv ( 'ISO-8859-1', 'UTF-8','Prise en charge') ,
						),
				),
				'attributes' => array(
						'id' => 'type_facturation',
						'required' => true,
				),
		));
		
		$this->add(array(
				'name' => 'organisme',
				'type' => 'textarea',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Organisme')
				),
				'attributes' => array(
						'id' => 'organisme',
				),
		));
		
		$this->add(array(
				'name' => 'taux',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Taux (%)'),
						'value_options' => array(
								'' => '00',
								5  => '05',
								10 => '10',
						),
				),
				'attributes' => array(
						'registerInArrrayValidator' => true,
						'onchange' => 'getTarif(this.value)',
						'id' => 'taux',
				),
		));
		
	}
}