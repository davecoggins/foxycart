<?php
class extension_foxycart extends Extension {
    
    public function getSubscribedDelegates(){
        return array(
            array(
            'page' => '/frontend/',
            'delegate' => 'FrontendOutputPreGenerate',
            'callback' => 'registerFunctions'
            )
        );
    }
    public function registerFunctions($context){
        $context['page']->registerPHPFunction('get_verification');
    }
}
// Functions to be called by XSL page templates:


function get_verification($var_name, $var_value, $var_code) {

	$api_key = Symphony::Configuration()->get('api_key', 'foxy_cart');
	
	$encodingval = htmlspecialchars($var_code) . htmlspecialchars($var_name) . htmlspecialchars($var_value);
	return '||'.hash_hmac('sha256', $encodingval, $api_key).($var_value == "--OPEN--" ? "||open" : "");
}
