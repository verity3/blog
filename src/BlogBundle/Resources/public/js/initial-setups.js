/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// require jQuery normally
const $ = require('jquery');
global.$ = global.jQuery = $;

$(document).ready(function () {
    $('.js-datepicker').datepicker({
        "format": "yyyy-mm-dd",
        'startView': 0
    });

});