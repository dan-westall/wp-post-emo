var wpPostEmo = {

    config: {
        wrapper: '.analyze-post-container',
        testNotifySpinner: null,
        testNotifyResponse: null
    },

    init : function () {
        self.testNotifySpinner  = jQuery( wpPostEmo.config.wrapper + ' button .spinner' );
        self.testNotifyResponse = jQuery( '#generate-analyze-response' );
        this._bindEvents();

    },

    _bindEvents : function () {
        console.log(jQuery(wpPostEmo.config.wrapper).find('button'));
        jQuery( wpPostEmo.config.wrapper ).find('button').on('click', wpPostEmo.ajaxGenerateMatches);
    },

    ajaxGenerateMatches : function (e) {

        e.preventDefault();

        self.testNotifyResponse.html('');
        self.testNotifySpinner.show();

        var xhr = jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            cache: false,
            data: {
                action: 'process_text',
                security: jQuery( wpPostEmo.config.wrapper ).find('[type="hidden"]').val(),
                post_id: jQuery( '#post_ID' ).val()
            },
            dataType: 'JSON',
            async: true
        });

        xhr.done( function( r ) {
            self.testNotifyResponse.html( '<span style="color: green">' + r.data.message + '</span>' );
            self.testNotifySpinner.hide();
        } );

        xhr.fail( function( xhr, textStatus ) {
            var message = textStatus;
            if ( typeof xhr.responseJSON === 'object' ) {
                if ( 'data' in xhr.responseJSON && typeof xhr.responseJSON.data === 'string' ) {
                    message = xhr.responseJSON.data;
                }
            } else if ( typeof xhr.statusText === 'string' ) {
                message = xhr.statusText;
            }
            self.testNotifyResponse.html( '<span style="color: red">' + message + '</span>' );
            self.testNotifySpinner.hide();
        } );

    }


};


(function ( $ ) {
    "use strict";

    $(function () {

        wpPostEmo.init();

    });

}(jQuery));