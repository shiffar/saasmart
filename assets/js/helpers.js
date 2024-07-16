function send_ajax_request(request_type,request_data,url,before_send,success_response,errors){
    $.ajax({
        url: url,
        type: request_type,
        headers: {
            'X-CSRF-TOKEN': "4Gq0plxXAnBxCa2N0SZCEux0cREU7h4NHObiPH10",
        },
        beforeSend: (typeof before_send !== "undefined" && typeof before_send === "function") ? before_send : () => { return ""; } ,
        processData: false,
        contentType: false,
        data: request_data,
        success:  (typeof success_response !== "undefined" && typeof success_response === "function") ? success_response : () => { return ""; },
        error:  (typeof errors !== "undefined" && typeof errors === "function") ? errors : () => { return ""; }
    });
}

function prepare_errors(data,form,msgContainer,btn){
    let errors = data.responseJSON;

    if(errors.success !== undefined){
        toastr.error(errors.msg.errorInfo[2]);
        toastr.error(errors.custom_msg);
    }

    $.each(errors.errors,function (index,value){
        console.log(value)
        toastr.error(value[0]);
    })
}