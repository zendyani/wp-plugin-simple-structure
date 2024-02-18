<?php

namespace Wap\Page;

class Controller
{
    protected $viewPath;

    public function __construct(string $viewPath = WAP_VIEW_PATH)
    {
        $this->viewPath = rtrim($viewPath, '/'); // Ensure no trailing slash
    }
    protected function render(string $view = '')
    {
        $view = $this->sanitizeViewName($view);

        $viewFile = $this->viewPath . '/' . $view . '.php';

        if (!file_exists($viewFile)) {
            // Handle the error appropriately
            return 'View not found';
        }

        ob_start();
        include_once($viewFile);

        // Capture the buffered content into a variable
        $content = ob_get_clean();
        
        // Now, you have the option to manipulate $content if needed
        
        // Finally, send the output to the browser
        echo $content;
    }

    private function sanitizeViewName(string $view): string
    {
        // Prevent directory traversal
        $view = str_replace(['..', '/', '\\'], '', $view);

        // Additional sanitization can be done here depending on requirements
        return sanitize_file_name($view); // Assuming WordPress environment for sanitization
    }
}
