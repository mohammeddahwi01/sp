<?php
namespace Eleanorsoft\MageplazaBlog\Helper;

use Mageplaza\Blog\Helper\Image as BaseImage;
use Psr\Log\LoggerInterface;

/**
 * Class Image
 *
 * @package Eleanorsoft_MageplazaBlog
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Image extends BaseImage
{

    /**
     * Resize Image Function
     * @param $image
     * @param null $width
     * @param null $height
     * @return string
     */
    public function resizeImage($image, $width = null, $height = null)
    {
        /** @var \Magento\Framework\Filesystem\Directory\WriteInterface $mediaDirectory */
        $mediaDirectory = $this->getMediaDirectory();
        if ($width) {
            $height = $height ?: $width;

            $imageFile = $this->getMediaPath(
                $this->getExcludeMediaPath($image, Image::TEMPLATE_MEDIA_TYPE_POST),
                Image::TEMPLATE_MEDIA_TYPE_POST . '/resize/' . $width . 'x' . $height
            );
            if (!$mediaDirectory->isFile($imageFile)) {
                try {

                    /** @var  $imageResize \Magento\Framework\Image\Adapter\Gd2 */
                    $imageResize = $this->imageFactory->create();

                    $imageResize->open($mediaDirectory->getAbsolutePath($image));

                    $_imageSrcWidth = $imageResize->getOriginalWidth();
                    $_imageSrcHeight = $imageResize->getOriginalHeight();

                    $corners = $this->getCornersSquare($_imageSrcWidth, $_imageSrcHeight);
                    $imageResize->constrainOnly(true);
                    $imageResize->keepTransparency(true);
                    $imageResize->keepFrame(true);
                    $imageResize->keepAspectRatio(true);
                    if (!is_null($corners)) {
                        $imageResize->crop(
                            $corners['top'],
                            $corners['left'],
                            $corners['right'],
                            $corners['bottom']
                        );
                    }
                    if ($_imageSrcWidth >= $width) {
                        $imageResize->resize($width, $height);
                    }
                    $imageResize->save($mediaDirectory->getAbsolutePath($imageFile));

                    $image = $imageFile;
                } catch (\Exception $e) {
                    var_dump($e->getMessage());die;
                    $this->objectManager->get(LoggerInterface::class)->critical($e->getMessage());
                }
            } else {
                $image = $imageFile;
            }
        }

        return $this->getMediaUrl($image);
    }

    /**
     * Returns the corners of a square
     *
     * @param $width
     * @param $height
     * @return array|null
     */
    private function getCornersSquare($width, $height)
    {
        $center_w = $width/2;
        $centre_h = $height/2;

        $corners = [];

        if ($width > $height) {
            $corners['top'] = 0;
            $corners['left'] = $center_w - $centre_h;
            $corners['right'] = $width - $center_w - $centre_h;
            $corners['bottom'] = 0;
        }
        elseif ($width < $height) {
            $corners['top'] = $centre_h - $center_w;
            $corners['left'] = 0;
            $corners['right'] = 0;
            $corners['bottom'] = $height - $centre_h - $center_w;

        }else{
            return null;
        }
        return $corners;
    }

}
