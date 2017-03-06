<?php

class Ebuilder
{

    public static $BASE_URL = 1;
    public static $BASE_DIR = 2;
    public static $UPLOADS_URL = 3;
    public static $UPLOADS_DIR = 4;
    public static $STATIC_URL = 5;
    public static $STATIC_DIR = 6;
    public static $THUMBNAILS_URL = 7;
    public static $THUMBNAILS_DIR = 8;
    public static $THUMBNAIL_WIDTH = 9;
    public static $THUMBNAIL_HEIGHT = 10;

    private $ci;
    private $config;

    public function __construct()
    {
        $this->ci =& get_instance();

        $this->config = [
            /* base url for image folders */
            self::$BASE_URL => base_url() . 'public/emailbuilder/',

            /* local file system base path to where image directories are located */
            self::$BASE_DIR => FCPATH . 'public/emailbuilder/',

            /* url to the uploads folder (relative to BASE_URL) */
            self::$UPLOADS_URL => 'upload/',

            /* local file system path to the uploads folder (relative to BASE_DIR) */
            self::$UPLOADS_DIR => 'upload/',

            /* url to the static images folder (relative to BASE_URL) */
            self::$STATIC_URL => 'upload/static/',

            /* local file system path to the static images folder (relative to BASE_DIR) */
            self::$STATIC_DIR => 'upload/static/',

            /* url to the thumbnail images folder (relative to BASE_URL */
            self::$THUMBNAILS_URL => 'upload/thumbnails/',

            /* local file system path to the thumbnail images folder (relative to BASE_DIR) */
            self::$THUMBNAILS_DIR => 'upload/thumbnails/',

            /* width and height of generated thumbnails */
            self::$THUMBNAIL_WIDTH => 90,
            self::$THUMBNAIL_HEIGHT => 90
        ];
    }

    private function resizeImage($file_name, $method, $width, $height)
    {
        $image = new Imagick($this->config[self::$BASE_DIR] . $this->config[self::$UPLOADS_DIR] . $file_name);

        if ($method === 'resize') {
            $image->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1.0);
        } else {
            $image_geometry = $image->getImageGeometry();

            $width_ratio = $image_geometry['width'] / $width;
            $height_ratio = $image_geometry['height'] / $height;

            $resize_width = $width;
            $resize_height = $height;

            if ($width_ratio > $height_ratio) {
                $resize_width = 0;
            } else {
                $resize_height = 0;
            }

            $image->resizeImage($resize_width, $resize_height, Imagick::FILTER_LANCZOS, 1.0);

            $image_geometry = $image->getImageGeometry();

            $x = ($image_geometry['width'] - $width) / 2;
            $y = ($image_geometry['height'] - $height) / 2;

            $image->cropImage($width, $height, $x, $y);
        }

        return $image;
    }

    public function image()
    {
        if ($this->ci->input->server('REQUEST_METHOD') === 'GET') {
            $method = $this->ci->input->get('method');

            $params = explode(',', $this->ci->input->get('params'));

            $width = (int) $params[0];
            $height = (int) $params[1];

            if ($method === 'placeholder') {
                $image = new Imagick();

                $image->newImage($width, $height, '#707070');
                $image->setImageFormat('png');

                $x = 0;
                $y = 0;
                $size = 40;

                $draw = new ImagickDraw();

                while ($y < $height) {
                    $draw->setFillColor('#808080');

                    $points = [
                        ['x' => $x, 'y' => $y],
                        ['x' => $x + $size, 'y' => $y],
                        ['x' => $x + $size * 2, 'y' => $y + $size],
                        ['x' => $x + $size * 2, 'y' => $y + $size * 2]
                    ];

                    $draw->polygon($points);

                    $points = [
                        ['x' => $x, 'y' => $y + $size],
                        ['x' => $x + $size, 'y' => $y + $size * 2],
                        ['x' => $x, 'y' => $y + $size * 2]
                    ];

                    $draw->polygon($points);

                    $x += $size * 2;

                    if ($x > $width) {
                        $x = 0;
                        $y += $size * 2;
                    }
                }

                $draw->setFillColor('#B0B0B0');
                $draw->setFontSize($width / 5);
                $draw->setFontWeight(800);
                $draw->setGravity(Imagick::GRAVITY_CENTER);
                $draw->annotation(0, 0, $width . ' x ' . $height);

                $image->drawImage($draw);

                header('Content-type: image/png');

                echo $image;
            } else {
                $file_name = $this->ci->input->get('src');

                $path_parts = pathinfo($file_name);

                switch ($path_parts['extension']) {
                    case 'png':
                        $mime_type = 'image/png';
                        break;
                    case 'gif':
                        $mime_type = 'image/gif';
                        break;
                    default:
                        $mime_type = 'image/jpeg';
                        break;
                }

                $file_name = $path_parts['basename'];

                $image = $this->resizeImage($file_name, $method, $width, $height);

                header('Content-type: ' . $mime_type);

                echo $image;
            }
        }
    }

    public function email()
    {
        $this->ci->load->library('premailer');

        $premailer = $this->ci->premailer->html($this->ci->input->post('html'), true, 'hpricot', $this->config[self::$BASE_URL]);

        $html = $premailer[ "html" ];

        $matches = [];

        $num_full_pattern_matches = preg_match_all('#<img.*?src="([^"]*?\/[^/]*\.[^"]+)#i', $html, $matches);

        for ($i = 0; $i < $num_full_pattern_matches; $i++) {
            if (stripos($matches[1][$i], '/img?src=') !== false) {
                $src_matches = [];

                if (preg_match('#/img\?src=(.*)&amp;method=(.*)&amp;params=(.*)#i', $matches[1][$i], $src_matches) !== false) {
                    $file_name = urldecode($src_matches[1]);
                    $file_name = substr($file_name, strlen($this->config[self::$BASE_URL] . $this->config[self::$UPLOADS_URL]));

                    $method = urldecode($src_matches[2]);

                    $params = urldecode($src_matches[3]);
                    $params = explode(',', $params);
                    $width = (int) $params[0];
                    $height = (int) $params[1];

                    $static_file_name = $method . '_' . $width . 'x' . $height . '_' . $file_name;

                    $html = str_ireplace($matches[1][$i], $this->config[self::$BASE_URL] . $this->config[self::$STATIC_URL] . urlencode($static_file_name), $html);

                    $image = $this->resizeImage($file_name, $method, $width, $height);

                    $image->writeImage($this->config[self::$BASE_DIR] . $this->config[self::$STATIC_DIR] . $static_file_name);
                }
            }
        }

        switch ($this->ci->input->post('action')) {
            case 'download': {
                header('Content-Type: application/force-download');
                header('Content-Disposition: attachment; filename="' . $this->ci->input->post('filename') . '"');
                header('Content-Length: ' . strlen($html));

                echo $html;

                break;
            }

            case 'email': {
                $to = $this->ci->input->post('rcpt');
                $subject = $this->ci->input->post('subject');

                $headers = [
                    'MIME-Version: 1.0',
                    'Content-type: text/html; charset=iso-8859-1',
                    "To: $to",
                    "Subject: $subject"
                ];

                $headers = implode("\r\n", $headers);

                if (mail($to, $subject, $html, $headers) === false) {
                    return false;
                }

                break;
            }
        }

        return true;
    }

    public function upload()
    {
        $files = [];

        if ($this->ci->input->server('REQUEST_METHOD') === 'GET') {
            $dir = scandir($this->config[self::$BASE_DIR] . $this->config[self::$UPLOADS_DIR]);

            foreach ($dir as $file_name) {
                $file_path = $this->config[self::$BASE_DIR] . $this->config[self::$UPLOADS_DIR] . $file_name;

                if (is_file($file_path)) {
                    $size = filesize($file_path);

                    $file = [
                        'name' => $file_name,
                        'url' => $this->config[self::$BASE_URL] . $this->config[self::$UPLOADS_URL] . $file_name,
                        'size' => $size
                    ];

                    if (file_exists($this->config[self::$BASE_DIR] . $this->config[self::$THUMBNAILS_DIR] . $file_name)) {
                        $file['thumbnailUrl'] = $this->config[self::$BASE_URL] . $this->config[self::$THUMBNAILS_URL] . $file_name;
                    }

                    $files[] = $file;
                }
            }
        } else if (!empty($_FILES)) {
            foreach ($_FILES['files']['error'] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['files']['tmp_name'][$key];

                    $file_name = $_FILES['files']['name'][$key];

                    $file_path = $this->config[self::$BASE_DIR] . $this->config[self::$UPLOADS_DIR] . $file_name;

                    if (move_uploaded_file($tmp_name, $file_path) === true) {
                        $size = filesize($file_path);

                        $image = new Imagick($file_path);

                        $image->resizeImage($this->config[self::$THUMBNAIL_WIDTH], $this->config[self::$THUMBNAIL_HEIGHT], Imagick::FILTER_LANCZOS, 1.0, true);
                        $image->writeImage($this->config[self::$BASE_DIR] . $this->config[self::$THUMBNAILS_DIR] . $file_name);
                        $image->destroy();

                        $file = [
                            'name' => $file_name,
                            'url' => $this->config[self::$BASE_URL] . $this->config[self::$UPLOADS_URL] . $file_name,
                            'size' => $size,
                            'thumbnailUrl' => $this->config[self::$BASE_URL] . $this->config[self::$THUMBNAILS_URL] . $file_name
                        ];

                        $files[] = $file;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        header('Content-Type: application/json; charset=utf-8');
        header('Connection: close');

        echo json_encode(['files' => $files]);

        return true;
    }

}
