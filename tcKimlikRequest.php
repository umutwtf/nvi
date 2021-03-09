<?php

class NVI
{

    protected $tcKimlikNo;
    protected $ad;
    protected $soyad;
    protected $dogumYili;

    public function __construct($tcKimlikNo, $ad, $soyad, $dogumYili)
    {
        $this->tcKimlikNo = $tcKimlikNo;
        $this->ad = $ad;
        $this->soyAd = $soyad;
        $this->dogumYili = $dogumYili;
    }

    public function getFilter($str)
    {
        $str = strip_tags($str);
        $str = mb_strtoupper($str,"UTF-8");
        return $str;
    }

    public function getXmlForm()
    {
        return '<?xml version="1.0" encoding="utf-8"?>
      <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
      <soap:Body>
      <TCKimlikNoDogrula xmlns="http://tckimlik.nvi.gov.tr/WS">
      <TCKimlikNo>' . $this->getFilter($this->tcKimlikNo) . '</TCKimlikNo>
      <Ad>' . $this->getFilter($this->ad) . '</Ad>
      <Soyad>' . $this->getFilter($this->soyad) . '</Soyad>
      <DogumYili>' . $this->getFilter($this->dogumYili) . '</DogumYili>
      </TCKimlikNoDogrula>
      </soap:Body>
      </soap:Envelope>';
    }

    public function tcKimlikDogrula()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getXmlForm());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'POST /Service/KPSPublic.asmx HTTP/1.1',
            'Host: tckimlik.nvi.gov.tr',
            'Content-Type: text/xml; charset=utf-8',
            'SOAPAction: "http://tckimlik.nvi.gov.tr/WS/TCKimlikNoDogrula"',
            'Content-Length: ' . strlen($this->getXmlForm())
        ));
        $dataRequestSoap = curl_exec($ch);
        curl_close($ch);
        return strip_tags($dataRequestSoap);
    }
}
