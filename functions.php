<?php
session_start();
include "../_conexao/connect.php";
include "../_conexao/config.php";

function TestantaVersao(){

    echo "Testei a versão";
}

function MsgReturn(String $msg, $type, $local)
{
$a = $type;
switch ($a) {
case 'success':
$color = "#4fbe87";
$message = "
<script>
Toastify({
text: '". $msg ."',
gravity:'top',
position: '". $local ."',
duration: 3000,
close: false,
backgroundColor: '". $color ."',
}).showToast();
</script>";
break;
case 'danger':
$color = "#BB2D3A";
$message = "
<script>
Toastify({
text: '". $msg ."',
gravity:'top',
position: '". $local ."',
duration: 3000,
close: false,
backgroundColor: '". $color ."',
}).showToast();
</script>";
break;
case 'warning':
$color = "#FFC007";
$message = "
<script>
Toastify({
text: '". $msg ."',
gravity:'top',
position: '". $local ."',
duration: 3000,
close: false,
backgroundColor: '". $color ."',
}).showToast();
</script>";
break;

}
return $message;
}
function ImgProd($id)
{
$prefix = "_tb_";
$table = $prefix."products_img";
$query = "SELECT * FROM {$table} WHERE fk_id_product = $id";
$data = BDExecuta($query);
$linha = mysqli_fetch_assoc($data);
$foto = $linha['name_img_prod'];
return $foto;
}
function ErrorPHP()
{
error_reporting(E_ALL);
ini_set('display_errors', 1);
}

function Teste($var) 
{
echo "Debug: "  . $var;
die;
}  

function Debug($var) 
{
echo "<pre>";
var_dump($var);
die;
}  
function Price($value) 
{
$price = "R$ " .  number_format($value, 2, ',', '.');
return $price;
}  
function PriMaiuscula($texto)
{
$texto1 = strtolower($texto);
$textoFormat = ucfirst($texto1); 
return $textoFormat;
}

function PhoneFormat($phone)
{
$ddd = "(" .  substr("$phone", -11, 2) . ")";
$priPhone = substr("$phone", -9, 5);
$secPhone = substr("$phone", -4, 4);
$phoneUser = $ddd . " " . $priPhone . "-" . $secPhone;
return $phoneUser;
}

function Delete($table, $verification, $condition, $search)
{
$prefix = "";
$table = $prefix.$table;
$query = "DELETE FROM {$table} WHERE {$verification}{$condition}{$search}";
$data = BDExecuta($query);
}

function SelectTypeGeral($date)
{
$prefix = "";
$query = "SELECT name_user, SUM(price_service) as valTot, date_register_launch FROM launch l
JOIN _tb_users u
ON l.fk_id_user = u.id_user
WHERE status_launch = 'FECHADO' AND DATE_FORMAT(date_register_launch,'%Y-%m-%d') = '{$date}' GROUP BY name_user";
$data = BDExecuta($query);
return $data;
}

function SelectTypeUser()
{
$prefix = "";
$query = "SELECT name_user, type_payment ,SUM(price_service) as valTot, date_register_launch FROM launch l
JOIN _tb_users u
ON l.fk_id_user = u.id_user
WHERE status_launch = 'FECHADO' GROUP BY type_payment";
$data = BDExecuta($query);
return $data;
}

function SelectTypePayment($table, $table2, $verification, $condition, $search)
{
$prefix = "";
$table = $prefix.$table;
$table2 = $prefix.$table2;
$query = "SELECT type_payment , SUM(price_service) as valTot FROM launch l
WHERE {$verification} {$condition} {$search} GROUP BY type_payment";
$data = BDExecuta($query);
return $data;
}

function DateFormat($date)
{
$formatDate = date("d/m/Y", strtotime($date));
return $formatDate;
}

function DateFormatHour($date)
{
$formatDate = date("d/m/Y H:i:s", strtotime($date));
return $formatDate;
}

function NumberFormat($number)
{
$format = "R$ " . number_format($number, "2", ",", ".");
return $format;
}

function FormatPrice($price)
{
$formatLimCard =  str_replace(".", "", $price);
$formatLimCard2 =  str_replace(",", ".", $formatLimCard);
return $formatLimCard2;
}

function SelectRand($table)
{
$prefix = "";
$table = $prefix.$table;
$query = "SELECT numero_gerado FROM {$table} WHERE status_numero = 'ABERTO' ORDER BY RAND( ) LIMIT 1";
return BDExecuta($query);
}

function Update($table, array $data, $verification, $condition, $search)
{
$prefix = "";
$table = $prefix.$table;
$fields = array_keys($data);
foreach ($fields as $value){
$valores =  $data[$value];
$query = "UPDATE {$table} SET `{$value}` = '{$valores}' WHERE {$verification}{$condition}{$search}";
//echo $query."<br>";
BDExecuta($query);
}
return;
}
function SelectInsert($table, $verification)
{
$prefix = "";
$table = $prefix.$table;
$query = "SELECT * FROM {$table} WHERE 1 ORDER BY {$verification} DESC LIMIT 1";
$data = BDExecuta($query);
return $data;
}
function SelectValid($table, $verification1, $verification2, $search1, $search2)
{
$prefix = "";
$table = $prefix.$table;
$query = "SELECT * FROM {$table} WHERE {$verification1}={$search1} && 
{$verification2}={$search2}";
$data = BDExecuta($query);
return $data;
}
function Insert($table, array $data, $insertId)
{
$prefix = "";
$table = $prefix.$table;
//Valida de SQL Injection
$data = DBEscape($data);
//Tras os indices do array
$fields = "`".implode("`, `", array_keys($data))."`";
$values = "'".implode("', '", $data)."'";
//Executa a Query
$query = "INSERT INTO {$table} ({$fields}) VALUES ({$values})";
return BDExecuta($query, $insertId);
}
function SelectSum($table, $tableSum, $verification, $condition, $search)
{
$prefix = "";
$table = $prefix.$table;
$query = "SELECT SUM({$tableSum}) as total FROM {$table} WHERE {$verification}{$condition}{$search}";
$data = BDExecuta($query);
return $data;
}

function SelectSumInvoice($table, $tableSum, $verification, $condition, $search)
{
$prefix = "";
$table = $prefix.$table;
$query = "SELECT mes_ref_fatura, SUM({$tableSum}) as total FROM {$table} WHERE {$verification}{$condition}{$search}";
$data = BDExecuta($query);
return $data;
}

function SelectCount($table, $tableCount, $verification, $condition, $search)
{
$prefix = "";
$table = $prefix.$table;
$query = "SELECT COUNT({$tableCount}) as qtd FROM {$table} WHERE {$verification}{$condition}{$search}";
$data = BDExecuta($query);
return $data;
}

function Select($table, $verification, $condition, $search)
{
$prefix = "";
$table = $prefix.$table;
$query = "SELECT * FROM {$table} WHERE {$verification}{$condition}{$search}";
$data = BDExecuta($query);
$linha = mysqli_fetch_assoc($data);
$total = mysqli_num_rows($data);

if($total > 0){
do{
$arr [] = $linha;
}while($linha = mysqli_fetch_assoc($data));

return $arr;
}


}
function SelectMist($table1, $table2, $columm1, $columm2, $verification, $condition, $search)
{
$prefix = "_tb_";
$table1 = $prefix.$table1;
$table2 = $prefix.$table2;
$query = "SELECT * FROM {$table1} as t1 
JOIN {$table2} as t2
ON t1.{$columm1} = t2.{$columm2}
WHERE {$verification}{$condition}{$search}";
$data = BDExecuta($query);

$linha = mysqli_fetch_assoc($data);
$total = mysqli_num_rows($data);

if($total > 0){
do{
$arr [] = $linha;
}while($linha = mysqli_fetch_assoc($data));

return $arr;

}
}
function SelectMist3($table1, $table2, $table3, $columm1, $columm2, $columm3, $columm4,$verification, $condition, $search)
{
$prefix = "";
$table1 = $prefix.$table1;
$table2 = $prefix.$table2;
$table3 = $prefix.$table3;
$query = "SELECT * FROM {$table1} as t1 
JOIN {$table2} as t2
ON t1.{$columm1} = t2.{$columm2}
JOIN {$table3} as t3
ON t1.{$columm3} = t3.{$columm4}
WHERE {$verification}{$condition}{$search}";
$data = BDExecuta($query);
return $data;
}
//Executa Querys
function BDExecuta($query, $insertId = false)
{
$link = DBConnect();
$result = @mysqli_query($link, $query) or die (mysqli_error($link));
if($insertId)
$result = mysqli_insert_id($link);
DBClose($link);
return $result;
}

function gravaTxt($texto, $idUser)
{

//Variável arquivo armazena o nome e extensão do arquivo.
$arquivo = "_" . $idUser .  "-pedido_comanda.txt";

unlink ($arquivo);

$arquivo = "_" . $idUser .  "-pedido_comanda.txt";

//Variável $fp armazena a conexão com o arquivo e o tipo de ação.
$fp = fopen($arquivo, "a+");

//Escreve no arquivo aberto.
fwrite($fp, $texto);

//Fecha o arquivo.
fclose($fp);
}

function deletaTxt()
{

$idUser = $_SESSION["id"];
$arquivo = "_" . $idUser .  "-pedido_comanda.txt";
unlink ($arquivo);


}

$comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú');

$semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0', 'U', 'U', 'U');