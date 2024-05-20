<?php

namespace app\components;

use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;
use function PHPUnit\Framework\returnArgument;

/**
 *
 * @param string $filename
 * @param int $width
 * @param int $height
 * @param string $type [default, w, h]
 *        default = масштабирование с фоновым пространством,
 *        w = заполнение по ширине,
 *        h = заполнение по высоте
 */

class Image
{
    const IMAGE_DEFAULT = 'nofoto.jpg';

    /**
     * @throws Exception
     */
    public static function resize($filename, $width, $height, $type = ""): string
    {
        $dirImage = Yii::getAlias('@app/web/images/');

        if (!is_dir($dirImage)) {
            //FileHelper::createDirectory($dirImage);
           mkdir('/app/web/images', 0777);
        }

        if (!file_exists($dirImage . $filename) || !is_file($dirImage . $filename)) {
            $filename = self::IMAGE_DEFAULT;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if ($extension == 'svg') return $dirImage . $filename;

        $old_image = $filename;
        $new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

        if (!file_exists($dirImage . $new_image) || (filemtime($dirImage . $old_image) > filemtime($dirImage . $new_image))) {
            $path = '';
            $directories = explode('/', dirname(str_replace('../', '', $new_image)));
            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;
                if (!file_exists($dirImage . $path)) {
                    @mkdir($dirImage . $path, 0777);
                }
            }


            list($width_orig, $height_orig) = getimagesize($dirImage . $old_image);
            if ($width_orig != $width || $height_orig != $height) {
               // try {
                    $image = new Resize($dirImage . $old_image);
                    $image->resize($width, $height, $type);
                    $image->save($dirImage . $new_image);
//                } catch (\Exception $e) {
//                    throw new Exception('Ошибка обработки изображения');
//                }

            } else {
                copy($dirImage . $old_image, $dirImage . $new_image);
            }
        }

        return '/images/' . $new_image;

    }
}