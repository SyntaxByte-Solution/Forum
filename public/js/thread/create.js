

let urlprms = new URLSearchParams(window.location.search);

if(urlprms.has('type')) {
    if(urlprms.get('type') == 'poll') {
        let thread_add_container = $('#thread-add-wrapper');
        thread_add_container.find('.thread-type-value').val('poll');
        thread_add_container.find('#thread-add-discussion').addClass('none');
        thread_add_container.find('#thread-add-poll').removeClass('none');

        thread_add_container.find('.tap-discussion').attr('style', '');
        thread_add_container.find('.tap-poll').attr('style', 'background-color: #dfdfdf; cursor: default;');

        let selected_icon_path = thread_add_container.find('.tap-poll .selected-icon-path').val();
        let status_ico = thread_add_container.find('.thread-add-type-icon');
        status_ico.find('path').attr('d', selected_icon_path);
    }
}

/**
 * When user clicks on display thread add button to add a thread (post) we have to perform the following steps
 *      1. Fetch the faded thread add viewer and place it to the global viewer (show header strip meanwhile)
 *      2. Once the faded thread add placed and its events get handled we send a request to fetch thread add component
 *      3. once thread add component get fetched, we have to handle all the events
 */
let thread_add_viewer_bootstrapped = false;
$('.display-thread-add-viewer').on('click', function() {
    $('#thread-add-viewer').removeClass('none');
    if(thread_add_viewer_bootstrapped) return;
    
    // Step 1
    start_loading_strip();
    setTimeout(() => {
        $.ajax({
            url: '/thread/add/faded/fetch',
            type: 'get',
            success: function(response) {
                $('#thread-add-viewer .global-viewer-content').html(response);
                handle_fade_loading($('#thread-add-viewer .global-viewer-content'));
                
                // Step 2
            },
            complete: function() {
                stop_loading_strip();
            }
        });
    }, 600);
});

// ---------------- THREAD ADD EMBBED MEDIA SHARING ----------------
$('.thread-add-share').on('click', function(event) {
  let threadtype = $('#thread-add-wrapper .thread-type-value').val(); // discussion or poll

  let form_data = new FormData();
  form_data.append('_token' ,csrf);
  form_data.append('subject' ,$('#subject').val());
  form_data.append('category_id' ,$('.category').val());
  form_data.append('visibility_id' ,$('.thread-add-visibility-slug').val());

  let button = $(this);
  let btn_text_ing = button.parent().find('.message-ing').val();
  let btn_text_no_ing = button.parent().find('.message-no-ing').val();
  let container = $(this);
  while(!container.hasClass('thread-add-container')) {
      container = container.parent();
  }

  if(form_data.get('subject') == '') {
      $('#subject').parent().find('.error').removeClass('none');
      container.find('.thread-add-error').text($('#subject').parent().find('.required-text').val());
      container.find('.thread-add-error-container').removeClass('none');
      move_element_by_id('thread-add-wrapper');
      return;
  } else {
      $('#subject').parent().find('.error').addClass('none');
      container.find('.thread-add-error').text("");
      container.find('.thread-add-error-container').addClass('none');
  }
  let has_upload = false;

  const $threadcontent = $('.thread-add-container #content').nextAll('.CodeMirror')[0].CodeMirror;
  switch(threadtype) {
      case 'discussion':
          // Append thread content to the thread in case the user keep it as discussion
          form_data.append('content' ,$threadcontent.getValue());

          if(form_data.get('content') == '') {
              $('#content').parent().find('.error').removeClass('none');
              container.find('.thread-add-error').text($('#content').parent().find('.required-text').val());
              container.find('.thread-add-error-container').removeClass('none');
              move_element_by_id('thread-add-wrapper');
              return;
          } else {
              $('#content').parent().find('.error').addClass('none');
              container.find('.thread-add-error-container').addClass('none');
          }
          // ---------------- WE CHECK FOR MEDIAS ONLY IN DISCUSSION TYPE ----------------
          // Checking images existence in the thread
          /**
           * Update: instead of directly append files to form data, we take first the old filename and extract the extension
           * then we use the counter and append the extension to the counter value, in that way we get ascending order of file names to maintain order
           * when saving those files
           */
          if(uploaded_thread_images_assets.length) {
              has_upload = true;
              // Append image files
              for(let i = 0;i<uploaded_thread_images_assets.length;i++) {
                  // First filename
                  let filename = uploaded_thread_images_assets[i][1].name.toLowerCase();
                  // Get file extension with the preceding dot (ex: file.jpg => .jpg)
                  let ext = filename.substr(filename.lastIndexOf('.'));
                  // Then we store the file with the combination of counter and extension to preserve the order when saving files
                  filename = uploaded_thread_images_assets[i][0] + ext;
                  form_data.append('images[]', uploaded_thread_images_assets[i][1], filename);
              }
          }
          // Checking videos existence in the thread
          if(uploaded_thread_videos_assets.length) {
              has_upload = true;
              // Append videos files
              for(let i = 0;i<uploaded_thread_videos_assets.length;i++) {
                  // First filename
                  let filename = uploaded_thread_videos_assets[i][1].name.toLowerCase();
                  // Get file extension with the preceding dot (ex: file.jpg => .jpg)
                  let ext = filename.substr(filename.lastIndexOf('.'));
                  // Then we store the file with the combination of counter and extension to preserve the order when saving files
                  filename = uploaded_thread_videos_assets[i][0] + ext;
                  form_data.append('videos[]', uploaded_thread_videos_assets[i][1], filename);
              }
          }

          break;
      case 'poll':
          // Here the user choose a poll se we have to append the thread type
          // The validation in the serverside of the content is : only required if the user choose discussion type
          // But in db level the content is required for that reason we're going to add two dashes as content just to fulfil the validation
          form_data.append('type' , 'poll');
          form_data.append('content' , '##');
          form_data.append('allow_multiple_choice', $('#thread-add-poll .allow-multiple-choices').val());
          form_data.append('allow_choice_add', $('#thread-add-poll .allow-people-to-add-options').val());

          // Validating options rules
          let options = $('#thread-add-poll-options-box .thread-add-poll-option-container');
          if(options.length < 2) {
              container.find('.thread-add-error').text($('#options-length-required').val());
              container.find('.thread-add-error-container').removeClass('none');
              return;
          }
          let fillables_count = 0;
          let optionsvalues = [];
          options.each(function() {
              if($(this).find('.poll-option-value').val() != "") {
                  fillables_count++;
                  optionsvalues.push($(this).find('.poll-option-value').val());
              }
          });
          if(fillables_count < 2) {
              container.find('.thread-add-error').text($('#options-length-fillables-required').val());
              container.find('.thread-add-error-container').removeClass('none');
              return;
          } else {
              form_data.append('options' , JSON.stringify(optionsvalues));
              container.find('.thread-add-error-container').addClass('none');
          }
          break;
  }

  // When user click share and everything is validated we need to disable both subject and content inputs
  $('#subject').attr('disabled', 'disabled');
  if(threadtype == 'discussion') {
      $threadcontent.setOption('readOnly', 'nocursor');
  } else if(threadtype == 'poll') {
      $('#thread-add-poll-options-box .thread-add-poll-option-container').each(function() {
          $(this).find('.poll-option-value').attr('disabled', 'disabled');
      })
  }

  button.text(btn_text_ing);
  button.attr("disabled","disabled");
  button.attr('style', 'background-color: #acacac; cursor: default');
  $.ajax({
      xhr: function() {
          var xhr = new window.XMLHttpRequest();
          
          if(has_upload) {
              let progress_bar_box = container.find('.progress-bar-box');
              let progress_bar = progress_bar_box.find('.progress-bar');
              progress_bar_box.removeClass('none');

              xhr.upload.addEventListener("progress", function(evt) {
                  if (evt.lengthComputable) {
                      var percentComplete = evt.loaded / evt.total;
                      percentComplete = parseInt(percentComplete * 100);
                      progress_bar.css('width', percentComplete+"%");
                      progress_bar_box.find('.progress-bar-percentage-counter').text(percentComplete);
                      if(percentComplete >= 50) {
                          progress_bar_box.find('.progress-bar-percentage').css('color', 'white');
                      }
              
                      if (percentComplete === 100) {
                          if(progress_bar_box.find('.text-above-progress-bar').length) {
                              progress_bar_box.find('.text-above-progress-bar').text(progress_bar_box.find('.upload-finish-text').val());
                          }
                      }
                  }
              }, false);
          }
      
          return xhr;
      },
      url: '/thread',
      type: 'post',
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
      data: form_data,
      success: function(response) {
          if($('#threads-global-container').length) {
              let tid = response.id;
              $.ajax({
                  url: `/threads/${response.id}/component/generate`,
                  type: 'get',
                  success: function(thread) {
                      if(threadtype == 'discussion') {
                          $('.thread-add-uploaded-media').slice(1).remove();
                          // Clear thread add component inputs
                          $('.uploaded-images-counter').val('0');
                          $('.uploaded-videos-counter').val('0');

                          $threadcontent.setOption('readOnly', false);
                          $threadcontent.getDoc().setValue("");
                          $('#thread-photos').val('');
                          $('#thread-videos').val('');
                          uploaded_thread_images_assets = [];
                          uploaded_thread_videos_assets = [];
                          uploaded_thread_media_counter = 0;

                          if(has_upload) {
                              let progress_bar_box = container.find('.progress-bar-box');
                              let progress_bar = progress_bar_box.find('.progress-bar');
              
                              progress_bar_box.addClass('none');
                              progress_bar_box.find('.text-above-progress-bar').text(progress_bar_box.find('.uploading-text').val());
                              progress_bar_box.find('.progress-bar-percentage').css('color', 'black');
                              progress_bar.css('width', '0%');
                          }
                      } else if(threadtype == 'poll') {
                          $('#thread-add-poll-options-box .thread-add-poll-option-container').each(function() {
                              let option_input = $(this).find('.poll-option-value');
                              option_input.attr('disabled', false);
                              option_input.val('');
                              option_input.trigger('focus');
                          });
                          $('body').trigger('click');
                      }

                      $('#subject').attr('disabled', false);
                      $('#subject').val('');

                      button.text(btn_text_no_ing);
                      button.attr("disabled",false);
                      button.attr('style', '');

                      $('#threads-global-container').prepend(thread);

                      let unhandled_thread = $('#threads-global-container').find('.thread-container-box').first();
                      force_lazy_load(unhandled_thread);
                      handle_thread_events(unhandled_thread);
                      handle_document_suboptions_hiding();
                      move_element_by_id('thread'+tid, 65);
                      basic_notification_show(button.parent().find('.successful-share').val(), 'basic-notification-round-tick');
                  }
              })
          } else {
              window.location.href = response.link;
          }
      },
      error: function(response) {
          if(has_upload) {
              let progress_bar_box = container.find('.progress-bar-box');
              let progress_bar = progress_bar_box.find('.progress-bar');

              progress_bar_box.addClass('none');
              progress_bar_box.find('.text-above-progress-bar').text(progress_bar_box.find('.uploading-text').val());
              progress_bar_box.find('.progress-bar-percentage').css('color', 'black');
              progress_bar.css('width', '0%');
          }
          
          let errors = JSON.parse(response.responseText);
          let error;

          if(errors.message) {
              error = errors.message;
          } else if(errors.error) {
              error = errors.error;
          } else {
              // The errors object hold errors keys as well as error values in form of array of errors
              // because a field could have multiple validation constraints and then it could have multiple errors
              // strings. In this case we only need the first error of the first validation
              error = errors[Object.keys(errors)[0]][0];
          }

          container.find('.thread-add-error-container').removeClass('none');
          container.find('.thread-add-error').html(error);

          $('#subject').attr('disabled', false);
          $threadcontent.setOption('readOnly', false);

          button.text(btn_text_no_ing);
          button.attr("disabled",false);
          button.attr('style', '');

          move_element_by_id('thread-add-wrapper');
      },
      complete: function(response) {
          
      }
  });
  
  return false;
});

// The following three variables will be used in edit thread (look at /thread/edit.js)
let already_uploaded_thread_images_assets = [];
let already_uploaded_thread_videos_assets = [];
let edit_deleted_medias = [];

let uploaded_thread_images_assets = [];
let uploaded_thread_videos_assets = [];
let uploaded_thread_media_counter = 0;
// This will track image uploads --- [Now it is possible to share more than one image] ---
$("#thread-photos").on('change', function(event) {
    // First we close the error if it is opened
    $('.thread-add-media-error p').addClass('none');
    /**
     * IMPORTANT: Because this is input file, if it gets clicked two times a row, then it will remove all the first files and
     * replace them with the new files so we will handle the situation where we upload more than one file; then we put them in an array;
     * then later if the user want to add more image or video; we'll take that addition and append it to the array(uploaded_thread_assets)
     * First we get the container and store it in a variable, then we loop through files and assign each one to the container and append
     * it to the post container to show it to the user
     */

    /**
     * First get the new uploaded files and passed them to validation function.
     * Images type validation function get the files, verify their types and then return an array of validated images
     * If the length of the returned array matches the length of original array of files; that means all files are validated :)
     * If not display the 
     */
     let media_container = $(this);
     while(!media_container.hasClass('thread-add-media-section')) {
         media_container = media_container.parent();    
     }

    let images = event.originalEvent.target.files;
    let validated_images = validate_image_file_Type(images);

    // First we check if all images passes image type by comparing uploaded images with validated images lengths
    if(images.length != validated_images.length) {
        /**
         * Print error: Only jpeg, png .. are supported
         * (tame: thread add media error)
         */
        media_container.find('.tame-image-type').removeClass('none');
    } else {
        media_container.find('.tame-image-type').addClass('none');
        media_container.find('.tame-video-type').addClass('none');
    }

    /** 
     * then we check the limit of uploaded images 
     * Notice: already uploaded videos and images is useful in edit page where the user has already upload images
     * we place those uploaded medias in separate arrays and then we check if the global number of medias is passable
     * ex: If user already uploaded 5 images, and then later he want to edit the thread by adding
     * 18 images, here we have to check if 18 + 5 < 20; If so then OK
     * Otherwise: we have to take only 15 from 18
     */
    if(validated_images.length + uploaded_thread_images_assets.length > 20
        || validated_images.length + uploaded_thread_images_assets.length + already_uploaded_thread_images_assets.length > 20) {
        media_container.find('.tame-image-limit').removeClass('none');
        validated_images = validated_images.slice(0, 20-(uploaded_thread_images_assets.length+already_uploaded_thread_images_assets.length));
    }
    
    images = validated_images;
    for(let i=0;i<images.length;i++) {
        /**
         * Here instead of pushing only the file to the array we have to pass also the counter (used to preserve the order) 
         * of uploaded file and then increment it
         */
        uploaded_thread_images_assets.push([uploaded_thread_media_counter, images[i]]);
        uploaded_thread_media_counter++;
    }
    /**
     * Now we loop through the new files and append them to thread-add-uploaded-medias-container by cloning 
     * thread-add-uploaded-media-projection-model container
     * About the other validations like file size we're gonna implement them in the backend
     */
    for (let i = 0; i < images.length; i++) {
        let clone = $('.thread-add-uploaded-media-projection-model').clone(true);
        $('.thread-add-uploaded-medias-container').append(clone);

        // Increment uploaded images index
        let upload_images_index = $('.thread-add-uploaded-medias-container').find('.uploaded-images-counter');
        let images_counter = parseInt(upload_images_index.val()) + 1;
        upload_images_index.val(images_counter);

        let global_medias_count = images_counter
        + already_uploaded_thread_images_assets.length
        + already_uploaded_thread_videos_assets.length
        + parseInt($('.thread-add-uploaded-medias-container').find('.uploaded-videos-counter').val());

        // We get the last uploaded image container
        let last_uploaded_image = $(".thread-add-uploaded-medias-container .thread-add-uploaded-media").last();
        last_uploaded_image.find('.uploaded-media-index').val(images_counter-1); // we want 0 based indexes here
        last_uploaded_image.find('.uploaded-media-genre').val('image'); // this is useful when close button is pressed in order for us to know from where we should delete the uploaded file(either from videos array container/image array container)

        last_uploaded_image.removeClass('none thread-add-uploaded-media-projection-model');
        if(global_medias_count >= 5) {
            if(global_medias_count == 5)
                $('.thread-add-uploaded-medias-container').addClass('scrollx');
                
                // Scroll to the end position of x axe
                let c = $('.thread-add-uploaded-medias-container');
                c[0].scrollLeft = c[0].scrollWidth;
        }

        let img = last_uploaded_image.find(".thread-add-uploaded-image");
        img.removeClass('none');

        // Preview the image
        load_image(images[i], img);
    }

    // Clear the input because we don't need its value; we use arrays to store files
    $(this).val('');
});
$("#thread-videos").on('change', function(event) {
    // First we close the error if it is opened
    $('.thread-add-media-error p').addClass('none');
    /**
     * IMPORTANT: see notices inside thread-image change event handler above
     */
     let media_container = $(this);
     while(!media_container.hasClass('thread-add-media-section')) {
         media_container = media_container.parent();    
     }

    let videos = event.originalEvent.target.files;
    let validated_videos = validate_video_file_Type(videos);

    if(videos.length != validated_videos.length) {
        media_container.find('.tame-video-type').removeClass('none');
    } else {
        media_container.find('.tame-video-type').addClass('none');
        media_container.find('.tame-image-type').addClass('none');
    }

    videos = validated_videos;

    /** First let's limit the number of uploaded files */
    if(videos.length + uploaded_thread_videos_assets.length > 4 
        || videos.length + uploaded_thread_videos_assets.length + already_uploaded_thread_videos_assets.length > 4) {
        videos = videos.slice(0, 4-(uploaded_thread_videos_assets.length+already_uploaded_thread_videos_assets.length));
        media_container.find('.tame-video-limit').removeClass('none');
    } else {
        media_container.find('.tame-video-limit').addClass('none');
    }

    for(let i=0;i<videos.length;i++) {
        uploaded_thread_videos_assets.push([uploaded_thread_media_counter, videos[i]]);
        uploaded_thread_media_counter++;
    }
    
    for (let i = 0; i < videos.length; i++) {
        let clone = $('.thread-add-uploaded-media-projection-model').clone(true);
        $('.thread-add-uploaded-medias-container').append(clone);
        // Increment the index
        let upload_videos_index = $('.thread-add-uploaded-medias-container').find('.uploaded-videos-counter');
        let videos_counter = parseInt(upload_videos_index.val()) + 1;
        upload_videos_index.val(videos_counter);
        
        let global_medias_count = videos_counter
            + already_uploaded_thread_images_assets.length
            + already_uploaded_thread_videos_assets.length
            + parseInt($('.thread-add-uploaded-medias-container').find('.uploaded-images-counter').val());
        
        // We get the last uploaded video container
        let last_uploaded_video = $(".thread-add-uploaded-medias-container .thread-add-uploaded-media").last();
        last_uploaded_video.find('.uploaded-media-index').val(videos_counter-1); // we want 0 based indexes here
        last_uploaded_video.find('.uploaded-media-genre').val('video'); // this is useful when close button is pressed in order for us to know from where we should delete the uploaded file(either from videos array container/image array container)
        
        last_uploaded_video.find('.thread-add-video-indicator').removeClass('none');

        last_uploaded_video.removeClass('none thread-add-uploaded-media-projection-model');
        if(global_medias_count >= 5) {
            if(global_medias_count == 5)
                $('.thread-add-uploaded-medias-container').addClass('scrollx');

            // Scroll to the end position of x axe
            let c = $('.thread-add-uploaded-medias-container');
            c[0].scrollLeft = c[0].scrollWidth;
        }

        
        // Preview the image (here image should be a snapshot from the video uploaded)
        let img = last_uploaded_video.find(".thread-add-uploaded-image");
        img.removeClass('none');
        try {
            // get the frame at 1.5 seconds of the video file
            get_thumbnail(videos[i], 1.5, img.parent()).then(value => {
                img.attr("src", value);
                handle_image_dimensions(img);
            });
        } catch(e) {
            
        }
    }

    // Clear the input because we don't need its value; we use arrays to store files
    $(this).val('');
});

$('.thread-add-uploaded-media').each(function() {
  handle_close_uploaded_media($(this));
});

function handle_close_uploaded_media(container) {
  container.find('.close-thread-media-upload').on('click', function() {
      // First we close the error if it is opened
      $('.thread-add-media-error p').addClass('none');
      /**
       * Before deleting the component we need the whole components container to decrement the 
       * global upload media counter and the genre of the component whether it's an image or video
       */
      let container = $(this);
      while(!container.hasClass('thread-add-uploaded-medias-container')) {
          container = container.parent();
      }
      let component_genre = $(this).parent().find('.uploaded-media-genre').val();
      let index_to_remove = $(this).parent().find('.uploaded-media-index').val();

      // Then we have to know the genre of component(image/video) in rorder to delete it from the array container type
      if(component_genre == 'image') {
          // decrement the uploaded images counter
          let global_images_counter = container.find('.uploaded-images-counter');
          global_images_counter.val(parseInt(global_images_counter.val()) - 1);

          uploaded_thread_images_assets.splice(index_to_remove, 1);
      } else if(component_genre == 'video') {
          // decrement the uploaded videos counter
          let global_videos_counter = container.find('.uploaded-videos-counter');
          global_videos_counter.val(parseInt(global_videos_counter.val()) - 1);
          
          uploaded_thread_videos_assets.splice(index_to_remove, 1);
      }

      // Then we need to remove the component
      $(this).parent().remove();

      // After removeing the component we need to adjust indexes
      adjust_uploaded_medias_indexes();

      global_counter = 
          $('#thread-uploads-wrapper .thread-add-uploaded-media').length;
      if(global_counter <= 4) {
          $('.thread-add-uploaded-medias-container').removeClass('scrollx');
      }
  })
}
function adjust_uploaded_medias_indexes() {
  let images_count = 0;
  let videos_count = 0;
  $('.thread-add-uploaded-media').each(function() {
      if($(this).find('.uploaded-media-genre').val() == 'image') {
          $(this).find('.uploaded-media-index').val(images_count);
          images_count++;
      } else if($(this).find('.uploaded-media-genre').val() == 'video') {
          $(this).find('.uploaded-media-index').val(videos_count);
          videos_count++;
      }
  });
}

$('.close-thread-media-upload-edit').on('click', function() {
  // First we close the error if it is opened
  $('.thread-add-media-error p').addClass('none');

  edit_deleted_medias.push($(this).parent().find('.uploaded-media-url').val());

  $(this).parent().remove();
});

$('.thread-add-container textarea').each(function() {
  let simplemde = new SimpleMDE({
      hideIcons: ["guide", "heading", "image"],
      spellChecker: false,
      mode: 'markdown',
      showMarkdownLineBreaks: true,
  });
});

$('.thread-add-poll-option-container').each(function() {
  handle_input_with_dynamic_label($(this));
  handle_poll_option_delete($(this));
});

function handle_poll_option_delete(option) {
  option.find('.remove-poll-option').on('click', function() {
      let option_container = $(this);
      while(!option_container.hasClass('thread-add-poll-option-container')) {
          option_container = option_container.parent();
      }
      let deleted_index = parseInt(option_container.find('.ta-option-index').text())-1;

      // Adjusting indexes of options' labels (Option n) that come after the deleted option
      $('#thread-add-poll-options-box .thread-add-poll-option-container').each(function(index) {
          if(index >= deleted_index) {
              $(this).find('.ta-option-index').text(parseInt($(this).find('.ta-option-index').text())-1);
          }
      });

      option_container.remove();
      if($('#thread-add-poll-options-box .thread-add-poll-option-container').length < 4) {
          $('#thread-add-poll-options-box').css('overflow-y', 'unset');
      }
  });
}

$('.poll-add-option').on('click', function() {
  let existing_options_length = $('#thread-add-poll-options-box .thread-add-poll-option-container').length;
  if(existing_options_length < 30) { // Allow only 30 option
      let newoption = $('.thread-add-poll-option-factory').clone();
      newoption.removeClass('thread-add-poll-option-factory none');
      newoption.find('.ta-option-index').text(existing_options_length+1);
      // Append option
      $('#thread-add-poll-options-box').append(newoption);
      // Handle events
      handle_input_with_dynamic_label(newoption.find('.dynamic-input-wrapper'));
      handle_poll_option_delete(newoption);
      handle_option_keyup(newoption.find('.poll-option-validation'));

      if(existing_options_length >= 3) {
          $('#thread-add-poll-options-box').css('overflow-y', 'scroll');
          $('#thread-add-poll-options-box').scrollTop(function() { return this.scrollHeight; });
      }
  } else {
      let limit_error = $('#options-length-limit-error').val();
      display_top_informer_message(limit_error, 'warning');
  }
});

$('.allow-multiple-choices-button').on('click', function() {
  let status = $("#thread-add-poll").find('.allow-multiple-choices');
  if(status.val() == 'no') {
      status.val('yes');
  } else {
      status.val('no');
  }
});

$('.allow-others-to-add-choices-button').on('click', function() {
  let status = $("#thread-add-poll").find('.allow-people-to-add-options');
  if(status.val() == 'no') {
      status.val('yes');
  } else {
      status.val('no');
  }
});

let thread_add_forum_lock = true;
$('.thread-add-forum').on('click', function() {
    if(!thread_add_forum_lock) {
        return;
    }
    thread_add_forum_lock = false;

    let button = $(this);
    let loading_anim = button.find('.loading-dots-anim');
    loading_anim.removeClass('none');
    start_loading_anim(loading_anim);

    let thread_add_container = button;
    while(!thread_add_container.hasClass('thread-add-container')) {
        thread_add_container = thread_add_container.parent();
    }

    let forum_id = button.find('.forum-id').val();

    $.ajax({
        url: `/forums/${forum_id}/categories/ids`,
        type: 'get',
        success: function(response) {
            // First change the icon
            $('.thread-add-forum-icon').html(button.find('.forum-ico').html());

            let categories = JSON.parse(response);
            $('.thread-add-category:not(:first)').remove();

            let first_iteration = true;
            $.each(categories, function(id, category){
                if(first_iteration) {
                    $('.thread-add-selected-category').text(category.category);
                    $('.thread-add-category').find('.thread-add-category-val').text(category.category);
                    $('.thread-add-category').find('.category-id').text(category.id);
                    thread_add_container.find('.category').val(category.id);
                    first_iteration = false;
                } else {
                    $('.thread-add-categories-container').append(`
                        <div class="thread-add-suboption thread-add-category flex align-center">
                            <span class="thread-add-category-val">${category.category}</span>
                            <input type="hidden" class="category-id" value="${category.id}">
                        </div>
                    `);

                    handle_category_selection($('.thread-add-category').last());
                }
            });
        },
        complete: function() {
            // Stop loading animation
            loading_anim.addClass('none');
            loading_anim.text('•');
            stop_loading_anim();

            thread_add_container.find('.forum').val(forum_id);

            // setting forum to posted to:
            $('.thread-add-selected-forum').text(button.find('.thread-add-forum-val').text());
            // Hide the suboptions container
            $('.thread-add-forum').removeClass('thread-add-suboption-selected');
            
            button.addClass('thread-add-suboption-selected');
            button.parent().css('display', 'none');
            thread_add_forum_lock = true;
        }
    })
});

$('.thread-add-category').each(function() {
    handle_category_selection($(this));
})

function handle_category_selection(category_button) {
    category_button.on('click', function(event) {
        event.stopPropagation();
        $(".thread-add-selected-category").text(category_button.find('.thread-add-category-val').text());

        let container = category_button;
        while(!container.hasClass('thread-add-container')) {
            container = container.parent();
        }
        container.find('.category').val(category_button.find('.category-id').val());

        $(this).parent().parent().css('display', 'none');
    });
}

$('.thread-add-type-change').on('click', function(event) {
    event.stopPropagation();

    let container = $(this);
    while(!container.hasClass('thread-add-container')) {
        container = container.parent();
    }

    let selected_thread_type = $(this).find('.thread-type').val();
    container.find('.thread-type-value').val(selected_thread_type)

    let selected_icon_path = $(this).find('.selected-icon-path').val();
    let status_ico = container.find('.thread-add-type-icon');
    status_ico.find('path').attr('d', selected_icon_path);

    switch(selected_thread_type) {
        case 'discussion':
            container.find('#thread-add-discussion').removeClass('none');
            container.find('#thread-add-poll').addClass('none');
            break;
        case 'poll':
            container.find('#thread-add-discussion').addClass('none');
            container.find('#thread-add-poll').removeClass('none');
            break;
    }
    $('.thread-add-type-change').attr('style', '');
    $(this).attr('style', 'background-color: #dfdfdf; cursor: default;');

    // Hide errors
    $('.thread-add-error-container').addClass('none');
    $('#thread-add-wrapper .asterisk-error').addClass('none');

    $('body').trigger('click'); // This will hide all suboptions containers
});

$('.thread-add-visibility').on('click', function(event) {
  event.stopPropagation();

  let container = $(this);
  while(!container.hasClass('thread-add-container')) {
      container = container.parent();
  }

  container.find('.thread-add-visibility-slug').val($(this).find('.thread-visibility').val());

  let selected_icon_path = $(this).find('.selected-icon-path').val();
  let status_ico = container.find('.thread-add-visibility-icon');

  status_ico.find('path').attr('d', selected_icon_path);
  
  $(this).parent().css('display', 'none');
});