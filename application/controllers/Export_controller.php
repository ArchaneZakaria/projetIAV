<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Export_controller extends CI_Controller {
public function __construct()
{
parent::__construct();
$this->load->helper(array('url'));
}

public function index()
{
$this->load->model('Export_model'); // Load Model
$data['export_data'] = $this->Export_model->fetchData();
$this->load->view('export',$data);
}
public function phpexcel_export()
{
if(isset($_POST['export']))
{
$this->load->model('Export_model'); // Load Model
$export_data = $this->Export_model->fetchData();
$this->load->library('excel'); // load Excel Library
$object_excel = new PHPExcel(); // new object for PHPExcel
$object_excel->setActiveSheetIndex(0); // Create new worksheet
$table_head = array('Staff Code', 'Staff Name','Staff Email'); //Set the names of header cells
$head = 0;
foreach($table_head as $value)
{
$object_excel->getActiveSheet()->setCellValueByColumnAndRow($head, 1, $value);
$head++;
}
$body = 2;//Add some data
foreach($export_data as $row)
{
$object_excel->getActiveSheet()->setCellValueByColumnAndRow(0,$body,$row->staff_code);
$object_excel->getActiveSheet()->setCellValueByColumnAndRow(1,$body,$row->staff_name);
$object_excel->getActiveSheet()->setCellValueByColumnAndRow(2,$body,$row->staff_email);
$body++;
}
$object_excel_writer = PHPExcel_IOFactory::createWriter($object_excel, ‘Excel5’);// Explain format of Excel data
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=”statffdetails.xls');
$object_excel_writer->save('php://output'); // For automatic download to local computer
echo "EXPORTED";
}
}
}
?>
