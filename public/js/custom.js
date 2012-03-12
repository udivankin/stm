/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() { 

    $('.tooltiped').tooltip({placement:'left'});
    
    /* show/hide comments */
    $('.commentbutton').toggle(function() {
        $(this).parentsUntil('.alert').next().fadeIn(200);
    }, function() {
        $(this).parentsUntil('.alert').next().fadeOut(200);
    });
    
    /* filter stories by status id */
    $("#storyFilters .filterByStatus").click(function() {
	var statusID = $(this).attr('filterstatus');
	$('.story').hide();
	$('.story[storyStatus="'+statusID+'"]').fadeIn(200);
	$(this).parent().siblings().removeClass('active');
	$(this).parent().addClass('active');
    });
    
    /* filter stories by officer */
    $("#storyFilters .filterByOfficer").click(function() {
	var uName = $(this).attr('storyofficer');
	$('.story').hide();
	$('.story[storyofficer="'+uName+'"]').fadeIn(200);
	$(this).parent().siblings().removeClass('active');
	$(this).parent().addClass('active');
    });
 
    $(".resetFilters").click(function() {
	$('#storyFilters li').removeClass('active');
	$('.story').fadeIn(200);
    }); 
    
    
    /* close any modal dialog by clicking No,thanks button */
    $(".btnModalClose").click(function() {
	 $('div.modal').modal('hide');
    });
    
    /* delete comment ajax */    
    $(".removeComment").click(function() {
	 $('#deleteCommentModal').modal('show');
    });

    $("#btnConfirmDeleteComment").click(function() {
	 var cID = $(this).attr('commentID');
	 var request = $.ajax({
	    url: "/stories/delete-comment",
	    type: "POST",
	    data: {commentID: cID},
	    dataType: "html"
	 });
	 request.done(function(data) {
	    var resp = eval('(' + data + ')');
	    if (resp.result==1) {
		$("#cmt"+cID).hide();
	    } else {
		$("#cmt"+cID).after('<div class="alert alert-error">Server message: error deleting comment.</div>');
	    }
	    $('div.modal').modal('hide');
	 });
	 request.fail(function(jqXHR, textStatus) {
	    $("#cmt"+cID).after('<div class="alert alert-error">Error while connecting to server.</div>');
	    $('div.modal').modal('hide');
	 });	
    });
    
    /* delete story ajax */ 
    $(".deleteStory").click(function() {
	$('#deleteStoryModal').modal('show');
	var sID = $(this).attr('storyID');
    });
    
    /* add comment ajax */ 
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
		$("#commentTextarea"+sID).val('');
	    } else {
		$("#commentTextarea"+sID).before('<div class="alert alert-error">Server message: error writing comment.</div>');
	    }
	});
	request.fail(function(jqXHR, textStatus) {
	    $("#commentTextarea"+sID).before('<div class="alert alert-error">Error while pushing comment to server.</div>');
	});
    });
	
});
