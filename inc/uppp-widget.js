/* 
 * Custom JS code for our UPPP Widget
*/

jQuery(document).ready(function() {    

    /*
     * Submit form when number of results is changed
     */
    jQuery('#num_results').change(function () {
        jQuery('#uppp_form').submit();
    });
    
});

