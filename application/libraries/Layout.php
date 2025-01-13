<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    public $data = array();
    public $view = null;
    public $viewFolder = null;
    public $layoutsFodler = 'layouts';
    public $layout = 'main';

    /**
     * [$view_js description]
     * @var [mixed]
     */
    public $view_js;
    public $view_css = '';
    public $title = '';

    /**
     * For set $this of codeigniter
     * @var [type]
     */
    private $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->title = APP_NAME;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function setLayoutFolder($layoutFolder)
    {
        $this->layoutsFodler = $layoutFolder;
    }

    public function render($view, $data = [], $return = false)
    {
        $controller = str_replace('Controller', '', $this->ci->router->fetch_class());
        $slug_controller = camelToSlug($controller, '-');

        $method = $this->ci->router->fetch_method();
        if (file_exists(VIEWPATH.$view.'.php')) {
            $viewFolder = $view;
        } else {
            $viewFolder = !($this->viewFolder) ? $slug_controller .'/'. $view : $this->viewFolder;
        }
        // $view = !($this->view) ? $method : $this->view;

        $loadedData = array();
        $loadedData['view'] = $viewFolder;
        $loadedData['data'] = $data;
        $loadedData['title'] = $this->title;
        $loadedData['breadcrumbs'] = $this->breadcrumbs();

        if (!empty($this->view_js)) {
            if (is_string($this->view_js)) {
                $view_js = $slug_controller .'/'. $this->view_js;

            } elseif (is_array($this->view_js)) {
                foreach ($this->view_js as $key => $js) {
                    $view_js[] = $slug_controller .'/'. $js;
                }

            }

            $loadedData = array_merge($loadedData, ['view_js' => $view_js]);
        }

        if (!empty($this->view_css)) {
            if (is_string($this->view_css)) {
                $view_css = $slug_controller .'/'. $this->view_css;

            } elseif (is_array($this->view_css)) {
                foreach ($this->view_css as $key => $css) {
                    $view_css[] = $slug_controller .'/'. $css;
                }

            }

            $loadedData = array_merge($loadedData, ['view_css' => $view_css]);
        }

        $layoutPath = '/'.$this->layoutsFodler.'/'.$this->layout;
        $this->ci->load->view($layoutPath, $loadedData, $return);
    }

    public function renderPartial($view, $data = [], $return = false)
    {
        $controller = str_replace('Controller', '', $this->ci->router->fetch_class());
        $slug_controller = camelToSlug($controller, '-');

        $method = $this->ci->router->fetch_method();
        $viewFolder = !($this->viewFolder) ? $slug_controller .'/'. $view : $this->viewFolder;

        $loadedData = array();
        $loadedData['data'] = $data;

        return $this->ci->load->view($viewFolder, $data, $return);
    }

    public function breadcrumbs() {
        $this->ci->load->helper('url');

        $breadcrumbs = array();

        if ($this->ci->uri->segment(1) !== '') {
            $total = count($this->ci->uri->segments);
            $segments = $this->ci->uri->segments;

            foreach ($segments as $key =>  $segment) {
                $joined_segments = implode('/', array_slice($segments, 0, $key));

                $breadcrumb = '<a href="' . site_url($joined_segments) . '">' . ucfirst($segment) . '</a>';

                if ($key == $total) {
                    $breadcrumb = ucfirst($segment);
                }

                $breadcrumbs[] = $breadcrumb;
            }
        }

        if (count($breadcrumbs) > 3) {
            $breadcrumbs[0] = '<a href="' . site_url('/site') . '">Home</a>';

        } else {
            array_unshift($breadcrumbs, '<a href="' . site_url('/site') . '">Home</a>');
        }

        return $breadcrumbs;
    }
}
