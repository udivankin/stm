/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() { 

    $('.tooltiped').tooltip({placement:'left'});
    
    $('.commentbutton').button();
    
    $('.commentbutton').toggle(function() {
        $(this).parentsUntil('.alert').next().fadeIn(200);        
    }, function() {
        $(this).parentsUntil('.alert').next().fadeOut(200);  
    });
    
    
});
