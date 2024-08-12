var id=updoot;
var username="himanshu";
$(document).ready(function() {
    $('.upvoteinput').click(function() { //line 72 and 80....upvotee and downvote class
        var id2 = $(this).attr('id'); //our id is like "updoot-67" or "downdoot-67"
        var id = id2.substr(id2.sindexOf("-") + 1); //so here we have got just the number part of our id
        var username = $('username').value;   // $(), can be used as shorthand for the getElementById function. To refer to an element in the Document Object Model (DOM) of an HTML page, the usual function identifying an element is: document. getElementById("id_of_element").
        if (username == null) {
            return false;
        }
        var votevalue = 0;
        if (id2.startsWith("updoot")) votevalue = 1;
        if (id2.startsWith("downdoot")) votevalue = -1;
        $.ajax({                
            type: "POST",
            url: "vote.php?postid=" + id + "&username=" + username +"&vote=" + votevalue,
            data: "",
            success: function(msg){}, //AJAX success is a global event. Global events are triggered on the document to call any handlers who may be listening. The ajaxSuccess event is only called if the request is successful. It is essentially a type function that's called when a request proceeds.
            error: function(msg){}    // reverse of AJAX success
        });
    });
});