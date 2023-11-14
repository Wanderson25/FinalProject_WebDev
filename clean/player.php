<div id="player">
    <audio id="audio" src=""></audio> 
    <div class="playing disable-select">
        <button id="loop" onclick="toggleLoop()">Loop</button>
        <button id="play" onclick="playPause()" >▷</button>
        <div class="seek">
            <div class="track"></div>
            <div class="progress"></div>
            <div class="thumb"></div>
        </div>
        <div id="duration">
            <span id="currStart">0:00</span>
            <span>/</span>
            <span id="currEnd">0:00</span>
        </div>
    </div>
            
    <div class="info">
        <img id="cover" class="cover_art" src="bocchibase\covers\夜に駆ける_YOASOBI.jpg">
        <div class="song_info">
            <p id="title">Racing into the Night</p>
            <p id="date">Released: </p>
        </div>
    </div>

    <div id="lyrics" class="lyrics">Loading lyrics</div>

    <div class="visualizer disable-select">
        <canvas id="canvas"></canvas>
        <div class="volume">
            <div class="track"></div>
            <div class="progress"></div>
            <div class="thumb"></div>
        </div>
    </div>

    <div class="extra_info">
        <div class="view_count disable-select" id="view_count">Listened: </div>
        
        <?php
        $if_clause = "<div class=\"special-activities\">
                        <div class=\"add_pl disable-select\" id=\"add_pl\">+Playlist</div>
                        <div class=\"favorite disable-select\" id=\"favorite\" >♡</div>
                    </div>";
        if_command($if_clause);
        ?>
        

    </div>
    

</div>
