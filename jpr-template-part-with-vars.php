<?php
/*
Plugin Name: JolekPress Get Template Part With Variables
Plugin URI: https://github.com/JolekPress/Get-Template-Part-With-Variables
Description: Adds a new function that works the same as get_template_part, but allows passing of variables using
and associative array.
Version: 0.1.0
Author: John Oleksowicz
Author URI: http://jolekpress.com
*/

require 'template-part-with-vars-classes/TemplateHelper.php';

function jpr_get_template_part_with_vars($slug, $name = null, $variablesArray = []) {
    JPR\TemplatePartWithVars\Helper::getTemplatePartWithNamedVariables($slug, $name, $variablesArray);
}