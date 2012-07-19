<?php
require_once 'libs/php_excel/PHPExcel.php';
// $inputFileType = 'Excel5';
   // $inputFileType = 'Excel2007';
   // $inputFileType = 'Excel2003XML';
   // $inputFileType = 'OOCalc';
   // $inputFileType = 'SYLK';
   // $inputFileType = 'Gnumeric';
   // $inputFileType = 'CSV';
// $inputFileName = 'demo.xls';

// /**  Create a new Reader of the type defined in $inputFileType  **/
// $objReader = PHPExcel_IOFactory::createReader($inputFileType);
// /**  Load $inputFileName to a PHPExcel Object  **/
// $objPHPExcel = $objReader->load($inputFileName);

// $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
// $sheet = $objPHPExcel->getActiveSheet();
// $array_data = array();

$objPHPExcel = PHPExcel_IOFactory::load("demo.xls");

	foreach ($objPHPExcel->getActiveSheet()->getDrawingCollection() as $drawing) {
	//echo $drawing;
    if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {
	echo '1';
        ob_start();
        call_user_func(
            $drawing->getRenderingFunction(),
            $drawing->getImageResource()
       //     $drawing->getName()
        );
        $imageContents = ob_get_contents();
		var_dump($imageContents);
        ob_end_clean();
    }
}

 foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 64;
    // echo "<br>The worksheet ".$worksheetTitle." has ";
    // echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
    // echo ' and ' . $highestRow . ' row.';
    echo '<br>Data: <table border="1"><tr>';
    for ($row = 1; $row <= $highestRow; ++ $row) {
        echo '<tr>';
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = $cell->getValue();
        //    $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
            echo '<td>' . $val . /*'<br>(Typ ' . $dataType . ')*/'</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
} 





?>