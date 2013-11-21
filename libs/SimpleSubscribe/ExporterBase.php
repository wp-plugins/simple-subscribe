<?php

/**
 * This file is part of the Simple Subscribe plugin.
 *
 * Copyright (c) 2013 Martin Pícha (http://latorante.name)
 *
 * For the full copyright and license information, please view
 * the SimpleSubscribe.php file in root directory of this plugin.
 */

namespace SimpleSubscribe;


// php-export-data - inspired by Eli Dickinson, http://github.com/elidickinson/php-export-data
/**
 * ExporterBase is the base class for exporters to specific file formats. See other
 * classes below.
 */

abstract class ExporterBase
{
    /** @var string Set in constructor to one of 'browser', 'string' */
	protected $exportTo;
    /** @var stringData so far, used if export string mode */
	protected $stringData;
    /** @var handle to temp file (for export file mode) */
	protected $tempFile;
    /** @var temp file name and path (for export file mode) */
	protected $tempFilename;
    /** @var string file mode: the output file name; browser mode: file name for download; string mode: not used */
	public $filename;


    /**
     * Constructor
     *
     * @param string $exportTo
     * @param string $filename
     */

    public function __construct($exportTo = "browser", $filename = "exportdata")
    {
		if(!in_array($exportTo, array('browser', 'string'))){
			throw new Exception("$exportTo is not a valid ExporterBase export type");
		}
		$this->exportTo = $exportTo;
		$this->filename = $filename;
        $this->initialize();
	}


    /**
     * init
     */

    public function initialize()
    {
		switch($this->exportTo) {
			case 'browser':
			case 'string':
				$this->stringData = '';
				break;
		}

	}


    /**
     * AddRow
     *
     * @param $row
     */

    public function addRow($row){ $this->write($this->generateRow($row)); }


    /**
     * Finialize
     */

    public function finalize()
    {

		switch($this->exportTo){
			case 'browser':
                $this->sendHttpHeaders();
                $this->write($this->generateHeader());
				echo $this->getString();
                $this->write($this->generateFooter());
				break;
			case 'string':
				break;
		}

	}


    /**
     * Get's string data
     *
     * @return mixed
     */

    public function getString(){ return $this->stringData; }


    /**
     * Sends headers
     *
     * @return mixed
     */

    abstract public function sendHttpHeaders();


    /**
     * Write
     *
     * @param $data
     */

    protected function write($data)
    {
		switch($this->exportTo) {
			case 'browser':
			case 'string':
				$this->stringData .= $data;
				break;
		}
	}


    /**
     * Overwritables
     */

    protected function generateHeader(){}
	protected function generateFooter(){}
	abstract protected function generateRow($row);
}


/**
 * ExporterBaseTSV - Exports to TSV (tab separated value) format.
 */

class ExporterTSV extends ExporterBase
{

    /**
     * Generate row
     *
     * @param $row
     * @return string
     */

    function generateRow($row)
    {
		foreach ($row as $key => $value) {
			// Escape inner quotes and wrap all contents in new quotes.
			// Note that we are using \" to escape double quote not ""
			$row[$key] = '"'. str_replace('"', '\"', $value) .'"';
		}
		return implode("\t", $row) . "\n";
	}


    /**
     * TSV headers
     *
     * @return mixed|void
     */

    function sendHttpHeaders()
    {
		header("Content-type: text/tab-separated-values");
        header("Content-Disposition: attachment; filename=".basename($this->filename));
	}
}


/**
 * ExporterXML - Exports to XML.
 */

class ExporterXML
{

    var $dom;
    var $subscribers;
    var $fileName;

    /**
     * Constructor, cretes xml document header and body
     */

    public function __construct($fileName)
    {
        $this->dom = new \DomDocument("1.0", "UTF-8");
        $this->subscribers = $this->dom->createElement('subscribers');
        $this->fileName = $fileName;
    }


    /**
     * Adds row
     *
     * @param $data
     */

    public function addRow($data)
    {
        $subscriber = $this->dom->createElement('subscriber');
        foreach($data as $key => $value){
            $subscriber->appendChild($this->dom->createElement($key, $value));
        }
        $this->subscribers->appendChild($subscriber);
    }


    /**
     * Prints out
     */

    public function finalize()
    {
        $this->dom->appendChild($this->subscribers);
        $this->dom->formatOutput = true;
        $this->sendHttpHeaders();
        echo $this->dom->saveXML();
    }


    /**
     * XML headers
     *
     * @return mixed|void
     */

    function sendHttpHeaders()
    {
        header("Content-type: text/xml");
        header("Content-Disposition: attachment; filename=".basename($this->fileName));
    }
}


/**
 * ExporterBaseCSV - Exports to CSV (comma separated value) format.
 */

class ExporterCSV extends ExporterBase
{

    /**
     * Generates row
     *
     * @param $row
     * @return string
     */

    function generateRow($row)
    {
		foreach($row as $key => $value){
			$row[$key] = '"'. str_replace('"', '\"', $value) .'"';
		}
		return implode(",", $row) . "\n";
	}


    /**
     * CSV Headers
     *
     * @return mixed|void
     */

    function sendHttpHeaders()
    {
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=".basename($this->filename));
	}
}


/**
 * ExporterBaseExcel exports data into an XML format  (spreadsheetML) that can be
 * read by MS Excel 2003 and newer as well as OpenOffice
 *
 * Creates a workbook with a single worksheet (title specified by
 * $title).
 *
 * Note that using .XML is the "correct" file extension for these files, but it
 * generally isn't associated with Excel. Using .XLS is tempting, but Excel 2007 will
 * throw a scary warning that the extension doesn't match the file type.
 *
 * Based on Excel XML code from Excel_XML (http://github.com/oliverschwarz/php-excel)
 *  by Oliver Schwarz
 */

class ExporterExcel extends ExporterBase
{

	const XmlHeader = "<?xml version=\"1.0\" encoding=\"%s\"?\>\n<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\">";
	const XmlFooter = "</Workbook>";

	public $encoding = 'UTF-8'; // encoding type to specify in file.
	public $title = 'Subscribers'; // title for Worksheet


    /**
     * Generate header
     *
     * @return string|void
     */

    function generateHeader()
    {
		$output = stripslashes(sprintf(self::XmlHeader, $this->encoding)) . "\n";
		$output .= "<Styles>\n";
		$output .= "<Style ss:ID=\"sDT\"><NumberFormat ss:Format=\"Short Date\"/></Style>\n";
		$output .= "</Styles>\n";
		$output .= sprintf("<Worksheet ss:Name=\"%s\">\n    <Table>\n", htmlentities($this->title));
		return $output;
	}


    /**
     * Generate footer
     *
     * @return string|void
     */

    function generateFooter()
    {
		$output = '';
		$output .= "    </Table>\n</Worksheet>\n";
		$output .= self::XmlFooter;
		return $output;
	}


    /**
     * Generate row
     *
     * @param $row
     * @return string
     */

    function generateRow($row)
    {
		$output = '';
		$output .= "        <Row>\n";
		foreach ($row as $k => $v) {
			$output .= $this->generateCell($v);
		}
		$output .= "        </Row>\n";
		return $output;
	}


    /**
     * Generate a Cell
     *
     * @param $item
     * @return string
     */

    private function generateCell($item)
    {
		$output = '';
		$style = '';

		// Tell Excel to treat as a number. Note that Excel only stores roughly 15 digits, so keep
		// as text if number is longer than that.
		if(preg_match("/^-?\d+(?:[.,]\d+)?$/",$item) && (strlen($item) < 15)) {
			$type = 'Number';
		}

		// Sniff for valid dates; should look something like 2010-07-14 or 7/14/2010 etc. Can
		// also have an optional time after the date.
		//
		// Note we want to be very strict in what we consider a date. There is the possibility
		// of really screwing up the data if we try to reformat a string that was not actually
		// intended to represent a date.
		elseif(preg_match("/^(\d{1,2}|\d{4})[\/\-]\d{1,2}[\/\-](\d{1,2}|\d{4})([^\d].+)?$/",$item) &&
					($timestamp = strtotime($item)) &&
					($timestamp > 0) &&
					($timestamp < strtotime('+500 years'))) {
			$type = 'DateTime';
			$item = strftime("%Y-%m-%dT%H:%M:%S",$timestamp);
			$style = 'sDT'; // defined in header; tells excel to format date for display
		}
		else {
			$type = 'String';
		}

		$item = str_replace('&#039;', '&apos;', htmlspecialchars($item, ENT_QUOTES));
		$output .= "            ";
		$output .= $style ? "<Cell ss:StyleID=\"$style\">" : "<Cell>";
		$output .= sprintf("<Data ss:Type=\"%s\">%s</Data>", $type, $item);
		$output .= "</Cell>\n";

		return $output;
	}


    /**
     * XLS Headers
     *
     * @return mixed|void
     */

    function sendHttpHeaders()
    {
		header("Content-Type: application/vnd.ms-excel; charset=" . $this->encoding);
		header("Content-Disposition: inline; filename=\"" . basename($this->filename) . "\"");
	}

}