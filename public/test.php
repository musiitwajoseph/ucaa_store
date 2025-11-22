<?php


define('AD_DOMAIN', '@uetcl.com');
define('AD_DNS_NAME', 'CID');
define('AD_DN', 'DC=UETCL,DC=COM');

$username = 'musijo';
$password = '2025MM????';


 $cnx = ldap_connect(AD_DNS_NAME) or die("Could not connect to LDAP");
            ldap_set_option($cnx, LDAP_OPT_PROTOCOL_VERSION, 3);    //Set the LDAP Protocol used by your AD service
            ldap_set_option($cnx, LDAP_OPT_REFERRALS, 0);       //This was necessary for my AD to do anything
            if(!ldap_bind($cnx,$username.AD_DOMAIN,$password)){ 
                $errors["message"] = "Could not Login, Contact Admin";
                $errors["status"] = False;
            }else{
                $errors["status"] = True;
                $errors["message"] = 'Logged';
            }


            echo $errors["message"];