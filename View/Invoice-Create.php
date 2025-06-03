
<?php
 class PDF extends FPDF
{
    public function header()
    {
        $this->Image('assets/img/logo.jpeg', 10, 8, 35); 
        $this->SetFont('Arial', 'B', 19);
        $this->Cell(0, 0, 'Infinity Education Point', 0, 0, 'C');
        $this->SetY(13);
        $this->SetX(14);
        $this->Cell(0, 0, '____________________', 0, 0, 'C');
        $this->SetY(20);
        $this->SetX(16);
        $this->SetFont('Arial', '', 14);
        $this->Cell(0, 0, 'Infinity Fee Receipt', 0, 0, 'C');
        $this->SetFont('Arial', 'B', 13);
        $this->SetXY(10, 43); 
        $this->SetFont('Arial', 'i', 11);
        $this->SetY(25);
        $this->SetX(153);
        $this->Cell(0, 0, '7000875988, 6266995591', 0, 0);
        $this->SetY(30);
        $this->SetX(135);
        $this->MultiCell(0, 0, 'infinityeducationcenter3@gmail.com', 0, 0); 
        // $this->SetY(33);
        // $this->SetX(137);
        
        // $this->MultiCell(0, 6, 'Jabalpur, Madhya Pradesh 482005', 0, 0); 

        $this->Ln();        
    }
}


// Create PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(15);
$total_pay=0;
foreach ($InstalmentData['Data'] as $InstalmentData) { 
  $total_pay +=$InstalmentData->total_pay;
} 

foreach ($selectData['Data'] as $student) {
   $role_number= $student->role_number;
   $student_name = $student->first_name.' '.$student->last_name;
    $course_name= $student->course_name;
    $total_amount= $student->total_amount;
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetX(40);
    $pdf->SetY(43);
    $pdf->Cell(0, 0, 'Student Id: '.$role_number, 0, 0); 
    $pdf->SetY(48);
    $pdf->SetX(10);
    $pdf->Cell(0, 0,'Student Name: '. $student_name, 0, 0); 
    $pdf->SetY(53);
    $pdf->SetX(10);
    $pdf->Cell(0, 0,'Course: '. $course_name, 0, 0); 
    $pdf->SetY(47);
    $pdf->SetX(150);
    $pdf->SetFont('Times', 'B', 18);
    $TotalDue=$total_amount- $total_pay;
    $pdf->SetTextColor(255, 0, 0); 
    $pdf->Cell(0, 0,'Total Due: '. $TotalDue, 0, 0); 
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln();
}
$center_name= $student->center_name;
if($center_name=="Adhartal"){
    $center_add="Neta colony behind old milk scheme near shiv mandir Adhartal Jabalpur";
}
else if($center_name=="Rampur"){
    $center_add="In front of Coal mines Ground Shakti Nagar Rampur";
}
else if($center_name=="Belkhadu"){
    $center_add="Near TVS showroom Main Road Belkhadu";
}

$pdf->SetY(33);
$pdf->SetX(135);
$pdf->SetFont('Arial', 'i', 11);
$pdf->MultiCell(0, 5, $center_add, 0, 0); 

$pdf->SetY(60);
$pdf->SetX(10);
$pdf->SetFont('Arial', 'B', 9);
$srNoWidth = $pdf->GetStringWidth('Sr. No.');
$receiptIdWidth = $pdf->GetStringWidth('Receipt Id');
$amountWidth = $pdf->GetStringWidth('Amount');
$Instalment = $pdf->GetStringWidth('Instalment');
$modeWidth = $pdf->GetStringWidth('Mode');
$Date = $pdf->GetStringWidth('Date');

// Calculate maximum width considering some padding
$maxTextWidth = max($srNoWidth, $receiptIdWidth, $amountWidth, $Instalment,$modeWidth, $Date) + 16; // Add 5 for padding

//Set cell widths based on maximum width
$pdf->SetDrawColor(169, 169, 169);
$pdf->Cell($maxTextWidth, 8, 'Sr. No.', 1, 0, 'C'); 
$pdf->Cell($maxTextWidth, 8, 'Receipt Id', 1, 0, 'C'); 
$pdf->Cell($maxTextWidth, 8, 'Instalment', 1, 0, 'C'); 
$pdf->Cell($maxTextWidth, 8, 'Date', 1, 0, 'C'); 
$pdf->Cell($maxTextWidth, 8, 'Payment Mode', 1, 0, 'C'); 
$pdf->Cell($maxTextWidth, 8, 'Amount', 1, 0, 'C'); 
$pdf->Ln();
$srno=1;

  foreach ($ReceiptData['Data'] as $invoice) {
    
    $pdf->SetFont('Arial', '', 10);
    $receipt_Id = $invoice->receipt_id;
    $amount = $invoice->amount;
    $comment = $invoice->comment;
    $payment_mode = $invoice->payment_mode;
    $pay_date = $invoice->pay_date;
    $createOn = $invoice->createOn;
    $dateFormat =  date('d-m-Y',strtotime($createOn));
    $role_number = $invoice->role_number;
    $pdf->Cell($maxTextWidth, 8, $srno, 1, 0, 'C'); 
    $pdf->Cell($maxTextWidth, 8, $receipt_Id, 1, 0, 'C'); 
    $pdf->Cell($maxTextWidth, 8,  ordinalSuffix($srno), 1, 0, 'C'); 
    $pdf->Cell($maxTextWidth, 8, $dateFormat, 1, 0, 'C'); 
    $pdf->Cell($maxTextWidth, 8, $payment_mode, 1, 0, 'C'); 
    $pdf->Cell($maxTextWidth, 8, $amount, 1, 0, 'C'); 
    $pdf->Ln();
    $srno++;
  }


  function ordinalSuffix($number) {
    if ($number % 100 >= 11 && $number % 100 <= 13) {
        return $number . 'th';
    } else {
        switch ($number % 10) {
            case 1:
                return $number . 'st';
            case 2:
                return $number . 'nd';
            case 3:
                return $number . 'rd';
            default:
                return $number . 'th';
        }
    }
}

//=====================================================================


// =========================Total Section ===================


$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$html = '
<table>
   <tr>
       <td width="25">Total Due:</td>
      <td width="25" > '.$total_amount-$total_pay.'</td>
   </tr>

   <tr>
       <td width="25">Paid Amount: </td>
       <td width="25" > '.$total_amount.'</td>
       
   </tr>
</table>';

// Convert HTML table to PDF table
$dompdf = new DOMDocument();
@$dompdf->loadHTML($html);

$rows = $dompdf->getElementsByTagName('tr');

foreach ($rows as $row) {
 $pdf->SetX(151);
 $cols = $row->getElementsByTagName('td');

 foreach ($cols as $col) {
     $width = $col->hasAttribute('width') ? $col->getAttribute('width') : 0;
     $pdf->Cell($width, 8, $col->nodeValue, 1);
 }
 $pdf->Ln(); 
}


// // =========================Total Section End===================
// //top Corner Receipt Id
$pdf->SetY(7);
$pdf->SetX(170);
$pdf->SetFont('Arial', 'B', 14);
  $pdf->Cell(41, 14,$receipt_Id, 0, 0); 




 $pdf->Output();

?>