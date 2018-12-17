$(document).ready(function(){

	$('#selected_type li').click(function(e){
		var data_type = $(this).val();
		$('#input_type').val(data_type);
    });

    //validate phone input
	$("#order_phone").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $("#newsletter_form").on('submit', function(){
        var data = $('form#newsletter_form').serialize();
        $.ajax({
            type : 'GET', 
            url : 'https://script.google.com/macros/s/AKfycbx9bRd9D95XMCWVrCGwrz7_Ib7kQ3-0Bu5ynJD3ewPZ16PATZ8/exec',
            data : data,
            success : function(data){
                alert("Thành công");
            }
        });
    });

    $('#showresultmodal').click(function(){
        var email = $('#recipient-email').val();
        var phone = $('#phone_number').val();
        var token = $('#token').val();
        var success = 'Thành công, vui lòng kiểm tra email để lấy lại mật khẩu';
        var failed = 'Có lỗi xảy ra, vui lòng thử lại!';
        var empty = 'Địa chỉ email hoặc số điện thoại này không tồn tại';
        $.ajax({
            type : 'POST', 
            url : '/MobileStore/public/ajaxpostuserprofile',
            data :{
                email : email,
                phone : phone,
                _token : token
            },
            success : function(data){
                if(data == 1){
                    $("#notificationcontent").html(success);
                    $('#recipient-email').val('');
                    $("#notificationcontent").attr('style', 'color : green; text-align: center;');
                }
                else{
                    $("#notificationcontent").html(empty);
                    $("#notificationcontent").attr('style', 'color : red; text-align: center;');
                }
            },
            error : function() {
                $("#notificationcontent").attr('style', 'text-align: center;');
                $("#notificationcontent").html(failed);
            }
        });
        setTimeout(function(){
            $('#forgotModal').modal('hide');
            $('#resultModal').modal('show');
        }, 5000);
    });

});