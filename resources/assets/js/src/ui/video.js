let videos

export default function init () {
    var tag = document.createElement('script')
    tag.src = 'https://www.youtube.com/iframe_api'
    var firstScriptTag = document.getElementsByTagName('script')[0]
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag)

    videos = document.querySelectorAll('.js-video')
    videos = Array.prototype.slice.call(videos)
    videos = videos.map(el => {
        const videoContainer = el.querySelector('[data-youtube-id]')
        const videoID = videoContainer.dataset.youtubeId
        const playBtn = el.querySelector('.js-video-btn')

        return {
            el: videoContainer,
            videoID,
            player: null,
            play: () => {},
            playBtn
        }
    })
}

function onYouTubeIframeAPIReady () {
    videos = videos.map(video => {
        video.player = new window.YT.Player(video.el, {
            height: 540,
            width: 360,
            videoId: video.videoID,
            playerVars: {
                modestbranding: 1,
                rel: 0,
                showinfo: 0,
                widget_referrer: window.location.href
            },
            events: {
                onReady: function (evt) {
                    video.play = evt.target.playVideo.bind(evt.target)
                }
            }
        })

        if (video.playBtn) {
            video.playBtn.addEventListener('click', () => {
                if (!video.play) {
                    return
                }

                video.playBtn.classList.add('is-active')
                video.play()
            })
        }

        return video
    })
}
window.onYouTubeIframeAPIReady = onYouTubeIframeAPIReady
