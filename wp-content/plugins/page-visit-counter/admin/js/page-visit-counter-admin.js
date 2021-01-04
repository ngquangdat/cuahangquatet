/* eslint-disable */
(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 */

	$(window).load(function() {

        //$('table#wizard-listing tbody').sortable();
        $(".multiselect2").chosen();
        $(".tablesorter").tablesorter({
            headers: {
                0: {
                    sorter: false
                },
                4: {
                    sorter: false
                }
            }
        });
        $('.jscolor').wpColorPicker();
		/*Check all checkbox wizard*/
        $('body').on('click', '#chk_all_wizard', function(e) {

            $('input.chk_single_wizard:checkbox').not(this).prop('checked', this.checked);

            var numberOfChecked = $("input[name='chk_single_wizard_chk']:checked").length;

            if (numberOfChecked >= 1) {
                $('#detete_all_selected_wizard').removeAttr("disabled");
            } else {
                $('#detete_all_selected_wizard').attr("disabled", "disabled");
            }
        });

        /*Check single checkbox wizard*/
        $('body').on('click', '.chk_single_wizard', function(e) {

			var numberOfChecked = $("input[name='chk_single_wizard_chk']:checked").length;
			
            if (numberOfChecked >= 1) {
                $('#detete_all_selected_wizard').removeAttr("disabled");
            } else {
                $('#detete_all_selected_wizard').attr("disabled", "disabled");
            }
		});
		
		/*Get all checkbox checked value*/
        $('body').on('click', '#detete_all_selected_wizard', function(e) {

            var numberOfChecked = $("input[name='chk_single_wizard_chk']:checked").length;
            var confrim = confirm("Are you sure want to delete selected wizard?");
			
            if (numberOfChecked >= 1) {
                if (confrim == true) {

                    var selectedWizardArr = [];
                    $.each($("input[name='chk_single_wizard_chk']:checked"), function() {
                        selectedWizardArr.push($(this).val());
					});
					
					var selectedWizard = selectedWizardArr;

                    $.ajax({
                        type: 'GET',
                        url: ajaxurl,
                        data: {
                            action: "pvcp_delete_selected_wizard_using_checkbox__premium_only",
                            selected_wizard_id: selectedWizard
                        },
                        success: function(response) {
                            if (response == 'true') {
                                $.each(selectedWizard, function(index, value) {
                                    $('#wizard_row_' + value).remove();
                                });
                                $('#chk_all_wizard').prop('checked', false);
                                $('#detete_all_selected_wizard').attr("disabled", "disabled");
                            } else {
                                return false;
                            }
                        }
                    });
                } else {
                    return false;
                }
            }
        });
        /*Pro Version alert message*/
        $('body').on('click', '.pvcp-pro-ver', function(e) {
            var ans = confirm ("This feature is available in pro version.")
            if (ans){
                window.open('https://www.thedotstore.com/page-visit-counter/','_blank');
            }
        });
        /*Delete single wizard using delete button*/
        $('body').on('click', '.delete_single_selected_wizard', function(e) {

            var singleSelectedWizard = $(this).attr('id');
            var singleSelectedWizardIntId = singleSelectedWizard.substr(singleSelectedWizard.lastIndexOf("_") + 1);
            var wizardName = $(this).data('attr_name');
			var confrim = confirm("Are you sure want to delete this wizard?");
			
            if (confrim == true) {
                $.ajax({
                    type: 'GET',
                    url: ajaxurl,
                    data: {
                        action: "pvcp_delete_single_wizard_using_button__premium_only",
                        single_selected_wizard_id: singleSelectedWizardIntId
                    },
                    success: function(response) {
                        if (response == 'true') {
                            $('#wizard_row_' + singleSelectedWizardIntId).remove();
                        } else {
                            return false;
                        }
                    }
                });
            } else {
                return false;
            }
        });

        /*Reset all page report and count using reset button in master page */
        $('body').on('click', '#reset_all_page_report_count', function(e) {

            var confrim = confirm("Are you sure want to delete this wizard?");

            if (confrim == true) {
                $.ajax({
                    type: 'GET',
                    url: ajaxurl,
                    data: {
                        action: "pvcp_reset_all",
                    },
                    success: function(response) {
                        $( ".pvcp-default-table .pvcp_general_wizardsettingfrm" ).after( "<div class='pvcp-alert-success'><strong>Successfully reset all page counts & report..! </strong> </div>" );
                    }
                });
            } else {
                return false;
            }
        });
  
        //Check that entered only number allow in IP address.
        var arr_ip_list = [];
        $( '#ip_address_chosen ul.chosen-choices li.search-field input' ).keypress( function( event ) {

            if ( event.which != 8 && isNaN( String.fromCharCode( event.which ) ) && event.which != 46 && event.which != 45 ) {
                event.preventDefault(); //stop character from entering input
            }
            return;
        } );

        $( 'body' ).on( 'keyup', '#ip_address_chosen ul.chosen-choices li.search-field input', function( evt ) {
            var c = evt.keyCode;

            if ( c == 188 || c == 13 || c == 59 || c == 186 ) {
                if ( c == 13 ) {
                    var ip = $( this ).val();
                }
                if ( c == 186 ) {
                    var ip = $( this ).val().replace( ';', '' );
                }
                if ( c == 59 ) {
                    var ip = $( this ).val().replace( ';', '' );
                }
                if ( c == 188 ) {
                    var ip = $( this ).val().replace( ',', '' );
                }
                var valid = ValidateIPaddress( ip );
                if ( '' != ip && valid == 'yes' && - 1 == $.inArray( ip, arr_ip_list ) ) {
                    //add new first name in array
                    arr_ip_list.push( ip );
                    $( '#ip_address' ).append( '<option value="' + ip + '">' + ip + '</option>' );
                    $( '#ip_address option[value=\'' + ip + '\']' ).prop( 'selected', true );
                    $( '#ip_address' ).trigger( 'chosen:updated' );
                } else {
                    $( '#ip_address' ).trigger( 'chosen:updated' );
                }
            }
        } );
        // For color picker


        $( 'body' ).on( 'blur', '#ip_address_chosen ul.chosen-choices li.search-field input', function( evt ) {
            var ip = $( this ).val().replace( ',', '' );
            var valid = ValidateIPaddress( ip );
            if ( '' != ip && valid == 'yes' && - 1 == $.inArray( ip, arr_ip_list ) ) {
                //add new first name in array
                arr_ip_list.push( ip );
                $( '#ip_address' ).append( '<option value="' + ip + '">' + ip + '</option>' );
                $( '#ip_address option[value=\'' + ip + '\']' ).prop( 'selected', true );
                $( '#ip_address' ).trigger( 'chosen:updated' );
            } else {
                $( '#ip_address' ).trigger( 'chosen:updated' );
            }
        } );

        var ipaddress = [];

        function ValidateIPaddress( ipaddress ) {

            var ipFormat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;

            //check that all the ip in range or without is match or not
            $.each( ipaddress.split( '-' ), function( i, e ) {
                if ( ! ipaddress.match( ipFormat ) ) {
                    return 'no';
                }
            } );
            //If no any un matched IP found the return yes for IP address is valid
            return 'yes';
        }
        // Chosen IP Address End

        //Reset file data
        $('body').on('click', '.reset_file', function() {

            $('.pvcp-main-table .general-setting .counter_icon img').remove();
            $('.pvcp-main-table .general-setting .pvcp_general_counter_icon').val('');
            $('.pvcp-main-table .general-setting #pvcp_general_counter_icon_temp').attr('value', '');

        });

        // description toggle
        $   ('span.pvcp_tooltip_icon').click(function (event) {
            event.preventDefault();
            $(this).next('p.description').toggle();
        });

         $('.pvcp-form-data-table').DataTable();
	});

})( jQuery );
