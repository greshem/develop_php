

<?php 
/* These salts are examples only, and should not be used verbatim in your code.
   You should generate a distinct, correctly-formatted salt for each password.
*/
if (CRYPT_STD_DES == 1) {
    echo 'Standard DES: ' . crypt('password', 'rl') . "\n";
}

if (CRYPT_EXT_DES == 1) {
    echo 'Extended DES: ' . crypt('password', '_J9..rasm') . "\n";
}

if (CRYPT_MD5 == 1) {
    echo 'MD5:          ' . crypt('password', '$1$rasmusle$') . "\n";
    echo 'MD5:          ' . crypt('password', '$1$12345678$') . "\n";
}

if (CRYPT_BLOWFISH == 1) {
    echo 'Blowfish:     ' . crypt('password', '$2a$07$usesomesillystringforsalt$') . "\n";
}

if (CRYPT_SHA256 == 1) {
    echo 'SHA-256:      ' . crypt('password', '$5$rounds=5000$usesomesillystringforsalt$') . "\n";
    echo 'SHA-256:      ' . crypt('password', '$5$rounds=6000$usesomesillystringforsalt$') . "\n";
}

if (CRYPT_SHA512 == 1) {
    echo 'SHA-512:      ' . crypt('password', '$6$rounds=5000$usesomesillystringforsalt$') . "\n";
    echo 'SHA-512:      ' . crypt('password081943', '$6$0123456789012345678901234567890123456789$') . "\n";

	echo 'SHA-512:      '. crypt('password',        '$6$tZJD.K5r$')."\n";
	echo 'SHA-512:      '. crypt('password',  	  '$6$eg8B7v//$')."\n";
	//$6$tZJD.K5r$aPDfca8ybHmLzuiII4IMnTRNWfc68J19oJrd/XSqDWG.GjnY4dNI9CNBiQh4oHNTMr7ARmsIazETMcXXGxnGZ0
	//$6$eg8B7v//$qZr67pTPkqIj3uAtzJgrYp8OLsyeKahkxX/ufZsas1MAOSUrjZs3/SW8UqHP.zTUY/cG.R9Web3R7B0BepftM0

}



?>
