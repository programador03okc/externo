<?php

namespace App\Helpers\Proformas;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Common\Entity\Row;
use Carbon\Carbon;

class ProformaExport
{
    private $libro;

    function __construct()
    {
        $this->libro = WriterEntityFactory::createXLSXWriter();
    }

    public function exportar($data)
    {
        $this->libro->openToBrowser("Proformas.xlsx");
        $this->generarFechaExportacion();
        $this->generarCabecera();
        $this->generarContenido($data);
        $this->libro->close();
    }

    private function generarContenido($data)
    {
        $estiloFecha=(new StyleBuilder())->setCellAlignment(CellAlignment::CENTER)->setFormat('dd-mm-YYYY')->build();
        
        $estiloCentrar=(new StyleBuilder())->setCellAlignment(CellAlignment::CENTER)->build();
        foreach ($data as $proforma) {
            $fechaEmision = new Carbon($proforma->fecha_emision);
            $fechaLimite = new Carbon($proforma->fecha_limite);
            $celdas = [
                WriterEntityFactory::createCell($proforma->requerimiento),
                WriterEntityFactory::createCell($proforma->proforma),
                WriterEntityFactory::createCell($proforma->tipo=='co' ? 'COMPRA ORDINARIA' : 'GRAN COMPRA'),
                WriterEntityFactory::createCell($proforma->entidad),
                WriterEntityFactory::createCell($proforma->departamento),
                WriterEntityFactory::createCell(25569+(gmmktime(0, 0, 0, $fechaEmision->month, $fechaEmision->day, $fechaEmision->year)/86400),$estiloFecha),
                WriterEntityFactory::createCell(25569+(gmmktime(0, 0, 0, $fechaLimite->month, $fechaLimite->day, $fechaLimite->year)/86400),$estiloFecha),
                
                WriterEntityFactory::createCell($proforma->acuerdo_marco),
                WriterEntityFactory::createCell($proforma->catalogo),
                WriterEntityFactory::createCell($proforma->categoria),
                WriterEntityFactory::createCell($proforma->marca),
                WriterEntityFactory::createCell($proforma->modelo),
                WriterEntityFactory::createCell($proforma->part_no),
                WriterEntityFactory::createCell($proforma->producto),
                WriterEntityFactory::createCell($proforma->cantidad),
                WriterEntityFactory::createCell($proforma->sistema_operativo),
                WriterEntityFactory::createCell($proforma->suite_ofimatica),
                WriterEntityFactory::createCell($proforma->windows==1 ? 'SI' : 'NO',$estiloCentrar),
                WriterEntityFactory::createCell($proforma->office==1 ? 'SI' : 'NO',$estiloCentrar),
                /*WriterEntityFactory::createCell($proforma->empresa,$estiloCentrar),
                WriterEntityFactory::createCell($proforma->moneda_ofertada,$estiloCentrar),
                WriterEntityFactory::createCell((float)$proforma->precio_unitario_base,$estiloNumero),
                WriterEntityFactory::createCell($proforma->software_educativo,$estiloCentrar),
                WriterEntityFactory::createCell((int)$proforma->cantidad),
                WriterEntityFactory::createCell($proforma->estado,$estiloCentrar),
                WriterEntityFactory::createCell($proforma->plazo_publicar),
                WriterEntityFactory::createCell((float)$proforma->precio_publicar,$estiloNumero),
                WriterEntityFactory::createCell((float)$proforma->costo_envio_publicar,$estiloNumero),
                WriterEntityFactory::createCell($proforma->usuario),
                WriterEntityFactory::createCell($fechaCotizacion==null ? "" : 25569+(gmmktime($fechaCotizacion->hour, $fechaCotizacion->minute, $fechaCotizacion->second, $fechaCotizacion->month, $fechaCotizacion->day, $fechaCotizacion->year)/86400),$estiloFechaHora),
                WriterEntityFactory::createCell($proforma->ultimo_comentario)*/
            ];
            $this->libro->addRow(WriterEntityFactory::createRow($celdas));
        }

    }

    private function generarFechaExportacion()
    {
        $this->libro->addRow(WriterEntityFactory::createRow([WriterEntityFactory::createCell('Generado el: '.date('d-m-Y')),]));
        /*$fila = 5;
        $this->hoja->setCellValue("A$fila", "Generado el " . (new Carbon())->format("d/m/Y"));*/
    }


    private function generarCabecera()
    {
        $this->libro->addRow(WriterEntityFactory::createRow([]));
        $filaTitulo=WriterEntityFactory::createRow([ 
            WriterEntityFactory::createCell(''),WriterEntityFactory::createCell(''),WriterEntityFactory::createCell(''),WriterEntityFactory::createCell(''),
            WriterEntityFactory::createCell(''),WriterEntityFactory::createCell(''),WriterEntityFactory::createCell(''),WriterEntityFactory::createCell(''),
            WriterEntityFactory::createCell(''),WriterEntityFactory::createCell('Lista de proformas')]);
        $estilosTitulo= (new StyleBuilder())
        ->setFontBold()->setFontSize(16)
        ->setCellAlignment(CellAlignment::CENTER)
        ->build();
        
        $filaTitulo->setStyle($estilosTitulo);
        $this->libro->addRow($filaTitulo);
        //$this->libro->setMergeRanges(['A2:J2']);
        $this->libro->addRow(WriterEntityFactory::createRow([]));

        $celdas = [
            WriterEntityFactory::createCell('Requerimiento'),
            WriterEntityFactory::createCell('Proforma'),
            WriterEntityFactory::createCell('Tipo de proforma'),
            WriterEntityFactory::createCell('Entidad'),
            WriterEntityFactory::createCell('Departamento entrega'),
            WriterEntityFactory::createCell('Fecha de emisión'),
            WriterEntityFactory::createCell('Fecha límite'),
            WriterEntityFactory::createCell('Acuerdo marco'),
            WriterEntityFactory::createCell('Catálogo'),
            WriterEntityFactory::createCell('Categoría'),
            WriterEntityFactory::createCell('Marca'),
            WriterEntityFactory::createCell('Modelo'),
            WriterEntityFactory::createCell('Nro. Parte'),
            WriterEntityFactory::createCell('Descripción completa producto'),
            WriterEntityFactory::createCell('Cantidad'),
            WriterEntityFactory::createCell('Sistema operativo'),
            WriterEntityFactory::createCell('Suite ofimática'),
            WriterEntityFactory::createCell('Incluye Windows'),
            WriterEntityFactory::createCell('Incluye Office'),
            
        ];
        $filaColumnas=WriterEntityFactory::createRow($celdas);
        $estilosColumnas= (new StyleBuilder())
        ->setFontBold()
        ->setCellAlignment(CellAlignment::CENTER)
        ->build();
        $filaColumnas->setStyle($estilosColumnas);
        $this->libro->addRow($filaColumnas);
    }

}
