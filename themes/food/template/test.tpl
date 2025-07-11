<?php echo $header; ?>

<head>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
</head>
<script>
    let currentVideoId = "1";
    let player, videoSource, noVideoMsg;

    document.addEventListener('DOMContentLoaded', function() {
        player = new Plyr('#player');
        videoSource = document.getElementById("videoSource");
        noVideoMsg = document.getElementById("noVideoMsg");

        if (player && videoSource && noVideoMsg) {
            loadVideo(currentVideoId);

            player.on('pause', savePlaybackState);
            player.on('ended', savePlaybackState);
        } else {
            console.error("Required elements not found");
        }
    });

    async function fetchData(action, data = {}) {
        try {
            const formData = new FormData();
            formData.append('action', action);
            for (const key in data) formData.append(key, data[key]);

            const response = await fetch('', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            return await response.json();
        } catch (e) {
            console.error('Fetch error:', e);
            return {
                success: false,
                error: 'Request failed'
            };
        }
    }

    async function loadVideo(videoId) {
        if (!player || !videoSource || !noVideoMsg) return;

        currentVideoId = videoId;
        const response = await fetchData('load', {
            video_id: videoId
        });

        if (response.success && response.video_url) {
            noVideoMsg.style.display = "none";
            videoSource.src = response.video_url;
            player.media.load();

            if (response.resumetime) {
                player.media.currentTime = parseFloat(response.resumetime);
            }

            player.media.style.display = "";
        } else {
            player.media.style.display = "none";
            noVideoMsg.style.display = "block";
        }
    }

    async function savePlaybackState() {
        if (!player || player.media.style.display === "none") return;

        try {
            await fetchData('save', {
                video_id: currentVideoId,
                resumetime: player.media.currentTime
            });
        } catch (e) {
            console.error('Failed to save playback state:', e);
        }
    }

    async function resumePlay() {
        if (!player) return;

        const data = await fetchData('load', {
            video_id: currentVideoId
        });
        if (data.success && data.resumetime !== undefined && data.resumetime !== null) {
            player.media.currentTime = parseFloat(data.resumetime);
            player.play().catch(e => console.error('Video play failed:', e));
        }
    }

    function selectVideo(videoId) {
        savePlaybackState().then(() => loadVideo(videoId));
    }
</script>
<div class="container m-5" style="margin-top: 15rem !important;">
    <center>
        <div class="mb-3">
            <button class="btn btn-primary" onclick="selectVideo('1')">Video 1</button>
            <button class="btn btn-primary" onclick="selectVideo('2')">Video 2</button>
        </div>
        <div style="text-align:center">
            <button class="btn btn-success" onclick="resumePlay()">Resume</button>
            <br><br>
            <div class="fw-medium text-danger bold" id="noVideoMsg" style="display:none;">No video Found/Selected.</div>
            <video id="player" playsinline controls data-poster="">
                <source src="" id="videoSource" type="video/mp4" />
                Your browser does not support the video tag.
            </video>
        </div>
    </center>
</div>

<?php echo $footer; ?>