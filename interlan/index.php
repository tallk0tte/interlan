<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>


<?php require 'metoder.php';?>

<div id="subContainer1">
<div align="center">
<h2>Myndigheter med DNSSEC</h2>
			<div>
				<table cellspacing="3" cellpadding="2" style="margin-bottom:7px;border:1px solid black;font: 11px verdana: margin-left: auto;">
					<tr><td style="background-color:#A0FFA0;width:145px;height:20px">&nbsp;domain</td><td>Signed with DNSSEC and without remarks</td></tr>
					<tr><td style="background-color:#FFFFFF;height:20px">domain</td><td>Without remarks in DNSCheck but not signed</td></tr>
					<tr><td style="background-color:#FFA500;height:20px">&nbsp;domain</td><td>Signed with DNSSEC but with warnings(not available)</td></tr>
					<tr><td style="background-color:#FFA500;height:20px">domain</td><td>Warnings in DNSCheck</td></tr>
					<tr><td style="background-color:#FF0000;height:20px">domain</td><td>Error in DNSCheck</td></tr>
				</table>
			</div>
			<br>
				</div> <!-- end align center -->
			</div> <!-- end subContainer1 -->
			<br>
			
<div id="subContainer">
	<br>
		<script type="text/javascript">

<?php 
		#Hämtar php arrayen och lägger in det i ett javascript objekt.
		#Forloopen tittar genom objektets längd och skapar så många rutor som finns i objektet. 
		#Den hämtar även css mallen med de rätta färgkoderna.
		#Tar även bort citat-tecken med .replace() och sedan lägger till det i subContainer.
?>
			var obj = <?php echo json_encode($noErrorsDNSArray)?>;
			var temp;
				for(var i = 0; i < obj.length; i++){
					temp = document.createElement("div");
					temp.className ='okDom'; 
					temp.innerHTML = JSON.stringify(obj[i].DomainName).replace(/\"/g, "");
					document.getElementById('subContainer').appendChild(temp);
					
				}
			</script>
	<br>
	<br>
		<script type="text/javascript">
			var warnObj = <?php echo json_encode($someErrorsDNSArray)?>;
			var warnTemp;
				for(var i = 0; i < warnObj.length; i++){
					warnTemp = document.createElement('div');
					warnTemp.className = 'warningDom';
					warnTemp.innerHTML = JSON.stringify(warnObj[i].DomainName).replace(/\"/g, "");;
					document.getElementById('subContainer').appendChild(warnTemp);
				}
			</script>
	<br>
	<br>	
		<script type="text/javascript">
			var errorObj = <?php echo json_encode($allErrorsDNSArray) ?>;
			var errorTemp;
				for(var i = 0; i < errorObj.length; i++){
					errorTemp = document.createElement('div');
					errorTemp.className = 'errorDom';
					errorTemp.innerHTML = JSON.stringify(errorObj[i].DomainName).replace(/\"/g, "");;
					document.getElementById('subContainer').appendChild(errorTemp);
				}
			</script>
	</div><!-- End subContainer1 -->
	
		
</body>
</html>