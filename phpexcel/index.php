<?php

//PhpSpreadsheetを使うための事前定義
require "vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls as XlsReader;  //xls形式用
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;    //xlsx形式用
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

//getパラメータで処理振り分け
$mode = null;
if(isset($_GET["mode"])) {
    $mode = $_GET["mode"];
} else {
    $mode = "create";
}
switch($mode) {
    case "create":
        create_xlsx();
        break;
    case "read":
        read_xlsx();
        break;
}

//Excelファイルを出力する
function create_xlsx() {
    //Spreadsheetを作成
    $spreadsheet = new Spreadsheet();
    $spreadsheet->getProperties()->setTitle("タイトル");
    //シートを作成
    $spreadsheet->getActiveSheet('sheet1')->UnFreezePane();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle("シートタイトル");
    //値を設定
    $sheet->setCellValue("A1", "Hello");
    $sheet->setCellValue("B1", "PhpSpreadsheet");
    $sheet->setCellValue("C1", "World");
    //セルの中央揃え
    $sheet->getStyle("A1:B1")->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER
        ]
    ]);
    //ボーダーを指定
    $sheet->getStyle("B1")->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
    //列幅を指定
    $sheet->getColumnDimension("B")->setWidth(8);
    //セル結合
    $sheet->mergeCells("C1:D1");
    //セル縦揃え
    $sheet->getStyle("C1:D1")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
    //テキストの折り返し
    $sheet->getStyle("C1")->getAlignment()->setWrapText(true);
    //配列の形で値をセット
    $dataList = [
        ["Happy Bingo!"],
        ['B', 'I', 'N', 'G', 'O'],
        [26, 15, 18, 17, 13],
        ['6', '11', 2, 5, '14'],
        [1, 8, NULL, 4, 19],
        [21, 27, 3, 20, 24],
        [16, 22, 23, 25, 12],
    ];
    $sheet->fromArray($dataList, NULL, "C6", true);

    // セルを縦横の数値で指定する(列番号, 行番号, 値)
    // 注）列・行は1から開始
    //$sheet->setCellValueByColumnAndRow(5, 3, '数値でセルを指定');
    // セルのスタイルを縦横の数値で指定する
    //$sheet->getStyleByColumnAndRow(5, 3)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
 
    //バッファのクリア
    ob_end_clean();
    
    $filename = "create.xlsx";
    
    // ダウンロード出力
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}


//Excelファイルを読み込む
function read_xlsx() {
    $filepath = "reader.xlsx";
    //readerを作成
    $reader = new Reader();
    //Excelファイルを読み込む
    $spreadsheet = $reader->load($filepath);
    //シートを取得
    $sheet = $spreadsheet->getActiveSheet();
    //値を取得
    $cellValue = $sheet->getCell("A1")->getValue();
    //$cellValue = $sheet->getCell("A1")->getCalculatedValue();
    //$cellValue = $sheet->getCell("A1")->getOldCalculatedValue();

    //取得した値を表示
    echo $cellValue;
    exit();
}
