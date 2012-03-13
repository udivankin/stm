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
         var cID = $(this).attr('commentID');
         $('#btnConfirmDeleteComment').attr('commentID',cID);
    });
    $("#btnConfirmDeleteComment").click(function() {
	 var cID = $(this).attr('commentID');
	 var request = $.ajax({
	    url: "/stories/delete-comment",
	    type: "POST",
	    data: {commentID: cID},
	    dataType: "json"
	 });
	 request.done(function(resp) {
	    if (resp.result==1) {
		$("#cmt"+cID).fadeOut(200);
	    } else {
                alert('xxx');
		$("#cmt"+cID).after('<div class="alert alert-error">Server message: error deleting comment.</div>');
	    }
	    $('div.modal').modal('hide');
	 });
	 request.fail(function(jqXHR, textStatus) {
	    $("#cmt"+cID).after('<div class="alert alert-error">Error while connecting to server.</div>');
	    $('div.modal').modal('hide');
	 });
    });

    /* rate accept reject story ajax */ 
    $("a.acceptRejectStory").click(function() {
	if ($(this).hasClass('disabled')) return false;
	$('#rateStoryModal').modal('show');
	var sID = $(this).attr('storyID');
        $('a#btnSetRatingAccept').attr('storyID',sID);
        $('a#btnSetRatingReject').attr('storyID',sID);
    });
    $("a#btnSetRatingAccept").click(function() {
	if ($(this).hasClass('disabled')) return false;
	var sID = $(this).attr('storyID');
	var ratingSet = $(this).attr('ratingSet');
	setStoryStatus(sID,3);
	setStoryRating(sID,ratingSet,location.reload());	
	$('div.modal').modal('hide');
	$('a#btnSetRatingAccept,a#btnSetRatingReject').addClass('disabled');
    });
    $("a#btnSetRatingReject").click(function() {
	if ($(this).hasClass('disabled')) return false;
	var sID = $(this).attr('storyID');
	var ratingSet = $(this).attr('ratingSet');	
	setStoryStatus(sID,4);
	setStoryRating(sID,ratingSet,location.reload());
	$('div.modal').modal('hide');
	$('a#btnSetRatingAccept,a#btnSetRatingReject').addClass('disabled');
    });
    
    /* set story rating ajax */ 
    var setStoryRating = function(sID,ratingToBeSet,callbackOnSuccess) {
	var request = $.ajax({
	    url: "/stories/set-story-rating",
	    type: "POST",
	    data: {storyID: sID, storyRating: ratingToBeSet},
	    dataType: "json"
	});
	request.done(function(resp) {
	    if (resp.result==1) {
		if (callbackOnSuccess !== undefined) callbackOnSuccess();
	    } else {
		$(".story[storyID="+sID+"]").after('<div class="alert alert-error">Server message: error updating rating.</div>');
	    }
	});	
    }
    
    $("#starRating li a").click(function() {
	var ratingSet = $(this).text();
	$("#starRating").removeClass('onestar twostar threestar fourstar fivestar');
	if (ratingSet == '1') $("#starRating").addClass('onestar')
	else if (ratingSet == '2') $("#starRating").addClass('twostar')
	else if (ratingSet == '3') $("#starRating").addClass('threestar')
	else if (ratingSet == '4') $("#starRating").addClass('fourstar')
	else if (ratingSet == '5') $("#starRating").addClass('fivestar');	
	$('a#btnSetRatingAccept').attr('ratingSet',ratingSet);
	$('a#btnSetRatingReject').attr('ratingSet',ratingSet);
	$('a#btnSetRatingAccept,a#btnSetRatingReject').removeClass('disabled');
    });
    
    /* delete story ajax */ 
    $(".deleteStory").click(function() {
	$('#deleteStoryModal').modal('show');
	var sID = $(this).attr('storyID');
        $('#btnConfirmDeleteStory').attr('storyID',sID);
    });
    $("#btnConfirmDeleteStory").click(function() {
	 var sID = $(this).attr('storyID');
	 var request = $.ajax({
	    url: "/stories/delete-story",
	    type: "POST",
	    data: {storyID: sID},
	    dataType: "json"
	 });
	 request.done(function(resp) {
	    if (resp.result==1) {
		$("div[storyid='"+sID+"']").fadeOut(200);
	    } else {
                alert('xxx');
		$("div[storyid='"+sID+"']").after('<div class="alert alert-error">Server message: error deleting story.</div>');
	    }
	    $('div.modal').modal('hide');
	 });
	 request.fail(function(jqXHR, textStatus) {
	    $("div[storyid='"+sID+"']").after('<div class="alert alert-error">Error while connecting to server.</div>');
	    $('div.modal').modal('hide');
	 });
    });
    
    /* add comment ajax */ 
    $(".addCommentBtn").click(function() {
	var sID = $(this).attr('storyID');
	var cText = $("#commentTextarea"+sID).val();
	var request = $.ajax({
	    url: "/stories/add-comment",
	    type: "POST",
	    data: {storyID: sID, commentText: cText},
	    dataType: "json"
	});
	request.done(function(resp) {
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
    
    /* set story status ajax */ 
    var setStoryStatus = function(sID,statusToBeSet,callbackOnSuccess) {
	var request = $.ajax({
	    url: "/stories/update-story-status",
	    type: "POST",
	    data: {storyID: sID, storyStatus: statusToBeSet},
	    dataType: "json"
	});
	request.done(function(resp) {
	    if (resp.result==1) {
		if (callbackOnSuccess !== undefined) callbackOnSuccess();
	    } else {
		$(".story[storyID="+sID+"]").after('<div class="alert alert-error">Server message: error updating  status.</div>');
	    }
	});	
    }
    $(".setStoryStatus").click(function() {
	if ($(this).hasClass('disabled')) return false;
	var sID = $(this).attr('storyID');
	var statusToBeSet = $(this).attr('statusToBeSet');
	setStoryStatus(sID,statusToBeSet,location.reload());
    });
    
    
    
});
