// Ready
jQuery(document).ready(function(){

  // Form verification
  jQuery('#downloadRequestForm')
  .form({
    fields: {
      name: {
        identifier: 'name',
        rules: [
          {
            type   : 'empty',
            prompt : 'Please enter your name'
          }
        ]
      },
      email: {
        identifier: 'email',
        rules: [
          {
            type   : 'empty',
            prompt : 'Please enter your email address'
          },
          {
            type   : 'email',
            prompt : 'Please enter a valid e-mail address'
          }
        ]
      } 
    }
  });

  // Setup modal window to capture user details
  jQuery('.ui.download.modal').modal({
    onApprove: function(){
      
      if(jQuery('#downloadRequestForm').form('is valid')){
        jQuery('#downloadRequestForm').submit();
      }
      else{
        return false;
      }
    }
  });

  // Setup click to submit the form and download the file
  jQuery('.download.link').click(function(e){

    // Find file name
    var thisFileName = jQuery(this).data('filename');

    // Update form and modal with relavant filename
    jQuery('#fileTodownloadHeading').html(thisFileName);
    jQuery('#downloadRequestForm input[name="filename"]').val(thisFileName);

    // Show the modal
    jQuery('.ui.download.modal').modal('show');
  });

});