<div class="wrap">
    <h2>
        <?php esc_html_e('My AJAX Plugin', 'my-ajax-plugin'); ?>
    </h2>
    <form id="my-ajax-form">
        <label for="name">
            <?php esc_html_e('Enter your name:', 'my-ajax-plugin'); ?>
        </label>
        <input type="text" name="name" id="name" required>
        <input type="hidden" name="nonce" id="my_nonce" value="<?php echo wp_create_nonce(WAP_NONCE_NAME); ?>">
        <button id="submit-name">
            <?php esc_html_e('Submit', 'my-ajax-plugin'); ?>
        </button>
    </form>
    <div id="message"></div>
</div>