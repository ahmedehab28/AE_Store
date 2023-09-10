document.getElementById("edit-button").addEventListener("click", function(event){
    event.preventDefault();
    var trs = document.querySelectorAll("tbody tr");
    trs.forEach(function(tr){
        var fieldName = tr.getAttribute('data-field');
        var td = tr.querySelector("td");
        var content = td.innerHTML;
        td.innerHTML = '<input class="form-control" name="' + fieldName + '" value="' + content + '" />';
    });
    this.style.display = 'none';
    document.getElementById("update-button").style.display = "inline-block";
    document.getElementById("cancel-button").style.display = "inline-block";
});


document.getElementById("cancel-button").addEventListener("click", function(){
    var inputs = document.querySelectorAll("td input");
    inputs.forEach(function(input){
        var content = input.value;
        input.parentNode.innerHTML = content;
    });
    this.style.display = "none";
    document.getElementById("update-button").style.display = 'none';
    document.getElementById("edit-button").style.display = "inline-block";
});

