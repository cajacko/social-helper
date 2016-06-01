var $ = require('jquery');
var tagList = $('#TrackingTags-list');
var tagInput = $('#TrackingTags-input');

var trackingTagTemplateSelector = 'TrackingTags-tag--template';
var tagTemplate = $('#' + trackingTagTemplateSelector).clone();
$('#' + trackingTagTemplateSelector).remove();

function wasTrackingTagAdded(data) {
  if (data.error) {
    return false;
  }

  if (!data.success) {
    return false;
  }

  if (!data.tagId) {
    return false;
  }

  if (!$.isNumeric(data.tagId)) {
    return false;
  }

  return true;
}

function trackingTagWasNotAdded(message, tagObject) {
  if (message) {
    console.log(message);
  }

  if (tagObject) {
    $(tagObject).remove();
  }
}

function addTempTag(tag) {
  var tagObject = $(tagTemplate).clone();
  $(tagObject).removeClass('hidden').attr('id', '');
  $(tagObject).find('.TrackingTags-tagText').text(tag);
  $(tagObject).find('.TrackingTags-delete').hide();
  $(tagObject).appendTo(tagList);

  return tagObject;
}

function confirmTagAdded(tagObject, tagId, tag) {
  var id = 'TrackingTags-tag--' + tag;
  $(tagObject).find('.TrackingTags-delete').show().attr('data-id', tagId);
  $(tagObject).attr('id', id);
}

function addTrackingTag(tag, tagObject) {
  $.ajax({
    url: '/action/add-tracking-tag',
    type: 'POST',
    dataType: 'json',
    data: {tag: tag},
  })
  .done(function(data) {
    if (wasTrackingTagAdded(data)) {
      confirmTagAdded(tagObject, data.tagId, tag);
    } else {
      console.log(data);
      if (data.error_message) {
        trackingTagWasNotAdded(data.error_message, tagObject);
      } else {
        trackingTagWasNotAdded('The server could not save the tag', tagObject);
      }
    }
  })
  .fail(function() {
    trackingTagWasNotAdded('Could not send the tag to the server', tagObject);
  });
}

function doesTagExist(tag) {
  var doesTagExist = false;

  $('.TrackingTags-tagText').each(function() {
    if ($(this).text() == tag) {
      doesTagExist = true;
    }
  });

  return doesTagExist;
}

function formatTag(tag) {
  tag = tag.trim();

  if (tag.charAt(0) == '#') {
    tag = tag.substring(1);
  }

  tag = tag.trim();

  return tag;
}

function isTagValid(tag) {
  // TODO
  return true;
}

$('#TrackingTags-form').submit(function(event) {
  event.preventDefault();
  var tag = $(tagInput).val();
  tag = formatTag(tag);
  $(tagInput).val('');

  if (doesTagExist(tag)) {
    trackingTagWasNotAdded('Tag already exists');
  } else if (tag.length) {
    if (isTagValid(tag)) {
      var tagObject = addTempTag(tag);
      addTrackingTag(tag, tagObject);
    } else {
      trackingTagWasNotAdded('Tag is not in a valid format');
    }
  } else {
    trackingTagWasNotAdded('No text was entered');
  }
});
