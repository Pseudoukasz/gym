'use strict';
global.$ = global.jQuery = $;
(function (window, $) {
    window.RepLogApp = function ($wrapper) {
        this.$wrapper = $wrapper;
        this.helper = new Helper(this.$wrapper);

        this.$wrapper.on('click',
            '.js-delete-rep-log',
            this.handleRepLogDelete.bind(this)
        );
        this.$wrapper.on('click',
            '.js-edit-rep-log',
            this.handleRepLogEdit.bind(this)
        );
        this.$wrapper.on('click',
            '#membership_submit',
            this.handleRepLogUpdate.bind(this)
        );

    };
    $.extend(window.RepLogApp.prototype, {


        handleRepLogDelete: function (e) {
            e.preventDefault();
            var $link = $(e.currentTarget);
            $link.addClass('text-danger');
            $link.find('.fa')
                .removeClass('fa-trash')
                .addClass('fa-spinner')
                .addClass('fa-spin')
            var deleteUrl = $link.data('url');
            var $row = $link.closest('tr');
            var self = this;
            $.ajax({
                url: deleteUrl,
                method: 'DELETE',
                success: function () {
                    $row.fadeOut('normal', function () {
                        $row.remove();
                    })
                }
            })
        },

        handleRepLogEdit: function (e) {
            e.preventDefault();
            var $link = $(e.currentTarget);
            console.log('hallo');
            var $form = $(e.currentTarget);
            //$('.edit').load($link.id);
            $link.addClass('text-danger');
            $link.find('.fa')
                .removeClass('fa-pencil')
                .addClass('fa-spinner')
                .addClass('fa-spin')
            var editUrl = $link.data('url');
            var $row = $link.closest('tr');
            var self = this;
            var $data = $.ajax({
                url: editUrl,
                method: 'POST',
                //context: document.body,
                dataType: 'html',
                success: function (responseText) {
                   // $form.closest('.membership').html(responseText);
                    //$('.edit').html(responseText);
                    //var result = JSON.stringify(responseText);
                    $('.modal-body').html(responseText); //return correct data

                }
            })
            //$('.edit').load($data.getAllResponseHeaders());
            console.log($data);
            var self = this;


        },
        /*TODO poprawić żeby edytowało a nie dodawało nowy */
        handleRepLogUpdate: function (e) {
            console.log('ellll');
            e.preventDefault();
            var $link = $(e.currentTarget);
            console.log('hallo');
            var $form = $(e.currentTarget);
            //$('.edit').load($link.id);
            $link.addClass('text-danger');
            $link.find('.fa')
                .removeClass('fa-pencil')
                .addClass('fa-spinner')
                .addClass('fa-spin')
            var editUrl = $link.data('url');
            var $row = $link.closest('tr');
            var self = this;
            var $data = $.ajax({
                url: editUrl,
                method: 'UPDATE',
                data: $('#membership').serialize(),
                dataType: 'html',
                success: function (responseText) {
                    // $form.closest('.membership').html(responseText);
                    //$('.edit').html(responseText);
                    //var result = JSON.stringify(responseText);
                    console.log('hello');

                }
            })
            //$('.edit').load($data.getAllResponseHeaders());
            console.log($data);
            var self = this;


        },
        handleNewFormSubmit: function (e) {
            e.preventDefault();

            var $form = $(e.currentTarget);
            var $tbody = this.$wrapper.find('tbody');
            var self = this;
            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                success: function (data) {
                    $tbody.append(data);

                },
                error: function (jqXHR) {
                    $form.closest('.js-new-rep-log-form-wrapper')
                        .html(jqXHR.responseText);
                }
            })
        }
    });
    /**
     * A "private" object
     */
    var Helper = function ($wrapper) {
        this.$wrapper = $wrapper;
    };

})(window, jQuery);

