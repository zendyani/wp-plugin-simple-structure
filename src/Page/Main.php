<?php

namespace Wap\Page;

class Main extends Controller
{
    public function handler(): void
    {
        $this->render('main');
    }

    /**
     * Enqueues scripts for the admin area.
     *
     * This method is designed to be hooked into WordPress's admin_enqueue_scripts action.
     * It checks the current page hook to enqueue scripts only on the plugin's admin page.
     *
     * @param string $hook The current page hook.
     */
    public function enqueueAssets(string $hook): void
    {
        if ($hook !== 'toplevel_page_my-ajax-plugin') {
            return;
        }

        wp_enqueue_script(
            'my-ajax-request', 
            WAP_URL . 'js/ajax-script.js', 
            ['jquery'], 
            false, // Consider specifying your plugin version instead of false.
            true // Load in the footer.
        );

        wp_localize_script(
            'my-ajax-request', 
            'MyAjax', 
            ['ajaxurl' => admin_url('admin-ajax.php')]
        );
    }
}
