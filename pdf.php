<?php
// Start session to get values from session array
session_start();

require 'fpdf/fpdf.php';


class PDF extends FPDF {
// Page header
    function Header() {
        // Left logo
        $this->Image('left.gif', 10, 16, 30);

        // Center logo
        $this->Image('center.png', 93, 16, 20, 30);

        // Right logo
        $this->Image('right.gif', 170, 16, 30);

        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);

        $this->SetY(26);

        // Move to the right
        $this->Cell(80);

        // Title
        $this->Cell(30, 65, 'Government of India', 0, 0, 'C');

        $this->SetFont('Arial', '', 12);
        $this->SetX(90);
        $this->Cell(30, 80, 'Chief Registrar of Births and Deaths', 0, 0, 'C');

        $this->SetFont('Arial', 'U', 12);
        $this->SetX(90);
        $this->Cell(30, 95, 'Birth Certificate', 0, 0, 'C');

        $this->SetFont('Arial', '', 12);
        $this->SetX(90);
        $this->Cell(30,110,'(Issued Under Section 12/17 of the RBDAct, 1969 and Rule 8/13 of the KRDB Rules, 1999)',0, 0, 'C');
        // Line break
        $this->Ln(20);

        $this->SetFont('Times', '', 13);

        // Page border
        $this->Rect(5, 5, 200, 285, 'D');

        $this->Cell(0,85,'This is to certify that the following information has been taken from the original record of birth which ', 0, 0, 'L');
        $this->SetX(10);
        $this->Cell(0, 100, 'is the register for '.$_SESSION["city"].' of India', 0, 0, 'L');

        $this->SetFont('Times', '', 15);
        $this->SetX(30);
        $this->Cell(0, 125, '1) Name : '.$_SESSION["name"], 0, 0, 'L');

        $this->SetX(30);
        $this->Cell(0, 140, '2) Gender : '.$_SESSION["gender"],0, 0, 'L');

        $this->SetX(30);
        $this->Cell(0, 155, '3) Date of Birth : '.$_SESSION["dob"], 0, 0, 'L');

        $this->SetX(30);
        $this->Cell(0, 170, '4) Place of Birth : '.$_SESSION["hospital"].', '.$_SESSION["city"], 0, 0, 'L');

        $this->SetX(30);
        $this->Cell(0, 185, '5) Father\'s Name : '.$_SESSION["fName"], 0, 0, 'L');

        $this->SetX(30);
        $this->Cell(0, 200, '6) Mother\'s Name : '.$_SESSION["mName"],0, 0, 'L');

        $this->SetX(30);
        $this->Cell(0, 215, '7) Permanent address of Parents :', 0, 0, 'L');

        $this->SetX(40);
        $this->Cell(0, 230, $_SESSION["address"], 0, 0, 'L');


        $this->SetX(30);
        $this->Cell(0, 270, '8) Date of Registration : '.$_SESSION["dob"], 0, 0, 'L');

        $this->SetX(30);
        $this->Cell(0, 285, '9) Date of Issue : '.date("d-m-Y"), 0, 0, 'L');

    }

    // Page footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 15
        $this->SetFont('Times', 'I', 15);

        $this->SetY(-23);
        $this->Cell(0, 10, 'This is a computer generated birth certificate.', 0, 0, 'C');

        $this->SetY(-15);
        $this->Cell(0, 10, '"Ensure registration of every birth and death."', 0, 0, 'C');
    }

}


$pdf = new PDF();

$pdf->Output();


