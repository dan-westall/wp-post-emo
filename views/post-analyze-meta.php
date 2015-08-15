<div class="analyze-post-container">

    <input id="generate-match-nonce" type="hidden" value="<?php echo esc_attr(wp_create_nonce('process_text')); ?>">

    <button class="button">Analyze Post</button>

    <br/><br/>

    <div id="generate-analyze-response"></div>

</div>