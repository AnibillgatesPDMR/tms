$(document).ready(function() {
    // Start : Get journal name by client
    $("#client").change(function() {
        var id=$(this).val();
        var _token = $('input[name="_token"]').val();
        var dataString = {id: id, _token : _token};
        $.ajax ({
            type: "POST",
            url: "journal",
            data: dataString,
            cache: false,
            success: function(data) {
                if (data) {
                    $('#journal').children('option:not(:first)').remove();
                    $.each(data, function(key, value) { 
                        $('#journal').append($("<option></option>").attr("value",value.id).text(value.journal_name));
                    });
                }
            } 
        });
    });
    // End : Get journal name by client

    // Start : Get book name by client and journal
    $("#journal").change(function() {
        var journalid=$(this).val();
        var typeid = $("#type option:selected").val();
        var clientid = $("#client option:selected").val();
        var _token = $('input[name="_token"]').val();
        var dataString = {type_id: typeid, journal_id: journalid, client_id: clientid, _token : _token};
        $.ajax ({
            type: "POST",
            url: "book",
            data: dataString,
            cache: false,
            success: function(data) {
                if (data) {
                    $('#book').children('option:not(:first)').remove();
                    $.each(data, function(key, value) { 
                        $('#book').append($("<option></option>").attr("value",value.id).text(value.book_name));
                    });
                }
            } 
        });
    });
    // End : Get book name by client and journal

    // Start : Get chapter name by client, journal and type
    $("#book").change(function() {
        var bookid=$(this).val();
        var typeid = $("#type option:selected").val();
        var clientid = $("#client option:selected").val();
        var journalid = $("#journal option:selected").val();
        var _token = $('input[name="_token"]').val();
        var dataString = {type_id: typeid, book_id: bookid, journal_id: journalid, client_id: clientid, _token : _token};
        $.ajax ({
            type: "POST",
            url: "chapter",
            data: dataString,
            cache: false,
            success: function(data) {
                if (data) {
                    $('#chapter').children('option:not(:first)').remove();
                    $.each(data, function(key, value) { 
                        $('#chapter').append($("<option></option>").attr("value",value.id).text(value.chapter_name));
                    });
                }
            } 
        });
    });
    // End : Get chapter name by client, journal and type

    $(function () {
        $('#redatepicker').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd'
        });
        $('#accdatepicker').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd'
        });
        $('#duedate').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd'
        });
        $('#copyduedate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        $('#xmlduedate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        $('#preduedate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        $('#inddduedate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        $('#graphiceduedate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        $('#fileduedate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        $('#epubduedate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    });

    // Start : Get article sub stage
    $("#articlestage").change(function() {
        var stageid=$(this).val();
        var _token = $('input[name="_token"]').val();
        var dataString = {stage_id: stageid, _token : _token};
        $.ajax ({
            type: "POST",
            url: "stage",
            data: dataString,
            cache: false,
            success: function(data) {
                if (data) {
                    $('#articlesubstage').children('option:not(:first)').remove();
                    $.each(data, function(key, value) { 
                        $('#articlesubstage').append($("<option></option>").attr("value",value.id).text(value.sub_stage));
                    });
                }
            } 
        });
    });
    // End : Get article sub stage

    // Start : Get client type
    $("#type").change(function() {
        var typeid=$(this).val();
        var _token = $('input[name="_token"]').val();
        var dataString = {type_id: typeid, _token : _token};
        $.ajax ({
            type: "POST",
            url: "client-by-type",
            data: dataString,
            cache: false,
            success: function(data) {
                if (data) {
                    $('#client').children('option:not(:first)').remove();
                    $.each(data, function(key, value) { 
                        $('#client').append($("<option></option>").attr("value",value.id).text(value.client_name));
                    });
                }
            } 
        });
    });
    // End : Get client type

    $('#name').on('blur', function(){
        var name = $('#name').val();
        var type = $('#type').val();
        if (name == '') {
            name_state = false;
            return;
        }

        var _token = $('input[name="_token"]').val();
        var dataString = {name: name, type: type, _token : _token};
        $.ajax ({
            type: "POST",
            url: "check-client-name",
            data: dataString,
            cache: false,
            success: function(data) {
                if (data == 'exist') {
                    $("#error").css("display", "block");
                    $("input[type=submit]").attr("disabled", "disabled");
                } else {
                    $("#error").css("display", "none");
                    $("input[type=submit]").removeAttr("disabled");
                }
            } 
        });
    });

    $('#journalname').on('blur', function(){
        var name = $('#journalname').val();
        var type = $('#type').val();
        var client = $('#client').val();
        if (name == '' || type == '' || client == '') {
            name_state = false;
            return;
        }

        var _token = $('input[name="_token"]').val();
        var dataString = {name: name, type: type, client: client, _token : _token};
        $.ajax ({
            type: "POST",
            url: "check-journal-name",
            data: dataString,
            cache: false,
            success: function(data) {
                if (data == 'exist') {
                    $("#error").css("display", "block");
                    $("input[type=submit]").attr("disabled", "disabled");
                } else {
                    $("#error").css("display", "none");
                    $("input[type=submit]").removeAttr("disabled");
                }
            } 
        });
    });

    $('#bookname').on('blur', function(){
        var name = $('#bookname').val();
        var type = $('#type').val();
        var client = $('#client').val();
        var journal = $('#journal').val();
        if (name == '') {
            name_state = false;
            return;
        }

        var _token = $('input[name="_token"]').val();
        var dataString = {name: name, type: type, client: client, journal: journal, _token : _token};
        $.ajax ({
            type: "POST",
            url: "check-book-name",
            data: dataString,
            cache: false,
            success: function(data) {
                if (data == 'exist') {
                    $("#error").css("display", "block");
                    $("input[type=submit]").attr("disabled", "disabled");
                } else {
                    $("#error").css("display", "none");
                    $("input[type=submit]").removeAttr("disabled");
                }
            } 
        });
    });

    $('.userform').click(function(){
        validateForm();   
    });

    function validateForm(){
        if (!$("input[name='ot']:checked").val()) {
            $('.ot-error').after('<span class="ot-error-red" style="color:red;">Please enter your </span>');
            return;
        } else {
            $('.ot-error-red').remove();
        }
    }

    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    

    $(".file-upload").on('change', function(){
        readURL(this);
    });
    
    $(".upload-button").on('click', function() {
       $(".file-upload").click();
    });


});