<?php 

include_once __DIR__.'/../../library/pdf/tcpdf.php';

class MyPdf extends TCPDF 
{

    //Page header
    public function Header() 
    {
        // Logo
        date_default_timezone_set('Africa/Lagos'); 
        if (count($this->pages) === 1):
            $date = date('F d, Y h:i:s a');
            $image_file = '../assets/images/10.png';
            $this->Cell(0, 15, $date, 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $this->Image($image_file, 40, 8, 20, '', 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
            $this->Ln(25);
            // Set font
            $this->SetFont('helvetica', 'B', 20);
            // Title
            $this->Cell(0, 25, PDF_HEADER_TITLE, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        endif;
        
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}