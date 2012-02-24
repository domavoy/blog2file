function showServerError(message) {
  alert("An error occured on the server and we could not finish this operation.\n\n" + message) 
}

// Re-arranges each ActiveRecord error from 2-elements array into hash
function error_messages(data) {
  var errors = {}
  for( i in data) { errors[data[i][0]] = data[i][1]; }
  return errors;
}

function format_errors(errors) {
  message = ''
  for(i in errors) {
    message += '  * ' + errors[i][0] + ' ' + errors[i][1] + "\n"
  }
  return message
}

jQuery(function($) {


  // Show tip on how to insert code
  $("#tip_how_to_insert_code_trigger").click(function() {
    $.cookie('tip_how_to_insert_code', 1, { path: '/', expires: 3560 } );
    $(this).hide();
    $("#tip_how_to_insert_code").show();
  });

  // Setting current time cookie to get user's timezone
  if(!($.cookie('timezone'))) {
    current_time = new Date();
    $.cookie('timezone', current_time.getTimezoneOffset(), { path: '/', expires: 3560 } );
  } 

  // disables submit buttons in forms
  $("form").submit(function() {
    $(":submit", this).attr("disabled", "disabled");
  });
  // enables buttons, when user clicks "back" button in browser
  $(":submit").attr("disabled", "")

});
