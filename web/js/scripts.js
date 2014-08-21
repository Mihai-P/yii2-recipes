$(function() {
  $( document ).on( "click", "a.remove-filename", function(event) {
    event.preventDefault();
    $($(this).attr('href')).val('');
    $(this).closest('.hint-block').html('');
  });	
});