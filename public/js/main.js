var modal = function(text){
    this.dialog = document.createElement("dialog");
    this.text = text;
};

modal.prototype.show = function(){
    
    var nodeT = document.createElement("p");
    nodeT.appendChild(document.createTextNode(this.text));
    nodeT.classList.add("dialog-title");
    
    var btn   = document.createElement("p");
    btn.classList.add("dialog-btn");
    btn.classList.add("dialog-btn__close");
    btn.appendChild(document.createTextNode("Zamknij"));
    
    this.dialog.appendChild(nodeT);
    this.dialog.appendChild(btn);
    this.dialog.classList.add("dialog");
    
    document.body.appendChild(this.dialog);
    if (! this.dialog.showModal) {
        dialogPolyfill.registerDialog(this.dialog);
    }
    this.dialog.showModal();
};
modal.prototype.close = function(){
    this.dialog.close();
    document.body.removeChild(this.dialog);
    this.dialog = document.createElement("dialog")
};
modal.prototype.text = function(text){
    this.text = text;
};

var mod = new modal("Dodano bazę danych");

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
    
    $(document).delegate(".dialog-btn__close", "click", function(evt){
        
        mod.close();
        
        evt.preventDefault();
    });
    
    mod.show();
    
});