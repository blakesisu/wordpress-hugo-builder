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
  });
});
