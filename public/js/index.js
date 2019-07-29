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
});