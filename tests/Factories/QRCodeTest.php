<?php

namespace NFePHP\NFe\Tests\Factories;

use NFePHP\NFe\Factories\QRCode;
use NFePHP\NFe\Tests\NFeTestCase;
use NFePHP\NFe\Exception\DocumentsException;

class QRCodeTest extends NFeTestCase
{
    /**
     * @covers QRCode::get
     * @covers QRCode::str2Hex
     */
    public function testPutQRTag()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');

        $token = 'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G';
        $idToken = '000001';
        $sigla = '';
        $versao = '100';
        $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';
        
        $expected = file_get_contents($this->fixturesPath.'xml/nfce_com_qrcode.xml');
        $expectedDom = new \DOMDocument('1.0', 'UTF-8');
        $expectedDom->formatOutput = false;
        $expectedDom->preserveWhiteSpace = false;
        $expectedDom->load($this->fixturesPath . 'xml/nfce_com_qrcode.xml');
        $expectedElement = $expectedDom->documentElement;
        
        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr);
        $actualDom = new \DOMDocument('1.0', 'UTF-8');
        $actualDom->formatOutput = false;
        $actualDom->preserveWhiteSpace = false;
        $actualDom->loadXML($response);
        $actualElement = $actualDom->documentElement;
        
        $this->assertEqualXMLStructure($expectedElement, $actualElement);
    }
    
    /**
     * @expectedException NFePHP\NFe\Exception\DocumentsException
     */
    public function testPutQRTagFailWithoutCSC()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');
        $token = '';
        $idToken = '000001';
        $sigla = '';
        $versao = '100';
        $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';
        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr);
    }
    
    /**
     * @expectedException NFePHP\NFe\Exception\DocumentsException
     */
    public function testPutQRTagFailWithoutCSCid()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');
        $token = 'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G';
        $idToken = '';
        $sigla = '';
        $versao = '100';
        $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';
        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr);
    }

    /**
     * @expectedException NFePHP\NFe\Exception\DocumentsException
     */
    public function testPutQRTagFailWithoutURL()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');
        $token = 'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G';
        $idToken = '000001';
        $sigla = '';
        $versao = '100';
        $urlqr = '';
        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr);
    }
}
