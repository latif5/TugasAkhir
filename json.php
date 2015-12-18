<?php

require ('config.php');

$sql = "SELECT * from `info_penduduk_propinsi`";
			
$data = mysql_query($sql);
$json = '{"penduduk": {';
$json .= '"lokasi":[ ';
while($x = mysql_fetch_array($data)){
	$json .= '{';
	$json .= '"id_prop":"'.$x['prop_id'].'",
		"prop_nama":"'.htmlspecialchars($x['prop_nama']).'",
		"ibukota":"'.$x['prop_ibukota'].'",
		"pria":"'.$x['prop_jml_penduduk_pria'].'",
		"wanita":"'.$x['prop_jml_penduduk_wanita'].'",
		"website":"'.$x['prop_website'].'",
		"x":"'.$x['prop_map_latitude'].'",
		"y":"'.$x['prop_map_longitude'].'"
	},';
}
$json = substr($json,0,strlen($json)-1);
$json .= ']';
$json .= '}}';

echo $json;

?>
