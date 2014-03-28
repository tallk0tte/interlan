<?php 
#Author: Johan Fohlin
#Email: Mr.Fohlin@gmail.com
# 
?>


<?php

#Uppkopplingen mot databasen.
$conn = mysql_connect("localhost", "root", "") or die("Could not connect to Database");
if(mysqli_connect_errno()){
	echo "Failed to connect to database" . mysql_connect_error();
}
mysql_select_db("interlan") or die(mysql_error());	?>
<?php 

#Avgör vilken typ som ska hämtas. Vill man ha t.ex. kommuner med DNSSEC så byter man ut domainType till 'kommuner';
$domainType = 'myndigheter';


#Hämtar alla värden som stämmer överrens och är secured, recursive samt inte har några errors samt dagens datum
$noErrorsDNS = mysql_query("SELECT domains_name FROM dns INNER JOIN domains ON dns.domain_id=domains.domains_id WHERE domains.domain_type='$domainType' AND dnssec = 1 
AND dns_recursive = 1 AND dns_errors = 0 AND dns_warnings = 0 AND DATE(dns.dns_timestamp) = DATE(NOW())  ") or die(mysql_error());
#Kör en loop och hämtar domains_name och lägger in det i en array
	while ($rowsErrorsDNS = mysql_fetch_assoc($noErrorsDNS)){
		$noErrorsDNSArray[] = array(
				'DomainName' =>$rowsErrorsDNS['domains_name']	
		);
	}

	
# För att sortera på dag: AND DATE(dns.dns_timestamp) = DATE(NOW())	
# Hämtar de som har några fel och de som har någon varning men ändå mindre än tre errors
$someErrorsDNS = mysql_query("SELECT domains_name FROM dns INNER JOIN domains ON dns.domain_id=domains.domains_id WHERE domains.domain_type ='$domainType' AND dns_warnings != 0
		AND dns_errors <= 2 ") or die(mysql_error());
#Kör en loop och hämtar domains_name och lägger in det i en array
	while($rowSomeErrorsDNS = mysql_fetch_array($someErrorsDNS)){
		$someErrorsDNSArray[] = array(
				'DomainName' =>$rowSomeErrorsDNS['domains_name']
		);
	}

#Hämtar de domäner som har mer än 3 fel, alltså de som inte uppfyler de kraven
$allErrorsDNS = mysql_query("SELECT domains_name FROM dns INNER JOIN domains ON dns.domain_id=domains.domains_id WHERE domains.domain_type ='$domainType' 
		AND dns_errors >= 3 AND DATE(dns.dns_timestamp) = DATE(NOW())	") or die(mysql_error());
#Kör en loop och hämtar domains_name och lägger in det i en array
	while ($rowAllErrorsDNS = mysql_fetch_array($allErrorsDNS)){
		$allErrorsDNSArray[] = array(
				'DomainName' => $rowAllErrorsDNS['domains_name']
					
		);
	}

	
	?>