jQuery(function ($) {
  /* You can safely use $ in this code block to reference jQuery */
  $(document).ready(function(){
    $('#hugopress-api-test-submit').click(function(e){
      e.preventDefault();
      var formInput = $('#hugopress-api-test-input').val();
      console.log('clicked?', formInput);

      $('#hugopress-api-test-mssg').empty();

      $.ajax({
        url: hugopress_post.ajax_url,
        type: 'post',
        data: {
          action: 'test_hugopress_api',
          input: formInput
        },
        success: function(response) {
          // Response div goes here.
          console.log('res', response);
          $('#hugopress-api-test-mssg').append(`<h2>HugoPress API Endpoints:</h2>`);
          response.split(' ').forEach((point) => {
            $('#hugopress-api-test-mssg').append(`<p>${point}</p>`);
          })
        }
      });

    });
  });
});
