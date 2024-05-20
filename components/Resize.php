<?php

namespace app\components;

class Resize {
    private $info;
    private $file;
    private $image;
    private $width;
    private $height;
    private $bits;
    private $mime;

    public function __construct($file)
    {
        if (file_exists($file)) {
            $this->file = $file;
            $info = getimagesize($file);
            $this->width  = $info[0];
            $this->height = $info[1];
            $this->bits = isset($info['bits']) ? $info['bits'] : '';
            $this->mime = isset($info['mime']) ? $info['mime'] : '';
            $this->info = array(
                'width'  => $info[0],
                'height' => $info[1],
                'bits'   => $info['bits'],
                'mime'   => $info['mime']
            );
            if ($this->mime == 'image/gif') {
                $this->image = imagecreatefromgif($file);
            } elseif ($this->mime == 'image/png') {
                $this->image = imagecreatefrompng($file);
            } elseif ($this->mime == 'image/jpeg') {
                $this->image = imagecreatefromjpeg($file);
            }
        } else {
            exit('Error: Could not load image ' . $file . '!');
        }
    }

    public function getFile() {
        return $this->file;
    }

    public function getImage() {
        return $this->image;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getBits() {
        return $this->bits;
    }

    public function getMime() {
        return $this->mime;
    }

    private function create($image) {
        $mime = $this->info['mime'];
        if ($mime == 'image/gif') {
            return imagecreatefromgif($image);
        } elseif ($mime == 'image/png') {
            return imagecreatefrompng($image);
        } elseif ($mime == 'image/jpeg') {
            return imagecreatefromjpeg($image);
        }
    }

    public function save($file, $quality = 90) {
        $info = pathinfo($file);

        $extension = strtolower($info['extension']);

        if (is_resource($this->image)) {
            if ($extension == 'jpeg' || $extension == 'jpg') {
                imagejpeg($this->image, $file, $quality);
            } elseif ($extension == 'png') {
                imagepng($this->image, $file);
            } elseif ($extension == 'gif') {
                imagegif($this->image, $file);
            }

            imagedestroy($this->image);
        }
    }

    public function resize($width = 0, $height = 0, $default = '') {
        if (!$this->width || !$this->height) {
            return;
        }

        $scale_w = $width / $this->width;
        $scale_h = $height / $this->height;

        if ($default == 'w') {
            $scale = $scale_w;
        } elseif ($default == 'h') {
            $scale = $scale_h;
        } elseif ($default == 'a') {
            if ($this->width > $this->height) $scale = $scale_h;
            else $scale = $scale_w;
        } else {
            $scale = min($scale_w, $scale_h);
        }

        if ($scale == 1 && $scale_h == $scale_w && $this->mime != 'image/png') {
            return;
        }

        $new_width = (int)($this->width * $scale);
        $new_height = (int)($this->height * $scale);
        $xpos = (int)(($width - $new_width) / 2);
        $ypos = (int)(($height - $new_height) / 2);

        $image_old = $this->image;
        $this->image = imagecreatetruecolor($width, $height);

        if ($this->mime == 'image/png') {
            imagealphablending($this->image, false);
            imagesavealpha($this->image, true);
            $background = imagecolorallocatealpha($this->image, 255, 255, 255, 127);
            imagecolortransparent($this->image, $background);
        } else {
            $background = imagecolorallocate($this->image, 255, 255, 255);
        }

        imagefilledrectangle($this->image, 0, 0, $width, $height, $background);

        imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->width, $this->height);
        imagedestroy($image_old);

        $this->width = $width;
        $this->height = $height;
    }
}