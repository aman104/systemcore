<?php

class STG_WFirma_API {

	private $apiCalls = array(
	 'contractor_add' => 'http://api2.wfirma.pl/contractors/add',
     'contractor_edit' => 'http://api2.wfirma.pl/contractors/edit/{ID_KONTRAHENTA}',    
     'invoice_add' => 'http://api2.wfirma.pl/invoices/add',
     'invoice_download' => 'http://api2.wfirma.pl/invoices/download/{ID_FAKTURY}'
	);

	private $login = 'psalajczyk@gmail.com';
	private $password = 'd4de0fm';

	private $inputFormat = 'xml';
	private $outputFormat = 'json';

	private static $instance = null;

	static function getInstance()
	{
		if(!self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function addInvoice($client_id = null, Payment $payment, $type = 'normal') // $type = 'receipt_normal' dla paragonów niefiskalnych
	{		

		$vat = '23';

		$request = '<?xml version="1.0" encoding="UTF-8"?>
		<api>
		    <invoices>
		        <invoice>';

		if($client_id)
		{
			$request .= '<contractor>
		                <id>'.$client_id.'</id>
		            </contractor>';	
		}


		$request .= '<paymentmethod>transfer</paymentmethod>
		            <currency>PLN</currency>
		            <alreadypaid_initial>'.$payment->getRealPrice().'</alreadypaid_initial>
		            <type>'.$type.'</type>
		 
		            <date>'.date('Y-m-d', time()).'</date>
		 
		            <invoicecontents>
		                <invoicecontent>
		                    <name>Doładowanie '.$payment->getPoints().' punktów</name>
		                    <unit>szt.</unit>
		                    <count>1</count>
		                    <price>'.$payment->getNettoPrice().'</price>		                    	
		                    <vat>'.$vat.'</vat>
		                </invoicecontent>
		            </invoicecontents>
		';


		//$request .= '<translation_language><id>1</id></translation_language>';


		$request .= '
		        </invoice>
		    </invoices>
		</api>';

		return $this->callRequest($this->apiCalls['invoice_add'], $request);
	}

	public function addContractor($data, $edit_force = false)
	{
		$request = '<?xml version="1.0" encoding="UTF-8"?>
		<api>
		    <contractors>
		        <contractor>
		            <name>'.$data['name'].'</name>
		            <altname>'.$data['name'].'</altname>
		            <nip>'.$data['nip'].'</nip>
		            <street>'.$data['street'].'</street>
		            <zip>'.$data['zip'].'</zip>
		            <city>'.$data['city'].'</city>
		            <country>'.$data['country'].'</country>
		            <email>'.$data['email'].'</email>
		        </contractor>
		    </contractors>
		</api>';		

		if(!$edit_force)
		{
			$url = $this->apiCalls['contractor_add'];	
		}
		else
		{
			$url = $this->apiCalls['contractor_edit'];
			$url = str_replace('{ID_KONTRAHENTA}', $edit_force, $url);
		}


		return $this->callRequest($url, $request);
	}

	public function downloadInvoice($invoice_id)
	{

		$request = '<?xml version="1.0" encoding="UTF-8"?>
		<api>
		    <invoices>
		        <parameters>		 
			    	<parameter>
			        	<name>page</name>
				    	<value>invoice</value>
	            	</parameter>		 		 
				</parameters>
		    </invoices>
		</api>';

		$url = $this->apiCalls['invoice_download'];
		$url = str_replace('{ID_FAKTURY}', $invoice_id, $url);

		return $this->callRequest($url, $request);
	}

	private function callRequest($call, $request)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $call.'?inputFormat='.$this->inputFormat.'&outputFormat='.$this->outputFormat);
		curl_setopt($ch, CURLOPT_POST,   1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
		$response = curl_exec($ch); 
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close($ch); 

        return $response;
	}

}