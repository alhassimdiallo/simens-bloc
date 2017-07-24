<?php
namespace Consultation\View\Helpers;

use Zend\View\Helper\AbstractHelper;
use ZendPdf\PdfDocument;
use ZendPdf\Page;

class DocumentPdf extends AbstractHelper{
	
	protected $_pdf;
	
	public function __construct()
	{
		$this->_pdf = new PdfDocument();;
	}
	
	public function addPage(Page $page)
	{
		$this->_pdf->pages[] = $page;
	}
	
	public function getDocument()
	{
		header('Content-Type: application/pdf; charset=utf-8') ;
		echo $this->_pdf->render();
	}
}