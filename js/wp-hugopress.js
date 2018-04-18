jQuery(function ($) {
  /* You can safely use $ in this code block to reference jQuery */
  $(document).ready(function(){
    $('#hugopress-api-test-submit').click(function(e){
      e.preventDefault();
      // var formInput = $('#hugopress-api-test-input').val();
      // console.log('clicked?', formInput);

      $('#hugopress-api-test-mssg').empty();

      $.ajax({
        url: hugopress_post.ajax_url,
        type: 'post',
        data: {
          action: 'test_hugopress_api',
          input: '/endpoints'
        },
      })
        .done(function(response) {
          // console.log('res', response);
          $('#hugopress-api-test-mssg').append(`<h2>HugoPress API Endpoints:</h2>`);
          response.split(' ').forEach((point, idx) => {
            if (point.length) {
              $('#hugopress-api-test-mssg').append(`<p> ${idx}: ${point}</p>`);
            }
          })
        })
      .fail(function(err) {
        console.log('fail', err);
        $('#hugopress-api-test-mssg').append(`<h2>HugoPress API Endpoints:</h2>`);
        $('#hugopress-api-test-mssg').append(`<p>Error in ajax request. Check base url.</p>`);
      });
    });

    $('#pressword-api-submit').click(function(e){
      e.preventDefault();
      let alias = $('#pressword-alias-input').val();
      let url = $('#pressword-url-input').val();
      console.log(`clicked?, alias: ${alias}, url: ${url}`);

      $.ajax({
        url: hugopress_post.ajax_url,
        type: 'post',
        data: {
          action: 'set_new_api',
          alias: alias, // your new value variable
          url: url
        },
        dataType: 'json'
      }).done(function( json ) {
        alert( "Ajax call succeeded, let's see what the response was." );
        if( json.success ) {
          alert( "Function executed successfully and returned: " + json.message );
        } else if( !json.success ) {
          alert( "Function failed and returned: " + json.message );
        }
      }).fail(function(err) {
        alert( "The Ajax call itself failed.", err );
      })
    });
  });
});
