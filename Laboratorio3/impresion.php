<?php
    require('codigos/fpdf.php');

   class PDF extends FPDF{

    const SEPARATOR_LINE_THICKNESS = 1.5;
    function Header() {
        $this->SetFillColor(63, 126, 130);
        $this->Rect(0, 0, $this->GetPageWidth(), 30, 'F'); 
        $this->SetFillColor(255, 255, 255);
        $this->Image('imagenes/logos/perfil-del-usuario.png', 10, 5, 20);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(255, 255, 255);
        $this->SetX(40);
        $this->Cell(0, 10, utf8_decode('Employees'), 0, 1, 'l');
        $this->Ln(8);
    }

    function Footer(){ 
       $this->SetY(-15);
       $this->SetFont('Arial','I',8);
       $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }

    public function headerTable(){
        $this->Ln(1);
        $this->SetFont('Arial','',12);
        $this->SetFillColor(200,220,255);
        $this->Cell(40, 6, 'Title', 1, 0, 'C', true);
        $this->Cell(30, 6, 'From Date', 1, 0, 'C', true);
        $this->Cell(30, 6, 'To Date', 1, 0, 'C', true);
        $this->Cell(30, 6, 'From Date ', 1, 0, 'C', true);
        $this->Cell(30, 6, 'To Date ', 1, 0, 'C', true);
        $this->Cell(30, 6, 'Salary', 1, 1, 'C', true);
        $this->Ln(0);
    }
    


    public function reportePasado($Title, $FromDate, $ToDate1, $FromDate1, $ToDate2,
                                   $Salary){
        $this->Ln(2);
        $this->SetFont('Arial','',10);
        $this->SetFillColor(200,220,255);
        $this->Cell(40, 6, $Title, 1);
        $this->Cell(30, 6, $FromDate, 1);
        $this->Cell(30, 6, $ToDate1, 1);
        $this->Cell(30, 6, $FromDate1, 1);
        $this->Cell(30, 6, $ToDate2, 1);
        $this->Cell(30, 6, $Salary, 1);

        $this->Ln(4);
    }

    public function reporteActual($Title, $FromDate, $ToDate1, $FromDate1, $ToDate2,
                                   $Salary){
        $this->Ln(1);
        $this->SetFont('Arial','',10);
        $this->SetFillColor(200,220,255);
        $this->Cell(40, 6, $Title, 1);
        $this->Cell(30, 6, $FromDate, 1);
        $this->Cell(30, 6, $ToDate1, 1);
        $this->Cell(30, 6, $FromDate1, 1);
        $this->Cell(30, 6, $ToDate2, 1);
        $this->Cell(30, 6, $Salary, 1);

        $this->Ln(4);
    }

    public function addSeparatorLine($r, $g, $b) {
        $x = $this->GetX();
        $y = $this->GetY() + 2.9;
        $this->SetLineWidth(self::SEPARATOR_LINE_THICKNESS);
        $this->SetDrawColor($r, $g, $b);
        $this->Line($x, $y, $this->GetPageWidth() - $this->lMargin - $this->rMargin + 10, $y);
        $this->SetXY($x, $y + self::SEPARATOR_LINE_THICKNESS);
        $this->SetDrawColor(0, 0, 0); 
        $this->SetLineWidth(0.2);
    }
 }

 $pdf=new PDF();
 $pdf->AliasNbPages();
 $pdf->AddPage();
 $pdf->SetFont('Times','',12);
 $pdf->SetTextColor(63, 126, 130);
 $pdf->Cell(20,12,utf8_decode('Human Resources Department'),0,1,'',false);
 $pdf->Cell(20,1,utf8_decode('Salaries Study Summary'),0,1,'',false);
 $pdf->SetTextColor(0,0,0);
 $pdf->Cell(20,10,utf8_decode(''),0,1,'',false);
 include_once("codigos/conexion.inc"); datos
 if (isset($_GET['id'])) {
    $id = $_GET['id'];
 $sql = "
 select * from employees where emp_no = $id;
     ";
$infoEmpleado = mysqli_query($conex, $sql) or die(mysqli_error($conex));
$infoEmpleado = mysqli_fetch_array($infoEmpleado);
$pdf->Cell(20,1,utf8_decode('Employee                     ').$infoEmpleado['emp_no'].(' - ').$infoEmpleado['first_name'].' '.$infoEmpleado['last_name'].
('                                            Hire date            ').$infoEmpleado['hire_date'],0,1,'',false);
$pdf->addSeparatorLine(63, 126, 130);

$sql = "
 SELECT
     'Staff' AS Title,
     DATE_FORMAT(e.hire_date, '%Y-%m-%d') AS FromDate,
     '1996-09-12' AS ToDate1,
     DATE_FORMAT(de.from_date, '%Y-%m-%d') AS FromDate1,
     DATE_FORMAT(de.to_date, '%Y-%m-%d') AS ToDate2,
     s.salary AS Salary
 FROM
     employees e
 JOIN
     dept_emp de ON e.emp_no = de.emp_no AND de.to_date < CURDATE()
 JOIN
     salaries s ON e.emp_no = s.emp_no AND s.to_date < CURDATE()
 WHERE
     e.emp_no = $id
 ORDER BY
     de.from_date;
";
$Regis = mysqli_query($conex, $sql) or die(mysqli_error($conex));

$isFirstRow = true; 
$pdf->headerTable(); 
if (mysqli_num_rows($Regis) > 0) {
 while ($row = mysqli_fetch_assoc($Regis)) {
     if ($isFirstRow) {
         $pdf->reportePasado(
             $row['Title'],
             $row['FromDate'],
             $row['ToDate1'],
             $row['FromDate1'],
             $row['ToDate2'],
             $row['Salary']
         );
         $isFirstRow = false; 
     } else {
         $pdf->reportePasado(
             '', 
             '',
             '',
             $row['FromDate1'],
             $row['ToDate2'],
             $row['Salary']
         );
     }
 }
} else{
 $pdf->reportePasado(
     '',
     '',
     '',
     '',
     '',
     ''
 );
}
$pdf->Cell(20,3,utf8_decode(''),0,1,'',false);
$pdf->addSeparatorLine(63, 126, 130);

$sql2 = "
 SELECT
     'Staff' AS Title,
     DATE_FORMAT(e.hire_date, '%Y-%m-%d') AS FromDate,
     IFNULL(NULLIF(DATE_FORMAT(de.to_date, '%Y-%m-%d'), '9999-01-01'), 'Current position') AS ToDate1,
     DATE_FORMAT(de.from_date, '%Y-%m-%d') AS FromDate1,
     IFNULL(NULLIF(DATE_FORMAT(de.to_date, '%Y-%m-%d'), '9999-01-01'), 'Today') AS ToDate2,
     YEAR(de.from_date) AS FromYear,
     s.salary AS Salary
 FROM
     employees e
 LEFT JOIN
     dept_emp de ON e.emp_no = de.emp_no
 LEFT JOIN
     salaries s ON e.emp_no = s.emp_no
 WHERE
     e.emp_no = $id AND (de.to_date >= CURDATE() OR de.to_date IS NULL) AND (s.to_date >= CURDATE() OR s.to_date IS NULL)
 ORDER BY
     de.from_date;
";

$Regis2 = mysqli_query($conex, $sql2) or die(mysqli_error($conex));

$isFirstRow2 = true; 
$pdf->headerTable();
while ($row = mysqli_fetch_assoc($Regis2)) {
 if ($isFirstRow) {
     $pdf->reporteActual(
         $row['Title'],
         $row['FromDate'],
         $row['ToDate1'],
         $row['FromDate1'],
         $row['ToDate2'],
         $row['Salary']
     );
     $isFirstRow2 = false;
 } else {
     $pdf->reporteActual(
         '',
         '',
         '',
         $row['FromDate1'],
         $row['ToDate2'],
         $row['Salary']
     );
 }
}
$pageWidth = $pdf->GetPageWidth();
$xCentered = ($pageWidth - $pdf->GetStringWidth('---====(End Summary)====---')) / 2;
$pdf->SetX($xCentered);
$pdf->SetTextColor(63, 126, 130);
$pdf->Cell(8, 12, utf8_decode('                                ---====(End Summary)====---'), 0, 1, 'C', false);
}else{
    echo "No se encontro el empleado";
}
$pdf->Output();


?>
  