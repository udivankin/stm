/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() { 

    $('.tooltiped').tooltip({placement:'left'});
    
    $('.commentbutton').toggle(function() {
        $(this).parentsUntil('.alert').next().fadeIn(200);
    }, function() {
        $(this).parentsUntil('.alert').next().fadeOut(200);
    });
    
    $(".filterByStatus").click(function() {
	var statusID = $(this).attr('filterstatus');
	$('.story').hide();
	$('.story[storyStatus="'+statusID+'"]').fadeIn(200);
    });
    
    $(".addCommentBtn").click(function() {
	var sID = $(this).attr('storyID');
	var cText = $("#commentTextarea"+sID).val();
	
	var request = $.ajax({
	    url: "/stories/add-comment",
	    type: "POST",
	    data: {storyID: sID, commentText: cText},
	    dataType: "html"
	});

	request.done(function(data) {
	    var resp = eval('(' + data + ')');
	    if (resp.result==1) {
		$("#commentTextarea"+sID).before('<pre>'+resp.text+'</pre>');
	    } else {
		$("#commentTextarea"+sID).before('<div class="alert alert-error">Server message: error writing comment.</div>');
	    }
	});

	request.fail(function(jqXHR, textStatus) {
	    $("#commentTextarea"+sID).before('<div class="alert alert-error">Error while pushing comment to server.</div>');
	});
	
    });
	
});
