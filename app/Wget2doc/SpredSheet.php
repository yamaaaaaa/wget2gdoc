<?php

namespace app\Wget2doc;

class SpredSheet extends Client
{
	
	private $spreadSheetId;
	private $sheetId;
	
	public function __construct($spreadsheetId, $spreadSheetName)
	{
		
		$this->spreadSheetId = $spreadsheetId;
		$this->spreadSheetName = $spreadSheetName;
		
		parent::__construct();
		
		$this->client->addScope(\Google_Service_Sheets::SPREADSHEETS);
		$this->client->setApplicationName('wget2doc');
		
	}
	
	public function upload($output)
	{
		$valueRange = new \Google_Service_Sheets_ValueRange();
		$valueRange->setValues($output);
		$range = $this->spreadSheetName . '!A1:A';
		$conf = ["valueInputOption" => "USER_ENTERED"];
		$this->service->spreadsheets_values->append($this->spreadSheetId, $range, $valueRange, $conf);
	}
	
	
}