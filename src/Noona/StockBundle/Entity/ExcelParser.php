<?php

namespace Noona\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProduitXml
 *
 */
class ExcelParser
{

    private $data;

    private $filename;

    public function __construct($data)
    {
        $this->setData($data);
        $this->setFilename("noona" . date('Ymd') . ".xls");
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }


    public function arrayToExcel()
    {

        $firstPassage = 0;
        $result = '';
        foreach($this->getData() as $data)
        {
            if(!$firstPassage){
                $result .= implode("\t", array_keys($data)) . "\r\n";
                $firstPassage = 1;
            }


            $result .= implode("\t", $data) . "\r\n";
        }
        return $result;
    }



}
