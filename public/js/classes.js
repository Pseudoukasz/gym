
/*$(document).on('click', '#add_new_classes', function (event) {
        event.stopImmediatePropagation();
        //console.log('hej');
        //$("#form1").load('@Url.Action("new", "Classes")')
    });*/
/*
$('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
})*/
/*$(document).ready(function (){
    $('#form_zapisz').click(function (){
        var data = $('#data').val();
        $.ajax({
            url: '/new',
            type: 'POST',
            data: {data: data},
            async: true,
        })
    })
})*/
/*
$.ajax({
    type: "POST",

})*/
/*$(document).ready(function () {
    $('#body').load("zajecia_new");
});*/

(function (window, $) {
    window.RepLogApp = function ($wrapper) {
        this.$wrapper = $wrapper;
        this.helper = new Helper(this.$wrapper);

        this.$wrapper.on('click',
            '.js-delete-rep-log',
            this.handleRepLogDelete.bind(this)
        );

        this.$wrapper.on(
            'click',
            'tbody tr',
            this.handleRowClicked.bind(this)
        );
        this.$wrapper.find('.new-form').on(
            'submit',
            this.handleNewFormSubmit.bind(this)
        );


    };
    $.extend(window.RepLogApp.prototype,{


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
                        self.updateTotalWeightLifted();
                    })
                }
            })
        },
        handleNewFormSubmit: function (e) {
            e.preventDefault();

            var $form = $(e.currentTarget);
           // var $tbody = this.$wrapper.find('tbody');
            var self = this;
            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                success: function (data){
                //    $tbody.append(data);

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
