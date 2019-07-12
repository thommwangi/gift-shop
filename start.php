<?php 

require 'vendor/autoload.php';
define('SITE_URL','http://localhost/GIFT-SHOP/cart.php');
$paypal= SDK\lib\PayPal\Rest\ApiContext(SDK\lib\PayPal\Auth\OAuthTokenCredential('AX1jnTwoCAePZX5hu1WrEW702r_ZIBLw5y5tbZz5BcmRgx84VWoP5sDhWXVy4rMawzK0UeDAsBl4lCRm','EBS43XNr1Q2zFmgqIEheGv9GRXzjA7hg-2CUFhwLDrA-scKCsuPtz479qvptl23-yvpRP5XBBFuJNe7x'));


 ?>