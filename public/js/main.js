$(document).ready(function(){
    
    var site = $("#hidden").html();
    
    var add  = $("#submit");
    var del  = $(".base_name a:nth-child(2)");
    
    if (site == "database") {
        
        add.on("click", function(evt){
            var name = $(".namein").val();
            
            $.ajax({
                method: "POST",
                url: "/database/add",
                data: {
                    database: name,
                    ajax: true
                },
                success: function(data){
                    if (data.create) {
                        alert("Utworzono bazę danych");
                        location.reload();
                    } else {
                        if (!!data.reason) {
                            alert(data.reason);
                        } else {
                            alert("Podaj poprawną nazwę");
                        }
                    }
                }
            });
            
            evt.preventDefault();    
        });
        
        del.on("click", function(evt){
            var name = $(this).prev().html();
            
            $.ajax({
                method: "POST",
                url: "/database/delete/" + name,
                data: {
                    ajax: true
                },
                success: function(data){
                    if (data.delete) {
                        alert("Usunięto bazę danych");
                        location.reload();
                    } else {
                        alert("Nie można usunąć bazy dancyh");
                    }
                }
            });
            
            evt.preventDefault();
        });
        
    } else if (site == "table") {
        
        del.on("click", function(evt){
            var name = $(this).prev().html();
            
            $.ajax({
                method: "POST",
                url: "/table/delete/" + name,
                data: {
                    ajax: true
                },
                success: function(data){
                    if (data.delete) {
                        alert("Usunięto tabelę");
                        location.reload();
                    } else {
                        if (!!data.reason)
                            alert(data.reason)
                        else
                            alert("Nie można usunąć tabeli");
                    }
                }
            });
            
            evt.preventDefault();
        });
        
    }
    
});