<?php //add2basketPage.php
	// ����������� ���������
	require "inc/lib.inc.php";// ����������� ���������� �������
	require "inc/config.inc.php";//����������� ����������������� �����
	
  $id = clearUint($_GET["id"]);//��������� ������ ����� �������������� ������, ������������ � ������� 
  if($id){
    add2Basket($id);//������� ��������� ����� � ������� ������������ � ��������� � �������� ��������� ������������� ������ 
    header("Location: Page.php");//������������� ������������ �� �������� ������ 
    exit;
}	