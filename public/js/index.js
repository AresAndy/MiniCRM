var bl;

$(function(){
    bl = function(b){
        if(b){
            $("#bl").addClass("bl");
        } else {
            $("#bl").removeClass("bl");
        }
    }

    $("#add").click(() => {
        $(".modal").load("/modal_insert_company", () => {
            $(".modal").modal();

            $("#insert_company").click(function(e) {
                e.preventDefault();

                //do some checks before post for some xtra UX
                let
                    name = $("#name").val(),
                    address = $("#address").val(),
                    type = $("#type").val();

                if(!name){
                    $("#name").focus();
                    alert("Please fill the name field.");
                    return;
                }

                if(!address){
                    $("#address").focus();
                    alert("Please fill the address field.");
                    return;
                }

                if(type == "-1"){
                    $("#type").focus();
                    alert("Please select a field.");
                    return;
                }

                bl(true);
                $.post("/insert_company", {
                    name: name,
                    address: address,
                    type: type
                })
                .fail(() => {
                    alert("Something went wrong...");
                })
                .done((json) => {
                    try{
                        if(json.result >= 0){
                            alert("company inserted");
                            location.reload();
                        } else {
                            alert("Something went wrong...");
                        }
                    } catch(e) {
                        alert("Something went wrong...");
                    }
                })
                .always(bl.bind(null, false));
            });
        });
    });

    $(".delete").click(function ()  {
        let id = $(this).data("id");

        if(confirm("Are you sure you want to remove this company?")){
            bl(true);
                $.post("/delete_company/" + id)
                .fail(() => {
                    alert("Something went wrong...");
                })
                .done((json) => {
                    try{
                        if(json.result >= 0){
                            alert("Company deleted");
                            location.reload();
                        } else {
                            alert("Something went wrong...");
                        }
                    } catch(e) {
                        alert("Something went wrong...");
                    }
                })
                .always(bl.bind(null, false));
        }
    });

    $(".modify").click(function ()  {
        let id = $(this).data("id");

        bl(true);
        $(".companydetails").load("/company_details/" + id, function(){
            let validate_contactdata = function(name, phone){
                let regx = /^(\+[0-9]{2})?[0-9]{3,4}-?[0-9]{5,7}$/;

                if(!name){
                    $("#name").focus();
                    alert("Please fill the name field.");
                    return false;
                }

                if(!phone || !phone.match(regx)){
                    $("#phone").focus();
                    alert("Please fill the phone field.");
                    return false;
                }

                return true;
            };

            $(".companydetails").show();

            $("#details_save").focus().click(() => {
                bl(true);

                let
                    name = $("#details_name").val(),
                    address = $("#details_address").val(),
                    type = $("#details_type").val();

                if(!name){
                    $("#details_name").focus();
                    alert("Please fill the name field.");
                    return;
                }

                if(!address){
                    $("#details_address").focus();
                    alert("Please fill the address field.");
                    return;
                }

                if(type == "-1"){
                    $("#details_type").focus();
                    alert("Please select a field.");
                    return;
                }

                $.post("/update_company", {
                    id: id,
                    name: name,
                    address: address,
                    type: type
                })
                .fail(() => {
                    alert("Something went wrong...");
                })
                .done((json) => {
                    try{
                        if(json.result >= 0){
                            alert("company updated");
                            location.reload();
                        } else {
                            alert("Something went wrong...");
                        }
                    } catch(e) {
                        alert("Something went wrong...");
                    }
                })
                .always(bl.bind(null, false));
            });

            $("#contact_add").click(() => {
                $(".modal").load("/modal_insert_contact", () => {
                    $(".modal").modal();
        
                    $("#insert_contact").click(function(e) {
                        e.preventDefault();
        
                        //do some checks before post for some xtra UX
                        let
                            name = $("#name").val(),
                            phone = $("#phone").val();
        
                        if(!validate_contactdata(name, phone)){
                            return;
                        }
              
                        bl(true);
                        $.post("/insert_contact", {
                            company: id,
                            name: name,
                            phone: phone
                        })
                        .fail(() => {
                            alert("Something went wrong...");
                        })
                        .done((json) => {
                            try{
                                if(json.result >= 0){
                                    alert("Contact inserted");
                                    location.reload();
                                    $(".modify[data-id='" + id + "']").click();
                                } else {
                                    alert("Something went wrong...");
                                }
                            } catch(e) {
                                alert("Something went wrong...");
                            }
                        })
                        .always(bl.bind(null, false));
                    });
                });
            });

            $(".contact-modify").click(function(){
                let id = $(this).data("id");

                $(".modal").load("/modal_modify_contact/" + id, () => {
                    $(".modal").modal();

                    $("#update_contact").click(function(e) {
                        e.preventDefault();
        
                        //do some checks before post for some xtra UX
                        let
                            name = $("#name").val(),
                            phone = $("#phone").val();
        
                        if(!validate_contactdata(name, phone)){
                            return;
                        }

                        bl(true);
                        $.post("/update_contact", {
                            id: id,
                            name: name,
                            phone: phone
                        })
                        .fail(() => {
                            alert("Something went wrong...");
                        })
                        .done((json) => {
                            try{
                                if(json.result >= 0){
                                    alert("Contact updated");
                                    location.reload();
                                } else {
                                    alert("Something went wrong...");
                                }
                            } catch(e) {
                                alert("Something went wrong...");
                            }
                        })
                        .always(bl.bind(null, false));
                    });
                });
            });

            $(".contact-delete").click(function(){
                let id = $(this).data("id");

                if(confirm("Are you sure you want to remove this contact?")){
                    bl(true);
                    $.post("/delete_contact/" + id)
                    .fail(() => {
                        alert("Something went wrong...");
                    })
                    .done((json) => {
                        try{
                            if(json.result >= 0){
                                alert("Contact deleted");
                                $(".modify[data-id='" + id + "'").click();
                            } else {
                                alert("Something went wrong...");
                            }
                        } catch(e) {
                            alert("Something went wrong...");
                        }
                    })
                    .always(bl.bind(null, false));
                }
            });

            bl(false);
        });
    });
});