// Handle visibility editing
handle_thread_visibility_switch($('.visibility-box'));

let last_media_count = $('#thread-uploads-wrapper .uploaded-media-url').last();
if(last_media_count.length) {
  let url = last_media_count.val();
  let filename = url.substring(url.lastIndexOf("/") + 1, url.lastIndexOf("."));

  last_media_count = parseInt(filename) + 1;
} else {
  last_media_count = 0;
}

$('.content-container textarea').each(function() {
    var simplemde = new SimpleMDE({
        element: this,
        hideIcons: ["guide", "heading", "image"],
        spellChecker: false,
        mode: 'markdown',
        showMarkdownLineBreaks: true,
    });
    simplemde.render();
});

let GetFileBlobUsingURL = function (url, convertBlob) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", url);
  xhr.responseType = "blob";
  xhr.addEventListener('load', function() {
      convertBlob(xhr.response);
  });
  xhr.send();
};
let blobToFile = function (blob, name) {
  blob.lastModifiedDate = new Date();
  blob.name = name;
  return blob;
};
let GetFileObjectFromURL = function(filePathOrUrl, convertBlob) {
  GetFileBlobUsingURL(filePathOrUrl, function (blob) {
    convertBlob(blobToFile(blob, 'testFile.jpg'));
  });
};

// Loop through already uploaded images and videos and do the same as you did in inline script blade ;
$('.thread-add-uploaded-media').each(function() {
  let container = $(this);
  let frame = container.find('.thread-add-uploaded-image');
  let type = container.find('.uploaded-media-genre').val();

  if(type == 'image') {
    container.imagesLoaded(function() {
      handle_image_dimensions(frame);
    });
    already_uploaded_thread_images_assets.push(frame.attr('src'));
  } else if(type == 'video') {
    let video_url = container.find('.uploaded-media-url').val();
    GetFileObjectFromURL(video_url, function (fileObject) {
        get_thumbnail(fileObject, 1.5, frame.parent()).then(value => {
            frame.attr("src", value);
        });
    });
    frame.parent().imagesLoaded(function() {
        handle_image_dimensions(frame);
    });
    already_uploaded_thread_videos_assets.push(video_url);
  }
});

$('.edit-thread').on('click', function() {
    let spinner = $('#edit-thread-button-spinner');
    let button = $(this);
    let button_text_ing = button.parent().find('.text-button-ing').val();
    let button_text_no_ing = button.parent().find('.text-button-no-ing').val();
    let thread_id = $(this).parent().find('.thread_id').val();
    const $content_edit = $('.content-container #content').nextAll('.CodeMirror')[0].CodeMirror;
    
    let form_data = new FormData();
    form_data.append('_token' ,csrf);
    form_data.append('subject' ,$('#subject').val());
    form_data.append('category_id' ,$('#category').val());
    form_data.append('content' , $content_edit.getValue());
    form_data.append('_method', 'patch');

    if(edit_deleted_medias.length) {
        form_data.append('removed_medias', JSON.stringify(edit_deleted_medias));
    }

    if(uploaded_thread_images_assets.length) {
        // Append image files
        for(let i = 0;i<uploaded_thread_images_assets.length;i++) {
            // First filename
            let filename = uploaded_thread_images_assets[i][1].name.toLowerCase();
            // Get file extension with the preceding dot (ex: file.jpg => .jpg)
            let ext = filename.substr(filename.lastIndexOf('.'));
            /**
             * Here to preserve the order is little more different than storing media the first time
             * First we need to take the last already uploaded media's name (If exists) from it's source
             * and add 1 to that counter
             */
            filename = last_media_count + ext;
            last_media_count++;
            form_data.append('images[]', uploaded_thread_images_assets[i][1], filename);
        }
    }
    // Checking videos existence in the thread
    if(uploaded_thread_videos_assets.length) {
        // Append videos files
        for(let i = 0;i<uploaded_thread_videos_assets.length;i++) {
            // First filename
            let filename = uploaded_thread_videos_assets[i][1].name.toLowerCase();
            // Get file extension with the preceding dot (ex: file.jpg => .jpg)
            let ext = filename.substr(filename.lastIndexOf('.'));
            // Then we store the file with the combination of counter and extension to preserve the order when saving files
            filename = last_media_count + ext;
            last_media_count++;
            form_data.append('videos[]', uploaded_thread_videos_assets[i][1], filename);
        }
    }

    if($('#thread-post-switch').prop("checked") == true) {
        form_data.append('replies_off', 1);
    } else {
        form_data.append('replies_off', 0);
    }

    let error_container = $('.thread-edit-error-container');
    if(form_data.get('subject') == '') {
        error_container.removeClass('none');
        error_container.find('.thread-edit-error').text($('.subject-required-error').val());
        $('#subject').parent().find('.error').removeClass('none');
        move_element_by_id('page-top');
        return;
    } else {
        error_container.addClass('none');
        $('#subject').parent().find('.error').addClass('none');
    }

    if(form_data.get('category_id') == '' || form_data.get('category_id') == 0) {
        error_container.removeClass('none');
        error_container.find('.thread-edit-error').text($('.category-required-error').val());
        $('#category').parent().find('.error').removeClass('none');
        move_element_by_id('page-top');
        return;
    } else {
        error_container.addClass('none');
        $('#category').parent().find('.error').addClass('none');
    }

    if(form_data.get('content') == '') {
        error_container.removeClass('none');
        error_container.find('.thread-edit-error').text($('.content-required-error').val());
        $('#content').parent().find('.error').removeClass('none');
        move_element_by_id('page-top');
        return;
    } else {
        spinner.removeClass('opacity0');
        start_spinner(spinner, 'thread-edit-spinner');

        error_container.addClass('none');
        $('#content').parent().find('.error').addClass('none');
        
        button.val(button_text_ing);
        button.attr("disabled","disabled");
        button.attr('style', 'background-color: #acacac; cursor: default');

        $.ajax({
            type: 'post',
            data: form_data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            url: '/thread/'+thread_id,
            success: function(response) {
                document.location.href = response;
            },
            error: function(response) {
                spinner.addClass('opacity0');
                stop_spinner(spinner, 'thread-edit-spinner');

                button.val(button_text_no_ing);
                button.attr("disabled",false);
                button.attr('style', '');

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

                error_container.removeClass('none');
                error_container.find('.thread-edit-error').html(error);
                move_element_by_id('page-top');
            },
            complete: function() {
                
            }
        })
    }
    
    return false;
});