var videoController = {
    data: {
        config: null
    },
    uiElements: {
        videoCardTemplate: null,
        videoList: null,
        loadingIndicator: null
    },
    init: function (config) {
        this.uiElements.videoCardTemplate = $('#video-template');
        this.uiElements.videoList = $('#video-list');
        this.uiElements.loadingIndicator = $('#loading-indicator');

        this.data.config = config;

        this.displayExistingS3Videos();
    },
    addVideoToScreen: function (videoId, videoObj) {
        // clone the template video element
        var newVideoElement = this.uiElements.videoCardTemplate.clone().attr('id', videoId);

        newVideoElement.attr('preload', 'metadata')
        newVideoElement.click(function() {
            // the user has clicked on the video... let's play it, or pause it depending on state
            var video = newVideoElement.find('video').get(0);

            if (newVideoElement.is('.video-playing')) {
                video.pause();
                $(video).removeAttr('controls'); // remove controls
            }
            else {
                $(video).attr('controls', ''); // show controls
                video.play();
            }

            newVideoElement.toggleClass('video-playing');
        });

        this.updateVideoOnScreen(newVideoElement, videoObj);

        this.uiElements.videoList.prepend(newVideoElement);
    },
    updateVideoOnScreen: function(videoElement, videoObj) {

        if (videoObj.transcoding) {
            // the video is currently transcoding... hide the video and show the spinner
            videoElement.find('video').hide();
            videoElement.find('.transcoding-indicator').show();
        } else {
            // the video is not transcoding... show the video and hide the spinner
            videoElement.find('video').show();
            videoElement.find('.transcoding-indicator').hide();
        }

        // set the video URL
        videoElement.find('video').attr('src', videoObj.source);
    },
    getElementForVideo: function(videoId) {
        return $('#' + videoId);
    },
    displayExistingS3Videos: function() {
        var that = this;
        AWS.config.region = that.data.config.s3.region;
        var params = {
            Bucket: that.data.config.s3.bucket,
            EncodingType: "url",
            FetchOwner: false
        };
        var s3 = new AWS.S3();
        s3.makeUnauthenticatedRequest('listObjectsV2', params, function(err, data) {
            for (i = 0; i<data.Contents.length; i++) {
                if (data.Contents[i].Key.endsWith('web-720p.mp4')) {
                    that.addVideoToScreen(data.Contents[i].ETag, {
                        source: 'https://s3-' + that.data.config.s3.region + '.amazonaws.com/' + that.data.config.s3.bucket +'/' + data.Contents[i].Key + '#t=1',
                        transcoding: false
                    });
                }
            }
            that.uiElements.loadingIndicator.hide();
        });
    }
};
